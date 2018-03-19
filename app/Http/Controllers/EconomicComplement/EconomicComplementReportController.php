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
use Maatwebsite\Excel\Facades\Excel;

use Muserpol\EconomicComplement;
use Muserpol\EconomicComplementProcedure;
use Muserpol\EconomicComplementRent;
use Muserpol\EconomicComplementState;
use Muserpol\EconomicComplementStateType;
use Muserpol\EconomicComplementType;
use Muserpol\EconomicComplementModality;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplementApplicantType;
use Muserpol\EconomicComplementLegalGuardian;
use Muserpol\EconomicComplementRequirement;
use Muserpol\EconomicComplementSubmittedDocument;
use Muserpol\Affiliate;
use Muserpol\Spouse;
use Muserpol\PensionEntity;
use Muserpol\City;
use Muserpol\Degree;
use Muserpol\Unit;
use Muserpol\Category;
use Muserpol\ObservationType;
use Muserpol\AffiliateObservation;
use DB;
use stdClass;

class EconomicComplementReportController extends Controller
{
    public static function reports_lists(){
        return $reports_list = [
        '' => '',
        '1' => 'Trámites con Pensión Solidaria de Vejez',
        '2' => 'Todos los Trámites',
        '3' => 'Diferencia de Promedio (Un semestre anterior)',
        '4' => 'Trámites con concurrencia',
        '5' => 'Trámites Excluidos por Salario',
        '6' => 'Cambio de Grado (Comparación con un semestre Anterior)',
        '7' => 'Cambio de Categoría (Comparación con un semestre Anterior)',
        '8' => 'Trámites con Apoderados',
        '9' => 'Trámites Validados con Observaciones',
        '10' => 'Trámites No Validados con Observaciones',
        '11' => 'Planilla Banco Union S.A.'

        // '2' => 'Trámites Inclusiones',
        // '3' => 'Trámites habituales',
      ];
    }
    public function index()
    {
        return view('economic_complements.print.report_generator', self::getViewModel());
    }
    public function average()
    {
        return view('economic_complements.average_list', self::getViewModel());
    }

    public static function getViewModel()
    {
       $cities = City::all();
       $cities_list = array('Todo' => 'Todo');
       foreach ($cities as $item) {
           $cities_list[$item->id]=$item->name;
       }

       $semestre = ['Todo' => 'Todo','F' => 'Primer', 'S' => 'Segundo'];
       foreach ($semestre as $item) {
           $semester_list[$item]=$item;
       }

       $semester1 = ['F' => 'Primer','S' => 'Segundo'];
       foreach ($semester1 as $item) {
           $semester1_list[$item]=$item;
       }

       $current_year = Util::getCurrentYear();
       $year_list =[$current_year => $current_year];
       $eco_com_year = EconomicComplement::distinct()->select('year')->orderBy('year', 'desc')->get();
       foreach ($eco_com_year as $item) {
           $year_list[Util::getYear($item->year)] = Util::getYear($item->year);
       }

       $report_type =
        ['' => '',
          '1' => 'Reporte de Recepción por Usuario', 
          // '2' => 'Reporte de beneficiarios',
          '3' => 'Reporte de apoderados',
          // '5' => 'Resumen de habituales',
          // '6' => 'Resumen de inclusiones',
          // '7' => 'Reporte por Intervalo de fechas',
          // '8' => 'Reporte Subsanados',
          // '9' => 'Reporte en Excel',
          // '10' => 'Reporte de excluidos por salario'
          '11' => 'Reporte Inclusiones',
        ];
       // $report_type = ['' => '', '1' => 'Reporte de recepción por usuario', '2' => 'Reporte de beneficiarios', '3' => 'Reporte de apoderados', '4' => 'Reporte de doble percepción', '5' => 'Resumen de habituales', '6' => 'Resumen de inclusiones', '7' => 'Reporte por Intervalo de fechas','8' => 'Reporte Subsanados','9' => 'Reporte en Excel','10' => 'Reporte de excluidos por salario'];
       foreach ($report_type as $key => $item) {
           $report_type_list[$key] = $item;
       }

     return [
           'cities_list' => $cities_list,
           'semester_list' => $semester_list,
           'year_list' => $year_list,
           'report_type_list' => $report_type_list,
           'semester1_list' => $semester1_list
       ];
   }

