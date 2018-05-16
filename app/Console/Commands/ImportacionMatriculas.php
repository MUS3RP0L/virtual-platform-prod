<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Muserpol\Affiliate;
use Log;
use Muserpol\Helper\Util;
use Muserpol\EconomicComplementApplicant;

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
        $ruta=storage_path('excel/imports/Senasir Marzo.xlsx');
        $this->info($ruta);
        if ($this->confirm('¿Importar Matricula del Afiliado?')) {
            Excel::load($ruta, function($reader) {
            //     $archivo = $reader->select(array('carnet'))->get();
              //  Log::info($archivo);
                // $hoja = $archivo[0];
            //     $this->info(sizeOf($hoja));
                $reader->each(function($row) {
                    //$this->info($row->carnet);
                    //$ci=$row->carnet;
                    if($row->num_com_tit){
                        $carnet=$row->carnet."-".$row->num_com_tit;
                    }else{
                        $carnet=$row->carnet;
                    }
                    $ci=Util::getFormatCi($carnet);
                    $affiliado=Affiliate::where('identity_card',$ci)->first();
                    Log::info($affiliado);
                    if($affiliado)
                    {
                        //Log::info($afiliado->identity_card);
                        $affiliado->affiliate_registration_number=$row->mat_titular;
                        $affiliado->save();
                        $this->info(' hay afiliado');
                    }
                    else{
                        $this->info($carnet." Afiliado No encontrado");
                    }
                });
            });
        }
        if ($this->confirm('¿Importar Matricula del Derechoambiente?')) {
            Excel::load($ruta, function($reader) {

                $reader->each(function($row) {
                    if($row->num_nom){
                        $carnetd=$row->carnetv."-".$row->num_com;
                    }else{
                        $carnetd=$row->carnetv;
                    }
                    $ci=Util::getFormatCi($carnetd);
                    $applicants = EconomicComplementApplicant::where('identity_card',$ci)->get();
                    //Log::info($applicant);
                    if($applicants){
                        foreach($applicants as $applicant){
                            //Log::info($afiliado->identity_card);
                            $applicant->applicant_registration_number=$row->mat_dh;
                            $applicant->save();
                        }
                        $this->info(' Hay el Derechohabiente');
                    }else{
                        $this->info($carnetd." No hay el Derechohabiente");
                    }
                });
            });
        }
    }
}
