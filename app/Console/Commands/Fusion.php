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
use Log;

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
            
            foreach ($afi1 as $a1) {
                $Progress->advance();
                $ci1 = explode('-', $a1->identity_card)[0];
                if ($ci2=Affiliate::whereRaw("split_part(identity_card, '-', 1) = '".$ci1."'")->where('id','<>',$a1->id)->first()) {
                    if ($ci2) {
                        # code...
                    $count++;   
                    Log::info($ci1);
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
