<?php

namespace Muserpol\Http\Controllers\Observation;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;
use Muserpol\Observation;
use Carbon\Carbon;

use Auth;
use Datatables;
use Session;
use Validator;

class ObservationController extends Controller
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
            'affiliate_id' => 'required',
            'module_id' => 'required',
            'title' => 'required|min:3',
            'message' => 'required|min:5',
        ];
        $messages = [
            'title.required' => 'El campo titulo es requerido',
            'title.min' => 'El mínimo de caracteres permitidos en titulo es 3',

            'message.required' => 'El campo mensaje es requerido',
            'message.min' => 'El mínimo de caracteres permitidos en mensaje es 3'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('affiliate/'.$request->affiliate_id)
            ->withErrors($validator)
            ->withInput();
        }else{
            $message="Observacion Creada";
            $observation=new Observation();
            $observation->user_id=Auth::user()->id;
            $observation->affiliate_id=$request->affiliate_id;
            $observation->module_id=$request->module_id;
            $observation->date=Carbon::now();
            $observation->title=$request->title;
            $observation->message=$request->message;
            $observation->save();
            Session::flash('message', $message);
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
        
        $observation=Observation::find($id);
        return $observation;
    }
    public function deleteOb($id)
    {
        $observation=Observation::find($id);        
        $observation->delete();
        return back();
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
    public function showOfAffiliate(Request $request)
    {
        $observations=Observation::select(['id','date','title','message'])->where('affiliate_id','=',$request->id);
        
        return Datatables::of($observations)
                ->addColumn('action', function ($observation) { return  '
                    <div class="btn-group" style="margin:-3px 0;">
                        <a href="/observation/deleteOb/'.$observation->id.'" style="padding:3px 5px;" class="btn btn-warning btn-raised btn-sm"><i class="glyphicon glyphicon-minus"></i> Eliminar</a>
                    </div>';})
                ->make(true);
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
