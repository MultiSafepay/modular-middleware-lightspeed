<?php declare(strict_types=1);

namespace ModularLightspeed\ModularLightspeed\API\Request\Webhooks;


use ModularLightspeed\ModularLightspeed\API\LightspeedRequestData;

final class DeleteWebhook extends LightspeedRequestData
{
    protected string $type = 'delete';
    protected string $path = 'webhooks';

    public function __construct(
        string $token,
        protected string $id,
        string $language = 'en'
    )
    {
        parent::__construct($token, $language);
        $this->path .= '/' . $this->id;
    }
}
