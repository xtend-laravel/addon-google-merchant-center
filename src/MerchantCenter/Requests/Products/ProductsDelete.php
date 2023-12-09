<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ProductsDelete extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->id;
    }
}
