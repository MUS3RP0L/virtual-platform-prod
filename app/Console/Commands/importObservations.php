<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Log;

use Muserpol\AffiliateObservation;
use Muserpol\EconomicComplement;



class importObservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alucarth:importObservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'importacion de observaciones ';

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
        // $this->info("".date("Y-m-d"));
        // exit();

        
        $sw = $this->ask("Importar  Contabilidad (c) o Prestamo (p) ");
        switch ($sw) {
            case 'c':
                # code...
                $this->info("Ejecutando Observados por Contabilidad");
                 $path = storage_path('excel/imports/LISTA DE DEUDORES DE CUENTAS POR COBRAR DE COMPLEMENTO ECONOMICO.xlsx');
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


                 $archivo = $reader->select(array('ci'))->get();
                 $hoja = $archivo[0];
                 foreach ($hoja as $fila) {

                     # code...
                    $afiliado = DB::table('affiliates')->where('identity_card','=',$fila->ci)->first();

                    if($afiliado)
                    {
                       Log::info($afiliado->identity_card." ".$afiliado->date_entry);    
                       array_push($rows, array($afiliado->identity_card,"Observado por Contabilidad"));

                       $observacion = new AffiliateObservation;
                       $observacion->user_id = 1;//user alejandro XD
                       $observacion->affiliate_id= $afiliado->id;
                       $observacion->observation_type_id = 1;
                       $observacion->date = date("Y-m-d");
                       $observacion->message="Falta de descargo por fondos en avance, fondo rotativo.";
                       $observacion->save();

                       $tramites = EconomicComplement::where("affiliate_id","=",$afiliado->id)->where("eco_com_procedure_id","=","2")->get();
                       Log::info("tramites : ".sizeof($tramites));
                       foreach ($tramites as $tramite) {
                           # code...
                            $tramite->amortization = 1;
                            $tramite->save();
                       }

                    }
                    else{

                        Log::info($fila->ci." Afiliado No encontrado");
                        array_push($rows,array($fila->ci,"Afiliado No encontrado"));
                        array_push($no_registrados, $fila->ci);
                    }

                    ini_set('memory_limit', '-1');
                    ini_set('max_execution_time', '-1');
                    ini_set('max_input_time', '-1');
                    set_time_limit('-1');
                    $Progress->advance();
                    
                 }

                });


                Excel::create('Informe_Observados_Contabilidad',function($excel)
                {

                global $rows;
                        $excel->sheet('Contribuciones',function($sheet) {

                             global $rows;

                              $sheet->fromArray($rows);
                        // $sheet->fromArray(
                        //                     array(
                        //                            $rows
                        //                           )
                        //                   );

                          // $sheet->row(1,array('Contribuciones: '.$contribuciones->count(),'Total Bs: '.$total) );

                          // $sheet->cells('A1:B1', function($cells) {
                          // $cells->setBackground('#4CCCD4');
                                                      // manipulate the range of cells

                          });

                })->store('xls', storage_path('excel/exports'));

                     

                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start) / 60;
                $Progress->finish();
                $this->info("\n finish them XD");

                break;
            case 'p':
                # code...
                $this->info("Ejecutando Observados por prestamo");   

                $path = storage_path('excel/imports/mora.xlsx');
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


                 $archivo = $reader->select(array('ci'))->get();
                 // $this->info($archivo);
                 $hoja = $archivo;
                 foreach ($hoja as $fila) {

                     # code...
                    // $this->info("c ".$fila);
                    $afiliado = DB::table('affiliates')->where('identity_card','=',$fila->ci)->first();



                    if($afiliado)
                    {
                       Log::info($afiliado->identity_card." ".$afiliado->date_entry);    
                       array_push($rows, array($afiliado->identity_card,"Observados por prestamos"));

                       $observacion = new AffiliateObservation;
                       $observacion->user_id = 1;//user alejandro XD
                       $observacion->affiliate_id= $afiliado->id;
                       $observacion->observation_type_id = 2;
                       $observacion->date = date("Y-m-d");
                       $observacion->message="Prestatario en situacion de mora.";
                       $observacion->save();

                       $tramites = EconomicComplement::where("affiliate_id","=",$afiliado->id)->where("eco_com_procedure_id","=","2")->get();
                       Log::info("tramites : ".sizeof($tramites));
                       foreach ($tramites as $tramite) {
                           # code...
                            $tramite->amortization = 0.5;
                            $tramite->save();
                       }

                    }
                    else{

                        Log::info($fila->ci." Afiliado No encontrado");
                        array_push($rows,array($fila->ci,"Afiliado No encontrado"));
                        array_push($no_registrados, $fila->ci);
                    }

                    ini_set('memory_limit', '-1');
                    ini_set('max_execution_time', '-1');
                    ini_set('max_input_time', '-1');
                    set_time_limit('-1');
                    $Progress->advance();
                    
                 }

                 });

                Excel::create('Informe_Observados_Prestamos',function($excel)
                {

                global $rows;
                        $excel->sheet('Contribuciones',function($sheet) {

                             global $rows;

                              $sheet->fromArray($rows);
                        // $sheet->fromArray(
                        //                     array(
                        //                            $rows
                        //                           )
                        //                   );

                          // $sheet->row(1,array('Contribuciones: '.$contribuciones->count(),'Total Bs: '.$total) );

                          // $sheet->cells('A1:B1', function($cells) {
                          // $cells->setBackground('#4CCCD4');
                                                      // manipulate the range of cells

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
