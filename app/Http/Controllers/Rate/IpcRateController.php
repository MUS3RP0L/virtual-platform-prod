<?php

namespace Muserpol\Http\Controllers\Rate;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\IpcRate;

class IpcRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $last_ipc_rate = IpcRate::orderBy('month_year', 'desc')->first();

        $data = [

            'last_ipc_rate' => $last_ipc_rate,
            'months' => Util::getArrayMonths()

        ];

        return view('ipc_rate.index', $data);
    }

    public function Data()
    {
        $ipc_rates = IpcRate::select(['month_year', 'index']);

        return Datatables::of($ipc_rates)
                ->editColumn('year', function ($ipc_rate) { return Carbon::parse($ipc_rate->month_year)->year; })
                ->addColumn('month', function ($ipc_rate) { return Util::getMes(Carbon::parse($ipc_rate->month_year)->month); })
                ->editColumn('index', function ($ipc_rate) { return Util::formatMoney($ipc_rate->index); })
                ->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $ipc_rate)
    {
        return $this->save($request, $ipc_rate);
    }

    public function save($request, $ipc_rate = false)
    {
        $rules = [

            'month_year' => 'required',
            'index' => 'required|numeric'
        ];

        $messages = [

            'month_year.required' => 'El campo Año no puede ser vacío', 

            'index.required' => 'El campo IPC no puede ser vacío', 
            'index.numeric' => 'El campo IPC sólo se aceptan números'

        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return redirect('ipc_rate')
            ->withErrors($validator)
            ->withInput();
        }
        else{

            $ipcTasa = IpcRate::where('month_year', '=', Util::datePickPeriod($request->month_year))->first();

            if ($ipcTasa) {

                $ipcTasa->user_id = Auth::user()->id;
                $ipcTasa->index = trim($request->index);
                $ipcTasa->save();

                $message = "Índice de Precios al Consumidor actualizado con éxito";

                Session::flash('message', $message);

            }
            else {

                $message = "Fecha no disponible";

                Session::flash('message', $message);
            }

        }
        
        return redirect('ipc_rate');
    }

}
