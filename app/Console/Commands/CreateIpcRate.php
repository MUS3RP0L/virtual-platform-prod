<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use Carbon\Carbon;
use Muserpol\IpcRate;

class CreateIpcRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'create:ipcrate';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Creating monthly index of consumer price.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {   
        $last_ipcrate = IpcRate::orderBy('month_year', 'desc')->first();

        if (Carbon::parse($last_ipcrate->month_year)->addMonth() < $date = new Carbon()) {
            
            $new_ipcrate = new IpcRate;
            $new_ipcrate->user_id = 1;
            $new_ipcrate->index = $last_ipcrate->index;
            $new_ipcrate->month_year = Carbon::parse($last_ipcrate->month_year)->addMonth();
            $new_ipcrate->save();

            $year = Carbon::parse($last_ipcrate->month_year)->year;
            $month = Carbon::parse($last_ipcrate->month_year)->month;
            \Storage::disk('local')->put('IpcRate_'. $month . '-' . $year . '.txt', "Index of consumer price successfully updated: " . $last_ipcrate->index);

        }

     }
}
