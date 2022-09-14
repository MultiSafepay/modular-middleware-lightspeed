<?php

namespace ModularLightspeed\ModularLightspeed\API\Response;

class PaymentMethodResponse
{
    public float $price_incl;
    public float $price_excl;
    public float $tax_rate;

    public function __construct(
        public string $id,
        public string $title,
        public string $icon,
        public array $data = []
    ) {
        $this->price_incl = 0;
        $this->price_excl = 0;
        $this->tax_rate = 0;
    }


}
