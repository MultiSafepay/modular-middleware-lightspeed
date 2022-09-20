<?php declare(strict_types=1);

namespace ModularLightspeed\ModularLightspeed\API\Request;

use JetBrains\PhpStorm\ArrayShape;
use ModularLightspeed\ModularLightspeed\API\LightspeedRequestData;

final class PutOrderData extends LightspeedRequestData
{
    protected string $type = 'put';
    protected string $path = 'orders';

    public function __construct(
        string $token,
        protected $orderId,
        protected string $status,
        protected string $paymentStatus,
        string $language = 'en',
    ) {
        parent::__construct($token, $language);
        $this->path .= "/" . $orderId;
    }

    #[ArrayShape(['order' => "array"])]
    public function getJson(): array
    {
        return [
            'order' => [
                'status' => $this->status,
                'paymentStatus' => $this->paymentStatus
            ]
        ];
    }
}
