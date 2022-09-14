<?php declare(strict_types=1);

namespace ModularLightspeed\ModularLightspeed\API\Request\Webhooks;


use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;

final class PostWebhook extends lightspeedRequestData
{
    protected string $type = 'post';
    protected string $path = 'webhooks';

    public function __construct(
        string $token,
        protected string $itemGroup,
        protected string $itemAction,
        protected string $address,
        string $language = 'en'
    ) {
        parent::__construct($token, $language);
    }

    public function getJson(): array
    {
        return [
            'webhook' => [
                'itemGroup' => $this->itemGroup,
                'itemAction' => $this->itemAction,
                'address' => $this->address,
                'isActive' => true,
                'format' => 'json'
            ]
        ];
    }
}
