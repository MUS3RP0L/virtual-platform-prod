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
use Muserpol\EconomicComplementObservation;
use Muserpol\EconomicComplementRecord;
use Muserpol\Devolution;

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
use Muserpol\WorkflowSequence;
use Muserpol\WorkflowState;
use Muserpol\Month;
use Maatwebsite\Excel\Facades\Excel;

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
        $procedures_e = EconomicComplementProcedure::orderBy('id','desc')->get();
        
        $procedures =   ['' => ''];

        foreach ($procedures_e as $procedure) {
            # code...
            array_push($procedures, [''.$procedure->id => ''.substr($procedure->year, 0, -6).' '.$procedure->semester]);
        }

        $data = [
            'year' => Util::getCurrentYear(),
            'semester' => Util::getCurrentSemester(),
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
        // $economic_complements = EconomicComplement::select(['id', 'affiliate_id',
        //     'eco_com_modality_id', 'eco_com_state_id', 'code', 'created_at','reception_date', 'total',
        //     'wf_current_state_id','city_id','eco_com_procedure_id'])->orderBy('created_at','desc');


        $economic_complements = EconomicComplement::
            select(['economic_complements.id', 
                    'economic_complements.affiliate_id',
                    'economic_complements.eco_com_modality_id', 
                    'economic_complements.eco_com_state_id', 
                    'economic_complements.code', 
                    'economic_complements.created_at',
                    'economic_complements.reception_date', 
                    'economic_complements.total',
                    'economic_complements.wf_current_state_id',
                    'economic_complements.city_id',
                    'economic_complements.eco_com_procedure_id',
                    'eco_com_applicants.first_name',
                    'eco_com_applicants.last_name',
                    'eco_com_applicants.mothers_last_name'
                    ])
            //->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
            ->leftJoin('eco_com_applicants','eco_com_applicants.economic_complement_id','=','economic_complements.id')
            ->orderBy('created_at','desc');
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

                       $economic_complements->whereIn('economic_complements.id',$ids)->where('eco_com_procedure_id','=',$procedure_id);
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

                       $economic_complements->whereIn('economic_complements.id',$ids);
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
        if($request->has('affiliate_last_name')){
            $affiliate_last_name = trim($request->get('affiliate_last_name'));
            $economic_complements->where(function($economic_complements) use ($affiliate_last_name)
            {                    
                $economic_complements->where('last_name', 'like', "{$affiliate_last_name}%");
            });
        }
        if($request->has('affiliate_mothers_last_name')){
            $affiliate_mothers_last_name = trim($request->get('affiliate_mothers_last_name'));
            $economic_complements->where(function($economic_complements) use ($affiliate_mothers_last_name)
            {                    
                $economic_complements->where('mothers_last_name', 'like', "{$affiliate_mothers_last_name}%");
            });
        }
        if($request->has('affiliate_first_name')){
            $affiliate_first_name = trim($request->get('affiliate_first_name'));
            $economic_complements->where(function($economic_complements) use ($affiliate_first_name)
            {                    
                $economic_complements->where('first_name', 'like', "{$affiliate_first_name}%");
            });
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
        ->addColumn('affiliate_identitycard', function ($economic_complement) {return ($economic_complement->economic_complement_applicant->city_identity_card_id ?? null) ? ($economic_complement->economic_complement_applicant->identity_card ?? '' ).' '.($economic_complement->economic_complement_applicant->city_identity_card->first_shortened ?? '') : ($economic_complement->economic_complement_applicant->identity_card ?? ''); })

        ->addColumn('city',function($conomic_complement){ return $conomic_complement->city->name ?? ''; })
        ->addColumn('procedure',function($economic_complement){ $procedure = EconomicComplementProcedure::find($economic_complement->eco_com_procedure_id);
                                                                    return    substr($procedure->year, 0, -6).' '.$procedure->semester; })
        ->addColumn('pension',function($economic_complement){ return $economic_complement->affiliate->pension_entity->name; })
        ->addColumn('affiliate_name', function ($economic_complement) { return $economic_complement->economic_complement_applicant ? $economic_complement->economic_complement_applicant->getTittleName(): null; })
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
        $economic_complements = EconomicComplement::where('affiliate_id', $request["id"])->select(['id', 'affiliate_id', 'eco_com_modality_id', 'wf_current_state_id','eco_com_state_id', 'code', 'reception_date', 'total','year','semester'])->orderBy(DB::raw("substr(substr(code,position('/' in code)+1,length(code)),length(substr(code,position('/' in code)+1,length(code)))-4, length(substr(code,position('/' in code)+1,length(code))))"),'desc')->orderBy(DB::raw("substr(code,position('/' in code)+1,length(code))"), 'desc');
        return Datatables::of($economic_complements)
        ->editColumn('gestion',function($economic_complement){ return $economic_complement->getYear() .' '.$economic_complement->semester;})
        ->editColumn('created_at', function ($economic_complement) { return $economic_complement->getCreationDate(); })
        ->editColumn('wf_state', function ($economic_complement) { return $economic_complement->wf_state->name; })
        ->editColumn('total', function ($economic_complement){return Util::formatMoney($economic_complement->total);})
        ->editColumn('state', function ($economic_complement) {
            try {
                    // Log::info("id complemento: ". $economic_complement->id);
                    $state = DB::table('eco_com_states')->where('id','=',$economic_complement->eco_com_state_id)->first();
                    return $state->name ?? '';
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
        $current_semester = Util::getCurrentSemester();
        $months = Month::all()->pluck('name','id');


        // $moduleObservation=Auth::user()->roles()->first()->module->id;
        // $observations_types = $moduleObservation == 1 ? ObservationType::all() : ObservationType::where('module_id',$moduleObservation)->get();
       
        // $observation_types_list = array('' => '');
        //     foreach ($observations_types as $item) {
        //         $observation_types_list[$item->id]=$item->name;
        //     }


        return [
            'eco_com_states_list' => $eco_com_states_list,
            'eco_com_types_list' => $eco_com_types_list,
            'semester_list' => $semester_list,
            'current_semester' => $current_semester,
            'pension_entities_list' => $pension_entities_list,
            'cities_list' => $cities_list,
            'cities_list_short' => $cities_list_short,
           
            'months' => $months,
        ];
    }

    public function ReceptionFirstStep($affiliate_id)
    {
        
        $getViewModel = self::getViewModel();

        $affiliate = Affiliate::idIs($affiliate_id)->first();

        // if($affiliate->getServiceYears()<16)
        // {
        //     Session::flash('message', 'Tiene menos de 16 años de servicio');
        //     return redirect('affiliate/'.$affiliate_id);
        // }
        $observations = $affiliate->observations->where('observation_type_id',6)->where('is_enabled',true);
        if($observations->count() > 0)
        {
            $messages = '';
            foreach($observations as $observation)
            {
                $messages.= "<br>".$observation->message;
            }
            Session::flash('message', 'Debe subsanar las siguientes observaciones:'.$messages);
            return redirect('affiliate/'.$affiliate_id);
        }
        
        $economic_complement = EconomicComplement::affiliateIs($affiliate_id)
        ->whereYear('year', '=', Util::getCurrentYear())
        ->where('semester', '=', 'Primer')->first();
        // dd(Util::getOriginalSemester());
        $eco_com_procedure=EconomicComplementProcedure::where('semester', 'like', 'Primer')->where('year', '=', Util::datePickYear(Util::getCurrentYear()))->first();
        // dd($eco_com_procedure);
        // dd($economic_complement);
        $last_complement = EconomicComplement::where('affiliate_id',$affiliate_id)->orderBy('reception_date','DESC')->first();

        // return $last_complement;
        if (!$economic_complement) {
            $economic_complement = new EconomicComplement;
            $eco_com_type = false;
            $eco_com_modality = false;
            $eco_com_modality_type_id = false;
            $economic_complement->semester =  $eco_com_procedure->semester;
            $economic_complement->year = Carbon::now()->year;
            $economic_complement->aps_total_cc = $last_complement->aps_total_cc ?? null;
            $economic_complement->aps_total_fsa = $last_complement->aps_total_fsa ?? null;
            $economic_complement->aps_total_fs = $last_complement->aps_total_fs ?? null;
            $economic_complement->total_rent = $last_complement->total_rent ?? null;

          
        }else{
            $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type->name;
            $eco_com_modality = $economic_complement->economic_complement_modality->name;
            $eco_com_modality_type_id = $economic_complement->economic_complement_modality->economic_complement_type->id;
        }

        $last_year = Util::getCurrentYear() - 1;
        $last_semester = "Segundo";
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
            $last_year_first = Carbon::now()->year - 2;
            $last_year_second = $last_year_first;
        }else{
            $last_semester_first = 'Primer';
            $last_semester_second = 'Segundo';
            $last_year_first = Carbon::now()->year ;
            $last_year_second = $last_year_first -1;
        }
        $eco_com_reception_type = 'Inclusion';
        $last_procedure_second = EconomicComplementProcedure::whereYear('year', '=', $last_year_second)->where('semester','like',$last_semester_second)->first();
        if ($last_procedure_second->count() > 0) {
            if ($last_procedure_second->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $eco_com_reception_type = 'Habitual';
            }
        }
        $last_procedure_first = EconomicComplementProcedure::whereYear('year', '=', $last_year_first)->where('semester','like',$last_semester_first)->first();
        if ($last_procedure_first->count() > 0) {
            if ($last_procedure_first->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $eco_com_reception_type = 'Habitual';
            }
        }
        $reception_types =  array('Inclusion' => 'Inclusion', 'Habitual' => 'Habitual');
        $semesters =  array('Primer' => 'Primer');
        $data = [
            'affiliate' => $affiliate,
            'eco_com_type' => $eco_com_type,
            'eco_com_modality' => $eco_com_modality,
            'economic_complement' => $economic_complement,
            'eco_com_modality_type_id' => $eco_com_modality_type_id,
            'reception_types' => $reception_types,
            'semesters' => $semesters,
            'last_complement' => $last_complement,
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

        //$last_year = Carbon::now()->subYear()->year;
        //$last_semester = Util::getSemester(Carbon::now()->subMonth(7));
        $last_year = Util::getCurrentYear() - 1;
        $last_semester = 'Primer';
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

    //second semester
    public function ReceptionFirstStepSecond($affiliate_id)
    {
        $getViewModel = self::getViewModel();

        $affiliate = Affiliate::idIs($affiliate_id)->first();
        // if($affiliate->getServiceYears()<16)
        // {
        //     Session::flash('message', 'Tiene menos de 16 años de servicio');
        //     return redirect('affiliate/'.$affiliate_id);
        // }
        $observations = $affiliate->observations->where('observation_type_id',6)->where('is_enabled',true);
        if($observations->count() > 0)
        {
            $messages = '';
            foreach($observations as $observation)
            {
                $messages.= "<br>".$observation->message;
            }            
            Session::flash('message', 'Debe subsanar las siguientes observaciones:'.$messages);
            return redirect('affiliate/'.$affiliate_id);
        }
        if($affiliate->observations->where('observation_type_id',10)->where('is_enabled',true)->count() > 0){
            Session::flash('message', 'Excluido por salario');
            return redirect('affiliate/'.$affiliate_id);
        }

        $economic_complement = EconomicComplement::affiliateIs($affiliate_id)
        ->whereYear('year', '=', Util::getCurrentYear())
        ->where('semester', '=', Util::getCurrentSemester())->first();
        $eco_com_procedure=EconomicComplementProcedure::where('semester', 'like', 'Segundo')->where('year', '=', Util::datePickYear(Util::getCurrentYear()))->first();
        $eco_com_procedure_one=EconomicComplementProcedure::where('semester', 'like', 'Primer')->where('year', '=', Util::datePickYear(Util::getCurrentYear()))->first();
        $eco_com_procedure_second=EconomicComplementProcedure::where('semester', 'like', 'Segundo')->where('year', '=', Util::datePickYear(Util::getCurrentYear() - 1))->first();
        $last_complement = EconomicComplement::where('affiliate_id',$affiliate_id)->where('eco_com_procedure_id', '=', $eco_com_procedure_second->id)->first();
        if (EconomicComplement::where('affiliate_id',$affiliate_id)->where('eco_com_procedure_id', '=', $eco_com_procedure_one->id)->first()) {
            $last_complement = EconomicComplement::where('affiliate_id',$affiliate_id)->where('eco_com_procedure_id', '=', $eco_com_procedure_one->id)->first();
        }
        // // return $last_complement;
        if (!$economic_complement) {
            $economic_complement = new EconomicComplement;
            $eco_com_type = false;
            $eco_com_modality = false;
            $eco_com_modality_type_id = false;
            $economic_complement->semester =  $eco_com_procedure->semester;
            $economic_complement->year = Util::getCurrentYear();
            $economic_complement->aps_total_cc = $last_complement->aps_total_cc ?? null;
            $economic_complement->aps_total_fsa = $last_complement->aps_total_fsa ?? null;
            $economic_complement->aps_total_fs = $last_complement->aps_total_fs ?? null;
            $economic_complement->total_rent = $last_complement->total_rent ?? null;
        }else{
            $eco_com_type = $economic_complement->economic_complement_modality->economic_complement_type->name;
            $eco_com_modality = $economic_complement->economic_complement_modality->name;
            $eco_com_modality_type_id = $economic_complement->economic_complement_modality->economic_complement_type->id;
        }

        $last_year = Util::getCurrentYear()-1;
        /*CORREGIR ALERICK */
        $last_semester = "Primer";
        if (EconomicComplement::affiliateIs($affiliate_id)
            ->whereYear('year', '=', $last_year)
            ->where('semester', '=', $last_semester)->first()) {
            $affiliate->type_ecocom = 'Habitual';
        }else{
            $affiliate->type_ecocom = 'Inclusión';
        }

            $last_semester_first = 'Primer';
            $last_year_first = Util::getCurrentYear();
            $last_year_second = $last_year_first -1;
            $last_semester_second = 'Segundo';
        
        $eco_com_reception_type = 'Inclusion';
        $last_procedure_second = EconomicComplementProcedure::whereYear('year', '=', $last_year_second)->where('semester','like',$last_semester_second)->first();
        if ($last_procedure_second->count() > 0) {
            if ($last_procedure_second->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $eco_com_reception_type = 'Habitual';
            }
        }
        $last_procedure_first = EconomicComplementProcedure::whereYear('year', '=', $last_year_first)->where('semester','like',$last_semester_first)->first();
        if ($last_procedure_first->count() > 0) {
            if ($last_procedure_first->economic_complements()->where('affiliate_id','=',$affiliate_id)->first()) {
                $eco_com_reception_type = 'Habitual';
            }
        }
        $reception_types =  array('Inclusion' => 'Inclusion', 'Habitual' => 'Habitual');
        $semesters =  array('Segundo' => 'Segundo');
        $data = [
            'affiliate' => $affiliate,
            'eco_com_type' => $eco_com_type,
            'eco_com_modality' => $eco_com_modality,
            'economic_complement' => $economic_complement,
            'eco_com_modality_type_id' => $eco_com_modality_type_id,
            'reception_types' => $reception_types,
            'semesters' => $semesters,
            'last_complement' => $last_complement,
            'eco_com_reception_type' => $eco_com_reception_type
        ];

        $data = array_merge($data, $getViewModel);
        return view('economic_complements.reception_first_step', $data);
    }
    public function ReceptionSecondStepSecond($economic_complement_id)
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
        $last_year = Util::getCurrentYear() - 1;
        /*CORREGIR ALERICK */
        $last_semester = "Primer";

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

    public function ReceptionThirdStepSecond($economic_complement_id)
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
                    ->orWhere('id','=',8);
                    // ->orWhere('id','=',13);
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
            $wf = WorkflowState::where('role_id','=',Util::getRol()->id)->first();
            // dd($wf);
            $can_create =false;
            switch ($wf->role_id) {
                
                case 2:
                case 4:
                case 22:
                case 23:
                case 24:
                case 25:
                case 26:
                case 27:
                    # code...
                    $can_create = true;
                    break;
                
            }
            if($can_create)
            {
                
                $data = self::getViewModel();
                $semester = $request->semester;
                $affiliate = Affiliate::idIs($request->affiliate_id)->first();

                $eco_com_pro = EconomicComplementProcedure::where('year','=',Util::datePickYear(Util::getCurrentYear()))->where('semester','=',$semester)->first();

                $economic_complement = EconomicComplement::affiliateIs($affiliate->id)
                ->whereYear('year', '=', Util::getCurrentYear())
                ->where('semester', '=', $semester)->first();
                
                $eco_com_modality = EconomicComplementModality::typeidIs(trim($request->eco_com_type))->first();
                if (!$economic_complement) {
                    $economic_complement = new EconomicComplement;
                    if ($last_economic_complement = EconomicComplement::whereYear('year', '=', Util::getCurrentYear())
                        ->where('semester', '=', $semester)
                        ->whereNull('deleted_at')->orderBy('id', 'desc')->first()) {
                            $number_code = Util::separateCode($last_economic_complement->code);
                            $code = $number_code + 1;
                    }else{
                            $code = 1;
                    }

                    $sem = ($semester == 'Primer') ? 'P' : 'S';

                    $economic_complement->user_id = Auth::user()->id;
                    $economic_complement->affiliate_id = $affiliate->id;
                    $economic_complement->eco_com_modality_id = $eco_com_modality->id;
                    $economic_complement->eco_com_procedure_id = $eco_com_pro->id;
                    if ($request->semester == 'Primer' || $request->semester == 'Segundo') { 
                        $economic_complement->workflow_id = 3;
                    }else{
                        $economic_complement->workflow_id = 1;
                    }
                    $economic_complement->wf_current_state_id = $wf->id;
                    $economic_complement->eco_com_state_id = 16;
                    $economic_complement->city_id = trim($request->city);
                    $economic_complement->category_id = $affiliate->category_id;
                    $economic_complement->degree_id = $affiliate->degree_id;
                    $economic_complement->reception_date = date('Y-m-d');
                    $economic_complement->state = 'Edited';

                    $economic_complement->year = Util::datePickYear(Util::getCurrentYear());
                    $economic_complement->semester = $semester;
                    
                    $economic_complement->has_legal_guardian =$request->has('has_legal_guardian')?true:false;
                    if($request->has('legal_guardian_sc'))
                    {
                        $economic_complement->has_legal_guardian_s = $request->legal_guardian_sc !='1'?true:false;
                    }
                    
                    $economic_complement->code = $code ."/". $sem . "/" . Util::getCurrentYear();

                    $economic_complement->reception_type = $request->reception_type; 
                    // $base_wage = BaseWage::degreeIs($affiliate->degree_id)->first();
                    // $economic_complement->base_wage_id = $base_wage->id;
                    // $economic_complement->complementary_factor_id = $complementary_factor->id;
                    $economic_complement->save();

                    Log::info('ingresando al metodo hdpo');
                    Log::info($economic_complement);
                    $observations = AffiliateObservation::where('affiliate_id',$economic_complement->affiliate_id)->get();
                    Log::info('mostrando observaciones ----------------------------_>');
                    Log::info($observations);
                    foreach($observations as $observation){
                        Log::info($observation);
                        if($observation->observationType->type=='AT')
                        {
                            $eco_com_observation = new EconomicComplementObservation;
                            $eco_com_observation->user_id = Auth::user()->id;
                            $eco_com_observation->economic_complement_id = $economic_complement->id;
                            $eco_com_observation->observation_type_id = $observation->observation_type_id;
                            $eco_com_observation->message = $observation->message;
                            $eco_com_observation->save();
                        }
                    }
                }
                return $this->save($request, $economic_complement);

            }
            else{

                Session::flash('message', 'No se pudo crear el Tramite por no es del area de Recepción');

                return back()->withInput();
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($economic_complement)
    {   
        //Log::info("show_id_complement= ".$economic_complement->id);



        try {
            $state = EconomicComplementState::find($economic_complement->eco_com_state_id);

        } catch (Exception $e) {
            $state =null;
        }
        $state_actual = $economic_complement->wf_current_state_id;

        // dd($state_actual);
        // dd($economic_complement->workflow_id);
        $sequence = WorkflowSequence::where("workflow_id",$economic_complement->workflow_id)
                                     ->where("wf_state_current_id",$economic_complement->wf_current_state_id)
                                     ->where('action','Denegar')
                                     ->get();
        // return $sequence;
        
        // $sw_actual = WorkflowState::where('role_id',Util::getRol()->id)->first();
        $sw_actual = WorkflowState::where('id',$economic_complement->wf_current_state_id)->first();

        $buttons_enabled=false;
        
        if($sw_actual)
        {
            if($sw_actual->id == $economic_complement->wf_state->id)
            {
                $buttons_enabled =true;
            }
        }
    
        

        if($sequence)
        {   

            $wf_state_before = array();
            foreach ($sequence as $s) {

                # code...
                $wf = WorkflowState::where('id',$s->wf_state_next_id)->first();

                $wf_before = array('id'=>$wf->id,'name'=>$wf->name);
                array_push($wf_state_before, $wf_before);
            }
            // $wf_state_before = WorkflowState::where('id',$sequence->wf_state_next_id)->first(); 
        }else
        {
            $wf_state_before = null;
        }
        // return $wf_state_before;
        if($wf_state_before && $economic_complement->state=='Received' && $economic_complement->user_id = Auth::user()->id)
        {
            $wf_state_before = null;
        }
                                     
        $has_checked = null;

        if($economic_complement->wf_state->role_id == Util::getRol()->id && $economic_complement->state == "Received")
        {
            $has_checked = true;   
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

        $last_year = Util::getCurrentYear() - 1;
        /*CORREGIR ALERICK */
        $last_semester = "Primer";
        
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
        $degrees=[''=>''];
        foreach ($dg as $d) {
            $degrees[$d->id]=$d->name;
        }

        $ep=PensionEntity::all();
        $entity_pensions=array(''=>'');

        foreach ($ep as $e) {
            $entity_pensions[$e->id]=$e->name;
        }

        $economic_complement_legal_guardian=$economic_complement->economic_complement_legal_guardian;
        $affi_observations = AffiliateObservation::where('affiliate_id',$affiliate->id)->get();
        // Log::info($affi_observations);
        if (EconomicComplement::where('affiliate_id', $affiliate->id)->whereYear('year','=', 2016)->first()) {
            $last_ecocom = EconomicComplement::where('affiliate_id', $affiliate->id)->whereYear('year','=', 2016)->get()->last();
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

                }else if($last_ecocom->economic_complement_modality->economic_complement_type->name == 'Viudedad'){
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
                }else{
                    $eco_com_submitted_documents_ar = EconomicComplementSubmittedDocument::economicComplementIs($last_ecocom->id)->where(function ($query)
                    {
                        $query->where('eco_com_requirement_id','=',17)
                        ->orWhere('eco_com_requirement_id','=',18)
                        ->orWhere('eco_com_requirement_id','=',19)
                        ->orWhere('eco_com_requirement_id','=',20)
                        ->orWhere('eco_com_requirement_id','=',21);
                    })->orderBy('id','asc')->get();

                    $eco_com_requirements_ar = EconomicComplementRequirement::where(function ($query)
                    {
                        $query->where('id','=',17)
                        ->orWhere('id','=',18)
                        ->orWhere('id','=',19)
                        ->orWhere('id','=',20)
                        ->orWhere('id','=',21);
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

                }else if($last_ecocom->economic_complement_modality->economic_complement_type->name == 'Viudedad'){
                    $eco_com_requirements_ar = EconomicComplementRequirement::where(function ($query)
                    {
                        $query->where('id','=',7)
                        ->orWhere('id','=',8)
                        ->orWhere('id','=',9)
                        ->orWhere('id','=',10)
                        ->orWhere('id','=',11)
                        ->orWhere('id','=',12);
                    })->orderBy('id','asc')->get();
                }else{
                    $eco_com_requirements_ar = EconomicComplementRequirement::where(function ($query)
                    {
                        $query->where('id','=',14)
                        ->orWhere('id','=',15)
                        ->orWhere('id','=',16)
                        ->orWhere('id','=',17)
                        ->orWhere('id','=',18)
                        ->orWhere('id','=',19)
                        ->orWhere('id','=',20)
                        ->orWhere('id','=',21);
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


         // Log::info(" entrando al complemento hdpl ");
        $hasObservation =false;
        foreach ($affi_observations as $observation) {
            # code...
            switch (Util::getRol()->id) {
                case 7:
                case 4:
                    if(Util::getRol()->module_id == 2 && $observation->is_enabled == false)
                    {
                        $hasObservation = true;
                    }  
                    # code...

                    break;
                case 16:
                    if(Util::getRol()->module_id == $observation->observationType->module_id && $observation->is_enabled == false)
                    {
                        $hasObservation = true;
                    } 
                    break;
                
            }
            
        }
        // dd($hasObservation);
        // Log::info("has observatop ".json_encode($hasObservation));
        $hasAmortization = false;
        switch (Util::getRol()->id) {
           
            case 16:
           
                if($hasObservation)
                {
                                      
                    if($economic_complement->eco_com_state_id=3 || $economic_complement->eco_com_state_id=2 || $economic_complement->eco_com_state_id=1 || $economic_complement->eco_com_state_id=18 || $economic_complement->eco_com_state_id=17 || $economic_complement->eco_com_state_id=21 )
                    {
                        
                        // if($economic_complement->total > 0)
                        // {
                            $hasAmortization =true; 
                        // }
                        
                    }

                     
                }
               
                break;
             case 4:
             case 7:
                
                if($hasObservation)
                {
                    $has_repocision_observation = false;
                    $has_contabilidad_observation = false;
                    foreach ($affi_observations as $observation) {
                         # code...
                        if($observation->observation_type_id == 13)
                        {
                            $has_repocision_observation = true;
                        }
                        if($observation->observation_type_id == 1)
                        {
                            $has_contabilidad_observation = true;
                        }
                     } 
                    if($has_repocision_observation || $has_contabilidad_observation)
                    {

                        if($economic_complement->eco_com_state_id=3 || $economic_complement->eco_com_state_id=2 || $economic_complement->eco_com_state_id=1 || $economic_complement->eco_com_state_id=18 || $economic_complement->eco_com_state_id=17 || $economic_complement->eco_com_state_id=21 )
                        {
                            // if($economic_complement->total > 0)
                            // {
                                $hasAmortization =true; 
                            // }
                            
                        }
                    }
                     
                }

             break;

        }

        $rent_month = EconomicComplementProcedure::find($economic_complement->eco_com_procedure_id);

        $has_cancel = false;
        if(Auth::user()->id == $economic_complement->user_id && $economic_complement->wf_state->role_id == Util::getRol()->id && $economic_complement->state=='Edited')
        {
            $has_cancel =true;            
        }

        $states = null;

        $has_edit_state =false;
        if(Util::getRol()->id == 9 || Util::getRol()->id == 4 )
        {
            if($economic_complement->workflow_id != 1) //adicionar condicionantes en este punto 
            {
                $has_edit_state =true;
    
                // $states = EconomicComplementState::where('eco_com_state_type_id',1)->get(); //solo los de tipo Pago
                $states = EconomicComplementState::all();
    
            }
        }
        //datos para el spouse

        $spouse = Spouse::where('affiliate_id',$economic_complement->affiliate_id)->first();

        if ($affiliate->gender == 'M') {
            $gender_list = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];
            $gender_list_s = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];

        }elseif ($affiliate->gender == 'F') {
            $gender_list = ['' => '', 'C' => 'CASADA', 'S' => 'SOLTERA', 'V' => 'VIUDA', 'D' => 'DIVORCIADA'];
            $gender_list_s = ['' => '', 'C' => 'CASADO', 'S' => 'SOLTERO', 'V' => 'VIUDO', 'D' => 'DIVORCIADO'];

        }
        // Log::info("has_cancel= ".json_encode($has_cancel));
        // Log::info("wf_state_before=" .json_encode($wf_state_before));

        $amount_amortization=0;
        $devolution = null;
        switch (Util::getRol()->id) {
            case 7:
                # code...
                $amount_amortization = $economic_complement->amount_accounting;
                break;
            case 16:
                # code...
                $amount_amortization = $economic_complement->amount_loan;
                break;
            case 4:
                # code...
                $amount_amortization = $economic_complement->amount_replacement;
                $devolution =  Devolution::where('affiliate_id','=',$affiliate->id)->where('observation_type_id','=',13)->first();
                break;
        }
        $devolution_amount_percetage = null;
        $devolution_amount_total = null;
        if($devolution){   
            if ($devolution->percentage && $economic_complement->total > 0) {
                 $devolution_amount_percetage = floatval($economic_complement->total * $devolution->percentage);
            }elseif ($economic_complement->total > 0 && !$devolution->percentage) {
                $devolution_amount_total = $devolution->total;
            }

        }

        $class_rent =DB::table('eco_com_kind_rent')->where('id',$economic_complement->eco_com_kind_rent_id)->first();
        $observations_quantity = EconomicComplementObservation::where('economic_complement_id',$economic_complement->id)->where('observation_type_id','<>',11)->get()->count();
        $observations_eliminated = EconomicComplementObservation::where('economic_complement_id',$economic_complement->id)
        ->whereNotNull('deleted_at')
        ->withTrashed()
        ->get();
        $notes_quantity = EconomicComplementObservation::where('economic_complement_id',$economic_complement->id)->where('observation_type_id',11)->get()->count();


        $observations_types = ObservationType::where('module_id',Util::getRol()->module_id)->where('type','T')->where('id','<>',11)->get();
        
        $affiliate_observations = AffiliateObservation::where('affiliate_id',$economic_complement->affiliate_id)->get();
        foreach($affiliate_observations as $observation){
            if($observation->observationType->type=='AT')
            {
                $eco_com_observation = EconomicComplementObservation::where('economic_complement_id',$economic_complement->id)
                ->where('observation_type_id',$observation->observation_type_id)
                ->first();
                if(!$eco_com_observation)
                {
                    $new_observation = ObservationType::find($observation->observation_type_id);
                    $observations_types->push($new_observation);
                    // ($observations_types,$new_observation);   
                }
            }
        }
        // return $observations_types;
        
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
        'status_eco_com_submitted_documents_ar'=>$status_eco_com_submitted_documents_ar,
        'has_amortization' => $hasAmortization,
        'amount_amortization' => $amount_amortization,
        'wf_state_before' => $wf_state_before,
        'buttons_enabled' => $buttons_enabled,
        'rent_month' => $rent_month,
        'has_cancel' => $has_cancel,
        'has_edit_state' => $has_edit_state,
        'has_checked' =>$has_checked,
        'states' => $states,
        'spouse' => $spouse,
        'gender_list' =>$gender_list,
        'gender_list_s' => $gender_list_s,
        'class_rent' => $class_rent,
        'devolution' => $devolution,
        'devolution_amount_percetage' => $devolution_amount_percetage,
        'devolution_amount_total' => $devolution_amount_total,
        'complement_observations' => $economic_complement->observations,
        'observations_quantity' =>$observations_quantity,
        'observations_eliminated' => $observations_eliminated->count(),
        'notes_quantity' =>$notes_quantity,
        'observations_types' => $observations_types,
        ];
        // return $data;
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
        'total' => Util::formatMoney($economic_complement->total),
        'total_repay' => Util::formatMoney($economic_complement->total_repay)

        ];

        $data = array_merge($data, $second_data);
        // }

        $data = array_merge($data, self::getViewModel());
        // return $data;
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
        // Log::info("id".$economic_complements->id);
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
                if ($request->semester == 'Primer') {
                    return redirect('economic_complement_reception_first_step/'.$request->affiliate_id)
                    ->withErrors($validator)
                    ->withInput();
                }
                return redirect('economic_complement_reception_first_step/'.$request->affiliate_id.'/second')
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
                    $eco_com_applicant->due_date = $affiliate->due_date;
                    $eco_com_applicant->is_duedate_undefined = $affiliate->is_duedate_undefined;
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
                        // $eco_com_applicant->due_date = $spouse->due_date;
                        // $eco_com_applicant->is_duedate_undefined = $spouse->is_duedate_undefined;

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
                //crear logica para el segundo semestre hdp 
                // $economic_complement->aps_total_cc = $request->aps_total_cc;
                // $economic_complement->aps_total_fsa = $request->aps_total_fsa;
                // $economic_complement->aps_total_fs = $request->aps_total_fs;

                $economic_complement->eco_com_modality_id=$eco_com_modality->id;
                $economic_complement->city_id = trim($request->city);
               
                $economic_complement->has_legal_guardian =$request->has('legal_guardian')?true:false;
              
                //Log::info($economic_complement->has_legal_guardian);
                if($request->has('legal_guardian_sc'))
                {   
                   //$v = $request->legal_guardian_sc =='1'?true:false;
                     // Log::info("legal_guardian_sc: ".$request->legal_guardian_sc);
                     // Log::info("v: ".$v);

                    $economic_complement->has_legal_guardian_s = $request->legal_guardian_sc !='1'?true:false;
                    // if(!$economic_complement->has_legal_guardian_s){
                    //     $economic_complements->month_id = $request->month_id;
                    // }
                }
                else
                {
                     Log::info("NO tiene legal_guardian_sc");

                }
                     Log::info("complemento: ".$economic_complement->id);


                    
          
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
                if ($request->semester == 'Primer') {
                    return redirect('economic_complement_reception_second_step/'.$economic_complement->id);
                }
                return redirect('economic_complement_reception_second_step/'.$economic_complement->id.'/second');

            }

            break;

            case 'second':

            $rules = [

            ];

            $messages = [

            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()){
                if ($economic_complement->semester == 'Primer') {
                    return redirect('economic_complement_reception_second_step/' . $economic_complement->id)
                    ->withErrors($validator)
                    ->withInput();    
                }
                return redirect('economic_complement_reception_second_step/' . $economic_complement->id.'/second')
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
                $eco_com_applicant->city_birth_id = $request->city_birth_id <> "" ? $request->city_birth_id : null;
                $eco_com_applicant->due_date = Util::datePick($request->due_date);
                $eco_com_applicant->is_duedate_undefined = !$request->is_duedate_undefined?false:true;
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
                    $affiliate->nua = $request->nua>0 ? $request->nua : 0;
                    $affiliate->gender = $request->gender;
                    $affiliate->civil_status = $request->civil_status;
                    $affiliate->due_date = Util::datePick($request->due_date);
                    $affiliate->is_duedate_undefined = !$request->is_duedate_undefined?false:true;
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
                            $spouse->due_date = Util::datePick($request->due_date);
                            $spouse->is_duedate_undefined = !$request->is_duedate_undefined?false:true;
                            $spouse->death_certificate_number = trim($request->death_certificate_number);
                            $affiliate->nua = ($request->nua == null) ? 0 : $request->nua;
                            $spouse->registration=Util::CalcRegistration(Util::datePick($request->birth_date),trim($request->last_name),trim($request->mothers_last_name), trim($request->first_name),Util::getGender($affiliate->gender));
                            $spouse->city_birth_id = $request->city_birth_id == "" ? null : $request->city_birth_id;
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
                            $spouse->civil_status = $request->civil_status;
                            $spouse->city_birth_id = $request->city_birth_id <> "" ? $request->city_birth_id : null;
                            $spouse->save();
                        }


                    break;

                    case '3':
                    if ($request->type1!='update') {

                        $rules = [
                            'age_eco_com_applicant' => 'integer|max:25'
                        ];

                        $messages = [
                            'age_eco_com_applicant.max' => 'El Huerfano no puede cobrar debido a que tiene mas de 25 años'
                        ];

                        $age = ['age_eco_com_applicant' => $eco_com_applicant->getAge()];

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
                                 $eco_com_legal_guardian->due_date = Util::datePick($request->due_date_lg);
                                 $eco_com_legal_guardian->is_duedate_undefined = !$request->is_duedate_undefinedlg?false:true;
                                 $eco_com_legal_guardian->save();
                             }
                         }

                if ($request->type == 'update') {
                    return redirect('economic_complement/'.$economic_complement->id);
                }
                else{
                    if($economic_complement->semester == 'Primer'){
                        return redirect('economic_complement_reception_third_step/'.$economic_complement->id);
                    }else{   
                        return redirect('economic_complement_reception_third_step/'.$economic_complement->id.'/second');
                    }
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

                        $wf_record=new WorkflowRecord;
                        $wf_record->user_id=Auth::user()->id;
                        $wf_record->date=Carbon::now();
                        $wf_record->eco_com_id=$request->id_complemento;
                        $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
                        $wf_record->record_type_id=1;
                        $wf_record->message="El usuario ".Util::getFullNameuser()." Creo ".$eco_com_submitted_document->economic_complement_requirement->name." fecha ".Carbon::now().".";
                        $wf_record->save();
                    }
                    elseif($eco_com_submitted_document->status <> $item->status){
                        $eco_com_submitted_document->status = $item->status;
                        $eco_com_submitted_document->reception_date = date('Y-m-d');
                        $eco_com_submitted_document->save();
                        
                        

                        $wf_record=new WorkflowRecord;
                        $wf_record->user_id=Auth::user()->id;
                        $wf_record->date=Carbon::now();
                        $wf_record->eco_com_id=$request->id_complemento;
                        $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
                        $wf_record->record_type_id=1;
                        $wf_record->message="El usuario ".Util::getFullNameuser()." modifico ".$eco_com_submitted_document->economic_complement_requirement->name." fecha ".Carbon::now().".";
                        $wf_record->save();
                        
                    }

                }

                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();
                
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
                              

                                // $wf_record=new WorkflowRecord;
                                // $wf_record->user_id=Auth::user()->id;
                                // $wf_record->date=Carbon::now();
                                // $wf_record->eco_com_id=$economic_complement->id;
                                // $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
                                // $wf_record->record_type_id=1;
                                // $wf_record->message="El usuario ".Util::getFullNameuser()." creó el trámite en fecha ".Carbon::now().".";
                                // $wf_record->save();

                                $wf_record=new WorkflowRecord;
                                $wf_record->user_id=Auth::user()->id;
                                $wf_record->date=Carbon::now();
                                $wf_record->eco_com_id=$request->id_complemento;
                                $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
                                $wf_record->record_type_id=1;
                                $wf_record->message="El usuario ".Util::getFullNameuser()." Creo ".$eco_com_submitted_document->economic_complement_requirement->name." fecha ".Carbon::now().".";
                                $wf_record->save();


                            }
                            elseif($eco_com_submitted_document->status <> $item->status )
                            {
                                $eco_com_submitted_document->comment = "Documentos del segundo Semestre del 2016";
                                $eco_com_submitted_document->status = $item->status;
                                $eco_com_submitted_document->reception_date = date('Y-m-d');
                                $eco_com_submitted_document->save();
                                 
                                
                                $wf_record=new WorkflowRecord;
                                $wf_record->user_id=Auth::user()->id;
                                $wf_record->date=Carbon::now();
                                $wf_record->eco_com_id=$request->id_complemento;
                                $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
                                $wf_record->record_type_id=1;
                                $wf_record->message="El usuario ".Util::getFullNameuser()." modifico ".$eco_com_submitted_document->economic_complement_requirement->name." fecha ".Carbon::now().".";
                                $wf_record->save();

                     


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
                    $role=Util::getRol();

                    switch ($role->id) {
                        case 3:
                            $economic_complement->review_date = date('Y-m-d');
                            break;
                        case 4:
                            $economic_complement->calculation_date = date('Y-m-d');    
                            
                            break;
                        case 5:
                            $economic_complement->aprobation_date  = date('Y-m-d');    
                            
                            break;
                    }
                    
                $economic_complement->state = 'Edited';
                $economic_complement->save();
                
                return redirect('inbox');
                // return redirect('economic_complement');
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
                    
                    $role=Util::getRol();

                    switch ($role->id) {
                        case 3:
                            $economic_complement->review_date = null;
                            break;
                        case 4:
                            $economic_complement->calculation_date = null;    
                            
                            break;
                        case 5:
                            $economic_complement->aprobation_date  = null;    
                            
                            break;
                    }


                    $economic_complement->state = 'Received';
                    $economic_complement->save();
                    return redirect('economic_complement');
                }

            break;

          case 'rent':
          // dd($request->sub_total_rent);
            $rules = [
                'sub_total_rent' => 'min:1|number_comma_dot|not_zero',
            ];
            $messages = [
                'sub_total_rent.min' => 'Debe de ingresar un monto mayor a 1 en la renta.',
                'sub_total_rent.not_zero' => 'Debe ingresar un monto mayor a 0.',
                'sub_total_rent.number_comma_dot' => 'Verifique que el monto ingresado este correcto.',
                
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
                EconomicComplement::calculate($economic_complement,$request->total_rent, $request->sub_total_rent, $request->reimbursement, $request->dignity_pension, $request->aps_total_fsa, $request->aps_total_cc, $request->aps_total_fs, $request->aps_disability);
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
        case 'print_total':
            $rules = [
                'comment'=>'required|max:350'
            ];
            $messages = [
                'comment.required'=>'Debe escribir una Nota.',
                'comment.max'=>'La Nota debe ser un maximo de 300 carcateres.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()){
                return redirect('economic_complement/' . $economic_complement->id)
                ->withErrors($validator)
                ->withInput();
            }
            else{
                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();
                $economic_complement->comment = $request->comment;
                $economic_complement->save();
                return redirect('economic_complement/print_total/'.$economic_complement->id);
            }
        break;
        case 'print_total_old':
            $rules = [
                'comment'=>'required|max:350'
            ];
            $messages = [
                'comment.required'=>'Debe escribir una Nota.',
                'comment.max'=>'La Nota debe ser un maximo de 300 carcateres.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()){
                return redirect('economic_complement/' . $economic_complement->id)
                ->withErrors($validator)
                ->withInput();
            }
            else{
                $economic_complement = EconomicComplement::idIs($economic_complement->id)->first();
                $economic_complement->comment = $request->comment;
                $economic_complement->save();
                return redirect('economic_complement/print_total_old/'.$economic_complement->id);
            }
        break;
        case 'legal_guardian':
            //return $request->all();
            $eco_com_legal_guardian = EconomicComplementLegalGuardian::economicComplementIs($economic_complement->id)->first();
              $eco_com_legal_guardian->identity_card = $request->identity_card_lg;
              if ($request->city_identity_card_id_lg) { $eco_com_legal_guardian->city_identity_card_id = $request->city_identity_card_id_lg; } else { $eco_com_legal_guardian->city_identity_card_id = null; }
             
              

              $eco_com_legal_guardian->is_duedate_undefined =!$request->is_duedate_undefinedlg?false:true;
              if(!$eco_com_legal_guardian->is_duedate_undefined)
              {
                 if($request->due_date_lg!='')
                 {
                    $eco_com_legal_guardian->due_date =$request->due_date_lg;
                 }else{
                    $eco_com_legal_guardian->due_date = null;
                 }
                 
              }


              // if($request->month_id!='')
              // {
                $economic_complement->month_id = $request->month_id==''?null:$request->month_id;
                $economic_complement->save();
              // }
              
              $eco_com_legal_guardian->last_name = $request->last_name_lg;
              $eco_com_legal_guardian->mothers_last_name = $request->mothers_last_name_lg;
              $eco_com_legal_guardian->first_name = $request->first_name_lg;
              $eco_com_legal_guardian->second_name = $request->second_name_lg;
              $eco_com_legal_guardian->surname_husband = $request->surname_husband_lg;
              $eco_com_legal_guardian->phone_number =trim(implode(",", $request->phone_number_lg));
              $eco_com_legal_guardian->cell_phone_number =trim(implode(",", $request->cell_phone_number_lg));
              //return $eco_com_legal_guardian;
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
      setlocale(LC_ALL, "es_ES.UTF-8");
      $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
      $current_date = Carbon::now();
      $hour = Carbon::parse($current_date)->toTimeString();
      $economic_complement = EconomicComplement::idIs($economic_complement_id)->first();
      $affiliate = Affiliate::where('id',$economic_complement->affiliate_id)->first();
      $eco_com_applicant = EconomicComplementApplicant::EconomicComplementIs($economic_complement->id)->first();
      $doc_number = $economic_complement->economic_complement_modality->economic_complement_type->id;
      $data=[
        'doc_number'=>$doc_number,
        'header1'=>$header1,
        'header2'=>$header2,
        'title'=>$title,
        'date'=>$date,
        'hour'=>$hour,
        'affiliate'=>$affiliate,
        'economic_complement'=>$economic_complement,
        'eco_com_applicant'=>$eco_com_applicant,
        'user' => Auth::user(),
        'user_role' =>Util::getRol()->name,
      ];

        switch ($type) {
            case 'vejez':
                // $view = \View::make('economic_complements.print.sworn_declaration1', $data)->render();
                // $pdf = \App::make('dompdf.wrapper');
                // $pdf->loadHTML($view)->setPaper('legal');
                // return $pdf->stream();
                return \PDF::loadView('economic_complements.print.sworn_declaration1', $data)->setPaper('letter')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_edited.pdf');
            case 'viudedad':
                $spouse = Spouse::where('affiliate_id',$affiliate->id)->first();
                array_push($data, $spouse);
                return \PDF::loadView('economic_complements.print.sworn_declaration2', $data)->setPaper('letter')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_edited.pdf');

                // $view = \View::make('economic_complements.print.sworn_declaration2', $data)->render();
                // $pdf = \App::make('dompdf.wrapper');
                // $pdf->loadHTML($view)->setPaper('legal');
                // return $pdf->stream();
        }

    }

    public function print_eco_com_reports($economic_complement_id,$type)
    {
      $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
      $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
      $date = Util::getDateEdit(date('Y-m-d'));
      setlocale(LC_ALL, "es_ES.UTF-8");
      $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
      $current_date = Carbon::now();
      $user = Auth::user();
      $user_role = Util::getRol()->name;
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
      $doc_number = $economic_complement->economic_complement_modality->economic_complement_type->id;

      $data=[
        'doc_number'=>$doc_number,
        'header1'=>$header1,
        'header2'=>$header2,
        'date'=>$date,
        'hour'=>$hour,
        'economic_complement'=>$economic_complement,
        'eco_com_submitted_document'=>$eco_com_submitted_document,
        'affiliate'=>$affiliate,
        'eco_com_applicant'=>$eco_com_applicant,
        'applicant_type'=>$applicant_type,
        'user' => Auth::user(),
        'user_role' =>Util::getRol()->name,
      ];

        switch ($type) {
            case 'report':
                $title= "RECEPCIÓN DE REQUISITOS";
                array_push($data,$title);
                return \PDF::loadView('economic_complements.print.reception_report', $data)->setPaper('letter')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_edited.pdf');
                
                $view = \View::make('economic_complements.print.reception_report', compact('header1', 'header2', 'title','date','hour','economic_complement','eco_com_submitted_document','affiliate','eco_com_applicant','user', 'user_role','yearcomplement'))->render();
                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();

            case 'inclusion':
                $title= "";
                array_push($data,$title);
                return \PDF::loadView('economic_complements.print.inclusion_solicitude', $data)->setPaper('letter')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_edited.pdf');
                
                $view = \View::make('economic_complements.print.inclusion_solicitude', compact('header1','header2','title','date','hour','economic_complement','eco_com_submitted_document','affiliate','eco_com_applicant','applicant_type', 'user', 'user_role'))->render();

                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view)->setPaper('legal');
                return $pdf->stream();

            case 'habitual':
                $title= "";
                array_push($data,$title);
                return \PDF::loadView('economic_complements.print.habitual_solicitude', $data)->setPaper('letter')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_edited.pdf');


                $view = \View::make('economic_complements.print.habitual_solicitude', compact('header1','header2','title','date','hour','economic_complement','eco_com_submitted_document','affiliate','eco_com_applicant','applicant_type', 'user', 'user_role'))->render();
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
        Log::info($request->id);
       
        $new_records = EconomicComplementRecord::select('created_at','message')->where('economic_complement_id',$request->id)->get();
        $records =  WorkflowRecord::select('created_at', 'message')->where('eco_com_id', $request->id)->orderBy('created_at', 'desc')->get();
        $history  = collect();
        foreach($new_records as $record){
            $history->push(array('created_at'=>$record->created_at,'message'=>$record->message));
        }
        foreach($records as $record){
            $history->push(array('created_at'=>$record->created_at,'message'=>$record->message));
        }
   
        return Datatables::of($history)
            ->editColumn('created_at', '{!! $created_at !!}')
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
            $last_year_first = Util::getCurrentYear() - 1;
            $last_year_second = $last_year_first;
        }else{
            $last_semester_first = 'Primer';
            $last_semester_second = 'Segundo';  
            $last_year_first = Util::getCurrentYear() ;
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

    public function save_amortization(Request $request)
    {
        
        $start_procedure = EconomicComplementProcedure::where('id','=', 2)->first();
        $rol = Util::getRol();
        if($request->amount_amortization > 0)
        {
            switch ($rol->id) {
                case 7: //contabiliadad
                    
                    $complemento = EconomicComplement::where('id',$request->id_complemento)->first();
                    $complemento->amount_accounting = $request->amount_amortization;
                    $complemento->save();

                    $wf_record=new WorkflowRecord;
                    $wf_record->user_id=Auth::user()->id;
                    $wf_record->date=Carbon::now();
                    $wf_record->eco_com_id=$complemento->id;
                    $wf_record->wf_state_id=$complemento->wf_current_state_id;
                    $wf_record->record_type_id=1;
                    $wf_record->message="El usuario ".Util::getFullNameuser()." amortizó ".$complemento->amount_accounting." Bs.   fecha ".Carbon::now().".";
                    $wf_record->save();

                    break;

                case 16: //prestamo 
                    
                    $complemento = EconomicComplement::where('id',$request->id_complemento)->first();
                    $complemento->amount_loan = $request->amount_amortization;
                    $complemento->save();

                    $wf_record=new WorkflowRecord;
                    $wf_record->user_id=Auth::user()->id;
                    $wf_record->date=Carbon::now();
                    $wf_record->eco_com_id = $complemento->id;
                    $wf_record->wf_state_id=$complemento->wf_current_state_id;
                    $wf_record->record_type_id=1;
                    $wf_record->message="El usuario ".Util::getFullNameuser()." amortizó ".$complemento->amount_loan." Bs.  fecha ".Carbon::now().".";
                    $wf_record->save();

                    break;
                
                case 4: //complemento
                    
                    $complemento = EconomicComplement::where('id',$request->id_complemento)->first();
                    $complemento->amount_replacement = $request->amount_amortization;
                    $complemento->save();
                    $sum = 0;
                    while ($start_procedure) {
                        $eco_com = $start_procedure->economic_complements()->where('affiliate_id','=', $complemento->affiliate_id)->first();
                        if ($eco_com) {
                            if ($eco_com->amount_replacement) {
                                $sum += $eco_com->amount_replacement;
                            }
                        }
                        $start_procedure = EconomicComplementProcedure::where('id','=', Util::semesternext(Carbon::parse($start_procedure->year)->year, $start_procedure->semester))->first();
                        Log::info("whille");
                    }
                    $devolution = Devolution::where('affiliate_id','=',$complemento->affiliate_id)->where('observation_type_id','=',13)->first();
                    if ($devolution) {
                        $devolution->balance = $devolution->total - $sum;
                        $devolution->save();
                    }
                    $wf_record=new WorkflowRecord;
                    $wf_record->user_id=Auth::user()->id;
                    $wf_record->date=Carbon::now();
                    $wf_record->eco_com_id=$complemento->id;
                    $wf_record->wf_state_id=$complemento->wf_current_state_id;
                    $wf_record->record_type_id=1;
                    $wf_record->message="El usuario ".Util::getFullNameuser()." amortizó ".$complemento->amount_replacement." Bs.  fecha ".Carbon::now().".";
                    $wf_record->save();

                    break;
                
            }
            Session::flash('message', 'Se guardo la Amortización.');
            
            if ($complemento->total_rent > 0 ) {   
                EconomicComplement::calculate($complemento,$complemento->total_rent, $complemento->sub_total_rent, $complemento->reimbursement, $complemento->dignity_pension, $complemento->aps_total_fsa, $complemento->aps_total_cc, $complemento->aps_total_fs, $complemento->aps_disability);
                $complemento->save();
            }
        }
        else{
            Session::flash('message', 'El Monto de amortizacion debe ser mayor a 0 ');
        }
        
        
        return back()->withInput();
    }

    public function retroceso_de_tramite(Request $request)
    {
        $economic_complement = EconomicComplement::where('id',$request->id_complemento)->first();
        $old_wf = DB::table('wf_states')->where('id',$economic_complement->wf_current_state_id)->first();
        // dd($old_wf);
        // $sequence = WorkflowSequence::where("workflow_id",$economic_complement->workflow_id)
        //                              ->where("wf_state_current_id",$economic_complement->wf_current_state_id)
        //                              ->where('action','Denegar')
        //                              ->first();
        // $wf_state_before = WorkflowState::where('id',$sequence->wf_state_next_id)->first(); 
        $economic_complement->wf_current_state_id = $request->wf_state_id;
        $economic_complement->state= 'Received';
        $economic_complement->save();

        $new = DB::table('wf_states')->where('id',$economic_complement->wf_current_state_id)->first();

        $wf_record=new WorkflowRecord;
        $wf_record->user_id=Auth::user()->id;
        $wf_record->date=Carbon::now();
        $wf_record->eco_com_id=$request->id_complemento;
        $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
        $wf_record->record_type_id=1;
        $wf_record->message="El usuario ".Util::getFullNameuser()." devolvio el tramite de ".$old_wf->name." a ".$new->name ."  fecha ".Carbon::now()."
        \n Motivo: ".$request->nota.".";
        $wf_record->save();

        return back()->withInput();

    }

    public function change_state(Request $request)
    {
        $economic_complement = EconomicComplement::where('id',$request->id_complemento)->first();

        $older = DB::table('eco_com_states')->where('id',$economic_complement->eco_com_state_id)->first();

        $economic_complement->eco_com_state_id = $request->state_id;
        if( $economic_complement->eco_com_state_id == 2 ||  $economic_complement->eco_com_state_id == 3)
        {
            $economic_complement->number_check = $request->numero_cheque;
        }
        else{
            $economic_complement->number_check = null;
        }
        $economic_complement->save();

        $new = DB::table('eco_com_states')->where('id',$economic_complement->eco_com_state_id)->first();
        $wf_record=new WorkflowRecord;
        $wf_record->user_id=Auth::user()->id;
        $wf_record->date=Carbon::now();
        $wf_record->eco_com_id=$request->id_complemento;
        $wf_record->wf_state_id=$economic_complement->wf_current_state_id;
        $wf_record->record_type_id=1;
        $wf_record->message="El usuario ".Util::getFullNameuser()." cambio de estado de ".$older->name." a ".$new->name ."  fecha ".Carbon::now().".";
        $wf_record->save();
        return back()->withInput();
    }

    public function moreInfo(Request $request)
    {
        $economic_complement = EconomicComplement::where('id',$request->id_complemento)->first();

        if($request->has("number_accounting"))
        {
            $economic_complement->number_accounting = $request->number_accounting;
        }
        if($request->has("number_budget"))
        {
            $economic_complement->number_budget = $request->number_budget;
        }

        if($request->has("number_check"))
        {
            $economic_complement->number_check = $request->number_check;
        }

        $economic_complement->save();

        return back()->withInput();

    }
    public function saveSpouse(Request $request)
    {
            // return $request->all();

            $economic_complement = EconomicComplement::where('id',$request->complement_id)->first();

            if($request->has('is_paid_spouse'))
            {

                $spouse = Spouse::where('affiliate_id',$economic_complement->affiliate_id)->first();

                if (!$spouse) { $spouse = new Spouse; }

                $spouse->user_id = Auth::user()->id;
                $spouse->affiliate_id = $economic_complement->affiliate_id;
                $spouse->identity_card = trim($request->identity_card);
                $spouse->city_identity_card_id = $request->city_identity_card_id;
                $spouse->last_name = trim($request->last_name);
                $spouse->mothers_last_name = trim($request->mothers_last_name);
                $spouse->surname_husband = trim($request->surname_husband);
                $spouse->first_name = trim($request->first_name);
                $spouse->second_name = trim($request->second_name);
                $spouse->birth_date = Util::datePick($request->birth_date);
                $spouse->city_birth_id = $request->city_birth_id;
                $spouse->civil_status = trim($request->civil_status);
                $spouse->registration=0;
     
                $spouse->save();

                $message = "Información de Conyuge actualizado con éxito";

                Session::flash('message', $message);
            }else
            {

            }

            $economic_complement->is_paid_spouse =$request->has('is_paid_spouse')?true:false;
            $economic_complement->save();

            return redirect('economic_complement/'.$economic_complement->id);

    }

    public function automatic_validation(Request $request)
    {   global $results,$rev,$nrev;
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        ini_set('max_input_time', '-1');
        set_time_limit('-1');
        if($request->filexl == false)
        {
            //validacion con el anterior semestre
            $rev=0;
            $nrev=0;
            $ecom1 = EconomicComplement::where('eco_com_procedure_id','=',2)
                                        ->whereIn('eco_com_state_id',[1,18,17])->get();
            foreach ($ecom1 as $dato) 
            {   
                 $actual = EconomicComplement::where('eco_com_procedure_id','=',6)
                                        ->where('wf_current_state_id','=',3)
                                        ->where('economic_complements.reception_type','=','Habitual')
                                        ->where('state','=','Received')
                                        ->where('affiliate_id','=',$dato->affiliate_id)->first();
                if($actual)
                {   
                    $actual->state='Edited';
                    $date = Carbon::Now();
                    $actual->review_date =$date; 
                    $actual->save();
                    $rev++;
                }
                else
                {
                    $nrev++;
                }
            }
        }
        elseif($request->filexl == true)
        {
            //validacion desde excel pagados por muserpol
            if($request->hasFile('archive'))
            {
                $reader = $request->file('archive');
                $filename = $reader->getRealPath();
                Excel::load($filename, function($reader) {
                      global $results;
                      ini_set('memory_limit', '-1');
                      ini_set('max_execution_time', '-1');
                      ini_set('max_input_time', '-1');
                      set_time_limit('-1');
                      $results = collect($reader->get());
                });
                
               foreach ($results as $result) 
               {
                     $ci = $result->ci;
                    
                     if($result->tipo_renta == "VEJEZ")
                     {   //dd($result->tipo_renta."hola");
                        $app=EconomicComplementApplicant::leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                                     ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                                                     ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                                     ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                                     ->where('eco_com_types.id','=',1)
                                                     //->where('eco_com_applicants.identity_card','=',rtrim($ci))
                                                     ->whereRaw("ltrim(trim(eco_com_applicants.identity_card),'0') ='".ltrim(trim($ci),'0')."'")
                                                     ->where('economic_complements.eco_com_procedure_id','=',6)
                                                     ->where('economic_complements.reception_type','=','Habitual')
                                                     ->where('economic_complements.wf_current_state_id','=',3)
                                                     ->where('economic_complements.state','=','Received')
                                                     ->select('economic_complements.id','economic_complements.affiliate_id')
                                                     ->first();
                       
                         if($app)
                         {   
                             $ecom = EconomicComplement::where('id','=',$app->id)->first();                     
                             $ecom->state = 'Edited';
                             $date = Carbon::Now();
                             $ecom->review_date =$date; 
                             $ecom->save(); 
                            // dd($ecom->id);
                             $rev++;
                         }else
                         {
                              
                             //  $this->info("Vejez: ".$result->ci);
                            $nrev = $nrev."-".$result->ci;
                         }
                     
                     }
                     elseif($result->tipo_renta =='VIUDEDAD')
                     {   
                        $app=EconomicComplementApplicant::leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                                    ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                                                    ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                                    ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                                    ->where('eco_com_types.id','=',2)
                                                    //->where('eco_com_applicants.identity_card','=',rtrim($ci))
                                                    ->whereRaw("ltrim(trim(eco_com_applicants.identity_card),'0') ='".ltrim(trim($ci),'0')."'")
                                                    ->where('economic_complements.eco_com_procedure_id','=',6)
                                                    ->where('economic_complements.reception_type','=','Habitual')
                                                    ->where('economic_complements.wf_current_state_id','=',3)
                                                    ->where('economic_complements.state','=','Received')
                                                    ->select('economic_complements.id','economic_complements.affiliate_id')
                                                    ->first();
                        //dd($app."--");        
                         if($app)
                         {   $ecom = EconomicComplement::where('id','=',$app->id)->first();
                             $ecom->state='Edited';
                             $date = Carbon::Now();
                             $ecom->review_date =$date; 
                             $ecom->save(); 
                             // dd($ecom->id." Viu");
                             $rev++;
                         }
                         else
                         {
                               //$this->info("Viudedad: ".$result->ci);
                            $nrev = $nrev."-".$result->ci;
                         }
                     }
                }
           }

        }
        $message = "Revizados:".$rev." "."No revizados:".$nrev;

        Session::flash('message', $message);
        return redirect('economic_complement');
    }


}
