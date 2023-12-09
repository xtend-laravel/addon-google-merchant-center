<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;
use XtendLunar\Addons\GoogleMerchantCenter\Base\MerchantCenter;

class Product extends Model
{
    use Sushi;

    public function getRows(): array
    {
        return collect(MerchantCenter::products())
            ->map(fn($item) => $this->formatProduct($item))
            ->toArray();
    }

    private function formatProduct(array $item): array
    {
        return [
            'gmc_id' => $item['id'],
            'title' => $item['title'],
            'description' => $item['description'],
            'material' => $item['material'] ?? null,
            'imageLink' => $item['imageLink'] ?? null,
            'reference' => strtoupper($item['offerId']),
            'availability' => $item['availability'],
            'price' => $item['price']['value'],
            'product_types' => $this->getProductTypes($item),
            'gender' => ucwords($item['gender'] ?? 'unisex'),
            'color' => $item['color'] ?? null,
            'sizes' => implode(',', $item['sizes'] ?? []),
            'link' => $item['link'] ?? null,
        ];
    }

    private function getProductTypes(array $item): string
    {
        return implode(',', $item['productTypes'] ?? ['Clothing']);
    }
}
