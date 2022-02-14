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
use Muserpol\Contribution;
use Muserpol\ContributionRate;

use Util;
use Log;

use Carbon\Carbon;

class ImportPayroll2018 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:payroll_2018';

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
        
        global $Progress, $aficount,$afincount;
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
                                 global $Progress,$aficount, $afincount;
                                 ini_set('memory_limit', '-1');
                                 ini_set('max_execution_time', '-1');
                                 ini_set('max_input_time', '-1');
                                 set_time_limit('-1');

                                 $ci=$result->car;
                                 $first_name=$result->nom ? trim($result->nom) : null;
                                 $second_name=$result->nom2 ? trim($result->nom2) : null;
                                 $last_name= $result->pat ? trim($result->pat) : null;
                                 $mothers_last_name=$result->mat ? trim($result->mat) : null;
                                 $surname_husband=$result->apes ? trim($result->apes) : null;
                                 $birth_date=$result->nac ? Carbon::createFromFormat('dmY', $result->nac)->toDateString() : null;
                                 $date_entry=$result->ing ? Carbon::createFromFormat('dmY', $result->ing)->toDateString() : null;

                                 $gender = $result->sex ? trim($result->sex) : null;
                                 $civil_status = $result->eciv ? trim($result->eciv) : null;
                                 //$item = $result->item ? trim($result->item) : null;
                                 //$nua = $result->nua ? trim($result->nua) : null;


                                 $month = $result->mes ? intval($result->mes) : 0;
                                 $year = $result->a_o ? intval($result->a_o)+2000: 0;
                                 $month_year = Carbon::createFromDate($year, $month, 1)->toDateString();


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
                                 $category_id = Category::where('percentage', Util::CalcCategory(Util::decimal($result->cat),Util::decimal($result->sue)))->first()->id;

                                 $afi = Affiliate::whereRaw("ltrim(trim(identity_card),'0') ='".ltrim(trim($ci),'0')."'")->first();
                                 
                                 if ($afi) {
                                     $aficount++;
                                 }else{
                                     $afincount++;
                                 }

                                 if (!$afi) {
                                     $afi=new Affiliate;
                                     $afi->identity_card = ltrim(trim($ci),'0');
                                 }

                                 switch ($result->desg) {
                                    case '1'://Disponibilidad
                                        $afi->affiliate_state_id = 3;
                                    break;
                                    case '3'://Comisión
                                        $afi->affiliate_state_id = 2;
                                    break;
                                    default://Servicio
                                        $afi->affiliate_state_id = 1;
                                 }
                                 switch ($result->desg) {
                                    case '5': //Batallón
                                        $afi->type = 'Batallón';
                                    break;
                                    default://Comando
                                        $afi->type = 'Comando';
                                 }
                                 if(! $afi->economic_complements()->where('eco_com_procedure_id', 7)->first()){
                                    $afi->unit_id = $unit_id;
                                    $afi->degree_id = $degree_id;
                                    $afi->category_id = $category_id;
                                    $afi->user_id = 1;
                                    $afi->last_name = Util::replaceCharacter($last_name);
                                    $afi->mothers_last_name = Util::replaceCharacter($mothers_last_name);
                                    $afi->surname_husband = Util::replaceCharacter($surname_husband);
                                    $afi->first_name = Util::replaceCharacter($first_name);
                                    $afi->second_name = Util::replaceCharacter($second_name);
                                    $afi->civil_status = $civil_status;
                                    $afi->gender = $gender;
                                    //$afi->item = $item;
                                    //$afi->afp = Util::getAfp(trim($result->afp));
                                    $afi->birth_date = $birth_date;
                                    $afi->date_entry = $date_entry;
                                    //$afi->nua = $nua;
                                    //$afi->registration = null;
                                    $afi->save();
                                    Log::info($afi->id.' esto');
                                }

                                 if (Util::decimal($result->sue)<> 0) {

                                     $contribution = Contribution::where('month_year', '=', $month_year)
                                                                 ->where('affiliate_id', '=', $afi->id)->first();
                                     if (!$contribution) {
                                         $contribution = new Contribution;
                                         $contribution->user_id = 1;
                                         $contribution->type = 'Planilla';
                                         $contribution->affiliate_id = $afi->id;
                                         $contribution->month_year = $month_year;
                                         $contribution->unit_id = $unit_id;
                                         $contribution->breakdown_id = $breakdown_id;
                                         $contribution->degree_id = $degree_id;
                                         $contribution->category_id = $category_id;
                                         //$contribution->item = $item;

                                         $contribution->base_wage = Util::decimal($result->sue);
                                         $contribution->seniority_bonus = Util::decimal($result->cat);
                                         $contribution->study_bonus = Util::decimal($result->est);
                                         $contribution->position_bonus = Util::decimal($result->carg);
                                         $contribution->border_bonus = Util::decimal($result->fro);
                                         $contribution->east_bonus = Util::decimal($result->ori);
                                         $contribution->public_security_bonus = Util::decimal($result->bseg);

                                         //$contribution->deceased = $result->dfu;
                                         //$contribution->natality = $result->nat;
                                         //$contribution->lactation = $result->lac;
                                         //$contribution->prenatal = $result->pre;
                                         //$contribution->subsidy = Util::decimal($result->sub);

                                         $contribution->gain = Util::decimal($result->gan);
                                         $contribution->payable_liquid = Util::decimal($result->lpag);
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
                                         //$NewContri ++;
                                     }
                                 }
                                 // $afi = Affiliate::whereRaw("split_part(ltrim(trim(identity_card),'0'), '-',1) ='".explode('-',ltrim(trim($ci),'0'))[0]."'")->first();
                                 $Progress->advance();
                         });
                     });
                    //  Excel::create('Reporte importacion fecha de nac '.date("Y-m-d H:i:s"),function($excel)
                    //  {
                    //     global $affiliate_no, $affiliate_yes, $affiliate_diff;
                    //     $excel->sheet('afiliados no importados',function($sheet){
                    //         global $affiliate_no;
                    //         $sheet->fromArray($affiliate_no);
                    //     });
                    //     $excel->sheet('ids afiliados importados',function($sheet){
                    //         global $affiliate_yes;
                    //         $sheet->fromArray($affiliate_yes);
                    //     });
                    //     $excel->sheet('afiliados con diff fecha nac',function($sheet){
                    //         global $affiliate_diff;
                    //         $sheet->fromArray($affiliate_diff);
                    //     });
                    // })->store('xls', storage_path('excel/exports'));
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
