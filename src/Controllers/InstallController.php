<?php
namespace ModularLightspeed\ModularLightspeed\Controllers;

use Illuminate\Http\Request;
use ModularLightspeed\ModularLightspeed\Clients\LightspeedClient;
use ModularLightspeed\ModularLightspeed\Models\Lightspeed;
use ModularLightspeed\ModularLightspeed\API\Request\ExternalServices\PostExternalService;
use ModularLightspeed\ModularLightspeed\API\Request\ShopScripts\PostShopScript;
use ModularLightspeed\ModularLightspeed\API\Request\Webhooks\PostWebhook;
use ModularLightspeed\ModularLightspeed\Requests\InstallRequest;

class InstallController
{
    /**
     * @param Lightspeed $Lightspeed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Lightspeed $Lightspeed)
    {
        return view('Lightspeed.install', ['uuid' => $Lightspeed->uuid]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(Request $request, LightspeedClient $client): \Illuminate\Http\RedirectResponse
    {
        $language = $request->get('language');
        $shopId = $request->get('shop_id');
        $clusterId = $request->get('cluster_id');
        $token = $request->get('token');

        $credentials = Lightspeed::updateOrCreate(
            ['shop_id' => $shopId],
            [
                'language' => $language,
                'shop_id' => $shopId,
                'cluster_id' => $clusterId,
                'token' => $token,
            ]
        );

        if ($credentials->wasRecentlyCreated) {
            $client->makeRequest(new PostExternalService(
                $credentials->token,
                url('/Lightspeed') . '/' . $credentials->uuid,
                'payment',
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'shipments',
                'created',
                route('Lightspeed.webhook.shipments.created', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'shipments',
                'updated',
                route('Lightspeed.webhook.shipments.updated', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'shipments',
                'deleted',
                route('Lightspeed.webhook.shipments.deleted', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'invoices',
                'updated',
                route('Lightspeed.webhook.invoice.created', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'invoices',
                'created',
                route('Lightspeed.webhook.invoice.updated', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostShopScript(
                $credentials->token,
                secure_asset('js/Lightspeed/checkout.js'),
                $language
            ));
        }

        return Redirect()->route('Lightspeed.install.show', [$credentials->uuid]);
    }

    /**
     * @param InstallRequest $request
     * @param Lightspeed $Lightspeed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InstallRequest $request, Lightspeed $Lightspeed): \Illuminate\Http\RedirectResponse
    {
        $Lightspeed->api_key = $request->api_key;
        $Lightspeed->save();

        return Redirect()->back()->with('success', 'Installation Successfully completed');
    }
}
