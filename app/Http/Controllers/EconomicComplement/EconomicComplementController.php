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
use DB;
use Log;

use Muserpol\EconomicComplementProcedure;
use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementStateType;
use Muserpol\EconomicComplementState;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementModality;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementLegalGuardian;
use Muserpol\EconomicComplementRequirement;
use Muserpol\EconomicComplementSubmittedDocument;
use Muserpol\EconomicComplementRent;

use Muserpol\Affiliate;
use Muserpol\Spouse;
use Muserpol\PensionEntity;
use Muserpol\City;
use Muserpol\BaseWage;
use Muserpol\ComplementaryFactor;
use Muserpol\Degree;
use Muserpol\Unit;
use Muserpol\Category;
use Muserpol\WorkflowRecord;
use Muserpol\ObservationType;
use Muserpol\AffiliateObservation;
class EconomicComplementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $procedures = EconomicComplementProcedure::orderBy('id','desc')->get();
        $data = [
            'year' => Carbon::now()->year,
            'semester' => Util::getSemester(Carbon::now()),
            'procedures' =>$procedures
        ];




        return view('economic_complements.index', array_merge($data, self::getViewModel()));
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
      $economic_complements = EconomicComplement::select(['id', 'affiliate_id',
            'eco_com_modality_id', 'eco_com_state_id', 'code', 'created_at','reception_date', 'total',
            'wf_current_state_id','city_id','eco_com_procedure_id'])->orderBy('created_at','desc');
        //return $economic_complements->get();

        try {
              $procedure_id = $request->get('eco_com_procedure_id');
        //    Log::info("obteniendo eco_com_procedure_id=".$procedure_id);
           // Log::info("valor del reques");

        } catch (Exception $e) {
            $procedure_id =null;
        }

       // Log::info("comensando buscqueda ".$procedure_id);
        if ($request->has('code'))
        {
            if($procedure_id){
                // Log::info("buscando por ".$procedure_id);
                    $economic_complements->where(function($economic_complements) use ($request,$procedure_id)
                    {
                        $code = trim($request->get('code'));
                        $economic_complements->where('code', 'like', "{$code}%")
                                             ->where('eco_com_procedure_id','=',$procedure_id);
                    });

            }else{

                    $economic_complements->where(function($economic_complements) use ($request)
                    {
                        $code = trim($request->get('code'));
                        $economic_complements->where('code', 'like', "{$code}%");
                    });
            }

        }
        if ($request->has('creation_date'))
        {


            $economic_complements->where(function($economic_complements) use ($request)
            {
                $creation_date = Util::datePick($request->get('creation_date'));
               // Log::info($creation_date);
                $economic_complements->where('reception_date', '=', $creation_date.'%');
            });
        }
        if ($request->has('affiliate_identitycard'))
        {

            if($procedure_id)
            {
               // Log::info("buscando por el carnet");
                $economic_complements->where(function($economic_complements) use ($request,$procedure_id)
                {


                    $applicants_identitycard=trim($request->get('affiliate_identitycard'));
                    $beneficiarios =EconomicComplementApplicant::identitycardIs($applicants_identitycard)->get();

                    $ids = array();
                    foreach ($beneficiarios as $beneficiario) {
                        # code...
                        array_push($ids, $beneficiario->economic_complement_id);

                    }
                   // Log::info($ids);


                   if($beneficiarios){

                       $economic_complements->whereIn('id',$ids)->where('eco_com_procedure_id','=',$procedure_id);
                       // $economic_complements->where('id', '=' , "{$applicants->economic_complement_id}")->where('eco_com_procedure_id','=',$procedure_id);
                   }
                   else{
                       $economic_complements->where('affiliate_id', 0)->where('eco_com_procedure_id','=',$procedure_id);
                   }

                });
            }else
            {
               // Log::info("buscando por el carnet sin procedure_id");
                $economic_complements->where(function($economic_complements) use ($request,$procedure_id)
                {
                    $applicants_identitycard=trim($request->get('affiliate_identitycard'));
                    $beneficiarios =EconomicComplementApplicant::identitycardIs($applicants_identitycard)->get();

                    $ids = array();
                    foreach ($beneficiarios as $beneficiario) {
                        # code...
                        array_push($ids, $beneficiario->economic_complement_id);

                    }
                    //Log::info($ids);


                   if($beneficiarios){

                       $economic_complements->whereIn('id',$ids);
                       // $economic_complements->where('id', '=' , "{$applicants->economic_complement_id}")->where('eco_com_procedure_id','=',$procedure_id);
                   }
                   else{
                       $economic_complements->where('affiliate_id', 0);
                   }

                });
            }


        }
        if ($request->has('eco_com_state_id'))
        {
            if($procedure_id){

                $economic_complements->where(function($economic_complements) use ($request,$procedure_id)
                {
                    $eco_com_state_id = trim($request->get('eco_com_state_id'));
                    $economic_complements->where('eco_com_state_id', '=', "{$eco_com_state_id}")->where('eco_com_procedure_id','=',$procedure_id);
                });

            }else
            {
                $economic_complements->where(function($economic_complements) use ($request)
                {
                    $eco_com_state_id = trim($request->get('eco_com_state_id'));
                    $economic_complements->where('eco_com_state_id', '=', "{$eco_com_state_id}");
                });

            }

        }

        if($request->has('eco_com_type'))
        {
            if ($request->has('eco_com_modality_id'))
            {
                if($procedure_id)
                {
                    $economic_complements->where(function($economic_complements) use ($request,$procedure_id)
                    {
                        $eco_com_modality_id = trim($request->get('eco_com_modality_id'));
                        if ($eco_com_modality_id >0) {
                            $economic_complements->where('eco_com_modality_id', '=', "{$eco_com_modality_id}")->where('eco_com_procedure_id','=',$procedure_id);
                        }
                    });
                }else
                {
                    $economic_complements->where(function($economic_complements) use ($request)
                    {
                        $eco_com_modality_id = trim($request->get('eco_com_modality_id'));
                        if ($eco_com_modality_id >0) {
                            $economic_complements->where('eco_com_modality_id', '=', "{$eco_com_modality_id}");
                        }
                    });
                }

            }else
            {
                //en caso de que la busqueda solo sea por eco_com_type
              // Log::info("buscando solo por eco_com_type");
                if($procedure_id)
                {

                     $economic_complements->join('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                            ->where('eco_com_modalities.eco_com_type_id','=',$request->get('eco_com_type'))
                                            ->where('eco_com_procedure_id','=',$procedure_id)
                                            ->select(['economic_complements.id','economic_complements.affiliate_id','economic_complements.eco_com_modality_id','economic_complements.eco_com_state_id','economic_complements.code','economic_complements.created_at','economic_complements.reception_date','economic_complements.total','economic_complements.wf_current_state_id','economic_complements.city_id','economic_complements.eco_com_procedure_id']);

                }else
                {

                     $economic_complements->join('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                            ->where('eco_com_modalities.eco_com_type_id','=',$request->get('eco_com_type'))
                                            ->select(['economic_complements.id','economic_complements.affiliate_id','economic_complements.eco_com_modality_id','economic_complements.eco_com_state_id','economic_complements.code','economic_complements.created_at','economic_complements.reception_date','economic_complements.total','economic_complements.wf_current_state_id'.'economic_complements.city_id','economic_complements.eco_com_procedure_id']);
                }
                //Log::info($economic_complements->get());
            }
        }


        return Datatables::of($economic_complements)
        ->addColumn('affiliate_identitycard', function ($economic_complement) {return $economic_complement->economic_complement_applicant->city_identity_card_id ? $economic_complement->economic_complement_applicant->identity_card.' '.$economic_complement->economic_complement_applicant->city_identity_card->first_shortened: $economic_complement->economic_complement_applicant->identity_card; })

        ->addColumn('city',function($conomic_complement){ return $conomic_complement->city->name; })
        ->addColumn('procedure',function($economic_complement){ $procedure = EconomicComplementProcedure::find($economic_complement->eco_com_procedure_id);
                                                                    return    substr($procedure->year, 0, -6).' '.$procedure->semester; })
        ->addColumn('pension',function($economic_complement){ return $economic_complement->affiliate->pension_entity->name; })
        ->addColumn('affiliate_name', function ($economic_complement) { return $economic_complement->economic_complement_applicant->getTittleName(); })
        ->editColumn('created_at', function ($economic_complement) { return $economic_complement->getCreationDate(); })
        ->editColumn('eco_com_state', function ($economic_complement) { return $economic_complement->economic_complement_state ? $economic_complement->economic_complement_state->economic_complement_state_type->name . " " . $economic_complement->economic_complement_state->name : $economic_complement->wf_state->name; })
        ->editColumn('eco_com_modality', function ($economic_complement) { return $economic_complement->economic_complement_modality->economic_complement_type->name . " " . $economic_complement->economic_complement_modality->name; })
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

    public function Data_by_affiliate(Request $request)
    {
        $economic_complements = EconomicComplement::where('affiliate_id', $request["id"])->select(['id', 'affiliate_id', 'eco_com_modality_id', 'wf_current_state_id','eco_com_state_id', 'code', 'reception_date', 'total'])->orderBy('id','desc');
        return Datatables::of($economic_complements)
        ->editColumn('created_at', function ($economic_complement) { return $economic_complement->getCreationDate(); })
        ->editColumn('wf_state', function ($economic_complement) { return $economic_complement->wf_state->name; })
        ->editColumn('state', function ($economic_complement) {
            try {
                    // Log::info("id complemento: ". $economic_complement->id);
                    $state = DB::table('eco_com_states')->where('id','=',$economic_complement->eco_com_state_id)->first();
                    // Log::info(json_encode($state));
                    if($state)
                    {
                        return $state->name;
                    }
                    else
                    {
                        // Log::info("vacio XD");
                        return "";
                    }
                    // return  $state->name;
            } catch (Exception $e) {
                 Log::info(json_encode("Error: en Datatables check  function Data_by_affiliate  in EconomicComplementController "));
                return '';
            }
             })
        ->addColumn('total',function($economic_complement){ return $economic_complement->total; })
        ->addColumn('action', function ($economic_complement) { return
            '<div class="btn-group" style="margin:-3px 0;">
                <a href="/economic_complement/'.$economic_complement->id.'" class="btn btn-primary btn-raised btn-sm">&nbsp;&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;</a>
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
        $eco_com_types_list = ['' => ''];
        foreach ($eco_com_types as $item) {
            $eco_com_types_list[$item->id]=$item->name;
        }

        $cities = City::all();
        $cities_list = ['' => ''];
        foreach ($cities as $item) {
            $cities_list[$item->id]=$item->name;
        }

        $cities_list_short = ['' => ''];
        foreach ($cities as $item) {
            $cities_list_short[$item->id]=$item->first_shortened;
        }

        $pension_entities = PensionEntity::all();
        $pension_entities_list = ['' => ''];
        foreach ($pension_entities as $item) {
            $pension_entities_list[$item->id]=$item->name;
        }

        $semestre = ['F' => 'Primer', 'S' => 'Segundo'];
        foreach ($semestre as $item) {
            $semester_list[$item]=$item;
        }

        $moduleObservation=Auth::user()->roles()->first()->module->id;
        $observations_types = $moduleObservation == 1 ? ObservationType::all() : ObservationType::where('module_id',$moduleObservation)->get();
        $observation_types_list = array('' => '');
                foreach ($observations_types as $item) {
                    $observation_types_list[$item->id]=$item->name;
                }

        return [
            'eco_com_states_list' => $eco_com_states_list,
            'eco_com_types_list' => $eco_com_types_list,
            'semester_list' => $semester_list,
            'pension_entities_list' => $pension_entities_list,
            'cities_list' => $cities_list,
            'cities_list_short' => $cities_list_short,
            'observations_types' => $observation_types_list,
            // 'affi_observations' => $affi_observations,
        ];
    }

    public function ReceptionFirstStep($affiliate_id)
    {
        $getViewModel = self::getViewModel();

        $affiliate = Affiliate::idIs($affiliate_id)->first();

        $economic_complement = EconomicComplement::affiliateIs($affiliate_id)
        ->whereYear('year', '=', Carbon::now()->year)
        ->where('semester', '=', Util::getSemester(Carbon::now()))->first();
        if (!$economic_complement) {
            $economic_complement = new EconomicComplement;
            $eco_com_type = false;
            $eco_com_modality = false;
            $economic_complement->semester =  Util::getSemester(Carbon::now());
            $economic_complement->year = Carbon::now()->year;
        }else{
            $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type->name;
            $eco_com_modality = $economic_complement->economic_complement_modality->name;
        }

        $last_year = Carbon::now()->subYear()->year;
        $last_semester = Util::getSemester(Carbon::now()->subMonth(7));
        if (EconomicComplement::affiliateIs($affiliate_id)
            ->whereYear('year', '=', $last_year)
            ->where('semester', '=', $last_semester)->first()) {
            $affiliate->type_ecocom = 'Habitual';
    }else{
        $affiliate->type_ecocom = 'Inclusión';
    }

        if (Util::getCurrentSemester() == 'Primer') {
            $last_semester_first = 'Segundo';
            $last_semester_second = 'Primer';
            $last_year_first = Carbon::now()->year - 1;
            $last_year_second = $last_year_first;
        }else{
            $last_semester_first = 'Primer';
            $last_semester_second = 'Segundo';
            $last_year_first = Carbon::now()->year ;
            $last_year_second = $last_year_first -1;
        }
        $eco_com_reception_type = 'Inclusion';
        $last_procedure_second = EconomicComplementProcedure::whereYear('year', '=', $last_year_second)->where('semester','like',$last_semester_second)->first();
        if (sizeof($last_procedure_second)>0) {
            if ($last_procedure_second->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $eco_com_reception_type = 'Habitual';
            }
        }
        $last_procedure_first = EconomicComplementProcedure::whereYear('year', '=', $last_year_first)->where('semester','like',$last_semester_first)->first();
        if (sizeof($last_procedure_first)>0) {
            if ($last_procedure_first->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $eco_com_reception_type = 'Habitual';
            }
        }
        $reception_types =  array('Inclusion' => 'Inclusion', 'Habitual' => 'Habitual');
        $data = [
            'affiliate' => $affiliate,
            'eco_com_type' => $eco_com_type,
            'eco_com_modality' => $eco_com_modality,
            'economic_complement' => $economic_complement,
            'reception_types' => $reception_types,
            'eco_com_reception_type' => $eco_com_reception_type
        ];

        $data = array_merge($data, $getViewModel);

        return view('economic_complements.reception_first_step', $data);
    }

    public function ReceptionSecondStep($economic_complement_id)
    {
        $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();

        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();

        $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

        if ($economic_complement->has_legal_guardian) {
            $eco_com_legal_guardian = EconomicComplementLegalGuardian::economicComplementIs($economic_complement->id)->first();
        }else{
            $eco_com_legal_guardian = '';
        }
        $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type;
        $eco_com_modality = $economic_complement->economic_complement_modality;

        if ($eco_com_applicant->gender == 'M') {
            $gender_list = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];
        }elseif ($eco_com_applicant->gender == 'F') {
            $gender_list = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];
        }

        if($affiliate->nua == null){
            $affiliate->nua=0;
        }

        $last_year = Carbon::now()->subYear()->year;
        $last_semester = Util::getSemester(Carbon::now()->subMonth(7));
        if (EconomicComplement::affiliateIs($affiliate->id)
            ->whereYear('year', '=', $last_year)
            ->where('semester', '=', $last_semester)->first()) {
            $affiliate->type_ecocom = 'Habitual';
    }else{
        $affiliate->type_ecocom = 'Inclusión';
    }

    $data = [

    'affiliate' => $affiliate,
    'eco_com_type' => $eco_com_type->name,
    'eco_com_modality' => $eco_com_modality->name,
    'economic_complement' => $economic_complement,
    'eco_com_applicant' => $eco_com_applicant,
    'eco_com_legal_guardian' => $eco_com_legal_guardian,
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

        $eco_com_modality = $economic_complement->economic_complement_modality;

        $eco_com_submitted_documents = EconomicComplementSubmittedDocument::with('economic_complement_requirement')->economicComplementIs($economic_complement->id)->get();

        if (EconomicComplementSubmittedDocument::economicComplementIs($economic_complement->id)->first()) {
            $status_documents = TRUE;
        }else{
            $status_documents = FALSE;
        }

        if ($economic_complement->reception_type == 'Habitual') {
            if ($economic_complement->economic_complement_modality->economic_complement_type->name== 'Viudedad') {
                $eco_com_requirements = EconomicComplementRequirement::where(function ($query)
                {
                    $query->where('id','=',6)
                    ->orWhere('id','=',8)
                    ->orWhere('id','=',13);
                })->orderBy('id','asc')->get();

            }else{
                $eco_com_requirements = EconomicComplementRequirement::economicComplementTypeIs($eco_com_type->id)->orderBy('id', 'asc')->take(2)->get();
            }
        }else{
            $eco_com_requirements = EconomicComplementRequirement::economicComplementTypeIs($eco_com_type->id)->get();
        }
        $data = [
            'affiliate' => $affiliate,
            'economic_complement' => $economic_complement,
            'eco_com_type' => $eco_com_type->name,
            'eco_com_modality' => $eco_com_modality->name,
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

            $eco_com_pro = EconomicComplementProcedure::where('year','=',Util::datePickYear(Carbon::now()->year))->where('semester','=',Util::getCurrentSemester())->first();

            $economic_complement = EconomicComplement::affiliateIs($affiliate->id)
            ->whereYear('year', '=', Carbon::now()->year)
            ->where('semester', '=', Util::getSemester(Carbon::now()))->first();

            $eco_com_modality = EconomicComplementModality::typeidIs(trim($request->eco_com_type))->first();

            if (!$economic_complement) {
                $economic_complement = new EconomicComplement;
                if ($last_economic_complement = EconomicComplement::whereYear('year', '=', Carbon::now()->year)
                    ->where('semester', '=', Util::getSemester(Carbon::now()))
                    ->whereNull('deleted_at')->orderBy('id', 'desc')->first()) {
                        $number_code = Util::separateCode($last_economic_complement->code);
                        $code = $number_code + 1;
                }else{
                        $code = 1;
                }

                $sem='';
                if(Util::getSemester(Carbon::now())=='Primer'){
                    $sem='P';
                }else{
                    $sem='S';
                }

                $economic_complement->user_id = Auth::user()->id;
                $economic_complement->affiliate_id = $affiliate->id;
                $economic_complement->eco_com_modality_id = $eco_com_modality->id;
                $economic_complement->eco_com_procedure_id = $eco_com_pro->id;
                $economic_complement->workflow_id = 1;
                $economic_complement->wf_current_state_id = 1;
                $economic_complement->city_id = trim($request->city);
                $economic_complement->category_id = $affiliate->category_id;

                $economic_complement->state = 'Edited';

                $economic_complement->year = Util::datePickYear(Carbon::now()->year, Util::getSemester(Carbon::now()));
                $economic_complement->semester = Util::getSemester(Carbon::now());
                if ($request->legal_guardian) { $economic_complement->has_legal_guardian = true; }else{
                    $economic_complement->has_legal_guardian = false;
                }
                $economic_complement->code = $code ."/". $sem . "/" . Carbon::now()->year;

                $economic_complement->reception_type = $request->reception_type;
                // $base_wage = BaseWage::degreeIs($affiliate->degree_id)->first();
                // $economic_complement->base_wage_id = $base_wage->id;
                // $complementary_factor = ComplementaryFactor::hierarchyIs($base_wage->degree->hierarchy->id)->whereYear('year', '=', Carbon::now()->year)->where('semester', '=', Util::getSemester(Carbon::now()))->first();
                // $economic_complement->complementary_factor_id = $complementary_factor->id;
                $economic_complement->save();
            }
            return $this->save($request, $economic_complement);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($economic_complement)
    {

        try {
            $state = EconomicComplementState::find($economic_complement->eco_com_state_id);

        } catch (Exception $e) {
            $state =null;
        }

        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();

        $eco_com_type = $economic_complement->economic_complement_modality;

        $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

        $eco_com_requirements = EconomicComplementRequirement::economicComplementTypeIs($eco_com_type->id)->get();

        $eco_com_submitted_documents = EconomicComplementSubmittedDocument::with('economic_complement_requirement')->economicComplementIs($economic_complement->id)->get();
        $eco_com_legal_guardian = EconomicComplementLegalGuardian::economicComplementIs($economic_complement->id)->first();

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

        $eco_com_states_block = EconomicComplementState::all();
        $eco_com_states_block_list =  ['' => ''];
        foreach ($eco_com_states_block as $item) {
            if($item->eco_com_state_type_id > 4){
                $eco_com_states_block_list[$item->id]=$item->name;
            }
        }

        $last_year = Carbon::now()->subYear()->year;
        $last_semester = Util::getSemester(Carbon::now()->subMonth(7));
        if (EconomicComplement::affiliateIs($affiliate->id)
                ->whereYear('year', '=', $last_year)
                ->where('semester', '=', $last_semester)->first()) {
                $affiliate->type_ecocom = 'Habitual';
        }else{
            $affiliate->type_ecocom = 'Inclusión';
        }

        $eco_com_state_type_list = EconomicComplementStateType::all();
        $eco_com_state_type_lists = [];
        foreach ($eco_com_state_type_list as $item) {
            $eco_com_state_type_lists[$item->id]=$item->name;
        }

        $ca=Category::all();
        $categories=[];
        foreach ($ca as $key=>$d) {
            if ($d->id != 9 && $d->id != 10) {
                $categories[$d->id]=$d->name;
            }
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

        $economic_complement_legal_guardian=$economic_complement->economic_complement_legal_guardian;
        $affi_observations = AffiliateObservation::where('affiliate_id',$affiliate->id)->first();
        if (EconomicComplement::where('affiliate_id', $affiliate->id)->whereYear('year','=', 2016)->where('semester','=', 'Segundo')->first()) {
               $last_ecocom = EconomicComplement::where('affiliate_id', $affiliate->id)->whereYear('year','=', 2016)->where('semester','=', 'Segundo')->first();

               if (EconomicComplementSubmittedDocument::economicComplementIs($last_ecocom->id)->first()) {
                   if ($last_ecocom->economic_complement_modality->economic_complement_type->name == 'Vejez') {
                       $eco_com_submitted_documents_ar = EconomicComplementSubmittedDocument::economicComplementIs($last_ecocom->id)->where(function ($query)
                       {
                           $query->where('eco_com_requirement_id','=',3)
                                 ->orWhere('eco_com_requirement_id','=',4)
                                 ->orWhere('eco_com_requirement_id','=',5);
                       })->orderBy('id','asc')->get();

                       $eco_com_requirements_ar = EconomicComplementRequirement::where(function ($query)
                       {
                           $query->where('id','=',3)
                                 ->orWhere('id','=',4)
                                 ->orWhere('id','=',5);
                       })->orderBy('id','asc')->get();

                   }else{
                       $eco_com_submitted_documents_ar = EconomicComplementSubmittedDocument::economicComplementIs($last_ecocom->id)->where(function ($query)
                       {
                           $query->where('eco_com_requirement_id','=',9)
                                 ->orWhere('eco_com_requirement_id','=',10)
                                 ->orWhere('eco_com_requirement_id','=',11)
                                 ->orWhere('eco_com_requirement_id','=',12);
                       })->orderBy('id','asc')->get();

                       $eco_com_requirements_ar = EconomicComplementRequirement::where(function ($query)
                       {
                           $query->where('id','=',9)
                                 ->orWhere('id','=',10)
                                 ->orWhere('id','=',11)
                                 ->orWhere('id','=',12);
                       })->orderBy('id','asc')->get();
                   }

                   $status_documents_ar = TRUE;
               }else{
                    if ($last_ecocom->economic_complement_modality->economic_complement_type->name == 'Vejez') {
                       $eco_com_requirements_ar = EconomicComplementRequirement::where(function ($query)
                       {
                           $query->where('id','=',2)
                                 ->orWhere('id','=',3)
                                 ->orWhere('id','=',4)
                                 ->orWhere('id','=',5);
                       })->orderBy('id','asc')->get();

                   }else{
                       $eco_com_requirements_ar = EconomicComplementRequirement::where(function ($query)
                       {
                           $query->where('id','=',7)
                                 ->orWhere('id','=',8)
                                 ->orWhere('id','=',9)
                                 ->orWhere('id','=',10)
                                 ->orWhere('id','=',11)
                                 ->orWhere('id','=',12);
                       })->orderBy('id','asc')->get();
                   }

                   $eco_com_submitted_documents_ar = null;
                   $status_documents_ar = FALSE;
               }
           }else{
               $eco_com_submitted_documents_ar = null;
               $eco_com_requirements_ar = null;
               $status_documents_ar = false;
               $last_ecocom = null;
        }
        //for documents submitted
        $status_eco_com_submitted_documents_ar=true;
        if ($eco_com_submitted_documents_ar) {
            $status_eco_com_submitted_documents_ar=true;
            foreach ($eco_com_submitted_documents_ar as $eco_com_submitted_document) {
                if (!$eco_com_submitted_document->status) {
                    $status_eco_com_submitted_documents_ar=false;
                    break;
                }
            }
        }else{
            $status_eco_com_submitted_documents_ar=false;
        }

        $data = [

        'affiliate' => $affiliate,
        'economic_complement' => $economic_complement,
        'eco_com_type' => $eco_com_type->shortened,
        'eco_com_applicant' => $eco_com_applicant,
        'eco_com_requirements' => $eco_com_requirements,
        'economic_complement_legal_guardian' => $economic_complement_legal_guardian,
        'eco_com_submitted_documents' => $eco_com_submitted_documents,
        'status_documents' => $status_documents,
        'gender_list' => $gender_list,
        'eco_com_states_block_list' => $eco_com_states_block_list,
        'eco_com_state_type_lists' => $eco_com_state_type_lists,
        'categories' => $categories,
        'degrees' => $degrees,
        //'type_eco_com' => $affiliate->type_ecocom,
        'affi_observations' => $affi_observations,
        'entity_pensions' => $entity_pensions,
        'eco_com_submitted_documents_ar' => $eco_com_submitted_documents_ar,
        'eco_com_requirements_ar' => $eco_com_requirements_ar,
        'status_documents_ar' => $status_documents_ar,
        'last_ecocom' => $last_ecocom,
        'state' => $state,
        'status_eco_com_submitted_documents_ar'=>$status_eco_com_submitted_documents_ar
        ];
        // dd($eco_com_submitted_documents_ar);

        // if ($economic_complement->base_wage_id) {
        //     $total_rent = $economic_complement->total_rent;
        //     $salary_reference = $economic_complement->base_wage->amount;
        //     $seniority = $economic_complement->category->percentage * $economic_complement->base_wage->amount;
        //     $salary_quotable = $salary_reference + $seniority;
        //     $difference = $salary_quotable - $total_rent;
        //     $months_of_payment = 6;
        //     $total_amount_semester = $difference * $months_of_payment;
        //     $complementary_factor = $eco_com_type->id == 1 ? $economic_complement->complementary_factor->old_age : $economic_complement->complementary_factor->widowhood;
        //     $total = $total_amount_semester * $complementary_factor/100;


        $second_data = [

        'sub_total_rent' => Util::formatMoney($economic_complement->sub_total_rent),
        'reimbursement' => Util::formatMoney($economic_complement->reimbursement),
        'dignity_pension' => Util::formatMoney($economic_complement->dignity_pension),
        'total_rent' => Util::formatMoney($economic_complement->total_rent),
        'total_rent_calc' => Util::formatMoney($economic_complement->total_rent_calc),
        'salary_reference' => Util::formatMoney($economic_complement->salary_reference),
        'seniority' => Util::formatMoney($economic_complement->seniority),
        'salary_quotable' => Util::formatMoney($economic_complement->salary_quotable),
        'difference' => Util::formatMoney($economic_complement->difference),
        'total_amount_semester' => Util::formatMoney($economic_complement->difference*6),
        'complementary_factor' => $economic_complement->complementary_factor,
        'total' => Util::formatMoney($economic_complement->total)

        ];

        $data = array_merge($data, $second_data);
        // }

        $data = array_merge($data, self::getViewModel());

        return view('economic_complements.view', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $economic_complement)
    {
        return $this->save($request, $economic_complement);
    }

    public function save($request, $economic_complement = false)
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
                $new_eco_com_modality = EconomicComplementModality::typeidIs(trim($request->eco_com_type))->first();
                if($new_eco_com_modality){
                    if($economic_complement->eco_com_modality_id <> $new_eco_com_modality->id){
                        $eco_com_submitted_document = EconomicComplementSubmittedDocument::where('economic_complement_id', '=', $economic_complement->id)->get();
                        foreach ($eco_com_submitted_document as $submitted_document) {
                            $submitted_document->delete();
                        }
                            // $eco_com_applicant->delete();
                            // $old_spouse = Spouse::affiliateidIs($request->affiliate_id)->first();
                            // if($old_spouse){
                            //     $old_spouse->delete();
                            // }
                            // $eco_com_applicant = new EconomicComplementApplicant;
                            // $eco_com_applicant->economic_complement_id = $economic_complement->id;
                    }
                }

                $affiliate = Affiliate::idIs($request->affiliate_id)->first();
                $affiliate->pension_entity_id = $request->pension_entity;
                $affiliate->save();

                $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

                if (!$eco_com_applicant) {
                    $eco_com_applicant = new EconomicComplementApplicant;
                    $eco_com_applicant->economic_complement_id = $economic_complement->id;
                }

                switch ($request->eco_com_type) {
                    case '1':
                    $eco_com_applicant->identity_card = $affiliate->identity_card;
                    $eco_com_applicant->city_identity_card_id = $affiliate->city_identity_card_id;
                    $eco_com_applicant->last_name = $affiliate->last_name;
                    $eco_com_applicant->mothers_last_name = $affiliate->mothers_last_name;
                    $eco_com_applicant->first_name = $affiliate->first_name;
                    $eco_com_applicant->second_name = $affiliate->second_name;
                    $eco_com_applicant->surname_husband = $affiliate->surname_husband;
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
                        $eco_com_applicant->second_name = $spouse->second_name;
                        $eco_com_applicant->surname_husband = $spouse->surname_husband;
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
                $eco_com_modality = EconomicComplementModality::typeidIs(trim($request->eco_com_type))->first();
                $economic_complement->eco_com_modality_id=$eco_com_modality->id;
                $economic_complement->city_id = trim($request->city);
                if ($request->legal_guardian) { $economic_complement->has_legal_guardian = true; }else{
                    $economic_complement->has_legal_guardian = false;
                }
                $economic_complement->state="Edited";
                $economic_complement->reception_type = $request->reception_type;
                $economic_complement->save();
                if ($request->legal_guardian) {
                    $eco_com_legal_guardian = EconomicComplementLegalGuardian::economicComplementIs($economic_complement->id)->first();

                    if (!$eco_com_legal_guardian) {

                        $eco_com_legal_guardian = new EconomicComplementLegalGuardian;
                        $eco_com_legal_guardian->economic_complement_id = $economic_complement->id;
                    }
                    $eco_com_legal_guardian->save();
                }

                return redirect('economic_complement_reception_second_step/'.$economic_complement->id);

            }

            break;

            case 'second':

            $rules = [

            ];

            $messages = [

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){
                return redirect('economic_complement_reception_second_step/' . $economic_complement->id)
                ->withErrors($validator)
                ->withInput();
            }
            else{
                //return "second";
                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();

                $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();

                $eco_com_applicant->identity_card = $request->identity_card;
                if ($request->city_identity_card_id) { $eco_com_applicant->city_identity_card_id = $request->city_identity_card_id; } else { $eco_com_applicant->city_identity_card_id = null; }
                $eco_com_applicant->last_name = $request->last_name;
                $eco_com_applicant->mothers_last_name = $request->mothers_last_name;
                $eco_com_applicant->first_name = $request->first_name;
                $eco_com_applicant->second_name = $request->second_name;
                $eco_com_applicant->surname_husband = $request->surname_husband;     
                $eco_com_applicant->gender = $request->gender;
                $eco_com_applicant->birth_date = Util::datePick($request->birth_date);
                $eco_com_applicant->civil_status = $request->civil_status;

                if ($request->applicant == 'update') {
                    $eco_com_applicant->phone_number = trim(implode(",", $request->phone_number_applicant));
                    $eco_com_applicant->cell_phone_number = trim(implode(",", $request->cell_phone_number_applicant));
                    $eco_com_applicant->date_death = Util::datePick($request->date_death);
                    $eco_com_applicant->reason_death = trim($request->reason_death);
                    $eco_com_applicant->death_certificate_number = trim($request->death_certificate_number);
                }else{
                    $eco_com_applicant->phone_number = trim(implode(",", $request->phone_number));
                    $eco_com_applicant->cell_phone_number = trim(implode(",", $request->cell_phone_number));
                }
                $eco_com_applicant->nua = ($request->nua == null) ? 0 : $request->nua;
                $eco_com_applicant->save();

                switch ($economic_complement->economic_complement_modality->economic_complement_type->id) {

                    case '1':
                    $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
                    $affiliate->identity_card = $request->identity_card;
                    if ($request->city_identity_card_id) { $affiliate->city_identity_card_id = $request->city_identity_card_id; } else { $affiliate->city_identity_card_id = null; }
                    $affiliate->last_name = $request->last_name;
                    $affiliate->mothers_last_name = $request->mothers_last_name;
                    $affiliate->city_birth_id = $request->city_birth_id == '' ? null: $request->city_birth_id;
                    $affiliate->first_name = $request->first_name;
                    $affiliate->second_name = $request->second_name;
                    $affiliate->surname_husband = $request->surname_husband;
                    $affiliate->nua = $request->nua;
                    $affiliate->gender = $request->gender;
                    $affiliate->civil_status = $request->civil_status;
                    $affiliate->birth_date = Util::datePick($request->birth_date);
                    $affiliate->date_death = Util::datePick($request->date_death);
                    $affiliate->reason_death = trim($request->reason_death);
                    $affiliate->death_certificate_number = trim($request->death_certificate_number);
                    if ($request->applicant == 'update') {
                        $affiliate->phone_number = trim(implode(",", $request->phone_number_applicant));
                        $affiliate->cell_phone_number = trim(implode(",", $request->cell_phone_number_applicant));
                    }else{
                        $affiliate->phone_number = trim(implode(",", $request->phone_number));
                        $affiliate->cell_phone_number = trim(implode(",", $request->cell_phone_number));
                    }
                    $affiliate->save();

                    break;

                    case '2':
                        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
                        if($request->type1 == 'update')
                        {
                            $spouse = Spouse::affiliateidIs($affiliate->id)->first();
                            if (!$spouse) { $spouse = new Spouse; }
                            $spouse->user_id = Auth::user()->id;
                            $spouse->affiliate_id = $affiliate->id;
                            $spouse->identity_card = trim($request->identity_card);
                            if ($request->city_identity_card_id) { $spouse->city_identity_card_id = $request->city_identity_card_id; } else { $spouse->city_identity_card_id = null; }
                            $spouse->last_name = trim($request->last_name);
                            $spouse->mothers_last_name = trim($request->mothers_last_name);
                            $spouse->first_name = trim($request->first_name);
                            $spouse->second_name = trim($request->second_name);
                            $spouse->civil_status = trim($request->civil_status);
                            $spouse->surname_husband = trim($request->surname_husband);      
                            $spouse->birth_date = Util::datePick($request->birth_date);
                            $spouse->date_death = Util::datePick($request->date_death);
                            $spouse->reason_death = trim($request->reason_death);
                            $spouse->death_certificate_number = trim($request->death_certificate_number);
                            $affiliate->nua = ($request->nua == null) ? 0 : $request->nua;
                            $spouse->registration=Util::CalcRegistration(Util::datePick($request->birth_date),trim($request->last_name),trim($request->mothers_last_name), trim($request->first_name),Util::getGender($affiliate->gender));
                            $spouse->save();
                            $affiliate->save();

                        }
                        else{
                            $affiliate->identity_card = $request->identity_card_affi;
                            if ($request->city_identity_card_id_affi) { $affiliate->city_identity_card_id = $request->city_identity_card_id_affi; } else { $affiliate->city_identity_card_id = null; }
                            $affiliate->last_name = $request->last_name_affi;
                            $affiliate->mothers_last_name = $request->mothers_last_name_affi;
                            $affiliate->first_name = $request->first_name_affi;
                            $affiliate->second_name = $request->second_name_affi;
                            $affiliate->birth_date = Util::datePick($request->birth_date_affi);
                            $affiliate->phone_number = trim(implode(",", $request->phone_number));
                            $affiliate->cell_phone_number = trim(implode(",", $request->cell_phone_number));
                            $affiliate->nua = ($request->nua == null) ? 0 : $request->nua;
                            $affiliate->save();

                            $spouse = Spouse::affiliateidIs($affiliate->id)->first();
                            if (!$spouse) { $spouse = new Spouse; }
                            $spouse->user_id = Auth::user()->id;
                            $spouse->affiliate_id = $affiliate->id;
                            $spouse->identity_card = trim($request->identity_card);
                            if ($request->city_identity_card_id) { $spouse->city_identity_card_id = $request->city_identity_card_id; } else { $spouse->city_identity_card_id = null; }
                            $spouse->last_name = trim($request->last_name);
                            $spouse->mothers_last_name = trim($request->mothers_last_name);
                            $spouse->first_name = trim($request->first_name);
                            $spouse->second_name = trim($request->second_name);
                            $spouse->birth_date = Util::datePick($request->birth_date);
                            $spouse->registration=Util::CalcRegistration(Util::datePick($request->birth_date),trim($request->last_name),trim($request->mothers_last_name), trim($request->first_name),Util::getGender($affiliate->gender));
                            $spouse->birth_date = Util::datePick($request->birth_date);
                            $spouse->date_death = Util::datePick($request->date_death);
                            $spouse->reason_death = trim($request->reason_death);
                            $spouse->death_certificate_number = trim($request->death_certificate_number);
                            $spouse->save();
                        }


                    break;

                    case '3':
                    if ($request->type1!='update') {

                        $rules = [
                            'age_eco_com_applicant' => 'integer|max:25'
                        ];

                        $messages = [
                            'age_eco_com_applicant.max' => 'El Huerfano no puede cobrar debido a que tiene mas de 25 anios'
                        ];

                        $age = ['age_eco_com_applicant' => $eco_com_applicant->getHowOldInt()];

                        $validator = Validator::make($age, $rules, $messages);

                        if($validator->fails())

                            return redirect('economic_complement_reception_second_step/' . $economic_complement->id)->withErrors($validator)->withInput();

                        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
                        $affiliate->identity_card = $request->identity_card_affi;
                        if ($request->city_identity_card_id_affi) {
                            $affiliate->city_identity_card_id = $request->city_identity_card_id_affi;
                        } else {
                            $affiliate->city_identity_card_id = null;
                        }
                        $affiliate->last_name = $request->last_name_affi;
                        $affiliate->mothers_last_name = $request->mothers_last_name_affi;
                        $affiliate->first_name = $request->first_name_affi;
                        $affiliate->second_name = $request->second_name_affi;
                        $affiliate->birth_date = Util::datePick($request->birth_date_affi);
                        $affiliate->phone_number = trim(implode(",", $request->phone_number));
                        $affiliate->cell_phone_number = trim(implode(",", $request->cell_phone_number));
                        $affiliate->nua = ($request->nua == null) ? 0 : $request->nua;
                        $affiliate->save();
                    }
                    break;
                }

                if ($economic_complement->has_legal_guardian) {
                             if($request->type != 'update'){
                                 $eco_com_legal_guardian = EconomicComplementLegalGuardian::economicComplementIs($economic_complement->id)->first();
                                 $eco_com_legal_guardian->identity_card = $request->identity_card_lg;
                                 if ($request->city_identity_card_id_lg) { $eco_com_legal_guardian->city_identity_card_id = $request->city_identity_card_id_lg; } else { $eco_com_legal_guardian->city_identity_card_id = null; }
                                 $eco_com_legal_guardian->last_name = $request->last_name_lg;
                                 $eco_com_legal_guardian->mothers_last_name = $request->mothers_last_name_lg;
                                 $eco_com_legal_guardian->first_name = $request->first_name_lg;
                                 $eco_com_legal_guardian->second_name = $request->second_name_lg;
                                 $eco_com_legal_guardian->surname_husband = $request->surname_husband_lg;
                                 $eco_com_legal_guardian->phone_number =trim(implode(",", $request->phone_number_lg));
                                 $eco_com_legal_guardian->cell_phone_number =trim(implode(",", $request->cell_phone_number_lg));
                                 $eco_com_legal_guardian->save();
                             }
                         }

                if ($request->type == 'update') {
                    return redirect('economic_complement/'.$economic_complement->id);
                }
                else{
                    return redirect('economic_complement_reception_third_step/'.$economic_complement->id);
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
                return redirect('economic_complement_reception_second_step/' . $economic_complement->id)
                ->withErrors($validator)
                ->withInput();
            }
            else{
                foreach (json_decode($request->data) as $item)
                {
                    $eco_com_submitted_document = EconomicComplementSubmittedDocument::where('economic_complement_id', '=', $economic_complement->id)
                    ->where('eco_com_requirement_id', '=', $item->id)->first();

                    if (!$eco_com_submitted_document) {
                        $eco_com_submitted_document = new EconomicComplementSubmittedDocument;
                        $eco_com_submitted_document->economic_complement_id = $economic_complement->id;
                        $eco_com_submitted_document->eco_com_requirement_id = $item->id;
                        $eco_com_submitted_document->status = $item->status;
                        $eco_com_submitted_document->reception_date = date('Y-m-d');
                        $eco_com_submitted_document->save();
                    }
                    elseif($eco_com_submitted_document->status <> $item->status){
                        $eco_com_submitted_document->status = $item->status;
                        $eco_com_submitted_document->reception_date = date('Y-m-d');
                        $eco_com_submitted_document->save();
                    }

                }

                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();
                $economic_complement->reception_date = date('Y-m-d');
                $economic_complement->save();

                return redirect('economic_complement/'.$economic_complement->id);

            }

            break;
            case 'requirements':

                    $rules = [

                    ];

                    $messages = [

                    ];

                    $validator = Validator::make($request->all(), $rules, $messages);
                    if ($validator->fails()){
                        return redirect('affiliate/' . $economic_complement->id)
                        ->withErrors($validator)
                        ->withInput();
                    }
                    else
                    {
                        foreach (json_decode($request->data) as $item)
                        {
                            $eco_com_submitted_document = EconomicComplementSubmittedDocument::where('economic_complement_id', '=', $economic_complement->id)
                            ->where('eco_com_requirement_id', '=', $item->id)->first();

                           if (!$eco_com_submitted_document) {
                                $eco_com_submitted_document = new EconomicComplementSubmittedDocument;
                                $eco_com_submitted_document->economic_complement_id = $economic_complement->id;
                                $eco_com_submitted_document->eco_com_requirement_id = $item->id;
                                $eco_com_submitted_document->status = $item->status;
                                $eco_com_submitted_document->reception_date = date('Y-m-d');
                                $eco_com_submitted_document->save();
                            }
                            elseif($eco_com_submitted_document->status <> $item->status )
                            {
                                $eco_com_submitted_document->comment = "Documentos del segundo Semestre del 2016";
                                $eco_com_submitted_document->status = $item->status;
                                $eco_com_submitted_document->reception_date = date('Y-m-d');
                                $eco_com_submitted_document->save();
                            }
                        }
                        if ($request->ecocom) {

                        return redirect('economic_complement/'.$request->ecocom);
                        }
                        return redirect('affiliate/'.$economic_complement->affiliate_id);
                    }
            break;

            case 'block':

            $rules = [

            ];

            $messages = [

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){
                return redirect('economic_complement/' . $economic_complement->id)
                ->withErrors($validator)
                ->withInput();
            }
            else{

                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();
                $economic_complement->eco_com_state_id = $request->eco_com_state_id;
                $economic_complement->save();

                return redirect('economic_complement/'.$economic_complement->id);

            }

            break;

            case 'edit_aditional_info':

            $rules = [

            ];

            $messages = [

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){
                return redirect('economic_complement/' . $economic_complement->id)
                ->withErrors($validator)
                ->withInput();
            }
            else{

                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();



                return redirect('economic_complement/'.$economic_complement->id);

            }



            break;

            case 'pass':

            $rules = [

            ];

            $messages = [

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){
                return redirect('economic_complement/' . $economic_complement->id)
                ->withErrors($validator)
                ->withInput();
            }
            else{

                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();
                //$economic_complement->eco_com_state_id = 2;
                $economic_complement->user_id = Auth::user()->id;
                $economic_complement->review_date = date('Y-m-d');
                $economic_complement->state = 'Edited';
                $economic_complement->save();
                //Log::info($economic_complement);
                // return redirect('inbox');
                return redirect('economic_complement');
                // return redirect('economic_complement/'.$economic_complement->id);

            }

            break;
            case 'revert':
                $rules = [
                ];
                $messages = [
                ];

                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()){
                    return redirect('economic_complement/' . $economic_complement->id)
                    ->withErrors($validator)
                    ->withInput();
                }
                else{
                    $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();
                    $economic_complement->user_id = Auth::user()->id;
                    $economic_complement->review_date = null;
                    $economic_complement->state = 'Received';
                    $economic_complement->save();
                    return redirect('economic_complement');
                }

            break;

          case 'rent':
          $rules = [
            ];
            $messages = [
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()){
                //dd("error");
                return redirect('economic_complement/' . $economic_complement->id)
                ->withErrors($validator)
                ->withInput();
            }
            else{
                //send from request data
                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();

                EconomicComplement::calculate($economic_complement,$request->total_rent, $request->sub_total_rent, $request->reimbursement, $request->dignity_pension, $request->aps_total_fsa, $request->aps_total_cc, $request->aps_total_fs);
                //$economic_complement->state = 'Edited';
                $economic_complement->rent_type = 'Manual';
                $economic_complement->calculation_date = Carbon::now();
                $economic_complement->save();
                    /*$total_rent = floatval(str_replace(',','',$request->sub_total_rent))-floatval(str_replace(',','',$request->reimbursement))-floatval(str_replace(',','',$request->dignity_pension));

                    //for aps
                    if($economic_complement->affiliate->pension_entity->type=='APS'){
                        $comp=0;
                        if (floatval(str_replace(',','',$request->aps_total_fsa)) > 0) {
                            $comp++;
                        }if (floatval(str_replace(',','',$request->aps_total_cc)) > 0) {
                            $comp++;
                        }if (floatval(str_replace(',','',$request->aps_total_fs)) > 0) {
                            $comp++;
                        }
                        $economic_complement->aps_total_fsa=floatval(str_replace(',','',$request->aps_total_fsa));
                        $economic_complement->aps_total_cc=floatval(str_replace(',','',$request->aps_total_cc));
                        $economic_complement->aps_total_fs=floatval(str_replace(',','',$request->aps_total_fs));
                        //vejez
                        if ($economic_complement->economic_complement_modality->economic_complement_type->id == 1)
                        {
                            if ($comp == 1 && $total_rent >= 2000)
                            {
                               $economic_complement->eco_com_modality_id = 4;
                            }
                            elseif ($comp == 1 && $total_rent < 2000)
                            {
                               $economic_complement->eco_com_modality_id = 6;
                            }
                            elseif ($comp > 1 && $total_rent < 2000)
                            {
                               $economic_complement->eco_com_modality_id = 8;
                            }else
                            {
                               $economic_complement->eco_com_modality_id = 1;
                            }
                        }
                        //Viudedad
                        if ($economic_complement->economic_complement_modality->economic_complement_type->id == 2)
                        {
                            if($comp == 1 && $total_rent >= 2000)
                            {
                                $economic_complement->eco_com_modality_id = 5;
                            }
                            elseif ($comp == 1 && $total_rent < 2000)
                            {
                                 $economic_complement->eco_com_modality_id = 7;
                            }
                            elseif ($comp > 1 && $total_rent < 2000 )
                            {
                                $economic_complement->eco_com_modality_id = 9;
                            }else
                            {
                                $economic_complement->eco_com_modality_id = 2;
                            }
                        }
                        //orfandad
                        if ($economic_complement->economic_complement_modality->economic_complement_type->id == 3)
                        {
                            if ($comp == 1 && $total_rent >= 2000)
                            {
                               $economic_complement->eco_com_modality_id = 10;
                            }
                            elseif ($comp == 1 && $total_rent < 2000)
                            {
                               $economic_complement->eco_com_modality_id = 11;
                            }
                            elseif ($comp > 1 && $total_rent < 2000)
                            {
                               $economic_complement->eco_com_modality_id = 12;
                            }else{
                               $economic_complement->eco_com_modality_id = 3;
                            }
                        }
                    }else{
                        //Senasir
                        if($economic_complement->economic_complement_modality->economic_complement_type->id == 1 && $total_rent < 2000)  //Vejez
                        {
                          $economic_complement->eco_com_modality_id = 8;
                        }
                        elseif ($economic_complement->economic_complement_modality->economic_complement_type->id == 2 && $total_rent < 2000) //Viudedad
                        {
                          $economic_complement->eco_com_modality_id = 9;
                        }
                        elseif($economic_complement->economic_complement_modality->economic_complement_type->id == 3 && $total_rent < 2000) //Orfandad
                        {
                            $economic_complement->eco_com_modality_id = 12;
                        }else {
                            $economic_complement->eco_com_modality_id = $economic_complement->economic_complement_modality->economic_complement_type->id;
                        }
                    }
                    $economic_complement->total_rent = $total_rent;
                    $economic_complement->save();

                    $economic_complement->total_rent_calc = $total_rent;

                    //para el promedio
                    if ($economic_complement->eco_com_modality_id>3) {
                        $economic_complement_rent = EconomicComplementRent::where('degree_id','=',$economic_complement->affiliate->degree->id)
                            ->where('eco_com_type_id','=',$economic_complement->economic_complement_modality->economic_complement_type->id)
                            ->whereYear('year','=',Carbon::parse($economic_complement->year)->year)
                            ->where('semester','=',$economic_complement->semester)
                            ->first();
                        $total_rent=$economic_complement_rent->average;
                        $economic_complement->total_rent_calc = $economic_complement_rent->average;

                    }
                    $base_wage = BaseWage::degreeIs($economic_complement->affiliate->degree_id)->whereYear('month_year','=',Carbon::parse($economic_complement->year)->year)->first();
                    if ($economic_complement->economic_complement_modality->economic_complement_type->id==2) {
                        $base_wage_amount=$base_wage->amount*(80/100);
                        $salary_reference = $base_wage_amount;
                        $seniority = $economic_complement->category->percentage * $base_wage_amount;
                    }else{
                        $salary_reference = $base_wage->amount;
                        $seniority = $economic_complement->category->percentage * $base_wage->amount;
                    }

                    $economic_complement->seniority=$seniority;
                    $salary_quotable = $salary_reference + $seniority;
                    $economic_complement->salary_quotable=$salary_quotable;
                    $difference = $salary_quotable - $total_rent;
                    $economic_complement->difference=$difference;
                    $months_of_payment = 6;
                    $total_amount_semester = $difference * $months_of_payment;
                    $economic_complement->total_amount_semester=$total_amount_semester;
                    //$complementary_factor = $eco_com_type->id == 1 ? $economic_complement->complementary_factor->old_age : $economic_complement->complementary_factor->widowhood;
                //     $total = $total_amount_semester * $complementary_factor/100;
                $economic_complement->sub_total_rent=floatval(str_replace(',','',$request->sub_total_rent));
                $economic_complement->reimbursement=floatval(str_replace(',','',$request->reimbursement));
                $economic_complement->dignity_pension=floatval(str_replace(',','',$request->dignity_pension));
                //$economic_complement->total_rent=floatval($request->sub_total_rent)-floatval($request->reimbursement)-floatval($request->dignity_pension);
                //$affiliate=Affiliate::find(52444);
                $complementary_factor = ComplementaryFactor::hierarchyIs($base_wage->degree->hierarchy->id)
                                            ->whereYear('year', '=', Carbon::parse($economic_complement->year)->year)
                                            ->where('semester', '=', $economic_complement->semester)->first();
                $economic_complement->complementary_factor_id = $complementary_factor->id;
                if ($economic_complement->economic_complement_modality->eco_com_type_id == 2 ) {
                    //viudedad
                    $complementary_factor=$complementary_factor->widowhood;
                }else{
                    //vejez
                    $complementary_factor=$complementary_factor->old_age;
                }
                $economic_complement->complementary_factor=$complementary_factor;
                $total = $total_amount_semester * floatval($complementary_factor)/100;
                $economic_complement->total=$total;
                $economic_complement->base_wage_id = $base_wage->id;
                $economic_complement->salary_reference=$salary_reference;
                $economic_complement->state = 'Edited';
                $economic_complement->save();*/
                //dd($economic_complement);
                return redirect('economic_complement/'.$economic_complement->id);
            }
        break;
        case 'legal_guardian':
            $eco_com_legal_guardian = EconomicComplementLegalGuardian::economicComplementIs($economic_complement->id)->first();
              $eco_com_legal_guardian->identity_card = $request->identity_card_lg;
              if ($request->city_identity_card_id_lg) { $eco_com_legal_guardian->city_identity_card_id = $request->city_identity_card_id_lg; } else { $eco_com_legal_guardian->city_identity_card_id = null; }
              $eco_com_legal_guardian->last_name = $request->last_name_lg;
              $eco_com_legal_guardian->mothers_last_name = $request->mothers_last_name_lg;
              $eco_com_legal_guardian->first_name = $request->first_name_lg;
              $eco_com_legal_guardian->second_name = $request->second_name_lg;
              $eco_com_legal_guardian->surname_husband = $request->surname_husband_lg;
              $eco_com_legal_guardian->phone_number =trim(implode(",", $request->phone_number_lg));
              $eco_com_legal_guardian->cell_phone_number =trim(implode(",", $request->cell_phone_number_lg));
              $eco_com_legal_guardian->save();
              return redirect('economic_complement/'.$economic_complement->id);
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

    public function print_sworn_declaration($economic_complement_id,$type)
    {
      $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
      $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
      $title = "FORMULARIO DE DECLARACIÓN JURADA VOLUNTARIA";
      $date = Util::getDateEdit(date('Y-m-d'));
      $current_date = Carbon::now();
      $hour = Carbon::parse($current_date)->toTimeString();
      $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();
      $affiliate = Affiliate::where('id',$economic_complement->affiliate_id)->first();
      $eco_com_applicant = EconomicComplementApplicant::EconomicComplementIs($economic_complement->id)->first();
        switch ($type) {
            case 'vejez':
                $view = \View::make('economic_complements.print.sworn_declaration1', compact('header1','header2','title','date','hour','affiliate','economic_complement','eco_com_applicant'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
            case 'viudedad':
                $spouse = Spouse::where('affiliate_id',$affiliate->id)->first();
                $view = \View::make('economic_complements.print.sworn_declaration2', compact('header1','header2','title','date','hour','affiliate','spouse','economic_complement','eco_com_applicant'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
        }

    }

    public function print_eco_com_reports($economic_complement_id,$type)
    {
      $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
      $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
      $date = Util::getDateEdit(date('Y-m-d'));
      $current_date = Carbon::now();
      $user = Auth::user();
      $hour = Carbon::parse($current_date)->toTimeString();
      $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();
      $eco_com_submitted_document = EconomicComplementSubmittedDocument::economicComplementIs($economic_complement->id)->get();
      $affiliate = Affiliate::where('id',$economic_complement->affiliate_id)->first();
      $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement_id)->first();
      $yearcomplement=new Carbon($economic_complement->year);
      if($economic_complement->economic_complement_modality->economic_complement_type->name=='Viudedad'){
          $applicant_type=$eco_com_applicant->gender=='F' ? "VIUDA" : "VIUDO";
      }
      if($economic_complement->economic_complement_modality->economic_complement_type->name=='Orfandad'){
        $applicant_type=$eco_com_applicant->gender=='F' ? "HUERFANA" : "HUERFANO";
      }
      if($economic_complement->economic_complement_modality->economic_complement_type->name=='Vejez'){
          $applicant_type="TITULAR";
      }

        switch ($type) {
            case 'report':
                $title= "RECEPCIÓN DE REQUISITOS";
                $view = \View::make('economic_complements.print.reception_report', compact('header1', 'header2', 'title','date','hour','economic_complement','eco_com_submitted_document','affiliate','eco_com_applicant','user','yearcomplement'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();

            case 'inclusion':
                $title= "";
                $view = \View::make('economic_complements.print.inclusion_solicitude', compact('header1','header2','title','date','hour','economic_complement','eco_com_submitted_document','affiliate','eco_com_applicant','applicant_type', 'user'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();

            case 'habitual':
                $title= "";
                $view = \View::make('economic_complements.print.habitual_solicitude', compact('header1','header2','title','date','hour','economic_complement','eco_com_submitted_document','affiliate','eco_com_applicant','applicant_type', 'user'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();
        }

    }

    public function getCausesByState(Request $request)
    {
        if($request->ajax())
        {
            $causesState = EconomicComplementState::where('eco_com_state_type_id',$request->id)->get();
            $data = [
            'causes' => $causesState
            ];
            return response()->json($data);
        }
    }

    public function get_record(Request $request)
    {
        $records = WorkflowRecord::select(['date', 'message'])->where('eco_com_id', $request->id)->orderBy('created_at', 'desc');

        return Datatables::of($records)
            ->editColumn('date',function ($record){
                return Util::getDateShort($record->date);
            })
            ->make(true);
    }
    public function getReceptionType(Request $request)
    {
        $reception_type = $this->receptionType($request->affiliate_id, $request->modality_id);
        return response()->json(['modality_name'=>$reception_type]);
    }
    public function receptionType($affiliate_id, $new_modality_id)
    {
        if (Util::getCurrentSemester() == 'Primer') {
            $last_semester_first = 'Segundo';
            $last_semester_second = 'Primer';
            $last_year_first = Carbon::now()->year - 1;
            $last_year_second = $last_year_first;
        }else{
            $last_semester_first = 'Primer';
            $last_semester_second = 'Segundo';
            $last_year_first = Carbon::now()->year ;
            $last_year_second = $last_year_first -1;
        }
        $reception_type = 'Inclusion';
        $last_procedure_second = EconomicComplementProcedure::whereYear('year', '=', $last_year_second)->where('semester','like',$last_semester_second)->first();
        if (sizeof($last_procedure_second)>0) {
            if ($old_eco = $last_procedure_second->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $reception_type = 'Habitual';
                if ($old_eco->economic_complement_modality->economic_complement_type->id == 1 && ($new_modality_id == 2 || $new_modality_id == 3)) {
                    $reception_type = 'Inclusion';
                }elseif ($old_eco->economic_complement_modality->economic_complement_type->id == 2 &&  $new_modality_id == 3) {
                        $reception_type = 'Inclusion';
                }
            }
        }
        $last_procedure_first = EconomicComplementProcedure::whereYear('year', '=', $last_year_first)->where('semester','like',$last_semester_first)->first();
        if (sizeof($last_procedure_first)>0) {
            if ($old_eco = $last_procedure_first->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $reception_type = 'Habitual';
                if ($old_eco->economic_complement_modality->economic_complement_type->id == 1 && ($new_modality_id == 2 || $new_modality_id == 3)) {
                    $reception_type = 'Inclusion';
                }elseif ($old_eco->economic_complement_modality->economic_complement_type->id == 2 &&  $new_modality_id == 3) {
                        $reception_type = 'Inclusion';
                }
            }
        }
        return $reception_type;
    }
}
