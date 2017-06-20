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

       $report_type = ['' => '', '1' => 'Reporte de recepción por usuario', '2' => 'Reporte de beneficiarios', '3' => 'Reporte de apoderados', '4' => 'Reporte de doble percepción', '5' => 'Resumen de habituales', '6' => 'Resumen de inclusiones', '7' => 'Reporte pago de complemento económico'];
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
                           $title = "REPORTE DIARIO DE TRÁMITES DEL COMPLEMENTO ECONÓMICO";
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
