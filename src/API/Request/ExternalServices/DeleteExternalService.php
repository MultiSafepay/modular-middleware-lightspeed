<?php declare(strict_types=1);


namespace ModularLightspeed\ModularLightspeed\API\Request\ExternalServices;

use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;

final class DeleteExternalService extends lightspeedRequestData
{
    protected string $type = 'delete';
    protected string $path = 'external_services';

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
