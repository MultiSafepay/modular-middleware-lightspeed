<?php

namespace ModularLightspeed\ModularLightspeed\API\Response;

use Illuminate\Support\Collection;

class PaymentMethodsResponse
{
    public Collection $payment_methods;

    public function __construct(
        protected Collection $gateways,
        protected string $transactionToken,
        protected string $currency,
    ){
        $this->payment_methods = $this->gateways->map(function ($gateway) {
            return new PaymentMethodResponse(
                $gateway->id,
                $gateway->name,
                $gateway->iconUrl,
                [
                    'token' => $this->transactionToken,
                    'currency' => $this->currency, // this field is missing in the frontend checkout, however needed for payment components
                    'hasComponent' => $gateway->hasComponent,
                ]);
        });
    }
}
