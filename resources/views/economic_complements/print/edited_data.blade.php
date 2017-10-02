@extends('globalprint.wkhtml')
@section('title2')
<center class="title">{{ $title2 }}</center> 
@endsection
@section('content')
  <style type="text/css">
  .tablee{
    width: 100%;
  }
  .tablee, td, th{
    border: .5px solid rgba(0,0,0,.5);
    border-collapse: collapse; 
    margin: 0px;
    padding: 0px;
    font-size: 11px; 
  }
  .number{
    text-align: center
  }
  tr {page-break-inside: avoid; }
  .title {
  margin-bottom: 0px;
  font-size: 0.9em;
}
</style>
      <div id="project">
        <table class="tablee">
          <tr>
               <th style="padding: 3px; width: 10px" class="number">N°</th>
               <th style="padding: 3px; width: 50px" class="grand">DOC. IDENTIDAD</th>
               <th style="padding: 3px; width: 100px" class="grand">NOMBRES Y APELLIDOS</th>
               <th style="padding: 3px; width: 20px" class="grand">TIPO RENTA</th>
               <th style="padding: 3px; width: 30px" class="grand">GRADO</th>
               <th style="padding: 3px; width: 30px" class="grand">N° DE TRAMITE</th>
               <th style="padding: 3px; width: 20px" class="grand">LIQ. PAGABLE</th>
               <th style="padding: 3px; width: 110px" class="grand">FIRMA</th>
           </tr>
           <?php $x=10?>  
            @foreach($economic_complements as $index=>$item)
            @if($index<10)
            <tr>
                <td class="number">{!! $index+1 !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  ">{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card->first_shortened ?? '' !!} </td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  ">{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px; ">{!! strtoupper($item->economic_complement_modality->economic_complement_type->name) ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px; " >{!! $item->degree->shortened ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;   text-align: center;">{!! $item->code !!}</td>
                <td style="padding-right:10px; padding-top:20px; padding-bottom:18px;   text-align: right;">Bs. {!! Util::formatMoney($item->total) !!} </td>
                <td></td>
            </tr>
            @elseif( $index == $x )
              <?php $x=$x+13?>
              <tr>
               <th style=" padding:9px;" class="number">N°</th>
               <th style=" padding:9px;" class="grand">DOC. IDENTIDAD</th>
               <th style=" padding:9px;" class="grand">NOMBRES Y APELLIDOS</th>
               <th style=" padding:9px;" class="grand">TIPO RENTA</th>
               <th style=" padding:9px;" class="grand">GRADO</th>
               <th style=" padding:9px;" class="grand">N° DE TRAMITE</th>
               <th style=" padding:9px;" class="grand">LIQ. PAGABLE</th>
               <th style=" padding:9px;" class="grand">FIRMA</th>
           </tr>
            <tr>
                <td class="number">{!! $index+1 !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  ">{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card->first_shortened ?? '' !!} </td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px; ">{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px; ">{!!strtoupper($item->economic_complement_modality->economic_complement_type->name) ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;" >{!! $item->degree->shortened ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;   text-align: center;">{!! $item->code !!}</td>
                <td style="padding-right:10px; padding-top:20px; padding-bottom:18px;   text-align: right;">Bs. {!! Util::formatMoney($item->total) !!} </td>
                <td></td>
            </tr>
              @else
              <tr>
                <td class="number">{!! $index+1 !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  ">{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card->first_shortened ?? '' !!} </td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  ">{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px; ">{!!strtoupper($item->economic_complement_modality->economic_complement_type->name) ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;" >{!! $item->degree->shortened ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  text-align: center;">{!! $item->code !!}</td>
                <td style="padding-right:10px; padding-top:20px; padding-bottom:18px;  text-align: right;">Bs. {!! Util::formatMoney($item->total) !!} </td>
                <td></td>
            </tr>
            @endif
            @endforeach
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td style="text-align: center; font-weight: bold; padding-left:10px; padding-top:20px; padding-bottom:18px;">TOTAL</td>
              <td style="text-align: center">Bs. {!! $total !!}</td>
              <td></td>
            </tr>
        </table>
    </div>
@endsection
