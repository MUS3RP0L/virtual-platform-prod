<?php

namespace Muserpol\Console\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;
use Log;
use Muserpol\Affiliate;
use Muserpol\Spouse;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementRequirement;
use Muserpol\EconomicComplementSubmittedDocument;

class ImportDisability extends Command implements SelfHandling
{
    protected $signature = 'import:disability';   
    protected $description = 'Importacion Regional';

    public function handle()
    {
    	global $Progress, $count, $afino, $afiecono, $afisuc;
        
        $password = $this->ask('Enter the password');

        if ($password == ACCESS) {

            $FolderName = $this->ask('Enter the name of the folder you want to import');

            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {
                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();                
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");

                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) {
                    $rows->each(function($result) {
							global $Progress, $count, $afino, $afiecono, $afisuc;
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '-1');
                            ini_set('max_input_time', '-1');
                            set_time_limit('-1');
                            $Progress->advance();

                            $ci = ltrim($result->nro_identificacion, "0");
                            $afi=Affiliate::whereRaw("LTRIM(identity_card,'0') ='".$ci."'")->first();
                            if ($afi) {
                            	if ($ecom = $afi->economic_complements()->whereYear('year','=',2017)->where('semester','like','Primer')->first()) {
                            		$ecom->total_rent = $ecom->total_rent + $result->total_bs;
                            		$ecom->aps_disability = $result->total_bs;
                            		$ecom->save();
                            		$afisuc[]=$result->nro_identificacion;
                            	}else{
                            		$afiecono[]=$result->nro_identificacion;
                            	}
                            }else{
                            	$afino[]=$result->nro_identificacion;
                            }
                    });
                });

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();

                $this->info("\n\nReport Update:\n
                Total encontrados ".sizeof($afisuc)." \n
                Afiliados no econtrados ".sizeof($afino).". \n
                Afiliados econtrados sin tramites ".sizeof($afiecono).". \n
                Execution time $execution_time [minutes].\n");
                Log::info('Successful');
                Log::info($afisuc);
                Log::info('No encontrado ');
                Log::info($afino);
                Log::info('sin tramites ');
                Log::info($afiecono);
            }

        }
        else {
            $this->error('Incorrect password!');
            exit();
        }



    }
}

