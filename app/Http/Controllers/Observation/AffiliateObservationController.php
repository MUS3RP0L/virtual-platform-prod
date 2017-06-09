<?php

namespace Muserpol\Http\Controllers\Observation;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;
use Muserpol\AffiliateObservation;
use Muserpol\Affiliate;
use Muserpol\ObservationType;
use Carbon\Carbon;

use Auth;
use Datatables;
use Session;
use Validator;

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
            'observation_type_id' => 'required',
            'message' => 'required|min:5',
        ];
        $messages = [
            'observation_type_id.required' => 'El campo tipo de observacion es requerido',

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
            $observation=new AffiliateObservation();
            $observation->user_id=Auth::user()->id;
            $observation->affiliate_id=$request->affiliate_id;
            $observation->date=Carbon::now();
            $observation->observation_type_id=$request->observation_type_id;
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
        
        $observation=AffiliateObservation::find($id);
        return $observation;
    }
    public function deleteOb($id)
    {
        $observation=AffiliateObservation::find($id);        
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
        $observations=AffiliateObservation::where('affiliate_id',$request->id)->select(['id','affiliate_id','date','message','observation_type_id'])->get();
        return Datatables::of($observations)
                ->addColumn('type',function ($observation)
                {
                    return $observation->observationType->name;
                })
                ->addColumn('action', function ($observation) {
                    $eco_com = \Muserpol\EconomicComplement::where('affiliate_id',$observation->affiliate_id)->first();
                    return
                        '<div class="btn-group">
                          <button type="button" class="btn btn-warning btn-raised btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Opciones <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                              <li><a href="/print_observations/'.$eco_com->id.'/'.$observation->observation_type_id.'" style="padding:3px 10px;"><i class="glyphicon glyphicon-print"></i> Imprimir Observación</a></li>
                              <li><a href="/observation/deleteOb/' .$observation->id. '" style="padding:3px 10px;" class="btn btn-danger btn-raised btn-sm">' .$observation->observation_type. '<i class="glyphicon glyphicon-minus"></i> Eliminar</a></li>
                          </ul>

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
