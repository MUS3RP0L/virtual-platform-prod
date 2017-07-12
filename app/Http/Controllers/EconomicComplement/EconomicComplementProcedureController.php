<?php

namespace Muserpol\Http\Controllers\EconomicComplement;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\EconomicComplementProcedure;

class EconomicComplementProcedureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('economic_complements.procedure.index');
    }
    public function Data(Request $request)
    {
        $procedures = EconomicComplementProcedure::select(['id', 'year', 'semester', 'normal_start_date', 'normal_end_date', 'lagging_start_date', 'lagging_end_date',  'additional_start_date', 'additional_end_date']);
        return Datatables::of($procedures)
               ->editColumn('year', function ($procedure) { return Util::getYear($procedure->year); })
               ->addColumn('action', function ($procedure) { return
                   '<div class="btn-group" style="margin:-3px 0;">
                   <a href="" data-procedure_id="'.$procedure->id.'" class="btn btn-primary btn-raised btn-sm editProcedure" data-toggle="modal" data-target="#modalEditProcedure">&nbsp;&nbsp;<i class="fa fa-pencil"></i>&nbsp;&nbsp;</a>
                   <a href="" class="btn btn-primary btn-raised btn-sm dropdown-toggle" data-toggle="dropdown">&nbsp;<span class="caret"></span>&nbsp;</a>
                   <ul class="dropdown-menu">
                       <li><a href="" data-procedure_id="'.$procedure->id.'"  data-toggle="modal" data-target="#modalDeleteProcedure" style="padding:3px 10px;" class="deleteProcedure"><i class="fa fa-minus"></i> Eliminar</a></li>
                   </ul>
                   </div>';})
               ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        $economic_complement_procedure=EconomicComplementProcedure::all()->last();
        $normal_start_date=Carbon::parse($economic_complement_procedure->normal_start_date)->format('d/m/Y');
        $normal_end_date=Carbon::parse($economic_complement_procedure->normal_end_date)->format('d/m/Y');
        $lagging_start_date = Carbon::parse($economic_complement_procedure->lagging_start_date)->format('d/m/Y');
        $lagging_end_date = Carbon::parse($economic_complement_procedure->lagging_end_date)->format('d/m/Y');
        $additional_start_date = Carbon::parse($economic_complement_procedure->additional_start_date)->format('d/m/Y');
        $additional_end_date = Carbon::parse($economic_complement_procedure->additional_end_date)->format('d/m/Y');
        $year = Carbon::now()->year;
        $semester = Util::getCurrentSemester();
        return view('economic_complements.procedure.create',compact('normal_start_date','normal_end_date','lagging_start_date','lagging_end_date','additional_start_date','additional_end_date','year','semester'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save($request, $eco_com_pro_id)
    {

        $exists = EconomicComplementProcedure::where('year','=',Util::datePickYear($request->year))->where('semester','=',$request->semester)->first();
        if ($exists) {
          return redirect('economic_complement_procedure')
          ->withErrors("Error en los datos")
          ->withInput();
        }else{
            if ($eco_com_pro_id) {
                $message = "Rango de fechas Actualizado";
                $eco_com_pro = EconomicComplementProcedure::find($eco_com_pro_id);
            }else{
                $message = "Rango de Fechas Creado con éxito";
                $eco_com_pro = new EconomicComplementProcedure();
            }
            $eco_com_pro->year = Util::datePickYear($request->year);
            $eco_com_pro->user_id = Auth::user()->id;
            $eco_com_pro->semester = $request->semester;
            $eco_com_pro->normal_start_date = Util::datePick($request->normal_start_date);
            $eco_com_pro->normal_end_date = Util::datePick($request->normal_end_date);
            $eco_com_pro->lagging_start_date = Util::datePick($request->lagging_start_date);
            $eco_com_pro->lagging_end_date = Util::datePick($request->lagging_end_date);
            $eco_com_pro->additional_start_date = Util::datePick($request->additional_start_date);
            $eco_com_pro->additional_end_date = Util::datePick($request->additional_end_date);
            $eco_com_pro->save();
            Session::flash('message', $message);
            return redirect('economic_complement_procedure');
        }
    }
    public function store(Request $request)
    {
        if ($request->economic_complement_procedure_id) {
            return $this->save($request, $request->economic_complement_procedure_id);
        }else{
            return $this->save($request, null);
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
        $procedure=EconomicComplementProcedure::find($id);
        $procedure->normal_start_date=Carbon::parse($procedure->normal_start_date)->format('d/m/Y');
        $procedure->normal_end_date=Carbon::parse($procedure->normal_end_date)->format('d/m/Y');
        $procedure->lagging_start_date = Carbon::parse($procedure->lagging_start_date)->format('d/m/Y');
        $procedure->lagging_end_date = Carbon::parse($procedure->lagging_end_date)->format('d/m/Y');
        $procedure->additional_start_date = Carbon::parse($procedure->additional_start_date)->format('d/m/Y');
        $procedure->additional_end_date = Carbon::parse($procedure->additional_end_date)->format('d/m/Y');
        $procedure->year = Carbon::parse($procedure->year)->year;
        return $procedure;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        
    }
    public function deleteProcedure(Request $request)
    {   
        $exists_eco_coms=EconomicComplementProcedure::find($request->economic_complement_procedure_id);
        if (!$exists_eco_coms->economic_complements->first()) {
            $exists_eco_coms->delete();
        }else{
            return redirect('economic_complement_procedure')
              ->withErrors("No puede Eliminar el Procedimiento porque existen datos.")
              ->withInput();
        }
        Session::flash('message', 'Procedimiento Eliminado con exito');
        return redirect('economic_complement_procedure');
    }
}
