<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Muserpol\Contribution;
use Log;

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
        global $rows;

        $this->info("Ejecutando Exportacion");
            

           Excel::load('public/file_to_import/PARA LLENADO DE DATOS.xlsx', function($reader) {

                   // global $results, $FileName;
           global $rows;
                 //$results = $reader->all();
            
                        
                    // Log::info($reader->toArray());

                    // $results = collect($reader->select(array('ci', 'ci_a'))->get());
                    $rows = array();
                    $results = $reader->select(array('ci', 'ci_a'))->get();
                    
                    // $grupo = $results->get()->groupBy('ci_a');
                    
                    $sheet = $results[0];
                    foreach ($sheet as $r) {

                        # code...
                         $afiliado = Affiliate::where('identity_card','=',$r->ci_a)->first();
                         Log::info($afiliado);
                         if($afiliado)
                         {
                             $contribuciones = Contribution::where('affiliate_id','=' ,$afiliado->id)->orderBy('month_year','DESC')->select('month_year','retirement_fund','mortuary_quota','total')->take(60)->get();

                             foreach ($contribuciones as $contribucion) {
                                 # code...
                                $row = array($afiliado->identity_card,$afiliado->first_name,$afiliado->second_name,$afiliado->last_name,$afiliado->mothers_last_name, $contribucion->month_year , $contribucion->quotable,$contribucion->total);
                                //og::info($contribucion->"");
                                array_push($rows, $row);
                             }
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
    }
}
