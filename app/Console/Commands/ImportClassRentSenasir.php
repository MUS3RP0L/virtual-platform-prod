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
                //$this->info($row->renta);

                if($row->renta=='TITULAR'){


                    $file_titulares[]=$ci;
                    
                    // $afiliado = $eco_vejes->filter(function($eco)use($ci)  {
                    //     return $eco->identity_card = $ci;
                    // });
                    $afiliado = Affiliate::where('identity_card','=',$ci)->first();
                    $this->info($afiliado);
                    if($afiliado)
                    {
                        $this->info("afiliado: ".$afiliado->id);

                        $complemento = EconomicComplement::where('affiliate_id',$afiliado->id)->where('eco_com_procedure_id',6)->first();

                        if(!$complemento)
                        {
                            $complemento = EconomicComplement::where('affiliate_id','0'.$afiliado->id)->where('eco_com_procedure_id',6)->first();
                        }
                        $this->info("no existe el afiliado ".$ci); 
                            
                        }

                        if($complemento)
                        {
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
                else
                {
                    $file_benefeciarios[]=$ci;
                    // $aplicants = EconomicComplementApplicant::where('identity_card',$ci)->get();
                    // if($aplicants)
                    // {
                    //     foreach ($aplicants as $aplicant) {
                    //         # code...
                    //         $com = EconomicComplement::where('id',$aplicant->economic_complement_id)->where('eco_com_procedure_id',6)->first();
                    //         if($com)
                    //         {
                    //             $complemento = $com;
                    //         }
                    //     }
                    //     // $this->info("aplicant: ".$aplicant->economic_complement->where('eco_com_procedure_id',6).:;
                    //     //$complemento = EconomicComplement::where('');
                    // }

                    // if(!$complemento)
                    // {
                    //      foreach ($aplicants as $aplicant) {
                    //         # code...
                    //         $com = EconomicComplement::where('id','0'.$aplicant->economic_complement_id)->where('eco_com_procedure_id',6)->first();
                    //         if($com)
                    //         {
                    //             $complemento = $com;
                    //         }
                    //     }
                    // }

                    // if($complemento)
                    // {
                    //     $beneficiarios++;
                    //     switch ($complemento->eco_com_modality_id) {
                    //         case 1:
                    //         case 4:
                    //         case 6:
                    //         case 8:

                    //                 array_push($id_vejes, $complemento->id);        
                    //         break;

                    //         case 2:
                    //         case 5:
                    //         case 7:
                    //         case 9:

                    //                 array_push($id_viudeda, $complemento->id);
                    //         break;

                    //         default:
                    //             # code...
                    //                 array_push($no_founded, $complemento->id);
                                    
                    //             break;
                          
                    //     }
                    // }
                    

                }




             

                //----------------------------------------------------------- hasta aqui busqueda

                // if($complemento)
                // {

                //     switch ($row->clase_renta) {
                //                 case 'VEJEZ':
                //                     # code...
                //                     $complemento->eco_com_kind_rent_id=1;
                //                     $vejes++;
                                    
                //                     break;
                //                 case 'VIUDEDAD':
                //                     # code..
                //                     $complemento->eco_com_kind_rent_id=2;
                //                     $viudeda++;
                                    
                //                     break;

                //                 case 'ORFANDAD':
                //                     # code...
                //                     $complemento->eco_com_kind_rent_id=3;
                //                     $orfandad++;
                //                     // array_push($id_orfandad, $complemento->id);
                //                     break;  

                //                 case 'ORFANDAD DOBLE':
                //                     # code...
                //                     $complemento->eco_com_kind_rent_id=4;
                //                     $orfandadDoble++;
                //                     // array_push($id_orfandadDoble, $complemento->id);
                //                     break;                            
                                
                //                 case 'INVALIDEZ':
                //                     # code...
                //                     $complemento->eco_com_kind_rent_id=5;
                //                     $invalidez++;
                //                     // array_push($id_invalidez, $complemento->id);
                //                     break;

                //                 case 'INC.PARCIAL PERMANEN':
                //                     # code...
                //                     $complemento->eco_com_kind_rent_id=6;
                //                     $parcial++;
                //                     // array_push($id_parcial, $complemento->id);
                //                     break;

                //                 case 'INC.TOTAL PERMANENTE':
                //                     # code...
                //                     $complemento->eco_com_kind_rent_id=7;
                //                     $total++;
                //                     // array_push($id_total, $complemento->id);
                //                     break;




                //     }

                //     $complemento->save();

                //     // switch ($complemento->eco_com_modality_id) {
                //     //     case 1:
                //     //     case 4:
                //     //     case 6:
                //     //     case 8:

                //     //             array_push($id_vejes, $complemento->id);        
                //     //     break;

                //     //     case 2:
                //     //     case 5:
                //     //     case 7:
                //     //     case 9:

                //     //             array_push($id_viudeda, $complemento->id);
                //     //     break;
                      
                //     // }
                    

                // }


                
            }//end for



            $this->info("Titulares ".sizeof($file_titulares));
            $this->info("beneficiarios ".sizeof($file_benefeciarios));
            
            $this->info("vejes size: ".sizeof($id_vejes ));
            $this->info("viudeda size: ".sizeof($id_viudeda ));

            dd('terminando XD');
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
            //dd($file_benefeciarios);

            $id_v=array();
            $id_vd=array();

            $this->info("buscando a no importados vejes");

            foreach ($eco_vejes as $eco) {

                
                $re = '/[^0*].*/';
                //$str = '00abf-1f';

                preg_match_all($re, $eco->identity_card, $matches, PREG_SET_ORDER, 0);
                $ci= $matches[0][0];

                if(in_array($ci, $file_titulares))
                {
                    array_push($id_v, $eco->id);
                }else {
                    # code...
                    $this->info("no encontrado:".$ci);
                    array_push($no_founded, $eco->id);
                    //dd(json_encode($file_titulares));

                }
            }
            // dd($id_v);
            $this->info("No encontrados vejes".json_encode($no_founded));
            //dd("Encontrados por vejes ".sizeof($id_v));

            $this->info("buscando a no importados viudeda");
           // $no_founded = null;
            $no_foundedv = array();
            foreach ($eco_viudedad as $eco) {

                 $re = '/[^0*].*/';
                //$str = '00abf-1f';

                preg_match_all($re, $eco->identity_card, $matches, PREG_SET_ORDER, 0);
                $ci= $matches[0][0];

                if(in_array($ci, $file_benefeciarios))
                {
                    array_push($id_vd, $eco->id);
                }
                else
                {
                    $this->info("no encontrado:".$ci);
                    array_push($no_foundedv, $eco->id);
                }
            }

            $this->info("No encontrados viudeda".json_encode($no_foundedv));

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

            // $this->info("vejes: ".json_encode($id_vejes ));
            // $this->info("viudeda: ".json_encode($id_viudeda ));
            
            $this->info("vejes size: ".sizeof($id_vejes ));
            $this->info("viudeda size: ".sizeof($id_viudeda ));
            
            $this->info("_____________________________");
            $this->info("encontrados vejes: ".json_encode($id_v));
            $this->info("_____________________________");
            $this->info("encontrados viudedad: ".json_encode($id_vd));

            $this->info("no encontrados : ".sizeof($no_founded));
            $this->info("beneficiarios : ".$beneficiarios);

            // $this->info("orfandad: ".json_encode($id_orfandad ));
            // $this->info("orfandadDoble: ".json_encode($id_orfandadDoble));
            // $this->info("invalidez: ".json_encode($id_invalidez ));
            // $this->info("parcial: ".json_encode($id_parcial ));
            // $this->info("total: ".json_encode($id_total ));
        });

    }

}
