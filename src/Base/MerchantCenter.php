<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\Base;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Lunar\Models\Product;

/**
 * @method static array products()
 * @see MerchantCenterManager::products
 *
 * @method static array modifyProduct(Product $product, string $productId)
 * @see MerchantCenterManager::modifyProduct
 *
 * @method static array removeProduct(Product $product, string $productId)
 * @see MerchantCenterManager::removeProduct
 *
 * @method static array removeAll(Collection $productIds)
 * @see MerchantCenterManager::removeProduct
 *
 * @method static array createProduct(Product $product)
 * @see MerchantCenterManager::createProduct
 *
 * @see \XtendLunar\Addons\GoogleMerchantCenter\Base\MerchantCenterManager
 */
class MerchantCenter extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return MerchantCenterInterface::class;
    }
}
