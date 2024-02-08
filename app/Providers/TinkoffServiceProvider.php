<?php

namespace App\Providers;

use App\Services\Tinkoff\Actions\CreatePaymentData;
use App\Services\Tinkoff\TinkoffConfig;
use App\Services\Tinkoff\TinkoffService;
use Illuminate\Support\ServiceProvider;

class TinkoffProvider extends ServiceProvider
{

public function register(): void
{

}

    public function boot()
    {}
    

}


}
