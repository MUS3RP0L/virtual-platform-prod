<?php

namespace Muserpol\Http\Controllers\Affiliate;

use Illuminate\Http\Request;
use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use Auth;
use Validator;
use Session;
use Muserpol\Helper\Util;

use Muserpol\Affiliate;
use Muserpol\AffiliateAddress;

class AffiliateAddressController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->save($request, $id);
    }

    public function save($request, $id = false)
    {
        $rules = [

            'city_address_id' => 'required',

        ];

        $messages = [

            'city_address_id.required' => 'El Campo es Requerido',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('affiliate/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        else {

            $AffiliateAddress = AffiliateAddress::affiliateidIs($id)->first();

            if (!$AffiliateAddress) { $AffiliateAddress = new AffiliateAddress; }

            $AffiliateAddress->user_id = Auth::user()->id;
            $AffiliateAddress->affiliate_id = $id;

            if ($request->city_address_id) { $AffiliateAddress->city_address_id = $request->city_address_id; } else { $AffiliateAddress->city_address_id = null; }
            $AffiliateAddress->zone = trim($request->zone);
            $AffiliateAddress->street = trim($request->street);
            $AffiliateAddress->number_address = trim($request->number_address);
            $AffiliateAddress->save();

            $message = "Información de domicilio de afiliado actualizado con éxito";

            Session::flash('message', $message);
        }

        return redirect('affiliate/'.$id);
    }
}
