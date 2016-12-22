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

use Muserpol\EconomicComplementFactor;
use Muserpol\Hierarchy;

class ComplementarityFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('complementarity_factor.index');
    }

    public function Data()
    {
        $select = DB::raw('complementarity_factors.year as year, complementarity_factors.semester as semester, cf1.old_age as cf1, cf2.old_age as cf2, cf3.old_age as cf3, cf4.old_age as cf4, cf5.old_age as cf5');

        $complementarity_factors = DB::table('complementarity_factors')->select($select)
        ->leftJoin('complementarity_factors as cf1', 'cf1.year', '=', 'complementarity_factors.year')
        ->leftJoin('complementarity_factors as cf2', 'cf2.year', '=', 'complementarity_factors.year')
        ->leftJoin('complementarity_factors as cf3', 'cf3.year', '=', 'complementarity_factors.year')
        ->leftJoin('complementarity_factors as cf4', 'cf4.year', '=', 'complementarity_factors.year')
        ->leftJoin('complementarity_factors as cf5', 'cf5.year', '=', 'complementarity_factors.year')

        ->where('cf1.hierarchy_id', '=', '1')
        ->where('cf2.hierarchy_id', '=', '2')
        ->where('cf3.hierarchy_id', '=', '3')
        ->where('cf4.hierarchy_id', '=', '4')
        ->where('cf5.hierarchy_id', '=', '5')

        ->groupBy('complementarity_factors.year', 'complementarity_factors.semester');

        return Datatables::of($complementarity_factors)
        ->editColumn('year', function ($complementarity_factor) { return Carbon::parse($complementarity_factor->year)->year; })
        ->editColumn('semester', function ($complementarity_factor) { return $complementarity_factor->semester; })
        ->editColumn('cf1', function ($complementarity_factor) { return Util::formatMoney($complementarity_factor->cf1); })
        ->editColumn('cf2', function ($complementarity_factor) { return Util::formatMoney($complementarity_factor->cf2); })
        ->editColumn('cf3', function ($complementarity_factor) { return Util::formatMoney($complementarity_factor->cf3); })
        ->editColumn('cf4', function ($complementarity_factor) { return Util::formatMoney($complementarity_factor->cf4); })
        ->editColumn('cf5', function ($complementarity_factor) { return Util::formatMoney($complementarity_factor->cf5); })

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
