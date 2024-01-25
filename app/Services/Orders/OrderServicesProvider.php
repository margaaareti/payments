<?php

namespace App\Services\Orders;

use App\Services\Currencies\Commands\InstallCurrenciesCommand;
use App\Services\Orders\Models\Order;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class OrderServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'order' => Order::class,
        ]);

        if ($this->app->runningInConsole()) {

            $this->loadMigrationsFrom(__DIR__ . '/Migrations');

            $this->commands([
            ]);
        }
    }
}
