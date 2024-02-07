<?php

namespace App\Services\Payments\Commands;

use App\Services\Payments\Enums\PaymentDriverEnum;
use App\Services\Payments\Models\PaymentMethod;
use Illuminate\Console\Command;

class InstallPaymentsCommand extends Command
{
    protected $signature = 'payments:install';

    protected $description = 'Command description';


    public function handle()
    {
        $this->warn('Установка платежных систем');

        $this->installPaymentMethods();

        $this->info('Платежные системы установлены');
    }

    private function installPaymentMethods(): void
    {
        PaymentMethod::query()->firstOrCreate([
            'driver'=> PaymentDriverEnum::test,
        ],[
            'name'=>'Тестовый способ',
            'active'=> !app()->isProduction(),
        ]);

        PaymentMethod::query()->firstOrCreate([
            'driver'=> PaymentDriverEnum::tinkoff,
        ],[
            'name'=>'Банковская карта',
            'active'=> false,
        ]);
    }
}
