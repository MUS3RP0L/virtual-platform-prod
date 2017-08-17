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
   /* Importar datos aporte Activos Filemarker*/
  public function importAA(){
    
      Excel::load('D:\Aportes\AA.xlsx',function($reader){

      global $rows,$rows1;
      $afiliadoNoImportado = array();

      $results =  $reader->select(array('ci','matricula','nombre','grado','anio','mes','cod_afi','fecha','recibo','monto'))->get();
      //echo json_encode($results);
      //exit();
      //para informe excel no importados
      $rows = array();
      $titulos= array('ci','matricula','nombre','paterno','materno','grado','anio','mes','cod_afi','fecha','recibo','monto', 'montoregistrado','observacion');
      array_push($rows, $titulos);

      $results = $reader->select(array('ci', 'ci_a'))->get();

      $sheet = $results;
      //echo $sheet;
      foreach($sheet as $r){
         $afiliado = DB::table('contributions')
         ->join('affiliates','contributions.affiliate_id','=','affiliates.id')
         ->where('affiliates.identity_card','=',$r->ci)->select('affiliates.id','contributions.user_id','contributions.affiliate_id','contributions.degree_id','contributions.unit_id','contributions.breakdown_id','contributions.category_id','contributions.month_year','contributions.item','contributions.type')->first();
         $sw=1;

         if(!$afiliado){
          $afiliado = DB::table('contributions')
          ->join('affiliates','contributions.affiliate_id','=','affiliates.id')
          ->join('spouses','affiliates.id','=','spouses.affiliate_id')
          ->where('spouses.identity_card','=',$r->ci)
          ->select('affiliates.id','contributions.user_id','contributions.affiliate_id','contributions.degree_id','contributions.unit_id','contributions.breakdown_id','contributions.category_id','contributions.month_year','contributions.item','contributions.type')->first(); 
          $sw=2; 
        }elseif(!$afiliado){  
         $afiliado = DB::table('affiliates')
           ->where('affiliates.identity_card','=',$r->ci)->select('affiliates.id','affiliates.user_id','affiliates.degree_id','affiliates.unit_id','affiliates.category_id')->first();
           $sw=3; 
         }
         //$afiliado = Affiliate::where('identity_card','=',$r->ci)->first();

        if($afiliado) {

          if($r->mes < 10)
             { $mes = "0".$r->mes; }
          else
             { $mes = $r->mes; }
          $fecha = $r->anio."-".$mes."-01";


          $Duplicidad = DB::table('contributions')
                      ->where('contributions.affiliate_id','=',$afiliado->id)
                      ->where('contributions.month_year','=',"'".$fecha."'")
                      ->where('contributions.month_year','>=','2001-01-01')
                      ->where('contributions.month_year','<=','2013-12-01')
                      ->select('contributions.user_id','contributions.total')->first();

          if(!$Duplicidad){
              
               if($sw==3){ 
               $Cont = new Contribution;
               $Cont->user_id = $afiliado->user_id;
               $Cont->affiliate_id = $afiliado->id;
               //$Cont->direct_contribution_id = 1;
               $Cont->degree_id = $afiliado->degree_id;
               $Cont->unit_id = $afiliado->unit_id;
               $Cont->breakdown_id = 0;
               $Cont->category_id = $afiliado->category_id;

               $date = $r->anio."-".$mes."-01";
               $Cont->month_year =$date;
               $Cont->item = 0;
               $Cont->type ="Planillas";
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
              //echo "De la BD: ".$afiliado->identity_card." Del Excel:".$r->anio."<br>";
              //Se guarda dicho resultado a exportar en excel
              $row =array($r->ci,$r->matricula,$r->nombre,$r->paterno,$r->materno,$r->grado,$r->anio,$r->mes,$r->cod_afi,$r->fecha,$r->recibo,$r->monto,'----','Importado a la BD, el affiliado no tenia ningun registro de aporte');
              array_push($rows, $row);
            }else{

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


              //echo "De la BD: ".$afiliado->identity_card." Del Excel:".$r->anio."<br>";
              //Se guarda dicho resultado a exportar en excel
              $row =array($r->ci,$r->matricula,$r->nombre,$r->paterno,$r->materno,$r->grado,$r->anio,$r->mes,$r->cod_afi,$r->fecha,$r->recibo,$r->monto,'----','Importado a la BD');
              array_push($rows, $row);

            }
          }
          else {
                if($fecha >= '2001-01-01' && $fecha <= '2013-12-01'){
                  $row =array($r->ci,$r->matricula,$r->nombre,$r->paterno,$r->materno,$r->grado,$r->anio,$r->mes,$r->cod_afi,$r->fecha,$r->recibo,$r->monto,$Duplicidad->total,'Este aporte esta registrado en periodo de 2001-01-01 al 2013-12-01 en Contributions');
                array_push($rows, $row);
               
              }else{


                    $row =array($r->ci,$r->matricula,$r->nombre,$r->paterno,$r->materno,$r->grado,$r->anio,$r->mes,$r->cod_afi,$r->fecha,$r->recibo,$r->monto,'-----','Este aporte se migrara del Sismu por estar comprendido despues del periodo 2013-12-01');
                    array_push($rows, $row);

              }
               
          }


        }
        else {
          $row =array($r->ci,$r->matricula,$r->nombre,$r->paterno,$r->materno,$r->grado,$r->anio,$r->mes,$r->cod_afi,$r->fecha,$r->recivo,$r->monto,'-----','No se halla al afiliado en registro de aportes');
          array_push($rows, $row);
          }
        }


    });

    //Resultado de importacion Aporte Activos Filemarker
    Excel::create('ImportadosAporteActivosFM_'.date("YmdHis"),function($excel)
    {

        global $rows;
                   $excel->sheet('AportePasivosFileMarker',function($sheet) {

                        global $rows;

                         $sheet->fromArray($rows);

                     });

           })->store('xls', storage_path('excel/exports'));
  }

