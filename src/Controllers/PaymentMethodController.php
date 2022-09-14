<?php
namespace ModularLightspeed\ModularLightspeed\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use ModularLightspeed\ModularLightspeed\API\Response\PaymentMethodsResponse;
use ModularLightspeed\ModularLightspeed\Models\lightspeed;
use ModularLightspeed\ModularLightspeed\Requests\PaymentMethodRequest;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepay;

class PaymentMethodController extends Controller
{
    public function all(
        PaymentMethodRequest $request,
        MultiSafepay         $multiSafepay,
        lightspeed           $lightspeed
    ): JsonResponse
    {
        $currency = $request->shop['currency'];
        $paymentMethods = [];

        try {
            $gateways = $multiSafepay->getPaymentMethods($lightspeed->api_key, (int)$request->quote['price_incl'], $currency, $request->billing_address['country']);
            $token = $multiSafepay->getTransactionToken($lightspeed->api_key);

            $paymentMethods = (new PaymentMethodsResponse(new Collection($gateways), $token, $currency))->payment_methods;
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);
        }

        return response()->json(['payment_methods' => $paymentMethods], 201);
    }
}
