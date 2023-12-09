<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\Concerns;

use Lunar\Models\Product;
use XtendLunar\Addons\GoogleMerchantCenter\Models\Product as ProductGmc;

trait WithGmcHelper
{
    public function productExists(Product $product): bool
    {
        $gmcId = $this->generateGmcId($product);
        return ProductGmc::query()->where('gmc_id', $gmcId)->exists();
    }

    public function generateGmcId(Product $product): string
    {
        $baseVariantSku = $this->getBaseVariantSku($product);
        return 'online:en:US:' . $baseVariantSku;
    }

    public function getBaseVariantSku(Product $product): string
    {
        $baseVariant = $product->variants->firstWhere('base', true);
        return $baseVariant->sku;
    }
}
