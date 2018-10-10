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
use Log;


class ImportRezagados extends Command implements SelfHandling
{
    protected $signature = 'import:rezagados';
   
    protected $description = 'Comando para importar rezagados';

    public function handle()
    {   
        global $Progress,$rezagados, $pagados,$cam;
        
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
                        global $Progress,$rezagados, $pagados,$cam;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $Progress->advance();

                        $ecom = EconomicComplement::where('affiliate_id','=', trim($result->descripcion2))
                                                    ->where('eco_com_procedure_id','=', 7)->first();
                        if($ecom)
                        {
                            if ($ecom->eco_com_state_id == 1 ) //or $ecom->eco_com_state_id == 17
                            {                                 
                              $pagados ++;                     
                            }
                            else
                            { 
                              if($ecom->total == $result->importeapagar)                               
                              {
                                $ecom->workflow_id= 2;
                                $ecom->wf_current_state_id = 3;
                                $ecom->eco_com_state_id = 15;
                                $ecom->save();
                                $rezagados ++;
                              }
                              else
                              {
                                    Log::info($ecom->id);
                              }

                             
                            }
                            
                        }                 

                    });

                });

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;

                $Progress->finish();

                $this->info("\n\nReport Update:\n
                Pagados en Banco: $pagados\n    
                Rezagados: $rezagados\n                
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