<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Lunar\Models\Product;
use XtendLunar\Addons\GoogleMerchantCenter\Base\MerchantCenter;
use XtendLunar\Addons\GoogleMerchantCenter\Concerns\WithGmcHelper;

class DeleteProductsNotInChannel extends Command
{
    use WithGmcHelper;

    protected $signature = 'gmc:delete-products-not-in-channel';

    protected $description = 'Clears out all products in Google Merchant Center that are not in the GMC channel';

    public function handle(): int
    {
        $this->components->info('Removing all products from Google Merchant Center that are not in the GMC channel...');
        $products = $this->getNonGmcChannelProducts();

        if ($products->isEmpty()) {
            $this->components->warn('No products to remove from Google Merchant Center.');

            return self::SUCCESS;
        }

        $productIds = $products->map(fn($product) => $this->generateGmcId($product));
        MerchantCenter::removeAll($productIds);

        $this->components->info('Done removing products from Google Merchant Center that are not in the GMC channel.');

        return self::SUCCESS;
    }

    private function getNonGmcChannelProducts(): Collection
    {
        return Product::whereDoesntHave('channels', function (Builder $query) {
            $query
                ->where('handle', 'gmc')
                ->where('enabled', true);
        })->get();
    }
}
