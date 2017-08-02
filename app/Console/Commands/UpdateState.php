<?php
namespace Muserpol\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Muserpol\Degree;
use Muserpol\Affiliate;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementModality;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementRent;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

class UpdateState extends Command implements SelfHandling
{
    protected $signature = 'update:state';
    protected $description = 'Actualizacion del estado del tramites a -> en tramite ';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {   global $Progress;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
            $time_start = microtime(true);
            $this->info("Working...\n");
            $Progress = $this->output->createProgressBar();
            $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
            $count=0;
            $economic_complements = EconomicComplement::whereYear('year','=',2017)
                            ->where('semester','=','Primer')
                            ->get();
            foreach ($economic_complements as $eco) {
                $Progress->advance();
                $count++;
                $eco->eco_com_state_id = 16;
                $eco->save();
            }
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start)/60;
            $Progress->finish();

            $this->info("\n\nupdate $count states:\n
            Execution time $execution_time [minutes].\n");
       }else {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
