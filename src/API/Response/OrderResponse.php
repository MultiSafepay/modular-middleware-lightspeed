<?php

namespace ModularLightspeed\ModularLightspeed\API\Response;

class OrderResponse
{
    public function __construct(
        public string $id,
        public string $paymentTitle,
        public string $paymentMethod,
        public string $firstname,
        public string $lastname,
        public string $gender,
        public string $birthDate,

        public string $addressBillingName,
        public string $addressBillingStreet,
        public string $addressBillingStreet2,
        public string $addressBillingNumber,
        public string $addressBillingZipcode,
        public string $addressBillingCity,
        public string $addressBillingCountry,
        public string $phone,
        public string $email,
        public array  $products,

        public string $shipmentId,
        public string $shipmentTitle,
        public float  $shipmentPriceExcl,
        public string $shipmentTaxRate,

        public float  $paymentPriceExcl,
        public string $paymentTaxRate,

        public string $addressShippingName,
        public string $addressShippingStreet,
        public string $addressShippingStreet2,
        public string $addressShippingNumber,
        public string $addressShippingZipcode,
        public string $addressShippingCity,
        public string $addressShippingCountry
    )
    {
    }
}
