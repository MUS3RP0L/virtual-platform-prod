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
       
        $this->info("Ejecutando Observados por prestamo");   

        $path = storage_path('excel/imports/mota_total.xlsx');
        // $path = str_replace('\\', '/', $o_path);
        $this->info("path: ".$path);

        global $Progress,$rows,$no_registrados;

        $rows = array();
        $no_registrados = array();

        Excel::selectSheetsByIndex(0)->load($path, function($reader) {

        global $Progress,$rows,$no_registrados;
            Log::info("ingreso a la lectura");

            $archivo = $reader->select(array('ci'))->get();
            Log::info($archivo);
            // $this->info($archivo);
            $hoja = $archivo;
            foreach ($hoja as $fila) {

                # code...
            // $this->info("c ".$fila);
            // $afiliado = DB::table('affiliates')->where('identity_card','=',trim($fila->ci))->first();
            $afiliado = Affiliate::where('identity_card','=',trim($fila->ci))->first();
            // $afiliado = DB::table('affiliates')->where('identity_card','=',$fila->ci)->first();

                //$this->info($afiliado);

            if(isset($afiliado))
            {
                $this->info("ingresando a metodo");
                $eco_com = EconomicComplement::where('eco_com_procedure_id',7)->where('affiliate_id',$afiliado->id) ->first();
                $this->info($eco_com);
                if(isset($eco_com)){

                        $eco_observacion = new EconomicComplementObservation;
                        $eco_observacion->user_id = 1;//user alejandro XD
                        $eco_observacion->economic_complement_id = $eco_com->id;
                        $eco_observacion->observation_type_id = 2;
                        //$eco_observacion->date = date("Y-m-d");
                        $eco_observacion->message = "Prestatario en situación de mora";
                        $eco_observacion->save();
                }
                $this->info($afiliado->identity_card." ".$afiliado->date_entry);    
                array_push($rows, array($afiliado->identity_card,"Observados por prestamos"));

                $observacion = new AffiliateObservation;
                $observacion->user_id = 1;//user alejandro XD
                $observacion->affiliate_id= $afiliado->id;
                $observacion->observation_type_id = 2;
                $observacion->date = date("Y-m-d");
                $observacion->message="Prestatario en situación de mora total.";
                $observacion->save();

                // $tramites = EconomicComplement::where("affiliate_id","=",$afiliado->id)->where("eco_com_procedure_id","=","2")->get();
                // Log::info("tramites : ".sizeof($tramites));
                // foreach ($tramites as $tramite) {
                //     # code...
                //      $tramite->amortization = 0.5;
                //      $tramite->save();
                // }

            }
            else{

                $this->info($fila->ci." Afiliado No encontrado");
                array_push($rows,array($fila->ci,"Afiliado No encontrado"));
                array_push($no_registrados, $fila->ci);
            }
            
        }

         });
        Excel::create('Informe_Observados_Prestamos',function($excel)
        {

        global $rows;
                $excel->sheet('Mora total',function($sheet) {

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


    }
}
