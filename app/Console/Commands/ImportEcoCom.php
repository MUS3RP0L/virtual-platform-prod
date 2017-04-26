<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

use Muserpol\Affiliate;
use Muserpol\Degree;
use Muserpol\Category;
use Muserpol\PensionEntity;
use Muserpol\City;
use Muserpol\Spouse;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementModality;

class ImportEcoCom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ecocom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Eco com';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $Progress, $FolderName;

        $password = $this->ask('Enter the password');

        if ($password == ACCESS) {

            $FolderName = $this->ask('Enter the name of the folder you want to import');

            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {

                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%");

                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) {

                    $rows->each(function($result) {

                        global $Progress, $FolderName;

                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');

                        if ($result->grado == 'CNL.') {
                            $degree_id = 7;

                        }elseif ($result->grado == 'GRAL.') {
                           $degree_id = 5;
                        }else{
                            $degree_id = Degree::select('id')->where('shortened', $result->grado)->first()->id;
                        }

                        $pension_entity_id = PensionEntity::select('id')->where('name', $result->ente_gestor)->first()->id;
                            
                        $category_id = Category::select('id')->where('percentage', $result->categoria)->first()->id;
                        
                        switch ($result->eciv) {

                            case 'CASADO(A)':
                                $eciv = "C";
                            break;

                            case 'DIVORCIADO(A)':
                                $eciv = "D";
                            break;

                            case 'SOLTERO(A)':
                                $eciv = "S";
                            break;

                            case 'VIUDO(A)':
                                $eciv = "V";
                            break;

                        }

                        if ($result->tiporenta == 'VEJEZ' or $result->tiporenta == 'RENT-M2000-VEJ' or $result->tiporenta == 'RENT-1COM-M2000-VEJ' or $result->tiporenta == 'RENT-1COMP-VEJ') {                          
                
                            $affiliate = Affiliate::where('identity_card', '=', Util::zero($result->ci))->first();

                            if (!$affiliate) {

                                $affiliate = new Affiliate;
                                $affiliate->identity_card = Util::zero($result->ci);
                                $city_id = City::select('id')->where('shortened', $result->ext)->first()->id;
                                $affiliate->city_identity_card_id = $city_id;
                                $affiliate->gender = "M";

                            }

                            $affiliate->user_id = 1;
                            $affiliate->affiliate_state_id = 5;
                            $affiliate->affiliate_type_id = 1;
                            $affiliate->registration = "0";

                            $affiliate->degree_id = $degree_id;
                            $affiliate->pension_entity_id = $pension_entity_id;
                            $affiliate->category_id = $category_id;
                            $affiliate->civil_status = $eciv;

                            $affiliate->last_name = $result->pat;
                            $affiliate->mothers_last_name = $result->mat;
                            $affiliate->first_name = $result->pnom;
                            $affiliate->second_name = $result->snom;
                            $affiliate->surname_husband = $result->apes;

                            $affiliate->change_date = Carbon::now();

                            $affiliate->birth_date = $result->fecha_nac;

                            $affiliate->save();

                        }
                        else {

                            $affiliate = Affiliate::where('identity_card', '=', Util::zero($result->ci_ch))->first();

                            if (!$affiliate) {

                                $affiliate = new Affiliate;
                                $affiliate->identity_card = Util::zero($result->ci_ch);
                                $city_id = City::select('id')->where('shortened', $result->ext_ch)->first()->id;
                                $affiliate->city_identity_card_id = $city_id;
                                $affiliate->gender = "F";

                            }

                            $affiliate->user_id = 1;
                            $affiliate->affiliate_state_id = 4;
                            $affiliate->affiliate_type_id = 1;
                            $affiliate->registration = "0";

                            $affiliate->degree_id = $degree_id;
                            $affiliate->pension_entity_id = $pension_entity_id;
                            $affiliate->category_id = $category_id;
                            $affiliate->civil_status = $eciv;

                            $affiliate->last_name = $result->pat_ch;
                            $affiliate->mothers_last_name = $result->mat_ch;
                            $affiliate->first_name = $result->pnombre_ch;
                            $affiliate->second_name = $result->snombre_ch;
                            $affiliate->surname_husband = $result->apes_ch;

                            $affiliate->change_date = Carbon::now();

                            $affiliate->save();

                            $spouse = new Spouse;
                            $spouse->user_id = 1;
                            $spouse->affiliate_id = $affiliate->id;
                            $spouse->identity_card = Util::zero($result->ci_ch);
                            $city_id = City::select('id')->where('shortened', $result->ext_ch)->first()->id;
                            $spouse->city_identity_card_id = $city_id;
                            $spouse->registration = "0";

                            $spouse->last_name = $result->pat;
                            $spouse->mothers_last_name = $result->mat;
                            $spouse->first_name = $result->pnom;
                            $spouse->second_name = $result->snom;
                            $spouse->surname_husband = $result->apes;

                            $spouse->birth_date = $result->fecha_nac;

                            $spouse->save();

                        }

                        $economic_complement = EconomicComplement::affiliateIs($affiliate->id)
                                    ->whereYear('year', '=', $result->gestion)
                                    ->where('semester', '=', $result->semestre)->first();

                        if (!$economic_complement) {
                            $economic_complement = new EconomicComplement;

                            if ($last_economic_complement = EconomicComplement::whereYear('year', '=', $result->gestion)
                                                ->where('semester', '=', "Segundo")
                                                ->whereNull('deleted_at')->orderBy('id', 'desc')->first()) {
                                $number_code = Util::separateCode($last_economic_complement->code);
                                $code = $number_code + 1;
                            }else{
                                $code = 1;
                            }

                            $sem='S';

                            $economic_complement->code = $code ."/". $sem . "/" . $result->gestion;
                            $economic_complement->affiliate_id = $affiliate->id;
                            $economic_complement->year = Util::datePickYear($result->gestion, $result->semestre);
                            $economic_complement->semester = "Segundo";
                            if ($result->beneficiario == 'PLANILLA GENERAL') {
                                $economic_complement->eco_com_state_id = 6;
                            }
                            else {
                                $economic_complement->eco_com_state_id = 8;
                            }
                           
                            $economic_complement->user_id = 1;

                            $eco_com_modality = EconomicComplementModality::where('shortened', $result->tiporenta)->first();

                            $economic_complement->eco_com_modality_id = $eco_com_modality->id;
                            $economic_complement->category_id = $affiliate->category_id;

                            $city_id = City::select('id')->where('name', $result->regional)->first()->id;
                            $economic_complement->city_id = $city_id;
                            $economic_complement->save();
                        }


                        $Progress->advance();

                    });

                });

                $time_end = microtime(true);

                $Progress->finish();

            }
        }
        else{
            $this->error('Incorrect password!');
            exit();
        }

    }
}
