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

       $current_year = Carbon::now()->year;
       $year_list =[$current_year => $current_year];
       $eco_com_year = EconomicComplement::distinct()->select('year')->orderBy('year', 'desc')->get();
       foreach ($eco_com_year as $item) {
           $year_list[Util::getYear($item->year)] = Util::getYear($item->year);
       }

       $report_type = ['' => '', '1' => 'Reporte diario de recepción', '2' => 'Reporte de beneficiarios', '3' => 'Reporte de apoderados', '4' => 'Reporte de doble percepción', '5' => 'Resumen de inclusiones', '6' => 'Resumen de habituales', '7' => 'Reporte pago de complemento económico'];
       foreach ($report_type as $key => $item) {
           $report_type_list[$key] = $item;
       }

     return [
           'cities_list' => $cities_list,
           'semester_list' => $semester_list,
           'year_list' => $year_list,
           'report_type_list' => $report_type_list
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
                           $current_date = Carbon::now();
                           $hour = Carbon::parse($current_date)->toTimeString();
                           $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                           $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                           $eco_complements = DB::table('eco_com_applicants')
                                           ->select(DB::raw('economic_complements.id,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.shortened exp, CONCAT( IF(ISNULL(eco_com_applicants.last_name),"",eco_com_applicants.last_name), " ", IF(ISNULL(eco_com_applicants.mothers_last_name),"",eco_com_applicants.mothers_last_name), " ", IF(ISNULL(eco_com_applicants.surname_husband),"",eco_com_applicants.surname_husband), " ",  IF(ISNULL(eco_com_applicants.first_name),"",eco_com_applicants.first_name), " ", IF(ISNULL(eco_com_applicants.second_name),"",eco_com_applicants.second_name)) full_name, degrees.shortened,eco_com_types.name,pension_entities.name pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number'))
                                           ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                           ->leftJoin('users','economic_complements.user_id','=','users.id')
                                           ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                           ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                           ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                           ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                           ->leftJoin('eco_com_applicant_types', 'eco_com_applicants.eco_com_applicant_type_id', '=', 'eco_com_applicant_types.id')
                                           ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                           ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                           ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                           ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                           ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                           ->leftJoin('units','affiliates.unit_id','=','units.id')
                                           ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                           ->where('economic_complements.city_id', 'LIKE', $regional)
                                           ->whereYear('economic_complements.year', '=', $request->year)
                                           ->where('economic_complements.semester', 'LIKE', $semester)
                                           ->where('economic_complements.user_id', '=', Auth::user()->id)
                                           ->orderBy('economic_complements.id','ASC')
                                           ->get();
                           if ($eco_complements) {
                               $view = \View::make('economic_complements.print.daily_report', compact('header1','header2','title','date','hour','eco_complements'))->render();
                               $pdf = \App::make('dompdf.wrapper');
                               $pdf->loadHTML($view)->setPaper('legal','landscape');
                               return $pdf->stream();
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
                           $current_date = Carbon::now();
                           $hour = Carbon::parse($current_date)->toTimeString();
                           $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                           $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                           $beneficiary_eco_complements = DB::table('eco_com_applicants')
                                           ->select(DB::raw('economic_complements.id, economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.shortened exp, CONCAT( IF(ISNULL(eco_com_applicants.last_name),"",eco_com_applicants.last_name), " ", IF(ISNULL(eco_com_applicants.mothers_last_name),"",eco_com_applicants.mothers_last_name), " ", IF(ISNULL(eco_com_applicants.surname_husband),"",eco_com_applicants.surname_husband), " ",  IF(ISNULL(eco_com_applicants.first_name),"",eco_com_applicants.first_name), " ", IF(ISNULL(eco_com_applicants.second_name),"",eco_com_applicants.second_name)) full_name, degrees.shortened,eco_com_types.name,pension_entities.name pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number'))
                                           ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                           ->leftJoin('users','economic_complements.user_id','=','users.id')
                                           ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                           ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                           ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                           ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                           ->leftJoin('eco_com_applicant_types', 'eco_com_applicants.eco_com_applicant_type_id', '=', 'eco_com_applicant_types.id')
                                           ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                           ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                           ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                           ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                           ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                           ->leftJoin('units','affiliates.unit_id','=','units.id')
                                           ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                           ->where('economic_complements.city_id', 'LIKE', $regional)
                                           ->whereYear('economic_complements.year', '=', $request->year)
                                           ->where('economic_complements.semester', 'LIKE', $semester)
                                           ->orderBy('economic_complements.id','ASC')
                                           ->get();
                                           //dd($beneficiary_eco_complements);
                           if ($beneficiary_eco_complements) {
                               $view = \View::make('economic_complements.print.beneficiary_report', compact('header1','header2','title','date','hour','beneficiary_eco_complements'))->render();
                               $pdf = \App::make('dompdf.wrapper');
                               $pdf->loadHTML($view)->setPaper('legal','landscape');
                               return $pdf->stream();
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
                           $current_date = Carbon::now();
                           $hour = Carbon::parse($current_date)->toTimeString();
                           $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                           $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                           $representative_eco_complements = DB::table('eco_com_legal_guardians')
                                           ->select(DB::raw('economic_complements.id,economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.shortened exp, CONCAT( IF(ISNULL(eco_com_applicants.last_name),"",eco_com_applicants.last_name), " ", IF(ISNULL(eco_com_applicants.mothers_last_name),"",eco_com_applicants.mothers_last_name), " ", IF(ISNULL(eco_com_applicants.surname_husband),"",eco_com_applicants.surname_husband), " ",  IF(ISNULL(eco_com_applicants.first_name),"",eco_com_applicants.first_name), " ", IF(ISNULL(eco_com_applicants.second_name),"",eco_com_applicants.second_name)) full_name, degrees.shortened,eco_com_types.name,pension_entities.name pension_entity,users.username, eco_com_legal_guardians.identity_card as ci, cities2.shortened as exp1, CONCAT( IF(ISNULL(eco_com_legal_guardians.last_name),"",eco_com_legal_guardians.last_name), " ", IF(ISNULL(eco_com_legal_guardians.mothers_last_name),"",eco_com_legal_guardians.mothers_last_name), " ", IF(ISNULL(eco_com_legal_guardians.surname_husband),"",eco_com_legal_guardians.surname_husband), " ",  IF(ISNULL(eco_com_legal_guardians.first_name),"",eco_com_legal_guardians.first_name), " ", IF(ISNULL(eco_com_legal_guardians.second_name),"",eco_com_legal_guardians.second_name)) full_repre,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number'))
                                           ->leftJoin('eco_com_applicants','eco_com_legal_guardians.eco_com_applicant_id','=', 'eco_com_applicants.id')
                                           ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                           ->leftJoin('users','economic_complements.user_id','=','users.id')
                                           ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                           ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                           ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                           ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                           ->leftJoin('cities as cities2', 'eco_com_legal_guardians.city_identity_card_id', '=', 'cities2.id')
                                           ->leftJoin('eco_com_applicant_types', 'eco_com_applicants.eco_com_applicant_type_id', '=', 'eco_com_applicant_types.id')
                                           ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                           ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                           ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                           ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                           ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                           ->leftJoin('units','affiliates.unit_id','=','units.id')
                                           ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                           ->where('economic_complements.city_id', 'LIKE', $regional)
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
                               $current_date = Carbon::now();
                               $hour = Carbon::parse($current_date)->toTimeString();
                               $regional = ($request->city == 'Todo') ? '%%' : $request->city;
                               $semester = ($request->semester == 'Todo') ? '%%' : $request->semester;
                               $double_perception_eco_complements = DB::table('eco_com_applicants')
                                               ->select(DB::raw('economic_complements.id, economic_complements.affiliate_id,economic_complements.code,economic_complements.semester,economic_complements.reception_date,cities.name as city,eco_com_applicants.identity_card,cities1.shortened exp, CONCAT( IF(ISNULL(eco_com_applicants.last_name),"",eco_com_applicants.last_name), " ", IF(ISNULL(eco_com_applicants.mothers_last_name),"",eco_com_applicants.mothers_last_name), " ", IF(ISNULL(eco_com_applicants.surname_husband),"",eco_com_applicants.surname_husband), " ",  IF(ISNULL(eco_com_applicants.first_name),"",eco_com_applicants.first_name), " ", IF(ISNULL(eco_com_applicants.second_name),"",eco_com_applicants.second_name)) full_name, degrees.shortened,eco_com_types.name,pension_entities.name pension_entity,users.username,eco_com_applicants.phone_number,eco_com_applicants.cell_phone_number'))
                                               ->leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                               ->leftJoin('users','economic_complements.user_id','=','users.id')
                                               ->leftJoin('affiliates', 'economic_complements.affiliate_id', '=', 'affiliates.id')
                                               ->leftJoin('cities', 'economic_complements.city_id', '=', 'cities.id')
                                               ->leftJoin('cities as cities0','affiliates.city_identity_card_id','=','cities0.id')
                                               ->leftJoin('cities as cities1', 'eco_com_applicants.city_identity_card_id', '=', 'cities1.id')
                                               ->leftJoin('eco_com_applicant_types', 'eco_com_applicants.eco_com_applicant_type_id', '=', 'eco_com_applicant_types.id')
                                               ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id', '=', 'eco_com_modalities.id')
                                               ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id', '=', 'eco_com_types.id')
                                               ->leftJoin('eco_com_states', 'economic_complements.eco_com_state_id', '=', 'eco_com_states.id')
                                               ->leftJoin('eco_com_state_types', 'eco_com_states.eco_com_state_type_id', '=', 'eco_com_state_types.id')
                                               ->leftJoin('degrees','affiliates.degree_id','=','degrees.id')
                                               ->leftJoin('units','affiliates.unit_id','=','units.id')
                                               ->leftJoin('pension_entities','affiliates.pension_entity_id','=','pension_entities.id')
                                               ->where('economic_complements.city_id', 'LIKE', $regional)
                                               ->whereYear('economic_complements.year', '=', $request->year)
                                               ->where('economic_complements.semester', 'LIKE', $semester)
                                               ->whereIn('eco_com_applicants.identity_card', function($query) {
                                                   $query->select(DB::raw('eco_com_applicants.identity_card'))
                                                   ->from('eco_com_applicants')
                                                   ->groupBy('eco_com_applicants.identity_card')
                                                   ->havingRaw('COUNT(economic_complements.id) > 1');
                                               })->orderBy('economic_complements.id','ASC')->get();

                               if ($double_perception_eco_complements) {
                                   $view = \View::make('economic_complements.print.double_perception_report', compact('header1','header2','title','date','hour','double_perception_eco_complements'))->render();
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
                       $message = "Reporte en proceso";
                       Session::flash('message', $message);
                       return redirect('report_complement');
                       break;

                       default:
                               return redirect('report_complement');
               }
           }
   }


}
