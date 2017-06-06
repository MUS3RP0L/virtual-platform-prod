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

class ImportComplement extends Command implements SelfHandling
{
    protected $signature = 'import:complement';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }
    

   
    public function handle()
    {   global $Progress,$vej, $viu, $orf,$afi,$app,$ecom;
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
                            global $Progress,$vej, $viu, $orf,$afi,$app,$ecom;
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '-1');
                            ini_set('max_input_time', '-1');
                            set_time_limit('-1');
                            $Progress->advance();
                            
                            $afi = Affiliate::where('identity_card','=', trim($result->afi_identity_card)->first();                            
                            if(!$afi) {
                                $afi = new Affiliate;
                                $afi->identity_card = $result->afi_identity_card;                                
                                $affiliate->city_identity_card_id = $result->$afi_city_identity_card_id;
                                $afi->gender = $result->afi_gender;
                            } 
                            $afi->user_id = 1;
                            $afi->affiliate_state_id = $result->afi_affiliate_state_id;
                            $afi->city_birth_id = $result->afi_city_birth_id;                            
                            $afi->degree_id = $result->afi_degree_id;;
                            $afi->unit_id = $result->unit_id;
                            $afi->category_id = $result->afi_category_id;
                            $afi->pension_entity_id = $result->afi_pension_entity_id;
                            $afi->registration ='0';
                            $afi->type = 'Comando';
                            $afi->last_name = $result->afi_last_name;
                            $afi->mothers_last_name = $result->afi_mothers_last_name;
                            $afi->first_name = $result->afi_first_name;
                            $afi->second_name = $result->afi_second_name;
                            $afi->surname_husband = $result->afi_surname_husband;
                            $afi->civil_status = $result->afi_civil_status;
                            $afi->birth_date = $result->afi_birth_date;
                            $afi->nua = $result->afi_nua;
                            $afi->change_date = Carbon::createFromDate(Carbon::parse($result->c_year)->year, 7, 1);
                            $afi->phone_number = $result->afi_phone_number;
                            $afi->cell_phone_number = $result->afi_cell_phone_number;
                            //$afi->save();

                            
                            $ecom = EconomicComplement::affiliateIs($affiliate->id)
                                    ->whereYear('year', '=', Carbon::parse($result->c_year)->year)
                                    ->where('semester', '=', $result->c_semestre)->first();
                            if (!$ecom) {
                                $ecom = new EconomicComplement;

                                if ($last_ecom = EconomicComplement::whereYear('year', '=', Carbon::parse($result->c_year)->year)
                                                    ->where('semester', '=', $result->c_semestre)
                                                    ->whereNull('deleted_at')->orderBy('id', 'desc')->first()) {
                                    $number_code = Util::separateCode($last_ecom->code);
                                    $code = $number_code + 1;
                                }else{
                                    $code = 1;
                                }

                                $sem='S';                                
                                $ecom->user_id = 1;
                                $ecom->affiliate_id = $afi->id;                 
                                $ecom->eco_com_modality_id = $result->c_eco_com_modality_id;
                                $ecom->eco_com_state_id = $result->c_eco_com_state_id;
                                $ecom->eco_com_procedure_id = 1;
                                $ecom->workflow_id = 1;
                                $ecom->wf_current_state_id = 7;
                                $ecom->city_id = $result->$c_city_id;
                                $ecom->category_id = $result->c_category_id;                                
                                $ecom->year = Carbon::createFromDate(Carbon::parse($result->c_year)->year, 7, 1);
                                $ecom->semester = $result->c_semestre;
                                $ecom->code = $code ."/". $sem . "/" . Cabon::parse($result->c_year)->year;                                                           
                                $ecom->reception_date = Carbon::createFromDate(Carbon::parse($result->c_year)->year, 7, 1);
                                $ecom->state = 'Edited';
                                $ecom->sub_total_rent = $result->sub_total_rent;
                                $ecom->dignity_pension = $result->dignity_pension;
                                $ecom->total_rent = $result->total_rent;
                                $ecom->total_rent_calc = $result->total_rent_calc;
                                $ecom->salary_reference = $result->salary_reference;
                                $ecom->seniority = $result->seniority;                                
                                $ecom->salary_quotable = $result->salary_quotable;
                                $ecom->difference = $result->difference;
                                $ecom->complementary_factor = $result->complementary_factor;
                                $ecom->reimbursement = $result->reimbursement;                        
                                $ecom->total = $result->total;          
                                //$ecom->save();

                            }

                            $app = EconomicComplementApplicant::economicComplementIs($ecom->id)->first();
                            if(!$app){
                                $app = new EconomicComplementApplicant; 
                                $app->economic_complement_id = $ecom->id;
                            }               
                            $app->city_identity_card_id = $result->ap_city_identity_card_id;
                            $app->identity_card = $result->ap_identity_card;
                            $app->last_name = $result->ap_last_name;
                            $app->mothers_last_name = $result->ap_mothers_last_name;
                            $app->first_name = $result->ap_first_name;
                            $app->second_name = $result->ap_second_name;
                            $app->surname_husband = $result->ap_surname_husband;
                            $app->birth_date = $result->ap_birth_date;
                            $app->nua = $result->ap_nua;
                            $app->gender = $result->ap_gender;
                            $app->civil_status = $result->ap_civil_status;
                            $app->phone_number = $result->ap_phone_number;
                            $app->cell_phone_number = $result->ap_cell_phone_number;
                            //$app->save();

                            if($ecom->c_tipo == 1)
                            {
                                $vej ++;
                            }                        

                            else if($ecom->c_tipo == 2) // create spouse
                            {   $spouse = Spouse::where('affiliate_id','=', $afi->id)
                                if (!$spouse)
                                {
                                    $spouse = new Spouse;
                                    $spouse->user_id = 1;
                                    $spouse->affiliate_id = $affiliate->id;
                                }
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
                                //$spouse->save();
                                $viu++;                               
                            }
                            else{
                                $orf++;
                            }

                    });

                });

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;

                $Progress->finish();

                $this->info("\n\nReport Update:\n
                $vej update Applicante Vejez.\n
                $viu update Applicante Viudadedad.\n
                $orf orfandad.\n
                Execution time $execution_time [minutes].\n");
            }

        }
        else{
            $this->error('Incorrect password!');
            exit();
        }


    }
}
