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
use Muserpol\Spouse;
use Muserpol\City;

class SpouseController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
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
            'identity_card' => 'required',
            'city_identity_card_id' => 'required',
            // 'last_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'mothers_last_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'first_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'second_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i'

        ];

        $messages = [
            'identity_card.required' => 'El Campo es Requerido',
            'city_identity_card_id.required' => 'El Campo es Requerido',
            // 'last_name.min' => 'El mínimo de caracteres permitidos para apellido paterno es 3',
            // 'last_name.regex' => 'Sólo se aceptan letras para apellido paterno',

            // 'mothers_last_name.min' => 'El mínimo de caracteres permitidos para apellido materno es 3',
            // 'mothers_last_name.regex' => 'Sólo se aceptan letras para apellido materno',

            // 'first_name.min' => 'El mínimo de caracteres permitidos para primer nombre es 3',
            // 'first_name.regex' => 'Sólo se aceptan letras para primer nombre',

            // 'second_name.min' => 'El mínimo de caracteres permitidos para segundo nombre es 3',
            // 'second_name.regex' => 'Sólo se aceptan letras para segundo nombre'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('affiliate/'.$id)
            ->withErrors($validator)
            ->withInput();
        }
        else {

            $spouse = Spouse::affiliateidIs($id)->first();

            if (!$spouse) { $spouse = new Spouse; }

            $spouse->user_id = Auth::user()->id;
            $spouse->affiliate_id = $id;
            $spouse->identity_card = trim($request->identity_card);
            if ($request->city_identity_card_id) { $spouse->city_identity_card_id = $request->city_identity_card_id; } else { $spouse->city_identity_card_id = null; }
            $spouse->last_name = trim($request->last_name);
            $spouse->mothers_last_name = trim($request->mothers_last_name);
            $spouse->surname_husband = trim($request->surname_husband);
            $spouse->first_name = trim($request->first_name);
            $spouse->second_name = trim($request->second_name);
            $spouse->birth_date = Util::datePick($request->birth_date);
            $spouse->registration=Util::CalcRegistration(Util::datePick($request->birth_date),trim($request->last_name),trim($request->mothers_last_name), trim($request->first_name),Util::getGender(Affiliate::find($id)->first()->gender));
            if ($request->DateDeathSpouseCheck == "on") {
                $spouse->date_death = Util::datePick($request->date_death);
                $spouse->reason_death = trim($request->reason_death);
            }else {
                $spouse->date_death = null;
                $spouse->reason_death = null;
            }
            $spouse->save();

            $message = "Información de Conyuge actualizado con éxito";

            Session::flash('message', $message);
        }

        return redirect('affiliate/'.$id);
    }

}
