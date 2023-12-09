<?php

namespace XtendLunar\Addons\GoogleMerchantCenter\Livewire\Pages;

use Livewire\Component;

class MerchantProductsIndex extends Component
{
    public function render()
    {
        return view('xtend-lunar-google-merchant-center::livewire.pages.merchant-products.index')
            ->layout('adminhub::layouts.app');
    }
}
