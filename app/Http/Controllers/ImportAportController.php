<?php

namespace Muserpol\Http\Controllers;

use Illuminate\Http\Request;

use Muserpol\Http\Requests;
use Muserpol\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
// use App\Affiliate;
use Muserpol\Affiliate;
use Muserpol\Contribution;

class ImportAportController extends Controller
{
  public function importAP(){
    Excel::load('D:\Aportes\APORTES ACTIVOS - FILE MAKER.xlsx',function($reader){
      $results =  $reader->select(array('ci','matricula','anio','mes','cod_afi','fecha','recibo','monto'))->get();
      //echo json_encode($results);
      //exit();
      $sheet = $results;
      //echo $sheet;
      foreach($sheet as $r){
        $afiliado = DB::table('contributions')
                    ->join('affiliates','contributions.affiliate_id','=','affiliates.id')
                    ->where('affiliates.identity_card','=',$r->ci)->select('affiliates.id','contributions.user_id','contributions.affiliate_id','contributions.degree_id','contributions.unit_id','contributions.breakdown_id','contributions.category_id','contributions.month_year','contributions.item','contributions.type')->first();

         //$afiliado = Affiliate::where('identity_card','=',$r->ci)->first();

        if($afiliado) {

          if($r->mes < 10)
             { $mes = "0".$r->mes; }
          else
             { $mes = $r->mes; }
          $fecha = $r->anio."-".$mes."-01";

          $Duplicidad = DB::table('contributions')
                      ->where('contributions.affiliate_id','=',$afiliado->id)
                      ->where('contributions.month_year','=',$fecha)->select('contributions.user_id')->first();
          if(!$Duplicidad){
              $Cont = new Contribution;
               $Cont->user_id = $afiliado->user_id;
               $Cont->affiliate_id = $afiliado->affiliate_id;
               //$Cont->direct_contribution_id = 1;
               $Cont->degree_id = $afiliado->degree_id;
               $Cont->unit_id = $afiliado->unit_id;
               $Cont->breakdown_id = $afiliado->breakdown_id;
               $Cont->category_id = $afiliado->category_id;

               $date = $r->anio."-".$mes."-01";
               $Cont->month_year =$date;
               $Cont->item = $afiliado->item;
               $Cont->type = $afiliado->type;
               $Cont->base_wage = 0;
               $Cont->dignity_pension = 0;
               $Cont->seniority_bonus = 0;
               $Cont->study_bonus = 0;
               $Cont->position_bonus = 0;
               $Cont->border_bonus = 0;
               $Cont->east_bonus = 0;
               $Cont->public_security_bonus =0;
               $Cont->deceased = 0;
               $Cont->natality = 0;
               $Cont->lactation = 0;
               $Cont->prenatal = 0;
               $Cont->subsidy = 0;
               $Cont->gain =0;
               $Cont->payable_liquid =0;
               $Cont->quotable =0;
               $Cont->retirement_fund =0;
               $Cont->mortuary_quota = 0;
               $Cont->mortuary_aid =0;
               $Cont->subtotal =0;
               $Cont->ipc =0;
               $Cont->total = $r->monto;
               $Cont->save();
      /*
               if($r->mes < 10)
                  { $mes = "0".$r->mes; }
               else
                  { $mes = $r->mes; }
                echo $afiliado->affiliate_id." ".$r->anio."-".$mes."-01<br>";
      */
               //echo var_dump($afiliado);
               //echo $afiliado->user_id;
               //exit();

              //echo "De la BD: ".$afiliado->identity_card." Del Excel:".$r->anio."<br>";
          }
        }
      }
    });
  }
}
