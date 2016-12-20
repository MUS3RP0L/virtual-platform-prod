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
        $select = DB::raw('eco_com_factors.year as year, c1.old_age as c1, c2.old_age as c2, c3.old_age as c3');

        $eco_com_factors = DB::table('eco_com_factors')->select($select)
        ->leftJoin('eco_com_factors as c1', 'c1.year', '=', 'eco_com_factors.year')
        ->leftJoin('eco_com_factors as c2', 'c2.year', '=', 'eco_com_factors.year')
        ->leftJoin('eco_com_factors as c3', 'c3.year', '=', 'eco_com_factors.year')

        ->where('c1.hierarchy_id', '=', '1')
        ->where('c2.hierarchy_id', '=', '2')
        ->where('c3.hierarchy_id', '=', '3')

        ->groupBy('eco_com_factors.year');

        return Datatables::of($eco_com_factors)
        ->editColumn('year', function ($eco_com_factor) { return Carbon::parse($eco_com_factor->year)->year; })
        ->editColumn('c1', function ($eco_com_factor) { return Util::formatMoney($eco_com_factor->c1); })
        ->editColumn('c2', function ($eco_com_factor) { return Util::formatMoney($eco_com_factor->c2); })
        ->editColumn('c3', function ($eco_com_factor) { return Util::formatMoney($eco_com_factor->c3); })

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
