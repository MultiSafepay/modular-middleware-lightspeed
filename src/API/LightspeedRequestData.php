<?php declare(strict_types=1);


namespace Modularlightspeed\Modularlightspeed\API;


use App\Data\RequestData;
use App\Data\ResponseInterface;
use Illuminate\Http\Client\Response;

class lightspeedRequestData extends RequestData implements ResponseInterface
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
