<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\Base;

use Illuminate\Support\Collection;
use Lunar\Models\Product;

interface MerchantCenterInterface
{
    public function products(): array;

    public function modifyProduct(Product $product, string $productId): void;

    public function removeProduct(Product $product, string $productId): void;

    public function createProduct(Product $product): void;

    public function removeAll(Collection $productIds): void;
}