/* Importar datos aporte Pasivos Filemarker*/
  public function importAP(){
    Excel::load('D:\Aportes\AP.xlsx',function($reader){

      global $rows,$rows1;
      $afiliadoNoImportado = array();

      $results =  $reader->select(array('ci','matricula','nombre','grado','anio','mes','cod_afi','fecha','recibo','monto'))->get();
      //echo json_encode($results);
      //exit();
      //para informe excel no importados
      $rows = array();
      $titulos= array('ci','matricula','nombre','grado','anio','mes','cod_afi','fecha','recibo','monto', 'montoregistrado','observacion');
      array_push($rows, $titulos);

      $results = $reader->select(array('ci', 'ci_a'))->get();

      $sheet = $results;
      //echo $sheet;
      foreach($sheet as $r){
        $afiliado = DB::table('contributions')
                    ->join('affiliates','contributions.affiliate_id','=','affiliates.id')
                    ->where('affiliates.identity_card','=',$r->ci)->select('affiliates.id','contributions.user_id','contributions.affiliate_id','contributions.degree_id','contributions.unit_id','contributions.breakdown_id','contributions.category_id','contributions.month_year','contributions.item','contributions.type')->first();

        if(!$afiliado){
          $afiliado = DB::table('contributions')
          ->join('affiliates','contributions.affiliate_id','=','affiliates.id')
          ->join('spouses','affiliates.id','=','spouses.affiliate_id')
          ->where('spouses.identity_card','=',$r->ci)
          ->select('affiliates.id','contributions.user_id','contributions.affiliate_id','contributions.degree_id','contributions.unit_id','contributions.breakdown_id','contributions.category_id','contributions.month_year','contributions.item','contributions.type')->first(); 
          $sw=2; 
        }elseif(!$afiliado){  
         $afiliado = DB::table('affiliates')
           ->where('affiliates.identity_card','=',$r->ci)->select('affiliates.id','affiliates.user_id','affiliates.degree_id','affiliates.unit_id','affiliates.category_id')->first();
           $sw=3; 
         }            

         //$afiliado = Affiliate::where('identity_card','=',$r->ci)->first();

        if($afiliado) {

          if($r->mes < 10)
             { $mes = "0".$r->mes; }
          else
             { $mes = $r->mes; }
          $fecha = $r->anio."-".$mes."-01";

          $Duplicidad = DB::table('contributions')
                      ->where('contributions.affiliate_id','=',$afiliado->id)
                      ->where('contributions.month_year','=',$fecha)
                      ->select('contributions.user_id','contributions.total')
                      ->first();

          if(!$Duplicidad){


              //Si no existe aporte en el sistema se lo registra
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
               $Cont->total = Util::decimal($r->monto);
               $Cont->save();


              //echo "De la BD: ".$afiliado->identity_card." Del Excel:".$r->anio."<br>";
              //Se guarda dicho resultado a exportar en excel
              $row =array($r->ci,$r->matricula,$r->paterno.' '.$r->materno.' '.$r->nombre,$r->grado,$r->anio,$r->mes,$r->cod_afi,$r->fecha,$r->recibo,$r->monto,'----','Importado a la BD');
              array_push($rows, $row);
          }
          else {
                $row =array($r->ci,$r->matricula,$r->paterno.' '.$r->materno.' '.$r->nombre,$r->grado,$r->anio,$r->mes,$r->cod_afi,$r->fecha,$r->recibo,$r->monto,$Duplicidad->total,'Se halla registrado el aporte');
                array_push($rows, $row);
          }


        }
        else {
          $row =array($r->ci,$r->matricula,$r->paterno.' '.$r->materno.' '.$r->nombre,$r->grado,$r->anio,$r->mes,$r->cod_afi,$r->fecha,$r->recivo,$r->monto,'-----','No se halla al afiliado en registro de aportes');
          array_push($rows, $row);
          }
        }


    });

    //Resultado de importacion Aporte Pasivos Filemarker
    Excel::create('ResImportadosAportePasivosFM',function($excel)
    {

        global $rows;
                   $excel->sheet('AportePasivosFileMarker',function($sheet) {

                        global $rows;

                         $sheet->fromArray($rows);

                     });

           })->store('xls', storage_path('excel/exports'));
  }

