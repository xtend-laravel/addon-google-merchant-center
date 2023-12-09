<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class ProductsInsert extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected array $payload,
    ){}

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function resolveEndpoint(): string
    {
        return '/products';
    }
}
