<?php

namespace Muserpol\Http\Controllers\Inbox;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Muserpol\Affiliate;
use Datatables;
use Util;
class InboxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('inbox.view');
    }
    public function DataReceived()
    {
        $Affiliate=Affiliate::all();
        $data=[];
        foreach ($Affiliate as $a) {
            $o=[];
            array_push($o,$a->id);
            array_push($o,$a->nua);
            array_push($o,$a->type);
            array_push($o,$a->gender);
            array_push($o,$a->date_entry);
            array_push($o,$a->last_name);
            array_push($data,$o );
        }
       //dd($data);
       return ["data"=>$data];
    }
    public function DataEdited()
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
        foreach ($request->edited as $v) {
            echo(Affiliate::find($v)->last_name);
            echo "<br>";
        }
        return; 
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
