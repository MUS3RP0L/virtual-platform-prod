@extends('print')
@section('title2')
    <h3>(Página 1/2)</h3>
@endsection
@section('content')
<table>
  <tr>
    <td>
      <div class="title"><b>I. INFORMACIÓN DE PERSONAL</b></div>
      <div id="project">
          <table>
            <tr>
              <th colspan="2" class="grand service">DATOS DE TITULAR</th>
            </tr>
            <tr>
              <td class="service">NOMBRE DEL BENEFICIARIO</th>
              <td class="info" >{!! $affiliate->getFullNametoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service">CARNET DE IDENTIDAD</th>
              <td class="info" >{!! $affiliate->identity_card !!}</td>
            </tr>
            <tr>
              <th class="service">FECHA DE NACIMIENTO</th>
              <td class="info" >{!! $affiliate->getFullDateNactoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service">NÚMERO ÚNICO DE AFILIADO-AFP</th>
              <td class="info" >{!! $affiliate->nua !!}</td>
            </tr>
            <tr>
              <th class="service">ESTADO CIVIL</th>
              <td class="info" >{!! $affiliate->getCivilStatus() !!}</td>
            </tr>
            <tr>
              <th class="service">EDAD</th>
              <td class="info" >{!! $affiliate->getHowOld() !!}</td>
            </tr>
            <tr>
              <th class="service">DIRECCIÓN DOMICILIO</th>
              <td class="info" >{!! $affiliate->getFullDirecctoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service" >FECHA DE FALLECIMIENTO</th>
              <td class="info">{!! $affiliate->getFull_fech_decetoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service" >CAUSA DE FALLECIMIENTO</th>
              <td class="info">{!! $affiliate->reason_decommissioned !!}</td>
            </tr>
          </table>
      </div>
    </td>

    <td>
      <div class="title"><b>II. INFORMACIÓN INSTITUCIONAL</b></div>
      <div id="project">
        <table>
            <tr>
              <th colspan="2" class="grand service">DATOS INSTITUCIONALES</th>
            </tr>
            <tr>
              <th class="service">MATRICULA</th>
              <td class="info" >{!! $affiliate->registration !!}</td>
            </tr>
            <tr>
              <th class="service">ESTADO</th>
              <td class="info" >{!! $affiliate->affiliate_state->name !!}</td>
            </tr>
            <tr>
              <th class="service">GRADO</th>
              <td class="info" >{!! $affiliate->degree->name !!}</td>
            </tr>
            <tr>
              <th class="service">UNIDAD</th>
              <td class="info" >{!! $affiliate->unit->shortened !!}</td>
            </tr>
            <tr>
              <th class="service">TIPO</th>
              <td class="info" >{!! $affiliate->affiliate_type->name !!}</td>
            </tr>
            <tr>
              <th class="service">NRO. ITEM</th>
              <td class="info" >{!! $affiliate->item !!}</td>
            </tr>
            <tr>
              <th class="service">FECHA DE ALTA</th>
              <td class="info">{!! $affiliate->getFullDateIngtoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service">FECHA DE BAJA</th>
              <td class="info">{!! $affiliate->getData_fech_bajatoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service">MOTIVO DE BAJA</th>
              <td class="info">{!! $affiliate->reason_decommissioned !!}</td>
            </tr>

          </table>
      </div>
    </td>
  </tr>
</table>

<div class="title"><b>III. RESUMEN DE APORTE</b></div>
    <div id="project">
        <table>
            <tr>
          <td colspan="6" class="grand service" style="text-align:center;">DATOS DE APORTES</td>
        </tr>
        <tr>
        <td class="grand service" style="text-align:center;" >GANADO</td>
        <td class="grand service" style="text-align:center;">BONO DE SEGURIDAD CIUDADANA</td>
        <td class="grand service" style="text-align:center;">COTIZABLE</td>
        <td class="grand service" style="text-align:center;">APORTE FONDO DE RETIRO</td>
        <td class="grand service" style="text-align:center;">APORTE SEGURO DE VIDA</td>
        <td class="grand service" style="text-align:center;">APORTE MUSERPOL</td>
        </tr>
        <tr>
        <th class="info" style="text-align:center;" >{!! $total_gain !!}</th>
        <th class="info" style="text-align:center;">{!! $total_public_security_bonus !!}</th>
        <th class="info" style="text-align:center;">{!! $total_quotable !!}</th>
        <th class="info" style="text-align:center;">{!! $total_retirement_fund !!}</th>
        <th class="info" style="text-align:center;">{!! $total_mortuary_quota !!}</th>
        <th class="info" style="text-align:center;">{{ $total }}</th>
        </tr>

    </table>

</div>
<footer>
  PLATAFORMA VIRUTAL - MUTUAL DE SERVICIOS AL POLICIA
</footer>
<div class="page-break"></div>
      <header class="clearfix">
        <table class="tableh">
              <tr>
                <th style="width: 25%;border: 0px;">
                  <div id="logo">
                    <img src="assets/images/logo.jpg">
                  </div>
                </th>
                <th style="width: 50%;border: 0px">
                  <h3><b>MUTUAL DE SERVICIOS AL POLICIA<br>
                      {!! $header1 !!} <br> {!! $header2 !!}
                      </b></h3>
                </th>
                <th style="width: 25%;border: 0px">
                  <div id="logo2">
                    <img src="assets/images/escudo.jpg">
                  </div>
                </th>
              </tr>
        </table>

        <h1>
          <b>
            {{ $title }}<br>
            <h3>(Página 2/2)</h3>
          </b>
        </h1>
        <br>
</header>

<div class="title"><b>IV. LISTA DE APORTES</b></div>
      <div id="project">
        <table>
           <tr>
              <th class="grand"><h4>N°</h4></th>
              <th class="grand"><h4>GESTIÓN</h4></th>
              <th class="grand"><h4>GRADO</h4></th>
              <th class="grand"><h4>UNIDAD</h4></th>
              <th class="grand"><h4>ITEM</h4></th>
              <th class="grand"><h4>SUELDO</h4></th>
              <th class="grand"><h4>BANTIG</h4></th>
              <th class="grand"><h4>BESTUDIO</h4></th>
              <th class="grand"><h4>BCARGO</h4></th>
              <th class="grand"><h4>BFRONTERA</h4></th>
              <th class="grand"><h4>BORIENTE</h4></th>
              <th class="grand"><h4>BSEG</h4></th>
              <th class="grand"><h4>GANADO</h4></th>
              <th class="grand"><h4>COTIZABLE</h4></th>
              <th class="grand"><h4>F.R.</h4></th>
              <th class="grand"><h4>S.V.</h4></th>
              <th class="grand"><h4>APORTE</h4></th>

           </tr>
           <?php $i=1;?>
            @foreach($contributions as $item)
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
@endsection
