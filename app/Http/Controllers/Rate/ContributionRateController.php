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

use Muserpol\ContributionRate;

class ContributionRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $last_contribution_rate = ContributionRate::orderBy('month_year', 'desc')->first();

        $data = [

            'last_contribution_rate' => $last_contribution_rate,
            'month_year' => Util::getfullmonthYear($last_contribution_rate->month_year)

        ];

        return view('contribution_rates.index', $data);
    }

    public function Data()
    {
        $contribution_rates = ContributionRate::select(['month_year', 'rate_active', 'retirement_fund', 'mortuary_quota', 'mortuary_aid']);

        return Datatables::of($contribution_rates)
            ->addColumn('year', function ($contribution_rate) { return Carbon::parse($contribution_rate->month_year)->year; })
            ->addColumn('month', function ($contribution_rate) { return Util::getMes(Carbon::parse($contribution_rate->month_year)->month); })
            ->editColumn('retirement_fund', function ($contribution_rate) { return Util::formatMoney($contribution_rate->retirement_fund); })
            ->editColumn('mortuary_quota', function ($contribution_rate) { return Util::formatMoney($contribution_rate->mortuary_quota); })
            ->editColumn('rate_active', function ($contribution_rate) { return Util::formatMoney($contribution_rate->rate_active); })
            ->editColumn('mortuary_aid', function ($contribution_rate) { return Util::formatMoney($contribution_rate->mortuary_aid); })
            ->addColumn('rate_passive', function ($contribution_rate) { return Util::formatMoney($contribution_rate->mortuary_aid); })
            ->make(true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $contribution_rate)
    {
        if (Auth::user()->can('manage')) {

            return $this->save($request, $contribution_rate);

        }else{

            return redirect('/');
        }
    }

    public function save($request, $contribution_rate  = false)
    {
        $rules = [

            'retirement_fund' => 'required|numeric',
            'mortuary_quota' => 'required|numeric',
            'mortuary_aid' => 'required|numeric'

        ];

        $messages = [

            'retirement_fund.required' => 'El campo Fondo de Retiro Sector Activo no puede ser vacío', 
            'retirement_fund.numeric' => 'El campo Fondo de Retiro Sector Activo sólo se aceptan números',

            'mortuary_quota.required' => 'El campo Seguro de Vida Sector Activo no puede ser vacío', 
            'mortuary_quota.numeric' => 'El campo Seguro de Vida Sector Activo sólo se aceptan números',

            'mortuary_aid.required' => 'El campo Seguro de Vida Sector Pasivo no puede ser vacío', 
            'mortuary_aid.numeric' => 'El campo Seguro de Vida Sector Pasivo sólo se aceptan números',

        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {

            return redirect('contribution_rate/'.$contribution_rate.'/edit')
            ->withErrors($validator)
            ->withInput();
        }
        else{

            $contribution_rate->user_id = Auth::user()->id;                 
            $contribution_rate->retirement_fund = trim($request->retirement_fund);
            $contribution_rate->mortuary_quota = trim($request->mortuary_quota);
            $contribution_rate->rate_active = trim($request->retirement_fund) + trim($request->mortuary_quota);
            $contribution_rate->mortuary_aid = trim($request->mortuary_aid);
            $contribution_rate->save();

            $message = "Tasa de Aporte Actualizado con éxito";

            Session::flash('message', $message);
        }
        
        return redirect('contribution_rate');
    }
}
