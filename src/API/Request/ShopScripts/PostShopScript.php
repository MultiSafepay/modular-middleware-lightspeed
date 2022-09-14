<?php declare(strict_types=1);


namespace Modularlightspeed\Modularlightspeed\API\Request\ShopScripts;


use Modularlightspeed\Modularlightspeed\API\lightspeedRequestData;
use function config;

final class PostShopScript extends lightspeedRequestData
{
    protected string $type = 'post';
    protected string $path = 'shop/scripts';
    protected string $name;

    public function __construct(
        protected string $token,
        protected string $location,
        public string $language = 'en'
    ) {
        parent::__construct($token, $language);
        $this->name = config('app.name');
    }


    public function getJson(): array
    {
        return [
            'shopScript' => [
                'url' => $this->location,
                'location' => 'body'
            ]
        ];
    }
}
