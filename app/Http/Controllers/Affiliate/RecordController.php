<?php

namespace Muserpol\Http\Controllers\Affiliate;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Datatables;

use Muserpol\Record;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function Data(Request $request)
    {   
        $records = Record::select(['date', 'message'])->where('affiliate_id', $request->id);
        
        return Datatables::of($records)->editColumn('date', function ($record) { return $record->getAllDate(); })->make(true);
    }
}
