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
        global $contaf, $totalr;
        if ($this->confirm('¿Importar Matricula del Afiliado?')) {
            Excel::load($ruta, function($reader) {
                global $contaf, $totalr;
                $reader->each(function($row) {
                    global $contaf, $totalr;
                    $totalr=$totalr+1;
                    $numcomvt=trim($row->num_com_tit);
                    if($numcomvt){
                        $carnet=$row->carnet."-".$row->num_com_tit;
                    }else{
                        $carnet=$row->carnet;
                    }
                    $ci=Util::getFormatCi($carnet);
                    $affiliado=Affiliate::where('identity_card',$ci)->first();
                    Log::info($affiliado);
                    if($affiliado)
                    {
                        $contaf=$contaf+1;
                        $affiliado->affiliate_registration_number=$row->mat_titular;
                        $affiliado->save();
                        //$this->info(' hay afiliado');
                    }
                    else{
                        $this->info($carnet." Afiliado No encontrado");
                    }
                });
                $this->info("Total de Registros: ".$totalr);
                $this->info("Total de Importados: ".$contaf);
            });
        }

        global $cont, $total;
        if ($this->confirm('¿Importar Matricula del Derechohabiente y del Afiliado?')) {

            Excel::load($ruta, function($reader) {
                global $cont, $total;
                $cont=0;
                $this->info(sizeOf($reader));
                $reader->each(function($row) {
                    global $cont, $total;
                    $total=$total+1;
                    Log::info($row);
                    $numcomv=trim($row->num_com);
                    if($numcomv){
                        $carnetd=$row->carnetv."-".$row->num_com;
                    }else{
                        $carnetd=$row->carnetv;
                    }
                    $ci=Util::getFormatCi($carnetd);
                    $applicants = EconomicComplementApplicant::where('identity_card',$ci)->get();
                    //Log::info($applicant);
                    if($applicants){
                        if(sizeOf($applicants)>0){
                            $cont=$cont+1;
                            foreach($applicants as $applicant){
                                //Log::info($afiliado->identity_card);
                                $affiliate=$applicant->economic_complement->affiliate;
                                $affiliate->affiliate_registration_number=$row->mat_titular;
                                $affiliate->save();

                                $applicant->applicant_registration_number=$row->mat_dh;
                                $applicant->save();
                            }
                        //$this->info(' Hay el Derechohabiente');
                        }else{
                            $this->info($carnetd." No hay el Derechohabiente");
                        }
                    }
                }
            );
            $this->info("Total de registros: ".$total);
            $this->info("Cantidad de importados: ".$cont);
            });
        }
    }
}
