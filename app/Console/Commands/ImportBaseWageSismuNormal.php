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

class ImportBaseWageSismuNormal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sismu_normal_base_wage';

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
        
         global $Progress, $affi_succ, $affi_no,$degree_count,$category_count, $affiliate_no,$contri_exist, $contr;
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
                         global $Progress, $affi_succ, $affi_no,$degree_count,$category_count,$affiliate_no, $contri_exist, $contr;
                         ini_set('memory_limit', '-1');
                         ini_set('max_execution_time', '-1');
                         ini_set('max_input_time', '-1');
                         set_time_limit('-1');
                         $ci = trim($result->ci);
                         // dd($ci);
                         $affi=Affiliate::where('identity_card','like',$ci)->first();
                         // $affi=DB::table('affiliates')->whereRaw("split_part(affiliates.identity_card, '-',1) like '".$ci."'")->first();
                         if ($affi) {
                             $year=$result->anio;
                             $month=$result->mes;
                             if (trim($result->grado) == "SIN GRADO") {
                                 $degree = null;    
                             }else{
                                 if (Util::getDegreeId_name($result->grado) != "error" ) {
                                     $degree=Util::getDegreeId_name($result->grado);
                                 }else{
                                     Log::info($result->grado);
                                     $degree_count++;
                                 }
                             }

                             if (Util::getCategoryId_number($result->categoria/100) != "error" ) {
                                 $category=Util::getCategoryId_number($result->categoria/100);
                             }else{
                                 Log::info($result->category);
                                 $category_count++;
                             }
                             $amount=$result->monto;
                             $contribution=Contribution::where('affiliate_id','=',$affi->id)->whereRaw("extract(year from month_year) = ".$year."")->whereRaw("extract(month from month_year) = ".$month."")->first();
                             if ($contribution && $contribution->type == 'Directo' ) {
                                $contribution->base_wage=$result->haberbasico;
                                $contribution->save();
                                $contr++;
                             }else{
                                 $this->info("********** NO Existe Contribucion o Es de tipo PLanilla");
                             }
                             $affi_succ++;
                         }else{
                             $affiliate_no[]= array(
                                 'PadCedulaIdentidad' => $result->PadCedulaIdentidad,
                                 'GradSigla'=>$result->GradSigla,
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

                    Contribuciones Actualizadas: $contr\n
                     $affi_succ Affiliates Found\n
                     \tGrados no Encontrados: $degree_count\n
                     \tCategorias no Encontrados: $category_count \n
                     \tAffiliates NOT found $affi_no\n
                 Execution time $execution_time [minutes].\n");

             }
        }else {
            $this->error('Incorrect password!');
            exit();
        }
        
    }
}
