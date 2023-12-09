<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use XtendLunar\Addons\GoogleMerchantCenter\Models\Product;

class ProductsGet extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected Product $product,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->product->gmc_id;
    }
}
