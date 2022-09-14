<?php declare(strict_types=1);

namespace Modularlightspeed\Modularlightspeed\API\Request\Webhooks;


use Modularlightspeed\Modularlightspeed\API\lightspeedRequestData;

final class GetAllWebhooks extends lightspeedRequestData
{
    protected string $type = 'get';
    protected string $path = 'webhooks';

    public function toResponse(array|\Illuminate\Http\Client\Response $data) : array
    {
        return $data['webhooks'];
    }
}
