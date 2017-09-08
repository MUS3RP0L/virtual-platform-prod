<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Muserpol\Contribution;
use Log;
use Illuminate\Support\Facades\DB;
class FrDisponibilidadAportes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FondoRetiro:FrDisponibilidadAportes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disponibilidad con los 60 aportes ';

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
         global $rows;

        $this->info("Verificando El total de las disponibilidades");

        $afiliados = DB::table('affiliates')->leftJoin('affiliate_records','affiliate_records.affiliate_id','=','affiliates.id')
                                            ->where('affiliate_records.affiliate_state_id','=',3)
                                            ->where('affiliate_records.date','>','2014-01-01')
                                            ->distinct()
                                            ->select('affiliates.id')
                                            ->get();    
        $this->info("Afiliados con disponibilidades ".sizeof($afiliados)); 

        $this->info("Procesando ");

        $rows = array();
        $titulos= array(
                        'Grado',
                        'Nombres',
                        'Apellidos',
                        'CI',
                        'Exp',
                        'Fecha de Alta',
                        'Fechas de disponibilidad',
                        'Categoria %',
                        'Sueldo Base',
                        'Antiguedad',
                        'Fondo de Retiro',
                        'Cotizable',

                        ); 
        array_push($rows, $titulos);

        foreach ($afiliados as $afi) {
            # code...   

            $afiliado = Affiliate::find($afi->id);

            Log::info("Afiliado ".$afiliado->id. " CI ".$afiliado->identity_card );

            $fecha_d = DB::table('affiliate_records')
                        ->join('affiliates','affiliate_records.affiliate_id','=','affiliates.id')
                        ->where('affiliate_records.affiliate_state_id','=',3)
                        ->where('affiliate_records.date','>','2014-01-01')
                        ->where('affiliates.identity_card','=',$afiliado->identity_card)->distinct()->select('affiliate_records.date')->get();

            $fecha_disponibilidad='sin disponibilidad';

            if(sizeof($fecha_d)>0)
            {
                $cadena="";
                foreach($fecha_d as $f)
                {
                    $cadena = $cadena."|".$f->date;
                    // Log::info($fecha_d['']);
                }
                $fecha_disponibilidad=$cadena;
            }

            $fecha = Contribution::where('affiliate_id','=',$afiliado->id)->orderBy('month_year','ASC')->first();
            $fecha_alta='sin registro';
            if($fecha)
            {
                $fecha_alta = $fecha->month_year;
            }

            $exp = 'sin registro';
            if($afiliado->city_identity_card_id)
            {
                $exp = $afiliado->city_identity_card->first_shortened;
            }
            
            // $monto_contribuciones=0;

            $contribuciones_c =  Contribution::where('affiliate_id','=',$afiliado->id)->where('breakdown_id','=',1)->where('month_year','>','2014-01-01')->get();



            if($contribuciones_c)
            {
                //$qty_cotizaciones = $contribuciones_c->count();
                foreach ($contribuciones_c as $contribucion) {
                    # code...
                    $cotizable_fondo = $contribucion->base_wage + $contribucion->seniority_bonus;
                     $row =array( 
                          $afiliado->degree->shortened,
                          $afiliado->first_name.''.$afiliado->second_name,
                          $afiliado->last_name.' '.$afiliado->mothers_last_name,
                          $afiliado->identity_card,
                          $exp,
                          $fecha_alta,
                          $fecha_disponibilidad,
                          $contribucion->category->porcentage,
                          $contribucion->base_wage,
                          $contribucion->seniority_bonus,
                          $contribucion->retirement_fund,
                          $contribucion->cotizable_fondo,
                          
                        //  $qty_cotizaciones,
                          // $monto_contribuciones,  
                        );

                    array_push($rows, $row);

                    // $monto_contribuciones+=$contribucion->total;

                }
            }

            



        }


        Log::info(" el tamañno ". sizeof($rows) );

             Excel::create('informe Fondo de Retiro',function($excel)
             {

                 global $rows;
                            $excel->sheet('Afiliados Aportes > 2014',function($sheet) {

                                 global $rows;

                                  $sheet->fromArray($rows,null, 'A1', false, false);
                                  $sheet->cells('A1:I1', function($cells) {

                                  // manipulate the range of cells
                                  $cells->setBackground('#058A37');
                                  $cells->setFontColor('#ffffff');  
                                  $cells->setFontWeight('bold');

                                  });

                              });

                    })->store('xls', storage_path('excel/exports'));


        $this->info("Finished XD");
    }
}
