@extends('retirement_funds.print.layout')

@section('title')

  VENTANILLA DE ATENCIÓN AL AFILIADO

@endsection

@section('title2')

  RECEPCIÓN

@endsection

@section('content')
      <div id="project">
        <table>
            <tr>
                <td style="width: 30%;border: 0px;">
                <div class="title"><b>I. DATOS GENERALES</b></div>
                </td>
            </tr>
            <tr>
              <th class="service">SOLICITANTE</th>
              <td class="info">{!! $applicant->getFullNametoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service">TITULAR</th>
              <td class="info">{!! $affiliate->getFullNametoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service">PARENTESCO DEL TITULAR</th>
              <td class="info">{!! $applicant->getParentesco() !!}</td>
            </tr>
            <tr>
              <th class="service">CARNET DE IDENTIDAD</th>
              <td class="info">{!! $applicant->identity_card !!}</td>
            </tr>
            <tr>
              <th class="service">FECHA DE NACIMIENTO</th>
              <td class="info">{!! $applicant->getFullDateNactoPrint() !!}</td>
            </tr>
            <tr>
              <th class="service">DIRECCIÓN DE DOMICILIO</th>
              <td class="info">{!! $applicant->home_address!!}</td>
            </tr>
            <tr>
              <th class="service">TELEFONO DOMICILIO</th>
              <td class="info">{!! $applicant->home_phone_number !!}</td>
            </tr>
            <tr>
              <th class="service">TELEFONO CELULAR</th>
              <td class="info">{!! $applicant->home_cell_phone_number !!}</td>
            </tr>
            <tr>
              <th class="service">CIUDAD</th>
              <td class="info">{!! $retirement_fund->city->name !!}</td>
            </tr>
          </table>
      </div>
       <br>
       <table class="tablet">
          <tr>
            <td style="width: 60%;border: 0px;">
              <div class="title"><b>II. REQUISITOS PRESENTADOS</b></div>
            </td>
          </tr>
        </table>

        <div id="project">
            <table>
             <tr>
                <th class="grand">N°</th>
                <th class="grand">REQUISITO</th>
                <th class="grand">ESTADO</th>
                <th class="grand">FECHA</th>
              </tr>
              <?php $i=1;?>
               @foreach ($documents as $item)
              <tr>
                <td style="width:1%" class="info">{!! $i !!}</td>
                <td style="width:75%" class="info">{!! $item->requirement->name !!}</td>
                @if ($item->status == 1)
                  <td class="info"><center><img class="circle" src="{!! asset('assets/images/check.png') !!}" style="width:70%" alt="icon"></center></td>
                @else
                  <td class="info"> </td>
                @endif
                <td style="width:20%" class="info"><center>{!! $item->getData_fech_requi() !!}</center></td>
              </tr>
              <?php $i++;?>
              @endforeach
            </table>
        </div>
        <br>
        <div id="notices">
          <div><b>Nota:</b></div>
          <div class="notice">Una vez presentada la documentación no sera devuelta.</div>
        </div>

@endsection
