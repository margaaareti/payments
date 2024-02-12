<?php

namespace App\Services\Currencies\Commands;

use App\Services\Currencies\Models\Currency;
use App\Services\Currencies\Sources\SourceEnum;
use App\Support\Values\AmountValue;
use Illuminate\Console\Command;

class InstallCurrenciesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->warn('Установка валют...');

        $this->installCurrencies();

        $this->info('Валюты установлены.');
    }


    private function installCurrencies(): void
    {

        Currency::query()->firstOrCreate(
            ['id' => Currency::RUB,],
            [
                'name' => 'Рубль',
                'price' => new AmountValue(1),
                'source'=> SourceEnum::manual,
            ]
        );

        Currency::query()->firstOrCreate(
            ['id' => Currency::USD,],
            [
                'name' => 'Доллар США',
                'price' => new AmountValue(100),
                'source'=> SourceEnum::manual,
            ]
        );

    }
}