   public function report_generator(Request $request)
   {  
    // return $request->all();
           if($request->has('type')) {
               switch ($request->type) {
                   case '1':
                           $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                           $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                           $title = "REPORTE DIARIO DE TRÁMITES DEL COMPLEMENTO ECONÓMICO ".$request->get('from')." AL ".$request->get('to');
                           $date = Util::getDateEdit(date('Y-m-d'));
                           setlocale(LC_ALL, "es_ES.UTF-8");
                           $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
                           $type = "user"; 
                           $user = Auth::user();   
                           $user_role = Util::getRol()->name;                       
                           $current_date = Carbon::now();
                           $anio = Util::getYear($request->from);
                           $hour = Carbon::parse($current_date)->toTimeString();                           
                           $from = Util::datePick($request->get('from'));
                           $to = Util::datePick($request->get('to'));                          
                           $eco_complements = DB::table('eco_com_applicants')
                                           ->select(DB::raw("economic_complements.id,economic_complements.code,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,economic_complements.reception_type,eco_com_applicants.identity_card,cities1.first_shortened as exp, trim(regexp_replace(CONCAT(eco_com_applicants.first_name,' ',eco_com_applicants.second_name,' ',eco_com_applicants.last_name,' ',eco_com_applicants.mothers_last_name,' ',eco_com_applicants.surname_husband),'( )+' , ' ', 'g')) full_name, degrees.shortened,eco_com_types.name,pension_entities.name as pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number"))
                                           ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                           ->leftJoin('users','economic_complements.user_id','=','users.id')
                                           ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                           ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                           ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                           ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')                                           
                                           ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                           ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                           ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                           ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                           ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                           ->leftJoin('units','affiliates.unit_id','=','units.id')
                                           ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                           ->whereDate('reception_date','>=', $from)->whereDate('reception_date','<=', $to)                                         
                                           ->where('economic_complements.user_id', '=', Auth::user()->id)                                          
                                           ->orderBy('economic_complements.id','ASC')
                                           ->get();

                           if ($eco_complements) {
                               
                               return \PDF::loadView('economic_complements.print.daily_report',compact('header1','header2','title','date','type','hour','anio','user','eco_complements','user_role'))->setPaper('letter')->setOption('encoding', 'utf-8')->setOrientation('landscape')->setOption('footer-right', 'Pagina [page] de [toPage]')->setOption('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_by_user.pdf');

                               /*$view = \View::make('economic_complements.print.daily_report',compact('header1','header2','title','date','type','hour','anio','user','eco_complements'))->render();
                               $pdf = \App::make('dompdf.wrapper');
                               $pdf->loadHTML($view)->setPaper('legal','landscape');
                               return $pdf->stream(); */  


                           } else {
                               $message = "No existen registros para visualizar";
                               Session::flash('message', $message);
                               return redirect('report_complement');
                           }
                   break;
                   case '2':
                           $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                           $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                           $title = "REPORTE DE BENEFICIARIOS DEL COMPLEMENTO ECONÓMICO";
                           $date = Util::getDateEdit(date('Y-m-d'));
                           $type = "user";
                           $user = Auth::user();
                           $user_role = Util::getRol()->name;
                           $anio = $request->year;
                           $current_date = Carbon::now();
                           $hour = Carbon::parse($current_date)->toTimeString();
                           $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                           $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                           $beneficiary_eco_complements = DB::table('eco_com_applicants')
                                           ->select(DB::raw("economic_complements.id, economic_complements.code,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,economic_complements.reception_type,cities.second_shortened as city,eco_com_applicants.identity_card,cities1.first_shortened as exp, trim(regexp_replace(CONCAT(eco_com_applicants.first_name,' ',eco_com_applicants.second_name,' ',eco_com_applicants.last_name,' ',eco_com_applicants.mothers_last_name,' ',eco_com_applicants.surname_husband),'( )+' , ' ', 'g')) full_name, degrees.shortened,eco_com_types.name,pension_entities.name pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number"))
                                           ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                           ->leftJoin('users','economic_complements.user_id','=','users.id')
                                           ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                           ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                           ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                           ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                           //->leftJoin('eco_com_applicant_types', 'eco_com_applicants.eco_com_applicant_type_id', '=', 'eco_com_applicant_types.id')
                                           ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                           ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                           ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                           ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                           ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                           ->leftJoin('units','affiliates.unit_id','=','units.id')
                                           ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                           ->whereRaw("economic_complements.city_id::text LIKE  '".$regional."'")
                                           ->whereYear('economic_complements.year', '=', $request->year)
                                           ->where('economic_complements.semester', 'LIKE', $semester)                                           
                                           ->orderBy('economic_complements.id','ASC')
                                           ->get();
                                           //dd($regional);                                           
                           if ($beneficiary_eco_complements) {                              
                             return \PDF::loadView('economic_complements.print.beneficiary_report',compact('header1','header2','title','date','type','hour','beneficiary_eco_complements','anio','user','user_role'))->setPaper('letter')->setOrientation('landscape')->setOption('footer-right', 'Pagina [page] de [toPage]')->setOption('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_beneficiary.pdf');

                             /*$view = \View::make('economic_complements.print.beneficiary_report',compact('header1','header2','title','date','type','hour','beneficiary_eco_complements','anio','user'))->render();
                                $pdf = \App::make('dompdf.wrapper');
                                $pdf->loadHTML($view)->setPaper('legal','landscape');
                                return $pdf->stream();*/

                           } else {
                               $message = "No existen registros para visualizar";
                               Session::flash('message', $message);
                               return redirect('report_complement');
                           }

                   break;
                   case '3':
                           $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                           $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                           $title = "REPORTE DE APODERADOS DEL COMPLEMENTO ECONÓMICO";
                           $date = Util::getDateEdit(date('Y-m-d'));
                           $type = "user";
                           $current_date = Carbon::now();
                           $hour = Carbon::parse($current_date)->toTimeString();
                           $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                           $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                           $representative_eco_complements = DB::table('eco_com_legal_guardians')
                                           ->select(DB::raw("economic_complements.id,economic_complements.affiliate_id,
                                           economic_complements.code,economic_complements.semester,economic_complements.reception_date,
                                           cities.name as city,eco_com_applicants.identity_card,cities1.first_shortened as exp, 
                                           concat_ws(' ', NULLIF(eco_com_applicants.last_name,null), NULLIF(eco_com_applicants.mothers_last_name, null),
                                            NULLIF(eco_com_applicants.surname_husband, null), NULLIF(eco_com_applicants.first_name, null), 
                                            NULLIF(eco_com_applicants.second_name, null)) as full_name, degrees.shortened,
                                            eco_com_types.name,pension_entities.name pension_entity,users.username,
                                            eco_com_legal_guardians.identity_card as ci, cities2.first_shortened as exp1,
                                            concat_ws(' ',NULLIF(eco_com_legal_guardians.last_name,null), 
                                            NULLIF(eco_com_legal_guardians.mothers_last_name,null), NULLIF(eco_com_legal_guardians.first_name,null),
                                            NULLIF(eco_com_legal_guardians.second_name,null)) as full_repre,eco_com_applicants.phone_number,
                                            eco_com_applicants.cell_phone_number,
                                            economic_complements.has_legal_guardian as has_legal_guardian,
                                            economic_complements.has_legal_guardian_s as has_legal_guardian_s"))
                                           //->leftJoin('eco_com_applicants','eco_com_legal_guardians.eco_com_applicant_id','=', 'eco_com_applicants.id')
                                           ->leftJoin('economic_complements','eco_com_legal_guardians.economic_complement_id','=','economic_complements.id')
                                           ->leftJoin('eco_com_applicants','economic_complements.id','=', 'eco_com_applicants.economic_complement_id')
                                           ->leftJoin('users','economic_complements.user_id','=','users.id')
                                           ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                           ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                           ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                           ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                           ->leftJoin('cities as cities2', 'eco_com_legal_guardians.city_identity_card_id', '=', 'cities2.id')
                                           //->leftJoin('eco_com_applicant_types', 'eco_com_applicants.eco_com_applicant_type_id', '=', 'eco_com_applicant_types.id')
                                           ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                           ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                           ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                           ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                           ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                           ->leftJoin('units','affiliates.unit_id','=','units.id')
                                           ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                           ->whereRaw("economic_complements.city_id::text LIKE '".$regional."'")
                                           ->whereYear('economic_complements.year', '=', $request->year)
                                           ->where('economic_complements.semester', 'LIKE', rtrim($semester))
                                           ->where('economic_complements.has_legal_guardian','=',true)
                                           ->orderBy('economic_complements.id','ASC')
                                           ->get();
                           if ($representative_eco_complements) {
                               $view = \View::make('economic_complements.print.representative_report', compact('header1','header2','title','date','hour','representative_eco_complements'))->render();
                               $pdf = \App::make('dompdf.wrapper');
                               $pdf->loadHTML($view)->setPaper('legal','landscape');
                               return $pdf->stream();
                           } else {
                               $message = "No existen registros para visualizar";
                               Session::flash('message', $message);
                               return redirect('report_complement');
                           }
                       break;
                       case '4':
                               $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                               $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                               $title = "REPORTE DE BENEFICIARIOS CON DOBLE PERCEPCION DE COMPLEMENTO ECONÓMICO";
                               $date = Util::getDateEdit(date('Y-m-d'));
                               $type = "user";
                               $current_date = Carbon::now();
                               $hour = Carbon::parse($current_date)->toTimeString();
                               $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                               $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                               $double_perception_eco_complements_1 = DB::table('eco_com_applicants')
                                               ->select(DB::raw("eco_com_applicants.identity_card"))
                                               ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                               ->leftJoin('users','economic_complements.user_id','=','users.id')
                                               ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                               ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                               ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                               ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                              // ->leftJoin('eco_com_applicant_types', 'eco_com_applicants.eco_com_applicant_type_id', '=', 'eco_com_applicant_types.id')
                                               ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                               ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                               ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                               ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                               ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                               ->leftJoin('units','affiliates.unit_id','=','units.id')
                                               ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                               ->whereRaw("economic_complements.city_id::text LIKE '".$regional."'")
                                               ->whereYear('economic_complements.year', '=', $request->year)
                                               ->where('economic_complements.semester', 'LIKE', $semester)
                                               ->groupBy('eco_com_applicants.identity_card')
                                               ->havingRaw("COUNT(eco_com_applicants.identity_card) > 1")->orderBy('eco_com_applicants.identity_card','ASC')->get();

                                               $double_perception_eco_complements = array();
     
                                                foreach($double_perception_eco_complements_1 as $dp){
                                                              
                                                              //dd($dp->identity_card);

                                                              $double_perception_eco_complements_2 = DB::table('eco_com_applicants')
                                                             ->select(DB::raw("economic_complements.id, economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.first_shortened as exp,concat_ws(' ', NULLIF(eco_com_applicants.last_name,null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null), NULLIF(eco_com_applicants.first_name, null), NULLIF(eco_com_applicants.second_name, null)) as full_name , degrees.shortened,eco_com_types.name,pension_entities.name as pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number"))
                                                             ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                                             ->leftJoin('users','economic_complements.user_id','=','users.id')
                                                             ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                                             ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                                             ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                                             ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                                            // ->leftJoin('eco_com_applicant_types', 'eco_com_applicants.eco_com_applicant_type_id', '=', 'eco_com_applicant_types.id')
                                                             ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                                             ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                                             ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                                             ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                                             ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                                             ->leftJoin('units','affiliates.unit_id','=','units.id')
                                                             ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                                             ->whereRaw("economic_complements.city_id::text LIKE '".$regional."'")
                                                             ->whereYear('economic_complements.year', '=', $request->year)
                                                             ->where('economic_complements.semester', 'LIKE', $semester)
                                                             ->where('affiliates.identity_card', '=', $dp->identity_card)
                                                             ->first();
                                                             array_push($double_perception_eco_complements, $double_perception_eco_complements_2);
                                              } 

                                              

                               if ($double_perception_eco_complements) {
                                   $view = \View::make('economic_complements.print.double_perception_report', compact('header1','header2','title','date','type','hour','double_perception_eco_complements'))->render();
                                   $pdf = \App::make('dompdf.wrapper');
                                   $pdf->loadHTML($view)->setPaper('legal','landscape');
                                   return $pdf->stream();
                               } else {
                                   $message = "No existen registros para visualizar";
                                   Session::flash('message', $message);
                                   return redirect('report_complement');
                               }

                       break;
                       case '5':
                       $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                       $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                       $title = "REPORTE HABITUALES DE COMPLEMENTO ECONÓMICO";
                       $date = Util::getDateEdit(date('Y-m-d'));
                       $type = 'user';
                       $current_date = Carbon::now();
                       $hour = Carbon::parse($current_date)->toTimeString();
                       $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                       $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                       $cities1 = City::all();
                       foreach ($cities1 as $key => $item1) {
                           $eco_com_types = EconomicComplementType::all();
                           foreach ($eco_com_types as $item2) {
                               $degrees = Degree::all();
                               foreach ($degrees as $item3) {
                                   $habitual = DB::table('v_habitual')
                                            ->select(DB::raw('count(v_habitual.id) total'))
                                            ->whereYear('v_habitual.year1', '=', $request->year)
                                            ->where('v_habitual.semester', 'LIKE', $semester)
                                            ->where('v_habitual.city_id', '=', $item1->id)
                                            ->where('v_habitual.type_id','=', $item2->id)
                                            ->where('v_habitual.degree_id','=', $item3->id)->first();
                                    $degree_list[$item3->id]= $habitual;
                               }
                               $types_list[$item2->name] = $degree_list;
                               $degree_list = null;
                           }
                           $deparment_list[$item1->first_shortened] = $types_list;
                           $types_list = null;
                       }
                       // total national by degree
                       $eco_com_types1 = EconomicComplementType::all();
                       $totaln = 0;
                       foreach ($eco_com_types1 as $ec_types) {
                           $degrees1 = Degree::all();
                           $st = 0;
                           foreach ($degrees1 as $degree) {
                               $inclusion1 = DB::table('v_habitual')
                                        ->select(DB::raw('count(v_habitual.id) total'))
                                        ->whereYear('v_habitual.year1', '=', $request->year)
                                        ->where('v_habitual.semester', 'LIKE', $semester)
                                        ->where('v_habitual.type_id','=', $ec_types->id)
                                        ->where('v_habitual.degree_id','=', $degree->id)->first();
                                $degree_list1[$degree->id]= $inclusion1;
                                $st = $st + $inclusion1->total;
                           }
                           $totaln = $totaln + $st;
                           $types_list1[$ec_types->name] = $degree_list1;
                           $degree_list1 = null;
                       }
                       //dd($deparment_list);
                       if ($deparment_list) {
                           $view = \View::make('economic_complements.print.summary_habitual', compact('header1','header2','title','date','type','hour','deparment_list','types_list1','totaln'))->render();
                           $pdf = \App::make('dompdf.wrapper');
                           $pdf->loadHTML($view)->setPaper('legal','landscape');
                           return $pdf->stream();
                       } else {
                           $message = "No existen registros para visualizar";
                           Session::flash('message', $message);
                           return redirect('report_complement');
                       }
                       break;
                       case '6':
                       $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                       $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                       $title = "REPORTE INCLUSIONES DE COMPLEMENTO ECONÓMICO";
                       $date = Util::getDateEdit(date('Y-m-d'));
                       $type = "user";
                       $current_date = Carbon::now();
                       $hour = Carbon::parse($current_date)->toTimeString();
                       //$regional = ($request->city == 'Todo') ? '%%' : $request->city;
                       $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                       $cities1 = City::all();
                       foreach ($cities1 as $key => $item1) {
                           $eco_com_types = EconomicComplementType::all();
                           foreach ($eco_com_types as $item2) {
                               $degrees = Degree::all();
                               foreach ($degrees as $item3) {
                                   $inclusion = DB::table('v_inclusion')
                                            ->select(DB::raw('count(v_inclusion.id) total'))
                                            ->whereYear('v_inclusion.year1', '=', $request->year)
                                            ->where('v_inclusion.semester', 'LIKE', $semester)
                                            ->where('v_inclusion.city_id', '=', $item1->id)
                                            ->where('v_inclusion.type_id','=', $item2->id)
                                            ->where('v_inclusion.degree_id','=', $item3->id)->first();
                                    $degree_list[$item3->id]= $inclusion;
                               }
                               $types_list[$item2->name] = $degree_list;
                               $degree_list = null;
                           }
                           $deparment_list[$item1->first_shortened] = $types_list;
                           $types_list = null;
                       }
                       // total national by degree
                       $eco_com_types1 = EconomicComplementType::all();
                       $totaln = 0;
                       foreach ($eco_com_types1 as $ec_types) {
                           $degrees1 = Degree::all();
                           $st = 0;
                           foreach ($degrees1 as $degree) {
                               $inclusion1 = DB::table('v_inclusion')
                                        ->select(DB::raw('count(v_inclusion.id) total'))
                                        ->whereYear('v_inclusion.year1', '=', $request->year)
                                        ->where('v_inclusion.semester', 'LIKE', $semester)
                                        ->where('v_inclusion.type_id','=', $ec_types->id)
                                        ->where('v_inclusion.degree_id','=', $degree->id)->first();
                                $degree_list1[$degree->id]= $inclusion1;
                                $st = $st + $inclusion1->total;
                           }
                           $totaln = $totaln + $st;
                           $types_list1[$ec_types->name] = $degree_list1;
                           $degree_list1 = null;
                       }
                       //dd($types_list1);
                       if ($deparment_list) {
                           $view = \View::make('economic_complements.print.summary_inclusion', compact('header1','header2','title','date','type','hour','deparment_list','types_list1','totaln'))->render();
                           $pdf = \App::make('dompdf.wrapper');
                           $pdf->loadHTML($view)->setPaper('legal','landscape');
                           return $pdf->stream();
                       } else {
                           $message = "No existen registros para visualizar";
                           Session::flash('message', $message);
                           return redirect('report_complement');
                       }
                       break;
                       case '7':
                           $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                           $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                           $title = "REPORTE DE TRÁMITES DEL COMPLEMENTO ECONÓMICO DEL ".$request->get('from')." AL ".$request->get('to');
                           $date = Util::getDateEdit(date('Y-m-d'));
                           $type = "user";                          
                           $current_date = Carbon::now();
                           $anio = Util::getYear($request->from);
                           $hour = Carbon::parse($current_date)->toTimeString();                           
                           $from = Util::datePick($request->get('from'));
                           $to = Util::datePick($request->get('to'));                          
                           $eco_complements = DB::table('eco_com_applicants')
                                           ->select(DB::raw("economic_complements.id,economic_complements.code,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,economic_complements.reception_type,cities.second_shortened as city,eco_com_applicants.identity_card,cities1.first_shortened as exp, concat_ws(' ', NULLIF(eco_com_applicants.last_name,null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null), NULLIF(eco_com_applicants.first_name, null), NULLIF(eco_com_applicants.second_name, null)) full_name, degrees.shortened,eco_com_types.name,pension_entities.name as pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number"))
                                           ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                           ->leftJoin('users','economic_complements.user_id','=','users.id')
                                           ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                           ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                           ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                           ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')                                           
                                           ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                           ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                           ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                           ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                           ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                           ->leftJoin('units','affiliates.unit_id','=','units.id')
                                           ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                           ->whereDate('reception_date','>=', $from)->whereDate('reception_date','<=', $to)                                           
                                           ->orderBy('economic_complements.id','ASC')
                                           ->get();
                           if ($eco_complements) {
                               
                               return \PDF::loadView('economic_complements.print.daily_report',compact('header1','header2','title','date','type','hour','eco_complements','anio','user'))->setPaper('letter')->setOrientation('landscape')->setOption('footer-right', 'Pagina [page] de [toPage]')->setOption('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_by_user.pdf');
                           } else {
                               $message = "No existen registros para visualizar";
                               Session::flash('message', $message);
                               return redirect('report_complement');
                           }
                           break;
                        case '8':                          
                                if($request->year <'2018'){
                                global $list,$list_date,$final;
                                $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                                $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                                $list = DB::table('eco_com_applicants')
                                               ->select(DB::raw("economic_complements.id, economic_complements.code,economic_complements.semester,eco_com_modalities.shortened as modality,eco_com_types.id as tipo_comple,eco_com_types.name as eco_type,eco_com_states.name as eco_state,economic_complements.reception_date,degrees.shortened as afi_degree,pension_entities.name as pension_entity,cities.name as city,eco_com_applicants.identity_card as ap_identity_card,cities1.first_shortened as ap_exp, eco_com_applicants.last_name as ap_last_name, eco_com_applicants.mothers_last_name as ap_mothers_last_name, eco_com_applicants.surname_husband as ap_surname_husband, eco_com_applicants.first_name as ap_first_name, eco_com_applicants.second_name as ap_second_name, eco_com_applicants.phone_number as ap_phone_number,eco_com_applicants.cell_phone_number as ap_cell_phone_number,affiliates.identity_card as afi_identity_card,cities0.first_shortened as afi_exp,affiliates.last_name as afi_last_name,affiliates.mothers_last_name as afi_mothers_last_name,affiliates.first_name as afi_first_name,affiliates.second_name as afi_second_name,affiliates.surname_husband as afi_surname_husband,affiliates.gender as afi_gender,affiliates.civil_status as afi_civil_status,affiliates.birth_date as afi_birth_date,users.username"))
                                               ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                               ->leftJoin('users','economic_complements.user_id','=','users.id')
                                               ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                               ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                               ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                               ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')                                               
                                               ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                               ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                               ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                               ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                               ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                               ->leftJoin('units','affiliates.unit_id','=','units.id')
                                               ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                               ->whereRaw("economic_complements.city_id::text LIKE  '".$regional."'")
                                               ->whereYear('economic_complements.year', '=', $request->year)
                                               ->where('economic_complements.semester', 'LIKE', $semester)                      
                                               ->orderBy('economic_complements.id','ASC')
                                               ->get();
                                $deu =0;
                                //dd($list);
                                foreach ($list as $comple) 
                                {   if($comple->tipo_comple == 1 || $comple->tipo_comple == 2)
                                    {

                                          $req = DB::table('eco_com_submitted_documents')->select(DB::raw('eco_com_submitted_documents.eco_com_requirement_id,eco_com_requirements.shortened,eco_com_submitted_documents.reception_date as req_date,eco_com_submitted_documents.status,eco_com_submitted_documents.created_at as req_update'))
                                                                              ->leftJoin('eco_com_requirements','eco_com_submitted_documents.eco_com_requirement_id','=','eco_com_requirements.id')
                                                                              ->where('eco_com_submitted_documents.economic_complement_id','=',$comple->id)->orderBy('eco_com_submitted_documents.eco_com_requirement_id','ASC')->get();
                                          //dd($req);  
                                          $num =0;                                                                                             
                                          foreach ($req as $item) 
                                          {                                                         
                                              //dd($item->eco_com_requirement_id);
                                              if($comple->tipo_comple == 1 && $item->eco_com_requirement_id == 4)
                                              {
                                                  $list_date["req_date"] =  $item->req_date;
                                                  $list_date["req_update"] =  $item->req_update;
                                              }
                                              elseif($comple->tipo_comple == 2 && $item->eco_com_requirement_id == 12)
                                              {
                                                  $list_date["req_date"] =  $item->req_date;
                                                  $list_date["req_update"] =  $item->req_update;
                                              }
                                             
                                              // requirement is true  or false
                                              if($comple->tipo_comple != 3)
                                              {
                                                if($item->status == true)
                                                  {
                                                      $list_req["req".$num] = "SI";

                                                  }
                                                  else{
                                                      $list_req["req".$num] = "NO";
                                                  }
                                              }                                                  
                                              $num++;
                                          }

                                          
                                                                                
                                          $data_req = array_merge($list_date, $list_req);
                                          $ecom = (array)$comple;
                                          $list_c = array_merge($ecom,$data_req); 
                                          $final[$deu]  = $list_c;
                                          $deu++;
                                          
                                    }                               
                                                               
                                  
                                }                              
                              //dd($final);
                              Excel::create('Filename', function($excel) use($final) {

                                  $excel->sheet('Sheetname', function($sheet) use($final) {

                                      $sheet->fromArray($final);

                                  });

                              })->export('xls');  
                              }else{
                                       $message = "No existen registros para visualizar de ". $request->semester."-".$request->year;
                               Session::flash('message', $message);
                               return redirect('report_complement');
                              }                          
                                
                              break;                                   

                           
                            
                            
                        case '9':
                                global $list;
                                $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                                $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                                $list = DB::table('eco_com_applicants')
                                               ->select(DB::raw("economic_complements.id, economic_complements.code,economic_complements.semester,eco_com_modalities.shortened as modality,eco_com_types.name as eco_type,eco_com_states.name as eco_state,economic_complements.reception_date,degrees.shortened as afi_degree,pension_entities.name as pension_entity,cities.name as city,eco_com_applicants.identity_card as ap_identity_card,cities1.first_shortened as ap_exp, eco_com_applicants.last_name as ap_last_name, eco_com_applicants.mothers_last_name as ap_mothers_last_name, eco_com_applicants.surname_husband as ap_surname_husband, eco_com_applicants.first_name as ap_first_name, eco_com_applicants.second_name as ap_second_name, eco_com_applicants.phone_number as ap_phone_number,eco_com_applicants.cell_phone_number as ap_cell_phone_number,affiliates.identity_card as afi_identity_card,cities0.first_shortened as afi_exp,affiliates.last_name as afi_last_name,affiliates.mothers_last_name as afi_mothers_last_name,affiliates.first_name as afi_first_name,affiliates.second_name as afi_second_name,affiliates.surname_husband as afi_surname_husband,affiliates.gender as afi_gender,affiliates.civil_status as afi_civil_status,affiliates.birth_date as afi_birth_date,users.username"))
                                               ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                               ->leftJoin('users','economic_complements.user_id','=','users.id')
                                               ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                               ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                               ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                               ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')                                               
                                               ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                               ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                               ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                               ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                               ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                               ->leftJoin('units','affiliates.unit_id','=','units.id')
                                               ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                               ->whereRaw("economic_complements.city_id::text LIKE  '".$regional."'")
                                               ->whereYear('economic_complements.year', '=', $request->year)
                                               ->where('economic_complements.semester', 'LIKE', $semester)                                           
                                               ->orderBy('economic_complements.id','ASC')
                                               ->get();
                                //dd($list); 
                                if($list)
                                {   
                                    Excel::create('REPORTE EXCEL', function($excel) {
                                        global $semester, $j,$list;
                                        $j = 2;
                                        $excel->sheet("TRAMITES DE COMPLEMENTO", function($sheet) {
                                           global $semester, $j, $i,$list;
                                           $i=1;                                           
                                           $sheet->row(1, array('NRO', 'CODIGO','SEMESTRE','MODALIDAD','TIPO_COMPLEMENTO','ESTADO_COMPL','FECHA_RECEP','GRADO','ENTE_GESTOR','REGIONAL','BE_CI','BE_EXP','BE_PATERNO','BE_MATERNO','BE_AP_ESPOSO','BE_PNOMBRE','BE_SNOMBRE','BE_TELEFONO','BE_CELULAR','AF_CI', 'AF_EXP','AF_PATERNO','AF_MATERNO','AF_PNOMBRE','AF_SNOMBRE','AF_AP_ESPOSO','AF_SEXO','AF_ESTADO_CIVIL','AF_FECHA_NAC','USUARIO'));
                                           
                                           foreach ($list as $datos) {
                                               $sheet->row($j, array($i,$datos->code,$datos->semester,$datos->modality,$datos->eco_type,$datos->eco_state,$datos->reception_date,$datos->afi_degree,$datos->pension_entity,$datos->city,$datos->ap_identity_card,$datos->ap_exp,$datos->ap_last_name,$datos->ap_mothers_last_name,$datos->ap_surname_husband,$datos->ap_first_name, $datos->ap_second_name,$datos->ap_phone_number,$datos->ap_cell_phone_number,$datos->afi_identity_card,$datos->afi_exp,$datos->afi_last_name,$datos->afi_mothers_last_name,$datos->afi_first_name,$datos->afi_second_name, $datos->afi_surname_husband, $datos->afi_gender,$datos->afi_civil_status,$datos->afi_birth_date,$datos->username));
                                               $j++;
                                               $i++;
                                           }
                                        });
                                    })->export('xlsx');
                                }
                                else
                                {
                                  $message = "No existen registros para visualizar";
                                  Session::flash('message', $message);
                                  return redirect('report_complement');
                                }
                              break;
                        
                        case '10': //REPORTE EXCLUIDOS POR SALARIO
                                  $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                                  $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                                  $title = "REPORTE EXLUIDOS POR SALARIO";
                                  $date = Util::getDateEdit(date('Y-m-d'));                                 
                                  $user = Auth::user();
                                  $user_role = Util::getRol()->name;
                                  $anio = $request->year;
                                  $current_date = Carbon::now();
                                  $hour = Carbon::parse($current_date)->toTimeString();
                                  $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                                  $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                                  $excluded_by_salary = DB::table('eco_com_applicants')
                                                   ->select(DB::raw("economic_complements.id, economic_complements.code,economic_complements.affiliate_id,economic_complements.total_rent,economic_complements.salary_quotable,economic_complements.reception_type,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.first_shortened as exp, concat_ws(' ', NULLIF(eco_com_applicants.last_name,null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null), NULLIF(eco_com_applicants.first_name, null), NULLIF(eco_com_applicants.second_name, null)) full_name, degrees.shortened as degree,eco_com_modalities.shortened as modality,pension_entities.name as pension_entity"))
                                                   ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')                                               
                                                   ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                                   ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                                   ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                                   ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')                                                   
                                                   ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                                   ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                                   ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                                   ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                                   ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                                   ->leftJoin('units','affiliates.unit_id','=','units.id')
                                                   ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                                   ->whereRaw("economic_complements.city_id::text LIKE  '".$regional."'")
                                                   ->whereYear('economic_complements.year', '=', $request->year)
                                                   ->where('economic_complements.semester', 'LIKE', $semester)
                                                   ->whereRaw("economic_complements.total_rent::numeric >= economic_complements.salary_quotable::numeric")                                       
                                                   ->orderBy('economic_complements.id','ASC')
                                                   ->get();                                           
                                  if ($excluded_by_salary) {                             
                                      $view = \View::make('economic_complements.print.report_excluded_by_salary', compact('header1','header2','title','date','hour','excluded_by_salary','anio','user_role'))->render();
                                      $pdf = \App::make('dompdf.wrapper');
                                      $pdf->loadHTML($view)->setPaper('letter','landscape');
                                      return $pdf->stream();

                                  } 
                                  else 
                                  {
                                       $message = "No existen registros para visualizar";
                                       Session::flash('message', $message);
                                       return redirect('report_complement');
                                  }

                              break;
                        case "11": //REPORTE HABITUALES
                                  global $j,$ecom,$regional,$semester;
                                  $j=2;
                                  $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                                  $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                                  $ecom = DB::table('eco_com_applicants')
                                              ->Select(DB::raw('economic_complements.code,eco_com_applicants.identity_card,cities2.first_shortened as ext,eco_com_applicants.first_name,eco_com_applicants.second_name,eco_com_applicants.last_name,eco_com_applicants.mothers_last_name,eco_com_applicants.surname_husband,cities1.name as regional,degrees.shortened as degree,categories.name as category,eco_com_modalities.shortened as modality,pension_entities.name as pension_entity,economic_complements.total,economic_complements.amount_loan,economic_complements.amount_accounting,  economic_complements.amount_replacement, (coalesce(economic_complements.total,0) + coalesce(economic_complements.amount_loan,0) + coalesce(economic_complements.amount_accounting,0) + coalesce(economic_complements.amount_replacement,0)) as subtotal,economic_complements.state'))
                                              ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                              ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')              
                                              ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                              ->leftJoin('cities as cities1','economic_complements.city_id','=','cities1.id')
                                              ->leftJoin('cities as cities2', 'eco_com_applicants.city_identity_card_id','=', 'cities2.id')
                                              ->leftJoin('degrees','economic_complements.degree_id','=','degrees.id')
                                              ->leftJoin('categories','economic_complements.category_id', '=', 'categories.id')
                                              ->leftJoin('pension_entities', 'affiliates.pension_entity_id','=','pension_entities.id')
                                              ->whereRaw("economic_complements.city_id::text LIKE  '".$regional."'")             
                                              ->whereYear('economic_complements.year','=', $request->year)
                                              ->where('economic_complements.semester','=', $semester)
                                              ->where('economic_complements.workflow_id','=',1)                                              
                                              ->where('economic_complements.wf_current_state_id',3)
                                              ->where('economic_complements.reception_type','=','Inclusion')                                             
                                              ->get(); 
                                
                                  
                                  if(sizeof($ecom) > 0)
                                  {
                                    Excel::create('Inclusiones'.$semester, function($excel)
                                    { global $ecom, $semester;
                                      $excel->sheet("Inclusiones".$semester, function($sheet)
                                      {
                                        global $i,$j, $ecom,$tip;
                                        $i=1;
                                        $sheet->row(1, array('NRO','CODIGO_TRAMITE','CI','EXT','PRIMER_NOMBRE','SEGUNDO_NOMBRE','PATERNO', 'MATERNO', 'APELLIDO_DE_CASADO', 'REGIONAL','GRADO','CATEGORIA','TIPO_RENTA','ENTE_GESTOR','SUBTOTAL','AMORTIZACION_PRESTAMOS','AMORTIZACION_CONTABILIDAD', 'REPOSICION_FONDO','TOTAL','TIPO_REVISION'));     

                                        foreach ($ecom as $datos) 
                                        {  
                                          $tip = ($datos->state == 'Edited') ? "REVIZADO":"NO REVIZADO";
                                          $sheet->row($j,array($i, $datos->code,$datos->identity_card, $datos->ext, $datos->first_name,$datos->second_name,$datos->last_name,$datos->mothers_last_name, $datos->surname_husband, $datos->regional,$datos->degree,$datos->category,$datos->modality,$datos->pension_entity,$datos->subtotal,$datos->amount_loan,$datos->amount_accounting,$datos->amount_replacement,$datos->total,$tip));
                                          $j++;
                                          $i++;
                                        }


                                      });
                                    })->export('xlsx');
                                     Session::flash('message', "Exportación Exitosa");
                                    return redirect('economic_complement');
                                  }
                                  else
                                  {
                                    Session::flash('message', "No existen registros");
                                    return redirect('economic_complement');
                                  } 

                        default:
                               return redirect('report_complement');
               }
           }
           else {
               $message = "Seleccione tipo de reporte a generar";
               Session::flash('message', $message);
               return redirect('report_complement');
           }
   }

   public function Data(Request $request)
   {
       if ($request->has('year') && $request->has('semester'))
       {
           $average_list = DB::table('eco_com_rents')
                           ->select(DB::raw("degrees.shortened as degree, eco_com_types.name as type,eco_com_rents.minor as rmin,eco_com_rents.higher as rmax, eco_com_rents.average as average "))
                           ->leftJoin('eco_com_types','eco_com_rents.eco_com_type_id','=','eco_com_types.id')
                           ->leftJoin('degrees','eco_com_rents.degree_id','=','degrees.id')
                           ->whereYear('eco_com_rents.year', '=', $request->year)
                           ->where('eco_com_rents.semester', '=', $request->semester)
                           ->orderBy('degrees.id','ASC');
               return Datatables::of($average_list)
                       ->addColumn('degree', function ($average_list) { return $average_list->degree; })
                       ->editColumn('type', function ($average_list) { return $average_list->type; })
                       ->editColumn('rmin', function ($average_list) { return $average_list->rmin; })
                       ->editColumn('rmax', function ($average_list) { return $average_list->rmax; })
                       ->editColumn('average', function ($average_list) { return $average_list->average; })
                       ->make(true);
       }
       else {
           $eco_com = EconomicComplement::select('semester')->orderBy('economic_complements.id','DESC')->first();
               $average_list = DB::table('eco_com_rents')
                              ->select(DB::raw("degrees.shortened as degree, eco_com_types.name as type,eco_com_rents.minor as rmin,eco_com_rents.higher as rmax, eco_com_rents.average as average "))
                              ->leftJoin('eco_com_types','eco_com_rents.eco_com_type_id','=','eco_com_types.id')
                              ->leftJoin('degrees','eco_com_rents.degree_id','=','degrees.id')
                              ->whereYear('eco_com_rents.year', '=', date("Y"))
                              ->where('eco_com_rents.semester', '=', $eco_com->semester)
                              ->orderBy('degrees.id','ASC');
               return Datatables::of($average_list)
                       ->addColumn('degree', function ($average_list) { return $average_list->degree; })
                       ->editColumn('type', function ($average_list) { return $average_list->type; })
                       ->editColumn('rmin', function ($average_list) { return $average_list->rmin; })
                       ->editColumn('rmax', function ($average_list) { return $average_list->rmax; })
                       ->editColumn('average', function ($average_list) { return $average_list->average; })
                       ->make(true);
       }

   }

   public function print_average(Request $request) {
       $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
       $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
       $title = "REPORTE DE PROMEDIOS";
       $date = Util::getDateEdit(date('Y-m-d'));
       $type = "user";
       $current_date = Carbon::now();
       $hour = Carbon::parse($current_date)->toTimeString();
       $average_list = DB::table('eco_com_applicants')
                       ->select(DB::raw("degrees.id as degree_id,degrees.shortened as degree,eco_com_types.id as type_id, eco_com_types.name as type,min(economic_complements.total) as rmin, max(economic_complements.total) as rmax,round((max(economic_complements.total)+ min(economic_complements.total))/2,2) as average"))
                       ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                       ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                       ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                       ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                       ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                       ->whereYear('economic_complements.year', '=', $request->year)
                       ->where('economic_complements.semester', '=', $request->semester)
                       ->whereNotNull('economic_complements.review_date')
                       ->groupBy('degrees.id','eco_com_types.id')
                       ->orderBy('degrees.id','ASC')->get();
        $view = \View::make('economic_complements.print.average_report', compact('header1','header2','title','date','type','hour','average_list'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('letter');
        return $pdf->stream();
   }
   public function export_average($year,$semester)
   {
      global $average_list;
      if ($year=="undefined" || $semester=="undefined")
      {
          Session::flash('message', "Seleccione Año y Semestre");
            return redirect('averages');
      } 
      else
      {
        
          $average_list = DB::table('eco_com_applicants')
                                        ->select(DB::raw("economic_complements.code,eco_com_applicants.identity_card as app_ci,cities1.first_shortened as app_ext,eco_com_applicants.first_name, eco_com_applicants.second_name, eco_com_applicants.last_name, eco_com_applicants.mothers_last_name, eco_com_applicants.surname_husband,
                                          affiliates.identity_card as afi_ci,cities2.first_shortened as afi_ext,affiliates.first_name as afi_first_name, affiliates.second_name as afi_second_name, affiliates.last_name as afi_last_name, affiliates.mothers_last_name as afi_mothers_last_name, 
                                          affiliates.surname_husband as afi_surname_husband,eco_com_applicants.birth_date,eco_com_applicants.civil_status,cities0.second_shortened as regional,degrees.shortened as degree,eco_com_modalities.shortened as modality,pension_entities.name as entity,economic_complements.sub_total_rent,economic_complements.reimbursement,economic_complements.dignity_pension,economic_complements.total_rent,economic_complements.total_rent_calc,categories.name as category,economic_complements.salary_reference,economic_complements.seniority,economic_complements.salary_quotable,economic_complements.difference,economic_complements.total_amount_semester,economic_complements.complementary_factor,economic_complements.total,economic_complements.reception_type"))
                                        ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                        ->leftJoin('cities as cities0', 'economic_complements.city_id', '=', 'cities0.id')
                                        ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                        ->leftJoin('categories','economic_complements.category_id','=','categories.id')
                                        ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                        ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                        ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                        ->leftJoin('cities as cities2', 'affiliates.city_identity_card_id', '=', 'cities2.id')
                                        ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                        ->leftJoin('pension_entities','affiliates.pension_entity_id','=', 'pension_entities.id')
                                        ->whereYear('economic_complements.year', '=', $year)
                                        ->where('economic_complements.semester', '=', $semester)
                                        ->where('economic_complements.total_rent','>', 0)
                                        ->whereIN('economic_complements.eco_com_modality_id',[1,2])
                                        ->whereRaw('economic_complements.total_rent::numeric < economic_complements.salary_quotable::numeric')
                                        ->whereNull('economic_complements.aps_disability')                                    
                                        ->orderBy('affiliates.degree_id','ASC')->get();
          //dd($average_list);
          if(sizeof($average_list) > 0)
          {
              Excel::create('TRAMITES_PARA_PROMEDIO', function($excel) 
              {
              
                       global $year,$semester,$i, $j, $average_list;
                       $j = 2;
                       $excel->sheet("TRAMITES_PROMEDIO".$year, function($sheet) {
                       global $year,$semester, $j, $i,$average_list;
                       $i=1;
                       $sheet->row(1, array('NRO','NRO_TRAMITE','CI', 'EXT', 'PRIMER_NOMBRE', 'SEGUNDO_NOMBRE', 'APELLIDO_PATERNO','APELLIDO_MATERNO','APELLIDO_DE_CASADO','CI_CAUSAHABIENTE','EXT','PRIMER_NOMBRE_CAUSAHABIENTE','SEGUNDO_NOMBRE_CAUSAHABIENTE','APELLIDO_PATERNO_CAUSAHABIENTE','APELLIDO_MATERNO_CAUSAHABIENTE','APELLIDO_DE_CASADO_CAUSAHABIENTE','FECHA_NACIMIENTO','ESTADO_CIVIL','REGIONAL','GRADO','TIPO_DE_RENTA','ENTE_GESTOR','RENTA_BOLETA','REINTEGRO','RENTA_DIGNIDAD','RENTA_TOTAL_NETA','NETO','CATEGORIA','REFERENTE_SALARIAL', 'ANTIGUEDAD','COTIZABLE','DIFERENCIA','TOTAL_SEMESTRE','FACTOR_DE_COMPLEMENTACION','COMPLEMENTO_ECONOMICO_FINAL_2017','TIPO_TRAMITE'));
                       
                       foreach($average_list as $datos) 
                       {
                           $sheet->row($j, array($i,$datos->code,$datos->app_ci,$datos->app_ext,$datos->first_name, $datos->second_name, $datos->last_name,$datos->mothers_last_name, $datos->surname_husband, $datos->afi_ci,$datos->afi_ext,$datos->afi_first_name, $datos->afi_second_name, $datos->afi_last_name,$datos->afi_mothers_last_name, $datos->afi_surname_husband, $datos->birth_date, $datos->civil_status, $datos->regional, $datos->degree, $datos->modality,$datos->entity,$datos->sub_total_rent,$datos->reimbursement,$datos->dignity_pension,$datos->total_rent,$datos->total_rent_calc,$datos->category, $datos->salary_reference,$datos->seniority, $datos->salary_quotable,$datos->difference, $datos->total_amount_semester,$datos->complementary_factor,$datos->total,$datos->reception_type));
                           $j++;
                           $i++;
                       }
                       
                     });
              })->export('xlsx');          
              return redirect('averages');
          }
          else
          {
            Session::flash('message', "No existe registros para exportar");
              return redirect('averages');
          }

      }
      
      
      
             
   }

   public function updated_list()
   {
       return view('economic_complements.print.updated_list', self::getViewModel());
   }

   public function export_updated_list(Request $request)
   {
       global $year, $semester,$i,$afi,$ecom,$ecom_list;
       $year = $request->year;
       $semester = $request->semester;
       $ecom = EconomicComplement::whereYear('economic_complements.year','=', $year)->where('economic_complements.semester','=',$semester)
                                    ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                                    ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                    ->select('economic_complements.id','affiliates.updated_at','pension_entities.type')->orderBy('pension_entities.type')->get();

       foreach ($ecom as $item) {
           $afi = DB::table('economic_complements')
               ->select(DB::raw('economic_complements.id,economic_complements.affiliate_id,affiliates.identity_card,cities.first_shortened,affiliates.nua,affiliates.last_name,affiliates.mothers_last_name,affiliates.first_name,affiliates.second_name,affiliates.surname_husband,affiliates.birth_date,pension_entities.type'))
               ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
               ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
               ->leftJoin('cities', 'affiliates.city_identity_card_id', '=', 'cities.id')
               ->where('economic_complements.id','=', $item->id)
               ->whereYear('economic_complements.year', '=', $year)
               ->where('economic_complements.semester', '=', $semester)
               ->where('affiliates.created_at', '<>', $item->updated_at)->first();
             if ($afi) {
                  $ecom_list[] = $afi;
             }

       }
       Excel::create('Afi_modificados', function($excel) {
                 global $year,$semester, $j, $ecom_list;
                 $j = 2;
                 $excel->sheet("AFILIADOS_MODIFI".$year, function($sheet) {
                 global $year,$semester, $j, $i,$ecom_list;
                 $i=1;
                 $sheet->row(1, array('NRO','TIPO_ID','NUM_ID', 'EXTENSION', 'CUA', 'PRIMER_APELLIDO_T', 'SEGUNDO_APELLIDO_T','PRIMER_NOMBRE_T','SEGUNDO_NOMBRE_T','APELLIDO_CASADA_T','FECHA_NACIMIENTO_T','ENTE_GESTOR'));
                 foreach ($ecom_list as $datos) {
                     $sheet->row($j, array($i,"I",$datos->identity_card,$datos->first_shortened,$datos->nua, $datos->last_name, $datos->mothers_last_name,$datos->first_name, $datos->second_name, $datos->surname_husband,$datos->birth_date,$datos->type));
                     $j++;
                     $i++;
                 }
               });
           })->export('xlsx');
             Session::flash('message', "Importación Exitosa");
             return redirect('get_updated_list');
   }

   public function data_shet($id_complemento)
    {

            $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
            $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
            $title = "FICHA PAGO COMPLEMENTO ECONÓMICO";
            $date = Util::getDateShort((date('Y-m-d')));
            $current_date = Carbon::now();
            $economic_complement = EconomicComplement::where('id',$id_complemento)->first();
            $hour = Carbon::parse($current_date)->toTimeString();
 

          try {
            $state = EconomicComplementState::find($economic_complement->eco_com_state_id);

        } catch (Exception $e) {
            $state =null;
        }

        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();

    
        if($economic_complement->complementary_factor > 1)
            $fc = $economic_complement->complementary_factor/100;
        else
            $fc = $economic_complement->complementary_factor; 

        $eco_com_prev = $economic_complement->total_amount_semester *  $fc;
        //dd($economic_complement->total_amount_semester);
        $factor_complement = $fc;

        $eco_tot_frac = $economic_complement->aps_total_cc + $economic_complement->aps_total_fsa + $economic_complement->aps_total_fs;
        //dd($eco_tot_frac);

        $eco_com_applicant = EconomicComplementApplicant::economicComplementIs($economic_complement->id)->first();
         $economic_complement_legal_guardian=$economic_complement->economic_complement_legal_guardian;

        if (EconomicComplementSubmittedDocument::economicComplementIs($economic_complement->id)->first()) {
            $status_documents = TRUE;
        }else{
            $status_documents = FALSE;
        }

        
        $t_v = $economic_complement->economic_complement_modality->shortened;
           
        if($t_v == 'VEJEZ' || $t_v == 'RENT-MEN-VEJ' || $t_v == 'RENT-1COMP-VEJ' || $t_v == 'RENT-1COM-MEN-VEJ'){
            $modality = 1;
        }
        if($t_v == 'VIUDEDAD'){
            $modality = 0;
        }

        $data = [

        'affiliate' => $affiliate,
        'economic_complement' => $economic_complement,
    
        'eco_com_applicant' => $eco_com_applicant,

        'economic_complement_legal_guardian' => $economic_complement_legal_guardian,
       
      
        'status_documents' => $status_documents,
      
        'eco_com_prev' => number_format($eco_com_prev, 2, '.', ','),
        'eco_tot_frac' => number_format($eco_tot_frac, 2, '.', ','),

        'factor_complement' => $factor_complement * 100,

        'date' => $date,
        'hour' => $hour,
        'header1' => $header1,
        'header2' => $header2,
        'title' => $title,
        'modality' => $modality,
        'code' => $economic_complement->code,
        'total' => number_format($economic_complement->total,2,'.',','),
        'reception_date' => Util::getDateShort($economic_complement->created_at,date('d/m/Y')),
        ];
       

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
        'user_1' => Auth::user()

        ];
        
        $data = array_merge($data, $second_data);
       
        $view = \View::make('economic_complements.print.datashet_economic_complements',$data )->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('legal');
        return $pdf->stream();
  
    }
    public function print_edited_data(Request $request)
    {
      $rules = [
          'ids_print' =>'required',
      ];

      $messages = [
          'ids_print.required' => 'Debe Seleccionar al menos un Trámite.',
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
          return redirect('inbox')
          ->withErrors($validator)
          ->withInput();
      }else{


      $ids=explode(',',$request->ids_print);
      // dd($ids[0]);
      $semester=EconomicComplement::where('id','=',$ids[0])->first()->economic_complement_procedure->semester;
      $year=carbon::parse(EconomicComplement::where('id','=',$ids[0])->first()->economic_complement_procedure->year)->year;
      $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
      $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
      
      $title = "&nbsp;";
      // $title = "REPORTE DE BENEFICIARIOS DEL COMPLEMENTO ECONÓMICO";
      setlocale(LC_ALL, "es_ES.UTF-8");
      $date = Util::getDateEdit(date('Y-m-d'));
      $date =strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
      $type = "user";
      $anio = Carbon::now()->year;
      $user = Auth::user();
      $current_date = Carbon::now();
      $hour = Carbon::parse($current_date)->toTimeString();
      $user_role = Util::getRol()->name;
      $economic_complements_array=EconomicComplement::where('economic_complements.state','Edited')->leftJoin('wf_states','economic_complements.wf_current_state_id', '=','wf_states.id')
                  ->where('wf_states.role_id',(Util::getRol()->id))
                  ->where('economic_complements.user_id',Auth::user()->id)
                  ->whereIn('economic_complements.id',$ids)
                  ->select('economic_complements.id')
                  ->get()
                  ->pluck('id');

      $pages=[];
      foreach (\Muserpol\City::all() as $city) {
        $economic_complements=EconomicComplement::whereIn('id',$economic_complements_array)->where('city_id','=',$city->id)->get();
        $economic_complements_temp_array=EconomicComplement::whereIn('id',$economic_complements_array)->where('city_id','=',$city->id)->get()->pluck('id');
        $total=Util::formatMoney(Util::totalSumEcoCom($economic_complements_temp_array)->sum);
        $title2 = " Listado de Beneficiarios del Complemento Económico <br>".$semester." Semestre ".$year."- Regional ".$city->name;
        if ($total) {
        $pages[] = \View::make('economic_complements.print.edited_data',compact('header1','header2','title','title2','date','type','anio','hour','economic_complements','user', 'user_role','total'))->render();
        }
      }
      $pdf = \App::make('snappy.pdf.wrapper');

      $pdf->setPaper('letter')->setOrientation('landscape')->setOPtion('footer-center', 'Pagina [page] de [toPage]')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018');
      $file_name=storage_path().'/snappy/planillas/'.'planilla_'.Auth::user()->username.'_'.date("Y-m-d_H:i:s").'.pdf';
      $pdf->generateFromHtml($pages,$file_name, [], true);
      return response()->download($file_name);

      
      return \PDF::loadView('economic_complements.print.edited_data',compact('header1','header2','title','title2','date','type','anio','hour','economic_complements','user', 'user_role','total'))->setPaper('letter')->setOrientation('landscape')->setOPtion('footer-center', 'Pagina [page] de [toPage]')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_edited.pdf');
      }
    }

    public function print_total($eco_com_id)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $date = Util::getDateEdit(date('Y-m-d'));
        setlocale(LC_ALL, "es_ES.UTF-8");
        $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();

        $economic_complement = EconomicComplement::where('id',$eco_com_id)->first();

        $title_inline=($economic_complement->old_eco_com == null) ? "FORMULARIO CE - 1" : "FORMULARIO CE - 2";
        $title="HOJA DE CÁLCULO DEL COMPLEMENTO ECONÓMICO";
        $title2=$economic_complement->economic_complement_procedure->getFullName() ?? '';
        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
        $eco_com_applicant = $economic_complement->economic_complement_applicant;
        $economic_complement_legal_guardian = $economic_complement->economic_complement_legal_guardian;
        $eco_tot_frac = $economic_complement->aps_total_cc + $economic_complement->aps_total_fsa + $economic_complement->aps_total_fs;
        $doc_number = $economic_complement->economic_complement_modality->economic_complement_type->id;

        if ($economic_complement->old_eco_com) {
            $old_eco_com=json_decode($economic_complement->old_eco_com);
            $old_eco_com_total_frac = $old_eco_com->aps_total_cc + $old_eco_com->aps_total_fsa + $old_eco_com->aps_total_fs;
            $modality=\Muserpol\EconomicComplementModality::where('id',$old_eco_com->eco_com_modality_id)->first();
            $old_eco_com_modality_name = $modality->economic_complement_type->name;
            $old_eco_com_modality = $modality->shortened;
            $degree=\Muserpol\Degree::where('id',$old_eco_com->degree_id)->first();
            $old_eco_com_degree = $degree->shortened;
            $old_eco_com_year = Carbon::parse($degree->year)->year;
            $category=\Muserpol\Category::where('id',$old_eco_com->category_id)->first();
            $old_eco_com_category = $category->name;
            $city=\Muserpol\City::where('id',$old_eco_com->city_id)->first();
            $old_eco_com_city = $city->name;

        }
        $total_literal= Util::convertir($economic_complement->total);
        $temp_total=null;
        if ($economic_complement->amount_loan || $economic_complement->amount_accounting || $economic_complement->amount_replacement) {
          $temp_total=$economic_complement->total +  ($economic_complement->amount_loan ?? 0) + ($economic_complement->amount_accounting ?? 0) + ($economic_complement->amount_replacement ?? 0);
        }
        // dd($temp_total);

        $temp_total=(number_format($temp_total,2,'.',''));
        if ($economic_complement->old_eco_com && ($old_eco_com->amount_loan || $old_eco_com->amount_accounting || $old_eco_com->amount_replacement || true )) {
          $old_eco_com_total_calificate = $old_eco_com->total + ($old_eco_com->amount_loan ?? 0) + ($old_eco_com->amount_accounting ?? 0) + ($old_eco_com->amount_replacement ?? 0);
        }
        $data = [
            'doc_number'=>$doc_number,
            'affiliate' => $affiliate,
            'economic_complement' => $economic_complement,
            'eco_com_applicant' => $eco_com_applicant,
            'old_eco_com' => $old_eco_com ?? null,
            'old_eco_com_total_frac' => $old_eco_com_total_frac ?? null,
            'old_eco_com_modality_name' => $old_eco_com_modality_name ?? null,
            'old_eco_com_modality' => $old_eco_com_modality ?? null,
            'old_eco_com_degree' => $old_eco_com_degree ?? null,
            'old_eco_com_year' => $old_eco_com_year ?? null,
            'old_eco_com_category' => $old_eco_com_category ?? null,
            'old_eco_com_city' => $old_eco_com_city ?? null,
            'economic_complement_legal_guardian' => $economic_complement_legal_guardian, 
            'eco_tot_frac' => number_format($eco_tot_frac, 2, '.', ','),
            'factor_complement' => $economic_complement->complementary_factor,
            'date' => $date,
            'hour' => $hour,
            'header1' => $header1,
            'header2' => $header2,
            'title' => $title,
            'title2' => $title2,
            'title_inline' => $title_inline,
            'total_literal' => $total_literal,
            'old_eco_com_total_calificate' => $old_eco_com_total_calificate ?? null,
        ];

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
            'temp_total' => $temp_total,
            'user' => Auth::user(),
            'user_role' =>Util::getRol()->name
        ];
        // dd(Util:: str_replace(',', '.', (str_replace('.', '', Util::formatMoney($temp_total)))));
        $data = array_merge($data, $second_data);
        return \PDF::loadView('economic_complements.print.print_total', $data)->setOption('page-width', '215.9')->setOption('page-height', '330')->setOption('margin-bottom', 0)/*->setOption('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')*/->stream('print_total.pdf');

        // ->setOption('page-width', '215.9')->setOption('page-height', '330')

        // $view = \View::make('economic_complements.print.print_total',$data )->render();
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($view)->setPaper('legal');
        // return $pdf->stream();
    }
    public function print_total_old($eco_com_id)
    {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $title_inline = "FORMULARIO CE - 1";
        $title = "HOJA DE CÁLCULO DEL COMPLEMENTO ECONÓMICO";
        
        $date = Util::getDateEdit(date('Y-m-d'));
        setlocale(LC_ALL, "es_ES.UTF-8");
        $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();

        $economic_complement = EconomicComplement::where('id',$eco_com_id)->first();
        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
        $eco_com_applicant = $economic_complement->economic_complement_applicant;
        $economic_complement_legal_guardian = $economic_complement->economic_complement_legal_guardian;
        $eco_tot_frac = $economic_complement->aps_total_cc + $economic_complement->aps_total_fsa + $economic_complement->aps_total_fs;
        $doc_number = $economic_complement->economic_complement_modality->economic_complement_type->id;
        
        if ($economic_complement->old_eco_com) {
            $old_eco_com=json_decode($economic_complement->old_eco_com);
            $title2 = \Muserpol\EconomicComplementProcedure::where('id',$old_eco_com->eco_com_procedure_id)->first()->getFullName() ?? '';
            $total_literal=Util::convertir($old_eco_com->total);
            $old_eco_com_total_frac = $old_eco_com->aps_total_cc + $old_eco_com->aps_total_fsa + $old_eco_com->aps_total_fs;
            $modality=\Muserpol\EconomicComplementModality::where('id',$old_eco_com->eco_com_modality_id)->first();
            $old_eco_com_modality_name = $modality->economic_complement_type->name;
            $old_eco_com_modality = $modality->shortened;
            $degree=\Muserpol\Degree::where('id',$old_eco_com->degree_id)->first();
            $old_eco_com_degree = $degree->shortened;
            $old_eco_com_year = Carbon::parse($degree->year)->year;
            $category=\Muserpol\Category::where('id',$old_eco_com->category_id)->first();
            $old_eco_com_category = $category->name;
            $city=\Muserpol\City::where('id',$old_eco_com->city_id)->first();
            $old_eco_com_city = $city->name;
            $old_eco_com_reception_date = Util::getDateShort($old_eco_com->reception_date);
            $doc_number = \Muserpol\EconomicComplementModality::where('id',$old_eco_com->eco_com_modality_id)->first()->economic_complement_type->id;
        }
        $temp_total=null;
        if ($old_eco_com->amount_loan || $old_eco_com->amount_accounting || $old_eco_com->amount_replacement) {
          $temp_total=$old_eco_com->total +  ($old_eco_com->amount_loan ?? 0) + ($old_eco_com->amount_accounting ?? 0) + ($old_eco_com->amount_replacement ?? 0);
        }
        $data = [
            'doc_number'=>$doc_number,
            'affiliate' => $affiliate,
            'economic_complement' => $economic_complement,
            'eco_com_applicant' => $eco_com_applicant,
            'old_eco_com' => $old_eco_com ?? null,
            'old_eco_com_total_frac' => $old_eco_com_total_frac ?? null,
            'old_eco_com_modality_name' => $old_eco_com_modality_name ?? null,
            'old_eco_com_modality' => $old_eco_com_modality ?? null,
            'old_eco_com_degree' => $old_eco_com_degree ?? null,
            'old_eco_com_year' => $old_eco_com_year ?? null,
            'old_eco_com_category' => $old_eco_com_category ?? null,
            'old_eco_com_city' => $old_eco_com_city ?? null,
            'old_eco_com_reception_date' => $old_eco_com_reception_date ?? null,
            'economic_complement_legal_guardian' => $economic_complement_legal_guardian, 
            'eco_tot_frac' => number_format($eco_tot_frac, 2, '.', ','),
            'factor_complement' => $economic_complement->complementary_factor,
            'date' => $date,
            'hour' => $hour,
            'header1' => $header1,
            'header2' => $header2,
            'title' => $title,
            'title2' => $title2,
            'title_inline' => $title_inline,
            'total_literal' => $total_literal ?? '',
        ];
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
            'temp_total' => Util::formatMoney($temp_total),
            'user' => Auth::user(),
            'user_role' =>Util::getRol()->name
        ];
        $data = array_merge($data, $second_data);
        return \PDF::loadView('economic_complements.print.print_total_old', $data)->setPaper('letter')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('print_total.pdf');
        // $view = \View::make('economic_complements.print.print_total_old',$data )->render();
        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML($view)->setPaper('legal');
        // return $pdf->stream();
    }
    public function print_eco_com_backrest($eco_com_id)
    {
      $economic_complement = EconomicComplement::where('id',$eco_com_id)->first();
      if ($economic_complement) {
        $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
        $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
        $date = Util::getDateEdit(date('Y-m-d'));
        setlocale(LC_ALL, "es_ES.UTF-8");
        $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
        $current_date = Carbon::now();
        $hour = Carbon::parse($current_date)->toTimeString();
        $title = ($economic_complement->old_eco_com == null) ? "FORMULARIO CE - 1" : "FORMULARIO CE - 2";
        $affiliate = Affiliate::idIs($economic_complement->affiliate_id)->first();
        $eco_com_applicant = $economic_complement->economic_complement_applicant;
        $economic_complement_legal_guardian = $economic_complement->economic_complement_legal_guardian;
        $eco_tot_frac = $economic_complement->aps_total_cc + $economic_complement->aps_total_fsa + $economic_complement->aps_total_fs;
        $doc_number = $economic_complement->economic_complement_modality->economic_complement_type->id;
        $total_literal= Util::convertir($economic_complement->total);
        $data = [
            'doc_number'=>$doc_number,
            'affiliate' => $affiliate,
            'economic_complement' => $economic_complement,
            'eco_com_applicant' => $eco_com_applicant,
            'economic_complement_legal_guardian' => $economic_complement_legal_guardian, 
            'date' => $date,
            'hour' => $hour,
            'header1' => $header1,
            'header2' => $header2,
            'title' => $title,
        ];
        $second_data = [
            'total' => Util::formatMoney($economic_complement->total),
            'total_literal' => $total_literal,
            'user' => Auth::user(),
            'user_role' =>Util::getRol()->name
        ];
        $data = array_merge($data, $second_data);
        return \PDF::loadView('economic_complements.print.print_total_backrest', $data)->setPaper('letter')->setOPtion('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('print_total.pdf');
      }
    }
    public function invalid_cell_phone()
    {
      $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
      $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
      $date = Util::getDateEdit(date('Y-m-d'));
      setlocale(LC_ALL, "es_ES.UTF-8");
      $date = strftime("%e de %B de %Y",strtotime(Carbon::createFromFormat('d/m/Y',$date)));
      $current_date = Carbon::now();
      $hour = Carbon::parse($current_date)->toTimeString();
      $title="Reporte de Beneficiarios con Teléfonos/Celulares incorrectos";
      $economic_complements=EconomicComplement::leftJoin('eco_com_applicants','economic_complements.id', '=','eco_com_applicants.economic_complement_id')
      ->where('economic_complements.eco_com_procedure_id', 6)
      ->where(function($query){
          $query->whereRaw("(eco_com_applicants.cell_phone_number ~ '_' or eco_com_applicants.phone_number ~ '_')");
          $query->orWhereRaw("(eco_com_applicants.phone_number like  '' and eco_com_applicants.cell_phone_number like  '')");
      })
      ->select(['economic_complements.id'])
      ->orderBy('economic_complements.id')
      ->get()
      ->pluck('id');
      $economic_complements=EconomicComplement::whereIn('id',$economic_complements)->get();
      $data = [
          'economic_complements' => $economic_complements,
          'date' => $date,
          'hour' => $hour,
          'header1' => $header1,
          'header2' => $header2,
          'title' => $title,
      ];
      $second_data = [
          'user' => Auth::user(),
          'user_role' =>Util::getRol()->name
      ];
      $data = array_merge($data, $second_data);
      return \PDF::loadView('economic_complements.reports.invalid_cell_phone', $data)->setPaper('letter')->setOption('footer-left', 'PLATAFORMA VIRTUAL DE LA MUSERPOL - 2018')->stream('report_invalid_cell_phone.pdf');
    }
  public function menu()
  {

    $years=[];
    $eco_com_pro_years = EconomicComplementProcedure::select('year')->distinct('year')->orderBy('year','desc')->get()->pluck('year','year');
    
    foreach ($eco_com_pro_years as $key => $value) {
      $years[]=array(Util::getYear($value) => Util::getYear($value));
    }
    $current_year = Util::getCurrentYear();
    $semesters = EconomicComplementProcedure::orderBy('semester')->get()->pluck('semester', 'semester');
    $current_semester = Util::getCurrentSemester();
    $reports_list=self::reports_lists();
    
    // self::reports_list = $reports_list;
    return view('economic_complements.reports.menu', compact('years','current_year', 'current_semester', 'semesters', 'reports_list'));
  }
  public function generateTable(Request $request)
  {
    $data;
    $type = $request->type;
    $year = $request->year;
    $semester = $request->semester;
    $eco_com_procedure_id = EconomicComplementProcedure::whereYear('year','=',$year)->where('semester','like',$semester)->first();
    if (!$eco_com_procedure_id) {
      return 'error';
    }
    $eco_com_procedure_id=$eco_com_procedure_id->id;
    //dd($eco_com_procedure_id);
    $name = self::reports_lists()[$type];
    switch ($type) {
      case 1:
        //tramites con fracion solidaria
        $columns = ',economic_complements.aps_total_fs as fraccion_solidaria';
        $file_name = $name.' '.date("Y-m-d H:i:s");
        $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
        ->ecocominfo()
        ->applicantinfo()
        ->affiliateinfo()
        ->where('aps_total_fs','>',0)
        ->select(DB::raw(EconomicComplement::basic_info_complements()."".$columns.""))
        ->get();

        $data = $economic_complements;
        Util::excel($file_name, 'hoja', $data);
        break;
        case 2:
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', '-1');
            ini_set('max_input_time', '-1');
            set_time_limit('-1');
          //$columns = ', pension_entities.type as tipo_de_ente_gestor, economic_complements.reception_type as tipo_de_recepcion, eco_com_states.name as estado, wf_states.name as ubicacion';
          $file_name = $name.' '.date("Y-m-d H:i:s");
          //dd(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_complements().",".EconomicComplement::basic_info_affiliates()));
          $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
            ->leftJoin('eco_com_applicants as eca','eca.economic_complement_id','=','economic_complements.id')
            ->leftJoin('eco_com_modalities as ecm','ecm.id','=','economic_complements.eco_com_modality_id')
            ->leftJoin('affiliates as af','af.id','=','economic_complements.affiliate_id')
             ->leftJoin( DB::raw('(SELECT afob.affiliate_id, STRING_AGG (afob.message, \'||\') as observaciones
                                   FROM affiliates AS af
		                           LEFT JOIN affiliate_observations as afob ON(afob.affiliate_id = af.id)
                                   GROUP BY afob.affiliate_id
          ) as afobs'),'afobs.affiliate_id','=','af.id')
            ->leftJoin('eco_com_states as ecs','ecs.id','=','economic_complements.eco_com_state_id')
            ->leftJoin('cities as ci_ben','eca.city_identity_card_id','=','ci_ben.id')
            ->leftJoin('cities as reg','economic_complements.city_id','=','reg.id')
            ->leftJoin('degrees as de','de.id','=','af.degree_id')
            ->leftJoin('categories as ca','ca.id','=','economic_complements.category_id')
            ->leftJoin('pension_entities as pe','pe.id','=','af.pension_entity_id')
            ->leftJoin('affiliate_observations as afob','af.id' ,'=','afob.affiliate_id')
            ->leftJoin('wf_states as ws','ws.id','=','economic_complements.wf_current_state_id')
            ->leftJoin('workflows as wo','wo.id','=','economic_complements.workflow_id')

          /*->ecocominfo()
          ->applicantinfo()
          ->affiliateinfo()
          ->affiliateinfo2()
          ->ecocomstates()
          ->wfstates(*/
         // ->select(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_affiliates().",".EconomicComplement::basic_info_complements()))

          ->select(DB::raw( 'DISTINCT ON (economic_complements.id) economic_complements.id, row_number() OVER () AS nro, economic_complements.code as N_Tramite, economic_complements.reception_date as Fecha_recepcion, eca.identity_card as ci_beneficiario, ci_ben.first_shortened as expedido, eca.identity_card || \' \' || ci_ben.first_shortened as ci_completo, eca.first_name as prim_nomb_ben, eca.second_name as seg_nomb_ben, eca.last_name as apellido_pat_ben, eca.mothers_last_name as apellido_mat_ben, eca.surname_husband as ape_casada_ben, eca.birth_date as fecha_nac_ben, af.identity_card as ci_causa, ci_ben.first_shortened as exp_causa, af.identity_card || \' \' || ci_ben.first_shortened as ci_completo_causa, af.first_name as primer_nom_cau, af.second_name as segundo_nom_cau, af.last_name as ape_pat_cau, af.mothers_last_name as ape_mat_cau, af.surname_husband as ape_casada_cau, af.birth_date as fecha_nac_cau, af.nua as Nua, reg.name as regional, ecm.shortened as tipo_de_prestacion, ecm.shortened as tipo_de_prestacion, ca.name as categoria, de.name as grado, pe.name as ente_gestor, economic_complements.aps_total_fsa as fracion_saldo_acumulado, economic_complements.aps_total_cc as compensacion_cotizaciones, economic_complements.aps_total_fs as fracicon_solidaria_vejez, economic_complements.total_rent as total_renta_o_jubilacion, economic_complements.total_rent_calc as promedio, economic_complements.seniority as antiguedad, economic_complements.salary_reference as sueldo_activo, economic_complements.salary_quotable as salario_cotizable, economic_complements.difference as diferencia, economic_complements.difference*6 as total_semestre, economic_complements.complementary_factor as factor_complementario, economic_complements.total as total_complemento_economico, economic_complements.state as estado, ws.first_shortened as ubicacion, ecm.name as tipo_beneficiario, economic_complements.reception_type as tipo_recepcion, ecs.name as estado, ws.first_shortened as ubicacion, wo.name as flujo, afobs.observaciones'))
          ->get();
          $data = $economic_complements;
          Util::excel($file_name, 'hoja', $data);
          break;
        case '3':
          $eco_com_procedure_current = EconomicComplementProcedure::find($eco_com_procedure_id);
          $eco_com_procedure_old = EconomicComplementProcedure::find(Util::semesterAgo($year, $semester));
          if (!$eco_com_procedure_old) { return;  }
          $ren_old=EconomicComplementRent::whereYear('year','=',Carbon::parse($eco_com_procedure_old->year)->year)->where('semester','=',$eco_com_procedure_old->semester)->get();
          $ren_current=EconomicComplementRent::whereYear('year','=',Carbon::parse($eco_com_procedure_current->year)->year)->where('semester','=',$eco_com_procedure_current->semester)->get();
          $rows=[];
          foreach ($ren_current as $current_rent) {
            foreach ($ren_old as $old_rent) {
              if ($current_rent->degree_id == $old_rent->degree_id && $current_rent->eco_com_type_id == $old_rent->eco_com_type_id) {
                $rows[] = array(
                  'degree' => Degree::find($current_rent->degree_id)->shortened,
                  'year_old' => Carbon::parse($old_rent->year)->year,
                  'semester_old' => $old_rent->semester,
                  'average_old' => $old_rent->average,
                  'year_current' => Carbon::parse($current_rent->year)->year,
                  'semester_current' => $current_rent->semester,
                  'average_current' => $current_rent->average,
                  'difference' =>  $current_rent->average - $old_rent->average,
                  // 'difference' => abs($old_rent->average - $current_rent->average),
                  'modality' => EconomicComplementModality::find($current_rent->eco_com_type_id)->economic_complement_type->name ?? '', 
                );
               }
            }
          }
          $file_name = $name.' '.date("Y-m-d H:i:s");
          Util::excel($file_name, 'hoja', $rows);
          break;
        case '4':
          $columns = ',economic_complements.aps_disability as concurrencia';
          $file_name = $name.' '.date("Y-m-d H:i:s");
          $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
          ->ecocominfo()
          ->applicantinfo()
          ->affiliateinfo()
          ->ecocomstates()
          ->wfstates()
          ->select(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_affiliates().",".EconomicComplement::basic_info_complements()."".$columns))
          ->where('aps_disability','>',0)
          ->get();
          $data = $economic_complements;
          Util::excel($file_name, 'hoja', $data);
          
          break;
        case '5':
          $columns = ',economic_complements.total_rent as total_renta,economic_complements.salary_quotable as salario_cotizable';
          $file_name = $name.' '.date("Y-m-d H:i:s");
          $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
          ->ecocominfo()
          ->applicantinfo()
          ->affiliateinfo()
          ->ecocomstates()
          ->wfstates()
          ->select(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_affiliates().",".EconomicComplement::basic_info_complements()."".$columns))
          ->whereRaw('economic_complements.total_rent > economic_complements.salary_quotable and aps_disability is null')
          ->get();
          $data = $economic_complements;
          Util::excel($file_name, 'hoja', $data);
          
          break;

        case '6':
          $eco_com_procedure_current = EconomicComplementProcedure::find($eco_com_procedure_id);
          $eco_com_procedure_old = EconomicComplementProcedure::find(Util::semesterAgo($year, $semester));
          if (!$eco_com_procedure_old) { return;  }
          $ecos_old=$eco_com_procedure_old->economic_complements;
          $ecos_current=$eco_com_procedure_current->economic_complements;
          // dd($ecos_old->count(), $ecos_current->count());
          $rows=[];
          foreach ($ecos_current as $current) {
            $afi_id=$current->affiliate_id;
            $old=EconomicComplement::where('affiliate_id','=',$afi_id)->where('eco_com_procedure_id','=', $eco_com_procedure_old->id)->first();
            if ($old) {
              if ($current->degree_id != $old->degree_id ) {
                $rows[] = array(
                  'afiliado_ci' => $current->affiliate->identity_card,
                  'tramite_anterior' => $old->code,
                  'tramite_actual' => $current->code,
                  'grado_anterior' => Degree::find($old->degree_id)->shortened,
                  'grado_actual' => Degree::find($current->degree_id)->shortened,
                );
               }
            }
          }
          $file_name = $name.' '.date("Y-m-d H:i:s");
          Util::excel($file_name, 'hoja', $rows);
          
          break;
          case '7':
          $eco_com_procedure_current = EconomicComplementProcedure::find($eco_com_procedure_id);
          $eco_com_procedure_old = EconomicComplementProcedure::find(Util::semesterAgo($year, $semester));
          if (!$eco_com_procedure_old) { return;  }
          $ecos_old=$eco_com_procedure_old->economic_complements;
          $ecos_current=$eco_com_procedure_current->economic_complements;
          // dd($ecos_old->count(), $ecos_current->count());
          $rows=[];
          foreach ($ecos_current as $current) {
            $afi_id=$current->affiliate_id;
            $old=EconomicComplement::where('affiliate_id','=',$afi_id)->where('eco_com_procedure_id','=', $eco_com_procedure_old->id)->first();
            if ($old) {
              if ($current->category_id != $old->category_id) {
                $rows[] = array(
                  'afiliado_ci' => $current->affiliate->identity_card,
                  'tramite_anterior' => $old->code,
                  'tramite_actual' => $current->code,
                  'categoria_anterior' => Category::find($old->category_id)->name,
                  'categoria_actual' => Category::find($current->category_id)->name,
                );
               }
            }
          }
          $file_name = $name.' '.date("Y-m-d H:i:s");
          Util::excel($file_name, 'hoja', $rows);

          
          break;


        case '8':
          $columns = ',economic_complements.total_rent as total_renta,economic_complements.salary_quotable as salario_cotizable, observations.observations as observaciones';
          $file_name = $name.' '.date("Y-m-d H:i:s");
          $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
          ->ecocominfo()
          ->applicantinfo()
          ->affiliateinfo()
          ->ecocomstates()
          ->wfstates()
          ->affiliateobservations()
          ->select(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_affiliates().",".EconomicComplement::basic_info_complements()."".$columns))
          ->whereRaw('economic_complements.has_legal_guardian = true and economic_complements.has_legal_guardian_s = false')
          ->get();
          
          $data = $economic_complements;
          Util::excel($file_name, 'hoja', $data);
         break;

        case '9':  //VALIDADOS CON OBSERVACION
          $columns = ',economic_complements.total_rent as total_renta,economic_complements.salary_quotable as salario_cotizable, observations.observations as observaciones';
          $file_name = $name.' '.date("Y-m-d H:i:s");
          $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
          ->ecocominfo()
          ->applicantinfo()
          ->affiliateinfo()
          ->ecocomstates()
          ->wfstates()
          ->affiliateobservations()
          ->select(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_affiliates().",".EconomicComplement::basic_info_complements()."".$columns))
          ->whereRaw("economic_complements.workflow_id = 1 and economic_complements.wf_current_state_id = 3 and economic_complements.state = 'Edited' and exists(SELECT affiliates.id from affiliate_observations where affiliates.id = affiliate_observations.affiliate_id and affiliate_observations.observation_type_id IN(1,2,3,12,13,14,15) and affiliate_observations.is_enabled = false and affiliate_observations.deleted_at is NULL)")
          ->get();
          
          $data = $economic_complements;
          Util::excel($file_name, 'hoja', $data);
         break;

        case '10': //NO VALIDADOS CON OBSERVACIONES
          $columns = ',economic_complements.total_rent as total_renta,economic_complements.salary_quotable as salario_cotizable, observations.observations as observaciones';
          $file_name = $name.' '.date("Y-m-d H:i:s");
          $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
          ->ecocominfo()
          ->applicantinfo()
          ->affiliateinfo()
          ->ecocomstates()
          ->wfstates()
          ->affiliateobservations()
          ->select(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_affiliates().",".EconomicComplement::basic_info_complements()."".$columns))
          ->whereRaw("economic_complements.workflow_id = 1 and economic_complements.wf_current_state_id <= 3 and economic_complements.state <> 'Edited'")
          ->get();
          
          $data = $economic_complements;
          Util::excel($file_name, 'hoja', $data);
         break;

         case '11': //REPORTE DE AMORTIZACION
          $columns = ',economic_complements.total_rent as total_renta,economic_complements.salary_quotable as salario_cotizable,economic_complements.amount_loan as amortizacion_prestamos,economic_complements.amount_accounting as amortizacion_contabilidad, economic_complements.amount_replacement as amortizacón_resposicion,  observations.observations as observaciones, economic_complements.has_legal_guardian,economic_complements.has_legal_guardian_s';
          $file_name = $name.' '.date("Y-m-d H:i:s");
          $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
          ->ecocominfo()
          ->applicantinfo()
          ->affiliateinfo()
          ->ecocomstates()
          ->wfstates()
          ->affiliateobservations()
          ->select(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_affiliates().",".EconomicComplement::basic_info_complements()."".$columns))
          ->whereRaw("economic_complements.workflow_id = 1 and economic_complements.wf_current_state_id = 3 and economic_complements.state = 'Edited' and not exists(SELECT affiliates.id from affiliate_observations where affiliates.id = affiliate_observations.affiliate_id and affiliate_observations.observation_type_id IN(1,2,3,12,13,14,15) and affiliate_observations.is_enabled = false and affiliate_observations.deleted_at is NULL)")
          ->get();
          
