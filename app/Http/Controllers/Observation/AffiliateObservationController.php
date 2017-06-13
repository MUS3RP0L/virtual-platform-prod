<?php

namespace Muserpol\Http\Controllers\Observation;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;
use Muserpol\AffiliateObservation;
use Muserpol\Affiliate;
use Muserpol\ObservationType;
use Muserpol\EconomicComplement;
use Carbon\Carbon;
use Util;

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

    public function showOfAffiliate(Request $request)
    {   
        $economic_complement = EconomicComplement::where('id',$request->eid)->first();
        $observations=AffiliateObservation::where('affiliate_id',$request->id)->select(['id','affiliate_id','date','message','observation_type_id'])->first();
        dd($economic_complement->year,$observations->date);
        // if($observations->date==$economic_complement->year){
        //     dd($economic_complement->year,$observations->date);
        // } else {
        //     dd("No quiero mostrar nada");
        // }
        // // $observations = AffiliateObservation::where('affiliate_observations.affiliate_id',$request->id)->leftJoin('economic_complements','affiliate_observations.affiliate_id','=','economic_complements.affiliate_id')->select('affiliate_observations.id','affiliate_observations.date','affiliate_observations.message',' bn
        //     ikaffiliate_observations.observation_type_id','economic_complements.id as eco_id')->get();
        return Datatables::of($observations)
                ->addColumn('type',function ($observation)
                {
                    return $observation->observationType->name;
                })
                ->addColumn('action', function ($observation) {
                    return
                        '<div class="btn-group">
                          <button type="button" class="btn btn-warning btn-raised btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Opciones <span class="caret"></span>
                          </button>
                          <ul class="dropdown-menu">
                              <li><a href="/print_observations/'.$observation->affiliate_id.'/'.$observation->observation_type_id.'" style="padding:3px 10px;"><i class="glyphicon glyphicon-print"></i> Imprimir Observación</a></li>
                              <li><a href="/observation/deleteOb/' .$observation->id. '" style="padding:3px 10px;" class="btn btn-danger btn-raised btn-sm">' .$observation->observation_type. '<i class="glyphicon glyphicon-minus"></i> Eliminar</a></li>
                          </ul>
                        </div>';})
                ->make(true);
    }
}
