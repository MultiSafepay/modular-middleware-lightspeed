<?php

namespace ModularLightspeed\ModularLightspeed\API\Request;

use Illuminate\Http\Client\Response;
use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;
use function collect;

class PutInvoiceData extends lightspeedRequestData
{
    protected string $type = 'put';
    protected string $path = 'invoices/';

    public function __construct(
        string $token,
        protected string $invoice,
        string $language = 'en',
        public string $status = 'paid'
    ) {
        parent::__construct($token, $language);
        $this->path .= $this->invoice;
    }

    public function getJson(): array
    {
        return [
            'invoice' => [
                'status' => 'paid'
            ]
        ];
    }

    public function toResponse(array|Response $data): \Illuminate\Support\Collection
    {
        return collect($data);
    }
}
