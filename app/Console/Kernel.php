<?php

namespace App\Console;

use App\Services\Currencies\Commands\UpdateCurrencyPricesCommand;
use App\Services\Currencies\Sources\SourceEnum;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(UpdateCurrencyPricesCommand::class,[SourceEnum::cbrf->value])->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
