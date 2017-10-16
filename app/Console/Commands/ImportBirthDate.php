<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Carbon\Carbon;
use Log;

class ImportBirthDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:dates';

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
        global $Progress, $aficount,$afincount,$affiliate_no, $affiliate_yes, $affiliate_diff, $exist, $diff, $same,$update, $existd, $diffd, $samed,$updated, $econo, $ecoyes;
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
                                 global $Progress,$aficount, $afincount, $affiliate_no, $affiliate_yes, $affiliate_diff, $exist, $diff,$same, $update,$existd, $diffd, $samed,$updated, $econo, $ecoyes;
                                 ini_set('memory_limit', '-1');
                                 ini_set('max_execution_time', '-1');
                                 ini_set('max_input_time', '-1');
                                 set_time_limit('-1');
                                 $ci = $result->car;
                                 $birth_date = null;
                                 $date_entry = null;
                                 if ($result->nac) {   
                                    $birth_date = Carbon::createFromFormat('dmY',$result->nac)->toDateString();
                                 }
                                 if ($result->nac) {   
                                    $date_entry = Carbon::createFromFormat('dmY',$result->ing)->toDateString();
                                 }
                                 $afi = Affiliate::whereRaw("ltrim(trim(identity_card),'0') ='".ltrim(trim($ci),'0')."'")->first();
                                 // $afi = Affiliate::whereRaw("split_part(ltrim(trim(identity_card),'0'), '-',1) ='".ltrim(trim($ci),'0')."'")->first();
                                 if ($afi) {
                                    if (!$afi->economic_complements()->where('eco_com_procedure_id','=',2)->first()) {
                                        if ($afi->birth_date) {
                                            $exist++;
                                            if ($afi->birth_date <> $birth_date) {
                                                $diff++;
                                                $affiliate_diff[]= array(
                                                    'id' => $afi->id,
                                                    'affi_fecha_nac'=>$afi->birth_date,
                                                    'fecha_nac'=>$birth_date,
                                                );
                                                $update++;
                                                $affiliate_yes[]= array(
                                                    'id' => $afi->id,
                                                    'fecha_nac'=>$birth_date,
                                                    'fecha_nac_ori'=>$result->nac,
                                                );
                                                $afi->birth_date = $birth_date;
                                                $afi->save();
                                            }else{
                                                $same++;
                                            }
                                        }else{
                                            $update++;
                                            $afi->birth_date = $birth_date;
                                            $afi->save();
                                            $affiliate_yes[]= array(
                                                'id' => $afi->id,
                                                'fecha_nac'=>$birth_date,
                                                'fecha_nac_ori'=>$result->nac,
                                            );
                                        }
                                        $econo++;
                                    }else{
                                        $ecoyes++;
                                    }

                                    if ($afi->date_entry) {
                                        $existd++;
                                        if ($afi->date_entry <> $date_entry) {
                                            $diffd++;
                                            $affiliate_diffd[]= array(
                                                'id' => $afi->id,
                                                'affi_fecha_ing'=>$afi->date_entry,
                                                'fecha_ing'=>$date_entry,
                                            );
                                            $updated++;
                                            $affiliate_yesd[]= array(
                                                'id' => $afi->id,
                                                'fecha_ing'=>$date_entry,
                                                'fecha_ing_ori'=>$result->ing,
                                            );
                                            $afi->date_entry = $date_entry;
                                            $afi->save();
                                        }else{
                                            $samed++;
                                        }
                                    }else{
                                        $updated++;
                                        $afi->date_entry = $date_entry;
                                        $afi->save();
                                        $affiliate_yesd[]= array(
                                            'id' => $afi->id,
                                            'fecha_ing'=>$date_entry,
                                            'fecha_ing_ori'=>$result->ing,
                                        );
                                    }
                                    $aficount++;
                                 }else{
                                     $afincount++;
                                     $affiliate_no[]= array(
                                         'ci' => $result->car,
                                         'p_nombre'=>$result->nom,
                                         's_nombre'=>$result->nom2,
                                         'paterno'=>$result->pat,
                                         'materno'=>$result->mat,
                                         'fecha_nac'=>$birth_date,
                                         'fecha_ing'=>$date_entry,
                                     );
                                 }
                                 $Progress->advance();
                         });
                     });
                     Excel::create('Reporte importacion fecha de nac '.date("Y-m-d H:i:s"),function($excel)
                     {
                        global $affiliate_no, $affiliate_yes, $affiliate_diff;
                        $excel->sheet('afiliados no importados',function($sheet){
                            global $affiliate_no;
                            $sheet->fromArray($affiliate_no);
                        });
                        $excel->sheet('ids afiliados importados',function($sheet){
                            global $affiliate_yes;
                            $sheet->fromArray($affiliate_yes);
                        });
                        $excel->sheet('afiliados con diff fecha nac',function($sheet){
                            global $affiliate_diff;
                            $sheet->fromArray($affiliate_diff);
                        });
                    })->store('xls', storage_path('excel/exports'));
                     Excel::create('Reporte importacion fecha de ing '.date("Y-m-d H:i:s"),function($excel)
                     {
                        global $affiliate_no, $affiliate_yesd, $affiliate_diffd;
                        $excel->sheet('afiliados no importados',function($sheet){
                            global $affiliate_no;
                            $sheet->fromArray($affiliate_no);
                        });
                        $excel->sheet('ids afiliados importados',function($sheet){
                            global $affiliate_yesd;
                            $sheet->fromArray($affiliate_yesd);
                        });
                        $excel->sheet('afiliados con diff fecha ing',function($sheet){
                            global $affiliate_diffd;
                            $sheet->fromArray($affiliate_diffd);
                        });
                    })->store('xls', storage_path('excel/exports'));
                     $time_end = microtime(true);
                     $execution_time = ($time_end - $time_start)/60;
                     $Progress->finish();
                     $this->info("\n\n
                         Found $aficount Affiliates\n
                          Affiliates with birth date ".($exist ?? 0)."\n
                            Affiliates with different birth date ".($diff ?? 0)."\n
                            Affiliates with same birth date ".($same ?? 0)."\n
                         Actualizaciones y/o Inserciones: ". ($update ?? 0)."\n
                         -------------------------------------\n
                          Affiliates with date entry ".($existd ?? 0)."\n
                            Affiliates with different date entry ".($diffd ?? 0)."\n
                            Affiliates with same date entry ".($samed ?? 0)."\n
                         Not Found ". ($afincount ?? 0)." affiliates\n
                         Actualizaciones y/o Inserciones: ". ($updated ?? 0)."\n
                         *******************************\n
                         Afiliados con Tramites $ecoyes \n
                         Afiliados sin Tramites $econo \n
                     Execution time $execution_time [minutes].\n");
                 }
            }else {
                $this->error('Incorrect password!');
                exit();
            }
         
    }
}
