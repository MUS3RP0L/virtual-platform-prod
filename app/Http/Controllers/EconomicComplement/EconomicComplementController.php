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

        $city = City::all();
        $cities_list = array('' => '');
        foreach ($city as $item) {
             $cities_list[$item->id]=$item->name;
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

        $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type;

        $eco_com_applicant_type = EconomicComplementApplicantType::idIs($eco_com_type->id)->first();


        $data = [

            'eco_com_type' => $eco_com_type->name,
            'eco_com_applicant_type' => $eco_com_applicant_type,
            'economic_complement' => $economic_complement,
            'eco_com_applicant' => $eco_com_applicant

        ];
        return $data;

        // $data = array_merge($data, self::getData($affiliate_id));
        // $data = array_merge($data, self::getViewModel());

        // return view('economic_complements.reception_second_step', $data);
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
                    return redirect('economic_complement_reception_second_step/'.$affiliate_id)
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


                    $applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

                    if (!$applicant) {

                        $eco_com_applicant = new EconomicComplementApplicant;
                        $applicant->economic_complement_id = $economic_complement->id;

                        switch ($request->eco_com_type) {
                            case '1':

                                $affiliate = Affiliate::idIs($affiliate_id)->first();
                                $applicant->eco_com_applicant_type_id = $request->eco_com_type;
                                $applicant->identity_card = $affiliate->identity_card;
                                $applicant->city_identity_card_id = $request->city_identity_card_id;
                                $applicant->last_name = $affiliate->last_name;
                                $applicant->mothers_last_name = $affiliate->mothers_last_name;
                                $applicant->first_name = $affiliate->first_name;

                            break;
                            case '2':
                            # code...
                            break;
                            case '3':
                            # code...
                            break;
                        }

                        $applicant->save();

                    }

                    return redirect('economic_complement_reception_second_step/'.$affiliate_id);

                }
            break;

            case 'second':

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
