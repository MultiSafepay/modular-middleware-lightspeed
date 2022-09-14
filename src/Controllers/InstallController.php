<?php
namespace Modularlightspeed\Modularlightspeed\Controllers;

use Illuminate\Http\Request;
use Modularlightspeed\Modularlightspeed\Clients\lightspeedClient;
use Modularlightspeed\Modularlightspeed\Models\lightspeed;
use Modularlightspeed\Modularlightspeed\API\Request\ExternalServices\PostExternalService;
use Modularlightspeed\Modularlightspeed\API\Request\ShopScripts\PostShopScript;
use Modularlightspeed\Modularlightspeed\API\Request\Webhooks\PostWebhook;

class InstallController
{
    /**
     * @param lightspeed $lightspeed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(lightspeed $lightspeed)
    {
        return view('lightspeed.install', ['uuid' => $lightspeed->uuid]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(Request $request, lightspeedClient $client): \Illuminate\Http\RedirectResponse
    {
        $language = $request->get('language');
        $shopId = $request->get('shop_id');
        $clusterId = $request->get('cluster_id');
        $token = $request->get('token');

        $credentials = lightspeed::updateOrCreate(
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
                url('/lightspeed') . '/' . $credentials->uuid,
                'payment',
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'shipments',
                'created',
                route('lightspeed.webhook.shipments.created', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'shipments',
                'updated',
                route('lightspeed.webhook.shipments.updated', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'shipments',
                'deleted',
                route('lightspeed.webhook.shipments.deleted', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'invoices',
                'updated',
                route('lightspeed.webhook.invoice.created', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostWebhook(
                $credentials->token,
                'invoices',
                'created',
                route('lightspeed.webhook.invoice.updated', $credentials->uuid),
                $language
            ));

            $client->makeRequest(new PostShopScript(
                $credentials->token,
                secure_asset('js/lightspeed/checkout.js'),
                $language
            ));
        }

        return Redirect()->route('lightspeed.install.show', [$credentials->uuid]);
    }

    /**
     * @param InstallRequest $request
     * @param lightspeed $lightspeed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InstallRequest $request, lightspeed $lightspeed): \Illuminate\Http\RedirectResponse
    {
        $lightspeed->api_key = $request->api_key;
        $lightspeed->save();

        return Redirect()->back()->with('success', 'Installation Successfully completed');
    }
}
