<?php

namespace Muserpol\Http\Controllers\Affiliate;

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
use Muserpol\AffiliateRecord;
use Muserpol\AffiliateAddress;
use Muserpol\AffiliateState;
use Muserpol\Category;
use Muserpol\Contribution;
use Muserpol\City;
use Muserpol\Degree;
use Muserpol\EconomicComplementProcedure;
use Muserpol\EconomicComplement;
use Muserpol\PensionEntity;
use Muserpol\Spouse;
use Muserpol\Unit;
use Muserpol\ObservationType;
use Muserpol\EconomicComplementApplicant;
use Muserpol\AffiliateObservation;
use Muserpol\EconomicComplementSubmittedDocument;
use Muserpol\Devolution;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('affiliates.index', self::getViewModel());
    }

    public function Data(Request $request)
    {
        $affiliates = DB::table('v_afiliados');

        if ($request->has('last_name'))
        {
            $last_name = strtoupper(trim($request->get('last_name')));
            $affiliates->where(function($affiliates) use ($last_name){
                $affiliates->where('affiliates.last_name','like',"%".$last_name."%")
                ->orWhere('spouses.last_name','like',"%".$last_name."%");
            });
        }

        if ($request->has('first_name'))
        {
            $first_name = strtoupper(trim($request->get('first_name')));
            $affiliates->where(function($affiliates) use ($first_name){
                $affiliates->where('affiliates.first_name','like',"%".$first_name."%")
                ->orWhere('spouses.first_name','like',"%".$first_name."%");
            });
        }

        if ($request->has('mothers_last_name'))
        {
            $mothers_last_name = strtoupper(trim($request->get('mothers_last_name')));
            $affiliates->where(function($affiliates) use ($mothers_last_name){
                $affiliates->where('affiliates.mothers_last_name','like',"%".$mothers_last_name."%")
                ->orWhere('spouses.mothers_last_name','like',"%".$mothers_last_name."%");
            });
        }
      
        if ($request->has('second_name'))
        {
            $second_name = strtoupper(trim($request->get('second_name')));
            $affiliates->where(function($affiliates) use ($second_name){
                $affiliates->where('affiliates.second_name','like',"%".$second_name."%")
                ->orWhere('spouses.second_name','like',"%".$second_name."%");
            });
        }

        if ($request->has('identity_card'))
        {
            $identity_card = strtoupper(trim($request->get('identity_card')));
            $affiliates->where(function($affiliates) use ($identity_card){
                $affiliates->where('affiliates.identity_card','like',"%".$identity_card."%")
                ->orWhere('spouses.identity_card','like',"%".$identity_card."%");
            });
        }

        if ($request->has('registration'))
        {
            $registration = strtoupper(trim($request->get('registration')));
            $affiliates->where(function($affiliates) use ($registration){
                $affiliates->where('affiliates.registration','like',"%".$registration."%")
                ->orWhere('spouses.registration','like',"%".$registration."%");
            });
        }

        return Datatables::of($affiliates)
        
        ->addColumn('action', function ($affiliate) { return
            '<div class="btn-group" style="margin:-3px 0;">
                <a href="affiliate/'.$affiliate->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
            </div>';})
        ->make(true);
    }

    public static function getViewModel()
    {
        $cities = City::all();
        $cities_list = ['' => ''];
        foreach ($cities as $item) {
            $cities_list[$item->id] = $item->name;
        }
            
        $cities_list_short = ['' => ''];
        foreach ($cities as $item) {
            $cities_list_short[$item->id] = $item->first_shortened;
        }

        $affiliate_states = AffiliateState::all();
        $affiliate_states_list = ['' => ''];
        foreach ($affiliate_states as $item) {
            $affiliate_states_list[$item->id] = $item->name;
        }

        $degrees = Degree::all();
        $degrees_list = ['' => ''];
        foreach ($degrees as $item) {
            $degrees_list[$item->id] = $item->name;
        }

        $pension_entities = PensionEntity::all();
        $pension_entities_list = ['' => ''];;
        foreach ($pension_entities as $item) {
            $pension_entities_list[$item->id] = $item->name;
        }

        $units = Unit::all();
        $units_list = ['' => ''];
        foreach ($units as $item) {
            $units_list[$item->id] = $item->name;
        }

        $categories = Category::all();
        $categories_list = ['' => ''];
        foreach ($categories as $item) {
            if ($item->id != 9 && $item->id !=10) {
                $categories_list[$item->id]=$item->name;
            }
        }

        $observations_types = ObservationType::all();
        $observation_types_list = array('' => '');
        foreach ($observations_types as $item) {
            $observation_types_list[$item->id]=$item->name;
        }

        $gender_list = ['' => '', 'C' => 'CASADO(A)', 'S' => 'SOLTERO(A)', 'V' => 'VIUDO(A)', 'D' => 'DIVORCIADO(A)'];

        return [
            'cities' => $cities,
            'cities_list' => $cities_list,
            'cities_list_short' => $cities_list_short,
            'affiliate_states_list' => $affiliate_states_list,
            'degrees_list' => $degrees_list,
            'pension_entities_list' => $pension_entities_list,
            'units_list' => $units_list,
            'categories_list' => $categories_list,
            'observation_types_list' => $observation_types_list,
            'gender_list' => $gender_list
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getData($affiliate)
    {
        $affiliate_address = AffiliateAddress::affiliateidIs($affiliate->id)->first();
        
        if (!$affiliate_address) { $affiliate_address = new AffiliateAddress; }
        
        $spouse = Spouse::affiliateidIs($affiliate->id)->first();

        if (!$spouse) { $spouse = new Spouse; }

        if ($spouse->city_identity_card_id) {
            $spouse->city_identity_card = City::idIs($spouse->city_identity_card_id)->first()->first_shortened;
        }else {
            $spouse->city_identity_card = '';
        }

        if ($affiliate->gender == 'M') {
            $gender_list = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];
            $gender_list_s = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];

        }elseif ($affiliate->gender == 'F') {
            $gender_list = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];
            $gender_list_s = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];

        }

        if ($affiliate->city_identity_card_id) {
            $affiliate->city_identity_card = City::idIs($affiliate->city_identity_card_id)->first()->first_shortened;
        }else {
            $affiliate->city_identity_card = '';
        }
        if ($affiliate->city_birth_id) {
            $affiliate->city_birth = City::idIs($affiliate->city_birth_id)->first()->name;
        }else {
            $affiliate->city_birth = '';
        }
        if ($affiliate_address->city_address_id) {
            $affiliate_address->city_address = City::idIs($affiliate_address->city_address_id)->first()->name;
        }else {
            $affiliate_address->city_address = '';
        }
        if ($affiliate_address->city_address_id || $affiliate_address->zone || $affiliate_address->Street || $affiliate_address->number_address) {
            $info_address = TRUE;
        }else{
            $info_address = FALSE;
        }
        if ($spouse->identity_card) {
            $info_spouse = TRUE;
        }else{
            $info_spouse = FALSE;
        }

        // $totals = DB::table('affiliates')
        //     ->select(DB::raw('SUM(contributions.gain) as gain, SUM(contributions.public_security_bonus) as public_security_bonus,
        //                     SUM(contributions.quotable) as quotable, SUM(contributions.total) as total,
        //                     SUM(contributions.retirement_fund) as retirement_fund, SUM(contributions.mortuary_quota) as mortuary_quota'))
        //     ->leftJoin('contributions', 'affiliates.id', '=', 'contributions.affiliate_id')
        //     ->where('affiliates.id', '=', $affiliate->id)
        //     ->get();

        // foreach ($totals as $item) {
        //     $total_gain = Util::formatMoney($item->gain);
        //     $total_public_security_bonus = Util::formatMoney($item->public_security_bonus);
        //     $total_quotable = Util::formatMoney($item->quotable);
        //     $total_retirement_fund = Util::formatMoney($item->retirement_fund);
        //     $total_mortuary_quota = Util::formatMoney($item->mortuary_quota);
        //     $total = Util::formatMoney($item->total);
        // }

        $economic_complement = EconomicComplement::where('affiliate_id', $affiliate->id)->first();

        $ca=Category::all();
        $categories=[];
        foreach ($ca as $key=>$d) {
            if ($key==8) {
                break;
            }else{
                $categories[$d->id]=$d->name;
            }
        }

        // $moduleObservation=Auth::user()->roles()->first()->module->id;
        // $observations_types = $moduleObservation == 1 ? ObservationType::all() : ObservationType::where('module_id',$moduleObservation)->get();
        $observations_types = ObservationType::where('module_id',Util::getRol()->module_id)->get();
        $observation_types_list = array('' => '');
        foreach ($observations_types as $item) {
            $observation_types_list[$item->id]=$item->name;
        }

        //$year = Util::getYear(Carbon::now());
        // $semester = Util::getCurrentSemester();
        //$semester = Util::getOriginalSemester();
        $year = Util::getCurrentYear();
        $eco_com_current_procedure_first = EconomicComplementProcedure::whereYear('year', '=',$year)
        ->where('semester','Primer')
        ->first();
        $eco_com_current_procedure_second = EconomicComplementProcedure::whereYear('year', '=',$year)
        ->where('semester','Segundo')
        ->first();
        if ($eco_com_current_procedure_first) {
            $first_economic_complement = EconomicComplement::where('affiliate_id', $affiliate->id)
            ->where('eco_com_procedure_id', $eco_com_current_procedure_first->id)
            ->first();
            $has_first_eco_com = $first_economic_complement ? "edit" : "create";

        } else {
            $eco_com_current_procedure_first='';
            $has_first_eco_com = "disabled";
        }
        if ($eco_com_current_procedure_second) {
            $second_economic_complement = EconomicComplement::where('affiliate_id', $affiliate->id)
            ->where('eco_com_procedure_id', $eco_com_current_procedure_second->id)
            ->first();
            $has_second_eco_com = $second_economic_complement ? "edit" : "create";
        }else{
            $eco_com_current_procedure_secondd='';
            $has_second_eco_com = "disabled";
        }

        $affi_observations = AffiliateObservation::where('affiliate_id',$affiliate->id)->first();

        if (EconomicComplement::where('affiliate_id', $affiliate->id)->whereYear('year','=', 2016)->where('semester','=', 'Segundo')->first()) {
            $last_ecocom = EconomicComplement::where('affiliate_id', $affiliate->id)->whereYear('year','=', 2016)->where('semester','=', 'Segundo')->first();   

            if (EconomicComplementSubmittedDocument::economicComplementIs($last_ecocom->id)->first()) {
                if ($last_ecocom->economic_complement_modality->economic_complement_type->name == 'Vejez') {
                    $eco_com_submitted_documents = EconomicComplementSubmittedDocument::economicComplementIs($last_ecocom->id)->where(function ($query)
                    {
                        $query->where('eco_com_requirement_id','=',2)
                              ->orWhere('eco_com_requirement_id','=',3)
                              ->orWhere('eco_com_requirement_id','=',4)
                              ->orWhere('eco_com_requirement_id','=',5);
                    })->orderBy('id','asc')->get();
                }else{
                    $eco_com_submitted_documents = EconomicComplementSubmittedDocument::economicComplementIs($last_ecocom->id)->where(function ($query)
                    {
                        $query->where('eco_com_requirement_id','=',7)
                              ->orWhere('eco_com_requirement_id','=',8)
                              ->orWhere('eco_com_requirement_id','=',9)
                              ->orWhere('eco_com_requirement_id','=',10)
                              ->orWhere('eco_com_requirement_id','=',11)
                              ->orWhere('eco_com_requirement_id','=',12)
                              ->orWhere('eco_com_requirement_id','=',13);
                    })->orderBy('id','asc')->get();
                }

                $status_documents = TRUE;
            }else{
                $eco_com_submitted_documents = null;
                $status_documents = FALSE;
            }
        }else{
            $eco_com_submitted_documents = null;
            $status_documents = false;
            $last_ecocom = null;
        }
        $percentages_list =array(
        '0.50'=>'50%',
        '0.60'=>'60%',
        '0.70'=>'70%',
        '0.80'=>'80%',
        '0.90'=>'90%',
        '1'=>'100%',
        );
        $devolution = Devolution::where('affiliate_id','=', $affiliate->id)->where('observation_type_id','=',13)->first();
        $paid_states=DB::table('paid_affiliates')->where('affiliate_id', '=',$affiliate->id)->get();
        $data = [
            'affiliate' => $affiliate,
            'affiliate_address' => $affiliate_address,
            'spouse' => $spouse,
            'gender_list' => $gender_list,
            'gender_list_s' => $gender_list_s,
            'info_address' => $info_address,
            'info_spouse' => $info_spouse,
            'first_economic_complement' => $first_economic_complement,
            'second_economic_complement' => $second_economic_complement,
            'has_first_eco_com' => $has_first_eco_com,
            'has_second_eco_com' => $has_second_eco_com,
            'last_ecocom' => $last_ecocom,
            'eco_com_submitted_documents' => $eco_com_submitted_documents,
            'status_documents' => $status_documents,
            'observations_types' => $observation_types_list,
            'affi_observations' => $affi_observations,
            'paid_states' =>$paid_states,
            'percentage_list' => $percentages_list,
            'devolution' => $devolution,
            // 'total_gain' => $total_gain,
            // 'total_public_security_bonus' => $total_public_security_bonus,
            // 'total_quotable' => $total_quotable,
            // 'total_retirement_fund' => $total_retirement_fund,
            // 'total_mortuary_quota' => $total_mortuary_quota,
            // 'total' => $total
        ];
        $data = array_merge($data, self::getViewModel());
        return $data;
    }

    public function show($affiliate)
    {
        return view('affiliates.view', self::getData($affiliate));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $affiliate)
    {
        return $this->save($request, $affiliate);
    }

    public function store(Request $request)
    {
        return $this->save($request);
    }

    public function save($request, $affiliate = false)
    {

        $rules = [
            // 'identity_card' =>'required',
            // 'city_identity_card_id' => 'required',
            // 'last_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'mothers_last_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'first_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'second_name' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'surname_husband' => 'min:3|regex:/^[a-záéíóúàèìòùäëïöüñ\s]+$/i',
            // 'gender' => 'required',
            // 'birth_date' => 'required'
        ];

        $messages = [
            // 'identity_card.required' => 'El Campo es Requerido',
            // 'city_identity_card_id.required' => 'El Campo es Requerido',
            // 'last_name.min' => 'El mínimo de caracteres permitidos para apellido paterno es 3',
            // 'last_name.regex' => 'Sólo se aceptan letras para apellido paterno',

            // 'mothers_last_name.min' => 'El mínimo de caracteres permitidos para apellido materno es 3',
            // 'mothers_last_name.regex' => 'Sólo se aceptan letras para apellido materno',

            // 'first_name.min' => 'El mínimo de caracteres permitidos para primer nombre es 3',
            // 'first_name.regex' => 'Sólo se aceptan letras para primer nombre',

            // 'second_name.min' => 'El mínimo de caracteres permitidos para teléfono de usuario es 3',
            // 'second_name.regex' => 'Sólo se aceptan letras para segundo nombre',

            // 'surname_husband.min' => 'El mínimo de caracteres permitidos para estado civil es 3',
            // 'surname_husband.regex' => 'Sólo se aceptan letras para estado civil',
            // 'gender.required' => 'Debe seleccionar un género',
            // 'birth_date.required' => 'Debe ingresa fecha de nacimiento'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect('affiliate/'.$affiliate->id)
            ->withErrors($validator)
            ->withInput();
        }
        else {

            switch ($request->type) {

                case 'personal':
                    $affiliate->user_id = Auth::user()->id;
                    $affiliate->identity_card = trim($request->identity_card);
                    if ($request->city_identity_card_id) { $affiliate->city_identity_card_id = $request->city_identity_card_id; } else { $affiliate->city_identity_card_id = null; }
                    $affiliate->last_name = trim($request->last_name);
                    $affiliate->mothers_last_name = trim($request->mothers_last_name);
                    $affiliate->first_name = trim($request->first_name);
                    $affiliate->second_name = trim($request->second_name);
                    $affiliate->surname_husband = trim($request->surname_husband);
                    $affiliate->gender = trim($request->gender);
                    $affiliate->nua = $request->nua >0 ? $request->nua:0;
                    $affiliate->birth_date = Util::datePick($request->birth_date);
                    $affiliate->civil_status = trim($request->civil_status);
                    if ($request->city_birth_id) { $affiliate->city_birth_id = $request->city_birth_id; } else { $affiliate->city_birth_id = null; }
                    $affiliate->phone_number = trim(implode(",", $request->phone_number));
                    $affiliate->cell_phone_number = trim(implode(",", $request->cell_phone_number));
                    if ($request->DateDeathAffiliateCheck == "on") {
                        $affiliate->date_death = Util::datePick($request->date_death);
                        $affiliate->reason_death = trim($request->reason_death);
                        $affiliate->death_certificate_number = trim($request->death_certificate_number);
                    }else {
                        $affiliate->date_death = null;
                        $affiliate->reason_death = null;
                        $affiliate->death_certificate_number = null;
                    }
                    if($request->has('is_duedate_undefined'))
                    {
                        $affiliate->is_duedate_undefined= $request->is_duedate_undefined;
                    }
                    else
                    {
                        $affiliate->is_duedate_undefined= false;
                        $affiliate->due_date = $request->due_date?$request->due_date:null;
                    }
                    $affiliate->save();
                    $message = "Información Afiliado actualizado con éxito";
                    if ($request->typeEco == "economic_complement") {
                        return redirect('economic_complement/'.$request->economic_complement_id);
                    }
                break;

                case 'personal_new':
                    if (!Affiliate::where('identity_card', '=', $request->identity_card)->first()) {
                        $affiliate = new Affiliate;
                        $affiliate->user_id = Auth::user()->id;
                        $affiliate->affiliate_state_id = 5;
                        if ($request->city_identity_card_id) { $affiliate->city_identity_card_id = $request->city_identity_card_id; } else { $affiliate->city_identity_card_id = null; }
                        $affiliate->identity_card = trim($request->identity_card);
                        $affiliate->category_id = $request->category;
                        $affiliate->type = $request->type_affiliate;
                        $affiliate->pension_entity_id = $request->pension;
                        $affiliate->city_birth_id = $request->city_birth_id;
                        $affiliate->degree_id = $request->degree;
                        $affiliate->last_name = trim($request->last_name);
                        $affiliate->mothers_last_name = trim($request->mothers_last_name);
                        $affiliate->first_name = trim($request->first_name);
                        $affiliate->second_name = trim($request->second_name);
                        $affiliate->surname_husband = trim($request->surname_husband);
                        $affiliate->gender = trim($request->gender);
                        $affiliate->nua = $request->nua > 0 ? $request->nua : 0;
                        $affiliate->birth_date = Util::datePick($request->birth_date);
                        $affiliate->civil_status = trim($request->civil_status);
                        $affiliate->change_date = Carbon::now();
                        $affiliate->phone_number = trim(implode(",", $request->phone_number));
                        $affiliate->cell_phone_number = trim(implode(",", $request->cell_phone_number));
                        $affiliate->registration = Util::CalcRegistration($affiliate->birth_date, $affiliate->last_name, $affiliate->mothers_last_name, $affiliate->first_name, $affiliate->gender);
                        if($request->has('is_duedate_undefined'))
                        {
                            $affiliate->is_duedate_undefined= $request->is_duedate_undefined;
                        }
                        else
                        {
                            $affiliate->due_date = $request->due_date?$request->due_date:null;
                            $affiliate->is_duedate_undefined= false;
                        }
                   
                        $affiliate->save();
                        $message = "Información Afiliado creado con éxito";
                    }else{
                        $message = "El Afiliado ya existe";
                    }
                break;

                case 'institutional':
                    $affiliate->affiliate_state_id = $request->state;
                    //$affiliate->type = $request->affiliate_type;
                    //$affiliate->unit_id = $request->unit;
                    $affiliate->degree_id = $request->degree;
                    $affiliate->date_entry = Util::datePick($request->date_entry);
                    $affiliate->item = $request->item > 0 ? $request->item: 0 ;
                    $affiliate->category_id = $request->category;
                    $affiliate->pension_entity_id=$request->affiliate_entity_pension;
                    $affiliate->service_years=$request->service_years <> "" ? $request->service_years:null;
                    $affiliate->service_months=$request->service_months <> "" ? $request->service_months : null;
                    $affiliate->save();
                    $message = "Información del Policia actualizada correctamene.";
                    Session::flash('message', $message);

                break;
                case 'devolutions':

                    $address=$affiliate->affiliate_address->first();
                    if (!$address) {
                        $message = "Debe Actualizar la información de domicilio del afiliado.";
                        Session::flash('message', $message);
                        return redirect('affiliate/'.$affiliate->id);
                    }

                    $devolution = Devolution::where('affiliate_id','=',$affiliate->id)->where('observation_type_id','=',13)->first();

                    
                    if ($devolution) {
                        if ($request->immediate_voluntary_return == 'on') {
                            $devolution->deposit_number = $request->deposit_number; 
                            $devolution->payment_amount = floatval(str_replace(',','',$request->amount));
                            $devolution->payment_date = Util::datePick($request->payment_date); 
                        }else{
                            $devolution->payment_amount = null;
                            $devolution->deposit_number = null;
                            $devolution->payment_date = null; 
                        }
                        if ($request->total_percentage == 'true') {
                            $devolution->percentage = $request->percentage;
                        }else{
                            $devolution->percentage = null;
                        }
                        $devolution->save();
                    return redirect()->route('devolution_print',$devolution->id);
                    }else{
                        $message="El afiliado no tiene deudas.";
                    }
                    Session::flash('message', $message);
                    return redirect('affiliate/'.$affiliate->id);
                    // $devolution->save();
                    break;
                case 'institutional_eco_com':
                    // $economic_complement = EconomicComplement::where('affiliate_id', $affiliate->id)->orderBy('created_at','desc')->first();
                    $economic_complement = EconomicComplement::find($request->economic_complement_id);

                    // recalculate
                    if ($economic_complement->total > 0 && ( $economic_complement->eco_com_state_id == 1 || $economic_complement->eco_com_state_id == 2 || $economic_complement->eco_com_state_id == 3 || $economic_complement->eco_com_state_id == 17 || $economic_complement->eco_com_state_id == 18 || $economic_complement->eco_com_state_id == 15 )) {
                        $economic_complement->recalification_date = Carbon::now();
                        $temp_eco_com = (array)json_decode($economic_complement);
                        $old_eco_com = [];
                        foreach ($temp_eco_com as $key => $value) {
                            if ($key != 'old_eco_com') {
                                $old_eco_com[$key] = $value;
                            }
                        }
                        if (!$economic_complement->old_eco_com) {
                            $economic_complement->old_eco_com=json_encode($old_eco_com);
                        }
                        $economic_complement->save();
                    }
                    // /recalculate
                    $economic_complement->city_id = $request->regional;
                    $economic_complement->category_id = $request->category;
                    $economic_complement->degree_id = $request->degree;
                    $economic_complement->save();
                    //$affiliate->affiliate_state_id = $request->state;
                    //  $affiliate->type = $request->affiliate_type;
                    //$affiliate->unit_id = $request->unit;
                    $affiliate->degree_id = $request->degree;
                    $affiliate->date_entry = Util::datePick($request->date_entry);
                    $affiliate->item = $request->item > 0 ? $request->item: 0 ;
                    $affiliate->category_id = $request->category;
                    $affiliate->pension_entity_id=$request->affiliate_entity_pension;
                    $affiliate->service_years=$request->service_years <> "" ? $request->service_years:null;
                    $affiliate->service_months=$request->service_months <> "" ? $request->service_months : null;
                    $affiliate->death_certificate_number=$request->death_certificate_number;
                    $affiliate->save();
                    if ($economic_complement->total_rent > 0 ) {   
                        EconomicComplement::calculate($economic_complement,$economic_complement->total_rent, $economic_complement->sub_total_rent, $economic_complement->reimbursement, $economic_complement->dignity_pension, $economic_complement->aps_total_fsa, $economic_complement->aps_total_cc, $economic_complement->aps_total_fs, $economic_complement->aps_disability);
                    }
                    
                    $message = "Información del Policia actualizada correctamene.";
                    Session::flash('message', $message);

                    return redirect('economic_complement/'.$economic_complement->id);

            }

        }

        if($request->type=='institutional_eco_com'){
            return redirect('economic_complement/'.$economic_complement->id);
        }
        else{
            return redirect('affiliate/'.$affiliate->id);
        }

    }

    public function print_affiliate($affiliate)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "REPORTE DE AFILIADO";
        $date = Util::getDateEdit(date('Y-m-d'));
        $type = 'affiliate';
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $data = $this->getData($affiliate);
        $affiliate = $data['affiliate'];
        $spouse = $data['spouse'];
