<?php declare(strict_types=1);


namespace ModularLightspeed\ModularLightspeed\API\Request\ExternalServices;


use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;

final class GetAllExternalServices extends lightspeedRequestData
{
    protected string $type = 'get';
    protected string $path = 'external_services';

    public function toResponse(array|\Illuminate\Http\Client\Response $data) : array
    {
        return $data['externalServices'];
    }
}
