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

class Concurrencia extends Command implements SelfHandling
{
    protected $signature = 'import:concurrencia';
    protected $description = 'Copy all record from 1ER Semester to 2do Semester';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {   global $Progress,$rev,$nrev, $exrev,$exnrev;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');

        $password = $this->ask('Enter the password');
        if ($password == ACCESS) 
        {
            $time_start = microtime(true);
            $this->info("Working...\n");
            $Progress = $this->output->createProgressBar();
            $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
            

            $rev=0;
            $nrev=0;
            $ecom1 = EconomicComplement::where('eco_com_procedure_id','=',2)
                                        ->whereRaw("total_rent > salary_quotable")
                                        ->where('id','<>',8487)->get();
            foreach ($ecom1 as $dato) 
            {   $Progress->advance();

                $actual = EconomicComplement::where('eco_com_procedure_id','=',6)                                       
                                        ->where('affiliate_id','=',$dato->affiliate_id)->first();
                if($actual)
                {   if($actual->eco_com_state_id != 22 || $actual->eco_com_state_id != 12)
                    {
                      $actual->wf_current_state_id = '8';
                      if($dato->aps_disability > 0)
                      {
                          $actual->eco_com_state_id = '22';
                          $actual->total_rent = $actual->total_rent + $dato->aps_disability;
                          $actual->aps_disability = $dato->aps_disability;
                      }
                      else
                      {
                          $actual->eco_com_state_id = '12';
                      }      
                      
                      $actual->save();
                      $rev++;
                    }
                   
                }
                else
                {
                    $nrev++;
                }
            }                   

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start)/60;
            $Progress->finish();
            $this->info("\n\nEncontrados: $rev\n
                    NoEncontados: $nrev\n
                    
                    Execution time $execution_time [minutes].\n");
             
       }
       else 
       {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
