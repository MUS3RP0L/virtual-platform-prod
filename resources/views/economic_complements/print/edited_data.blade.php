@extends('globalprint.wkhtml')
@section('title2')
    
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
    font-size: 7px; 
  }
  .tablee tr td {
    padding-left: 50px: 
  }
  .number{
    text-align: center
  }
</style>
      <div id="project">
        <table class="tablee">
           <tr>
               <th class="number"><h3>N°</h3></th>
               <th class="grand"><h3>DOC. IDENTIDAD</h3></th>
               <th class="grand"><h3>NOMBRES Y APELLIDOS</h3></th>
               <th class="grand"><h3>TIPO RENTA</h3></th>
               <th class="grand"><h3>GRADO</h3></th>
               <th class="grand"><h3>N° DE TRAMITE</h3></th>
               <th class="grand"><h3>LIQ. PAGABLE</h3></th>
               <th class="grand"><h3>FIRMA</h3></th>
           </tr>
           
            @foreach($economic_complements as $index=>$item)
            <tr>
                <td class="number"><h4>{!! $index+1 !!}</h5></td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:20px;  width: 80px;">{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card->first_shortened ?? '' !!} </td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:20px;  width: 200px;">{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:20px; ">{!! $item->economic_complement_modality->economic_complement_type->name ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:20px;  width: 100px;" >{!! $item->degree->shortened ?? '' !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:20px;  width: 70px">{!! $item->code !!}</td>
                <td style="padding-left:10px; padding-top:20px; padding-bottom:20px;  width: 50px">{!! $item->total !!}</td>
                <td style="width"></td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
