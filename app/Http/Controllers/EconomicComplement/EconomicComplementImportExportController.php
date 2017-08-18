<?php
namespace Muserpol\Http\Controllers\EconomicComplement;
use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Factory;
use Storage;
use File;
use Log;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use Muserpol\Helper\Util;
use Maatwebsite\Excel\Facades\Excel;

use Muserpol\Affiliate;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementProcedure;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementLegalGuardian;
use stdClass;

use App\CustomCollection;

class EconomicComplementImportExportController extends Controller
{

    public function index()
    {

    }

    public static function import_from_senasir(Request $request)
    {
        if($request->hasFile('archive'))
        {
          global $year, $semester, $results,$i,$afi,$list;
          $reader = $request->file('archive');
          $filename = $reader->getRealPath();
          $year = $request->year;
          $semester = $request->semester;
          Excel::load($filename, function($reader) {
                  global $results,$i,$afi,$list;
                  ini_set('memory_limit', '-1');
                  ini_set('max_execution_time', '-1');
                  ini_set('max_input_time', '-1');
                  set_time_limit('-1');
                  $results = collect($reader->get());
          });

        //  return response()->json($results);
          $afi;
          $found=0;
          $nofound=0;
          $procedure = EconomicComplementProcedure::whereYear('year','=',$year)->where('semester','=',$semester)->first();
          foreach ($results as $datos) {
            
            $ext = ($datos->num_com ? "-".$datos->num_com : '');
            $ext = str_replace(' ','', $ext);                                  
            if($datos->renta == "DERECHOHABIENTE"){
              $comp = DB::table('eco_com_applicants') // VIUDEDAD
                  ->select(DB::raw('eco_com_applicants.identity_card as ci_app,economic_complements.*, eco_com_types.id as type'))
                  ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                  ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')                                            
                  ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                  ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                  ->whereRaw("LTRIM(eco_com_applicants.identity_card,'0') ='".rtrim($datos->carnet.''.$ext)."'")
                  ->where('eco_com_types.id','=', 2)
                  ->where('affiliates.pension_entity_id','=', 5)
                  ->whereYear('economic_complements.year', '=', $year)
                  ->where('economic_complements.semester', '=', $semester)->first();
            }
            elseif($datos->renta == "TITULAR")
            {
                $comp = DB::table('eco_com_applicants') // VEJEZ
                  ->select(DB::raw('eco_com_applicants.identity_card as ci_app,economic_complements.*, eco_com_types.id as type'))
                  ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                  ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')                                            
                  ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                  ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                  ->whereRaw("LTRIM(eco_com_applicants.identity_card,'0') ='".rtrim($datos->carnet.''.$ext)."'")                
                  ->where('eco_com_types.id','=', 1)
                  ->where('affiliates.pension_entity_id','=', 5)
                  ->whereYear('economic_complements.year', '=', $year)
                  ->where('economic_complements.semester', '=', $semester)->first();
            }
            else
            {
                $comp = DB::table('eco_com_applicants') // ORFANDAD
                  ->select(DB::raw('eco_com_applicants.identity_card as ci_app,economic_complements.*, eco_com_types.id as type'))
                  ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                  ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')                                            
                  ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                  ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                  ->whereRaw("LTRIM(eco_com_applicants.identity_card,'0') ='".rtrim($datos->carnet.''.$ext)."'")                
                  ->where('eco_com_types.id','=', 3)
                  ->where('affiliates.pension_entity_id','=', 5)
                  ->whereYear('economic_complements.year', '=', $year)
                  ->where('economic_complements.semester', '=', $semester)->first();
            } 
            $procedure = EconomicComplementProcedure::whereYear('year','=',$year)->where('semester','=',$semester)->first();          
            if ($comp && $procedure->indicator > 0)
            {
               
                $ecomplement = EconomicComplement::where('id','=', $comp->id)->first();
                if (is_null($ecomplement->total_rent))
                {
                  $reimbursements = $datos->reintegro_importe_adicional + $datos->reintegro_inc_gestion;
                  $discount = $datos->renta_dignidad + $datos->reintegro_renta_dignidad + $datos->reintegro_importe_adicional + $datos->reintegro_inc_gestion;
                  $total_rent = $datos->total_ganado - $discount;
                  
                  if($comp->type == 1 && $total_rent < $procedure->indicator)  //Vejez Senasir
                  {
                    $ecomplement->eco_com_modality_id = 8;
                  } 
                  elseif ($comp->type == 2 && $total_rent < $procedure->indicator) //Viudedad 
                  {  
                    $ecomplement->eco_com_modality_id = 9;
                  } 
                  elseif($comp->type == 3 && $total_rent < $procedure->indicator) //Orfandad 
                  {  
                      $ecomplement->eco_com_modality_id = 12;
                  }
                  $ecomplement->sub_total_rent = $datos->total_ganado;                
                  $ecomplement->total_rent =  $total_rent;
                  $ecomplement->dignity_pension = $datos->renta_dignidad;
                  $ecomplement->reimbursement = $reimbursements;
                  $ecomplement->rent_type ='Automatico';
                  $ecomplement->save();                
                  $found ++;
                }
                  
            }
            else{
              $nofound ++;
              $i ++;
              $list = $comp;
            }
          }          
              
          Session::flash('message', "Importación Exitosa"." F:".$found." NF:".$nofound);
          return redirect('economic_complement');
        }
        return back();
    }

