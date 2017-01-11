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
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementApplicantType;
use Muserpol\Affiliate;
use Muserpol\City;

class EconomicComplementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('economic_complements.index', self::getViewModel());
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
        if ($request->has('creation_date'))
        {
            $economic_complements->where(function($economic_complements) use ($request)
            {
                $creation_date = Util::datePick($request->get('creation_date'));
                $economic_complements->where('created_at', 'like', "%{$creation_date}%");
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
        if ($request->has('eco_com_state_id'))
        {
            $economic_complements->where(function($economic_complements) use ($request)
            {
                $eco_com_state_id = trim($request->get('eco_com_state_id'));
                $economic_complements->where('eco_com_state_id', 'like', "%{$eco_com_state_id}%");
            });
        }
        if ($request->has('eco_com_modality_id'))
        {
            $economic_complements->where(function($economic_complements) use ($request)
            {
                $eco_com_modality_id = trim($request->get('eco_com_modality_id'));
                $economic_complements->where('eco_com_state_id', 'like', "%{$eco_com_modality_id}%");
            });
        }
        return Datatables::of($economic_complements)
                ->addColumn('affiliate_identitycard', function ($economic_complement) { return $economic_complement->affiliate->identity_card; })
                ->addColumn('affiliate_name', function ($economic_complement) { return $economic_complement->affiliate->getTittleName(); })
                ->editColumn('created_at', function ($economic_complement) { return $economic_complement->getCreationDate(); })
                ->editColumn('eco_com_state', function ($economic_complement) { return $economic_complement->economic_complement_state->name; })
                ->editColumn('eco_com_modality', function ($economic_complement) { return $economic_complement->economic_complement_modality->name; })
                ->addColumn('action', function ($economic_complement) { return
                    '<div class="btn-group" style="margin:-3px 0;">
                        <a href="economic_complement/'.$economic_complement->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
                        <a href="" class="btn btn-primary btn-raised btn-sm dropdown-toggle" data-toggle="dropdown">&nbsp;<span class="caret"></span>&nbsp;</a>
                        <ul class="dropdown-menu">
                            <li><a href="voucher/delete/ '.$economic_complement->id.' " style="padding:3px 10px;"><i class="glyphicon glyphicon-ban-circle"></i> Anular</a></li>
                        </ul>
                    </div>';})
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static function getViewModel()
    {
        $eco_com_states = EconomicComplementState::all();
        $eco_com_states_list =  ['' => ''];
        foreach ($eco_com_states as $item) {
            $eco_com_states_list[$item->id]=$item->name;
        }

        $eco_com_types = EconomicComplementType::all();
        $eco_com_types_list = array('' => '');
        foreach ($eco_com_types as $item) {
            $eco_com_types_list[$item->id]=$item->name;
        }

        $cities = City::all();
        $cities_list = array('' => '');
        foreach ($cities as $item) {
             $cities_list[$item->id]=$item->name;
        }

        $cities_list_short = ['' => ''];
        foreach ($cities as $item) {
            $cities_list_short[$item->id]=$item->shortened;
        }

        $semestre = ['F' => 'Primer', 'S' => 'Segundo'];
        foreach ($semestre as $item) {
            $semester_list[$item]=$item;
        }

        $semester = Util::getSemester(Carbon::now());

        return [

            'eco_com_states_list' => $eco_com_states_list,
            'eco_com_types_list' => $eco_com_types_list,
            'semester_list' => $semester_list,
            'cities_list' => $cities_list,
            'cities_list_short' => $cities_list_short,
            'year' => Carbon::now()->year,
            'semester' => $semester

        ];
    }

    public function getData($affiliate_id)
    {
        $affiliate = Affiliate::idIs($affiliate_id)->first();

        $data = [

           'affiliate' => $affiliate

        ];

        return array_merge($data, self::getViewModel());

    }

    public function ReceptionFirstStep($affiliate_id)
    {
        $eco_com_type = false;
        $economic_complement = new EconomicComplement;

        $data = [

           'eco_com_type' => $eco_com_type,
           'economic_complement' => $economic_complement

        ];

        $data = array_merge($data, self::getData($affiliate_id));
        $data = array_merge($data, self::getViewModel());

        return view('economic_complements.reception_first_step', $data);
    }

    public function ReceptionSecondStep($affiliate_id)
    {
        $data = self::getViewModel();
        $economic_complement = EconomicComplement::affiliateIs($affiliate_id)
                                ->whereYear('created_at', '=', $data['year'])
                                ->where('semester', '=', $data['semester'])->first();

        $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();


        $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type;

        $eco_com_applicant_type = EconomicComplementApplicantType::idIs($eco_com_type->id)->first();

        if ($eco_com_applicant->gender == 'M') {
            $gender_list = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];
        }elseif ($eco_com_applicant->gender == 'F') {
            $gender_list = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];
        }

        $data = [

            'eco_com_type' => $eco_com_type->name,
            'eco_com_applicant_type' => $eco_com_applicant_type,
            'economic_complement' => $economic_complement,
            'eco_com_applicant' => $eco_com_applicant,
            'gender_list' => $gender_list

        ];

        $data = array_merge($data, self::getData($affiliate_id));
        $data = array_merge($data, self::getViewModel());

        return view('economic_complements.reception_second_step', $data);
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

    public function update(Request $request, $affiliate_id)
    {
        return $this->save($request, $affiliate_id);
    }

    public function save($request, $affiliate_id = false)
    {

        switch ($request->step) {

            case 'first':

                $rules = [
                    'eco_com_type' => 'required',
                    'city' => 'required',
                ];

                $messages = [

                    'eco_com_type.required' => 'El campo Tipo de Trámite es requerido',
                    'city.required' => 'El campo Ciudad es requerido',

                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()){
                    return redirect('economic_complement_reception_first_step/'.$affiliate_id)
                    ->withErrors($validator)
                    ->withInput();
                }
                else{

                    $data = self::getViewModel();
                    $economic_complement = EconomicComplement::affiliateIs($affiliate_id)
                                                ->whereYear('created_at', '=', $data['year'])
                                                ->where('semester', '=', $data['semester'])->first();

                    if (!$economic_complement) {

                        $economic_complement = new EconomicComplement;
                        if ($last_economic_complement = EconomicComplement::whereYear('created_at', '=', $data['year'])
                                                            ->where('semester', '=', $data['semester'])
                                                            ->where('deleted_at', '=', null)->orderBy('id', 'desc')->first()) {
                            $number_code = Util::separateCode($last_economic_complement->code);
                            $code = $number_code + 1;
                        }else{
                            $code = 1;
                        }
                        $economic_complement->code = $code . "/" . $data['year'];
                        $economic_complement->affiliate_id = $affiliate_id;
                    }

                    $eco_com_modality = EconomicComplementModality::typeidIs(trim($request->eco_com_type))->first();
                    $economic_complement->eco_com_modality_id = $eco_com_modality->id;
                    $economic_complement->eco_com_state_id = 1;
                    $economic_complement->city_id = trim($request->city);
                    $economic_complement->save();


                    $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

                    if (!$eco_com_applicant) {

                        $eco_com_applicant = new EconomicComplementApplicant;
                        $eco_com_applicant->economic_complement_id = $economic_complement->id;

                        switch ($request->eco_com_type) {
                            case '1':

                                $affiliate = Affiliate::idIs($affiliate_id)->first();
                                $eco_com_applicant->eco_com_applicant_type_id = $request->eco_com_type;
                                $eco_com_applicant->identity_card = $affiliate->identity_card;
                                $eco_com_applicant->city_identity_card_id = $affiliate->city_identity_card_id;
                                $eco_com_applicant->last_name = $affiliate->last_name;
                                $eco_com_applicant->mothers_last_name = $affiliate->mothers_last_name;
                                $eco_com_applicant->first_name = $affiliate->first_name;
                                $eco_com_applicant->birth_date = $affiliate->birth_date;
                                $eco_com_applicant->nua = $affiliate->nua;
                                $eco_com_applicant->gender = $affiliate->gender;
                                $eco_com_applicant->civil_status = $affiliate->civil_status;
                                $eco_com_applicant->phone_number = $affiliate->phone_number;
                                $eco_com_applicant->cell_phone_number = $affiliate->cell_phone_number;

                            break;
                            case '2':
                            # code...
                            break;
                            case '3':
                            # code...
                            break;
                        }

                        $eco_com_applicant->save();

                    }

                    return redirect('economic_complement_reception_second_step/'.$affiliate_id);

                }
            break;

            case 'second':

                $rules = [

                ];

                $messages = [

                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()){
                    return redirect('economic_complement_reception_second_step/' . $affiliate_id)
                    ->withErrors($validator)
                    ->withInput();
                }
                else{
                    $economic_complement = EconomicComplement::idIs($request->economic_complement_id)->first();
                    $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($request->economic_complement_id)->first();

                    switch ($economic_complement->economic_complement_modality->economic_complement_type->id) {
                        case '1':

                            $eco_com_applicant->identity_card = $request->identity_card;
                            if ($request->city_identity_card_id) { $eco_com_applicant->city_identity_card_id = $request->city_identity_card_id; } else { $eco_com_applicant->city_identity_card_id = null; }
                            $eco_com_applicant->last_name = $request->last_name;
                            $eco_com_applicant->mothers_last_name = $request->mothers_last_name;
                            $eco_com_applicant->first_name = $request->first_name;
                            $eco_com_applicant->birth_date = Util::datePick($request->birth_date);
                            $eco_com_applicant->civil_status = $request->civil_status;
                            $eco_com_applicant->phone_number = $request->phone_number;
                            $eco_com_applicant->cell_phone_number = $request->cell_phone_number;
                            $eco_com_applicant->nua = $request->nua;

                            $affiliate = Affiliate::idIs($affiliate_id)->first();
                            $affiliate->identity_card = $request->identity_card;
                            if ($request->city_identity_card_id) { $affiliate->city_identity_card_id = $request->city_identity_card_id; } else { $affiliate->city_identity_card_id = null; }
                            $affiliate->last_name = $request->last_name;
                            $affiliate->mothers_last_name = $request->mothers_last_name;
                            $affiliate->first_name = $request->first_name;
                            $affiliate->birth_date = Util::datePick($request->birth_date);
                            $affiliate->gender = $request->gender;
                            $affiliate->civil_status = $request->civil_status;
                            $affiliate->phone_number = $request->phone_number;
                            $affiliate->cell_phone_number = $request->cell_phone_number;
                            $eco_com_applicant->nua = $request->nua;
                            $affiliate->save();

                        break;
                        case '2':
                        # code...
                        break;
                        case '3':
                        # code...
                        break;
                    }

                    $eco_com_applicant->save();

                    return redirect('economic_complement_reception_second_step/'.$affiliate_id);

                }

            break;
        }


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
