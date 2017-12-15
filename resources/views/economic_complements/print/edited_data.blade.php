@extends('globalprint.wkhtml')
@section('title2')
<h2 class="title" style="font-size: 16px; margin-bottom: 5px;">{!! $title2 !!}</h2>
@endsection
@section('content')
  <style type="text/css">
  .tablee{
    width: 100%;

  }
  .tablee, td, th{
    border: 2px solid rgba(0,0,0,0.7);
    border-collapse: collapse; 
    margin: 0px;
    padding: 0px;
    font-size: 11px; 
  }
  .number{
    text-align: center
  }
  thead{display: table-header-group;}
  tfoot {display: table-row-group;}
  tr {page-break-inside: avoid; }
  .title {
  margin-bottom: 0px;
  font-size: 0.9em;
}
</style>
      <div id="project">
        <table class="tablee">
          <thead>
          <tr>
               <th style="padding: 3px; width: 10px" class="number grand bold">N°</th>
               <th style="padding: 3px; width: 50px" class="grand bold">C.I.</th>
               <th style="padding: 3px; width: 100px" class="grand bold">NOMBRES Y APELLIDOS</th>
               <th style="padding: 3px; width: 20px" class="grand bold">TIPO DE PRESTACIÓN</th>
               <th style="padding: 3px; width: 30px" class="grand bold">GRADO</th>
               <th style="padding: 3px; width: 20px" class="grand bold">CAT.</th>
               <th style="padding: 3px; width: 30px" class="grand bold">N° DE TRAMITE</th>
               <th style="padding: 3px; width: 20px" class="grand bold">TOTAL</th>
               <th style="padding: 3px; width: 100px" class="grand bold">FIRMA</th>
           </tr>
          </thead>
            @foreach($economic_complements as $index=>$item)
            <tr>
                <td class="number">{!! $index+1 !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  ">{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card ? $item->economic_complement_applicant->city_identity_card->first_shortened.'.' : '' !!} </td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  ">{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
                <td class="text-center" style="padding-left:10px; padding-top:20px; padding-bottom:18px; ">{!! strtoupper($item->economic_complement_modality->economic_complement_type->name) ?? '' !!}</td>
                <td class="text-center" style="padding-left:10px; padding-top:20px; padding-bottom:18px; " >{!! $item->degree->shortened ?? '' !!}</td>
                <td class="text-center" style="padding-left:10px; padding-top:20px; padding-bottom:18px; " >{!! $item->category->name ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;   text-align: center;">{!! $item->code !!}</td>
                <td style="padding-right:10px; padding-top:20px; padding-bottom:18px;   text-align: right;">Bs. {!! Util::formatMoney($item->total + ($item->amount_loan ?? 0) + ($item->amount_accounting ?? 0) + ($item->amount_replacement ?? 0) ) !!} </td>
                <td></td>
            </tr>
            @endforeach
            <tr>
              <td colspan="6"></td>
              <td style="text-align: center; font-weight: bold; padding-left:10px; padding-top:20px; padding-bottom:18px;" class="size-12">TOTAL</td>
              <td style="text-align: center" class="size-12"><strong>Bs. {!! $total !!}</strong></td>
              <td></td>
            </tr>
        </table>
        <br><br>
        <br>
        <table>
          <tr>
            <td class="padding-top"><strong>Elaborado y Revisado por</strong></td>
            <td class="padding-top"><strong>V° B°</strong></td>
            <td class="padding-top"><strong>V° B°</strong></td>
          </tr>
        </table>
    </div>
@endsection
