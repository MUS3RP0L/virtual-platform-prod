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
use Muserpol\EconomicComplementRequirement;
use Muserpol\EconomicComplementSubmittedDocument;

class ImportSpouse extends Command implements SelfHandling
{
    protected $signature = 'import:sp';   
    protected $description = 'Command description';

    public function handle()
    {   global $Progress,$vej, $viu, $orf,$newafi,$oldafi,$totalafi;
        
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
                                global $Progress,$vej, $viu, $orf,$newafi,$oldafi,$totalafi;
                                ini_set('memory_limit', '-1');
                                ini_set('max_execution_time', '-1');
                                ini_set('max_input_time', '-1');
                                set_time_limit('-1');
                                $Progress->advance();                   

                                $afi = Affiliate::where('identity_card','=', trim($result->afi_identity_card));
                                if($afi)
                                {
                                    $ecom = EconmicComplement::where('affiliate_id','=', $afi->id);
                                }

                                $afi = EconmicComplement::leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                                          ->whereYear('year','=' 2016)
                                                          ->where('semester', '=', 'Segundo')
                                                          ->where('identity_card','=', trim($result->afi_identity_card))
                                                          ->first();                            
                                if($afi->)
                                if($result->c_tipo = 2) // create spouse
                                {   
                                    $spouse = Spouse::where('affiliate_id','=', $afi->id);
                                    
                                    if (!$spouse)
                                    {
                                        $spouse = new Spouse;
                                        $spouse->user_id = 1;
                                        $spouse->affiliate_id = $afi->id;
                                        $spouse->city_identity_card_id = $result->ap_city_identity_card_id;
                                        $spouse->identity_card = $result->ap_identity_card;                                
                                        $spouse->registration = "0";
                                        $spouse->last_name = $result->ap_last_name;
                                        $spouse->mothers_last_name = $result->ap_mothers_last_name;
                                        $spouse->first_name = $result->ap_first_name;
                                        $spouse->second_name = $result->ap_second_name;
                                        $spouse->surname_husband = $result->ap_surname_husband;
                                        $spouse->civil_status = $result->ap_civil_status;
                                        $spouse->birth_date = $result->ap_birth_date;
                                        $spouse->save();
                                        $viu++;
                                    }                               
                                }





                        });
                });

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();

                $this->info("\n\nReport Update:\n
                $vej Vejez.\n
                $viu Viudadedad.\n
                $orf orfandad.\n               
                Execution time $execution_time [minutes].\n");
            }

        }
        else {
            $this->error('Incorrect password!');
            exit();
        }



    }
}