/* Importar datos aporte SISMU*/
  public function importAS(){
      
      ini_set('memory_limit', '-1');
      ini_set('max_execution_time', '-1');
      ini_set('max_input_time', '-1');
      set_time_limit('-1');

      Excel::load('D:\Aportes\AS1.xls',function($reader){
      
      global $rows;

      $rows = array();
      $titulos = array('matricula','paterno','materno','ap_casada','nombres','ci','telefono','celular','anio','mes','haberbasico','cotizable','totalaporte','aporteregistrado','observacion');
      array_push($rows, $titulos);

      $results =  $reader->select(array('matricula','paterno','ap_casada','materno','nombres','ci','telefono','celular','anio','mes','haberbasico','cotizable','aporte','totalaporte'))->get();
      $sheet = $results;

      //echo $sheet;
      foreach($sheet as $r){

        if($r->mes < 10)
             { $mes = "0".$r->mes; }
        else
             { $mes = $r->mes; }
        $fecha = $r->anio."-".$mes."-01";

        if($fecha >= '2014-01-01'){   
        $afiliado = DB::table('contributions')
                    ->join('affiliates','contributions.affiliate_id','=','affiliates.id')
                    ->where('affiliates.identity_card','=',$r->ci)->select('affiliates.id','contributions.user_id','contributions.affiliate_id','contributions.degree_id','contributions.unit_id','contributions.breakdown_id','contributions.category_id','contributions.month_year','contributions.item','contributions.type')->first();

         //$afiliado = Affiliate::where('identity_card','=',$r->ci)->first();

        if($afiliado) {
          
          $Duplicidad = DB::table('contributions')
                      ->where('contributions.affiliate_id','=',$afiliado->id)
                      ->where('contributions.month_year','=',$fecha)
                      ->where('contributions.month_year','>=','2014-01-01')
                      ->select('contributions.user_id','contributions.total')->first();
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
                     $Cont->gain = $r->haberbasico;
                     $Cont->payable_liquid =0;
                     $Cont->quotable =$r->cotizable;
                     $Cont->retirement_fund =0;
                     $Cont->mortuary_quota = 0;
                     $Cont->mortuary_aid =0;
                     $Cont->subtotal =0;
                     $Cont->ipc =0;
                     $Cont->total = $r->totalaporte;
                     $Cont->save();
                     //Se guarda dicho resultado a exportar en excel
                     $row =array($r->matricula,$r->paterno,$r->ap_casada,$r->materno,$r->nombres,$r->ci,$r->telefono,$r->celular,$r->anio,$r->mes,$r->haberbasico,$r->cotizable,$r->totalaporte,'----','Importado a la BD');
                     array_push($rows, $row);
                }
                else
                {
                      $row =array($r->matricula,$r->paterno,$r->ap_casada,$r->materno,$r->nombres,$r->ci,$r->telefono,$r->celular,$r->anio,$r->mes,$r->haberbasico,$r->cotizable,$r->totalaporte,$Duplicidad->total,'Se halla registrado el aporte');
                      array_push($rows, $row);
                }
          }
          else
          {
                      $row =array($r->matricula,$r->paterno,$r->ap_casada,$r->materno,$r->nombres,$r->ci,$r->telefono,$r->celular,$r->anio,$r->mes,$r->haberbasico,$r->cotizable,$r->totalaporte,'-----','No se halla al afiliado en registro de aportes');
                      array_push($rows, $row);
          }
        }else{
          //si fecha es antes de 2014-01-01
               $row =array($r->matricula,$r->paterno,$r->ap_casada,$r->materno,$r->nombres,$r->ci,$r->telefono,$r->celular,$r->anio,$r->mes,$r->haberbasico,$r->cotizable,$r->totalaporte,'-----','Posible registro de aportes en Filemarker');
                      array_push($rows, $row);
        }  

      }
    });

    //Resultado de importacion Aporte Sismu
    Excel::create('ImportadosAporteSISMU_'.date("YdmHis"),function($excel)
    {

        global $rows;
                   $excel->sheet('ResultadoImportacionAporteSISMU',function($sheet) {

                        global $rows;

                         $sheet->fromArray($rows);

                     });

           })->store('xls', storage_path('excel/exports'));
  }
}
