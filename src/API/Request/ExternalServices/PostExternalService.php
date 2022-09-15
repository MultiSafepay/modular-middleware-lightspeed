<?php declare(strict_types=1);

namespace ModularLightspeed\ModularLightspeed\API\Request\ExternalServices;

use JetBrains\PhpStorm\ArrayShape;
use ModularLightspeed\ModularLightspeed\API\LightspeedRequestData;
use function config;

final class PostExternalService extends LightspeedRequestData
{
    protected string $type = 'post';
    protected string $path = 'external_services';
    protected string $name;

    public function __construct(
        string $token,
        protected string $endpoint,
        protected string $serviceType = 'payment',
        string $language = 'en'
    ) {
        parent::__construct($token, $language);
        $this->name = config('app.name');
    }

    #[ArrayShape(['externalService' => "array"])]
    public function getJson(): array
    {
        return [
            'externalService' => [
                'type' => $this->serviceType,
                'name' => $this->name,
                'urlEndpoint' => $this->endpoint,
                'isActive' => true,
            ]
        ];
    }
}
