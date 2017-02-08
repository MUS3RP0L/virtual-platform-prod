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
use Muserpol\EconomicComplementRequirement;
use Muserpol\EconomicComplementSubmittedDocument;
use Muserpol\Affiliate;
use Muserpol\Spouse;
use Muserpol\PensionEntity;
use Muserpol\City;
use Muserpol\BaseWage;
use Muserpol\ComplementaryFactor;

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

        $pension_entities = PensionEntity::all();
        $pension_entities_list = array('' => '');
        foreach ($pension_entities as $item) {
             $pension_entities_list[$item->id]=$item->name;
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
            'pension_entities_list' => $pension_entities_list,
            'cities_list' => $cities_list,
            'cities_list_short' => $cities_list_short,
            'year' => Carbon::now()->year,
            'semester' => $semester

        ];
    }

    public function ReceptionFirstStep($affiliate_id)
    {
        $getViewModel = self::getViewModel();
        $affiliate = Affiliate::idIs($affiliate_id)->first();
        $economic_complement = EconomicComplement::affiliateIs($affiliate_id)
                                                    ->whereYear('created_at', '=', $getViewModel['year'])
                                                    ->where('semester', '=', $getViewModel['semester'])->first();
        if (!$economic_complement) {
            $economic_complement = new EconomicComplement;
            $eco_com_type = false;
        }else{
            $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type->id;
        }

        $data = [
            'affiliate' => $affiliate,
            'eco_com_type' => $eco_com_type,
            'economic_complement' => $economic_complement
        ];

        $data = array_merge($data, $getViewModel);

        return view('economic_complements.reception_first_step', $data);
    }

    public function ReceptionSecondStep($economic_complement_id)
    {
        $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();

        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();

        $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

        $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type;


        if ($eco_com_applicant->gender == 'M') {
            $gender_list = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];
        }elseif ($eco_com_applicant->gender == 'F') {
            $gender_list = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];
        }

        $data = [

            'affiliate' => $affiliate,
            'eco_com_type' => $eco_com_type->name,
            'economic_complement' => $economic_complement,
            'eco_com_applicant' => $eco_com_applicant,
            'gender_list' => $gender_list

        ];

        $data = array_merge($data, self::getViewModel());

        return view('economic_complements.reception_second_step', $data);
    }

    public function ReceptionThirdStep($economic_complement_id)
    {
        $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();

        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();

        $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type;

        $eco_com_requirements = EconomicComplementRequirement::economicComplementTypeIs($eco_com_type->id)->get();

        $eco_com_submitted_documents = EconomicComplementSubmittedDocument::with('economic_complement_requirement')->economicComplementIs($economic_complement->id)->get();

        if (EconomicComplementSubmittedDocument::economicComplementIs($economic_complement->id)->first()) {
            $status_documents = TRUE;
        }else{
            $status_documents = FALSE;
        }

        $data = [

            'affiliate' => $affiliate,
            'economic_complement' => $economic_complement,
            'eco_com_type' => $eco_com_type->name,
            'eco_com_requirements' => $eco_com_requirements,
            'eco_com_submitted_documents' => $eco_com_submitted_documents,
            'status_documents' => $status_documents
        ];

        $data = array_merge($data, self::getViewModel());

        return view('economic_complements.reception_third_step', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = self::getViewModel();

        $affiliate = Affiliate::idIs($request->affiliate_id)->first();

        $economic_complement = EconomicComplement::affiliateIs($affiliate->id)
                                    ->whereYear('year', '=', $data['year'])
                                    ->where('semester', '=', $data['semester'])->first();

        if (!$economic_complement) {

            $economic_complement = new EconomicComplement;
            if ($last_economic_complement = EconomicComplement::whereYear('year', '=', $data['year'])
                                                ->where('semester', '=', $data['semester'])
                                                ->whereNull('deleted_at')->orderBy('id', 'desc')->first()) {
                $number_code = Util::separateCode($last_economic_complement->code);
                $code = $number_code + 1;
            }else{
                $code = 1;
            }
            $economic_complement->code = $code . "/" . $data['year'];
            $economic_complement->affiliate_id = $affiliate->id;
            $economic_complement->year = Util::datePickYear($data['year'], $data['semester']);
            $economic_complement->semester = $data['semester'];
            $economic_complement->eco_com_state_id = 1;

            $economic_complement->has_empowered = $data['semester'];
        }

        // $base_wage = BaseWage::degreeIs($affiliate->degree_id)->first();
        // $complementary_factor = ComplementaryFactor::hierarchyIs($base_wage->degree->hierarchy->id)
        //                             ->whereYear('year', '=', $data['year'])
        //                             ->where('semester', '=', $data['semester'])->first();
        // $economic_complement->base_wage_id = $base_wage->id;
        // $economic_complement->complementary_factor_id = $complementary_factor->id;
        //
        $eco_com_modality = EconomicComplementModality::typeidIs(trim($request->eco_com_type))->first();
        $economic_complement->eco_com_modality_id = $eco_com_modality->id;
        $economic_complement->category_id = $affiliate->category_id;

        $economic_complement->city_id = trim($request->city);
        // $economic_complement->save();

        // return $this->save($request, $economic_complement->id);
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $economic_complement = EconomicComplement::idIs($id)->first();

        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();

        $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type;

        $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

        $eco_com_submitted_documents = EconomicComplementSubmittedDocument::with('economic_complement_requirement')->economicComplementIs($economic_complement->id)->get();

        if (EconomicComplementSubmittedDocument::economicComplementIs($economic_complement->id)->first()) {
            $status_documents = TRUE;
        }else{
            $status_documents = FALSE;
        }

        if ($eco_com_applicant->gender == 'M') {
            $gender_list = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];
        }elseif ($eco_com_applicant->gender == 'F') {
            $gender_list = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];
        }

        $sub_total_rent = $economic_complement->sub_total_rent;
        $salary_reference = $economic_complement->base_wage->amount;
        $seniority = $economic_complement->category->percentage * $economic_complement->base_wage->amount;
        $salary_quotable = $salary_reference + $seniority;
        $difference = $salary_quotable - $sub_total_rent;
        $months_of_payment = 6;
        $total_amount_semester = $difference * $months_of_payment;
        $complementary_factor = $eco_com_type->id == 1 ? $economic_complement->complementary_factor->old_age : $economic_complement->complementary_factor->widowhood;
        $total = $total_amount_semester * $complementary_factor/100;

        $data = [

            'affiliate' => $affiliate,
            'economic_complement' => $economic_complement,
            'eco_com_type' => $eco_com_type->name,
            'eco_com_applicant' => $eco_com_applicant,
            'eco_com_submitted_documents' => $eco_com_submitted_documents,
            'status_documents' => $status_documents,
            'gender_list' => $gender_list,

            'sub_total_rent' => Util::formatMoney($sub_total_rent),
            'salary_reference' => Util::formatMoney($salary_reference),
            'seniority' => Util::formatMoney($seniority),
            'salary_quotable' => Util::formatMoney($salary_quotable),
            'difference' => Util::formatMoney($difference),
            'total_amount_semester' => Util::formatMoney($total_amount_semester),
            'complementary_factor' => $complementary_factor,
            'total' => Util::formatMoney($total),

        ];

        $data = array_merge($data, self::getViewModel());

        return view('economic_complements.view', $data);
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

    public function update(Request $request, $economic_complement_id)
    {
        return $this->save($request, $economic_complement_id);
    }

    public function save($request, $economic_complement_id = false)
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
                    return redirect('economic_complement_reception_first_step/'.$request->affiliate_id)
                    ->withErrors($validator)
                    ->withInput();
                }
                else{

                    $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement_id)->first();
                    $affiliate = Affiliate::idIs($request->affiliate_id)->first();
                    $affiliate->pension_entity_id = $request->pension_entity;
                    $affiliate->save();

                    if (!$eco_com_applicant) {

                        $eco_com_applicant = new EconomicComplementApplicant;
                        $eco_com_applicant->economic_complement_id = $economic_complement_id;
                        $eco_com_applicant->eco_com_applicant_type_id = $request->eco_com_type;

                        switch ($request->eco_com_type) {
                            case '1':

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

                                $spouse = Spouse::affiliateidIs($request->affiliate_id)->first();
                                if ($spouse) {
                                    $eco_com_applicant->identity_card = $spouse->identity_card;
                                    $eco_com_applicant->city_identity_card_id = $spouse->city_identity_card_id;
                                    $eco_com_applicant->last_name = $spouse->last_name;
                                    $eco_com_applicant->mothers_last_name = $spouse->mothers_last_name;
                                    $eco_com_applicant->first_name = $spouse->first_name;
                                    $eco_com_applicant->birth_date = $spouse->birth_date;
                                }
                                $eco_com_applicant->nua = $affiliate->nua;
                                if ($affiliate->gender == 'M') { $eco_com_applicant->gender = 'F'; }else{ $eco_com_applicant->gender = 'M'; }
                                $eco_com_applicant->civil_status = 'V';
                                $eco_com_applicant->phone_number = $affiliate->phone_number;
                                $eco_com_applicant->cell_phone_number = $affiliate->cell_phone_number;

                            break;
                        }

                        $eco_com_applicant->save();

                    }

                    return redirect('economic_complement_reception_second_step/'.$economic_complement_id);

                }

            break;

            case 'second':

                $rules = [

                ];

                $messages = [

                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()){
                    return redirect('economic_complement_reception_second_step/' . $economic_complement_id)
                    ->withErrors($validator)
                    ->withInput();
                }
                else{
                    $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();

                    $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement_id)->first();
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
                    $eco_com_applicant->save();

                    switch ($economic_complement->economic_complement_modality->economic_complement_type->id) {

                        case '1':

                            $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
                            $affiliate->identity_card = $request->identity_card;
                            if ($request->city_identity_card_id) { $affiliate->city_identity_card_id = $request->city_identity_card_id; } else { $affiliate->city_identity_card_id = null; }
                            $affiliate->last_name = $request->last_name;
                            $affiliate->mothers_last_name = $request->mothers_last_name;
                            $affiliate->first_name = $request->first_name;
                            $affiliate->birth_date = Util::datePick($request->birth_date);
                            $affiliate->civil_status = $request->civil_status;
                            $affiliate->phone_number = $request->phone_number;
                            $affiliate->cell_phone_number = $request->cell_phone_number;
                            $affiliate->nua = $request->nua;
                            $affiliate->save();

                        break;

                        case '2':

                            $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
                            $affiliate->phone_number = $request->phone_number;
                            $affiliate->cell_phone_number = $request->cell_phone_number;
                            // $affiliate->nua = $request->nua;
                            $affiliate->save();
                            $spouse = Spouse::affiliateidIs($affiliate->id)->first();
                            $spouse->identity_card = $request->identity_card;
                            if ($request->city_identity_card_id) { $spouse->city_identity_card_id = $request->city_identity_card_id; } else { $spouse->city_identity_card_id = null; }
                            $spouse->last_name = $request->last_name;
                            $spouse->mothers_last_name = $request->mothers_last_name;
                            $spouse->first_name = $request->first_name;
                            $spouse->birth_date = Util::datePick($request->birth_date);
                            $spouse->civil_status = $request->civil_status;
                            $spouse->save();

                        break;

                        case '3':

                            $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
                            $affiliate->phone_number = $request->phone_number;
                            $affiliate->cell_phone_number = $request->cell_phone_number;
                            $affiliate->nua = $request->nua;
                            $spouse = Spouse::affiliateidIs($affiliate->id)->first();
                            $spouse->save();

                        break;
                    }

                    if ($request->type == 'update') {
                        return redirect('economic_complement/'.$economic_complement_id);
                    }
                    else{
                        return redirect('economic_complement_reception_third_step/'.$economic_complement_id);
                    }
                }

            break;

            case 'third':

                $rules = [

                ];

                $messages = [

                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()){
                    return redirect('economic_complement_reception_second_step/' . $economic_complement_id)
                    ->withErrors($validator)
                    ->withInput();
                }
                else{

                    foreach (json_decode($request->data) as $item)
                    {
                        $eco_com_submitted_document = EconomicComplementSubmittedDocument::where('economic_complement_id', '=', $economic_complement_id)
                                    ->where('eco_com_requirement_id', '=', $item->id)->first();

                        if (!$eco_com_submitted_document) {
                            $eco_com_submitted_document = new EconomicComplementSubmittedDocument;
                            $eco_com_submitted_document->economic_complement_id = $economic_complement_id;
                            $eco_com_submitted_document->eco_com_requirement_id = $item->id;
                        }
                        $eco_com_submitted_document->status = $item->status;
                        $eco_com_submitted_document->reception_date = date('Y-m-d');
                        $eco_com_submitted_document->save();
                    }

                    $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();
                    $economic_complement->reception_date = date('Y-m-d');
                    $economic_complement->save();

                    return redirect('economic_complement/'.$economic_complement_id);

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

    public function print_sworn_declaration1($economic_complement_id)
    {
          $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
          $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
          $title = "FORMULARIO DE DECLARACIÓN JURADA VOLUNTARIA";
          $date = Util::getDateEdit(date('Y-m-d'));
          $current_date = Carbon::now();
          $hour = Carbon::parse($current_date)->toTimeString();
          $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();
          $affiliate = Affiliate::idIs($economic_complement_id)->first();
          $eco_com_applicant = EconomicComplementApplicant::EconomicComplementIs($economic_complement->id)->first();
          $view = \View::make('economic_complements.print.sworn_declaration1', compact('header1','header2','title','date','hour','affiliate','economic_complement','eco_com_applicant'))->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($view)->setPaper('legal');
          return $pdf->stream();

    }

    public function print_sworn_declaration2($economic_complement_id)
    {
          $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
          $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
          $title = "FORMULARIO DE DECLARACIÓN JURADA VOLUNTARIA";
          $date = Util::getDateEdit(date('Y-m-d'));
          $current_date = Carbon::now();
          $hour = Carbon::parse($current_date)->toTimeString();
          $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();
          $affiliate = Affiliate::idIs($economic_complement_id)->first();
          $spouse  = Spouse::where('affiliate_id', '=', $affiliate->id )->first();
          $eco_com_applicant = EconomicComplementApplicant::EconomicComplementIs($economic_complement->id)->first();
          $view = \View::make('economic_complements.print.sworn_declaration2', compact('header1','header2','title','date','hour','affiliate','spouse','economic_complement','eco_com_applicant'))->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($view)->setPaper('legal');
          return $pdf->stream();

    }

    public function print_inclusion_solicitude($economic_complement_id)
    {
          $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
          $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
          $title = "";
          $date = Util::getDateEdit(date('Y-m-d'));
          $current_date = Carbon::now();
          $hour = Carbon::parse($current_date)->toTimeString();
          $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();
          $eco_com_submitted_document = EconomicComplementSubmittedDocument::economicComplementIs($economic_complement->id)->get();
          $affiliate = Affiliate::idIs($economic_complement_id)->first();
          $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();
          $view = \View::make('economic_complements.print.inclusion_solicitude', compact('header1','header2','title','date','hour','economic_complement','eco_com_submitted_document','affiliate','eco_com_applicant'))->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($view)->setPaper('letter');
          return $pdf->stream();
    }

    public function print_pay_solicitude($economic_complement_id)
    {
          $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
          $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
          $title = "";
          $date = Util::getDateEdit(date('Y-m-d'));
          $current_date = Carbon::now();
          $hour = Carbon::parse($current_date)->toTimeString();
          $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();
          $eco_com_submitted_document = EconomicComplementSubmittedDocument::economicComplementIs($economic_complement->id)->get();
          $affiliate = Affiliate::idIs($economic_complement_id)->first();
          $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();
          $view = \View::make('economic_complements.print.pay_solicitude', compact('header1','header2','title','date','hour','economic_complement','eco_com_submitted_document','affiliate','eco_com_applicant'))->render();
          $pdf = \App::make('dompdf.wrapper');
          $pdf->loadHTML($view)->setPaper('letter');
          return $pdf->stream();
    }


}
