<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Muserpol\Breakdown;
use Muserpol\Unit;
use Muserpol\Hierarchy;
use Muserpol\Degree;
use Muserpol\Category;
use Muserpol\Reimbursement;
use Muserpol\ContributionRate;
use Muserpol\Contribution;
use DB;
use Util;
use Log;

use Carbon\Carbon;

class ImportReimbursement2018 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:reimbursement2018';

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
        
        global $Progress, $aficount,$afincount,$affiliate_no, $search_ci;
             $password = $this->ask('Enter the password');
             if ($password == ACCESS) {
                 $FolderName = $this->ask('Enter the name of the folder you want to import');
                 
                 if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {
                     
                    $carnet = $this->choice('Buscar afiliados SIN extension?', ['SI', 'NO']);
                    $this->info($carnet);
                    if($carnet == "SI"){
                        $search_ci = true;
                    }else{
                        $search_ci = false;
                    }
                     $time_start = microtime(true);
                     $this->info("Working...\n");
                     $Progress = $this->output->createProgressBar();
                     $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                     Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) {
                         $rows->each(function($result) {
                                 global $Progress,$aficount, $afincount, $affiliate_no, $search_ci;
                                 ini_set('memory_limit', '-1');
                                 ini_set('max_execution_time', '-1');
                                 ini_set('max_input_time', '-1');
                                 set_time_limit('-1');

                                 $ci=$result->car;                                                             
                                 $month = $result->mes ? (($result->mes=="re") ? 6 : intval($result->mes)) : 0;
                                 $year = $result->a_o ? intval($result->a_o)+2000: 0;
                                 $month_year = Carbon::createFromDate($year, $month, 1)->toDateString();

                                if($search_ci){
                                    $afi=DB::table('affiliates')->whereRaw("ltrim(split_part(affiliates.identity_card, '-',1), '0') like '".(explode("-",ltrim(trim($ci), "0"))[0])."'")->first();
                                }else{
                                    $afi = Affiliate::whereRaw("ltrim(trim(identity_card),'0') ='".ltrim(trim($ci),'0')."'")->first();
                                }                                 
                                 
                                 if ($afi) {


                                    if (is_null($result->desg)) {$result->desg = 0;}
                                    $breakdown_id = Breakdown::select('id')->where('code', $result->desg)->first()->id;
   
                                    if ($breakdown_id == 1) {
                                        $unit_id = Unit::select('id')->where('breakdown_id', 1)->where('code', '20190')->first()->id;
                                    }
                                    elseif ($breakdown_id == 2) {
                                        $unit_id = Unit::select('id')->where('breakdown_id', 2)->where('code', '20190')->first()->id;
                                    }
                                    elseif ($breakdown_id == 3) {
                                        $unit_id = Unit::select('id')->where('breakdown_id', 3)->where('code', '20190')->first()->id;
                                    }
                                    else{
                                        if (Unit::select('id')->where('breakdown_id', $breakdown_id)->where('code', $result->uni)->first()) {
                                            $unit_id = Unit::select('id')->where('breakdown_id', $breakdown_id)->where('code', $result->uni)->first()->id;
                                        }else {
                                            $unit_id = Unit::select('id')->where('code', $result->uni)->first()->id;
                                        }
                                    }
                                    if ($result->niv == '04' && $result->gra == '15'){$result->niv = '03';}
                                    $hierarchy_id = $result->niv ? Hierarchy::where('code','=', $result->niv)->first()->id ?? null : null;
                                    $degree_id = $result->gra ? Degree::where('code','=', trim($result->gra))->where('hierarchy_id', '=', $hierarchy_id)->first()->id : null;
                                   


                                     $aficount++;
                                     if (Util::decimal($result->sue)<> 0) {
                                          $contribution = Reimbursement::where('month_year', '=', $month_year)
                                          ->where('affiliate_id', '=', $afi->id)->first();
                                         if (!$contribution) {
                                              $contribution = new Reimbursement;
                                              $contribution->user_id = 1;
                                              $contribution->type = 'Planilla';
                                              $contribution->affiliate_id = $afi->id;
                                              $contribution->month_year = $month_year;
                                              $contribution->unit_id = $unit_id;
                                              $contribution->breakdown_id = $breakdown_id;
                                              $contribution->degree_id = $degree_id;
                                            //   $contribution->category_id = $category_id;
                                              
                                              $contribution->base_wage = Util::decimal($result->sue);
                                              $contribution->seniority_bonus = Util::decimal($result->cat);
                                              $contribution->study_bonus = Util::decimal($result->est);
                                              $contribution->position_bonus = Util::decimal($result->carg);
                                              $contribution->border_bonus = Util::decimal($result->fro);
                                              $contribution->east_bonus = Util::decimal($result->ori);
                                              $contribution->public_security_bonus = Util::decimal($result->bseg);

                                             $contribution->gain = Util::decimal($result->gan);
                                             $contribution->payable_liquid = Util::decimal($result->pag);
                                             $contribution->quotable = (FLOAT)$contribution->base_wage +
                                                                     (FLOAT)$contribution->seniority_bonus +
                                                                     (FLOAT)$contribution->study_bonus +
                                                                     (FLOAT)$contribution->position_bonus +
                                                                     (FLOAT)$contribution->border_bonus +
                                                                     (FLOAT)$contribution->east_bonus;
     
                                             $contribution->total = Util::decimal($result->mus);
     
                                             $contribution_rate = ContributionRate::where('month_year', '=', $month_year)->first();
                                             if (!$contribution_rate) {
                                                 $this->error("no hay contribution rate");
                                             }
                                             $percentage = round(($contribution->total / $contribution->quotable) * 100, 2);
                                             
                                             if ($percentage == round(($contribution_rate->retirement_fund + $contribution_rate->mortuary_quota),2)) {
                                                 $contribution->retirement_fund = $contribution->total * $contribution_rate->retirement_fund / $percentage;
                                                 $contribution->mortuary_quota = $contribution->total * $contribution_rate->mortuary_quota / $percentage;
                                                 }else {
                                                     if($percentage == round($contribution_rate->mortuary_quota,2)){
                                                         $contribution->retirement_fund = 0;
                                                         $contribution->mortuary_quota = $contribution->total * $contribution_rate->mortuary_quota / $percentage;
                                                     }else{
                                                         $this->error('Unknown percentage of contribution!');
                                                         exit();
                                                         Log::info($result);
                                                     }
                                             }
                                             $contribution->save();                                         
                                         }
                                     }
                                }else{
                                    $afincount++;
                                    Log::info(json_encode($result));
                                    $affiliate_no[]= array(
                                        'ci' => $result->car,
                                        'p_nombre'=>$result->nom,
                                        's_nombre'=>$result->nom2,
                                        'paterno'=>$result->pat,
                                        'materno'=>$result->mat,
                                        'anio'=>$result->a_o,
                                        'mes'=>$result->mes
                                    );
                                }
                                $Progress->advance();
                         });
                     });
                     Log::info($affiliate_no);
                     Excel::create('Lista Afiliados NO importados de Reintegro'.date("Y-m-d H:i:s"),function($excel)
                     {
                         global $affiliate_no;
                         $excel->sheet('afiliados no importados',function($sheet) {
                             global $affiliate_no;
                             $sheet->fromArray($affiliate_no);
                         });
                     })->store('xls', storage_path('excel/exports'));
                     $time_end = microtime(true);
                     $execution_time = ($time_end - $time_start)/60;
                     $Progress->finish();
                     $this->info("\n\n
                         Found $aficount Affiliates\n
                         Not Found ". ($afincount ?? 0)." affiliates\n
                     Execution time $execution_time [minutes].\n");
                 }
            }else {
                $this->error('Incorrect password!');
                exit();
            }
         
        
    }
}
