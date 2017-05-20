<?php

namespace Muserpol\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;
use Muserpol\PDF;

class PdfController extends Controller
{

    public function debtor()
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $data = $this->getData();
        $date = Util::getDateEdit(date('d." sss"-m-Y'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $invoice = "2222";
        $view =  \View::make('debtor', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal');
        return $pdf->stream();
       // return $pdf->download('invoice');
    }

    public function getData()
    {
        $data =  [
            'quantity'=>'1' ,
            'description'=>'some ramdom text',
            'price'=> '500',
            'total'=> '500'
        ];
        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
