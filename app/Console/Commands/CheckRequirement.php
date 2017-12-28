<?php

namespace Muserpol\Console\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\Affiliate;
use Muserpol\Spouse;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use Muserpol\AffiliateObservation;
use Log;


class CheckRequirement extends Command implements SelfHandling
{
    protected $signature = 'check:requirement';
   
    protected $description = 'checking observations of requirements';

    public function handle()
    {   
        global $Progress,$nofound,$found, $pagados,$cam;
        
       $password = $this->ask('Enter the password');
        if ($password == ACCESS) 
        {

            $FolderName = $this->ask('Enter the name of the folder you want to import');

            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) 
            {
                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                
                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) 
                {
                    $rows->each(function($result) 
                    {
                        global $Progress,$nofound,$found, $pagados,$cam;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $Progress->advance();


                        $ecom1 = EconomicComplement::where('affiliate_id','=', $result->descripcion2)
                                                    ->where('eco_com_procedure_id','=', 6)->first();
                        if($ecom1)
                        {   
                            $ecom = AffiliateObservation::where('affiliate_id','=', $ecom1->affiliate_id)
                                                        ->whereIn('observation_type_id',[6,7])
                                                        ->where('is_enabled','=', false)
                                                        ->whereNull('deleted_at')->first();
                            if($ecom)
                            {  
                                $daf = EconomicComplement::where('affiliate_id','=', $ecom->affiliate_id)
                                                    ->where('eco_com_procedure_id','=', 2)
                                                    ->where('wf_current_state_id','=',12)
                                                    ->where('state','=','Received')->first();
                                if($daf)
                                {
                                   //Log::info($daf->affiliate_id); 
                                   $found++;       
                                }
                                else
                                {
                                    Log::info($ecom->affiliate_id); 
                                }
                               //Log::info($ecom->affiliate_id);         
                               
                            }         
                        }
                        else
                        {
                            $nofound++;
                        }

                        
                                                    
                                 

                    });

                });

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;

                $Progress->finish();

                $this->info("\n\nReport Update:\n
                Pagados en Banco: $found\n    
                NoFound: $nofound\n                
                Execution time $execution_time [minutes].\n");
            }

        }
        else
        {
            $this->error('Incorrect password!');
            exit();
        }
        


    }
}