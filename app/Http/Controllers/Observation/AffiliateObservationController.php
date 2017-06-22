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
      if (isset($request->economic_complement_id)) {
        $economic_complement = EconomicComplement::where('id',$request->economic_complement_id)->first();
        $observations=AffiliateObservation::where('affiliate_id',$request->affiliate_id)->select(['id','affiliate_id','date','message','observation_type_id'])->get();
        $observations_list = collect(new AffiliateObservation);
        foreach ($observations as $obs) {
          if(Util::getYear($economic_complement->year)==Util::getYear($obs->date) && Util::getSemester($economic_complement->year) == Util::getSemester($obs->date)){
            $observations_list->push($obs);
          }
        }
      } else {
        $observations_list=AffiliateObservation::where('affiliate_id',$request->affiliate_id)->select(['id','affiliate_id','date','message','observation_type_id'])->get();
      }

      return Datatables::of($observations_list)
        ->addColumn('type',function ($observation){
          return $observation->observationType->name;
        })
        ->addColumn('action', function ($observation) {
          return
            '<div class="btn-group" style="margin:-3px 0;">
            <button type="button" class="btn btn-primary btn-raised btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="/print_observations/'.$observation->affiliate_id.'/'.$observation->observation_type_id.'"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
                <li><a data-id="'.$observation->id.'" class="editObservation" href="#" role="button" data-toggle="modal" data-target="#observationEditModal" ><i class="fa fa-pencil" ></i> Editar</a></li>
                <li><a href="/observation/deleteOb/' .$observation->id. '">' .$observation->observation_type. '<i class="fa fa-times-circle"></i> Eliminar</a></li>
              </ul>
            </div>';})
        ->make(true);
    }
    public function update(Request $request)
    {
      $affiliateObservation=AffiliateObservation::find($request->observation_id);
      $affiliateObservation->user_id=Auth::user()->id;
      $affiliateObservation->affiliate_id=$request->affiliate_id;
      $affiliateObservation->date=Carbon::now();
      $affiliateObservation->observation_type_id=$request->observation_type_id;
      $affiliateObservation->message=$request->message;
      $affiliateObservation->save();
      return redirect('affiliate/'.$request->affiliate_id);
    }
  }