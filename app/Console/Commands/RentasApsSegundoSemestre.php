<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\EconomicComplement;
use Muserpol\Affiliate;
use Muserpol\Helper\Util;
use Maatwebsite\Excel\Facades\Excel;
use Log;

class RentasApsSegundoSemestre extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alucarth:RentasApsSS';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compara las rentas de la APS del segundo semestre 2017 con planillas hdp';

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
        $op = $this->choice('Generar Reporte APS, Seleccione una Opcion XD',['Vejez','Muerte']);
        switch($op)
        {
            case 'Vejez':
                $path = storage_path('excel/imports/aps_vejez.xlsx');   
            break;
            case 'Muerte':
                $path = storage_path('excel/imports/aps_muerte.xlsx');   
            break;
        }
        // $path = str_replace('\\', '/', $o_path);
        $this->info("path: ".$path);
        global $Progress,$row_correcto,$no_registrados,$row_diferente,$hoja,$op;
        Excel::load($path, function($reader) {

            global $Progress,$row_correcto,$no_registrados,$row_diferente,$hoja,$op;
            $no_registrados=array();
            $sin_ente_gestor = array();
            $row_diferente = array(self::getTitle());
            $row_correcto = array(self::getTitle());
            $this->comment("Abriendo archivo espere por favor ...");
            $hoja = $reader->select(array('ci','cc','fsa','fs','totalp'))->get();
            $this->output->progressStart(sizeof($hoja));
            foreach($hoja as $obj)
            {
                $ci = Util::getFormatCi($obj->ci);
                
                $affiliate = Affiliate::where('identity_card',$ci)->first();
                                
                if(!is_null($affiliate))
                {   
                    $eco_com = EconomicComplement::where('affiliate_id',$affiliate->id)->where('eco_com_procedure_id',6)->first();
                    if(!is_null($eco_com))
                    {
                        $ok = false;
                        if(round($eco_com->total_rent,2) == round($obj->totalp,2)){
                            $ok= true;
                        }
                        
                        if(!$ok)
                        {
                            // $this->info(round($eco_com->total_rent,2).' != '.round($obj->totalp,2));
                            Log::info(round($eco_com->total_rent,2).' != '.round($obj->totalp,2));
                            array_push($row_diferente, self::getFormat($eco_com,$obj)  );
                        }else{
                            array_push($row_correcto,self::getFormat($eco_com,$obj));
                        }
                        // $this->info($eco_com->id);

                    }else{
                        Log::info('no encontro el complento hdp mm');
                    }

                }else{
                    Log::info('no econtrado: '.$ci);
                    // array_push($no_registrados,$obj); //no encontrados
                }
                $this->output->progressAdvance();
            } 
            $this->output->progressFinish();
        });

        $this->info('total registros excel: '.sizeof($hoja));
        $this->info('sin problemas '.(sizeof($row_correcto)-1));
        $this->info('con problemas '.(sizeof($row_diferente)-1));

        $this->info('generando reporte '.$op);
        Excel::create('Informe_'.$op.'_con_inconsistencia',function($excel)
        {
            global $row_diferente,$row_correcto,$op;

                $excel->sheet($op.' Diferente',function($sheet) {

                     global $row_diferente,$row_correcto,$op;

                      $sheet->fromArray($row_diferente,null, 'A1', false, false);

                });

                $excel->sheet($op.' Correcto',function($sheet) {

                     global $row_diferente,$row_correcto,$op;

                      $sheet->fromArray($row_correcto,null, 'A1', false, false);

                });


        })->store('xls', storage_path('excel/exports'));

    }
    public static function getTitle()
    {
        return array('Codigo del Titular','CI Titular','Codigo del Tramite','BD Muserpol Total Pension','APS Total Pension');
    }
    public static function getFormat($eco_com,$excel_object)
    {
        $row = array($eco_com->affiliate->id,$eco_com->affiliate->identity_card,$eco_com->code, $eco_com->total_rent,$excel_object->totalp);
        return $row;
    }
}