//        $total_gain = $data['total_gain'];
//        $total_public_security_bonus = $data['total_public_security_bonus'];
//        $total_quotable = $data['total_quotable'];
//        $total_retirement_fund = $data['total_retirement_fund'];
//        $total_mortuary_quota = $data['total_mortuary_quota'];
//        $total = $data['total'];
        $contributions = Contribution::select(['id', 'month_year', 'degree_id', 'unit_id', 'item', 'base_wage','seniority_bonus', 'study_bonus', 'position_bonus', 'border_bonus', 'east_bonus', 'public_security_bonus', 'gain', 'quotable', 'retirement_fund', 'mortuary_quota', 'total'])->where('affiliate_id', $affiliate->id)->get();
        $date = Util::getfulldate(date('Y-m-d'));
        $view = \View::make('affiliates.print.show', compact('header1','header2','title','date','hour','affiliate', 'spouse','contributions'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal','landscape');
        return $pdf->stream();
    }

    public function print_affiliate_cover($affiliate)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE FONDO DE RETIRO POLICIAL INDIVIDUAL";
        $title = "REPORTE DE AFILIADO";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $data = $this->getData($affiliate);
        $affiliate = $data['affiliate'];
        $spouse = $data['spouse'];
        $total_gain = $data['total_gain'];
        $total_public_security_bonus = $data['total_public_security_bonus'];
        $total_quotable = $data['total_quotable'];
        $total_retirement_fund = $data['total_retirement_fund'];
        $total_mortuary_quota = $data['total_mortuary_quota'];
        $total = $data['total'];
        $contributions = Contribution::select(['id', 'month_year', 'degree_id', 'unit_id', 'item', 'base_wage','seniority_bonus', 'study_bonus', 'position_bonus', 'border_bonus', 'east_bonus', 'public_security_bonus', 'gain', 'quotable', 'retirement_fund', 'mortuary_quota', 'total'])->where('affiliate_id', $affiliate->id)->get();
        $date = Util::getfulldate(date('Y-m-d'));
        $view = \View::make('affiliates.print.show', compact('header1','header2','title','date','hour','affiliate', 'spouse','total_gain','total_public_security_bonus','total_quotable','total_retirement_fund','total_mortuary_quota','total','contributions'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal','landscape');
        return $pdf->stream();
    }

    public function print_observations($id_affiliate,$type)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $title = "NOTIFICACIÓN";
        $date = Util::getDateEdit(date('Y-m-d'));
        setlocale(LC_ALL, "es_ES.UTF-8");
        $dateHeader = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
        $current_semester=util::getCurrentSemester();
        $current_year= Util::getCurrentYear();
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $eco_com = EconomicComplement::where('affiliate_id',$id_affiliate)->first();
        $eco_com_applicant = EconomicComplementApplicant::where ('eco_com_applicants.economic_complement_id','=',$eco_com->id)->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')->select('economic_complements.code','economic_complements.reception_date','eco_com_applicants.first_name','eco_com_applicants.second_name','eco_com_applicants.last_name','eco_com_applicants.mothers_last_name','eco_com_applicants.surname_husband','eco_com_applicants.identity_card','eco_com_applicants.nua','eco_com_applicants.city_identity_card_id','eco_com_applicants.birth_date','economic_complements.semester','economic_complements.year','economic_complements.reception_date')->first();
        $eco_com_applicant_date=strftime("%e de %B de %Y",strtotime($eco_com_applicant->reception_date));
        $yearcomplement=new Carbon($eco_com_applicant->year);
        $procedure=EconomicComplementProcedure::whereYear('year','=',date("Y",strtotime($eco_com_applicant->year)))->where('semester','=',$eco_com_applicant->semester)->first();
        $user = Auth::user();
        $user_role =Util::getRol()->name;
        $data=[
            'header1'=>$header1,
            'header2'=>$header2,
            'title'=>$title,
            'date'=>$date,
            'dateHeader'=>$dateHeader,
            'hour'=>$hour,
            'eco_com_applicant'=>$eco_com_applicant,
            'eco_com_applicant_date'=>$eco_com_applicant_date,
            'yearcomplement'=>$yearcomplement,
            'user' => Auth::user(),
            'user_role' =>Util::getRol()->name,
            'current_semester'=>$current_semester,
            'current_year'=>$current_year,
            'yearcomplement'=>$yearcomplement,
            'procedure'=>$procedure
        
        ];
        switch ($type) {
            //OBSERVACIONES AL AFILIADO
            //contabilidad
            case '1':
                $view = \View::make('affiliates.print.print_debtor_in_contable', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            
            //prestamos
            case '2':
                $view = \View::make('affiliates.print.wallet_arrear', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            
            //juridica
            case '3':
                $view = \View::make('affiliates.print.legal_action', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();

            //OBSERVACIONES AL TRAMITE
            //Fuera de plazo 90 dias
            case '4':
                $view = \View::make('affiliates.print.out_of_time90', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            
            //Fuera de plazo 120 dias
            case '5':
                $view = \View::make('affiliates.print.out_of_time120', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();

             //Inclumplimiento de requisitos de inclusión
             case '6':
                Session::flash('message', 'Se tiene registrado la observación respectiva');
            
            //Falta de requisitos habitual inclusión
            case '7':
                $view = \View::make('affiliates.print.print_miss_requiriments_habinc', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            
           
            
            //Menor a 16 años de servicio
            case '8':
                $view = \View::make('affiliates.print.less_16', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            
            //Por invalidez
            case '9':
                $view = \View::make('affiliates.print.invalidity', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            
            //Por salario
            case '10':
                $nextSemester = $eco_com_applicant->semester == 'Primer' ? 'Segundo' : 'Primer'; 
                $nextYear = $eco_com_applicant->semester == 'Segundo' ? Util::getYear($eco_com_applicant->year) : $eco_com_applicant->year;
                array_push($data, $nextSemester);
                array_push($data, $nextYear);
                $view = \View::make('affiliates.print.excluded_by_salary', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();

            //General complemento económico
            //case '11':
            #code

            //Observación por pago a domicilio
            //case '12':
            #code

            //Interrupción reposición de fondos
            //case '13':
            #code


            //Inconsistencia por categoría
            case '14':

                $view = \View::make('affiliates.print.inconsistency_category',$data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            
            //Inconsistencia por grado    
            case '15':
            
                $view = \View::make('affiliates.print.inconsistency_degree',$data)->render(); 
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream(); 

            //Salario por concurrencia
            case '16':
                $nextSemester = $eco_com_applicant->semester == 'Primer' ? 'Segundo' : 'Primer'; 
                $nextYear = $eco_com_applicant->semester == 'Segundo' ? Util::getYear($eco_com_applicant->year) : $eco_com_applicant->year;
                array_push($data, $nextSemester);
                array_push($data, $nextYear);
                $view = \View::make('affiliates.print.excluded_salary_concurrence', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            
            //Calificación correcta
            
            case '17':
                $nextSemester = $eco_com_applicant->semester == 'Primer' ? 'Segundo' : 'Primer'; 
                $nextYear = $eco_com_applicant->semester == 'Segundo' ? Util::getYear($eco_com_applicant->year) : $eco_com_applicant->year;
                array_push($data, $nextSemester);
                array_push($data, $nextYear);
                $view = \View::make('affiliates.print.correct_grading', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();

            //Solicitud fuera de plazo (90 dias) incuplimiento de requisitos
            //case '18':
            #code    

            //Solicitud presentada fuera de plazo (120 dias) Amortización de deuda
            //case '19':
            #code 

            //nota por concurrencia
            /*case '20':
                $view = \View::make('affiliates.print.notice_of_concurrence', $data)->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();        
            */    
        }
    }

    public function print_correct_grading($id_complement)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $title = "NOTIFICACIÓN";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $eco_com_applicant=EconomicComplementApplicant::where ('eco_com_applicants.economic_complement_id','=',$id_complement)->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')->select('economic_complements.code','economic_complements.reception_date','eco_com_applicants.first_name','eco_com_applicants.second_name','eco_com_applicants.last_name','eco_com_applicants.mothers_last_name','eco_com_applicants.surname_husband','eco_com_applicants.identity_card','eco_com_applicants.nua','eco_com_applicants.city_identity_card_id','eco_com_applicants.birth_date','economic_complements.semester','economic_complements.year')->first();
        $yearcomplement=new Carbon($eco_com_applicant->year);
        $view = \View::make('affiliates.print.correct_grading', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal');
        return $pdf->stream();
    }
    public function getCategory(Request $request)
    {
        $service_year = $request->service_years;
        $service_month = $request->service_months;
        if ($service_month > 0) {
            $service_year++;
        }
        $category = Category::where('from','<=',$service_year)
                   ->where('to','>=',$service_year)
                   ->first();
        if ($category) {
            return $category; 
        }
        return "error";
    }
    public function history_print($affiliate_id)
    {
        
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DE FONDO DE RETIRO POLICIAL, CUOTA Y AUXILIO MORTUORIO";
        $date = Util::getDateEdit(date('Y-m-d'));
        setlocale(LC_ALL, "es_ES.UTF-8");
        $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $title = "HISTORIAL POLICIAL";

        $affiliate = Affiliate::where('id', '=', $affiliate_id)->first();
        $affiliate_records = AffiliateRecord::where('affiliate_id', '=', $affiliate_id)->where('type_id', '<>', 6)->orderBy('date', 'asc')->get();
        $data = [
            'date' => $date,
            'hour' => $hour,
            'header1' => $header1,
            'header2' => $header2,
            'title' => $title,
        ];
        $second_data = [
            'affiliate' => $affiliate,
            'affiliate_records' => $affiliate_records,
            'user' => Auth::user(),
            'user_role' =>Util::getRol()->name
        ];
        $data = array_merge($data, $second_data);
        return \PDF::loadView('affiliates.print.history', $data)->setPaper('letter')->setOption('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2017')->setOption('footer-right', 'Pagina [page] de [toPage]')->stream('affiliate_history.pdf');
    }
    public function get_debts_record(Request $request)
    {
        $affiliate = Affiliate::where('id','=', $request->id)->first();


        $loan = $affiliate->economic_complements()->sum('amount_loan');
        $replacement = $affiliate->economic_complements()->sum('amount_replacement');
        $accounting = $affiliate->economic_complements()->sum('amount_accounting');

        // $debts = $affiliate->debts()->orderBy('created_at')->get( );
        $economic_complements = $affiliate->economic_complements()->select('id', 'code','amount_loan', 'amount_replacement', 'amount_accounting');
        
        return Datatables::of($economic_complements)
            ->editColumn('amount_loan',function ($economic_complement)
            {
                return $economic_complement->amount_loan;
            })
            ->editColumn('amount_replacement',function ($economic_complement)
            {
                return $economic_complement->amount_replacement;
            })
            ->editColumn('amount_accounting',function ($economic_complement)
            {
                return $economic_complement->amount_accounting;
            })
            ->make(true);
    }
    public function devolution_print($devolution)
    {        
        
        $devolution=Devolution::where('id','=',$devolution)->first();
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $date = Util::getDateEdit(date('Y-m-d'));
        setlocale(LC_ALL, "es_ES.UTF-8");
        $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $title = "COMPROMISO DE DEVOLUCIÓN POR PAGOS EN DEFECTO DEL COMPLEMENTO ECONÓMICO";
        $affiliate = Affiliate::where('id', '=', $devolution->affiliate_id)->first();
        $address = $affiliate->affiliate_address->first();
        $eco_com = $affiliate->economic_complements()->whereIn('eco_com_procedure_id',[2,6])->get()->last();
        $eco_com_applicant = null;
        $city = null;
        if (!$eco_com) {
        }else{
            $eco_com_applicant=$eco_com->economic_complement_applicant;
            $city=$eco_com->city->name;
        }
        //aumentar restriccion q solo tome las deudas de I/II/2015 y I/II/2016
        // $total_dues=$devolution->dues()->sum('amount');
        $total_dues_literal=Util::convertir($devolution->total);
        $data = [
            'date' => $date,
            'hour' => $hour,
            'header1' => $header1,
            'header2' => $header2,
            'title' => $title,
        ];
        $second_data = [
            'devolution' => $devolution,
            'economic_complement' => $eco_com,
            'city' => $city,
            'eco_com_applicant' => $eco_com_applicant,
            // 'total_dues' => $total_dues,
            'total_dues_literal' => $total_dues_literal,
            'affiliate' => $affiliate,
            'address' => $address,
            'user' => Auth::user(),
            'user_role' =>Util::getRol()->name
        ];
        $data = array_merge($data, $second_data);
        return \PDF::loadView('affiliates.print.devolution_print', $data)->setPaper('letter')->setOption('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2017')/*->setOption('footer-right', 'Pagina [page] de [toPage]')*/->stream('affiliate_devolution.pdf');
    }
}
