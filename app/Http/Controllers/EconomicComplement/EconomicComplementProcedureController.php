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
            ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $year=Carbon::now()->year;
        return view('economic_complements.procedure.create',['year'=>$year]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save($request, $eco_com_pro=false)
    {
       
            $eco_com_pro = EconomicComplementProcedure::where('year','=',Util::datePickYear(Carbon::now()->year))->where('semester','=',Util::getCurrentSemester())->first();
            if ($eco_com_pro) {
                $message = "Rango de fechas Actualizado";
            }else {
                $eco_com_pro = new EconomicComplementProcedure();
                $message = "Rango de Fechas Creado con éxito";
            }
            $eco_com_pro->year = Util::datePickYear(Carbon::now()->year);
            $eco_com_pro->user_id = Auth::user()->id;
            $eco_com_pro->semester = Util::getCurrentSemester();
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
    public function store(Request $request)
    {
        return $this->save($request);
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
