<?php declare(strict_types=1);


namespace ModularLightspeed\ModularLightspeed\API\Request\ShopScripts;

use ModularLightspeed\ModularLightspeed\API\LightspeedRequestData;

final class GetAllShopScripts extends LightspeedRequestData
{
    protected string $type = 'get';
    protected string $path = 'shop/scripts';

    public function toResponse(array|\Illuminate\Http\Client\Response $data) : array
    {
        return $data['shopScripts'];
    }
}
