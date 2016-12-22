<?php

namespace Muserpol\Http\Controllers\EconomicComplement;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Auth;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\ComplementaryFactor;
use Muserpol\Hierarchy;

class ComplementaryFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $year = Util::getYear(new Carbon());
        $semester = Util::getSemester(new Carbon());
        return ComplementaryFactor::where('year', '2016')->first();
        // if () {
        //     return "hola";
        // }else{
        //     return "chau";
        // }
        // $complementary_factor = ;
        //
        // $data = [
        //
        //     'complementary_factor' => $complementary_factor,
        //     'semester' =>
        //
        // ];
        //
        // return view('complementary_factor.index', $data);

    }

    public function old_ageData()
    {
        $select = DB::raw('complementary_factors.year as year, complementary_factors.semester as semester, cf1.old_age as cf1, cf2.old_age as cf2, cf3.old_age as cf3, cf4.old_age as cf4, cf5.old_age as cf5');

        $complementary_factors = DB::table('complementary_factors')->select($select)
        ->leftJoin('complementary_factors as cf1', 'cf1.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf2', 'cf2.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf3', 'cf3.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf4', 'cf4.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf5', 'cf5.year', '=', 'complementary_factors.year')

        ->where('cf1.hierarchy_id', '=', '1')
        ->where('cf2.hierarchy_id', '=', '2')
        ->where('cf3.hierarchy_id', '=', '3')
        ->where('cf4.hierarchy_id', '=', '4')
        ->where('cf5.hierarchy_id', '=', '5')

        ->groupBy('complementary_factors.year', 'complementary_factors.semester');

        return Datatables::of($complementary_factors)
        ->editColumn('year', function ($complementary_factor) { return Carbon::parse($complementary_factor->year)->year; })
        ->editColumn('semester', function ($complementary_factor) { return $complementary_factor->semester; })
        ->editColumn('cf1', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf1); })
        ->editColumn('cf2', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf2); })
        ->editColumn('cf3', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf3); })
        ->editColumn('cf4', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf4); })
        ->editColumn('cf5', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf5); })

        ->make(true);
    }


    public function widowhoodData()
    {
        $select = DB::raw('complementary_factors.year as year, complementary_factors.semester as semester, cf1.widowhood as cf1, cf2.widowhood as cf2, cf3.widowhood as cf3, cf4.widowhood as cf4, cf5.widowhood as cf5');

        $complementary_factors = DB::table('complementary_factors')->select($select)
        ->leftJoin('complementary_factors as cf1', 'cf1.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf2', 'cf2.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf3', 'cf3.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf4', 'cf4.year', '=', 'complementary_factors.year')
        ->leftJoin('complementary_factors as cf5', 'cf5.year', '=', 'complementary_factors.year')

        ->where('cf1.hierarchy_id', '=', '1')
        ->where('cf2.hierarchy_id', '=', '2')
        ->where('cf3.hierarchy_id', '=', '3')
        ->where('cf4.hierarchy_id', '=', '4')
        ->where('cf5.hierarchy_id', '=', '5')

        ->groupBy('complementary_factors.year', 'complementary_factors.semester');

        return Datatables::of($complementary_factors)
        ->editColumn('year', function ($complementary_factor) { return Carbon::parse($complementary_factor->year)->year; })
        ->editColumn('semester', function ($complementary_factor) { return $complementary_factor->semester; })
        ->editColumn('cf1', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf1); })
        ->editColumn('cf2', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf2); })
        ->editColumn('cf3', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf3); })
        ->editColumn('cf4', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf4); })
        ->editColumn('cf5', function ($complementary_factor) { return Util::formatMoney($complementary_factor->cf5); })

        ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        return $this->save($request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $complementary_factor)
    {
        if (Auth::user()->can('manage')) {

            return $this->save($request, $complementary_factor);

        }else{

            return redirect('/');
        }
    }

    public function save($request, $complementary_factor  = false)
    {
        $rules = [

            'cf1_old_age' => 'required|numeric',
            'cf1_widowhood' => 'required|numeric',
            'cf2_old_age' => 'required|numeric',
            'cf2_widowhood' => 'required|numeric',
            'cf3_old_age' => 'required|numeric',
            'cf3_widowhood' => 'required|numeric',
            'cf4_old_age' => 'required|numeric',
            'cf4_widowhood' => 'required|numeric',
            'cf5_old_age' => 'required|numeric',
            'cf5_widowhood' => 'required|numeric'

        ];

        $messages = [

            'cf1_old_age.required' => 'El campo no puede ser vacío',
            'cf1_old_age.numeric' => 'El campo sólo se aceptan números',
            'cf1_widowhood.required' => 'El campo no puede ser vacío',
            'cf1_widowhood.numeric' => 'El campo sólo se aceptan números',

            'cf2_old_age.required' => 'El campo no puede ser vacío',
            'cf2_old_age.numeric' => 'El campo sólo se aceptan números',
            'cf2_widowhood.required' => 'El campo no puede ser vacío',
            'cf2_widowhood.numeric' => 'El campo sólo se aceptan números',

            'cf3_old_age.required' => 'El campo no puede ser vacío',
            'cf3_old_age.numeric' => 'El campo sólo se aceptan números',
            'cf3_widowhood.required' => 'El campo no puede ser vacío',
            'cf3_widowhood.numeric' => 'El campo sólo se aceptan números',

            'cf4_old_age.required' => 'El campo no puede ser vacío',
            'cf4_old_age.numeric' => 'El campo sólo se aceptan números',
            'cf4_widowhood.required' => 'El campo no puede ser vacío',
            'cf4_widowhood.numeric' => 'El campo sólo se aceptan números',

            'cf5_old_age.required' => 'El campo no puede ser vacío',
            'cf5_old_age.numeric' => 'El campo sólo se aceptan números',
            'cf5_widowhood.required' => 'El campo no puede ser vacío',
            'cf5_widowhood.numeric' => 'El campo sólo se aceptan números'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            return redirect('complementary_factor')
            ->withErrors($validator)
            ->withInput();
        }
        else{

            // $complementary_factor = ComplementaryFactor::where('year', '=', Util::datePickPeriod($request->month_year))->first();

            if ($complementary_factor) {

                $message = "Factores de Complementación actualizados con éxito";

            }else {

                $complementary_factor = new ComplementaryFactor();
                $message = "Factores de Complementación creados con éxito";
            }

            $complementary_factor->user_id = Auth::user()->id;
            $complementary_factor->hierarchy_id = trim($request->hierarchy_id);
            $complementary_factor->semester = trim($request->semester);
            $complementary_factor->old_age = trim($request->old_age);
            $complementary_factor->widowhood = trim($request->widowhood);
            $complementary_factor->save();



            Session::flash('message', $message);
        }

        return redirect('complementary_factor');
    }
}
