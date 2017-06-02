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
        $affiliates = Affiliate::select(['affiliates.id', 'affiliates.identity_card', 'affiliates.registration', 'affiliates.last_name', 'affiliates.mothers_last_name', 'affiliates.first_name', 'affiliates.second_name',  'affiliates.affiliate_state_id', 'affiliates.degree_id', 'affiliates.city_identity_card_id']);
        if ($request->has('last_name'))
        {  
            $last_name = strtoupper(trim($request->get('last_name')));
            $last_name=strtoupper($last_name);
           
           $affiliates->leftJoin('spouses','affiliates.id','=','spouses.affiliate_id')
           ->where(function($affiliates) use ($last_name){
            $affiliates->where('affiliates.last_name','like',"%".$last_name."%")
            ->orWhere('spouses.last_name','like',"%".$last_name."%");
        })->get();

         
        }
        if ($request->has('mothers_last_name'))
        {
          $mothers_last_name = strtoupper(trim($request->get('mothers_last_name')));
          $mothers_last_name=strtoupper($mothers_last_name);

          $affiliates->leftJoin('spouses','affiliates.id','=','spouses.affiliate_id')
          ->where(function($affiliates) use ($mothers_last_name){
            $affiliates->where('affiliates.mothers_last_name','like',"%".$mothers_last_name."%")
            ->orWhere('spouses.mothers_last_name','like',"%".$mothers_last_name."%");
        })->get();

      }
      if ($request->has('first_name'))
      {
        $first_name = strtoupper(trim($request->get('first_name')));
        $first_name=strtoupper($first_name);

        $affiliates->leftJoin('spouses','affiliates.id','=','spouses.affiliate_id')
        ->where(function($affiliates) use ($first_name){
            $affiliates->where('affiliates.first_name','like',"%".$first_name."%")
            ->orWhere('spouses.first_name','like',"%".$first_name."%");
        })->get();
    }
    if ($request->has('second_name'))
    {
     $second_name = strtoupper(trim($request->get('second_name')));
     $second_name=strtoupper($second_name);

     $affiliates->leftJoin('spouses','affiliates.id','=','spouses.affiliate_id')
     ->where(function($affiliates) use ($second_name){
        $affiliates->where('affiliates.second_name','like',"%".$second_name."%")
        ->orWhere('spouses.second_name','like',"%".$second_name."%");
    })->get();
 }
 if ($request->has('identity_card'))
 {


    $affiliates->where(function($affiliates) use ($request)
    {
        $identity_card = trim($request->get('identity_card'));
        $identity_card=strtoupper($identity_card);
        $affiliate=Affiliate::identitycardIs($identity_card)->first();
        if(isset($affiliate)){
            $affiliates->where('identity_card', 'like', "{$identity_card}");
        }   
        else{
            $spouses=Spouse::identitycardIs($identity_card)->first();
            $affiliate=$spouses->affiliate;
            $affiliates->find($affiliate->id);         
        }
    });
}
if ($request->has('registration'))
{
    $affiliates->where(function($affiliates) use ($request)
    {
        $registration = trim($request->get('registration'));
        $affiliates->where('registration', 'like', "%{$registration}%");
    });
}