    public static function import_from_aps(Request $request) {

      if($request->hasFile('archive'))
      {
        global $year, $semester, $results,$i,$afi,$list;
        $reader = $request->file('archive');
        $filename = $reader->getRealPath();
        $year = $request->year;
        $semester = $request->semester;
        Excel::load($filename, function($reader) {
                global $results,$i,$afi,$list;
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', '-1');
                ini_set('max_input_time', '-1');
                set_time_limit('-1');
                $results = collect($reader->get());
        });

        $afi;
        $found=0;
        $nofound=0; 
        $procedure = EconomicComplementProcedure::whereYear('year','=',$year)->where('semester','=',$semester)->first();    
        foreach ($results as $datos)
        {   
            $nua = ltrim((string)$datos->nrosip_titular, "0");
            $ci = explode("-",ltrim($datos->nro_identificacion, "0"));
            $ci1 = $ci[0];            
            $afi = DB::table('economic_complements')
                  ->select(DB::raw('affiliates.identity_card as ci_afi,economic_complements.*, eco_com_types.id as type'))     
                  ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')                                 
                  ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                  ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                  ->whereRaw("split_part(LTRIM(affiliates.identity_card,'0'), '-',1) = '".$ci1."'")
                  ->whereRaw("LTRIM(affiliates.nua::text,'0') ='".$nua."'")        
                  ->where('affiliates.pension_entity_id','!=', 5)
                  ->whereYear('economic_complements.year', '=', $year)
                  ->where('economic_complements.semester', '=', $semester)->first();

            
              if ($afi)
              { $ecomplement = EconomicComplement::where('id','=', $afi->id)->first(); 
                if ((is_null($ecomplement->total_rent) || $ecomplement->total_rent == 0) && $procedure->indicator > 0 )
                {                              
                    $comp1 = 0;
                    $comp2 = 0;
                    $comp3 = 0;
                    if ($datos->total_cc > 0) {
                        $comp1 = 1;
                    }
                    if ($datos->total_fsa > 0) {
                        $comp2 = 1;
                    }
                    if($datos->total_fs > 0) {
                        $comp3 = 1;
                    }
                    $comp = $comp1 + $comp2 + $comp3;
                                                  
                    

                    //Vejez
                    if ($afi->type == 1 )
                    {
                       if ($comp == 1 && $datos->total_pension >= $procedure->indicator)
                       {
                          $ecomplement->eco_com_modality_id = 4;
                       }
                       elseif ($comp == 1 && $datos->total_pension < $procedure->indicator)
                       {
                          $ecomplement->eco_com_modality_id = 6;
                       }
                       elseif ($comp > 1 && $datos->total_pension < $procedure->indicator)
                       {
                          $ecomplement->eco_com_modality_id = 8;
                       }
                    }
                   //Viudedad
                    elseif ($afi->type == 2) 
                    {
                       if($comp == 1 && $datos->total_pension >= $procedure->indicator) 
                       {
                           $ecomplement->eco_com_modality_id = 5;
                       } elseif ($comp == 1 && $datos->total_pension < $procedure->indicator) 
                       {
                            $ecomplement->eco_com_modality_id = 7;
                       } elseif ($comp > 1 && $datos->total_pension < $procedure->indicator ) 
                       {
                           $ecomplement->eco_com_modality_id = 9;
                       }
                    }
                    else
                    { //ORFANDAD
                      if ($comp == 1 && $datos->total_pension >= $procedure->indicator)
                       {
                          $ecomplement->eco_com_modality_id = 10;
                       }
                       elseif ($comp == 1 && $datos->total_pension < $procedure->indicator)
                       {
                          $ecomplement->eco_com_modality_id = 11;
                       }
                       elseif ($comp > 1 && $datos->total_pension < $procedure->indicator)
                       {
                          $ecomplement->eco_com_modality_id = 12;
                       }
                    }
                    $ecomplement->total_rent = $datos->total_pension;
                    $ecomplement->aps_total_cc = $datos->total_cc;
                    $ecomplement->aps_total_fsa = $datos->total_fsa;
                    $ecomplement->aps_total_fs = $datos->total_fs;
                    $ecomplement->rent_type ='Automatico';
                    $ecomplement->save();                  
                    $found ++;
                    Log::info($ci);
                }
              }
              else
              {
                $nofound ++;
                $i ++;
                $list[] = $datos;
              }
            
          }
          
          Session::flash('message', "Importación Exitosa"." F:".$found." NF:".$nofound);
          return redirect('economic_complement');
    }
  }

  public static function import_from_bank(Request $request) {
    //substr_replace($string ,"",-1);
    if($request->hasFile('archive'))
    {
      global $year, $semester, $results,$i,$afi,$list;
      $reader = $request->file('archive');
      $filename = $reader->getRealPath();
      $year = $request->year;
      $semester = $request->semester;
      Excel::load($filename, function($reader) {
              global $results,$i,$afi,$list;
              ini_set('memory_limit', '-1');
              ini_set('max_execution_time', '-1');
              ini_set('max_input_time', '-1');
              set_time_limit('-1');
              $results = collect($reader->get());
      });

      $afi;
      $found=0;
      $nofound=0;
      //return response()->json($results);
      foreach ($results as $valor){
          $ci = substr_replace($valor->carnet,"",-2);
          $card = rtrim($ci);
        //  return response()->json($card);
          $afi = DB::table('economic_complements')
            ->select(DB::raw('economic_complements.*'))
            ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
            ->where('affiliates.identity_card', '=',rtrim($card))
            ->whereYear('economic_complements.review_date', '=', $year)
            ->where('economic_complements.semester', '=', $semester)
            ->where('economic_complements.eco_com_state_id', '=', 2)->first();
            if ($afi){
                $ecomplement = EconomicComplement::where('affiliate_id','=', $afi->affiliate_id)->whereYear('review_date','=', $afi->review_date)->where('semester','=', $afi->semester)->where('eco_com_state_id','=', $afi->eco_com_state_id)->first();
                $ecomplement->eco_com_state_id = 4;
                $ecomplement->total = $valor->monto_asignado;
                $ecomplement->payment_number = $valor->nro_comprobante;
                $ecomplement->payment_date = $valor->fecha_pago;
                $ecomplement->save();
                $found ++;
            }
            else{
              $nofound ++;
              $i ++;
              $list[]= $valor;
            }
        }
        //return response()->json($list);
        //export record no found
        Excel::create('REPORTE_BANCO_NO_ENCONTRADO', function($excel) {
            global $list, $j,$k;
            $j = 2;
            $k=1;
            $excel->sheet('Lista_Banco', function($sheet) {
            global $list, $j,$k;
            $sheet->row(1, array('NRO', 'DEPARTAMENTO','CARNET','NOMBRE','MONTO_ASIGNADO','DESCRIPCION1','DESCRIPCION2','NRO_COMPROBANTE','FECHA_PAGO'));
            foreach ($list as $datos) {
                $sheet->row($j, array($k,$datos->departamento,$datos->carnet,$datos->nombre, $datos->monto_asignado,$datos->descripcion1,$datos->descripcion2,$datos->nro_comprobante,$datos->fecha_pago));
                $j++;
                $k++;
            }

          });

        })->export('xlsx');
        Session::flash('message', "Importación Exitosa"." F:".$found." NF:".$nofound);
        return redirect('economic_complement');
  }

  }

    //############################################## EXPORT AFFILIATES TO APS ###################################
    public function export_to_aps(Request $request)
    {
        global $year, $semester,$i,$afi;
       $year = $request->year;
       $semester = $request->semester;
       Excel::create('Muserpol_para_aps', function($excel) {
                 global $year,$semester, $j;
                 $j = 2;
                 $excel->sheet("AFILIADOS_PARA_APS_".$year, function($sheet) {
                 global $year,$semester, $j, $i;
                 $i=1;
                 $sheet->row(1, array('NRO', 'TIPO_ID', 'NUM_ID', 'EXTENSION', 'CUA', 'PRIMER_APELLIDO_T', 'SEGUNDO_APELLIDO_T','PRIMER_NOMBRE_T','SEGUNDO_NOMBRE_T','APELLIDO_CASADA_T','FECHA_NACIMIENTO_T'));
                 $afi = DB::table('eco_com_applicants')
                     ->select(DB::raw('economic_complements.id,economic_complements.affiliate_id,affiliates.identity_card,cities.third_shortened,affiliates.nua,affiliates.last_name,affiliates.mothers_last_name,affiliates.first_name,affiliates.second_name,affiliates.surname_husband,affiliates.birth_date'))
                     ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                     ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                     ->leftJoin('cities', 'affiliates.city_identity_card_id', '=', 'cities.id')
                     ->where('affiliates.pension_entity_id','<>', 5)
                     //->where('economic_complements.sub_total_rent','>', 0)
                     //->whereNull('economic_complements.total_rent')
                     ->whereYear('economic_complements.year', '=', $year)                     
                     ->where('economic_complements.semester', '=', $semester)->get();
                 foreach ($afi as $datos) {
                     $sheet->row($j, array($i, "I",Util::addcero($datos->identity_card,13),$datos->third_shortened,Util::addcero($datos->nua,9), $datos->last_name, $datos->mothers_last_name,$datos->first_name, $datos->second_name, $datos->surname_husband,Util::DateUnion($datos->birth_date)));
                     $j++;
                     $i++;
                 }
               });
           })->export('xlsx');
             Session::flash('message', "Importación Exitosa");
             return redirect('economic_complement');
    }

