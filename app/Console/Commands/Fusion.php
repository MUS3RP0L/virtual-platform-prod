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

class Fusion extends Command implements SelfHandling
{
    protected $signature = 'fusion:affiliate';
    protected $description = 'Fusion de Affiliates ';

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
             ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '-1');
                            ini_set('max_input_time', '-1');
                            set_time_limit('-1');
            $count=0;
            $afi1 = Affiliate::All();
            $afi2 = Affiliate::All();

            foreach ($afi1 as $a1) {
                $Progress->advance();
                        $ci1 = explode('-', $a1->identity_card);
                foreach ($afi2 as $a2) {
                    if($a1->id <> $a2->id){
                        $ci2 = explode('-', $a2->identity_card);
                        if($ci1[0]==$ci2[0]){
                            $count++;
                        }
                    }
                }
            }
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start)/60;
            $Progress->finish();

            $this->info("\n\nFound $count states:\n
            Execution time $execution_time [minutes].\n");
       }else {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
