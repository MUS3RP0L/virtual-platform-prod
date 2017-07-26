@extends('globalprint.print')
@section('title2')
    
@endsection
@section('content')
      <div id="project">
        <table>
           <tr>
               <th class="grand"><h4>N°</h4></th>
               <th class="grand"><h4>REGION</h4></th>
               <th class="grand"><h4>CI</h4></th>
               <th class="grand"><h4>NOMBRES Y APELLIDOS</h4></th>
               <th class="grand"><h4>GRADO</h4></th>
               <th class="grand"><h4>RENTA</h4></th>
               <th class="grand"><h4>FECHA</h4></th>
               <th class="grand"><h4>GESTOR</h4></th>
               <th class="grand"><h4>TIPO</h4></th>
                <th class="grand"><h4>PENSION</h4></th>
               <th class="grand"><h4>SAL+CAT</h4></th>
               
           </tr>
           <?php $i=1;?>
            @foreach($excluded_by_salary as $item)
            <tr>
                <td ><h4>{!! $i !!}</h4></td>
                <td ><h4>{!! $item->city !!}</h4></td>
                <td ><h4>{!! $item->identity_card !!} {!! $item->exp !!}</h4></td>
                <td ><h4>{!! $item->full_name !!}</h4></td>
                <td ><h4>{!! $item->degree !!}</h4></td>
                <td ><h4>{!! $item->modality !!}</h4></td>
                <td ><h4>{!! Util::getDateEdit($item->reception_date) !!}</h4></td>
                <td ><h4>{!! $item->pension_entity !!}</h4></td>
                <td ><h4>{!! $item->reception_type !!}</h4></td>
                <td ><h4>{!! $item->total_rent !!}</h4></td>
                <td ><h4>{!! $item->salary_quotable !!}</h4></td>                
                
            </tr>
            <?php $i++;?>
            @endforeach
        </table>
    </div>
@endsection
