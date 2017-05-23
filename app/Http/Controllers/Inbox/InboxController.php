<?php

namespace Muserpol\Http\Controllers\Inbox;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Muserpol\Affiliate;
use Muserpol\WorkflowSequence;
use Muserpol\EconomicComplement;
use Datatables;
use Util;
use Auth;
class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('inbox.view');
    }
    public function DataReceived()
    {

        $user_ids=Auth::user()->roles()->first();
        $economic_complements=EconomicComplement::where('eco_com_state_id',null)->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
            ->where('wf_states.role_id',($user_ids->id))
            ->where('economic_complements.state','Received')
            ->select('economic_complements.id','economic_complements.code')
            ->get();
            
        // $economic_complements=EconomicComplement::where('eco_com_state_id',null)->where('state','Received')->select('id','code');
        //$data=[];
        return Datatables::of($economic_complements)
                ->addColumn('action', function ($economic_complement) { return  '
                    <div class="btn-group" style="margin:-3px 0;">
                        <a href="economic_complement/'.$economic_complement->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                    </div>';})
                ->make(true);
        foreach ($e as $v) {
            if ($v->wf_state->role_id == $user_ids->id) {
                    $o=[];
                    array_push($o,$v->id);
                    array_push($o,$v->code);
                    array_push($data,$o );
            }
        }        

       return ["data"=>$data];
    }
    public function DataEdited()
    {
         $user_ids=Auth::user()->roles()->first();
         $e=EconomicComplement::where('eco_com_state_id',null)->where('state','Edited')->get();
         $data=[];
         foreach ($e as $v) {
             if ($v->wf_state->role_id == $user_ids->id) {
                     $o=[];
                     array_push($o,$v->id);
                     array_push($o,$v->code);
                     array_push($data,$o );
                 
             }
         }        
        //dd($data);
        return ["data"=>$data];
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

        foreach ($request->edited as $key) {
            $e=EconomicComplement::find($key);
            $wfsq=WorkflowSequence::where('wf_state_current_id',$e->wf_current_state_id)->where('action','Aprobar')->first();
            $e->wf_current_state_id=$wfsq->wf_state_next_id;
            $e->save();
        }
        return; 
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
