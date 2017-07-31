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
      $results =  $reader->select(array('ci','monto'))->get();
    //echo json_encode($results);
    //exit();
      $sheet = $results;
      //echo $sheet;
      foreach($sheet as $r){
         $afiliado = Affiliate::where('identity_card','=',$r->ci)->first();
         $Cont = new Contribution;
         $Cont->total = $r->total;
         $Cont->save();
         exit();
        //if($afiliado){echo $r->ci."<br>";}
      }
    });
  }
}
