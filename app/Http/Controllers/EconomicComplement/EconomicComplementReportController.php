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
use DB;

class EconomicComplementReportController extends Controller
{

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

       $current_year = Carbon::now()->year;
       $year_list =[$current_year => $current_year];
       $eco_com_year = EconomicComplement::distinct()->select('year')->orderBy('year', 'desc')->get();
       foreach ($eco_com_year as $item) {
           $year_list[Util::getYear($item->year)] = Util::getYear($item->year);
       }

       $report_type = ['' => '', '1' => 'Reporte de recepción por usuario', '2' => 'Reporte de beneficiarios', '3' => 'Reporte de apoderados', '4' => 'Reporte de doble percepción', '5' => 'Resumen de habituales', '6' => 'Resumen de inclusiones', '7' => 'Reporte por Intervalo de fechas','8' => 'Reporte Subsanados','9' => 'Reporte en Excel','10' => 'Reporte de excluidos por salario'];
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
           if($request->has('type')) {
               switch ($request->type) {
                   case '1':
                           $header1 = "DIRECCIÓN DE BENEFICIOS ECONÓMICOS";
                           $header2 = "UNIDAD DE OTORGACIÓN DEL COMPLEMENTO ECONÓMICO";
                           $title = "REPORTE DIARIO DE TRÁMITES DEL COMPLEMENTO ECONÓMICO".$request->get('from')." AL ".$request->get('to');
                           $date = Util::getDateEdit(date('Y-m-d'));
                           $type = "user"; 
                           $user = Auth::user();                          
                           $current_date = Carbon::now();
                           $anio = Util::getYear($request->from);
                           $hour = Carbon::parse($current_date)->toTimeString();                           
                           $from = Util::datePick($request->get('from'));
                           $to = Util::datePick($request->get('to'));                          
                           $eco_complements = DB::table('eco_com_applicants')
                                           ->select(DB::raw("economic_complements.id,economic_complements.code,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.first_shortened as exp, concat_ws(' ', NULLIF(eco_com_applicants.last_name,null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null), NULLIF(eco_com_applicants.first_name, null), NULLIF(eco_com_applicants.second_name, null)) full_name, degrees.shortened,eco_com_types.name,pension_entities.name as pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number"))
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
                               
                               return \PDF::loadView('economic_complements.print.daily_report',compact('header1','header2','title','date','type','hour','eco_complements','anio','user'))->setPaper('letter')->setOrientation('landscape')->stream('report_by_user.pdf');
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
                           $anio = $request->year;
                           $current_date = Carbon::now();
                           $hour = Carbon::parse($current_date)->toTimeString();
                           $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                           $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                           $beneficiary_eco_complements = DB::table('eco_com_applicants')
                                           ->select(DB::raw("economic_complements.id, economic_complements.code,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.first_shortened as exp, concat_ws(' ', NULLIF(eco_com_applicants.last_name,null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null), NULLIF(eco_com_applicants.first_name, null), NULLIF(eco_com_applicants.second_name, null)) full_name, degrees.shortened,eco_com_types.name,pension_entities.name pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number"))
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
                           if ($beneficiary_eco_complements) {                              
                             return \PDF::loadView('economic_complements.print.beneficiary_report',compact('header1','header2','title','date','type','hour','beneficiary_eco_complements','anio','user'))->setPaper('letter')->setOrientation('landscape')->stream('report_beneficiary.pdf');

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
                                           ->select(DB::raw("economic_complements.id,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.first_shortened as exp, concat_ws(' ', NULLIF(eco_com_applicants.last_name,null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null), NULLIF(eco_com_applicants.first_name, null), NULLIF(eco_com_applicants.second_name, null)) as full_name, degrees.shortened,eco_com_types.name,pension_entities.name pension_entity,users.username, eco_com_legal_guardians.identity_card as ci, cities2.first_shortened as exp1, concat_ws(' ',NULLIF(eco_com_legal_guardians.last_name,null), NULLIF(eco_com_legal_guardians.mothers_last_name,null), NULLIF(eco_com_legal_guardians.first_name,null),NULLIF(eco_com_legal_guardians.second_name,null)) as full_repre,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number"))
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
                               $double_perception_eco_complements = DB::table('eco_com_applicants')
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
                                               ->whereIn('eco_com_applicants.identity_card', function($query) {
                                                   $query->select(DB::raw("applicants.identity_card"))
                                                   ->from('eco_com_applicants as applicants')
                                                   ->groupBy('applicants.identity_card')
                                                   ->havingRaw("COUNT(applicants.identity_card) > 1");
                                               })->orderBy('economic_complements.id','ASC')->get();

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
                                           ->select(DB::raw("economic_complements.id,economic_complements.code,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.first_shortened as exp, concat_ws(' ', NULLIF(eco_com_applicants.last_name,null), NULLIF(eco_com_applicants.mothers_last_name, null), NULLIF(eco_com_applicants.surname_husband, null), NULLIF(eco_com_applicants.first_name, null), NULLIF(eco_com_applicants.second_name, null)) full_name, degrees.shortened,eco_com_types.name,pension_entities.name as pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number"))
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
                               
                               return \PDF::loadView('economic_complements.print.daily_report',compact('header1','header2','title','date','type','hour','eco_complements','anio','user'))->setPaper('letter')->setOrientation('landscape')->stream('report_by_user.pdf');
                           } else {
                               $message = "No existen registros para visualizar";
                               Session::flash('message', $message);
                               return redirect('report_complement');
                           }
                           break;
                        case '8':                          
                                
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
                                      $view = \View::make('economic_complements.print.report_excluded_by_salary', compact('header1','header2','title','date','hour','excluded_by_salary','anio'))->render();
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


}
