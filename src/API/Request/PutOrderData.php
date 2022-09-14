<?php declare(strict_types=1);

namespace Modularlightspeed\Modularlightspeed\API\Request;

use JetBrains\PhpStorm\ArrayShape;
use Modularlightspeed\Modularlightspeed\API\lightspeedRequestData;

final class PutOrderData extends lightspeedRequestData
{
    protected string $type = 'put';
    protected string $path = 'orders';

    public function __construct(
        string $token,
        protected int $orderId,
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
