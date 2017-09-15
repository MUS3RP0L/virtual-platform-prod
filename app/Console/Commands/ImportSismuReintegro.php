<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Log;
use DB;
use Util;
use Muserpol\Reimbursement;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ImportSismuReintegro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sismu_reintegro';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $Progress, $affi_succ, $affi_no,$degree_count,$category_count, $affiliate_no,$contri_exist, $years, $months;
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
                        global $Progress, $affi_succ, $affi_no,$degree_count,$category_count,$affiliate_no, $contri_exist, $years, $months;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $ci = trim($result->ci);
                        $affi=Affiliate::where('identity_card','like',$ci)->first();
                        // $affi=DB::table('affiliates')->whereRaw("split_part(affiliates.identity_card, '-',1) like '".$ci."'")->first();
                        if ($affi) {
                            $year=$result->anio;
                            $month=$result->mes;        
                            $reimnursement=Reimbursement::where('affiliate_id','=',$affi->id)->whereRaw("extract(year from month_year) = ".$year."")->first();
                            if ($reimnursement) {
                                $reimnursement_month=explode(',', $reimnursement->months);
                                if (in_array($month,($reimnursement_month))) {
                                    // $this->info("existe");

                                }else{
                                    $reimnursement->month_year = Carbon::create($year, $month,1,0,0,0);
                                    $reimnursement->base_wage = 0;
                                    $reimnursement->seniority_bonus = $reimnursement->seniority_bonus + $result->antiguedad;
                                    $reimnursement->study_bonus = $reimnursement->study_bonus + $result->estudio;
                                    $reimnursement->position_bonus = $reimnursement->position_bonus + $result->cargo;
                                    $reimnursement->border_bonus = $reimnursement->border_bonus + $result->frontera;
                                    $reimnursement->east_bonus = $reimnursement->east_bonus + $result->oriente;
                                    $reimnursement->gain = 0;
                                    $reimnursement->quotable = $reimnursement->quotable + $result->cotizable;
                                    $reimnursement->retirement_fund = $reimnursement->retirement_fund + $result->fr;
                                    $reimnursement->mortuary_quota = $reimnursement->mortuary_quota + $result->cm;
                                    $reimnursement->subtotal = $reimnursement->subtotal + $result->subtotal;
                                    $reimnursement->ipc = $reimnursement->ipc + $result->ipc;
                                    $reimnursement->total = $reimnursement->total + $result->total;
                                    $array=explode(',', $reimnursement->months);
                                    array_push($array, intval($month));
                                    $array=implode(',', $array);    
                                    $reimnursement->months=$array;
                                    $reimnursement->save();
                                }
                            }else{
                                $reimnursement =new Reimbursement;
                                $reimnursement->user_id = 1;
                                $reimnursement->type = 'Directo';
                                $reimnursement->affiliate_id = $affi->id;
                                $reimnursement->month_year = Carbon::create($year, $month,1,0,0,0);
                                $reimnursement->base_wage = 0;
                                $reimnursement->seniority_bonus = $result->antiguedad;
                                $reimnursement->study_bonus = $result->estudio;
                                $reimnursement->position_bonus = $result->cargo;
                                $reimnursement->border_bonus = $result->frontera;
                                $reimnursement->east_bonus = $result->oriente;
                                $reimnursement->gain = 0;
                                $reimnursement->quotable = $result->cotizable;
                                $reimnursement->retirement_fund = $result->fr;
                                $reimnursement->mortuary_quota = $result->cm;
                                $reimnursement->payable_liquid = 0;
                                $reimnursement->mortuary_aid = 0;
                                $reimnursement->subtotal = $result->subtotal;
                                $reimnursement->ipc = $result->ipc;
                                $reimnursement->total = $result->total;
                                $reimnursement->months=implode(',',array(intval($month)));
                                $reimnursement->save();
                            }
                            $affi_succ++;
                        }else{
                            $affiliate_no[]= array(
                                'ci' => $result->ci,
                                'grado'=>$result->grado,
                                'anio'=>$result->anio,
                                'mes'=>$result->mes,
                                'total'=>$result->total
                            );
                            $affi_no++;
                        }
                        $Progress->advance();
                    });
                });
                // dd($affiliate_no);
                // Excel::create('Lista Afiliados que ya existe sus Contribuciones '.date("Y-m-d H:i:s"),function($excel)
                // {
                //     global $contri_exist;
                //     $excel->sheet('existing contributions',function($sheet){
                //         global $contri_exist;
                //         $sheet->fromArray($contri_exist);
                //     });
                // })->store('xls', storage_path('excel/exports'));
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();
                $this->info("\n\n ---------\n
                    $affi_succ Affiliates Found\n
                    \tGrados no Encontrados: $degree_count\n
                    \tCategorias no Encontradas: $category_count \n
                    \tAffiliates NOT found $affi_no\n
                Execution time $execution_time [minutes].\n");
            }
       }else {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
