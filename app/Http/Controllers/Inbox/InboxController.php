<?php

namespace Muserpol\Http\Controllers\Inbox;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Muserpol\Affiliate;
use Muserpol\WorkflowSequence;
use Muserpol\WorkflowState;
use Muserpol\EconomicComplement;
use Datatables;
use Util;
use Auth;
use Validator;
use Session;
use stdClass;
use Log;

class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
     
        if(Util::getRol()->module_id ==2 || Util::getRol()->module_id ==9 )
        {
            
            $sw_actual = WorkflowState::where('role_id',Util::getRol()->id)->first();
         
            if($sw_actual)
            {
                $sequence = WorkflowSequence::where("workflow_id",'<=',3)
                                         ->where("wf_state_current_id",$sw_actual->id)
                                         ->where('action','Aprobar')
                                         ->first();
     
                $sw_siguiente = WorkflowState::where('id',$sequence->wf_state_next_id)->first();
            }else
            {
                $sw_siguiente = null;
            }
            
            $workflow_ids = Util::getRol()->module->workflows->pluck('name', 'id');
            $workflow_ids2  = Util::getRol()->module->workflows;
            $data = array('sw_actual' => $sw_actual, 'sw_siguiente' => $sw_siguiente, 'workflow_ids'=> $workflow_ids ,'wfs'=>$workflow_ids2 );
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
        $economic_complements=EconomicComplement::where('economic_complements.state','Received')->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
            // ->leftJoin('eco_com_applicants','economic_complements.id','=','eco_com_applicants.economic_complement_id')
            ->where('wf_states.role_id',($rol->id))
            ->where('economic_complements.eco_com_procedure_id','2')
            ->select('economic_complements.id','economic_complements.code')
            ->get()
            ->pluck('id');
        $economic_complements=EconomicComplement::whereIn('id',$economic_complements)->get();
        return Datatables::of($economic_complements)
                ->addColumn('workflow_id',function ($economic_complement)
                {
                    return $economic_complement->workflow_id;
                })
                ->addColumn('ci',function ($economic_complement)
                {
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->economic_complement_applicant->identity_card.'</a>';
                })
                ->addColumn('name',function ($economic_complement)
                {
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->economic_complement_applicant->getFullName().'</a>';
                })
                ->addColumn('city',function ($economic_complement)
                {
                    return $economic_complement->city->second_shortened ?? '';
                })
                ->addColumn('code',function ($economic_complement)
                {
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->code.'</a>';
                })
                /*->addColumn('action', function ($economic_complement) { return  '
                    <div class="btn-group" style="margin:-3px 0;">
                        <a href="economic_complement/'.$economic_complement->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                    </div>';})*/
                ->make(true);
    }
    public function DataEdited()
    {
        // $user_role_id=Auth::user()->roles()->first();
        $rol = Util::getRol();
        //id de tramites en proceso
        $state_id = 16;
        $economic_complements=EconomicComplement::where('economic_complements.state','Edited')->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
            ->where('wf_states.role_id',($rol->id))
            ->where('economic_complements.eco_com_procedure_id','2')
            ->where('economic_complements.user_id',Auth::user()->id)
            ->select('economic_complements.id','economic_complements.code')
            // ->take(4)
            ->get()->pluck('id');
            $economic_complements=EconomicComplement::whereIn('id',$economic_complements)->get();

            /*$data=[];
            foreach ($economic_complements as $eco) {
                $temp=[];
                // $temp[]= new stdClass;
                $temp[]= $eco->id;
                $temp[]= $eco->economic_complement_applicant->identity_card;
                $temp[]= $eco->economic_complement_applicant->getFullName();
                $temp[]= $eco->city->second_shortened ?? '';
                $temp[]= $eco->code;

                    $data[] = $temp;

            }
            return response()->json(["data"=>$data]);*/
        
        return Datatables::of($economic_complements)
                ->addColumn('workflow_id',function ($economic_complement)
                {
                    return $economic_complement->workflow_id;
                })
                ->editColumn('id', function ($economic_complement) {
                    return '
                            <input type="checkbox" class="checkBoxClass" value="'.$economic_complement->id.'" name="id[]"><span class="checkbox-material"><span class="check"></span></span> ';
                })
                // ->editColumn('id', function ($economic_complement) {
                //     return '
                //         <div class="checkbox">
                //         <label>
                //             <input type="checkbox" class="checkBoxClass" value="'.$economic_complement->id.'" name="id[]"><span class="checkbox-material"><span class="check"></span></span> 
                //         </label>
                //         </div>';
                // })
                ->addColumn('city',function ($economic_complement)
                {
                    return $economic_complement->city->second_shortened ?? '';
                })
                ->addColumn('ci',function ($economic_complement)
                {
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->economic_complement_applicant->identity_card.'</a>';
                })
                ->addColumn('name',function ($economic_complement)
                {
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->economic_complement_applicant->getFullName().'</a>';
                })
                ->addColumn('code',function ($economic_complement)
                {
                    return '<a href="'.url('economic_complement', $economic_complement->id).'">'.$economic_complement->code.'</a>';
                })
                ->make(true);
    }
    public function send_all()
    {
        $rol = Util::getRol();
        $ids=EconomicComplement::where('economic_complements.state','Received')->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
            ->where('wf_states.role_id',($rol->id))
            ->where('economic_complements.eco_com_procedure_id','2')
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
            foreach (explode(',',$request->ids) as $key) {
                $e=EconomicComplement::find($key);
                $wfsq=WorkflowSequence::where('wf_state_current_id',$e->wf_current_state_id)->where('action','Aprobar')->first();
                $e->wf_current_state_id=$wfsq->wf_state_next_id;
                $e->state='Received';
                $e->save();
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
