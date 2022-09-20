<?php declare(strict_types=1);


namespace ModularLightspeed\ModularLightspeed\API;

use Illuminate\Http\Client\Response;
use ModularLightspeed\ModularLightspeed\API\Data\RequestData;
use ModularLightspeed\ModularLightspeed\API\Data\ResponseInterface;

class LightspeedRequestData extends RequestData implements ResponseInterface
{
    public function __construct(
        protected string $token,
        protected string $language = 'en'
    )
    {
    }

    public function getAuth(): string {return $this->token;}
    public function getLanguage(): string {return $this->language;}

    public function toResponse(array|Response $data) : array|string|null|\Illuminate\Support\Collection {return null;}

}
