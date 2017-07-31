<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Log;

class Exportar_de_MDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alucarth:Exportar_de_MDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esportar informacion de la base de datos  maria DB';

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
        global $rows,$no_registrados;

        $rows = array();
        $no_registrados = array();
        $this->info(" Iniciando exportacion XD");


         Excel::load('public/file_to_import/fechas de alta.xlsx', function($reader) {

        global $rows,$no_registrados;

         $archivo = $reader->select(array('ci'))->get();
         $hoja = $archivo[0];
         foreach ($hoja as $fila) {
             # code...
            $afiliado = DB::connection('mysql')->table('affiliates')->where('identity_card','=',$fila->ci)->first();

            // Log::info($fila->ci);
            if($afiliado)
            {
               Log::info($afiliado->identity_card." ".$afiliado->date_entry);    
               array_push($rows, array($afiliado->identity_card,$afiliado->date_entry));
            }
            else{

                Log::info($fila->ci." Afiliado No encontrado");
                array_push($rows,array($fila->ci,"Afiliado No encontrado"));
                array_push($no_registrados, $fila->ci);
            }

            
         }

         });





         $this->info(" Afiliados no Encontrados ".sizeof($no_registrados));
        
         $this->info("Exportando Excel XD");

         Excel::create('Fechas_de_alta',function($excel)
         {                    
            global $rows;
          
            $excel->sheet('Fechas de alta de afiliados',function($sheet) {

                 global $rows;

                  $sheet->fromArray($rows);
                    

                $sheet->cell('A1', function($cell) {

                // manipulate the cell
                $cell->setValue('Ci ');
                $cell->setBackground('#32E59F');

                });
                $sheet->cell('B1', function($cell) {

                // manipulate the cell
                $cell->setValue('Fecha de Alta');
                $cell->setBackground('#32E59F');

                });



              });
                  
         })->store('xls', storage_path('excel/exports'));

        $this->info(" < Finalizado > ");


    }
}
