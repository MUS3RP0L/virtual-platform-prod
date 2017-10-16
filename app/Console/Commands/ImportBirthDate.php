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
    protected $signature = 'import:birth_date';

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
        global $Progress, $aficount,$afincount,$affiliate_no, $affiliate_yes, $affiliate_diff, $exist, $diff, $same,$update;
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
                                 global $Progress,$aficount, $afincount, $affiliate_no, $affiliate_yes, $affiliate_diff, $exist, $diff,$same, $update;
                                 ini_set('memory_limit', '-1');
                                 ini_set('max_execution_time', '-1');
                                 ini_set('max_input_time', '-1');
                                 set_time_limit('-1');
                                 $ci = $result->car;
                                 $birth_date = null;
                                 if ($result->nac) {   
                                    $birth_date = Carbon::createFromFormat('dmY',$result->nac)->toDateString();
                                 }
                                 $afi = Affiliate::whereRaw("split_part(ltrim(trim(identity_card),'0'), '-',1) ='".ltrim(trim($ci),'0')."'")->first();
                                 if ($afi) {
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
                     $time_end = microtime(true);
                     $execution_time = ($time_end - $time_start)/60;
                     $Progress->finish();
                     $this->info("\n\n
                         Found $aficount Affiliates\n
                          Affiliates with birth date ".($exist ?? 0)."\n
                            Affiliates with different birth date ".($diff ?? 0)."\n
                            Affiliates with same birth date ".($same ?? 0)."\n
                         Not Found ". ($afincount ?? 0)." affiliates\n
                         Actualizaciones y/o Inserciones: ". ($update ?? 0)."\n
                     Execution time $execution_time [minutes].\n");
                 }
            }else {
                $this->error('Incorrect password!');
                exit();
            }
         
    }
}
