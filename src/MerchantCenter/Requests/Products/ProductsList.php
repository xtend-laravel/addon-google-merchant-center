<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ProductsList extends Request
{
    protected Method $method = Method::GET;

    protected function defaultQuery(): array
    {
        return [
            'maxResults' => 250,
        ];
    }

    public function resolveEndpoint(): string
    {
        return '/products';
    }
}
