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
use Validator;
use Session;
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
            // ->where('economic_complements.eco_com_procedure_id','2')
            ->select('economic_complements.id','economic_complements.code')

            ->get();
        return Datatables::of($economic_complements)
                ->addColumn('action', function ($economic_complement) { return  '
                    <div class="btn-group" style="margin:-3px 0;">
                        <a href="economic_complement/'.$economic_complement->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                    </div>';})
                ->make(true);
    }
    public function DataEdited()
    {
        $user_role_id=Auth::user()->roles()->first();
        $economic_complements=EconomicComplement::where('eco_com_state_id',null)->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
            ->where('wf_states.role_id',($user_role_id->id))
            ->where('economic_complements.state','Edited')
            ->where('economic_complements.eco_com_procedure_id','2')
            ->where('economic_complements.user_id',Auth::user()->id)
            //->select('economic_complements.id','economic_complements.code')
            // ->take(4)
            ->get();
        // return  $economic_complements;
        return Datatables::of($economic_complements)
                ->addColumn('action', function ($economic_complement) {
                    return '<div class="checkbox">
                        <label>
                            <input type="checkbox" class="checkBoxClass" value="'.$economic_complement->id.'" name="edited[]"><span class="checkbox-material"><span class="check"></span></span> 
                        </label>
                        </div>';
                })
                ->make(true);
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
             'edited' =>'required',
        ];
        $messages = [
            'edited.required' => 'Debe seleccionar por lo menos un tramite para enviar',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('inbox')
            ->withErrors($validator)
            ->withInput();
        }else{
            foreach ($request->edited as $key) {
                $e=EconomicComplement::find($key);
                $wfsq=WorkflowSequence::where('wf_state_current_id',$e->wf_current_state_id)->where('action','Aprobar')->first();
                $e->wf_current_state_id=$wfsq->wf_state_next_id;
                $e->state='Received';
                $e->save();
            }
            return view('inbox.view'); 
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
