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


class ImportSentBank extends Command implements SelfHandling
{
    protected $signature = 'import:SentBank';
   
    protected $description = 'Comando a ENVIADO AL BANCO';

    public function handle()
    {   
        global $Progress, $found,$nofound,$cam;
        $found=0;
        $nofound=0;
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
                        global $Progress,$found, $nofound,$cam;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $Progress->advance();

                        
                       Log::info($result->descripcion_2);
                     
                            $ecom = EconomicComplement::where('affiliate_id','=', trim($result->descripcion_2))                                                     
                                                      ->where('eco_com_procedure_id','=', 13)->first();
                            if ($ecom)
                            {       
                                    $ecom->eco_com_state_id = 24;  //Enviado a banco
                                    $ecom->save();
                                    $found++;                  
                            }
                            else
                            {
                                  $nofound++; 
                                  Log::info($result->descripcion2);             
                            }
                        

                    });

                });

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;

                $Progress->finish();

                $this->info("\n\nReport Update:\n
                Enviados en Banco: $found\n    
                No Enviados: $nofound\n                
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
