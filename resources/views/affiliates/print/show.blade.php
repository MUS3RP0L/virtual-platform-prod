@extends('globalprint.print')
@section('title2')
    <h3>(Página 1/2)</h3>
@endsection
@section('content')



<table>
      <tr>
        <th style="width: 60%;border: 0px;text-align:left;">
          <div><b>I. INFORMACIÓN PERSONAL</b></div>
        </th>
        <th style="width: 40%;border: 0px;text-align:left;">
          <div><b>II. INFORMACIÓN INSTITUCIONAL</b></div>
        </th>
      </tr>
</table>

<table>
  <tr>
    <td style="width: 60%;border: 0px;">
      <div id="project">
          <table>
            <tr>
              <th colspan="2" class="grand service"><h4><b>DATOS DEL TITULAR</b></h4></th>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>NOMBRE DEL BENEFICIARIO</b></h5></th>
              <td class="info" style="width: 75%;" ><h5>{!! $affiliate->getFullNametoPrint() !!}</h5></td>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>CARNET DE IDENTIDAD</b></h5></th>
              <td class="info" style="width: 75%;" ><h5>{!! $affiliate->identity_card !!}</h5></td>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>FECHA DE NACIMIENTO</b></h5></th>
              <td class="info" style="width: 75%;"><h5>{!! $affiliate->getFullDateNactoPrint() !!}</h5></td>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>NRO. ÚNICO DE AFILIADO-AFP</b></h5></th>
              <td class="info" style="width: 75%;" ><h5>{!! $affiliate->nua !!}</h5></td>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>ESTADO CIVIL</b></h5></th>
              <td class="info" style="width: 75%;"><h5>{!! $affiliate->getCivilStatus() !!}</h5></td>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>EDAD</b></h5></th>
              <td class="info" style="width: 75%;"><h5>{!! $affiliate->getHowOld() !!}</h5></td>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>DIRECCIÓN DOMICILIO</b></h5></th>
              <td class="info" style="width: 75%;"><h5>{!! $affiliate->getFullDirecctoPrint() !!}</h5></td>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>FECHA DE FALLECIMIENTO</b></h5></th>
              <td class="info" style="width: 75%;"><h5>{!! $affiliate->getFull_fech_decetoPrint() !!}</h5></td>
            </tr>
            <tr>
              <th class="service" style="width: 25%;"><h5><b>CAUSA DE FALLECIMIENTO</b></h5></th>
              <td class="info" style="width: 75%;"><h5>{!! $affiliate->reason_decommissioned !!}</h5></td>
            </tr>
          </table>
        </div>

    </td>

    <td style="width: 40%;border: 0px;">

            <table>
            <tr>
              <td colspan="2" class="grand service"><center><b>DATOS INSTITUCIONALES</b></center></td>
            </tr>
            <tr>
              <td  style="width: 35%;"><h6><b>MATRICULA</b></h6></td>
              <td class="info" style="width: 65%;"><h6>{!! $affiliate->registration !!}</h6></td>
            </tr>
            <tr>
              <td class="service"><b>ESTADO</b></td>
              <td class="info" ><h6>{!! $affiliate->affiliate_state->name !!}</h6></td>
            </tr>
            <tr>
              <td class="service"><b>GRADO</b></td>
              <td class="info" ><h6>{!! $affiliate->degree->name !!}</h6></td>
            </tr>
            <tr>
              <td class="service"><b>UNIDAD</b></td>
              <td class="info" ><h6>{!! $affiliate->unit->shortened !!}</h6></td>
            </tr>
            <tr>
              <td class="service"><b>TIPO</b></td>
              <td class="info" ><h6>{!! $affiliate->affiliate_type->name !!}</h6></td>
            </tr>
            <tr>
              <td class="service"><b>NRO. ITEM</b></td>
              <td class="info" ><h6>{!! $affiliate->item !!}</td>
            </tr>
            <tr>
              <td class="service"><b>FECHA DE ALTA</b></td>
              <td class="info"><h6>{!! $affiliate->getFullDateIngtoPrint() !!}</h6></td>
            </tr>
            <tr>
              <td class="service"><b>FECHA DE BAJA</b></td>
              <td class="info"><h6>{!! $affiliate->getData_fech_bajatoPrint() !!}</h6></td>
            </tr>
            <tr>
              <td class="service"><b>MOTIVO DE BAJA</b></td>
              <td class="info"><h6>{!! $affiliate->reason_decommissioned !!}</h6></td>
            </tr>

          </table>


    </td>
  </tr>
</table>

<div><b>III. RESUMEN DE APORTE</b></div>
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
                    <img src="img/logo.jpg">
                  </div>
                </th>
                <th style="width: 50%;border: 0px">
                  <h4><b>MUTUAL DE SERVICIOS AL POLICIA<br>
                      {!! $header1 !!} <br> {!! $header2 !!}
                    </b></h4>
                </th>
                <th style="width: 25%;border: 0px">
                  <div id="logo2">
                    <img src="img/escudo.jpg">
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

<div><b>IV. LISTA DE APORTES</b></div>
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
