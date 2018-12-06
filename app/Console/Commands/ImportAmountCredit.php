<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\EconomicComplement;
use Muserpol\Helper\Util;
use Muserpol\Affiliate;
use Muserpol\Spouse;
use Log;

class ImportAmountCredit extends Command implements SelfHandling
{
    protected $signature = 'import:amount_credit';
   
    protected $description = '';

    /**
     * Execute the command.
     *
     * @return void
     */
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
                        if ($result->ci) {
                            if ($result->tipo == 'T') {
                                $affiliate = Affiliate::where('identity_card',$result->ci)->first();
                            }else{
                                $affiliate = Spouse::where('identity_card',$result->ci)->first()->affiliate;
                            }
                            if ($affiliate) {
                                $found++;
                                $eco = EconomicComplement::where('affiliate_id', $affiliate->id)->where('eco_com_procedure_id', 13)->first();
                                if (! $eco) {
                                    $this->info('EconomicComplement NOT FOUND '.$result->ci  );
                                }else{
                                    $eco->amount_credit = $result->total;
                                    $eco->save();
                                }
                            }else{
                                $this->info('Affiliate Not found =>'.$result->ci);
                            }
                        }
                    });
                });
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;

                $Progress->finish();

                $this->info("\n\nReport Update:\n
                Pagados en Banco: $found\n    
                No pagados: $nofound\n                
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
