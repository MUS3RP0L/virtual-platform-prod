<?php

namespace Muserpol\Console\Commands;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Muserpol\AffiliateState;
use Muserpol\AffiliateStateType;
use Muserpol\City;
use Muserpol\Degree;
use Muserpol\Unit;
use Muserpol\Category;
use Muserpol\PensionEntity;
use Muserpol\Spouse;


use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementState;
use Muserpol\EconomicComplementStateType;
use Muserpol\EconomicComplementModality;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementProcedure;
use Muserpol\EconomicComplementLegalGuardian;

class importfinal extends Command implements SelfHandling
{
    protected $signature = 'set1:importfinal';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

        global $Progress,$vej, $viu, $orf,$afi,$app,$eco_com;

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

                            global $Progress,$vej, $viu, $orf,$afi,$app,$eco_com;
                            ini_set('memory_limit', '-1');
                            ini_set('max_execution_time', '-1');
                            ini_set('max_input_time', '-1');
                            set_time_limit('-1');
                            $Progress->advance();

                            //$afi = Affiliate::All();
                            if ($result->tipo_complemento == 1)
                            {

                                $afi = new Affiliate;  //copy aplicant to afi
                                $afi->user_id = 1;
                                $afi->affiliate_state_id = 1;
                                $afi->city_identity_card_id = $result->city_identity_card_id;
                                $afi->city_birth_id = $result->city_birth_id;
                                $afi->degree_id = $result->degree_id;
                                $afi->unit_id = $result->unit_id;
                                $afi->category_id = $result->category_id;
                                $afi->pension_entity_id = $result->pension_entity_id;
                                $afi->identity_card = $result->identity_card;
                                $afi->registration ='0';
                                $afi->type = 'Comando';
                                $afi->last_name = $result->last_name;
                                $afi->mothers_last_name = $result->mothers_last_name;
                                $afi->first_name = $result->first_name;
                                $afi->second_name = $result->second_name;
                                $afi->surname_husband = $result->surname_husband;
                                $afi->gender = $result->gender;
                                $afi->civil_status = $result->civil_status;
                                $afi->birth_date = $result->birth_date;
                                $afi->nua = $result->nua;
                                $afi->change_date = Carbon::now();
                                $afi->phone_number = $result->phone_number;
                                $afi->cell_phone_number = $result->cell_phone_number;
                                $afi->save();

                                $eco_com = new EconomicComplement;
                                $eco_com->user_id = 1;
                                $eco_com->affiliate_id = $result->affiliate_id;
                                $eco_com->eco_com_modality_id = $result->eco_com_modality_id;
                                $eco_com->eco_com_state_id = $result->eco_com_state_id;
                                $eco_com->eco_com_procedure_id = 1;
                                $eco_com->workflow_id = 1;
                                $eco_com->wf_current_state_id = 7;
                                $eco_com->city_id = $result->regional_id;
                                $eco_com->category_id = $result->eco_com_categoria;
                                $eco_com->year = $result->year;
                                $eco_com->semester = $result->semester;
                                $eco_com->code = $result->code;
                                //$eco_com->reception_date = $result->reception_date;
                                $eco_com->reception_date = $result->year;
                                $eco_com->state = 'Edited';
                                $eco_com->sub_total_rent = $result->sub_total_rent;
                                $eco_com->dignity_pension = $result->dignity_pension;
                                $eco_com->total_rent = $result->total_rent;
                                $eco_com->total_rent_calc = $result->total_rent_calc;
                                $eco_com->salary_reference = $result->salary_reference;
                                $eco_com->seniority = $result->seniority;
                                $eco_com->salary_quotable = $result->salary_quotable;
                                $eco_com->difference = $result->difference;
                                //$eco_com->total_amount_semester = $result->total_amount_semester;
                                $eco_com->complementary_factor = $result->complementary_factor;
                                $eco_com->reimbursement = $result->reimbursement;
                                $eco_com->total = $result->total;
                                $eco_com->save();

                                $app = new EconomicComplementApplicant;
                                $app->economic_complement_id = $result->id;
                                $app->identity_card = $result->identity_card;
                                $app->city_identity_card_id = $result->city_identity_card_id;
                                $app->first_name = $result->first_name;
                                $app->second_name = $result->second_name;
                                $app->last_name = $result->last_name;
                                $app->mothers_last_name = $result->mothers_last_name;
                                $app->surname_husband = $result->surname_husband;
                                $app->birth_date = $result->birth_date;
                                $app->nua = $result->nua;
                                $app->gender = $result->gender;
                                $app->civil_status = $result->civil_status;
                                $app->phone_number = $result->phone_number;
                                $app->cell_phone_number = $result->cell_phone_number;
                                $app->save();
                                $vej++;
                            }
                            elseif($result->tipo_complemento == 2)
                            {
                                $afi = new Affiliate;   // afi to afi
                                $afi->user_id = 1;
                                $afi->affiliate_state_id = 1;
                                $afi->city_identity_card_id = $result->afi_city_ci;
                                $afi->city_birth_id = $result->city_birth_id;
                                $afi->degree_id = $result->degree_id;
                                $afi->unit_id = $result->unit_id;
                                $afi->category_id = $result->category_id;
                                $afi->pension_entity_id = $result->pension_entity_id;
                                $afi->identity_card = $result->afi_ci;
                                $afi->registration ='0';
                                $afi->type = 'Comando';

                                $afi->first_name = $result->afi_first_name;
                                $afi->second_name = $result->afi_second_name;
                                $afi->last_name = $result->afi_last_name;
                                $afi->mothers_last_name = $result->afi_mothers_last_name;
                                $afi->surname_husband = $result->afi_surname_husband;
                                $afi->nua = $result->afi_nua;
                                $afi->birth_date = $result->afi_birth_date;
                                $afi->gender = $result->afi_gender;
                                $afi->civil_status = $result->afi_civil_status;
                                $afi->change_date = Carbon::now();
                                $afi->phone_number = $result->afi_phone_number;
                                $afi->cell_phone_number = $result->afi_cell_phone_number;
                                $afi->save();

                                $spouse = new Spouse;     // copy de aplicants a spouse
                                $spouse->user_id = 1;
                                $spouse->affiliate_id = $result->affiliate_id;
                                $spouse->city_identity_card_id =  $result->city_identity_card_id;
                                $spouse->identity_card = $result->identity_card;
                                $spouse->registration ='0';
                                $spouse->first_name = $result->first_name;
                                $spouse->second_name = $result->second_name;
                                $spouse->last_name = $result->last_name;
                                $spouse->mothers_last_name = $result->mothers_last_name;
                                $spouse->surname_husband = $result->surname_husband;
                                $spouse->birth_date = $result->birth_date;
                                $spouse->save();

                                $eco_com = new EconomicComplement;   //copy eco_com a eco_com
                                $eco_com->user_id = 1;
                                $eco_com->affiliate_id = $result->affiliate_id;
                                $eco_com->eco_com_modality_id = $result->eco_com_modality_id;
                                $eco_com->eco_com_state_id = $result->eco_com_state_id;
                                $eco_com->eco_com_procedure_id = 1;
                                $eco_com->workflow_id = 1;
                                $eco_com->wf_current_state_id = 7;
                                $eco_com->city_id = $result->regional_id;
                                $eco_com->category_id = $result->eco_com_categoria;
                                $eco_com->year = $result->year;
                                $eco_com->semester = $result->semester;
                                $eco_com->code = $result->code;
                                //$eco_com->reception_date = $result->reception_date;
                                $eco_com->reception_date = $result->year;
                                $eco_com->state = 'Edited';
                                $eco_com->sub_total_rent = $result->sub_total_rent;
                                $eco_com->dignity_pension = $result->dignity_pension;
                                $eco_com->total_rent = $result->total_rent;
                                $eco_com->total_rent_calc = $result->total_rent_calc;
                                $eco_com->salary_reference = $result->salary_reference;
                                $eco_com->seniority = $result->seniority;
                                $eco_com->salary_quotable = $result->salary_quotable;
                                $eco_com->difference = $result->difference;
                                //$eco_com->total_amount_semester = $result->total_amount_semester;
                                $eco_com->complementary_factor = $result->complementary_factor;
                                $eco_com->reimbursement = $result->reimbursement;
                                $eco_com->total = $result->total;
                                $eco_com->save();

                                $app = new EconomicComplementApplicant; //copy applicant to applicant
                                $app->economic_complement_id = $result->id;
                                $app->city_identity_card_id = $result->city_identity_card_id;
                                $app->identity_card = $result->identity_card;
                                $app->first_name = $result->first_name;
                                $app->second_name = $result->second_name;
                                $app->last_name = $result->last_name;
                                $app->mothers_last_name = $result->mothers_last_name;
                                $app->surname_husband = $result->surname_husband;
                                $app->birth_date = $result->birth_date;
                                $app->nua = $result->nua;
                                $app->gender = $result->gender;
                                $app->civil_status = $result->civil_status;
                                $app->phone_number = $result->phone_number;
                                $app->cell_phone_number = $result->cell_phone_number;
                                $app->save();
                                $viu++;
                            }
                            else {

                                $afi = new Affiliate;  //  afi to afi
                                $afi->user_id = 1;
                                $afi->affiliate_state_id = 1;
                                $afi->city_identity_card_id = $result->afi_city_ci;
                                $afi->city_birth_id = $result->city_birth_id;
                                $afi->degree_id = $result->degree_id;
                                $afi->unit_id = $result->unit_id;
                                $afi->category_id = $result->category_id;
                                $afi->pension_entity_id = $result->pension_entity_id;
                                $afi->identity_card = $result->afi_ci;
                                $afi->registration ='0';
                                $afi->type = 'Comando';

                                $afi->first_name = $result->afi_first_name;
                                $afi->second_name = $result->afi_second_name;
                                $afi->last_name = $result->afi_last_name;
                                $afi->mothers_last_name = $result->afi_mothers_last_name;
                                $afi->surname_husband = $result->afi_surname_husband;
                                $afi->gender = $result->afi_gender;
                                $afi->birth_date = $result->afi_birth_date;
                                $afi->nua = $result->afi_nua;
                                $afi->civil_status = $result->afi_civil_status;
                                $afi->change_date = Carbon::now();
                                $afi->phone_number = $result->afi_phone_number;
                                $afi->cell_phone_number = $result->afi_cell_phone_number;
                                $afi->save();

                                $eco_com = new EconomicComplement;   //copy eco_com a eco_com
                                $eco_com->user_id = 1;
                                $eco_com->affiliate_id = $result->affiliate_id;
                                $eco_com->eco_com_modality_id = $result->eco_com_modality_id;
                                $eco_com->eco_com_state_id = $result->eco_com_state_id;
                                $eco_com->eco_com_procedure_id = 1;
                                $eco_com->workflow_id = 1;
                                $eco_com->wf_current_state_id = 7;
                                $eco_com->city_id = $result->regional_id;
                                $eco_com->category_id = $result->eco_com_categoria;
                                $eco_com->year = $result->year;
                                $eco_com->semester = $result->semester;
                                $eco_com->code = $result->code;
                                $eco_com->reception_date = Carbon::now();
                                $eco_com->reception_date = $result->year;
                                $eco_com->state = 'Edited';
                                $eco_com->sub_total_rent = $result->sub_total_rent;
                                $eco_com->dignity_pension = $result->dignity_pension;
                                $eco_com->total_rent = $result->total_rent;
                                $eco_com->total_rent_calc = $result->total_rent_calc;
                                $eco_com->salary_reference = $result->salary_reference;
                                $eco_com->seniority = $result->seniority;
                                $eco_com->salary_quotable = $result->salary_quotable;
                                $eco_com->difference = $result->difference;
                                //$eco_com->total_amount_semester = $result->total_amount_semester;
                                $eco_com->complementary_factor = $result->complementary_factor;
                                $eco_com->reimbursement = $result->reimbursement;
                                $eco_com->total = $result->total;
                                $eco_com->save();

                                $app = new EconomicComplementApplicant; //copy applicant to applicant
                                $app->economic_complement_id = $result->id;
                                $app->city_identity_card_id = $result->city_identity_card_id;
                                $app->identity_card = $result->identity_card;
                                $app->first_name = $result->first_name;
                                $app->second_name = $result->second_name;
                                $app->last_name = $result->last_name;
                                $app->mothers_last_name = $result->mothers_last_name;
                                $app->surname_husband = $result->surname_husband;
                                $app->birth_date = $result->birth_date;
                                $app->nua = $result->nua;
                                $app->gender = $result->gender;
                                $app->civil_status = $result->civil_status;
                                $app->phone_number = $result->phone_number;
                                $app->cell_phone_number = $result->cell_phone_number;
                                $app->save();
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
    }
}
