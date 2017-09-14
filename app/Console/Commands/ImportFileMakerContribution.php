<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Log;
use DB;
use Util;
use Muserpol\Contribution;
use Muserpol\ContributionRate;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ImportFileMakerContribution extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:file_maker_activo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importacion de afiliados de file maker PASIVO';

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
        // dd(Util::getDegreeId_name("hola"));
       global $Progress, $affi_succ, $affi_no,$degree_count, $affiliate_no;
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
                        global $Progress, $affi_succ, $affi_no,$degree_count,$affiliate_no;
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
                            if (Util::getDegreeId_name($result->grado) != "error" ) {
                                $degree=Util::getDegreeId_name($result->grado);
                            }else{
                                Log::info($result->grado);
                                $degree_count++;
                            }
                            $amount=$result->monto;
                            $contribution=Contribution::where('affiliate_id','=',$affi->id)->whereRaw("extract(year from month_year) = ".$year."")->whereRaw("extract(month from month_year) = ".$month."")->first();
                            if ($contribution) {
                                // Log::info("------Existe ". $ci." ".$year."-".$month );
                            }else{
                                // Log::info("********** NO Existe ".$ci);
                                $contribution_rate = ContributionRate::whereRaw("extract(year from month_year) = ".$year)->whereRaw("extract(month from month_year) = ".$month)->first();
                                $contri =new Contribution;
                                $contri->user_id = 1;
                                $contri->type = 'Directo';
                                $contri->affiliate_id = $affi->id;
                                $contri->degree_id = $degree;
                                $percentage = round(($contribution_rate->retirement_fund + $contribution_rate->mortuary_quota) * 100, 1);
                                $contri->month_year = Carbon::create($year, $month,1,0,0,0);
                                $contri->retirement_fund = $amount * $contribution_rate->retirement_fund / $percentage * 100;
                                $contri->mortuary_quota = $amount * $contribution_rate->mortuary_quota / $percentage * 100;
                                $contri->total = $amount;
                                $contri->base_wage = 0;
                                $contri->seniority_bonus = 0;
                                $contri->study_bonus = 0;
                                $contri->position_bonus = 0;
                                $contri->border_bonus = 0;
                                $contri->east_bonus = 0;
                                $contri->gain = 0;
                                $contri->quotable = 0;
                                $contri->save();
                                // dd($contri);
                            }
                            $affi_succ++;
                        }else{
                            $affiliate_no[]= array(
                                'ci' => $result->ci,
                                'nombre'=>$result->nombre,
                                'paterno'=>$result->paterno,
                                'materno'=>$result->materno,
                                'grado'=>$result->grado,
                                'anio'=>$result->anio,
                                'mes'=>$result->mes,
                                'monto'=>$result->monto
                            );
                            $affi_no++;
                        }
                        $Progress->advance();
                    });
                });
                // dd($affiliate_no);
                Excel::create('Lista Afiliados NO importados de File Maker'.date("Y-m-d H:i:s"),function($excel) use($affiliate_no)
                {
                    global $affiliate_no;
                    $excel->sheet('afiliados no importados',function($sheet) use($affiliate_no){
                        global $affiliate_no;
                        $sheet->fromArray($affiliate_no);
                    });
                })->store('xls', storage_path('excel/exports'));
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();
                $this->info("\n\n ---------\n
                    $affi_succ Affiliates Found\n
                    \tGrados no Encontrados: $degree_count\n
                    \tAffiliates NOT found $affi_no\n


                Execution time $execution_time [minutes].\n");

            }
       }else {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
