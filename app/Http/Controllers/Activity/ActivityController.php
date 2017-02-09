<?php

namespace Muserpol\Http\Controllers\Activity;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;
use Muserpol\User;
use Muserpol\Activity;
use DB;


class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
            return view('activities.index');
    }

    public function Data(Request $request)
    {
        $activities = Activity::select(['created_at','message', 'activity_type_id', 'user_id'])->where('user_id', '=', Auth::user()->id);
        if ($request->has('from') && $request->has('to'))
        {   $activities->where(function($activities) use ($request)
            {   $from = Util::datePick($request->get('from'));
                $to = Util::datePick($request->get('to'));
                $activities->whereDate('created_at','>=', $from)->whereDate('created_at','<=', $to);
            });
        }

        return Datatables::of($activities)
                ->addColumn('created_at', function ($activities) { return $activities->created_at; })
                ->editColumn('message', function ($activities) { return $activities->message; })
                ->editColumn('user_id', function ($activities) { return Auth::user()->username; })
                ->addColumn('activity_type_id', function ($activities) { return $activities->activity_type_id; })
                ->make(true);
    }

    public function print_activity(Request $request) {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $title = "REGISTROS DE ACTIVIDATES DEL USUARIO";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        //return response()->json($request->from);
        //dd($request->all());
        if($request->has('from') && $request->has('to')) {
            $from = Util::datePick($from);
            $to = Util::datePick($from);
            $activities = Activity::select(['created_at','message', 'activity_type_id', 'user_id'])->where('user_id', '=', Auth::user()->id)->whereDate('created_at','>=', $from)->whereDate('created_at','<=', $to)->orderBy('created_at')->get();

        }
        elseif($request->has('btn1')) {
            $activities = Activity::select(['created_at','message', 'activity_type_id', 'user_id'])->where('user_id', '=', Auth::user()->id)->whereDate('created_at','=', date('Y-m-d'))->orderBy('created_at')->get();
        }
        else {
            $activities = Activity::select(['created_at','message', 'activity_type_id', 'user_id'])->where('user_id', '=', Auth::user()->id)->orderBy('created_at')->get();
        }
        //return response()->json($activities);
        $view = \View::make('activities.print.show', compact('header1','header2','title','date','hour','activities'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('letter');
        return $pdf->download('Reporte_Actividades.pdf');
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
        //
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
