@extends('globalprint.print')
@section('title2')
    <h3>(Página 1/2)</h3>
@endsection
@section('content')
<div><b>IV. LISTA DE BENEFICIARIOS</b></div>
      <div id="project">
        <table>
           <tr>
              <th class="grand"><h4>N°</h4></th>
              <th class="grand"><h4>CI</h4></th>
              <th class="grand"><h4>NOMBRES Y APELLIDOS</h4></th>
              <th class="grand"><h4>REGION</h4></th>
              <th class="grand"><h4>GRADO</h4></th>
              <th class="grand"><h4>TIPO RENTA</h4></th>
              <th class="grand"><h4>FECHA</h4></th>
              <th class="grand"><h4>TIPO</h4></th>
              <th class="grand"><h4>USUARIO</h4></th>
           </tr>
           <?php $i=1;?>
            @foreach($eco_complements as $item)
            <tr>
              <td ><h4>{!! $i !!}</h4></td>
              <td ><h4>{!! Util::getDateEdit($item->month_year) !!}</h4></td>
              <td ><h4>{!! $item->degree_id ? $item->degree->code_level . "-" . $item->degree->code_degree : '' !!}</h4></td>
              <td ><h4>{!! $item->unit_id ? $item->unit->code : '' !!}</h4></td>
              <td ><h4>{!! $item->item !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->base_wage) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->seniority_bonus) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->study_bonus) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->position_bonus) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->border_bonus) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->east_bonus) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->public_security_bonus) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->gain) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->quotable) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->retirement_fund) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->mortuary_quota) !!}</h4></td>
              <td ><h4>{!! Util::formatMoney($item->total) !!}</h4></td>
            </tr>
            <?php $i++;?>
            @endforeach
        </table>
    </div>
    <footer>
      PLATAFORMA VIRUTAL - MUTUAL DE SERVICIOS AL POLICIA
    </footer>

@endsection
