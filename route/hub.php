<?php

use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Middleware\Authenticate;
use XtendLunar\Addons\GoogleMerchantCenter\Livewire\Pages\MerchantProductsIndex;

Route::prefix(config('lunar-hub.system.path'))
    ->middleware(['web', Authenticate::class, 'can:settings:core'])
    ->group(function () {
        Route::get('/google-merchant-center', MerchantProductsIndex::class)->name('hub.google-merchant-center.index');
    });
