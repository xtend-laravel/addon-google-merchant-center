<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\Commands;

use Illuminate\Console\Command;
use Lunar\Models\Channel;
use Lunar\Models\Product;
use XtendLunar\Addons\GoogleMerchantCenter\Base\MerchantCenter;
use XtendLunar\Addons\GoogleMerchantCenter\Concerns\WithGmcHelper;

class SyncProducts extends Command
{
    use WithGmcHelper;

    protected $signature = 'gmc:sync-products';

    protected $description = 'Sync products to Google Merchant Center';

    public function handle(): int
    {
        $this->info('Syncing all products to Google Merchant Center...');

        $channel = Channel::where('handle', 'gmc')->sole();

        /** @var \Illuminate\Database\Eloquent\Collection $products */
        $products = Product::channel($channel)->get();

        // Product::all()->each(
        //     fn(Product $product) => $product->scheduleChannel(Channel::all()),
        // );

        $products->each(
            fn($product) => $this->syncProduct($product),
        );

        $this->info('Done syncing products to Google Merchant Center.');

        return self::SUCCESS;
    }

    public function syncProduct(Product $product): void
    {
        $this->productExists($product)
            ? MerchantCenter::modifyProduct($product, $this->generateGmcId($product))
            : MerchantCenter::createProduct($product);

        $this->info("Synced product {$product->translateAttribute('name')} to Google Merchant Center.");
    }
}
