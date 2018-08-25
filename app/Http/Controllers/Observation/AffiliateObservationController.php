<?php

namespace Muserpol\Http\Controllers\Observation;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;
use Muserpol\AffiliateObservation;
use Muserpol\Affiliate;
use Muserpol\EconomicComplement;
use Muserpol\ObservationType;
use Muserpol\EconomicComplementProcedure;
use Muserpol\AffiliateRecord;
use Muserpol\EconomicComplementObservation;
use Carbon\Carbon;
use Util;
use Log;
use Auth;
use Datatables;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AffiliateObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
     
      // return $request->all();
      $rules = [
      'affiliate_id' => 'required',
      // 'observation_type_id' => 'required',
      ];
      $messages = [
      // 'observation_type_id.required' => 'El campo tipo de observacion es requerido',

      // 'message.required' => 'El campo mensaje es requerido',
      // 'message.min' => 'El mínimo de caracteres permitidos en mensaje es 3'
      ];
      $validator = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
        return redirect('affiliate/'.$request->affiliate_id)
        ->withErrors($validator)
        ->withInput();
      }else{

        if($request->observation_id=='')
        {
            $observation = new AffiliateObservation;
            $observation->observation_type_id = $request->observation_type_id;
            $message="Observacion Creada";
        }
        else{
            $observation = AffiliateObservation::find($request->observation_id);
            $message="Observacion Actualizada";
        }
       
        $nota = ObservationType::where('type','N')->where('module_id',Util::getRol()->module_id)->first();
       
        $observation->user_id=Auth::user()->id;
        $observation->affiliate_id=$request->affiliate_id;
        $observation->date=Carbon::now();
        $observation->observation_type_id=$request->observation_type_id;
        $observation->is_enabled=($request->is_enabled == 'on');
        $observation->message=$request->message;

        if($request->has('is_note')){
            $observation->observation_type_id = $nota->id;
            if($message == 'Observacion Creada'){
              $message = 'Nota Creada';
            }else{
              $message = 'Nota Actualizada';
            }

        }

        $observation->save();
        Session::flash('affiliate_id',$observation->affiliate_id);
        Session::flash('observation_type_id',$observation->observation_type_id);
        Session::flash('message', $message);

        // Log::info(Util::getCurrentProcedure());
        //creando la observacion en el tramite en caso de exista el tramite y el tipo sea AT
        
        if($observation->observationType->type == 'AT')
        {
          $economic_complement = EconomicComplement::where('affiliate_id',$observation->affiliate_id)->where('eco_com_procedure_id',Util::getCurrentProcedure()->id)->first();
          // Log::info($economic_complement);
          if($economic_complement)
          { 
            $eco_com_observation = new EconomicComplementObservation;
            $eco_com_observation->user_id = Auth::user()->id;
            $eco_com_observation->economic_complement_id = $economic_complement->id;
            $eco_com_observation->observation_type_id = $observation->observation_type_id;
            $eco_com_observation->message = $observation->message;
            $eco_com_observation->save();
          }
        }


      }
      return redirect('affiliate/'.$request->affiliate_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $observation=AffiliateObservation::find($id);
      return $observation;
    }
    public function delete(Request $request)
    {
      $observation=AffiliateObservation::find($request->observation_id);
      if($observation->observationType->type == 'AT')
      {
        $economic_complement = EconomicComplement::where('affiliate_id',$observation->affiliate_id)->where('eco_com_procedure_id',Util::getCurrentProcedure()->id)->first();
        // Log::info($economic_complement);
        if($economic_complement)
        { 
          $eco_com_observation = EconomicComplementObservation::where('economic_complement_id',$economic_complement->id)->where('observation_type_id',$observation->observation_type_id)->first();
          $eco_com_observation->delete();
        }
      }
      $observation->delete();

      return back();
    }

    public function eliminated(Request $request)
    {
      $observations_list=AffiliateObservation::where('affiliate_id',$request->affiliate_id)
                                              ->whereNotNull('deleted_at')
                                              ->withTrashed()
                                              ->select('id','affiliate_id','deleted_at','message','observation_type_id')->get();
      

      return Datatables::of($observations_list)
      ->editColumn('deleted_at', '{!! $deleted_at !!}')
      ->addColumn('type',function ($observation){
        return $observation->observationType->name;
      })
      
      ->make(true);
      
    }

    public function showOfAffiliate(Request $request)
    {
      // Log::info(Util::getRol());
      $nota = ObservationType::where('type','N')->where('module_id',Util::getRol()->module_id)->first();
    
      // Log::info($nota);
      if($request->type =='A')
      {
        $observations_list=AffiliateObservation::where('affiliate_id',$request->affiliate_id)
                                                  ->where('observation_type_id','<>',$nota->id)
                                                  ->select(['id','affiliate_id','created_at','message','is_enabled','observation_type_id'])->get();
      }else{
        $observations_list=AffiliateObservation::where('affiliate_id',$request->affiliate_id)
                                                  ->where('observation_type_id','=',$nota->id)
                                                  ->select(['id','affiliate_id','created_at','message','is_enabled','observation_type_id'])->get(); 
      }
      

      return Datatables::of($observations_list)
        ->editColumn('created_at', '{!! $created_at !!}')
        ->addColumn('type',function ($observation){
          return '<span class="label label-info">'. $observation->observationType->type.'</span> '. $observation->observationType->name;
        })
        ->addColumn('action', function ($observation) {

          $note = $observation->observationType->type=='N'?'1':'0';
          $color = $observation->observationType->type=='N'?'info':'warning';
          $options = '';
          if($observation->observationType->type <> 'N'){
              $options = '<div class="btn-group" style="margin:-3px 0;">
              <button type="button" class="btn btn-'.$color.' btn-raised btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="caret"></span></button>
              <ul class="dropdown-menu">'.
                  // .'<li><a href="/print_observations/'.$observation->affiliate_id.'/'.$observation->observation_type_id.'"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>'.
                   ((Util::getRol()->module_id == $observation->observationType->module_id) ? '<li><a data-observation-id="'.$observation->id.'"  role="button" data-toggle="modal" data-target="#observationEditModal"  data-observation-type-id="'.$observation->observation_type_id.'" data-observation-name="'.$observation->observationType->name.'" data-observation-message="'.$observation->message.'" data-observation-enabled="'.$observation->is_enabled.'" data-notes="'.$note.'" ><i class="fa fa-pencil" ></i> Editar</a></li>'.
                  '<li><a data-toggle="modal" data-target="#observationDeleteModal" data-observation-id="'.$observation->id.'" data-observation-name="'.$observation->observationType->name.'"  class="deleteObservation" href="#"> <i class="fa fa-times-circle"></i> Eliminar</a></li>':'').'
                </ul>
              </div>';
          }else{
              $options = '<div class="btn-group" style="margin:-3px 0;">
              <button type="button" class="btn btn-'.$color.' btn-raised btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="caret"></span></button>
              <ul class="dropdown-menu">'.
                  // <li><a href="/print_observations/'.$observation->affiliate_id.'/'.$observation->observation_type_id.'"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>'.
                  ((Util::getRol()->module_id == $observation->observationType->module_id) ? '<li><a data-observation-id="'.$observation->id.'"  role="button" data-toggle="modal" data-target="#observationEditModal"  data-observation-type-id="'.$observation->observation_type_id.'" data-observation-name="'.$observation->observationType->name.'" data-observation-message="'.$observation->message.'" data-observation-enabled="'.$observation->is_enabled.'" data-notes="'.$note.'" ><i class="fa fa-pencil" ></i> Editar</a></li>'.
                  '<li><a data-toggle="modal" data-target="#observationDeleteModal" data-observation-id="'.$observation->id.'" data-observation-name="'.$observation->observationType->name.'"  class="deleteObservation" href="#"> <i class="fa fa-times-circle"></i> Eliminar</a></li>':'').' 
                </ul>
              </div>';
          }
        return $options;
      })
      ->make(true);
    }
    public function update(Request $request)
    {
      //dd($request->all());
      $affiliateObservation=AffiliateObservation::find($request->observation_id);
      $affiliateObservation->user_id=Auth::user()->id;
      $affiliateObservation->affiliate_id=$request->affiliate_id;
      $affiliateObservation->date=Carbon::now();
      $affiliateObservation->observation_type_id=$request->observation_type_id;
      $affiliateObservation->is_enabled=($request->is_enabled == 'on');
      $affiliateObservation->message=$request->message;
      $affiliateObservation->save();

      $affiliate = Affiliate::where('id',$request->affiliate_id)->first();
      $aff_record = new AffiliateRecord;
      if (Auth::user()) {$user_id = Auth::user()->id;}else{$user_id = 1;}
      $aff_record->user_id = $user_id;
      $aff_record->affiliate_id = $affiliate->id;
      $aff_record->date = Carbon::now();
      $aff_record->type_id = 6;// 6 es por la observacion
      $aff_record->message = Auth::user()->getFullname()." Se Actualizo Observación ".$affiliateObservation->observationType->name;
      $aff_record->save();

      return redirect('affiliate/'.$request->affiliate_id);
    }

    public function lista_observados()
    {
      $typeObs = ObservationType::all();
      $gestion = DB::table('eco_com_procedures')->orderBy('year','ASC')->get();
      $gs = array();
      $g1 = array();
      foreach ($gestion as $g) {
        $g1=substr($g->year, 0, 4);
        if($g->semester == 'Primer')
          $y = $g1.'1';
        else
          $y = $g1.'2';
        array_push($gs,array('id'=>$y,'year'=>$g1,'semester' => $g->semester));
      }
      
      return view('affiliates.observations',['typeObs'=>$typeObs,'gestion' => $gs]);
      //return view('affiliates.observations');
    }
    public function getDataObsertaions(Request $request)
    {    
          if($request->observation == -1 && $request->year == -1)
          $afiliados = DB::table('v_observados');
          elseif($request->observation != -1 && $request->year == -1)  
          $afiliados = DB::table('v_observados')->where('observation_type_id','=',$request->observation);
          elseif($request->observation != -1 && $request->year != -1)
          {
            $year = substr($request->year, 0, -1);
            $sem = substr($request->year, -1);
           
            if($sem == 1)
              $semestre = 'Primer';
            elseif($sem == 2)
              $semestre = 'Segundo';

            $afiliados = DB::table('v_observados')
            ->where('observation_type_id','=',$request->observation)
            ->where('year','=',$year)
            ->where('semester','=',$semestre);
          }
          elseif($request->observation == -1 && $request->year != -1)
          {
            $year = substr($request->year, 0, -1);
            $sem = substr($request->year, -1);
           
            if($sem == 1)
              $semestre = 'Primer';
            elseif($sem == 2)
              $semestre = 'Segundo';

            $afiliados = DB::table('v_observados')
            ->where('year','=',$year)
            ->where('semester','=',$semestre);
          }
            
        return Datatables::of($afiliados)
       
        ->addColumn('action', function ($afiliado) {
                return '<div class="btn-group" style="margin:-3px 0;">
                <a href="affiliate/'.$afiliado->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
            </div>';

            })
        ->make(true);
    }


    //REPORTE AFFILIADOS OBSERVADOS
    public function afi_observations()
    {
      $typeObs = ObservationType::all();        
      return view('affiliates.affiliateObservations',['typeObs'=>$typeObs]);
    }

    public function get_afi_observations()
    {
      global $AfiObservados, $AfiRendicionCuentas1,$AfiCarteraMora2,$AfiNoCorresponde4,$AfiIncumplimientoRequisitos6,$AfiMenora16Años8,$AfiRiesgoComun9,$AfiMayorSalarioActivo10,$AfiNotasCE11,$AfiReposicionFondos13,$AfiDocumentosPreverificados16,$AfiDadoBaja20,$AfiJudiciales21,$AfiRetencionFondos22,$AfiNuevasNupcias24,$AfiInvalidez25,$InconsistenciaDatos26;    
      
      $AfiObservados = DB::table('affiliate_observations')
      ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
      concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
      ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
      ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
      ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
      ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
      ->whereRaw("affiliate_observations.deleted_at is null")
      ->get();
      
      if(sizeof($AfiObservados) > 0)
      {
        Excel::create('Afi_Observados', function($excel)
        { global $AfiObservados;

          $excel->sheet('AfiliadosObservados', function ($sheet) {
            global $AfiObservados;
           

            $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
            foreach ($AfiObservados as $datos) {    
              array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
            }
  
            $sheet->fromArray($rows, null, 'A1', false, false);
            $sheet->cells('A1:J1', function ($cells) {
  
                              // manipulate the range of cells
              $cells->setBackground('#058A37');
              $cells->setFontColor('#ffffff');
  
            });
  
          }); //FIN TODOS LOS OBSERVADOS

          $excel->sheet('ObservacionContabilidad', function ($sheet) 
          {
              global $AfiRendicionCuentas1;
              $AfiRendicionCuentas1 = DB::table('affiliate_observations')
              ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
              concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
              ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
              ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
              ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
              ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
              ->whereRaw("affiliate_observations.deleted_at is null")
              ->where('affiliate_observations.observation_type_id','=',1)
              ->get();

              $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
              foreach ($AfiRendicionCuentas1 as $datos) {    
                array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
              }
              $sheet->fromArray($rows, null, 'A1', false, false);
              $sheet->cells('A1:J1', function ($cells) 
              {
                // manipulate the range of cells
                $cells->setBackground('#058A37');
                $cells->setFontColor('#ffffff');
              });
            }); 
          
            //MORA PRESTAMOS
            $excel->sheet('Obs.Mora Prestamos', function ($sheet)  
            {
                global $AfiCarteraMora2;
                $AfiCarteraMora2 = DB::table('affiliate_observations')
                ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                ->whereRaw("affiliate_observations.deleted_at is null")
                ->where('affiliate_observations.observation_type_id','=',2)
                ->get();
  
                $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                foreach ($AfiCarteraMora2 as $datos) {    
                  array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                }
                $sheet->fromArray($rows, null, 'A1', false, false);
                $sheet->cells('A1:J1', function ($cells) 
                {
                  // manipulate the range of cells
                  $cells->setBackground('#058A37');
                  $cells->setFontColor('#ffffff');
                });
              }); 
            
            
              //SOLICITUD PRESENTADA FUERA DE PLAZO
            $excel->sheet('Solicitud_Fuera_plazo', function ($sheet)  
            {
                global $AfiNoCorresponde4;
                $AfiNoCorresponde4 = DB::table('affiliate_observations')
                                  ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                  concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                  ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                  ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                  ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                  ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                  ->whereRaw("affiliate_observations.deleted_at is null")
                                  ->where('affiliate_observations.observation_type_id','=',4)
                                  ->get();
                            
                $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                foreach ($AfiNoCorresponde4 as $datos) {    
                  array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                }
                $sheet->fromArray($rows, null, 'A1', false, false);
                $sheet->cells('A1:J1', function ($cells) 
                {
                  // manipulate the range of cells
                  $cells->setBackground('#058A37');
                  $cells->setFontColor('#ffffff');
                });
              });  
            
              // OBSERVADOS POR INCUMPLIMIENTO DE REQUISITOS
              $excel->sheet('Obs_Requisitos', function ($sheet)  
              {
                  global $AfiIncumplimientoRequisitos6;
                  $AfiIncumplimientoRequisitos6 = DB::table('affiliate_observations')
                                            ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                            concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                            ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                            ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                            ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                            ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                            ->whereRaw("affiliate_observations.deleted_at is null")
                                            ->where('affiliate_observations.observation_type_id','=',6)
                                            ->get();
                              
                  $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                  foreach ($AfiIncumplimientoRequisitos6 as $datos) {    
                    array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                  }
                  $sheet->fromArray($rows, null, 'A1', false, false);
                  $sheet->cells('A1:J1', function ($cells) 
                  {
                    // manipulate the range of cells
                    $cells->setBackground('#058A37');
                    $cells->setFontColor('#ffffff');
                  });
                });  
              
                // MENOR A 16 AÑOS
               /* $excel->sheet('Observacion_Menor_diezyseis', function ($sheet)  
                {
                    global $AfiMenora16Años8;
                    $AfiMenora16Años8 = DB::table('affiliate_observations')
                                    ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                    concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                    ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                    ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                    ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                    ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                    ->whereRaw("affiliate_observations.deleted_at is null")
                                    ->where('affiliate_observations.observation_type_id','=',8)
                                    ->get();
                                
                    $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                    foreach ($AfiMenora16Años8 as $datos) {    
                      array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                    }
                    $sheet->fromArray($rows, null, 'A1', false, false);
                    $sheet->cells('A1:J1', function ($cells) 
                    {
                      // manipulate the range of cells
                      $cells->setBackground('#058A37');
                      $cells->setFontColor('#ffffff');
                    });
                  });  */
              
                // OBSERVACION RIESGO COMUN
                $excel->sheet('Obs.RiesgoComun', function ($sheet)  
                {
                    global $AfiRiesgoComun9;
                    $AfiRiesgoComun9 = DB::table('affiliate_observations')
                                  ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                  concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                  ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                  ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                  ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                  ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                  ->whereRaw("affiliate_observations.deleted_at is null")
                                  ->where('affiliate_observations.observation_type_id','=',9)
                                  ->get();
                                                          
                    $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                    foreach ($AfiRiesgoComun9 as $datos) {    
                      array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                    }
                    $sheet->fromArray($rows, null, 'A1', false, false);
                    $sheet->cells('A1:J1', function ($cells) 
                    {
                      // manipulate the range of cells
                      $cells->setBackground('#058A37');
                      $cells->setFontColor('#ffffff');
                    });
                  }); 
                
                //SALARIO MAYOR ACTIVO
                $excel->sheet('Obs.Salario_Mayor_Activo', function ($sheet)  
                {
                    global $AfiMayorSalarioActivo10;
                    $AfiMayorSalarioActivo10 = DB::table('affiliate_observations')
                                          ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                          concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                          ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                          ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                          ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                          ->whereRaw("affiliate_observations.deleted_at is null")
                                          ->where('affiliate_observations.observation_type_id','=',10)
                                          ->get();
                                                          
                    $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                    foreach ($AfiMayorSalarioActivo10 as $datos) {    
                      array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                    }
                    $sheet->fromArray($rows, null, 'A1', false, false);
                    $sheet->cells('A1:J1', function ($cells) 
                    {
                      // manipulate the range of cells
                      $cells->setBackground('#058A37');
                      $cells->setFontColor('#ffffff');
                    });
                  });  
              
                //OBSERVACION NOTAS COMPLEMENTO ECONOMICO
                $excel->sheet('Observacion_Notas_CE', function ($sheet)  
                {
                    global $AfiNotasCE11;
                    $AfiNotasCE11 = DB::table('affiliate_observations')
                                  ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                  concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                  ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                  ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                  ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                  ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                  ->whereRaw("affiliate_observations.deleted_at is null")
                                  ->where('affiliate_observations.observation_type_id','=',11)
                                  ->get();
                                                          
                    $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                    foreach ($AfiNotasCE11 as $datos) {    
                      array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                    }
                    $sheet->fromArray($rows, null, 'A1', false, false);
                    $sheet->cells('A1:J1', function ($cells) 
                    {
                      // manipulate the range of cells
                      $cells->setBackground('#058A37');
                      $cells->setFontColor('#ffffff');
                    });
                  });
                
                 // OBSERVACION REPOSICION DE FONDOS
                $excel->sheet('Obs.Reposicion_fondos', function ($sheet)  
                {
                    global $AfiReposicionFondos13;
                    $AfiReposicionFondos13 = DB::table('affiliate_observations')
                                          ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                          concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                          ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                          ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                          ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                          ->whereRaw("affiliate_observations.deleted_at is null")
                                          ->where('affiliate_observations.observation_type_id','=',13)
                                          ->get();
                                                          
                    $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                    foreach ($AfiReposicionFondos13 as $datos) {    
                      array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                    }
                    $sheet->fromArray($rows, null, 'A1', false, false);
                    $sheet->cells('A1:J1', function ($cells) 
                    {
                      // manipulate the range of cells
                      $cells->setBackground('#058A37');
                      $cells->setFontColor('#ffffff');
                    });
                  });

                  // OBSERVADOS DOCUMENTOS PREVERIFICADOS
                  $excel->sheet('Obs.Preverificados', function ($sheet)  
                  {
                      global $AfiDocumentosPreverificados16;
                      $AfiDocumentosPreverificados16 = DB::table('affiliate_observations')
                                                  ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                                  concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                                  ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                                  ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                                  ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                                  ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                                  ->whereRaw("affiliate_observations.deleted_at is null")
                                                  ->where('affiliate_observations.observation_type_id','=',16)
                                                  ->get();
                                                            
                      $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                      foreach ($AfiDocumentosPreverificados16 as $datos) {    
                        array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                      }
                      $sheet->fromArray($rows, null, 'A1', false, false);
                      $sheet->cells('A1:J1', function ($cells) 
                      {
                        // manipulate the range of cells
                        $cells->setBackground('#058A37');
                        $cells->setFontColor('#ffffff');
                      });
                    });

                  // OBSERVADOS DADOS DE BAJA
                    $excel->sheet('Obs.Dados_Baja', function ($sheet)  
                    {
                        global $AfiDadoBaja20;
                        $AfiDadoBaja20 = DB::table('affiliate_observations')
                                    ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                    concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                    ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                    ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                    ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                    ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                    ->whereRaw("affiliate_observations.deleted_at is null")
                                    ->where('affiliate_observations.observation_type_id','=',20)
                                    ->get();
                                                              
                        $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                        foreach ($AfiDadoBaja20 as $datos) {    
                          array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                        }
                        $sheet->fromArray($rows, null, 'A1', false, false);
                        $sheet->cells('A1:J1', function ($cells) 
                        {
                          // manipulate the range of cells
                          $cells->setBackground('#058A37');
                          $cells->setFontColor('#ffffff');
                        });
                      });
                  
                    // OBSERVACION DE SENTENCIAS Y RESOLUCIONES JUDICIALES
                      $excel->sheet('Obs.Judiciales', function ($sheet)  
                      {
                          global $AfiJudiciales21;
                          $AfiJudiciales21 = DB::table('affiliate_observations')
                                          ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                          concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                          ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                          ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                          ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                          ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                          ->whereRaw("affiliate_observations.deleted_at is null")
                                          ->where('affiliate_observations.observation_type_id','=',21)
                                          ->get();
                                                                
                          $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                          foreach ($AfiJudiciales21 as $datos) {    
                            array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                          }
                          $sheet->fromArray($rows, null, 'A1', false, false);
                          $sheet->cells('A1:J1', function ($cells) 
                          {
                            // manipulate the range of cells
                            $cells->setBackground('#058A37');
                            $cells->setFontColor('#ffffff');
                          });
                        });
                      
                      // OBSERVACION DE RETENCION DE FONDOS
                       $excel->sheet('Obs.Retencion_Fondos ', function ($sheet)  
                        {
                            global $AfiRetencionFondos22;
                            $AfiRetencionFondos22 = DB::table('affiliate_observations')
                                                ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                                concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                                ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                                ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                                ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                                ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                                ->whereRaw("affiliate_observations.deleted_at is null")
                                                ->where('affiliate_observations.observation_type_id','=',22)
                                                ->get();
                                                                  
                            $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                            foreach ($AfiRetencionFondos22 as $datos) {    
                              array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                            }
                            $sheet->fromArray($rows, null, 'A1', false, false);
                            $sheet->cells('A1:J1', function ($cells) 
                            {
                              // manipulate the range of cells
                              $cells->setBackground('#058A37');
                              $cells->setFontColor('#ffffff');
                            });
                          });
                      

                          // OBSERVACION POR NUEVAS NUPCIAS
                        $excel->sheet('Obs.Nupcias', function ($sheet)  
                          {
                              global $AfiNuevasNupcias24;
                              $AfiNuevasNupcias24 = DB::table('affiliate_observations')
                                                ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                                concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                                ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                                ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                                ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                                ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                                ->whereRaw("affiliate_observations.deleted_at is null")
                                                ->where('affiliate_observations.observation_type_id','=',24)
                                                ->get();
                                                                    
                              $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                              foreach ($AfiNuevasNupcias24 as $datos) {    
                                array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                              }
                              $sheet->fromArray($rows, null, 'A1', false, false);
                              $sheet->cells('A1:J1', function ($cells) 
                              {
                                // manipulate the range of cells
                                $cells->setBackground('#058A37');
                                $cells->setFontColor('#ffffff');
                              });
                            });
                        
                          // OBSERVACION EXCLUIDO POR INVALIDEZ
                            $excel->sheet('Obs.Invalidez', function ($sheet)  
                            {
                                global $AfiInvalidez25;
                                $AfiInvalidez25 = DB::table('affiliate_observations')
                                                  ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                                  concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                                  ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                                  ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                                  ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                                  ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                                  ->whereRaw("affiliate_observations.deleted_at is null")
                                                  ->where('affiliate_observations.observation_type_id','=',25)
                                                  ->get();
                                                                      
                                $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                                foreach ($AfiInvalidez25 as $datos) {    
                                  array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                                }
                                $sheet->fromArray($rows, null, 'A1', false, false);
                                $sheet->cells('A1:J1', function ($cells) 
                                {
                                  // manipulate the range of cells
                                  $cells->setBackground('#058A37');
                                  $cells->setFontColor('#ffffff');
                                });
                              });

                          //OBSERVACION POR INCONSISTENCIA DE DATOS
                              $excel->sheet('Obs.Inconsistencia', function ($sheet)  
                              {
                                  global $InconsistenciaDatos26;
                                  $InconsistenciaDatos26 = DB::table('affiliate_observations')
                                                    ->select(DB::raw("DISTINCT on (affiliates.id) affiliates.id, affiliates.identity_card, affiliates.registration, degrees.shortened,  concat(affiliates.first_name, ' ', affiliates.second_name) AS names,
                                                    concat(affiliates.last_name, ' ', affiliates.mothers_last_name) AS surnames,affiliate_states.name AS state,affiliate_observations.observation_type_id,observation_types.name AS observation"))
                                                    ->leftJoin('affiliates','affiliate_observations.affiliate_id','=','affiliates.id')
                                                    ->leftJoin('observation_types','affiliate_observations.observation_type_id','=','observation_types.id')
                                                    ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                                    ->leftJoin('affiliate_states','affiliates.affiliate_state_id','=','affiliate_states.id')
                                                    ->whereRaw("affiliate_observations.deleted_at is null")
                                                    ->where('affiliate_observations.observation_type_id','=',26)
                                                    ->get();
                                                                        
                                  $rows = array(array('CI','MATRICULA','GRADO','NOMBRES','APELLIDOS', 'ESTADO','OBSERVACION'));
                                  foreach ($InconsistenciaDatos26 as $datos) {    
                                    array_push($rows, array($datos->identity_card, $datos->registration, $datos->shortened,$datos->names,$datos->surnames,$datos->state,$datos->observation));
                                  }
                                  $sheet->fromArray($rows, null, 'A1', false, false);
                                  $sheet->cells('A1:J1', function ($cells) 
                                  {
                                    // manipulate the range of cells
                                    $cells->setBackground('#058A37');
                                    $cells->setFontColor('#ffffff');
                                  });
                                });
                    
                  
                


          })->download('xlsx');
         Session::flash('message', "Exportación Exitosa");
        return redirect('afi_observations');
      }
      else
      {
        Session::flash('message', "No existen registros");
        return redirect('afi_observations');
      }
      
        
    }



    public function get_eco_com_compare2018_2017()
    {global $result;

      $eco2018= DB::table('eco_com_applicants')
                    ->select(DB::raw("economic_complements.id,eco_com_applicants.identity_card as bene_ci, eco_com_applicants.first_name bene_nombre,eco_com_applicants.last_name as bene_paterno,eco_com_applicants.mothers_last_name as bene_materno, economic_complements.code as codigo, economic_complements.reception_date as fecha, economic_complements.year as ano, economic_complements.semester as semestre, economic_complements.total_rent as renta, economic_complements.aps_total_cc,economic_complements.aps_total_fsa, economic_complements.aps_total_fs,  economic_complements.aps_disability as renta_invalidez, affiliates.identity_card as afi_ci, affiliates.first_name as afi_nombre,affiliates.last_name as paterno, affiliates.mothers_last_name as materno, pension_entities.name as ente_gestor, eco_com_types.name as modalidad"))
                    ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                    ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                    ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                    ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                    ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                    ->where('pension_entities.id', '<>', 5)
                    ->where('economic_complements.eco_com_procedure_id', '=', 7)
                    ->where('economic_complements.total_rent', '>', 0)->get();

        foreach($eco2018 as $item2018) 
        {
            $eco2017= DB::table('eco_com_applicants')
                    ->select(DB::raw("economic_complements.id,eco_com_applicants.identity_card as bene_ci, eco_com_applicants.first_name bene_nombre,eco_com_applicants.last_name as bene_paterno,eco_com_applicants.mothers_last_name as bene_materno, economic_complements.code as codigo, economic_complements.reception_date as fecha, economic_complements.year as ano, economic_complements.semester as semestre, economic_complements.total_rent as renta, economic_complements.aps_total_cc,economic_complements.aps_total_fsa, economic_complements.aps_total_fs,  economic_complements.aps_disability as renta_invalidez, affiliates.identity_card as afi_ci, affiliates.first_name as afi_nombre,affiliates.last_name as paterno, affiliates.mothers_last_name as materno, pension_entities.name as ente_gestor, eco_com_types.name as modalidad"))
                    ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                    ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                    ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                    ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                    ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                    ->where('pension_entities.id', '<>', 5)
                    ->where('economic_complements.eco_com_procedure_id', '=', 6)
                    ->where('economic_complements.total_rent', '>', 0)
                    ->where('eco_com_applicants.identity_card','=',rtrim($item2018->bene_ci))->first();
            if($eco2017)
            {

            
                    $comp2018=0;
                    if ($item2018->aps_total_fsa > 0) 
                    {
                        $comp2018++;
                    }
                    if ($item2018->aps_total_cc > 0) 
                    {
                        $comp2018++;
                    }
                    if ($item2018->aps_total_fs > 0) 
                    {
                        $comp2018++;
                    }
                    
                    $comp2017=0;
                    if ($eco2017->aps_total_fsa > 0) 
                    {
                        $comp2017++;
                    }
                    if ($eco2017->aps_total_cc > 0) 
                    {
                        $comp2017++;
                    }
                    if ($eco2017->aps_total_fs > 0) 
                    {
                        $comp2017++;
                    }	
                    
                    if($comp2018 <> $comp2017 )
                    {
                        $result[]= (array)$item2018;
                    }
                   // Log::info($result);
            }
                    
        }
       // dd($result);
       Util::excel('componenetes', 'hoja',$result);
      // Excel::create('componentes', function($excel)
      // { global $result;

      //     $excel->sheet('component', function ($sheet) 
      //     {
      //       global $result;
           
      //      $result1 = (array) $result;
      //      $rows = array(array('id','bene_ci', 'bene_nombre','bene_paterno','bene_materno', 'codigo', 'fecha', 'ano', 'semestre', 'renta', 'aps_total_cc','aps_total_fsa','aps_total_fs','renta_invalidez','afi_ci','afi_nombre','afi_paterno','afi_materno','ente_gestor','modalidad'));
              
      //     //  array_push($rows, array($datos->id, $datos->bene_ci, $datos->bene_nombre,$datos->bene_paterno,$datos->bene_materno,$datos->codigo,$datos->fecha,$datos->ano,$datos->semestre,$datos->renta,$datos->aps_total_cc,$datos->aps_total_fsa,$datos->aps_total_fs,$datos->renta_invalidez,$datos->afi_ci,$datos->afi_nombre,$datos->paterno,$datos->materno,$datos->ente_gestor,$datos->modalidad));
      //       array_push($rows,array($result1));
  
      //       $sheet->fromArray((array) $rows, null, 'A1', false, false);          
  
      //     }); //FIN 
      //   })->download('xlsx');
        Session::flash('message', "Exportación Exitosa");
       return redirect('afi_observations');
    }


    public function get_eco_com_sin_rentas(Request $request)
    {  global $year, $semester, $results, $i, $afi, $list;
      if ($request->hasFile('archive')) 
		  {
       
        $reader = $request->file('archive');
        $filename = $reader->getRealPath();
        $year = $request->year;
        $semester = $request->semester;
        Log::info("Reading excel ...");
        Excel::load($filename, function ($reader) 
        {
          global $results, $i, $afi, $list;
          ini_set('memory_limit', '-1');
          ini_set('max_execution_time', '-1');
          ini_set('max_input_time', '-1');
          set_time_limit('-1');
          $results = collect($reader->get());
        });
        Log::info("done read excel");

        $afi;
        $found = 0;
        $nofound = 0;
        $procedure = EconomicComplementProcedure::whereYear('year', '=', $year)->where('semester', '=', $semester)->first();
        $ec = EconomicComplement::where('eco_com_procedure_id','=', $procedure->id)
            ->select(DB::raw('economic_complements.id,economic_complements.code,economic_complements.reception_date,economic_complements.total_rent,economic_complements.aps_disability as invalidez,economic_complements.aps_total_cc,economic_complements.aps_total_fsa,economic_complements.aps_total_fs,economic_complements.total, eco_com_types.id as type,affiliates.identity_card as ci_afi,affiliates.first_name as afi_nombres,affiliates.last_name as afi_paterno,affiliates.mothers_last_name as afi_materno,affiliates.nua'))
            ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
            ->leftJoin('eco_com_modalities', 'economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
            ->leftJoin('eco_com_types', 'eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')->get();
        
        foreach($ec as $datos)
        {
            foreach($results as $dexcel)
            {
              $nua_e1 = ltrim((string)$dexcel->nrosip_titular, "0");
              $ci_e1 = explode("-", ltrim($dexcel->nro_identificacion, "0"));
              $ci1 = $ci_e1[0];

              $nua_db1 = ltrim((string)$datos->nua, "0");
              $ci_db1 = explode("-", ltrim($datos->ci_afi, "0"));
              $cidb = $ci_db1[0];
             
              if($cidb == $ci1 && $nua_db1 == $nua_db1)
              {
                
              }
              else
              {
                $list[] = $datos;
              }

            }
        }
   
			Util::excel('Rentas No Existen', 'Noexisten',$list);
		//	Session::flash('message', "Veificacion completada" . " BIEN:" . $found . " MAL:" . $nofound);
			return redirect('afi_observations');
    }
  }
    


   






}
