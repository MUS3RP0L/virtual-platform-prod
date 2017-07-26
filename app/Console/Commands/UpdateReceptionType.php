<?php
namespace Muserpol\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

use DB;
use Muserpol\Affiliate;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementModality;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementProcedure;

use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;

class UpdateReceptionType extends Command implements SelfHandling
{
    protected $signature = 'update:reception_type';
    protected $description = 'Actualiza el tipo de recepcion en [Habitual, inclusion]';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        global $Progress,$count_modalities, $count_semesters, $count_inc ;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
            $year = $this->ask('Enter the year');
            $semester = $this->choice('Enter the semester', ['Primer', 'Segundo']);
            if($year > 0 and $semester != null)
            {
                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                $economic_complements = EconomicComplement::whereYear('year','=',$year)->where('semester','=',$semester)->get();
                foreach ($economic_complements as $eco) {
                    // temp 
                    if (Util::getCurrentSemester() == 'Primer') {
                        $last_semester_first = 'Segundo';
                        $last_semester_second = 'Primer';
                        $last_year_first = Carbon::now()->year - 1; 
                        $last_year_second = $last_year_first;
                    }else{
                        $last_semester_first = 'Primer';
                        $last_semester_second = 'Segundo';
                        $last_year_first = Carbon::now()->year ;
                        $last_year_second = $last_year_first -1;
                    }
                    $reception_type = 'Inclusion';
                    $affiliate_id = $eco->affiliate_id;
                    $last_procedure_second = EconomicComplementProcedure::whereYear('year', '=', $last_year_second)->where('semester','like',$last_semester_second)->first();
                    if (sizeof($last_procedure_second)>0) {
                        if ($old_eco = $last_procedure_second->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                            $reception_type = 'Habitual';
                            if ($old_eco->economic_complement_modality->economic_complement_type->id == 1 && ($eco->economic_complement_modality->economic_complement_type->id == 2||$eco->economic_complement_modality->economic_complement_type->id == 3)) {
                                $reception_type = 'Inclusion';
                                $count_modalities++;
                            }elseif ($old_eco->economic_complement_modality->economic_complement_type->id == 2 &&  $eco->economic_complement_modality->economic_complement_type->id  == 3) {
                                    $reception_type = 'Inclusion';
                                    $count_modalities++;
                            }else{
                                $count_semesters++;
                            }
                        }
                    }else{
                        $count_inc++;
                    }
                    $last_procedure_first = EconomicComplementProcedure::whereYear('year', '=', $last_year_first)->where('semester','like',$last_semester_first)->first();
                    if (sizeof($last_procedure_first)>0) {
                        if ($old_eco = $last_procedure_first->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                            $reception_type = 'Habitual';
                            if ($old_eco->economic_complement_modality->economic_complement_type->id == 1 && ($eco->economic_complement_modality->economic_complement_type->id == 2 || $eco->economic_complement_modality->economic_complement_type->id == 3)) {
                                $reception_type = 'Inclusion';
                                $count_modalities++;
                            }elseif ($old_eco->economic_complement_modality->economic_complement_type->id == 2 &&  $eco->economic_complement_modality->economic_complement_type->id  == 3) {
                                    $reception_type = 'Inclusion';
                                    $count_modalities++;
                            }else{
                                $count_semesters++;
                            }
                        }
                    }else{
                        $count_inc++;
                    }
                    
                    $eco->reception_type = $reception_type;
                    // /temp 
                    
                    $eco->save();
                    $Progress->advance();
                }
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();
                $this->info("\n\n
                Actualizados por modalidad: $count_modalities (Inclusion - de vejez a viudedad) \n
                Actualizados por semestre: $count_semesters (habitual)\n
                Actualizados a inclusiones: $count_inc (vejez y viudedad)\n
                Execution time $execution_time [minutes].\n");
            }
        }else {
           $this->error('Incorrect password!');
           exit();
        }
    }
}
