<?php

namespace ModularLightspeed\ModularLightspeed\API\RequestRequest;

use Illuminate\Http\Client\Response;
use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;
use ModularMultiSafepay\ModularMultiSafepay\Response\OrderResponse;
use function collect;

class GetOrderData extends lightspeedRequestData
{
    protected string $type = 'get';
    protected string $path = 'orders/';

    public function __construct(
        protected string $order,
        string           $token,
        string           $language = 'en'
    )
    {
        parent::__construct($token, $language);
        $this->path .= $this->order;
    }

    public function toResponse(array|Response $data): \Illuminate\Support\Collection
    {
        $order = $data['order'];
        $products = $order['products']['resource']['embedded'];
        return collect(new OrderResponse(
            $order['id'],
            $order['paymentTitle'],
            $order['paymentData']['method'],
            $order['firstname'],
            $order['lastname'],
            $order['gender'],
            $order['birthDate'],
            $order['addressBillingName'],
            $order['addressBillingStreet'],
            $order['addressBillingStreet2'],
            $order['addressBillingNumber'],
            $order['addressBillingZipcode'],
            $order['addressBillingCity'],
            $order['addressBillingCountry']['code'],
            $order['phone'],
            $order['email'],
            $products,
            $order['shipmentId'],
            $order['shipmentTitle'],
            $order['shipmentPriceExcl'],
            $order['shipmentTaxRate'],
            $order['paymentPriceExcl'],
            $order['paymentTaxRate'],
            $order['addressShippingName'],
            $order['addressShippingStreet'],
            $order['addressShippingStreet2'],
            $order['addressShippingNumber'],
            $order['addressShippingZipcode'],
            $order['addressShippingCity'],
            $order['addressShippingCountry']['code']
        ));
    }
}