    public function export_to_bank(Request $request)
    {
      global $year, $semester,$i,$afi,$semester1;
      $year = $request->year;
      $semester = $request->semester;
      $afi = DB::table('eco_com_applicants')
          ->select(DB::raw("economic_complements.id,economic_complements.affiliate_id,economic_complements.semester,cities0.second_shortened as regional,eco_com_applicants.identity_card,cities1.first_shortened as ext,concat_ws(' ', NULLIF(eco_com_applicants.first_name,null), NULLIF(eco_com_applicants.second_name, null), NULLIF(eco_com_applicants.last_name, null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null)) as full_name,economic_complements.total as importe,eco_com_modalities.shortened as modality,degrees.shortened as degree"))
          ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
          ->leftJoin('cities as cities0', 'economic_complements.city_id', '=', 'cities0.id')
          ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')          
          ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
          ->leftJoin('degrees', 'economic_complements.degree_id', '=', 'degrees.id')         
          ->whereYear('economic_complements.year', '=', $year)
          ->where('economic_complements.semester', '=', $semester)
          ->where('economic_complements.workflow_id','=',1)
          ->where('economic_complements.wf_current_state_id',2)
          ->where('economic_complements.state','Edited')
          ->where('economic_complements.total','>', 0)
          ->whereRaw('economic_complements.total_rent::numeric < economic_complements.salary_quotable::numeric')         
          ->whereRaw("not exists(select affiliates.id from affiliate_observations where affiliates.id = affiliate_observations.affiliate_id and affiliate_observations.observation_type_id IN(1,2,3,12,13) and is_enabled = false ) ")         
          ->whereNotNull('economic_complements.review_date')->get();     
      

      if($afi){
            if($semester == "Primer")
            {
              $semester1 = "MUSERPOL PAGO COMPLEMENTO ECONOMICO 1ER SEM ".$year;
              $abv ="Pago_Banco_Union_1ER_SEM_".$year;
            }
            else{
              $semester1 = "MUSERPOL PAGO COMPLEMENTO ECONOMICO 2DO SEM ".$year;
              $abv ="Export_for_Banco_Union_2DO_SEM_".$year;
            }
            Excel::create($abv, function($excel) {
                global $year,$semester,$afi,$j,$semester1;
                $j = 2;
                $excel->sheet("AFILIADOS_PARA_APS_".$year, function($sheet) {
                  //$sheet->setColumnFormat(array(
                   //   'D' => '0,000.00'
                  //));
                global $year,$semester, $afi,$j, $i,$semester1;
                $i=1;
                $sheet->row(1, array('DEPARTAMENTO','IDENTIFICACION','NOMBRE_Y_APELLIDO','IMPORTE_A_PAGAR','MONEDA_DEL_IMPORTE','DESCRIPCION_1','DESCRIPCION_2','DESCRIPCION_3'));
             
                foreach ($afi as $datos) 
                {
                    $economic =  EconomicComplement::idIs($datos->id)->first();

                    //$import = number_format($datos->importe, 2, '.', ',');
                    $import=$datos->importe;
                    if ($economic->has_legal_guardian)
                    {
                     
                      $legal1 = EconomicComplementLegalGuardian::where('economic_complement_id','=', $economic->id)->first();
                      $sheet->row($j, array($datos->regional,$legal1->identity_card." ".$legal1->city_identity_card->first_shortened,$legal1->getFullName(), $import,"1",$datos->modality." - ".$datos->degree,$datos->affiliate_id,$semester1));                     
                      
                    }
                    else
                    {
                      
                      $apl =EconomicComplement::find($datos->id)->economic_complement_applicant;
                      $sheet->row($j, array($datos->regional,$datos->identity_card." ".$datos->ext,$apl->getFullName(), $import,"1",$datos->modality." - ".$datos->degree,$datos->affiliate_id,$semester1));  

                    }                   
                    
                    $j++;
                   
                }    
                           
              });
          })->export('xlsx');
          return redirect('economic_complement');
          Session::flash('message', "Importación Exitosa");

      }
      else {

        Session::flash('message', "No existen registros para exportar");
        return redirect('economic_complement');

      }


    }

