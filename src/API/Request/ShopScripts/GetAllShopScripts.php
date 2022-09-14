<?php declare(strict_types=1);


namespace ModularLightspeed\ModularLightspeed\API\Request\ShopScripts;

use ModularLightspeed\ModularLightspeed\API\lightspeedRequestData;

final class GetAllShopScripts extends lightspeedRequestData
{
    protected string $type = 'get';
    protected string $path = 'shop/scripts';

    public function toResponse(array|\Illuminate\Http\Client\Response $data) : array
    {
        return $data['shopScripts'];
    }
}
