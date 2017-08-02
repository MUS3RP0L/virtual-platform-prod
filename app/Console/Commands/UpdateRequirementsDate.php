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

class UpdateRequirementsDate extends Command implements SelfHandling
{
    protected $signature = 'update:req';
    protected $description = 'Command description';
    
    public function handle()
    {
        global $Progress, $vej, $viu, $orf, $newafi, $total;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {

            $FolderName = $this->ask('Enter the name of the folder you want to import');
            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {
                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                
                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file)
                {
                    $rows->each(function($result)
                    {
                        global $Progress, $vej, $viu, $orf, $newafi, $oldafi, $total;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $Progress->advance();
                        
                        if ($result->tiporenta == 'VEJEZ' or $result->tiporenta == 'RENT-M2000-VEJ' or $result->tiporenta == 'RENT-1COM-M2000-VEJ' or $result->tiporenta == 'RENT-1COMP-VEJ') {
                            $app = Affiliate::where('identity_card', '=', $result->ci)->first();
                            if ($app) {
                                $ecom = EconomicComplement::where('economic_complements.affiliate_id', '=', $app->id)->whereYear('year', '=', 2016)->where('semester', '=', 'Segundo')->first();
                                if ($ecom) {
                                    $submits = $ecom->economic_complement_submitted_documents;
                                    foreach ($submits as $value) {
                                        switch ($value->eco_com_requirement_id) {
                                            case "1":
                                                break;
                                            case "2":
                                                if ($result->v_ci2 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "3":
                                                if ($result->v_agra_servicio3 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "4":
                                                if ($result->v_anos_servicio4 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            default:
                                                if ($result->v_resolucion_senasir5 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                        }
                                        $value->save();
                                    }
                                    $vej++;
                                }
                            }
                        } elseif ($result->tiporenta == 'VIUDEDAD' or $result->tiporenta == 'RENT-M2000-VIU' or $result->tiporenta == 'RENT-1COM-M2000-VIU' or $result->tiporenta == 'RENT-1COMP-VIU') {
                            //Viudedad
                            
                            $app = Affiliate::where('identity_card', '=', $result->c_ci)->first();
                            if ($app) {
                                $ecom = EconomicComplement::where('economic_complements.affiliate_id', '=', $app->id)->whereYear('year', '=', 2016)->where('semester', '=', 'Segundo')->first();
                                if ($ecom) {
                                    $submits = $ecom->economic_complement_submitted_documents;
                                    foreach ($submits as $value) {
                                        switch ($value->eco_com_requirement_id) {
                                            case "6":
                                                break;
                                            case "7":
                                                if ($result->viu_ci_causa7 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "8":
                                                if ($result->viu_ci_derecho8 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "9":
                                                if ($result->viu_defuncion9 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "10":
                                                if ($result->viu_senasir10 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "11":
                                                if ($result->viu_agra_servicio11 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "12":
                                                if ($result->viu_anos_servicio12 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            default:
                                                if ($result->viu_matri13 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                        }
                                        $value->save();
                                    }
                                    $viu++;
                                }
                            }
                        } elseif ($result->tiporenta == "ORFANDAD") {
                            $app = Affiliate::where('identity_card', '=', $result->c_ci)->first();
                            if ($app) {
                                $ecom = EconomicComplement::where('economic_complements.affiliate_id', '=', $app->id)->whereYear('year', '=', 2016)->where('semester', '=', 'Segundo')->first();
                                if ($ecom) {
                                    $submits = $ecom->economic_complement_submitted_documents;
                                    foreach ($submits as $value) {
                                        switch ($value->eco_com_requirement_id) {
                                            case "14":
                                                break;
                                            case "15":
                                                if ($result->viu_ci_causa7 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "16":
                                                if ($result->viu_ci_derecho8 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "17":
                                                if ($result->viu_defuncion9 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "18":
                                                if ($result->viu_senasir10 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            case "19":
                                                break;
                                            case "20":
                                                if ($result->viu_agra_servicio11 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                                break;
                                            default:
                                                if ($result->viu_anos_servicio12 == "SI" && $value->status) {
                                                    $value->reception_date = Carbon::parse("2016-07-07");
                                                }
                                        }
                                        $value->save();   
                                    }
                                    $orf++;
                                }
                            }
                        }
                        $total = $vej + $viu + $orf;
                    });
                });
                
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start) / 60;
                $Progress->finish();
                
                $this->info("\n\ Update:\n
                    $vej Vejez.\n
                    $viu Viudadedad.\n
                    $orf orfandad.\n 
                    $total Total.\n               
                    Execution time $execution_time [minutes].\n");
            }  
        } else {
            $this->error('Incorrect password!');
            exit();
        }
    }
}