<?php

namespace XtendLunar\Addons\GoogleMerchantCenter;

use Binaryk\LaravelRestify\Traits\InteractsWithRestifyRepositories;
use CodeLabX\XtendLaravel\Base\XtendAddonProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Lunar\Hub\Facades\Menu;
use Lunar\Hub\Menu\MenuLink;
use Lunar\Models\Channel;
use XtendLunar\Addons\GoogleMerchantCenter\Base\MerchantCenterInterface;
use XtendLunar\Addons\GoogleMerchantCenter\Base\MerchantCenterManager;
use XtendLunar\Addons\GoogleMerchantCenter\Commands\DeleteProductsNotInChannel;
use XtendLunar\Addons\GoogleMerchantCenter\Commands\SyncProducts;
use XtendLunar\Addons\GoogleMerchantCenter\Livewire\Products\Table;

class GoogleMerchantCenterProvider extends XtendAddonProvider
{
    use InteractsWithRestifyRepositories;

    protected $policies = [

    ];

    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../route/hub.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'xtend-lunar-google-merchant-center');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'xtend-lunar::google-merchant-center');
        $this->loadRestifyFrom(__DIR__.'/Restify', __NAMESPACE__.'\\Restify\\');
        $this->mergeConfigFrom(__DIR__.'/../config/gmc.php', 'gmc');

        $this->app->singleton(MerchantCenterInterface::class, function ($app) {
            return $app->make(MerchantCenterManager::class);
        });

        $this->registerLivewireComponents();
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncProducts::class,
                DeleteProductsNotInChannel::class,
            ]);
        }

        if ($this->app->environment('production')) {
            $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
                $schedule->command(SyncProducts::class)->dailyAt('00:00');
                $schedule->command(DeleteProductsNotInChannel::class)->dailyAt('00:00');
            });
        }

        $this->registerPolicies();
        Blade::componentNamespace('XtendLunar\\Addons\\GoogleMerchantCenter\\Components', 'xtend-lunar::google-merchant-center');

        Menu::slot('sidebar')
            ->group('hub.configure')
            ->addItem(function (MenuLink $item) {
                return $item->name('Merchant Center')
                    ->handle('hub.google-merchant-center')
                    ->route('hub.google-merchant-center.index')
                    ->icon('shopping-bag');
            });

        $this->publishes([
           __DIR__.'/../config/gmc.php' => config_path('gmc.php'),
        ]);

        Channel::query()->updateOrCreate([
            'handle' => 'gmc'
        ], [
            'name' => 'Google Merchant Center',
            'default' => false,
            'url' => '#',
        ]);
    }

    protected function registerLivewireComponents(): void
    {
        Livewire::component('xtend-lunar::google-merchant-center.products.table', Table::class);
        // Livewire::component('xtend-lunar::google-merchant-center.widget-slots.create', Create::class);
        // Livewire::component('xtend-lunar::google-merchant-center.widget-slots.edit', Edit::class);
    }

    protected function registerPolicies()
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
