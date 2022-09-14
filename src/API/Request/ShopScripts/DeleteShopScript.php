<?php declare(strict_types=1);


namespace ModularLightspeed\ModularLightspeed\API\Request\ShopScripts;


use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;

final class DeleteShopScript extends lightspeedRequestData
{
    protected string $type = 'delete';
    protected string $path = 'shop/scripts';

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

