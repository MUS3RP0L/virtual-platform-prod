<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
class ImportClassRentSenasir extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alucarth:ImportClassRentSenasir';
    protected $description = 'Command description';

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
        $this->info("Importando clase de rentas de senasir");
        $path = storage_path('excel/imports/092017-Policia_Boliviana N.xlsx');
        Excel::load($path, function($reader) {

            global $rows;
            //dd($reader->get());
            $rows = $reader->select(array('ci','ext','renta','clase_renta'))
                           // ->take(500)
                           ->get();
            //$this->info("resultado".$results);

            $this->info(sizeof($rows));

            $vejes=0;
            $viudeda=0;
            $orfandad=0;
            $orfandadDoble=0;
            $invalidez=0;
            $parcial=0;
            $total=0;
            
            $id_vejes=array();
            $id_viudeda=array();
            $id_orfandad=array();
            $id_orfandadDoble=array();
            $id_invalidez=array();
            $id_parcial=array();
            $id_total=array();

            // $rows = $reader->get("ci");
            foreach ($rows as $row) {

                $ext = trim($row->ext);
                //$this->info('extencion ['.$ext.']');
               // $this->info(strlen($ext));
                // if(strlen($ext)>0)
                if(strlen($ext)>0)
                {
                    $ci = $row->ci.'-'.$row->ext;
                }
                else
                {
                    $ci = $row->ci;
                }

                $complemento = null;
                $this->info($row->renta);
                if($row->renta=='TITULAR'){


            
                    $afiliado = Affiliate::where('identity_card','=',$ci)->first();

                    if($afiliado)
                    {
                        $this->info("afiliado: ".$afiliado->id);

                        $complemento = EconomicComplement::where('affiliate_id',$afiliado->id)->where('eco_com_procedure_id',6)->first();

                        
                    }
                    else
                    {
                        $this->info("no existe el afiliado ".$ci);       
                    }
                }
                else
                {
                    
                    $aplicants = EconomicComplementApplicant::where('identity_card',$ci)->get();
                    if($aplicants)
                    {
                        foreach ($aplicants as $aplicant) {
                            # code...
                            $com = EconomicComplement::where('id',$aplicant->economic_complement_id)->where('eco_com_procedure_id',6)->first();
                            if($com)
                            {
                                $complemento = $com;
                            }
                        }
                        // $this->info("aplicant: ".$aplicant->economic_complement->where('eco_com_procedure_id',6).:;
                        //$complemento = EconomicComplement::where('');
                    }
                    else{
                        $this->info("no existe aplicant: ".$ci);
                    }
                }


                if($complemento)
                {

                    switch ($row->clase_renta) {
                                case 'VEJEZ':
                                    # code...
                                    $complemento->eco_com_kind_rent_id=1;
                                    $vejes++;
                                    
                                    break;
                                case 'VIUDEDAD':
                                    # code..
                                    $complemento->eco_com_kind_rent_id=2;
                                    $viudeda++;
                                    
                                    break;

                                case 'ORFANDAD':
                                    # code...
                                    $complemento->eco_com_kind_rent_id=3;
                                    $orfandad++;
                                    // array_push($id_orfandad, $complemento->id);
                                    break;  

                                case 'ORFANDAD DOBLE':
                                    # code...
                                    $complemento->eco_com_kind_rent_id=4;
                                    $orfandadDoble++;
                                    // array_push($id_orfandadDoble, $complemento->id);
                                    break;                            
                                
                                case 'INVALIDEZ':
                                    # code...
                                    $complemento->eco_com_kind_rent_id=5;
                                    $invalidez++;
                                    // array_push($id_invalidez, $complemento->id);
                                    break;

                                case 'INC.PARCIAL PERMANEN':
                                    # code...
                                    $complemento->eco_com_kind_rent_id=6;
                                    $parcial++;
                                    // array_push($id_parcial, $complemento->id);
                                    break;

                                case 'INC.TOTAL PERMANENTE':
                                    # code...
                                    $complemento->eco_com_kind_rent_id=7;
                                    $total++;
                                    // array_push($id_total, $complemento->id);
                                    break;




                    }

                    $complemento->save();

                    switch ($complemento->eco_com_modality_id) {
                        case 1:
                        case 4:
                        case 6:
                        case 8:

                                array_push($id_vejes, $complemento->id);        
                        break;

                        case 2:
                        case 5:
                        case 7:
                        case 9:

                                array_push($id_viudeda, $complemento->id);
                        break;
                      
                    }
                    

                }


                
            }

            $eco_vejes  = EconomicComplement::where('eco_com_procedure_id',6)->whereIn('eco_com_modality_id',[1,4,6,8])->select('id')->get();

            $eco_viudedad  = EconomicComplement::where('eco_com_procedure_id',6)->whereIn('eco_com_modality_id',[2,5,7,9])->select('id')->get();
            
            $this->info("eco_vejes: ".$eco_vejes->count());
            $this->info("eco_viudedad: ".$eco_viudedad->count());

            $id_v=array();
            $id_vd=array();

            $this->info("buscando a no importados vejes");

            foreach ($eco_vejes as $eco) {
                if(!in_array($eco->id, $id_vejes))
                {
                    array_push($id_v, $eco->id);
                }
            }
            
            $this->info("buscando a no importados viudeda");

            foreach ($eco_viudedad as $eco) {
                if(!in_array($eco->id, $id_viudeda))
                {
                    array_push($id_v, $eco->id);
                }
            }

            $this->info("Cechus y Anita 2017 ® ™");
            $this->info("vejes: ".$vejes );
            $this->info("viudeda: ".$viudeda );
            $this->info("orfandad: ".$orfandad );
            $this->info("orfandadDoble: ".$orfandadDoble );
            $this->info("invalidez: ".$invalidez );
            $this->info("parcial: ".$parcial );
            $this->info("total: ".$total );
            // $this->info("ci:".$row->ci);
            // $this->info("clase de renta".$row->clase_renta);
            $this->info("________________");

            $this->info("Total importados: ".($vejes+$viudeda+$orfandad+$orfandadDoble+$invalidez+$parcial+$total));

            $this->info("vejes: ".json_encode($id_vejes ));
            $this->info("viudeda: ".json_encode($id_viudeda ));
            
            $this->info("vejes size: ".sizeof($id_vejes ));
            $this->info("viudeda size: ".sizeof($id_viudeda ));

            $this->info("no encontrados vejes: ".json_encode($id_v));
            $this->info("no encontrados viudedad: ".json_encode($id_vd));
            // $this->info("orfandad: ".json_encode($id_orfandad ));
            // $this->info("orfandadDoble: ".json_encode($id_orfandadDoble));
            // $this->info("invalidez: ".json_encode($id_invalidez ));
            // $this->info("parcial: ".json_encode($id_parcial ));
            // $this->info("total: ".json_encode($id_total ));
        });

    }

}