    /* David */
    public function export_excel()
    {
        // $complementos = EconomicComplement::where('workflow_id','=','1')
        //                               // ->where('wf_current_state_id','=','2')
        //                               ->where('state','=','Edited')
        //                               ->get();   
      if(Auth::check())
      {
        $user_role_id=Auth::user()->roles()->first();
        Log::info("user_role_id = ".$user_role_id->id);
        $semestre = DB::table('eco_com_procedures')->orderBy('id','DESC')->first();

         $economic_complements=EconomicComplement::where('eco_com_state_id',16)
            ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
            ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
            ->leftJoin('eco_com_procedures','economic_complements.eco_com_procedure_id','=','eco_com_procedures.id')
            ->leftJoin('cities','economic_complements.city_id','=','cities.id')
            ->leftJoin('categories','economic_complements.category_id','=','categories.id')
            ->leftJoin('base_wages','economic_complements.base_wage_id','=','base_wages.id')
            ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')

            ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
            ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
            ->leftJoin('affiliate_observations','affiliates.id','=','affiliate_observations.affiliate_id')

            ->where('economic_complements.workflow_id','=','1')
            ->where('economic_complements.wf_current_state_id','2')
            ->where('economic_complements.state','Edited')
          //  ->where('economic_complements.eco_com_procedure_id',$semestre->id)
            ->where('economic_complements.eco_com_procedure_id','2')
            //->where('economic_complements.user_id',Auth::user()->id)


            ->select('economic_complements.review_date as Fecha','eco_com_applicants.identity_card as CI','cities.first_shortened as Exp_complemento','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.surname_husband as ap_esp','eco_com_applicants.birth_date as Fecha_nac','eco_com_applicants.nua','eco_com_applicants.phone_number as Telefono','eco_com_applicants.cell_phone_number as celular','eco_com_modalities.shortened as tipo_renta','eco_com_procedures.year as año_gestion','eco_com_procedures.semester as semestre','categories.name as categoria','degrees.shortened as Grado','base_wages.amount as Sueldo_base','economic_complements.code as Nro_proceso','pension_entities.name as Ente_gestor','affiliate_observations.date as Fecha_obs','affiliate_observations.message as Observacion')
           // ->select('economic_complements.id as id_base' ,'economic_complements.code as codigo')
            ->orderBy('economic_complements.review_date','ASC')
            ->get();

       //  return $economic_complements;
        //$fila = new CustomCollection(array('identificador' => ,$economic_complements-> ));
         Excel::create('Reporte General '.date("Y-m-d H:i:s"),function($excel) use ($economic_complements)
         {
                    
            
                        $excel->sheet('Reporte General',function($sheet) use ($economic_complements) {

                        $sheet->fromArray($economic_complements);
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
                  
                })->download('xls');

        //return $economic_complements;
       // return "contribuciones totales ".$economic_complements->count();
      }
      else
      {
        return "funcion no disponible revise su sesion de usuario";
      }
    }
     public function export_excel_user()
    {


        // $complementos = EconomicComplement::where('workflow_id','=','1')
        //                               // ->where('wf_current_state_id','=','2')
        //                               ->where('state','=','Edited')
        //                               ->get();   
      if(Auth::check())
      {
        $user_role_id=Auth::user()->roles()->first();
        //Log::info("user_role_id = ".$user_role_id->id);
        $semestre = DB::table('eco_com_procedures')->orderBy('id','DESC')->first();
      //  Log::info($semestre->id);
         $economic_complements=EconomicComplement::where('eco_com_state_id',16)
            ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
            ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
            ->leftJoin('eco_com_procedures','economic_complements.eco_com_procedure_id','=','eco_com_procedures.id')
            ->leftJoin('cities','economic_complements.city_id','=','cities.id')
            ->leftJoin('categories','economic_complements.category_id','=','categories.id')
            ->leftJoin('base_wages','economic_complements.base_wage_id','=','base_wages.id')
            ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')

            ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
            ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
            ->leftJoin('affiliate_observations','affiliates.id','=','affiliate_observations.affiliate_id')

            ->where('economic_complements.workflow_id','=','1')
            ->where('economic_complements.wf_current_state_id','2')
            ->where('economic_complements.state','Edited')
            ->where('economic_complements.eco_com_procedure_id','2')
            ->where('economic_complements.user_id',Auth::user()->id)


            ->select('economic_complements.review_date as Fecha','eco_com_applicants.identity_card as CI','cities.first_shortened as Exp','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.surname_husband as ap_esp','eco_com_applicants.birth_date as Fecha_nac','eco_com_applicants.nua','eco_com_applicants.phone_number as Telefono','eco_com_applicants.cell_phone_number as celular','eco_com_modalities.shortened as tipo_renta','eco_com_procedures.year as año_gestion','eco_com_procedures.semester as semestre','categories.name as categoria','degrees.shortened as Grado','base_wages.amount as Sueldo_base','economic_complements.code as Nro_proceso','pension_entities.name as Ente_gestor','affiliate_observations.date as Fecha_obs','affiliate_observations.message as Observacion')
             ->orderBy('economic_complements.review_date','ASC')
           // ->select('economic_complements.id as id_base' ,'economic_complements.code as codigo')
            ->get();

       //  return $economic_complements;
        //$fila = new CustomCollection(array('identificador' => ,$economic_complements-> ));
         Excel::create('Reporte '.date("Y-m-d H:i:s").' - '.Auth::user()->first_name.' '.Auth::user()->last_name,function($excel) use ($economic_complements)
         {
                    
            
                        $excel->sheet('Reporte usuario',function($sheet) use ($economic_complements) {

                        $sheet->fromArray($economic_complements);
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
                  
                })->download('xls');

        //return $economic_complements;
       // return "contribuciones totales ".$economic_complements->count();
      }
      else
      {
        return "funcion no disponible revise su sesion de usuario";
      }
    }
    public function export_excel_general()
    {
      // $complementos = EconomicComplement::where('workflow_id','=','1')
        //                               // ->where('wf_current_state_id','=','2')
        //                               ->where('state','=','Edited')
        //                               ->get();   
      if(Auth::check())
      {
        $user_role_id=Auth::user()->roles()->first();
        Log::info("user_role_id = ".$user_role_id->id);
        $semestre = DB::table('eco_com_procedures')->orderBy('id','DESC')->first();

         $economic_complements=EconomicComplement::whereNotNull('total_rent')
            ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
            ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
            ->leftJoin('eco_com_procedures','economic_complements.eco_com_procedure_id','=','eco_com_procedures.id')
            ->leftJoin('cities','economic_complements.city_id','=','cities.id')
            ->leftJoin('categories','economic_complements.category_id','=','categories.id')
            ->leftJoin('base_wages','economic_complements.base_wage_id','=','base_wages.id')
            ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')

            ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
            ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
            ->leftJoin('affiliate_observations','affiliates.id','=','affiliate_observations.affiliate_id')

            // ->where('economic_complements.workflow_id','=','1')
            // ->where('economic_complements.wf_current_state_id','2')
            // ->where('economic_complements.state','Edited')
          //  ->where('economic_complements.eco_com_procedure_id',$semestre->id)
            ->where('economic_complements.eco_com_procedure_id','2')
            //->where('economic_complements.user_id',Auth::user()->id)

            ->distinct('economic_complements.id')
            ->select('economic_complements.id','eco_com_applicants.identity_card as CI','cities.first_shortened as Exp','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.surname_husband as ap_esp','eco_com_applicants.birth_date as Fecha_nac','eco_com_applicants.nua','eco_com_applicants.phone_number as Telefono','eco_com_applicants.cell_phone_number as celular','eco_com_modalities.shortened as tipo_renta','eco_com_procedures.year as año_gestion','eco_com_procedures.semester as semestre','categories.name as categoria','degrees.shortened as Grado','economic_complements.total_rent as Renta_total','base_wages.amount as Sueldo_base','economic_complements.seniority as antiguedad','economic_complements.salary_quotable as Salario_cotizable','economic_complements.difference as direfencia','economic_complements.total_amount_semester as monto_total_semestre','economic_complements.complementary_factor as factor_de_complementacion','economic_complements.total','economic_complements.code as Nro_proceso','pension_entities.name as Ente_gestor','affiliate_observations.date as Fecha_obs','affiliate_observations.message as Observacion')
           // ->select('economic_complements.id as id_base' ,'economic_complements.code as codigo')
            // ->orderBy('economic_complements.review_date','ASC')
            ->get();

       //  return $economic_complements;
        //$fila = new CustomCollection(array('identificador' => ,$economic_complements-> ));
         Excel::create('Reporte General '.date("Y-m-d H:i:s"),function($excel) use ($economic_complements)
         {
                    
            
                        $excel->sheet('Reporte General Complemento',function($sheet) use ($economic_complements) {

                        $sheet->fromArray($economic_complements);
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
                  
                })->download('xls');

        //return $economic_complements;
       // return "contribuciones totales ".$economic_complements->count();
      }
      else
      {
        return "funcion no disponible revise su sesion de usuario";
      }
    }

    public function export_excel_observations()
    {
      if(Auth::check())
      {

 
        global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;




         
        $afiliados = DB::table('v_observados')->get();
        
        $a = array();
        foreach ($afiliados as $afiliado) {

          # code...
          $complementos = DB::table("economic_complements")->where('affiliate_id',$afiliado->id)->where('eco_com_procedure_id','=','2')->first();
          if($complementos){
             array_push($a, $afiliado->id);
          }
         
        }
        $afiliados = DB::table('v_observados')->whereIn('id',$a)->get();

        $com_obser_contabilidad_1 = array();
        $com_obser_prestamos_2 = array();
        $com_obser_juridica_3 = array();
        $com_obser_fueraplz90_4 = array();
        $com_obser_fueraplz120_5 = array();
        $com_obser_faltareq_6 = array();
        $com_obser_habitualinclusion7 = array();
        $com_obser_menor16anos_8 = array();
        $com_obser_invalidez_9 = array();
        $com_obser_salario_10 = array();
        $com_obser_pagodomicilio_12 = array();
        $com_obser_repofond_13 =array();


        foreach ($afiliados as $afiliado) {
          # code...
             $complementos = DB::table("economic_complements")->where('affiliate_id',$afiliado->id)
                                                              ->where('eco_com_procedure_id','=','2')
                                                              ->where('state','=','Edited')
                                                              ->whereNotNull('review_date')
                                                              ->get();
             if($complementos)
             {
               switch ($afiliado->observation_type_id) {
                 
                 case 1:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_contabilidad_1, $complemento->id);
                        }
                   break;
                 
                 case 2:
                   # code...
                        foreach ($complementos as $complemento) {

                          # code...
                          array_push($com_obser_prestamos_2, $complemento->id);
                        }
                   break;
                 
                 case 3:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_juridica_3, $complemento->id);
                        }
                   break;
                 
                 case 4:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_fueraplz90_4, $complemento->id);
                        }
                   break;
                 
                 case 5:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_fueraplz120_5, $complemento->id);
                        }
                   break;
                 
                 case 6:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_faltareq_6, $complemento->id);
                        }
                   break;
                 
                 case 7:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_habitualinclusion7, $complemento->id);
                        }
                   break;
                 
                 case 8:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_menor16anos_8, $complemento->id);
                        }
                   break;
                 
                 case 9:
                   # code..
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_invalidez_9, $complemento->id);
                        }
                   break;
                 
                 case 10:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_salario_10, $complemento->id);
                        }
                   break;
                 
                 case 12:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_pagodomicilio_12, $complemento->id);
                        }
                   break;
                 
                 case 13:
                   # code...
                        foreach ($complementos as $complemento) {
                          # code...
                          array_push($com_obser_repofond_13, $complemento->id);
                        }
                   break;


                 default:
                   # code...
                   break;
               }
               
             }

        }
        Log::info($com_obser_contabilidad_1);

        
       //  return $economic_complements;
        //$fila = new CustomCollection(array('identificador' => ,$economic_complements-> ));
         Excel::create('Reporte General '.date("Y-m-d H:i:s"),function($excel) 
         {
                     global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;               $excel->sheet('Observacion por contabilidad ',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;      
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_contabilidad_1)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Observacion por prestamos ',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_prestamos_2)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Observacion por juridica ',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_juridica_3)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });


                        $excel->sheet('Fuera de Plazo 90 días',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_fueraplz90_4)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Fuera de Plazo 120 días',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_fueraplz120_5)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Falta de Requisitos',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_faltareq_6)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });


                        $excel->sheet('Requisitos Hab a Incl',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_habitualinclusion7)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Menor a 16 años',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_menor16anos_8)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Observación por Invalidez',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_invalidez_9)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Observación por Salario',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_salario_10)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Pago a domicilio',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_pagodomicilio_12)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) {

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                        $excel->sheet('Reposicion de fondo',function($sheet) {

                         global $com_obser_contabilidad_1,$com_obser_prestamos_2,$com_obser_juridica_3,$com_obser_fueraplz90_4,$com_obser_fueraplz120_5,$com_obser_faltareq_6,$com_obser_habitualinclusion7,$com_obser_menor16anos_8,$com_obser_invalidez_9,$com_obser_salario_10,$com_obser_pagodomicilio_12,$com_obser_repofond_13;     
                         $economic_complements=EconomicComplement::whereIn('economic_complements.id',$com_obser_repofond_13)
                          ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                          ->leftJoin('cities as city_com','economic_complements.city_id','=','city_com.id')
                          ->leftJoin('cities as city_ben','eco_com_applicants.city_identity_card_id','=','city_ben.id')
                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                          ->distinct('economic_complements.id')
                          ->select('economic_complements.id as Id','economic_complements.code as Nro_tramite','eco_com_applicants.first_name as Primer_nombre','eco_com_applicants.second_name as Segundo_nombre', 'eco_com_applicants.last_name as Paterno','eco_com_applicants.mothers_last_name as Materno','eco_com_applicants.identity_card as CI','city_ben.first_shortened as Ext','city_com.name as Regional','degrees.shortened as Grado','eco_com_modalities.shortened as Tipo_renta','economic_complements.total as Complemento_Final','affiliates.id as affiliate_id')
                          ->get();

                        $rows = array(array('ID','Nro de Tramite','Nombres y Apellidos','C.I.','Ext','Regional','Grado','Tipo Renta','Complemento Económico Final','Observaciones'));
                        foreach ($economic_complements as $c) {
                          # code...
                          $observaciones = DB::table('affiliate_observations')->where('affiliate_id',$c->affiliate_id)->get();
                          $observacion = "";
                          foreach ($observaciones as $obs) {
                            # code...
                            $observacion = $observacion." | ".$obs->message; 
                          }

                          array_push($rows,array($c->Id,$c->Nro_tramite,$c->Primer_nombre.' '.$c->Segundo_nombre.' '.$c->Paterno.' '.$c->Materno,$c->CI,$c->Ext,$c->Regional,$c->Grado,$c->Tipo_renta,$c->Complemento_Final,$observacion));
                        }
                     
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function($cells) { 

                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');  

                        });

                        });

                })->download('xls');

        //return $economic_complements;
       // return "contribuciones totales ".$economic_complements->count();
      }
      else
      {
        return "funcion no disponible revise su sesion de usuario";
      }
    }

    public function planilla_general()
    { 
      global $rows;
        $afis = DB::table('eco_com_applicants')
          
          ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
          ->leftJoin('cities as cities0', 'economic_complements.city_id', '=', 'cities0.id')
          ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')          
          ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
          ->leftJoin('degrees', 'economic_complements.degree_id', '=', 'degrees.id') 
          ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
          ->leftJoin('categories','categories.id','=','economic_complements.category_id')
          ->leftJoin('cities as cities2','affiliates.city_identity_card_id','=','cities2.id')
          // ->leftJoin('base_wages','base_wages.id','=','economic_complements.base_wage_id')

          ->whereYear('economic_complements.year', '=', '2017')
          ->where('economic_complements.semester', '=', 'Primer')
          ->where('economic_complements.workflow_id','=',1)
          ->where('economic_complements.wf_current_state_id',2)
          ->where('economic_complements.state','Edited')
          ->where('economic_complements.total','>', 0)
          ->whereRaw('economic_complements.total_rent::numeric < economic_complements.salary_quotable::numeric')        
          ->whereRaw("not exists(select affiliates.id from affiliate_observations where affiliates.id = affiliate_observations.affiliate_id and affiliate_observations.observation_type_id IN(1,2,3,12))")        
          ->whereNotNull('economic_complements.review_date')

          // ->select(DB::raw("economic_complements.id,economic_complements.code,eco_com_applicants.identity_card,,cities1.first_shortened as ext, economic_complements.affiliate_id,economic_complements.semester,cities0.second_shortened as regional,concat_ws(' ', NULLIF(eco_com_applicants.first_name,null), NULLIF(eco_com_applicants.second_name, null), NULLIF(eco_com_applicants.last_name, null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null)) as full_name,economic_complements.total as importe,eco_com_modalities.shortened as modality,degrees.shortened as degree"))

          ->select(DB::raw("economic_complements.id,economic_complements.code,eco_com_applicants.identity_card,cities1.first_shortened as ext,eco_com_applicants.first_name,eco_com_applicants.second_name,eco_com_applicants.last_name,eco_com_applicants.mothers_last_name,eco_com_applicants.surname_husband,eco_com_applicants.birth_date,eco_com_applicants.civil_status,cities0.name as regional,degrees.shortened as degree,eco_com_modalities.shortened as modality,pension_entities.name as gestor,economic_complements.sub_total_rent as renta_boleta,economic_complements.reimbursement as reintegro,economic_complements.dignity_pension,economic_complements.total_rent as renta_neta,economic_complements.total_rent_calc as neto,categories.name as category,economic_complements.salary_reference,economic_complements.seniority as antiguedad,economic_complements.salary_quotable,economic_complements.difference,economic_complements.total_amount_semester,economic_complements.complementary_factor,economic_complements.total,reception_type as tipo_tramite,affiliates.identity_card as ci_afiliado, cities2.first_shortened as ext_afiliado,affiliates.first_name as pn_afiliado,affiliates.second_name as sn_afiliado,affiliates.last_name as ap_afiliado,affiliates.mothers_last_name as am_afiliado,affiliates.surname_husband as ap_casado_afiliado,eco_com_modalities.id as modality_id"))
          
          ->get();
          // dd($afis);
          // exit();
          $rows= array(array('Nro','Nro Tramite','C.I.','Ext','Primer Nombre','Segundo Nombre','Apellido Paterno','Apellido Materno','Apellido de Casado','Ci Causahabiente','Ext','Primer Nombre Causahabiente','Segundo Nombre Causahabiente','Apellido Paterno Causahabiente',' Apellido Materno Causahabiente','Apellido Casado Causahabiente','Fecha de Nacimiento','Estado Civil','Regional','Grado','Tipo de Renta','Ente Gestor','Renta Boleta','Reintegro','Renta Dignidad','Renta Total Neta','Neto','Categoria','Referente Salarial','Antiguedad','Cotizable','Diferencia','Total Semestre','Factor de Complementacion','Complemento Economico final','Tipo de tramite') );

          $i=1;
          foreach ($afis as $a) {
            # code...
            switch ($a->modality_id) {
              case '1':
              case '4':
              case '6':
              case '8':
                # code...
                $afiliado_ci ="";
                $afiliado_ext = "";
                $afiliado_first_name = "";
                $afiliado_second_name = "";
                $afiliado_last_nme = "";
                $afiliado_mother_last_name = "";
                $afiliado_surname_husband ="";
                break;
              
              default:
                # code...
                $afiliado_ci = $a->ci_afiliado;
                $afiliado_ext = $a->ext_afiliado;
                $afiliado_first_name = $a->pn_afiliado;
                $afiliado_second_name = $a->sn_afiliado;
                $afiliado_last_nme = $a->ap_afiliado;
                $afiliado_mother_last_name = $a->am_afiliado;
                $afiliado_surname_husband =$a->ap_casado_afiliado;
                break;
            }


            array_push($rows, array($i,$a->code,$a->identity_card,$a->ext,$a->first_name,$a->second_name,$a->last_name,$a->mothers_last_name,$a->surname_husband,$afiliado_ci,$afiliado_ext,$afiliado_first_name,$afiliado_second_name,$afiliado_last_nme,$afiliado_mother_last_name,$afiliado_surname_husband,$a->birth_date,$a->civil_status,$a->regional,$a->degree,$a->modality,$a->gestor,$a->renta_boleta,$a->reintegro,$a->dignity_pension,$a->renta_neta,$a->neto,$a->category,$a->salary_reference,$a->antiguedad,$a->salary_quotable,$a->difference,$a->total_amount_semester,$a->complementary_factor,$a->total,$a->tipo_tramite));
            $i++;
          }

         Excel::create('Planilla General '.date("Y-m-d H:i:s"),function($excel)
         {

         global $rows;
                    $excel->sheet('Planilla General',function($sheet) {

                         global $rows;

                          $sheet->fromArray($rows,null, 'A1', false, false);
                          $sheet->cells('A1:AJ1', function($cells) {

                          // manipulate the range of cells
                          $cells->setBackground('#058A37');
                          $cells->setFontColor('#ffffff');  
                          $cells->setFontWeight('bold');

                          });
                      });

            })->download('xls');

          // dd($rows);

    }


    //########## EXPORT PLANILLA BY DEPARTMENT
    public function export_by_department(Request $request)
    {   global $list,$ben,$suc,$cbb,$lpz,$oru,$pdo,$pts,$scz,$tja;
        if(is_null($request->year) || is_null($request->semester))
        {
            
            Session::flash('message', "Seleccione Año y Semestre");
            return redirect('economic_complement');
        }
        else
        {
            $list = DB::table('eco_com_applicants')
                                          ->select(DB::raw("economic_complements.id,economic_complements.code,eco_com_applicants.identity_card as app_ci,cities1.first_shortened as app_ext,eco_com_applicants.first_name, eco_com_applicants.second_name, eco_com_applicants.last_name, eco_com_applicants.mothers_last_name, eco_com_applicants.surname_husband,
                                            affiliates.identity_card as afi_ci,cities2.first_shortened as afi_ext,affiliates.first_name as afi_first_name, affiliates.second_name as afi_second_name, affiliates.last_name as afi_last_name, affiliates.mothers_last_name as afi_mothers_last_name, 
                                            affiliates.surname_husband as afi_surname_husband,eco_com_applicants.birth_date,eco_com_applicants.civil_status,cities0.second_shortened as regional,degrees.shortened as degree,eco_com_modalities.shortened as modality,pension_entities.name as entity,economic_complements.sub_total_rent,economic_complements.reimbursement,economic_complements.dignity_pension,economic_complements.total_rent,economic_complements.total_rent_calc,categories.name as category,economic_complements.salary_reference,economic_complements.seniority,economic_complements.salary_quotable,economic_complements.difference,economic_complements.total_amount_semester,economic_complements.complementary_factor,economic_complements.total,economic_complements.reception_type"))
                                          ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                          ->leftJoin('cities as cities0', 'economic_complements.city_id', '=', 'cities0.id')
                                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                          ->leftJoin('categories','economic_complements.category_id','=','categories.id')
                                          ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                          ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                          ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                          ->leftJoin('cities as cities2', 'affiliates.city_identity_card_id', '=', 'cities2.id')
                                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                          ->leftJoin('pension_entities','affiliates.pension_entity_id','=', 'pension_entities.id')
                                          ->whereYear('economic_complements.year', '=', $request->year)
                                          ->where('economic_complements.semester', '=', $request->semester)
                                          ->where('economic_complements.workflow_id','=',1)
                                          ->where('economic_complements.wf_current_state_id',2)
                                          ->where('economic_complements.state','Edited')
                                          ->where('economic_complements.total','>', 0)                                          
                                          ->whereRaw('economic_complements.total_rent::numeric < economic_complements.salary_quotable::numeric')
                                          ->whereRaw("not exists(select affiliates.id from affiliate_observations where affiliates.id = affiliate_observations.affiliate_id and affiliate_observations.observation_type_id IN(1,2,3,12,13))")         
                                          ->whereNotNull('economic_complements.review_date')                                    
                                          ->orderBy('cities0.second_shortened','ASC')->get();

              $encb= array('NRO_TRAMITE','CI', 'EXT', 'PRIMER_NOMBRE', 'SEGUNDO_NOMBRE', 'APELLIDO_PATERNO','APELLIDO_MATERNO','APELLIDO_DE_CASADO','CI_CAUSAHABIENTE','EXT','PRIMER_NOMBRE_CAUSAHABIENTE','SEGUNDO_NOMBRE_CAUSAHABIENTE','APELLIDO_PATERNO_CAUSAHABIENTE','APELLIDO_MATERNO_CAUSAHABIENTE','APELLIDO_DE_CASADO_CAUSAHABIENTE','FECHA_NACIMIENTO','ESTADO_CIVIL','REGIONAL','GRADO','TIPO_DE_RENTA','ENTE_GESTOR','RENTA_BOLETA','REINTEGRO','RENTA_DIGNIDAD','RENTA_TOTAL_NETA','NETO','CATEGORIA','REFERENTE_SALARIAL', 'ANTIGUEDAD','COTIZABLE','DIFERENCIA','TOTAL_SEMESTRE','FACTOR_DE_COMPLEMENTACION','COMPLEMENTO_ECONOMICO_FINAL_2017','TIPO_TRAMITE');
               $ben[] = $encb;
               $suc[] = $encb;
               $cbb[] = $encb;
               $lpz[] = $encb;
               $oru[] = $encb;
               $pdo[] = $encb;
               $pts[] = $encb;
               $scz[] = $encb;
               $tja[] = $encb;
              foreach ($list as $datos) 
              {
                    $economic =  EconomicComplement::idIs($datos->id)->first();                    
                    //$import = $datos->importe;
                    if ($economic->has_legal_guardian)
                    {                     
                      $legal1 = EconomicComplementLegalGuardian::where('economic_complement_id','=', $economic->id)->first();
                      $obj =array($datos->code,$datos->app_ci,$datos->app_ext,$datos->first_name, $datos->second_name, $datos->last_name,$datos->mothers_last_name, $datos->surname_husband, $datos->afi_ci,$datos->afi_ext,$datos->afi_first_name, $datos->afi_second_name, $datos->afi_last_name,$datos->afi_mothers_last_name, $datos->afi_surname_husband, $datos->birth_date, $datos->civil_status, $datos->regional, $datos->degree, $datos->modality,$datos->entity,$datos->sub_total_rent,$datos->reimbursement,$datos->dignity_pension,$datos->total_rent,$datos->total_rent_calc,$datos->category, $datos->salary_reference,$datos->seniority, $datos->salary_quotable,$datos->difference, $datos->total_amount_semester,$datos->complementary_factor,$datos->total,$datos->reception_type);                    
                      
                    }
                    else
                    {                      
                      $apl =EconomicComplement::find($datos->id)->economic_complement_applicant;
                      $obj = array($datos->code,$datos->app_ci,$datos->app_ext,$datos->first_name, $datos->second_name, $datos->last_name,$datos->mothers_last_name, $datos->surname_husband, $datos->afi_ci,$datos->afi_ext,$datos->afi_first_name, $datos->afi_second_name, $datos->afi_last_name,$datos->afi_mothers_last_name, $datos->afi_surname_husband, $datos->birth_date, $datos->civil_status, $datos->regional, $datos->degree, $datos->modality,$datos->entity,$datos->sub_total_rent,$datos->reimbursement,$datos->dignity_pension,$datos->total_rent,$datos->total_rent_calc,$datos->category, $datos->salary_reference,$datos->seniority, $datos->salary_quotable,$datos->difference, $datos->total_amount_semester,$datos->complementary_factor,$datos->total,$datos->reception_type);  

                    }
              
                switch ($datos->regional) 
                {
                  case "BEN" :
                    $ben[]=$obj;
                    break;
                  case "SUC" :
                    $suc[]=$obj;
                    break;
                  case "CBB" :
                    $cbb[]=$obj;
                    break;
                  case "LPZ" :
                    $lpz[]=$obj;
                    break;
                  case "ORU" :
                    $oru[]=$obj;
                    break;
                  case "PDO" :
                    $pdo[]=$obj;
                    break;
                  case "PTS" :
                    $pts[]=$obj;
                    break;
                  case "SCZ" :
                    $scz[]=$obj;
                    break;
                  case "TJA" :
                    $tja[]=$obj;
                    break;                 
                }
            }
            
            global $ben,$suc,$cbb,$lpz,$oru,$pdo,$pts,$scz,$tja;
            Excel::create('PLANILLA_POR_DEPARTAMENTO', function($excel)
            {
                global $ben,$suc,$cbb,$lpz,$oru,$pdo,$pts,$scz,$tja;                        
                $excel->sheet('BENI', function($sheet) use($ben) 
                {
                    $sheet->fromArray($ben,null, 'A1', false, false);                   
                });

                $excel->sheet('CHUQUISACA', function($sheet) use($suc) 
                {
                        $sheet->fromArray($suc,null, 'A1', false, false);
                });

                $excel->sheet('COCHABAMBA', function($sheet) use($cbb) 
                {
                        $sheet->fromArray($cbb,null, 'A1', false, false);
                });

                $excel->sheet('LA PAZ', function($sheet) use($lpz) 
                {
                        $sheet->fromArray($lpz,null, 'A1', false, false);
                });

                $excel->sheet('ORURO', function($sheet) use($oru) 
                {
                        $sheet->fromArray($oru,null, 'A1', false, false);
                });

                $excel->sheet('PANDO', function($sheet) use($pdo) 
                {
                        $sheet->fromArray($pdo,null, 'A1', false, false);
                });

                $excel->sheet('POTOSI', function($sheet) use($pts) 
                {
                        $sheet->fromArray($pts,null, 'A1', false, false);
                });

                $excel->sheet('SANTA CRUZ', function($sheet) use($scz) 
                {
                        $sheet->fromArray($scz,null, 'A1', false, false);
                });

                $excel->sheet('TARIJA', function($sheet) use($tja) 
                {
                        $sheet->fromArray($tja,null, 'A1', false, false);
                });                

            })->export('xlsx');
        }
    }

    public function payrollLegalGuardian()
    {
        global $rows,$i;
        $eco=EconomicComplement::where('eco_com_procedure_id','=',2)
            ->whereNotNull('review_date')
            ->where('state','like','Edited')
            ->where('has_legal_guardian','=',true)
            ->get();
        $rows[]=array('Nro','C.I.','Nombre Completo Poderdante','C.I.','Nombre Completo Apoderado','Regional','Grado','Tipo Renta','Complemento Economico');
        $i=1;
        foreach ($eco as $e) {
            $app = $e->economic_complement_applicant;
            $apo = $e->economic_complement_legal_guardian;
            $data = new stdClass;
            $data->index = $i++;
            $data->ci_app = $app->identity_card.' '.$app->city_identity_card->first_shortened;
            $data->name_app = $app->getFullName();
            $data->ci_apo = $apo->identity_card.' '.$apo->city_identity_card->first_shortened;
            $data->name = $apo->getFullName();
            $data->city = $e->city->name;
            $data->degree = $e->degree->shortened;
            $data->eco_com_type = strtoupper($e->economic_complement_modality->economic_complement_type->name);
            $data->total = $e->total;
            // $rows[] = get_object_vars($data);
            $rows[] = (array)($data);
        }
        Excel::create('Planilla de casos de Apoderados y poderdantes',function($excel)
        {
            global $rows;
            $excel->sheet('Apoderados y poderdantes',function($sheet){
                global $rows;
                $sheet->fromArray($rows,null, 'A1', false, false);
                $sheet->cells('A1:I1', function($cells) {
                    $cells->setBackground('#058A37');
                    $cells->setFontColor('#ffffff');
                    $cells->setFontWeight('bold');
                });
                $sheet->setAllBorders('thin');
            });
        })->download('xls');
    }
    public function payrollHome()
    {   
        global $rows,$i;
        $aff=DB::table('affiliates')
                ->leftJoin('affiliate_observations','affiliates.id','=','affiliate_observations.affiliate_id')
                ->leftJoin('observation_types', 'affiliate_observations.observation_type_id', '=', 'observation_types.id')
                ->where('observation_types.id','=',  12)
                ->get();
        $rows[]=array('Nro','C.I.','Nombre Completo','Regional','Grado','Tipo Renta','Complemento Economico');
        $i=1;
        $total=0;
        foreach ($aff as $a) {
            if ($e = Affiliate::find($a->affiliate_id)->economic_complements()->where('eco_com_procedure_id','=',2)->where('state','like','Edited')->whereNotNull('review_date')->first()) {
                $app = $e->economic_complement_applicant;
                $data = new stdClass;
                $data->index = $i++;
                $data->ci_app = $app->identity_card.' '.$app->city_identity_card->first_shortened;
                $data->name_app = $app->getFullName();
                $data->city = $e->city->name;
                $data->degree = $e->degree->shortened;
                $data->eco_com_type = strtoupper($e->economic_complement_modality->economic_complement_type->name);
                $data->total = $e->total;
                $total += $e->total;
                $rows[] = (array)($data);
            }
        }
        Excel::create('Planilla de pago a domicilio',function($excel)
        {
            global $rows,$i;
            $excel->sheet('Pago a Domicilio',function($sheet){
                global $rows,$i;
                ++$i;
                $sheet->fromArray($rows,null, 'A1', false, false);
                $sheet->cells('A1:G1', function($cells) {
                    $cells->setBackground('#058A37');
                    $cells->setFontColor('#ffffff');
                    $cells->setFontWeight('bold');
                });
            });
        })->download('xls');
    }
    public function payrollReplenishmentFunds()
    {   
        global $rows,$i;
        $aff=DB::table('affiliates')
                ->leftJoin('affiliate_observations','affiliates.id','=','affiliate_observations.affiliate_id')
                ->leftJoin('observation_types', 'affiliate_observations.observation_type_id', '=', 'observation_types.id')
                ->where('observation_types.id','=',  13)
                ->get();
        $rows[]=array('Nro','C.I.','Nombre Completo','Regional','Grado','Tipo Renta','Complemento Economico');
        $i=1;
        $total=0;
        foreach ($aff as $a) {
            if ($e = Affiliate::find($a->affiliate_id)->economic_complements()->where('eco_com_procedure_id','=',2)->where('state','like','Edited')->whereNotNull('review_date')->first()) {
                $app = $e->economic_complement_applicant;
                $data = new stdClass;
                $data->index = $i++;
                $data->ci_app = $app->identity_card.' '.$app->city_identity_card->first_shortened;
                $data->name_app = $app->getFullName();
                $data->city = $e->city->name;
                $data->degree = $e->degree->shortened;
                $data->eco_com_type = strtoupper($e->economic_complement_modality->economic_complement_type->name);
                $data->total = $e->total;
                $total += $e->total;
                $rows[] = (array)($data);
            }
        }
        Excel::create('Planilla de reposición de fondos',function($excel)
        {
            global $rows,$i;
            $excel->sheet('Reposición De Fondos',function($sheet){
                global $rows,$i;
                ++$i;
                $sheet->fromArray($rows,null, 'A1', false, false);
                $sheet->cells('A1:G1', function($cells) {
                    $cells->setBackground('#058A37');
                    $cells->setFontColor('#ffffff');
                    $cells->setFontWeight('bold');
                });
            });
        })->download('xls');
    }
    public function payrollLoan()
    {   
        global $rows,$i;
        $aff=DB::table('affiliates')
                ->leftJoin('affiliate_observations','affiliates.id','=','affiliate_observations.affiliate_id')
                ->leftJoin('observation_types', 'affiliate_observations.observation_type_id', '=', 'observation_types.id')
                ->where('observation_types.id','=',  2  )
                ->get();
        $rows[]=array('Nro','C.I.','Nombre Completo','Regional','Grado','Tipo Renta','Complemento Economico');
        $i=1;
        $total=0;
        foreach ($aff as $a) {
            if ($e = Affiliate::find($a->affiliate_id)->economic_complements()->where('eco_com_procedure_id','=',2)->where('state','like','Edited')->whereNotNull('review_date')->first()) {
                $app = $e->economic_complement_applicant;
                $data = new stdClass;
                $data->index = $i++;
                $data->ci_app = $app->identity_card.' '.$app->city_identity_card->first_shortened;
                $data->name_app = $app->getFullName();
                $data->city = $e->city->name;
                $data->degree = $e->degree->shortened;
                $data->eco_com_type = strtoupper($e->economic_complement_modality->economic_complement_type->name);
                $data->total = $e->total;
                $total += $e->total;
                $rows[] = (array)($data);
            }
        }
        Excel::create('Planilla de observados por situación de mora por prestamos',function($excel)
        {
            global $rows,$i;
            $excel->sheet('Situación de mora por prestamos',function($sheet){
                global $rows,$i;
                ++$i;
                $sheet->fromArray($rows,null, 'A1', false, false);
                $sheet->cells('A1:G1', function($cells) {
                    $cells->setBackground('#058A37');
                    $cells->setFontColor('#ffffff');
                    $cells->setFontWeight('bold');
                });
            });
        })->download('xls');
    }
    public function payrollaccounting()
    {   
        global $rows,$i;
        $aff=DB::table('affiliates')
                ->leftJoin('affiliate_observations','affiliates.id','=','affiliate_observations.affiliate_id')
                ->leftJoin('observation_types', 'affiliate_observations.observation_type_id', '=', 'observation_types.id')
                ->where('observation_types.id', '=', 1)
                ->get();
        $rows[]=array('Nro','C.I.','Nombre Completo','Regional','Grado','Tipo Renta','Complemento Economico');
        $i=1;
        $total=0;
        foreach ($aff as $a) {
            if ($e = Affiliate::find($a->affiliate_id)->economic_complements()->where('eco_com_procedure_id','=',2)->where('state','like','Edited')->whereNotNull('review_date')->first()) {
                $app = $e->economic_complement_applicant;
                $data = new stdClass;
                $data->index = $i++;
                $data->ci_app = $app->identity_card.' '.$app->city_identity_card->first_shortened;
                $data->name_app = $app->getFullName();
                $data->city = $e->city->name;
                $data->degree = $e->degree->shortened;
                $data->eco_com_type = strtoupper($e->economic_complement_modality->economic_complement_type->name);
                $data->total = $e->total;
                $total += $e->total;
                $rows[] = (array)($data);
            }
        }
        Excel::create('Planilla de observados por cuentas por cobrar',function($excel)
        {
            global $rows,$i;
            $excel->sheet('Cuentas por Cobrar',function($sheet){
                global $rows,$i;
                ++$i;
                $sheet->fromArray($rows,null, 'A1', false, false);
                $sheet->cells('A1:G1', function($cells) {
                    $cells->setBackground('#058A37');
                    $cells->setFontColor('#ffffff');
                    $cells->setFontWeight('bold');
                });
            });
        })->download('xls');
    }
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
