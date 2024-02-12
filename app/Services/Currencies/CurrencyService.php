<?php

namespace App\Services\Currencies;

use App\Services\Actions\UpdateCurrencyPricesAction;
use App\Services\Currencies\Sources\Source;
use App\Services\Currencies\Sources\SourceEnum;
use App\Services\Currencies\Sources\SourceFactory;

class CurrencyService
{
    public function getSource(SourceEnum $source): Source
    {
        return SourceFactory::make($source);
    }

    public function updatePrices(): UpdateCurrencyPricesAction
    {
        return app(UpdateCurrencyPricesAction::class);
    }
}
