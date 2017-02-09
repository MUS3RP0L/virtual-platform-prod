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
        $activities = Activity::select(['created_at','message', 'activity_type_id', 'user_id']);

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
                ->addColumn('activity_type_id', function ($activities) { return $activities->activity_type_id; })
                ->editColumn('user_id', function ($activities) { return Auth::user()->username; })
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
