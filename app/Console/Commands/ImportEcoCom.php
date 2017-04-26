<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\Affiliate;
use Muserpol\Breakdown;
use Muserpol\Degree;
use Muserpol\Hierarchy;
use Muserpol\Category;
use Muserpol\Unit;


class ImportEcoCom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ecocom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Eco com';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $NewAffi, $UpdateAffi, $NewContri, $Progress, $FolderName, $Date;

        $password = $this->ask('Enter the password');

        if ($password == ACCESS) {

            $FolderName = $this->ask('Enter the name of the folder you want to import');

            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {

                
                
            }
        }
        else{
            $this->error('Incorrect password!');
            exit();
        }

    }
}
