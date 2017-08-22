<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Muserpol\Contribution;
use Muserpol\AffiliateObservation;
use Muserpol\EconomicComplement;
use Log;
use Illuminate\Support\Facades\DB;

class ObservationsAmount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alucarth:ObservationsAmount';

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
        //  
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');

        $this->info("Importacion de Observaciones");
        $sw = $this->ask("Escriba  Contabilidad (c) , Prestamo (p) ,Reposicion (r)  ");
        switch ($sw) {
            case 'c':
                // $this->info("Ejecutando Reposicion (r) ");
                // $path = storage_path('excel/imports/reposicion.xlsx');
                // // $path = str_replace('\\', '/', $o_path);
                
                // $this->info("path: ".$path);

                // global $Progress,$rows,$no_registrados;

                // $rows = array();
                // $no_registrados = array();

                // $time_start = microtime(true);
                // $this->info("Trabajando la Reputa...\n");
                // $Progress = $this->output->createProgressBar();
                // $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");

                // Excel::load($path, function($reader) {

                // global $Progress,$rows,$no_registrados;


                //  $archivo = $reader->select(array('ci','monto'))->get();
                //  $hoja = $archivo;
                //  Log::info($hoja);
                //  foreach ($hoja as $fila) {

                //     Log::info("ci: ".$fila->ci."  monto:".$fila->monto);

                //      # code...
                //     $afiliado = DB::table('affiliates')->where('identity_card','=',$fila->ci)->first();

                //     if($afiliado)
                //     {
                //        Log::info($afiliado->identity_card." ".$afiliado->date_entry);    
                //        array_push($rows, array($afiliado->identity_card,"Observacion por Contabilidad"));

                //        $observacion = new AffiliateObservation;
                //        $observacion->user_id = 1;//user alejandro XD
                //        $observacion->affiliate_id= $afiliado->id;
                //        $observacion->observation_type_id = 1;
                //        $observacion->date = date("Y-m-d");
                //        $observacion->message="Falta de descargo por fondos en avance, fondo rotativo.";
                //        // $observacion->save();

                //        $tramite = EconomicComplement::where("affiliate_id","=",$afiliado->id)->where("eco_com_procedure_id","=","2")->first();
                //        // Log::info("tramites : ".sizeof($tramites));
                //        if($tramite)
                //        {

                //             if($fila->monto < $tramite->total)
                //             {
                //                $tramite->amount_accounting = $fila->monto; 
                //                $tramite->save();
                //             }else
                //             {
                //                $tramite->amount_accounting = $tramite->total;
                //                $tramite->save();
                //             }   
                           
                //        }

                       

                //     }
                //     else{

                //         Log::info($fila->ci." Afiliado No encontrado");
                //         array_push($rows,array($fila->ci,"Afiliado No encontrado"));
                //         array_push($no_registrados, $fila->ci);
                //     }

           
                //     $Progress->advance();
                    
                //  }

                // });


                // Excel::create('Informe_Observados_Contabilidad',function($excel)
                // {

                // global $rows;
                //         $excel->sheet('Contablidad ',function($sheet) {

                //              global $rows;

                //               $sheet->fromArray($rows);

                //           });

                // })->store('xls', storage_path('excel/exports'));

                     

                // $time_end = microtime(true);
                // $execution_time = ($time_end - $time_start) / 60;
                // $Progress->finish();
                // $this->info("\n finish them XD");

                break;
            case 'p':

                $this->info("Ejecutando Prestamos (p) ");
                $path = storage_path('excel/imports/Casos de Amortización de Deuda.xlsx');
                // $path = str_replace('\\', '/', $o_path);
                
                $this->info("path: ".$path);

                global $Progress,$rows,$no_registrados;

                $rows = array();
                $no_registrados = array();

                $time_start = microtime(true);
                $this->info("Trabajando la Reputa...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");

                Excel::load($path, function($reader) {

                global $Progress,$rows,$no_registrados;


                 $archivo = $reader->select(array('ci','monto','tipo'))->get();
                 $hoja = $archivo;
                 Log::info($hoja);
                 foreach ($hoja as $fila) {

                    Log::info("ci: ".$fila->ci."  monto:".$fila->monto." renta:".$fila->tipo);

                     # code...
                    $modalidad = DB::table("eco_com_modalities")->where("shortened","=",$fila->tipo)->first();

                    $applicant = DB::table('eco_com_applicants')
                                ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                ->where('eco_com_applicants.identity_card','=',$fila->ci)
                                ->where('eco_com_modality_id','=',$modalidad->id)
                                ->where("eco_com_procedure_id","=","2")
                                ->first();
                    if($applicant)
                    {
                        Log::info("tiene id_comple=".$applicant->economic_complement_id);
                        $tramite = EconomicComplement::where('id','=',$applicant->economic_complement_id)->first();
                         if($tramite)
                         {

                                if($fila->monto < $tramite->total)
                                {
                                   $tramite->amount_loan= $fila->monto; 
                                   $tramite->save();

                                }else
                                {
                                   $tramite->amount_loan = $tramite->total;
                                   $tramite->save();
        
                                }   

                               $observacion = AffiliateObservation::where('affiliate_id',$tramite->affiliate_id)->where('observation_type_id',2)->first();
                               $observacion->is_enabled =true;
                               $observacion->save();
                               Log::info("observacion con enabled ".$tramite->affiliate_id);
                               Log::info($observacion);
                               
                         
                        }    
                        else{
                            Log::info("no tiene el hdp");
                        }  
                    }         
                

           
                    $Progress->advance();
                    
                 }

                });


                Excel::create('Informe_Observados_Reposicion',function($excel)
                {

                global $rows;
                        $excel->sheet('Reposiciones',function($sheet) {

                             global $rows;

                              $sheet->fromArray($rows);

                          });

                })->store('xls', storage_path('excel/exports'));

                     

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start) / 60;
                $Progress->finish();
                $this->info("\n finish them XD");
                

                break;
            case 'r':

                $this->info("Ejecutando Reposicion (r) ");
                $path = storage_path('excel/imports/rep.xlsx');
                // $path = str_replace('\\', '/', $o_path);
                
                $this->info("path: ".$path);

                global $Progress,$rows,$no_registrados;

                $rows = array();
                $no_registrados = array();

                $time_start = microtime(true);
                $this->info("Trabajando la Reputa...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");

                Excel::load($path, function($reader) {

                global $Progress,$rows,$no_registrados;


                 $archivo = $reader->select(array('ci','monto','tipo'))->get();
                 $hoja = $archivo;
                 Log::info($hoja);
                 foreach ($hoja as $fila) {

                    Log::info("ci: ".$fila->ci."  monto:".$fila->monto." renta:".$fila->tipo);

                     # code...
                    $modalidad = DB::table("eco_com_modalities")->where("shortened","=",$fila->tipo)->first();

                    $applicant = DB::table('eco_com_applicants')
                                ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                ->where('eco_com_applicants.identity_card','=',$fila->ci)
                                ->where('eco_com_modality_id','=',$modalidad->id)
                                ->where("eco_com_procedure_id","=","2")
                                ->first();
                    if($applicant)
                    {
                        Log::info("tiene id_comple=".$applicant->economic_complement_id);
                        $tramite = EconomicComplement::where('id','=',$applicant->economic_complement_id)->first();
                         if($tramite)
                         {

                                if($fila->monto < $tramite->total)
                                {
                                   $tramite->amount_replacement= $fila->monto; 
                                   $tramite->save();

                                }else
                                {
                                   $tramite->amount_replacement = $tramite->total;
                                   $tramite->save();

                                }   
                               
                               $observacion = AffiliateObservation::where('affiliate_id',$tramite->affiliate_id)->where('observation_type_id',13)->first();
                               $observacion->is_enabled =true;
                               $observacion->save();
                               Log::info("observacion con enabled ".$tramite->affiliate_id);
                               Log::info($observacion);
                     
                        }    
                        else{
                            Log::info("no tiene el hdp");
                        }  
                    }         
                

           
                    $Progress->advance();
                    
                 }

                });


                Excel::create('Informe_Observados_Reposicion',function($excel)
                {

                global $rows;
                        $excel->sheet('Reposiciones',function($sheet) {

                             global $rows;

                              $sheet->fromArray($rows);

                          });

                })->store('xls', storage_path('excel/exports'));

                     

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start) / 60;
                $Progress->finish();
                $this->info("\n finish them XD");
                break;
            default:
            # code...
            $this->info("Esta pendejo no existe esa opcion");

            break;            

        }


    }
}
