<?php declare(strict_types=1);


namespace Modularlightspeed\Modularlightspeed\API\Request\ShopScripts;


use Modularlightspeed\Modularlightspeed\API\lightspeedRequestData;

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

