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
  td{font-size: 9px;}
</style>
      <div id="project">
        <table class="tablee">
          <thead>
            
           <tr>
               <th class="grand number"><h4>N°</h4></th>
               <th class="grand"><h4>REGIONAL</h4></th>
               <th class="grand"><h4>CI</h4></th>
               <th class="grand"><h4>NOMBRES Y APELLIDOS</h4></th>
               <th class="grand"><h4>GRADO</h4></th>
               <th class="grand"><h4>RENTA</h4></th>
               <th class="grand"><h4>FECHA</h4></th>
               <th class="grand"><h4>GESTOR</h4></th>
               <th class="grand"><h4>TIPO</h4></th>
               <th class="grand"><h4>TELF/CEL</h4></th>
               <th class="grand"><h4>N° TRÁMITE</h4></th>

           </tr>
          </thead>
            @foreach($beneficiary_eco_complements as $index=>$item)
            <tr>
                <td class="number">{!! $index+1 !!}</td>
                <td>{!! $item->city !!}</td>
                <td>{!! $item->identity_card !!} {!! $item->exp !!}</td>
                <td>{!! $item->full_name !!}</td>
                <td>{!! $item->shortened !!}</td>
                <td>{!! $item->name !!}</td>
                <td>{!! Util::getDateEdit($item->reception_date) !!}</td>
                <td>{!! $item->pension_entity !!}</td>
                <td>{!! $item->reception_type!!}</td>
                <td>{!! ($item->cell_phone_number) ? explode(',',$item->cell_phone_number)[0] : explode(',',$item->phone_number)[0] !!}</td>
                <td>{!! $item->code !!}</td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
