<?php declare(strict_types=1);

namespace ModularLightspeed\ModularLightspeed\API\Request\Webhooks;


use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;

final class DeleteWebhook extends lightspeedRequestData
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
