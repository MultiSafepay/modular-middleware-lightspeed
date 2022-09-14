<?php declare(strict_types=1);


namespace Modularlightspeed\Modularlightspeed\API\Request\ExternalServices;


use Modularlightspeed\Modularlightspeed\API\lightspeedRequestData;

final class GetAllExternalServices extends lightspeedRequestData
{
    protected string $type = 'get';
    protected string $path = 'external_services';

    public function toResponse(array|\Illuminate\Http\Client\Response $data) : array
    {
        return $data['externalServices'];
    }
}
