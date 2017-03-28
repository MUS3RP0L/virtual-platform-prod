<?php
namespace Muserpol\Http\Controllers\EconomicComplement;
use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\Factory;
use Storage;
use File;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use Muserpol\Helper\Util;
use Maatwebsite\Excel\Facades\Excel;

use Muserpol\Affiliate;
use Muserpol\EconomicComplement;

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
          foreach ($results as $datos){

            $afi = DB::table('economic_complements')
                ->select(DB::raw('economic_complements.*'))
                ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                ->where('affiliates.identity_card', '=', trim($datos->carnet))
                ->whereYear('economic_complements.review_date', '=', $year)
                ->where('economic_complements.semester', '=', $semester)
                ->where('economic_complements.eco_com_state_id', '=', 2)->first();
            if ($afi){
                $ecomplement = EconomicComplement::where('affiliate_id','=', $afi->affiliate_id)->whereYear('review_date','=', $afi->review_date)->where('semester','=', $afi->semester)->where('eco_com_state_id','=', $afi->eco_com_state_id)->first();
                if($ecomplement->eco_com_modality_id == 1 && $datos->total_ganado < 2000)  //Vejez Senasir
                {
                    $ecomplement->eco_com_modality_id = 8;
                } elseif ($ecomplement->eco_com_modality_id == 2 && $datos->total_ganado < 2000) {  //Viudedad
                    $ecomplement->eco_com_modality_id = 9;
                } elseif ($ecomplement->eco_com_modality_id == 3 && $datos->total_ganado < 2000) {  //Orfandad
                    $ecomplement->eco_com_modality_id = 8;
                }
                $ecomplement->reimbursement_basic_pension = $datos->rentegro_r_basica;
                $ecomplement->dignity_pension = $datos->renta_dignidad;
                $ecomplement->dignity_pension_reimbursement = $datos->reintegro_renta_dignidad;
                $ecomplement->dignity_pension_bonus = $datos->aguinaldo_renta_dignidad;
                $ecomplement->bonus_reimbursement = $datos->reintegro_aguinaldo;
                $ecomplement->reimbursement_aditional_amount = $datos->reintegro_importe_adicional;
                $ecomplement->reimbursement_increase_year = $datos->reintegro_inc_gestion;
                //$reimbursements = $datos->rentegro_r_basica + $datos->renta_dignidad + $datos->reintegro_renta_dignidad +  $datos->aguinaldo_renta_dignidad + $datos->reintegro_aguinaldo + $datos->reintegro_importe_adicional + $datos->reintegro_inc_gestion;
                $ecomplement->total = $datos->total_ganado;
                $ecomplement->save();
                $affiliates = Affiliate::where('id','=', $afi->affiliate_id)->first();
                $affiliates->pension_entity_id = 5;
                $affiliates->save();
                $found ++;
            }
            else{
              $nofound ++;
              $i ++;
              $list[]= $datos;
            }
          }
          //return response()->json($list);
          //export record no found
          Excel::create('Senasir CE', function($excel) {
              global $list, $j;
              $j = 2;
              $excel->sheet('Lista', function($sheet) {
              global $list, $j;
              $sheet->row(1, array('mat_titular', 'mat_dh', 'departamento', 'regional', 'renta', 'tipo_renta', 'carnet','nombres','fecha_nacimiento','clase_renta','total_ganado','total_descuentos','renta_basica','rentegro_r_basica','bono_del_estado','adicion_ivm','incremento_acumulado','renta_complementaria','renta_dignidad','reintegro_renta_dignidad','aguinaldo_renta_dignidad','inc_al_minimo_nacional','reintegro_aguinaldo','bono_ips_ds_27760','beneficios_adicionales','plus_afps','resolucion_15_95','importe_adicional','reintegro_importe_adicional','bono_adicional_ip2006','ajuste_adicional','incremento_gestion','reintegro_inc_gestion','incr_inv_prop_ip_gestion','caja_nacional_salud','caja_salud_banca_privada','conf_nac_jubil_rent_bolivia','conf_nac_maestros_jubilados','desc_a_favor_cnjrb','moneda_fraccionaria','pago_indebido_ivm','pago_adelantado_pra_ivm','desc_cobro_indebido_r026_99_ivm','retencion_judicial','descuento_musepol','descuento_covipol','prestamo_musepol'));
              foreach ($list as $valor) {
                  $sheet->row($j, array($valor->mat_titular, $valor->mat_dh, $valor->departamento, $valor->regional, $valor->renta, $valor->tipo_renta, $valor->carnet, $valor->nombres,$valor->fecha_nacimiento,$valor->clase_renta, $valor->total_ganado, $valor->total_descuentos,$valor->renta_basica, $valor->rentegro_r_basica, $valor->bono_del_estado,$valor->adicion_ivm,$valor->incremento_acumulado,$valor->renta_complementaria,$valor->renta_dignidad,$valor->reintegro_renta_dignidad,$valor->aguinaldo_renta_dignidad,$valor->inc_al_minimo_nacional, $valor->reintegro_aguinaldo,$valor->bono_ips_ds_27760,$valor->beneficios_adicionales,$valor->plus_afps,$valor->resolucion_15_95,$valor->importe_adicional,$valor->reintegro_importe_adicional,$valor->bono_adicional_ip2006,$valor->ajuste_adicional,$valor->incremento_gestion,$valor->reintegro_inc_gestion,$valor->incr_inv_prop_ip_gestion,$valor->caja_nacional_salud,$valor->caja_salud_banca_privada,$valor->conf_nac_jubil_rent_bolivia,$valor->conf_nac_maestros_jubilados,$valor->desc_a_favor_cnjrb,$valor->moneda_fraccionaria,$valor->pago_indebido_ivm,$valor->pago_adelantado_pra_ivm,$valor->desc_cobro_indebido_r026_99_ivm,$valor->retencion_judicial, $valor->descuento_musepol, $valor->descuento_covipol, $valor->prestamo_musepol));
                  $j++;
              }
            });

          })->export('xlsx');

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
        //return response()->json($results);
        foreach ($results as $datos){
            $afi = DB::table('economic_complements')
              ->select(DB::raw('economic_complements.*'))
              ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
              ->where('affiliates.nua', '=', rtrim(Util::zero($datos->cua_titular)))
              ->where('affiliates.identity_card', '=', rtrim(Util::zero($datos->nro_identificacion)))
              ->whereIn('affiliates.pension_entity_id', [1, 2, 3, 4])
              ->whereYear('economic_complements.review_date', '=', $year)
              ->where('economic_complements.semester', '=', rtrim($semester))
              ->where('economic_complements.eco_com_state_id', '=', 2)
              ->whereNull('economic_complements.deleted_at')->first();
              if ($afi){
                  //return response()->json($afi);
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
                  $ecomplement = EconomicComplement::where('id','=', $afi->id)->first();
                  $ecomplement->total = $datos->total_pension;
                  //Vejez
                 if ($ecomplement->eco_com_modality_id == 1 || $ecomplement->eco_com_modality_id == 3)
                 {
                     if ($comp == 1 && $datos->total_pension >= 2000)
                     {
                        $ecomplement->eco_com_modality_id = 4;
                     }
                     elseif ($comp == 1 && $datos->total_pension < 2000)
                     {
                        $ecomplement->eco_com_modality_id = 6;
                     }
                     elseif ($comp > 1 && $datos->total_pension < 2000)
                     {
                        $ecomplement->eco_com_modality_id = 8;
                     }
                 }
                 //Viudedad
                 if ($ecomplement->eco_com_modality_id == 2) {
                     if($comp == 1 && $datos->total_pension >= 2000) {
                         $ecomplement->eco_com_modality_id = 5;
                     } elseif ($comp == 1 && $datos->total_pension < 2000) {
                          $ecomplement->eco_com_modality_id = 7;
                     } elseif ($comp > 1 && $datos->total_pension < 2000 ) {
                         $ecomplement->eco_com_modality_id = 9;
                     }
                 }
                  $ecomplement->save();
                  $affiliates = Affiliate::where('id', '=', $afi->affiliate_id)->first();
                  if ($datos->afpea == "01") {
                      $affiliates->pension_entity_id = 1;
                  }
                  elseif($datos->afpea == "02") {
                      $affiliates->pension_entity_id = 2;
                  }
                  elseif($datos->afpea == "13"){
                      $affiliates->pension_entity_id = 3;
                  }
                  else{
                       $affiliates->pension_entity_id = 4;
                  }
                  $affiliates->save();
                  $found ++;
              }
              else{
                $nofound ++;
                $i ++;
                $list[]= $datos;
              }
          }
          //return response()->json($list);
          //export record no found
          Excel::create('APS_NOTFOUND', function($excel) {
              global $list, $j,$k;
              $j = 2;
              $excel->sheet('Lista_aps', function($sheet) {
              global $list, $j,$k;
              $k=1;
              $sheet->row(1, array('NRO_CORRELATIVO','AFP/EA','PERIODO','CUA_TITULAR','PN_TITULAR','SN_TITULAR','PA_TITULAR','SA_TITULAR','AC_TITULAR','FNAC_TITULAR','NRO_IDENTIFICACION','TIPO_PENSION','FECHA_SOLICITUD','TOTAL_CC','COMISION_CC','EGS_CC','DESCUENTO_CC','CAUSA_DESCUENTO_CC','NETO_CC','TOTAL_FSA','COMISION_FSA','EGS_FSA	DESCUENTO_FSA','CAUSA_DESCUENTO_FSA','NETO_FSA	TOTAL_FS','COMISION_FS','EGS_FS','DESCUENTO_FS','CAUSA_DESCUENTO_FS',	'NETO_FS','TOTAL_PENSION','TIPO_PAGO','PORCENTAJE_PNS','PTC_DERECHOHABIENTE','PN_DERECHOHABIENTE','SN_DERECHOHABIENTE','PA_DERECHOHABIENTE','SA_DERECHOHABIENTE','AC_DERECHOHABIENTE','FNAC_DERECHOHABIENTE','SEXO_DERECHOHABIENTE'));
              foreach ($list as $valor) {
                  $sheet->row($j, array($k, $valor->afpea, $valor->periodo, $valor->cua_titular, $valor->pn_titular, $valor->sn_titular, $valor->pa_titular, $valor->sa_titular,$valor->ac_titular,$valor->fnac_titular, Util::zero($valor->nro_identificacion), $valor->tipo_pension,$valor->fecha_solicitud, $valor->total_cc, $valor->comision_cc,$valor->egs_cc,$valor->descuento_cc,$valor->causa_descuento_cc,$valor->neto_cc,$valor->total_fsa,$valor->comision_fsa,$valor->egs_fsa, $valor->descuento_fsa,$valor->causa_descuento_fsa,$valor->neto_fsa,$valor->plus_afps,$valor->total_fs,$valor->comision_fs,$valor->egs_fs,$valor->descuento_fs,$valor->causa_descuento_fs,$valor->neto_fs,$valor->total_pension,$valor->tipo_pago,$valor->porcentaje_pns,$valor->ptc_derechohabiente,$valor->pn_derechohabiente,$valor->sn_derechohabiente,$valor->pa_derechohabiente,$valor->sa_derechohabiente,$valor->ac_derechohabiente,$valor->fnac_derechohabiente,$valor->sexo_derechohabiente));
                  $j++;
                  $k++;
              }
            });

          })->export('xlsx');
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
                    $afi = DB::table('economic_complements')
                        ->select(DB::raw('economic_complements.id,economic_complements.affiliate_id,affiliates.identity_card,cities.third_shortened,affiliates.nua,affiliates.last_name,affiliates.mothers_last_name,affiliates.first_name,affiliates.second_name,affiliates.surname_husband,affiliates.birth_date'))
                        ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                        ->leftJoin('cities', 'affiliates.city_identity_card_id', '=', 'cities.id')
                        ->where('affiliates.pension_entity_id','<>', 5)
                        ->whereYear('economic_complements.review_date', '=', $year)
                        ->where('economic_complements.semester', '=', $semester)
                        ->where('economic_complements.eco_com_state_id', '=', 2)->get();
                    foreach ($afi as $datos) {
                        $sheet->row($j, array($i, "I",$datos->identity_card,$datos->third_shortened,$datos->nua, $datos->last_name, $datos->mothers_last_name,$datos->first_name, $datos->second_name, $datos->surname_husband,$datos->birth_date));
                        $j++;
                        $i++;
                    }
                  });
              })->export('xlsx');
                Session::flash('message', "Importación Exitosa");
                return redirect('economic_complement');

    }

    public function export_to_bank(Request $request){
      global $year, $semester,$i,$afi,$semester1;
      $year = $request->year;
      $semester = $request->semester;
      $afi = DB::table('economic_complements')
          ->select(DB::raw('economic_complements.id,economic_complements.affiliate_id,economic_complements.semester,economic_complements.total,affiliates.identity_card,cities.shortened as ext,affiliates.last_name,affiliates.mothers_last_name,affiliates.first_name,affiliates.second_name,affiliates.surname_husband,eco_com_modalities.name,degrees.shortened as degree'))
          ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
          //->join('cities', 'affiliates.city_id', '=', 'cities.id')
          ->leftJoin('cities', 'affiliates.city_identity_card_id', '=', 'cities.id')
          ->leftJoin('degrees', 'affiliates.degree_id', '=', 'degrees.id')
          ->whereYear('economic_complements.review_date', '=', $year)
          ->where('economic_complements.semester', '=', $semester)
          ->where('economic_complements.eco_com_state_id', '=', 2)->get();
      //return response()->json($afi);

      if($afi){
            if($semester == "F"){
              $semester1 = "MUSERPOL PAGO COMPLEMENTO ECONOMICO 1ER SEM ".$year;
              $abv ="Pago_Banco_Union_1ER_SEM_".$year;
            }
            else{
              $semester1 = "MUSERPOL PAGO COMPLEMENTO ECONOMICO 2DO SEM ".$year;
              $abv ="Pago_Banco_Union_2DO_SEM_".$year;
            }
            Excel::create($abv, function($excel) {
                global $year,$semester,$afi,$j,$semester1;
                $j = 2;
                $excel->sheet("AFILIADOS_PARA_APS_".$year, function($sheet) {
                global $year,$semester, $afi,$j, $i,$semester1;
                $i=1;
                $sheet->row(1, array('NRO', 'DEPARTAMENTO','IDENTIFICACION','NOMBRE_Y_APELLIDO','IMPORTE_A_PAGAR','MONEDA_DEL_IMPORTE','DESCRIPCION1','DESCRIPCION2','DESCRIPCION3'));
                foreach ($afi as $datos) {
                    $economic =  EconomicComplement::idIs($datos->id)->first();
                    $sheet->row($j, array($i,$economic->city->second_shortened,$datos->identity_card." ".$datos->ext,$datos->first_name." ".$datos->second_name." ".$datos->last_name." ".$datos->mothers_last_name." ".$datos->surname_husband, $datos->total,"1",$datos->name,$datos->degree,$semester1));
                    $j++;
                    $i++;
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
