@extends('globalprint.print')
@section('title2')
    <h3>(Página 1/2)</h3>
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
</style>
      <div id="project">
        <table class="tablee">
           <tr>
               <th class="grand number"><h4>N°</h4></th>
               <th class="grand"><h4>REGION</h4></th>
               <th class="grand"><h4>CI</h4></th>
               <th class="grand"><h4>NOMBRES Y APELLIDOS</h4></th>
               <th class="grand"><h4>GRADO</h4></th>
               <th class="grand"><h4>RENTA</h4></th>
               <th class="grand"><h4>FECHA</h4></th>
               <th class="grand"><h4>AFP</h4></th>
               <th class="grand"><h4>TIPO</h4></th>
               <th class="grand"><h4>TELF/CEL</h4></th>

           </tr>
           <?php $i=1;?>
            @foreach($beneficiary_eco_complements as $item)
            <tr>
                <td class="number"><h4>{!! $i !!}</h4></td>
                <td ><h4>{!! $item->city !!}</h4></td>
                <td ><h4>{!! $item->identity_card !!} {!! $item->exp !!}</h4></td>
                <td ><h4>{!! $item->full_name !!}</h4></td>
                <td ><h4>{!! $item->shortened !!}</h4></td>
                <td ><h4>{!! $item->name !!}</h4></td>
                <td ><h4>{!! Util::getDateEdit($item->reception_date) !!}</h4></td>
                <td ><h4>{!! $item->pension_entity !!}</h4></td>
                <td ><h4>{!! (Util::getType1($item->affiliate_id) > 1) ? 'HABITUAL' : 'INCLUSION' !!}</h4></td>
                <td ><h4>{!! ($item->cell_phone_number) ? $item->cell_phone_number : $item->phone_number !!}</h4></td>

            </tr>
            <?php $i++;?>
            @endforeach
        </table>
    </div>
@endsection
