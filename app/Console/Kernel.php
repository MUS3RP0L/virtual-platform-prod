<?php

namespace Muserpol\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [

        \Muserpol\Console\Commands\ImportPayroll::class,
        \Muserpol\Console\Commands\ImportReimbursement::class,
        \Muserpol\Console\Commands\ImportBaseWage::class,
        \Muserpol\Console\Commands\ImportEcoCom::class,
        \Muserpol\Console\Commands\CreateIpcRate::class,
        \Muserpol\Console\Commands\CreateContributionRate::class,
        \Muserpol\Console\Commands\importfinal::class,
        \Muserpol\Console\Commands\CalculateAverage::class,
        \Muserpol\Console\Commands\ImportComplement::class,
        \Muserpol\Console\Commands\ImportRequirement::class,
        \Muserpol\Console\Commands\AutomaticCalculation::class,
        \Muserpol\Console\Commands\ImportJuridica::class,
        \Muserpol\Console\Commands\UpdateAffiliateRecords::class,
        \Muserpol\Console\Commands\ExportExcel::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('create:ipcrate')->monthly();
        $schedule->command('create:contributionrate')->monthly();
    }
}
