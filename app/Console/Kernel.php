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
        \Muserpol\Console\Commands\ImportNua::class
        
    ];


    protected function schedule(Schedule $schedule)
    {

         $schedule->command('create:ipcrate')->monthly();
         $schedule->command('create:contributionrate')->monthly();

    }
}
