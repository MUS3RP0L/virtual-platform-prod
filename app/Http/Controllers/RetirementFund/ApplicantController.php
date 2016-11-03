<?php

namespace Muserpol\Http\Controllers\RetirementFund;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;

use DB;
use Auth;
use Validator;
use Session;
use Datatables;
use Carbon\Carbon;
use Muserpol\Helper\Util;

use Muserpol\Affiliate;
use Muserpol\Applicant;
use Muserpol\ApplicantType;
use Muserpol\RetirementFund;

class ApplicantController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $retirement_fund_id)
    {
        return $this->save($request, $retirement_fund_id);
    }

    public function save($request, $retirement_fund_id = false)
    {
        $rules = [

            'identity_card' => 'min:4',
            'last_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'first_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            'home_phone_number' =>'numeric',
            'home_cell_phone_number' =>'numeric',
        ];

        $messages = [

            'identity_card.min' => 'El mínimo de caracteres permitidos para Carnet de Identidad es 4',
            'last_name.min' => 'El mínimo de caracteres permitidos para apellido paterno es 3',
            'last_name.regex' => 'Sólo se aceptan letras para apellido paterno',
            'first_name.min' => 'El mínimo de caracteres permitidos para nombres es 3',
            'first_name.regex' => 'Sólo se aceptan letras para primer nombre',
            'home_phone_number.numeric' => 'Sólo se aceptan números para teléfono',
            'home_cell_phone_number.numeric' => 'Sólo se aceptan números para celular',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
            return redirect('retirement_fund/' . $retirement_fund_id)
            ->withErrors($validator)
            ->withInput();
        }
        else{

            $RetirementFund = RetirementFund::afiIs($retirement_fund_id)->where('deleted_at', '=', null)->orderBy('id', 'desc')->first();
            $applicant = Applicant::retirementFundIs($RetirementFund->id)->orderBy('id', 'asc')->first();

            if (!$applicant) {
                $applicant = new Applicant;
            }

            $applicant_type = ApplicantType::where('id', '=', $request->type_applicant)->first();
            $applicant->applicant_type_id = $applicant_type->id;
            $applicant->retirement_fund_id = $RetirementFund->id;
            $applicant->identity_card = trim($request->identity_card);
            $applicant->last_name = trim($request->last_name);
            $applicant->mothers_last_name = trim($request->mothers_last_name);
            $applicant->first_name = trim($request->first_name);
            $applicant->kinship = trim($request->kinship);
            $applicant->home_address = trim($request->home_address);
            $applicant->home_phone_number = trim($request->home_phone_number);
            $applicant->home_cell_phone_number = trim($request->home_cell_phone_number);
            $applicant->work_address = trim($request->work_address);

            $applicant->save();

            $message = "Información de Solicitante actualizada con éxito";

            }
            Session::flash('message', $message);

        return redirect('retirement_fund/' . $retirement_fund_id);
    }

}
