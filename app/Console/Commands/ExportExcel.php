<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Muserpol\Contribution;
use Log;
use Illuminate\Support\Facades\DB;

class ExportExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:ExportExcel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exportacion de archivo excel para el reporte del afiliado';

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
        global $rows,$afiliadoConflicto;


        $this->info("Ejecutando Exportacion");

             $afiliado = Affiliate::where('id','=',9886)->first();
           $this->info($afiliado);
            $contribuciones = Contribution::where('affiliate_id','=',$afiliado->id)->where('contributions.month_year','>=','28-08-1999')->get();
             $contribuciones = Contribution::where('affiliate_id','=',$afiliado->id)->get();

            foreach ($contribuciones as $c) {
                # code...
                $this->info("F:".$c->month_year);
            }

            $this->info($contribuciones->count());

            $años_contribuciones = (int)($contribuciones->count() /12);

            // while()

            $decimal = $contribuciones->count() /12;
            $this->info("decimal".$decimal);
            $mes = round(($decimal-$años_contribuciones)*12);

            $this->info("años ".$años_contribuciones);
            $this->info(" mes ".$mes);
             exit();

           Excel::load('public/file_to_import/PARA LLENADO DE DATOS.xlsx', function($reader) {


           global $rows,$afiliadoConflicto;

                     $afiliadoConflicto = array();


                    //para el primer informe
                     /*
                    $rows = array();
                    $titulos= array('ci','Primer Nombre','Segundo Nombre','Apellido Paterno','Apellido Materno','Fecha','Sueldo Base','Categoria','cotizable','cotizable2','FR');
                    array_push($rows, $titulos);
                    $results = $reader->select(array('ci', 'ci_a'))->get();


                    // $grupo = $results->get()->groupBy('ci_a');

                    $sheet = $results[0];
                    foreach ($sheet as $r) {

                        # code...
                         $afiliado = Affiliate::where('identity_card','=',$r->ci_a)->first();


                       //  Log::info($afiliado);

                         if($afiliado)
                         {
                            $contribuciones = Contribution::where('affiliate_id','=',$afiliado->id)->orderBy('month_year','ASC')->get();

                            if(sizeof( $contribuciones)>0){


                                 $fecha = Contribution::where('affiliate_id','=',$afiliado->id)->orderBy('month_year','ASC')->first();
                                 if($fecha)
                                 {
                                    $fecha_inicio = $fecha->month_year;
                                 }
                                 else
                                 {
                                    $fecha_inicio = '0000/00/00';
                                    array_push($afiliadoConflicto, $afiliado);

                                 }

                                // array_push($afiliadoConflicto, $afiliado);

                                 Log::info($fecha_inicio);

                                $fecha_d = DB::table('affiliate_records')
                                                ->join('affiliates','affiliate_records.affiliate_id','=','affiliates.id')
                                                ->where('affiliate_records.affiliate_state_id','=',3)
                                                ->where('affiliates.identity_card','=',$afiliado->identity_card)->orderBy('affiliate_records.date','ASC')->first();

                                if($fecha_d)
                                {

                                    $fecha_fin =$fecha_d->date;
                                }
                                else{

                                    $fecha = Contribution::where('affiliate_id','=',$afiliado->id)->orderBy('month_year','DESC')->first();

                                    if($fecha){
                                        $fecha_fin =$fecha->month_year;
                                    }
                                    else
                                    {
                                         $fecha_fin ='0000/00/00';
                                    }

                                    Log::info("no tiene disponibilidad");
                                }


                                Log::info($fecha_fin);

                                $contribuciones = Contribution::where('affiliate_id','=' ,$afiliado->id)->orderBy('month_year','DESC')->select('month_year','base_wage','seniority_bonus','quotable','dignity_pension','study_bonus','position_bonus','border_bonus','east_bonus','public_security_bonus','retirement_fund')->whereBetween('month_year',array($fecha_inicio,$fecha_fin))->take(60)->get();

                                 foreach ($contribuciones as $contribucion) {
                                     # code...
                                    $cotizable2 = $contribucion->base_wage + $contribucion->dignity_pension + $contribucion->seniority_bonus + $contribucion->study_bonus + $contribucion->position_bonus + $contribucion->border_bonus + $contribucion->east_bonus - $contribucion->public_security_bonus;
                                    $row = array($afiliado->identity_card,$afiliado->first_name,$afiliado->second_name,$afiliado->last_name,$afiliado->mothers_last_name, $contribucion->month_year ,$contribucion->base_wage,$contribucion->seniority_bonus,$contribucion->quotable,$cotizable2,$contribucion->retirement_fund);
                                    //og::info($contribucion->"");
                                    array_push($rows, $row);
                                 }

                            }else
                            {
                                $row = array($r->ci_a,"no tiene contribuciones ","","","","" ,"","","","","");
                                array_push($rows, $row);
                            }

                         }
                         else
                         {
                            $row = array($r->ci_a,"no esta registrado","","","","" ,"","","","","");
                             array_push($rows, $row);
                         }


                    }

                    */

            //*individual*/

                    $rows = array();
                    $titulos= array('ci','Exp','fecha_alta','fecha_baja','fecha disponibilidad','cotizaciones ','años','meses');                    array_push($rows, $titulos);
                    $results = $reader->select(array('ci', 'ci_a'))->get();

                    // $grupo = $results->get()->groupBy('ci_a');

                    $sheet = $results[0];
                    foreach ($sheet as $r) {

                        # code...
                         $afiliado = Affiliate::where('identity_card','=',$r->ci_a)->first();


                        if($afiliado)
                        {
                                Log::info($afiliado->id);
                                $exp = 'sin registro';
                                if($afiliado->city_identity_card_id)
                                {
                                    $exp = $afiliado->city_identity_card->first_shortened;
                                }
                                $fecha = Contribution::where('affiliate_id','=',$afiliado->id)->orderBy('month_year','ASC')->first();
                                $fecha_alta='sin registro';
                                if($fecha)
                                {
                                    $fecha_alta = $fecha->month_year;
                                }

                                $fecha = Contribution::where('affiliate_id','=',$afiliado->id)->orderBy('month_year','DESC')->first();
                                 $fecha_baja = 'sin registro';
                                if($fecha)
                                {
                                    $fecha_baja = $fecha->month_year;
                                }

                                $fecha_disponibilidad='sin disponibilidad';

                                // $fecha_d =DB::select('select distinct date from affiliate_records ar, affiliates a where a.id = ar.affiliate_id and ar.affiliate_state_id = 3 AND  a.identity_card = '.$afiliado->identity_card.' order by date asc');

                                $fecha_d = DB::table('affiliate_records')
                                            ->join('affiliates','affiliate_records.affiliate_id','=','affiliates.id')
                                            ->where('affiliate_records.affiliate_state_id','=',3)
                                            ->where('affiliates.identity_card','=',$afiliado->identity_card)->distinct()->select('affiliate_records.date')->get();

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

                                $qty_cotizaciones = 0;

                                $contribuciones_c =  Contribution::where('affiliate_id','=',$afiliado->id)->where('breakdown_id','=',1)->get();
                                if($contribuciones_c)
                                {
                                    $qty_cotizaciones = $contribuciones_c->count();
                                }

                                $años_contribuciones = 0;



                                $contribuciones_tiempo = Contribution::where('affiliate_id','=',$afiliado->id)->get();
                                Log::info($contribuciones_tiempo->count());

                                $años_contribuciones = (int)($contribuciones_tiempo->count()/12);
                                $meses_contribuciones =  round((($contribuciones_tiempo->count()/12) - $años_contribuciones)*12);
                                Log::info("años ".$años_contribuciones);
                                Log::info("meses ".$meses_contribuciones);
                                $row =array($afiliado->identity_card,$exp,$fecha_alta,$fecha_baja,$fecha_disponibilidad,$qty_cotizaciones,$años_contribuciones,$meses_contribuciones);
                                array_push($rows, $row);
                        }
                        else
                        {
                                Log::info('sin registro');
                                 $row =array($r->ci_a,'no se encuentra registrado','-----','----','-----','-----','-----','-----');
                                array_push($rows, $row);
                        }



                    }




                });
             Log::info(" el tamañno ". sizeof($rows) );

             Excel::create('informe',function($excel)
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


        // $ci = $this->ask('Ingrese el ci del afiliadio');

       //  $afiliado = Affiliate::where('identity_card','=',$ci)->first();
       //  Log::info($afiliado->id);



       // $contribuciones = Contribution::where('affiliate_id','=' ,$afiliado->id)->orderBy('month_year','DESC')->select('month_year','retirement_fund','mortuary_quota','total')->take(60)->get();

       // $total=0;

       // foreach ($contribuciones as $contribucion) {
       //     # code...
       //      $total += $contribucion->total;
       // }
        //Log::info('--------------------------------------------------------------');
        // Log::info("total registro ".$contribuciones->count());


        // Log::info($contribuciones);



        // Excel::create('informe',function($excel)
        // {
        //     $excel->setTitle("Informe de Contribuyentes");

        //     $excel->setCreator("David")->setCompany("Muserpol");

        //     $excel->setDescription(" informe de Contribuyentes");

        //     $cis= array('2023470','669198','630563');

            // foreach ($cis as $ci) {
            //     # code...
            //         Log::info("buscando por ".$ci);
            //         $afiliado = Affiliate::where('identity_card','=',$ci)->first();
            //         Log::info($afiliado->id);



            //         $contribuciones = Contribution::where('affiliate_id','=' ,$afiliado->id)->orderBy('month_year','DESC')->select('month_year','retirement_fund','mortuary_quota','total')->take(60)->get();


            //         Log::info("total registros ".$contribuciones->count());


            //         Log::info($contribuciones);


            //         $total=0;

            //         foreach ($contribuciones as $contribucion) {
            //            # code...
            //             $total += $contribucion->total;
            //         }

            //          $excel->sheet('afiliado '.$afiliado->identity_card,function($sheet) use ($contribuciones,$total) {


            //             $sheet->setStyle(array(
            //                 'font' => array(
            //                     'name'      =>  'Calibri',
            //                     'size'      =>  12,
            //                     'bold'      =>  true
            //                 )
            //             ));

            //             // $sheet->fromArray(
            //             //                     array(
            //             //                            array('Contribuciones:',$contribuciones->count(),'Total Bs: ',$total)
            //             //                           )
            //             //                   );

            //               $sheet->row(1,array('Contribuciones: '.$contribuciones->count(),'Total Bs: '.$total) );

            //               $sheet->cells('A1:B1', function($cells) {
            //               $cells->setBackground('#4CCCD4');
            //                                           // manipulate the range of cells

            //               });
            //         });

            // }





        // })->store('xls', storage_path('excel/exports'));

             $this->info('total exportadors '.sizeof($rows));
            foreach ($afiliadoConflicto as $af) {

                # code...
                $this->info(' afiliado '.$af->id);
            }


    }
}