return Datatables::of($affiliates)
->addColumn('identity_card', function($affiliate){ return $affiliate->city_identity_card_id ? $affiliate->identity_card . ' ' . $affiliate->city_identity_card->shortened : $affiliate->identity_card; })
->addColumn('degree', function ($affiliate) { return $affiliate->degree_id ? $affiliate->degree->shortened : ''; })
->editColumn('last_name', function ($affiliate) { return Util::ucw($affiliate->last_name); })
->editColumn('mothers_last_name', function ($affiliate) { return Util::ucw($affiliate->mothers_last_name); })
->addColumn('names', function ($affiliate) { return Util::ucw($affiliate->first_name) .' '. Util::ucw($affiliate->second_name); })
->addColumn('state', function ($affiliate) { return $affiliate->affiliate_state->name; })
->addColumn('action', function ($affiliate) { return  '
    <div class="btn-group" style="margin:-3px 0;">
        <a href="affiliate/'.$affiliate->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
    </div>';})
->make(true);
}

public static function getViewModel()
{
    $cities = City::all();
    $cities_list = ['' => ''];
    foreach ($cities as $item) {
        $cities_list[$item->id]=$item->name;
    }

    $cities_list_short = ['' => ''];
    foreach ($cities as $item) {
        $cities_list_short[$item->id]=$item->first_shortened;
    }

        $affiliate_states=AffiliateState::all();
        $a_states=[];
        foreach ($affiliate_states as $as) {
            $a_states[$as->id]=$as->name;
        }
        $dg=Degree::all();
        $degrees=[];
        foreach ($dg as $d) {
            $degrees[$d->id]=$d->name;
        }

        $ep=PensionEntity::all();
        $entity_pensions=array(''=>'');

        foreach ($ep as $e) {
            $entity_pensions[$e->id]=$e->name;
        }

        $at=Affiliate::all();
        $affiliate_types=[];
        foreach ($at as $d) {
            $affiliate_types[$d->id]=$d->type;
        }

        $un=Unit::all();
        $units=[];
        foreach ($un as $d) {
            $units[$d->id]=$d->name;
        }

        $ca=Category::all();
        $categories=[];
        foreach ($ca as $key=>$d) {
            if ($key==8) {
                break;
            }else{
                $categories[$d->id]=$d->name;
            }
        }

        $gender_list = ['' => '', 'C' => 'CASADO(A)', 'S' => 'SOLTERO(A)', 'V' => 'VIUDO(A)', 'D' => 'DIVORCIADO(A)'];


        return [

        'cities_list' => $cities_list,
        'cities_list_short' => $cities_list_short,
        'gender_list' => $gender_list,
        'affiliate_state'=>$a_states,
        'degrees'=>$degrees,
        'affiliate_types'=>$affiliate_types,
        'entity_pensions'=>$entity_pensions,
        'units'=>$units,
        'categories'=>$categories

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
        $affiliate = Affiliate::idIs($affiliate)->first();

        $AffiliateAddress = AffiliateAddress::affiliateidIs($affiliate->id)->first();
        if (!$AffiliateAddress) { $AffiliateAddress = new AffiliateAddress; }
        $spouse = Spouse::affiliateidIs($affiliate->id)->first();

        if (!$spouse) { $spouse = new Spouse; }
        if ($spouse->city_identity_card_id) {
            $spouse->city_identity_card = City::idIs($spouse->city_identity_card_id)->first()->shortened;
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
            $affiliate->city_identity_card = City::idIs($affiliate->city_identity_card_id)->first()->shortened;
        }else {
            $affiliate->city_identity_card = '';
        }
        if ($affiliate->city_birth_id) {
            $affiliate->city_birth = City::idIs($affiliate->city_birth_id)->first()->name;
        }else {
            $affiliate->city_birth = '';
        }
        if ($AffiliateAddress->city_address_id) {
            $AffiliateAddress->city_address = City::idIs($AffiliateAddress->city_address_id)->first()->name;
        }else {
            $AffiliateAddress->city_address = '';
        }
        if ($AffiliateAddress->city_address_id || $AffiliateAddress->zone || $AffiliateAddress->Street || $AffiliateAddress->number_address) {
            $info_address = TRUE;
        }else{
            $info_address = FALSE;
        }
        if ($spouse->identity_card) {
            $info_spouse = TRUE;
        }else{
            $info_spouse = FALSE;
        }

        // $last_contribution = Contribution::affiliateidIs($affiliate->id)->orderBy('month_year', 'desc')->first();

        // $totals = DB::table('affiliates')
        //                 ->select(DB::raw('SUM(contributions.gain) as gain, SUM(contributions.public_security_bonus) as public_security_bonus,
        //                                 SUM(contributions.quotable) as quotable, SUM(contributions.total) as total,
        //                                 SUM(contributions.retirement_fund) as retirement_fund, SUM(contributions.mortuary_quota) as mortuary_quota'))
        //                 ->leftJoin('contributions', 'affiliates.id', '=', 'contributions.affiliate_id')
        //                 ->where('affiliates.id', '=', $affiliate->id)
        //                 ->get();

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

        $observations_types = ObservationType::all();
        $observation_types_list = array('' => '');
        foreach ($observations_types as $item) {
            $observation_types_list[$item->id]=$item->name;
        }

        $canObservate=false;
        $ObservationType=null;
        $moduleObservation=Auth::user()->roles()->first()->module->id;
        if($moduleObservation==8 || $moduleObservation==6 ||$moduleObservation==9 ){
            $ObservationType=ObservationType::where('module_id',$moduleObservation)->first();
            $canObservate=true;
        }

        $year = Util::getYear(Carbon::now());
        $semester = Util::getCurrentSemester();
        
        $eco_com_current_procedure = EconomicComplementProcedure::whereYear('year', '=',$year)
        ->where('semester',$semester)
        ->first();
        if ($eco_com_current_procedure) {
            $current_economic_complement = EconomicComplement::where('affiliate_id', $affiliate->id)
            ->where('eco_com_procedure_id', $eco_com_current_procedure->id)
            ->first();
            if ($current_economic_complement) {
                $has_current_eco_com = "edit";
            } else {
                $has_current_eco_com = "create";
            }
        } else {
            $has_current_eco_com = "disabled";
        }

        $data = [
        'canObservate'=>$canObservate,
        'ObservationType'=>$ObservationType,
        'affiliate' => $affiliate,
        'AffiliateAddress' => $AffiliateAddress,
        'spouse' => $spouse,
        'gender_list' => $gender_list,
        'gender_list_s' => $gender_list_s,
        'info_address' => $info_address,
        'info_spouse' => $info_spouse,
        'economic_complement' => $economic_complement,
        'current_economic_complement' => $current_economic_complement,
        'has_current_eco_com' => $has_current_eco_com,
            // 'last_contribution' => $last_contribution,
        'observations_types'=>$observation_types_list,
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

        return view('affiliates.view', self::getData($affiliate->id));
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
                }else {
                    $affiliate->date_death = null;
                    $affiliate->reason_death = null;
                }
                $affiliate->save();
                $message = "Información Afiliado actualizado con éxito";
                break;

                case 'personal_new':
                if (!Affiliate::where('identity_card', '=', $request->identity_card)->first()) {
                    $affiliate = new Affiliate;
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
                    $affiliate->degree_id = $request->degree;
                    $affiliate->change_date = Carbon::now();
                    $affiliate->affiliate_state_id = 5;
                    if ($request->city_birth_id) { $affiliate->city_birth_id = $request->city_birth_id; } else { $affiliate->city_birth_id = null; }
                    $affiliate->registration = Util::CalcRegistration($affiliate->birth_date, $affiliate->last_name, $affiliate->mothers_last_name, $affiliate->first_name, $affiliate->gender);
                    $affiliate->save();
                    $message = "Información Afiliado creado con éxito";
                }

                break;

                case 'institutional':

                    //check!

                    //end check!
                $affiliate->affiliate_state_id = $request->state;
              //  $affiliate->type = $request->affiliate_type;
                //$affiliate->unit_id = $request->unit;
              $affiliate->degree_id = $request->degree;
                $affiliate->date_entry = Util::datePick($request->date_entry);
                $affiliate->item = $request->item > 0 ? $request->item: 0 ;
                $affiliate->category_id = $request->category;
                $affiliate->pension_entity_id=$request->affiliate_entity_pension;
                $affiliate->save();
                $message = "Información del Policia actualizada correctamene.";
                Session::flash('message', $message);

                break;
                case 'institutional_eco_com':

                    //check!
                    $economic_complement = EconomicComplement::where('affiliate_id', $affiliate->id)->orderBy('created_at','desc')->first();
                    $economic_complement->city_id = $request->regional;
                    $economic_complement->save();
                    //end check!
                    //$affiliate->affiliate_state_id = $request->state;
                    //  $affiliate->type = $request->affiliate_type;
                    //$affiliate->unit_id = $request->unit;
                    $affiliate->degree_id = $request->degree;
                    $affiliate->date_entry = Util::datePick($request->date_entry);
                    $affiliate->item = $request->item > 0 ? $request->item: 0 ;
                    $affiliate->category_id = $request->category;
                    $affiliate->pension_entity_id=$request->affiliate_entity_pension;
                    $affiliate->save();
                    $message = "Información del Policia actualizada correctamene.";
                    Session::flash('message', $message);


            }
            Session::flash('message', $message);
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

    public function print_excluded_observations($id_complement,$type)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $title = "NOTIFICACIÓN";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $eco_com_applicant=EconomicComplementApplicant::where ('eco_com_applicants.economic_complement_id','=',$id_complement)->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')->select('economic_complements.code','economic_complements.reception_date','eco_com_applicants.first_name','eco_com_applicants.second_name','eco_com_applicants.last_name','eco_com_applicants.mothers_last_name','eco_com_applicants.surname_husband','eco_com_applicants.identity_card','eco_com_applicants.nua','eco_com_applicants.city_identity_card_id','eco_com_applicants.birth_date','economic_complements.semester','economic_complements.year')->first();
        $yearcomplement=new Carbon($eco_com_applicant->year);
        switch ($type) {
            case 'less16':
            $view = \View::make('affiliates.print.less_16', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();


            case 'invalidity':
            $view = \View::make('affiliates.print.invalidity', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
            

            case 'salary':
                // if($eco_com_applicant->semester=="Primero"){
                //     $nextSemester = "Segundo";
                //     $nextYear = $yearcomplement->format('Y');
                // }

                // if($eco_com_applicant->semester=="Segundo") {
                //     $nextSemester = "Primero";
                //     $nextYear = $yearcomplement->addYear(1);
                // }

            $view = \View::make('affiliates.print.excluded_by_salary', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
            

            case 'legal':
            $view = \View::make('affiliates.print.legal_action', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
        }
    }

    //observations suspension
    public function print_suspended_observations($id_complement,$type)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $title = "NOTIFICACIÓN";
        $date = Util::getDateEdit(date('Y-m-d'));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $eco_com_applicant=EconomicComplementApplicant::where ('eco_com_applicants.economic_complement_id','=',$id_complement)->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')->select('economic_complements.code','economic_complements.reception_date','eco_com_applicants.first_name','eco_com_applicants.second_name','eco_com_applicants.last_name','eco_com_applicants.mothers_last_name','eco_com_applicants.surname_husband','eco_com_applicants.identity_card','eco_com_applicants.nua','eco_com_applicants.city_identity_card_id','eco_com_applicants.birth_date','economic_complements.semester','economic_complements.year','economic_complements.reception_date')->first();
        $yearcomplement=new Carbon($eco_com_applicant->year);
        $procedure=EconomicComplementProcedure::whereYear('year','=',date("Y",strtotime($eco_com_applicant->year)))->where('semester','=',$eco_com_applicant->semester)->first();
        
        switch ($type) {
            case 'debtor_conta':
            $view = \View::make('affiliates.print.print_debtor_in_contable', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
            break;
            
            case 'wallet_pres':
            $view = \View::make('affiliates.print.wallet_arrear', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
            break;
            
            case 'out_time90':
            $view = \View::make('affiliates.print.out_of_time90', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement','procedure'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
            break;
            
            case 'out_time120':
            $view = \View::make('affiliates.print.out_of_time120', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement','procedure'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
            break;
            
            case 'miss_requirements':
            $view = \View::make('affiliates.print.miss_requiriments', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
            break;
            
            case 'miss_requirements_hi':
            $view = \View::make('affiliates.print.print_miss_requiriments_habinc', compact('header1','header2','title','date','hour','eco_com_applicant','yearcomplement'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('legal');
            return $pdf->stream();
            break;
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
    
}