          $data = $economic_complements;
          Util::excel($file_name, 'hoja', $data);
         break;


        // case 2:
        // //tipos de recepcion inclusion 

        // $columns = ',economic_complements.reception_type as tipo_de_recepcion';

        // $file_name = $name.' '.date("Y-m-d H:i:s");
        // $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
        // ->ecocominfo()
        // ->applicantinfo()
        // ->affiliateinfo()
        // ->where('economic_complements.reception_type', '=', 'Inclusion')
        // ->select(DB::raw(EconomicComplement::basic_info_colums()."".$columns.""))
        // ->get();
        // $data = $economic_complements;
        // Util::excel($file_name, 'hoja', $data);
        // break;
        // case 3:
        // //tipos de recepcion Habitual 

        // $columns = ',economic_complements.reception_type as tipo_de_recepcion';

        // $file_name = $name.' '.date("Y-m-d H:i:s");
        // $economic_complements=EconomicComplement::where('eco_com_procedure_id','=',$eco_com_procedure_id)
        // ->ecocominfo()
        // ->applicantinfo()
        // ->affiliateinfo()
        // ->where('economic_complements.reception_type', '=', 'Habitual')
        // ->select(DB::raw(EconomicComplement::basic_info_colums()."".$columns.""))
        // ->get();
        // $data = $economic_complements;
        // Util::excel($file_name, 'hoja', $data);
        // break;
        case '11':
          # code...
            $columns = ', observations.observations as observaciones';
            $file_name = $name.' '.date("Y-m-d H:i:s");

            $economic_complements = EconomicComplement::where('eco_com_procedure_id',$eco_com_procedure_id)
            ->ecocominfo()
            ->applicantinfo()
            ->affiliateinfo()
            ->ecocomstates()
            ->Observations()
            ->where('affiliate_observations.observation_type_id',2)
            //->select(DB::raw(EconomicComplement::basic_info_colums().",".EconomicComplement::basic_info_affiliates().",".EconomicComplement::basic_info_complements()."".$columns))
            ->get();
            dd($economic_complements);
            $data = $economic_complements;
            Util::excel($file_name,'observados prestamos',$data);

          break;
      default:
        
        break;
    }
    return "hola";
    // return Datatables::of($economic_complements)->make(true);
  }
}
