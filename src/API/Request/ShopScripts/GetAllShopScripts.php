<?php declare(strict_types=1);


namespace Modularlightspeed\Modularlightspeed\API\Request\ShopScripts;

use Modularlightspeed\Modularlightspeed\API\lightspeedRequestData;

final class GetAllShopScripts extends lightspeedRequestData
{
    protected string $type = 'get';
    protected string $path = 'shop/scripts';

    public function toResponse(array|\Illuminate\Http\Client\Response $data) : array
    {
        return $data['shopScripts'];
    }
}
