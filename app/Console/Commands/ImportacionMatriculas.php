<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Muserpol\Affiliate;
use Log;

class ImportacionMatriculas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ImportacionMatriculas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa las matriculas del afiliado y al beneficiario del SENASIR';

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
        $afiliado=[];
        if ($this->confirm('Importar Matricula del Afiliado?')) {
            $ruta=storage_path('excel/imports/Senasir Marzo.xlsx');
            $this->info($ruta);
            Excel::load($ruta, function($reader) {
                // reader methods
                $archivo = $reader->select(array('carnet'))->get();
               // Log::info($archivo);
                $hoja = $archivo[0];
                $this->info(sizeOf($hoja));
                foreach ($hoja as $fila) {
                    //Log::info($fila);
                    $ci=trim($fila->carnet);
                   // $afiliado = Affiliate::where('identity_card',trim($fila->carnet))->first();
                    
                    $afiliado = DB::table('affiliates')->where('first_name','=',$ci)->first();
                    Log::info($afiliado);
                    if($afiliado)
                    {
                        //Log::info($afiliado->identity_card);
                       $this->info('hay afiliado');
                    }
                    else{

                      $this->info('no hay afiliado');

                    }
                    //$this->info('paso if');
                }

            });
            $this->info($ruta);
        }
        if ($this->confirm('Importar Matricula del Derechoambiente?')) {
        }
        $this->info('hola');

    }
}
