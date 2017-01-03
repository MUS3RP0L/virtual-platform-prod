<?php

namespace Muserpol\Http\Controllers\EconomicComplement;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementState;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementModality;

class EconomicComplementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $eco_com_states = EconomicComplementState::all();
        $eco_com_states_list =  ['' => ''];
        foreach ($eco_com_states as $item) {
            $eco_com_states_list[$item->id]=$item->name;
        }

        $eco_com_types = EconomicComplementType::all();
        $list_eco_com_types = array('' => '');
        foreach ($eco_com_types as $item) {
            $list_eco_com_types[$item->id]=$item->name;
        }

        $data = [
            'eco_com_states_list' => $eco_com_states_list,
            'list_eco_com_types' => $list_eco_com_types
        ];

        return view('economic_complement.index', $data);
    }

    public function getEconomicComplementType(Request $request, $id)
    {
        if($request->ajax())
        {
            $modalities = EconomicComplementModality::typeidIs($id)->get();
            return response()->json($modalities);
        }
    }

    public function Data(Request $request)
    {
        $economic_complements = EconomicComplement::select(['id', 'affiliate_id', 'eco_com_modality_id', 'eco_com_state_id', 'code', 'created_at', 'total']);

        if ($request->has('code'))
        {
            $economic_complements->where(function($economic_complements) use ($request)
            {
                $code = trim($request->get('code'));
                $economic_complements->where('code', 'like', "%{$code}%");
            });
        }
        if ($request->has('affiliate_identitycard'))
        {
            $economic_complements->where(function($economic_complements) use ($request)
            {
                $affiliate_identitycard = trim($request->get('affiliate_identitycard'));

                $affiliate = Affiliate::identitycardIs($affiliate_identitycard)->first();

                $economic_complements->where('affiliate_id', 'like', "%{$affiliate->id}%");
            });
        }
        if ($request->has('creation_date'))
        {
            $economic_complements->where(function($economic_complements) use ($request)
            {
                $creation_date = Util::datePick($request->get('creation_date'));
                $economic_complements->where('created_at', 'like', "%{$creation_date}%");
            });
        }
        if ($request->has('eco_com_state'))
        {
            $economic_complements->where(function($economic_complements) use ($request)
            {
                $voucher_type = trim($request->get('voucher_type'));
                $economic_complements->where('voucher_type_id', 'like', "%{$voucher_type}%");
            });
        }
        if ($request->has('payment_date'))
        {
            $economic_complements->where(function($economic_complements) use ($request)
            {
                $payment_date = Util::datePick($request->get('payment_date'));
                $economic_complements->where('payment_date', 'like', "%{$payment_date}%");
            });
        }

        return Datatables::of($economic_complements)
                ->addColumn('affiliate_name', function ($voucher) { return $voucher->affiliate->getTittleName(); })
                ->editColumn('voucher_type', function ($voucher) { return $voucher->voucher_type->name; })
                ->addColumn('total', function ($voucher) { return Util::formatMoney($voucher->total); })
                ->editColumn('created_at', function ($voucher) { return $voucher->getCreationDate(); })
                ->addColumn('status', function ($voucher) { return $voucher->payment_date ? 'Pagado' : 'Pendiente'; })
                ->editColumn('payment_date', function ($voucher) { return $voucher->payment_date ? Util::getDateShort($voucher->payment_date) : '-'; })
                ->addColumn('action', function ($voucher) { return
                    '<div class="btn-group" style="margin:-3px 0;">
                        <a href="voucher/'.$voucher->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                        <a href="" class="btn btn-primary btn-raised btn-sm dropdown-toggle" data-toggle="dropdown">&nbsp;<span class="caret"></span>&nbsp;</a>
                        <ul class="dropdown-menu">
                            <li><a href="voucher/delete/ '.$voucher->id.' " style="padding:3px 10px;"><i class="glyphicon glyphicon-ban-circle"></i> Anular</a></li>
                        </ul>
                    </div>';})
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
