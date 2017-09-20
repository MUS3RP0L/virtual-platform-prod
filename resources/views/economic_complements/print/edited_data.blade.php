@extends('globalprint.wkhtml')
@section('title2')
<center>{{ $title2 }}</center> 
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
</style>
      <div id="project">
        <table class="tablee">
          <tr>
               <th style="padding: 2px;" class="number">N°</th>
               <th style="padding: 2px;" class="grand">DOC. IDENTIDAD</th>
               <th style="padding: 2px;" class="grand">NOMBRES Y APELLIDOS</th>
               <th style="padding: 2px;" class="grand">TIPO RENTA</th>
               <th style="padding: 2px;" class="grand">GRADO</th>
               <th style="padding: 2px;" class="grand">N° DE TRAMITE</th>
               <th style="padding: 2px;" class="grand">LIQ. PAGABLE</th>
               <th style="padding: 2px;" class="grand">FIRMA</th>
           </tr>
           <?php $x=10?>  
            @foreach($economic_complements as $index=>$item)
            @if($index<10)
            <tr>
                <td class="number">{!! $index+1 !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 80px;">{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card->first_shortened ?? '' !!} </td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 200px;">{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px; ">{!! strtoupper($item->economic_complement_modality->economic_complement_type->name) ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 100px;" >{!! $item->degree->shortened ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 70px; text-align: center;">{!! $item->code !!}</td>
                <td style="padding-right:10px; padding-top:20px; padding-bottom:18px;  width: 50px; text-align: right;">Bs. {!! Util::formatMoney($item->total) !!} </td>
                <td></td>
            </tr>
            @elseif( $index == $x )
              <?php $x=$x+13?>
              <tr>
               <th style=" padding:9px;  width: 10px;" class="number">N°</th>
               <th style=" padding:9px;  width: 70px;" class="grand">DOC. IDENTIDAD</th>
               <th style=" padding:9px;  width: 80px;" class="grand">NOMBRES Y APELLIDOS</th>
               <th style=" padding:9px;  width: 80px;" class="grand">TIPO RENTA</th>
               <th style=" padding:9px;" class="grand">GRADO</th>
               <th style=" padding:9px;  width: 80px;" class="grand">N° DE TRAMITE</th>
               <th style=" padding:9px;  width: 0px;" class="grand">LIQ. PAGABLE</th>
               <th style=" padding:9px;  width: 80px;" class="grand">FIRMA</th>
           </tr>
            <tr>
                <td class="number">{!! $index+1 !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 80px;">{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card->first_shortened ?? '' !!} </td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 200px;">{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px; ">{!!strtoupper($item->economic_complement_modality->economic_complement_type->name) ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;" >{!! $item->degree->shortened ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 70px; text-align: center;">{!! $item->code !!}</td>
                <td style="padding-right:10px; padding-top:20px; padding-bottom:18px;  width: 50px; text-align: right;">Bs. {!! Util::formatMoney($item->total) !!} </td>
                <td></td>
            </tr>
              @else
              <tr>
                <td class="number">{!! $index+1 !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 80px;">{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card->first_shortened ?? '' !!} </td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 200px;">{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px; ">{!!strtoupper($item->economic_complement_modality->economic_complement_type->name) ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;" >{!! $item->degree->shortened ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:18px;  width: 70px; text-align: center;">{!! $item->code !!}</td>
                <td style="padding-right:10px; padding-top:20px; padding-bottom:18px;  width: 50px; text-align: right;">Bs. {!! Util::formatMoney($item->total) !!} </td>
                <td></td>
            </tr>
            @endif

            @endforeach
        </table>
    </div>
@endsection
