<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Affiliate;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementApplicant;
use DB;

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

       
        //$this->info($ci);
        // $re = '/[^0*].*/';
        // $str = '00abf-1f';

        // preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        // dd($matches[0][0]);

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

            $file_titulares=array();
            $file_benefeciarios=array();

            $no_founded = array();
            $beneficiarios =0;

            $ci_vejes =array();
            $ci_viudedad =array();
            // $rows = $reader->get("ci");



            //dd('terminando XD');
            $eco_vejes  = EconomicComplement::join('affiliates','affiliates.id','=','economic_complements.affiliate_id')
                                            ->where('eco_com_procedure_id',6)
                                            ->where('affiliates.pension_entity_id',5)
                                            ->whereIn('eco_com_modality_id',[1,4,6,8])
                                            ->select('economic_complements.id','affiliates.identity_card')
                                            ->get();

            $eco_viudedad = EconomicComplement::join('affiliates','affiliates.id','=','economic_complements.affiliate_id')
                                            ->join('eco_com_applicants','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                            ->where('eco_com_procedure_id',6)
                                            ->where('affiliates.pension_entity_id',5)
                                            ->whereIn('eco_com_modality_id',[2,5,7,9])
                                            ->select('economic_complements.id','eco_com_applicants.identity_card')
                                            ->get();
            
            $this->info("eco_vejes: ".$eco_vejes->count());
            $this->info("eco_viudedad: ".$eco_viudedad->count());


            foreach ($rows as $row) {

                $ext = trim($row->ext);

                if(strlen($ext)>0)
                {
                    $ci = $row->ci.'-'.$row->ext;
                }
                else
                {
                    $ci = $row->ci;
                }

                $complemento = null;
                //$this->info($row->renta);

                if($row->renta=='TITULAR'){


                    $file_titulares[]=$ci;
                    
                    // $afiliado = $eco_vejes->filter(function($eco)use($ci)  {
                    //     return $eco->identity_card = $ci;
                    // });


                    $afiliado = Affiliate::where('identity_card','=',$ci)
                                ->where('pension_entity_id',5)
                                ->first();

                    if(!$afiliado)
                    {
                        $afiliado = Affiliate::where('identity_card','like','0%'.$ci)
                                    ->where('pension_entity_id',5)
                                    ->first();
                    }


                    //$this->info($afiliado);
                    if($afiliado)
                    {
                       // $this->info("afiliado: ".$afiliado->id);
                       
                        $complemento = EconomicComplement::where('affiliate_id',$afiliado->id)
                                       ->where('eco_com_procedure_id',6)
                                       ->whereIn('eco_com_modality_id',[1,4,6,8])
                                       ->first();
                        
                        if($complemento)
                        {
                            // $vejes++;
                            $ci_vejes[]=$afiliado->identity_card;
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

                                default:
                                    # code...
                                        array_push($no_founded, $complemento->id);
                                        
                                    break;
                              

                            }
                        }
                        
                    }
                        
                          
                    

                }
                else
                {
                    $file_benefeciarios[]=$ci;

                    $complemento = DB::table('economic_complements')
                                            ->join('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                                            ->join('affiliates','affiliates.id','=','economic_complements.affiliate_id')
                                            ->where('eco_com_applicants.identity_card','=',$ci)
                                            ->whereIn('economic_complements.eco_com_modality_id',[2,5,7,9])
                                            ->where('economic_complements.eco_com_procedure_id',6)
                                            ->where('affiliates.pension_entity_id',5)
                                            ->select('economic_complements.id','eco_com_applicants.identity_card','economic_complements.eco_com_modality_id')
                                            // ->where('economic_complements.s')
                                            ->first();
                    if(!$complemento)
                    {
                        $complemento = DB::table('economic_complements')
                                            ->join('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                                            ->join('affiliates','affiliates.id','=','economic_complements.affiliate_id')
                                            ->where('eco_com_applicants.identity_card','like','0%'.$ci)
                                            ->whereIn('economic_complements.eco_com_modality_id',[2,5,7,9])
                                            ->where('economic_complements.eco_com_procedure_id',6)
                                            ->where('affiliates.pension_entity_id',5)
                                            ->select('economic_complements.id','eco_com_applicants.identity_card','economic_complements.eco_com_modality_id')
                                            // ->where('economic_complements.s')
                                            ->first();
                    }



                    if($complemento)
                    {   
                        $ec = $complemento;
                        $complemento= EconomicComplement::where('id',$ec->id)->first();
                        $beneficiarios++;

                        $ci_viudedad[]=$complemento->identity_card;
                        
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

                            default:
                                # code...
                                    array_push($no_founded, $complemento->id);
                                    
                                break;
                          
                        }
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
                }



                
            }//end for


            $id_v=array();
            $id_vd=array();

            $this->info("buscando a no importados vejes");

            foreach ($eco_vejes as $eco) {


                $id_v[]=$eco->identity_card;

                if(!in_array($eco->identity_card, $ci_vejes))
                {
                    $this->info("ci no encontrado:".$eco->identity_card);
                }
            }
 
            // dd($id_v);
            // $this->info("No encontrados viudad ".json_encode($no_founded));
            // $this->info("con complemento a vejes: ".$vejes);
            // $this->info("Encontrados por vejes ".sizeof($id_vejes));
            // $this->info("Encontrados por Viudedad ".sizeof($id_viudeda));
            // $this->info("con complemento".$beneficiarios);
            // $this->info("buscando dentro ".sizeof($eco_viudedad));
           // $no_founded = null;
            $no_foundedv = array();

            foreach ($eco_viudedad as $eco) {

                

                if(!in_array($eco->id, $id_viudeda))
                {
                    $this->info("No se encontro a la viuda hdp id_complemento:".$eco->id);
                }
                
            }
            $this->info("beneficiarios : ".$beneficiarios);

            // $this->info("No encontrados viudeda".json_encode($no_foundedv));
            $this->info("Encontrados por vejes ".sizeof($id_vd));
         //  dd("............................................................");

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

            // // $this->info("vejes: ".json_encode($id_vejes ));
            // // $this->info("viudeda: ".json_encode($id_viudeda ));
            
            // $this->info("vejes size: ".sizeof($id_vejes ));
            // $this->info("viudeda size: ".sizeof($id_viudeda ));
            
            // $this->info("_____________________________");
            // $this->info("encontrados vejes: ".json_encode($id_v));
            // $this->info("_____________________________");
            // $this->info("encontrados viudedad: ".json_encode($id_vd));

            // $this->info("no encontrados : ".sizeof($no_founded));

            // $this->info("orfandad: ".json_encode($id_orfandad ));
            // $this->info("orfandadDoble: ".json_encode($id_orfandadDoble));
            // $this->info("invalidez: ".json_encode($id_invalidez ));
            // $this->info("parcial: ".json_encode($id_parcial ));
            // $this->info("total: ".json_encode($id_total ));
        });

    }

}
