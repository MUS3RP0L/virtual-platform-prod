<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\Affiliate;
use Muserpol\ObservationType;
use Muserpol\AffiliateObservation;
use Muserpol\EconomicComplementObservation;
use Muserpol\EconomicComplement;
use Maatwebsite\Excel\Facades\Excel;
use Log;
use DB;
class ImportObservationsLoan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:ImportObservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar Observaciones por prestamos';

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
       
        $this->info("Ejecutando Observados por Prestamos");
        
        //$estados = DB::connection('sqlsrv')->table('EstCivil')->get(); 
        //$this->info(json_encode($estados));
        //$path = storage_path('no_conciliados.xlsx');

        $path = storage_path('excel/imports/prestamos_junio_mora.xls');
      
      //  $path = storage_path('excel/imports/PRESTAMOS_EN_MORA (2).xlsx');
        // $path = str_replace('\\', '/', $o_path);
        $this->info("path: ".$path);

        global $Progress,$rows,$rows_not_found;

        $rows = array();
        $rows_not_found = array();
        array_push($rows,array('nro_prestamo','ci','matricula','primer_nombre','segundo_nombre','paterno','materno','apellido_casada'));
        array_push($rows_not_found,array('nro_prestamo','ci','matricula','primer_nombre','segundo_nombre','paterno','materno','apellido_casada'));
        Excel::selectSheetsByIndex(0)->load($path, function($reader) {

        global $Progress,$rows,$rows_not_found;
            Log::info("ingreso a la lectura");

            $archivo = $reader->select(array('nro_prestamo','ci','matricula','primer_nombre','segundo_nombre','paterno','materno','apellido_casada'))->get();
            Log::info($archivo);
            // $this->info($archivo);
            $hoja = $archivo;
            foreach ($hoja as $row) {

                # code...
            // $this->info("c ".$row);
            //$afiliado = DB::table('affiliates')->where('identity_card','=',trim($row->ci))->first();
           $afiliado = Affiliate::where('identity_card','=',trim($row->ci))->first();
            // $afiliado = DB::table('affiliates')->where('identity_card','=',$fila->ci)->first();

                //$this->info($afiliado);

            if(isset($afiliado))
            {
                $aff_observation = AffiliateObservation::where('affiliate_id',$afiliado->id)->where('observation_type_id',2)->first();
                if(!$aff_observation){
                    $observacion = new AffiliateObservation;
                    $observacion->user_id = 1;//user alejandro XD
                    $observacion->affiliate_id= $afiliado->id;
                    $observacion->observation_type_id = 2;
                    $observacion->date = date("Y-m-d");
                    $observacion->message="Prestatario en situación de mora.";
                    $observacion->save();
                }
                
                //$this->info("ingresando a metodo");
                $eco_com = EconomicComplement::where('eco_com_procedure_id',7)->where('affiliate_id',$afiliado->id) ->first();
                $this->info($eco_com);
                if(isset($eco_com)){

                        $eco_observation= EconomicComplementObservation::where('economic_complement_id',$eco_com->id)->where('observation_type_id',2)->first();
                        if(!$eco_observation){
                            $eco_observacion = new EconomicComplementObservation;
                            $eco_observacion->user_id = 1;//user alejandro XD
                            $eco_observacion->economic_complement_id = $eco_com->id;
                            $eco_observacion->observation_type_id = 2;
                            //$eco_observacion->date = date("Y-m-d");
                            $eco_observacion->message = "Prestatario en situación de mora";
                            $eco_observacion->save();
                        }
                }
                $this->info($afiliado->identity_card);    
                array_push($rows, array($row->nro_prestamo,$row->ci,$row->matricula,$row->primer_nombre,$row->segundo_nombre,$row->paterno,$row->materno,$row->apellido_casada));

             
            }
            else{

                $this->info($row->ci." Afiliado No encontrado");
                array_push($rows_not_found,array($row->nro_prestamo,$row->ci,$row->matricula,$row->primer_nombre,$row->segundo_nombre,$row->paterno,$row->materno,$row->apellido_casada));
                
            }
            
        }

         });
       
        Excel::create('Informe_observados_1_2018',function($excel)
        {
            global $rows,$rows_not_found,$row_empy_capital;
                    $excel->sheet('Observados',function($sheet) {
                            global $rows,$rows_not_found,$row_empy_capital;
                            $sheet->fromModel($rows,null, 'A1', false, false);
                            $sheet->cells('A1:C1', function($cells) {
                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  
                            $cells->setFontWeight('bold');
                            });
                        });
                    $excel->sheet('no_encontrados',function($sheet) {
                            global $rows,$rows_not_found,$row_empy_capital;
                            $sheet->fromModel($rows_not_found,null, 'A1', false, false);
                            $sheet->cells('A1:C1', function($cells) {
                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  
                            $cells->setFontWeight('bold');
                            });
                        });
                  
        })->store('xls', storage_path('excel/exports'));
        
        $this->info('Termino Brian y Taty');
    }
}
