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
    .number{
      text-align: center
    }
    thead{display: table-header-group;}
    tfoot {display: table-row-group;}
    tr {page-break-inside: avoid; }
    td{
      font-size: 9px;
    }
  </style>
      <div id="project">
        <table class="tablee">
          <thead>
           <tr>
              <th class="grand number"><h4>N°</h4></th>
              <th class="grand"><h4>REGIONAL</h4></th>
              <th class="grand"><h4>CI</h4></th>
              <th class="grand"><h4>NOMBRES Y APELLIDOS</h4></th>
              <th class="grand"><h4>FECHA</h4></th>
              <th class="grand"><h4>MODALIDAD</h4></th>
              <th class="grand"><h4>TELEFONO</h4></th>
              <th class="grand"><h4>CELULAR</h4></th>
              <th class="grand"><h4>N° TRÁMITE</h4></th>
           </tr>
          </thead>
            @foreach($economic_complements as $index=>$item)
            <tr>
              <td>{!! $index+1 !!}</td>
              <td>{!! $item->city->name ?? ''!!}</td>
              <td>{!! $item->economic_complement_applicant->identity_card ?? '' !!} {!! $item->economic_complement_applicant->city_identity_card->first_shortened ?? '' !!}</td>
              <td>{!! $item->economic_complement_applicant->getFullName() ?? '' !!}</td>
              <td>{!! Util::getDateEdit($item->reception_date) !!}</td>
              <td>{!! $item->economic_complement_modality->economic_complement_type->name ?? '' !!}</td>
              <td>{!! ($item->economic_complement_applicant->phone_number ?? '')!!}</td>
              <td>{!! ($item->economic_complement_applicant->cell_phone_number ?? '')!!}</td>
              <td>{!! $item->code !!}</td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
