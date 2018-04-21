<?php

namespace Muserpol\Http\Controllers\Inbox;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Muserpol\Affiliate;
use Muserpol\WorkflowSequence;
use Muserpol\WorkflowState;
use Muserpol\EconomicComplement;
// use Datatables;
use Yajra\Datatables\Facades\Datatables;
use Util;
use Auth;
use Validator;
use Session;
use stdClass;
use Carbon\Carbon;
use Log;
use DB;
use Muserpol\WorkflowRecord;
class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // dd(Util::getRol());
        //return Util::getRol();
        if(Util::getRol()->module_id ==2 || Util::getRol()->module_id ==9 || Util::getRol()->module_id == 8  )
        {
            
            $sw_actual = WorkflowState::where('role_id',Util::getRol()->id)->first();
            
            $secuencias_atras = WorkflowState::where('sequence_number','<',$sw_actual->sequence_number )->select('id','name')->orderBy('sequence_number')->get();

            $secuencias = array();
            if($sw_actual)
            {
                $sequence = WorkflowSequence::where("workflow_id",'<=',3)
                                         ->where("wf_state_current_id",$sw_actual->id)
                                         ->where('action','Aprobar')
                                         ->get();
                // return $sw_actual;
                // return $sequence;

                
                foreach ($sequence as $s) {
                                # code...
                    $wf = WorkflowState::where('id',$s->wf_state_next_id)->first();
                    Log::info("workflows:");
                    Log::info($wf);
                    $wf_nexts = array('id'=>$wf->id,'name'=>$wf->name,'workflow_id'=>$s->workflow_id);
                    Log::info("next:");
                    Log::info($wf_nexts);

                    array_push($secuencias, $wf_nexts);
                }            
                // $sw_siguiente = WorkflowState::where('id',$sequence->wf_state_next_id)->first();
            }else
            {
                $sw_siguiente = null;
            }
            
            $workflow_ids = Util::getRol()->module->workflows->pluck('name', 'id');
            $workflow_ids2  = Util::getRol()->module->workflows;
            $workflow_ids_edited  = Util::getRol()->module->workflows;
            $wfss=[];
            foreach ($workflow_ids2 as $key => $value) {
                $q_economic_complements=EconomicComplement::leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
                   ->where('economic_complements.state','Edited')
                   ->where('economic_complements.workflow_id',$value->id)
                   ->where('wf_states.role_id',(Util::getRol()->id))
                   ->where('economic_complements.user_id',Auth::user()->id)
                   ->get()->count();
                   $data = new stdClass;
                   // $data->quantity = $value->name.' ('.$q_economic_complements.')';
                   $data->quantity = $q_economic_complements;
                   $data->id = $value->id;
                   $data->module_id = $value->module_id;
                   $data->name = $value->shortened;
                   switch ($value->id) {
                       case '1':
                           $data->color = 'btn-success';
                           break;
                       case '2':
                           $data->color = 'btn-warning';
                           break;
                       case '3':
                           $data->color = 'btn-info';
                           break;
                       default:
                           $data->color = 'btn-default';
                           break;
                   }
                   $wfss[]=$data;
            }
            $workflow_ids_received  = Util::getRol()->module->workflows;
            $wf_received=[];
            foreach ($workflow_ids_received as $key => $value) {
                $q_economic_complements=EconomicComplement::leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
                   ->where('economic_complements.state','Received')
                   ->where('wf_states.role_id',(Util::getRol()->id))
                   ->where('economic_complements.workflow_id',$value->id)
                   ->leftJoin('eco_com_applicants','economic_complements.id', '=', 'eco_com_applicants.economic_complement_id')
                   ->get()->count()
                   ;

                   $data = new stdClass;
                   // $data->quantity = $value->name.' ('.$q_economic_complements.')';
                   $data->quantity = $q_economic_complements;
                   $data->id = $value->id;
                   $data->module_id = $value->module_id;
                   $data->name = $value->shortened;
                   switch ($value->id) {
                       case '1':
                           $data->color = 'btn-success';
                           break;
                       case '2':
                           $data->color = 'btn-warning';
                           break;
                       case '3':
                           $data->color = 'btn-info';
                           break;
                       default:
                           $data->color = 'btn-default';
                           break;
                   }
                   $wf_received[]=$data;
            }
            $data = array('sw_actual' => $sw_actual,
                            'secuencias' => $secuencias,
                            'workflow_ids'=> $workflow_ids ,
                            'wfs'=>$wfss,
                            'secuencias_atras' => $secuencias_atras,
                            'wf_received'=>$wf_received );

        //    return $data;

            return view('inbox.view',$data);
        }
        else
        {
            return redirect("home");
        }
       
    }
    public function DataReceived()
    {

        // $rol=Auth::user()->roles()->first();
        // dd($rol);
        //id de tramites en proceso
        $rol = Util::getRol();
        Log::info("rol actual".$rol);
        $state_id = 16;
        $economic_complements=DB::table('economic_complements')
            ->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
            ->leftJoin('v_observados','v_observados.id','=','economic_complements.affiliate_id')
            ->where('economic_complements.state','Received')
            ->where('wf_states.role_id',($rol->id))
            ->leftJoin('eco_com_applicants','economic_complements.id', '=', 'eco_com_applicants.economic_complement_id')
            ->leftJoin('cities','economic_complements.city_id', '=', 'cities.id')

            ->select(DB::raw("DISTINCT ON (economic_complements.id) economic_complements.id"),'economic_complements.affiliate_id','eco_com_applicants.identity_card as ci',DB::raw("trim(regexp_replace(CONCAT(eco_com_applicants.first_name,' ',eco_com_applicants.second_name,' ',eco_com_applicants.last_name,' ',eco_com_applicants.mothers_last_name,' ',eco_com_applicants.surname_husband),'( )+' , ' ', 'g')) as name"),'cities.second_shortened as city','economic_complements.code','v_observados','economic_complements.workflow_id')
            // ->select(DB::raw("DISTINCT ON (economic_complements.id) economic_complements.id, economic_complements.affiliate_id,economic_complements.workflow_id, eco_com_applicants.identity_card as ci, trim(regexp_replace(CONCAT(eco_com_applicants.first_name,' ',eco_com_applicants.second_name,' ',eco_com_applicants.last_name,' ',eco_com_applicants.mothers_last_name,' ',eco_com_applicants.surname_husband),'( )+' , ' ', 'g')) as name ,cities.second_shortened as city, economic_complements.code"))
            ->orderBy('economic_complements.id', 'asc');



        return Datatables::queryBuilder($economic_complements)

                ->addColumn('workflow_id',function ($economic_complement)
                {
                    return $economic_complement->workflow_id;
                })
                ->addColumn('ci',function ($economic_complement)
                {
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->ci.' </a>';
                })
                ->addColumn('name',function ($economic_complement)
                {
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->name.'</a>';
                })
                ->addColumn('city',function ($economic_complement)
                {
                    return $economic_complement->city;
                })
                ->addColumn('code',function ($economic_complement)
                {
                    //$observation =DB::table('affiliate_observations')->where('affiliate_id',$economic_complement->affiliate_id)->first();
                    $icon = $economic_complement->v_observados?'<span class="badge bg-yellow" data-toggle="tooltip" data-placement="top" title="Trámite Observado"><i class="fa fa-warning"></span></i>':'';
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->code.'</a> '.$icon;
                })
                /*->addColumn('action', function ($economic_complement) { return  '
                    <div class="btn-group" style="margin:-3px 0;">
                        <a href="economic_complement/'.$economic_complement->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                    </div>';})*/
                ->make(true);
    }
    public function DataEdited()
    {
        
        $rol = Util::getRol();
         $economic_complements=DB::table('economic_complements')
            ->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
            ->leftJoin('v_observados','v_observados.id','=','economic_complements.affiliate_id')
            ->where('economic_complements.state','Edited')
            ->where('wf_states.role_id',($rol->id))
            ->where('economic_complements.user_id',Auth::user()->id)
            ->leftJoin('eco_com_applicants','economic_complements.id', '=', 'eco_com_applicants.economic_complement_id')
            ->leftJoin('cities','economic_complements.city_id', '=', 'cities.id')
            ->select(DB::raw("DISTINCT ON (economic_complements.id) economic_complements.id"),'economic_complements.affiliate_id','eco_com_applicants.identity_card as ci',DB::raw("trim(regexp_replace(CONCAT(eco_com_applicants.first_name,' ',eco_com_applicants.second_name,' ',eco_com_applicants.last_name,' ',eco_com_applicants.mothers_last_name,' ',eco_com_applicants.surname_husband),'( )+' , ' ', 'g')) as name"),'cities.second_shortened as city','economic_complements.code','v_observados','economic_complements.workflow_id')
            ->orderBy('economic_complements.id', 'asc');
            // ->select(DB::raw("economic_complements.affiliate_id,economic_complements.workflow_id, economic_complements.id, eco_com_applicants.identity_card as ci, trim(regexp_replace(CONCAT(eco_com_applicants.first_name,' ',eco_com_applicants.second_name,' ',eco_com_applicants.last_name,' ',eco_com_applicants.mothers_last_name,' ',eco_com_applicants.surname_husband),'( )+' , ' ', 'g')) as name ,cities.second_shortened as city, economic_complements.code,v_observados.id as observation"))
            // ->orderBy('economic_complements.code', 'asc')
            // ;

            return Datatables::queryBuilder($economic_complements)
          
                    ->addColumn('workflow_id',function ($economic_complement)
                    {
                        return $economic_complement->workflow_id;
                    })
                    ->editColumn('id', function ($economic_complement) {
                        return '<input type="checkbox" class="checkBoxClass check" value="'.$economic_complement->id.'" name="id[]" onclick="cli()"> ';
                    })
                    ->addColumn('ci',function ($economic_complement)
                    {
                        return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->ci.'</a>';
                    })
                    ->addColumn('name',function ($economic_complement)
                    {
                        return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->name.'</a>';
                    })
                    ->addColumn('city',function ($economic_complement)
                    {
                        return $economic_complement->city;
                    })
                    ->addColumn('code',function ($economic_complement)
                    {
                        // $observation =DB::table('v_observados')->where('affiliate_id',$economic_complement->affiliate_id)->first();
                        $icon = $economic_complement->v_observados?'<span class="badge bg-yellow" data-toggle="tooltip" data-placement="top" title="Trámite Observado"><i class="fa fa-warning"></span></i>':'';
                        return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->code.'</a> '.$icon;
                    })
                    /*->addColumn('action', function ($economic_complement) { return  '
                        <div class="btn-group" style="margin:-3px 0;">
                            <a href="economic_complement/'.$economic_complement->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                        </div>';})*/
                    ->make(true);

    }
    public function send_all()
    {
        $rol = Util::getRol();
        $ids=EconomicComplement::where('economic_complements.state','Received')->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
            ->where('wf_states.role_id',($rol->id))
            ->select('economic_complements.id','economic_complements.code')
            ->get()
            ->pluck('id')
            ;
        $economic_complements=EconomicComplement::whereIn('id',$ids)->get();
        foreach ($economic_complements as $eco) {
             $eco->user_id = Auth::user()->id;
             $eco->aprobation_date  = date('Y-m-d');    
             $eco->state = 'Edited';
             // dd($eco);
             $eco->save();
        }
        return redirect('inbox'); 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
             'ids' =>'required|min:1',
        ];
        $messages = [
            'ids.required' => 'Debe seleccionar por lo menos un tramite para enviar',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('inbox')
            ->withErrors($validator)
            ->withInput();
        }else{
            // foreach ($request->edited as $key) {
            //     $e=EconomicComplement::find($key);
            //     $wfsq=WorkflowSequence::where('wf_state_current_id',$e->wf_current_state_id)->where('action','Aprobar')->first();
            //     $e->wf_current_state_id=$wfsq->wf_state_next_id;
            //     $e->state='Received';
            //     // $e->save();
            // }
            if($request->type==2)
            {
                foreach (explode(',',$request->ids) as $key) {
                    $e=EconomicComplement::find($key);
                    // $wfsq=WorkflowSequence::where('wf_state_current_id',$e->wf_current_state_id)->where('action','Aprobar')->first();
                    $e->wf_current_state_id=$request->wf_state_next_id;
                    $e->state='Received';
                    $e->save();
                }
            }
            if($request->type==1)
            {
                foreach (explode(',',$request->ids) as $key) {
                    $e=EconomicComplement::find($key);
                    // $wfsq=WorkflowSequence::where('wf_state_current_id',$e->wf_current_state_id)->where('action','Aprobar')->first();
                    $e->wf_current_state_id=$request->wf_state_id;
                    $e->state='Received';
                    $e->save();
                    $new = DB::table('wf_states')->where('id',$e->wf_current_state_id)->first();
                    $old_wf = DB::table('wf_states')->where('id',$e->wf_current_state_id)->first();
                    $wf_record=new WorkflowRecord;
                    $wf_record->user_id=Auth::user()->id;
                    $wf_record->date=Carbon::now();
                    $wf_record->eco_com_id=$e->id;
                    $wf_record->wf_state_id=$e->wf_current_state_id;
                    $wf_record->record_type_id=1;
                    $wf_record->message="El usuario ".Util::getFullNameuser()." devolvio el tramite de ".$old_wf->name." a ".$new->name ."  fecha ".Carbon::now()."
                    \n Motivo: ".$request->nota.".";
                    $wf_record->save();
                }
            }
            
            return redirect('inbox'); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
