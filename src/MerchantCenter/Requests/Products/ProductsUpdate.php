<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class ProductsUpdate extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function __construct(
        protected array $payload,
        protected string $id,
    ){}

    protected function defaultBody(): array
    {
        return $this->payload;
    }

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->id;
    }
}
