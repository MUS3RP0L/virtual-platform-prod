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
        global $NewAffi, $UpdateAffi, $NewContri, $Progress, $FolderName, $Date;

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

                        global $NewAffi, $UpdateAffi, $NewContri, $Progress, $FolderName, $Date;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');

                        if ($result->tiporenta == 'VEJEZ' or $result->tiporenta == 'RENT-M2000-VEJ' or $result->tiporenta == 'RENT-1COM-M2000-VEJ' or $result->tiporenta == 'RENT-1COMP-VEJ') {
                            
                            $degree_id = Degree::select('id')->where('shortened', $result->grado)->first()->id;
                           
                            $pension_entity_id = PensionEntity::select('id')->where('shortened', $result->ente_gestor)->first()->id;
                            
                            $category_id = Category::select('id')->where('name', $result->categoria)->first()->id;

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
                        
                        $table->enum('civil_status', ['C', 'S', 'V', 'D']);


                            $affiliate = Affiliate::where('identity_card', '=', Util::zero($result->ci))->first();

                            if (!$affiliate) {

                                $affiliate = new Affiliate;
                                $affiliate->identity_card = Util::zero($result->ci);
                                // $affiliate->gender = $result->sex;
                                $NewAffi ++;

                            }
                            else{$UpdateAffi ++;}

                            $affiliate->degree_id = $degree_id;
                            $affiliate->pension_entity_id = $pension_entity_id;
                            $affiliate->category_id = $category_id;
                            $affiliate->civil_status = $eciv;

                            $affiliate->last_name = $result->pat;
                            $affiliate->mothers_last_name = $result->mat;
                            $affiliate->first_name = $result->pnom;
                            $affiliate->second_name = $result->snom;
                            $affiliate->surname_husband = $result->apes;

                            $affiliate->birth_date = Util::datePic($fecha_nac);
                            // $affiliate->registration = Util::CalcRegistration($affiliate->birth_date, $affiliate->last_name, $affiliate->mothers_last_name, $affiliate->first_name, $affiliate->gender);
                            $affiliate->save();

                        }
                        else {

                        }

                    });

                });

                $time_end = microtime(true);

                $execution_time = ($time_end - $time_start)/60;

                $TotalAffi = $NewAffi + $UpdateAffi;
                $TotalNewAffi = $NewAffi ? $NewAffi : "0";
                $TotalUpdateAffi = $UpdateAffi ? $UpdateAffi : "0";
                $TotalAffi = $TotalAffi ? $TotalAffi : "0";
                $TotalNewContri = $NewContri ? $NewContri : "0";

                $Progress->finish();

                $this->info("\n\nReport $Date:\n
                    $TotalNewAffi new affiliates.\n
                    $TotalUpdateAffi affiliates successfully updated.\n
                    Total $TotalAffi affiliates.\n
                    Total $TotalNewContri entered contributions.\n
                    Execution time $execution_time [minutes].\n");

                \Storage::disk('local')->put('ImportPayroll_'. $Date.'.txt', "Reporte de Importacion Afiliados y Aportes:\r\n
                    $TotalNewAffi new affiliates.\r\n
                    $TotalUpdateAffi affiliates successfully updated.\r\n
                    Total $TotalAffi affiliates.\r\n
                    Total $TotalNewContri entered contributions.\r\n
                    Execution time $execution_time [minutes].\r\n");

            }
        }
        else{
            $this->error('Incorrect password!');
            exit();
        }

    }
}
