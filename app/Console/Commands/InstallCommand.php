<?php

namespace App\Console\Commands;

use App\Services\Currencies\Commands\InstallCurrenciesCommand;
use Illuminate\Console\Command;

class InstallCommand extends Command
{

    protected $signature = 'install';


    protected $description = 'Command description';


    public function handle()
    {
        $this->warn('Установка приложения...');

        $this->call(InstallCurrenciesCommand::class);

        $this->info('Приложение установлено...');
    }
}
