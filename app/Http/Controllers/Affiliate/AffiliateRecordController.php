<?php

namespace Muserpol\Http\Controllers\Affiliate;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Datatables;

use Muserpol\AffiliateRecord;

class AffiliateRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function Data(Request $request)
    {   
        $records = AffiliateRecord::select(['date', 'message'])->where('affiliate_id', $request->id);
        
        return Datatables::of($records)->editColumn('date', function ($record) { return $record->getAllDate(); })->make(true);
    }
}
