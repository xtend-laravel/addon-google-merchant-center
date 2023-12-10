<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\Base;

use Saloon\Http\Request;
use XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\MerchantCenterApiConnector;
use XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products\ProductsDelete;
use XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products\ProductsInsert;
use XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products\ProductsList;
use XtendLunar\Addons\GoogleMerchantCenter\MerchantCenter\Requests\Products\ProductsUpdate;

class MerchantCenterApiService
{
    public function __construct(
        private MerchantCenterApiConnector $connector)
    {}

    public function createProduct(array $payload): array
    {
        return $this->processRequest(
            new ProductsInsert(
                payload: $payload,
            ),
        );
    }

    public function updateProduct(array $payload, string $productId): array
    {
        return $this->processRequest(
            new ProductsUpdate(
                payload: $payload,
                id: $productId,
            ),
        );
    }

    public function deleteProduct(string $productId): ?array
    {
        return $this->processRequest(
            new ProductsDelete(
                id: $productId,
            ),
        );
    }

    public function fetchProducts(): array
    {
        return $this->processRequest(
            request: new ProductsList(),
        );
    }

    private function processRequest(Request $request): array
    {
        $response = $this->connector->send(
            request: $request,
        );

        if ($response->failed()) {
            dump($response->json('error.message'));
            return [];
        }

        return $response->json('resources') ?? [];
    }
}
