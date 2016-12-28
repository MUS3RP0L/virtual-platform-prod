@extends('retirement_funds.print.layout')

@section('title')
  LEGAL FONDO DE RETIRO POLICIAL INDIVIDUAL
@endsection

@section('title2')
  DICTAMEN LEGAL AFILIACIÓN
@endsection

@section('content')

      <table class="tablet">
        <tr>
          <td style="width: 60%;border: 0px;">
            <div class="title"><b>REF: </b>FONDO DE RETIRO POLICIAL INDIVIDUAL</div>
          </td>
          <td style="width: 40%;border: 0px;text-align:right;">
            <div class="title"><b>MODALIDAD: </b>{!! $retirement_fund->retirement_fund_modality->name !!}</div>
          </td>
        </tr>
      </table>
      <br>

      <p align="justify"> En fecha {!! $date !!} mediante nota el Sr. {!! $applicant->getFullNametoPrint() !!}
        con CI. {!! $applicant->identity_card !!} en calidad de BENEFICIARIO solicita la declaración de Fondo
        de Retiro policial <b>{!! $retirement_fund->retirement_fund_modality->name !!}</b>, adjunto la documentación pertinente
        cumpliendo con los requisitos exigidos:
      </p>

      <div id="project">
          <table>
            <tr>
              <td style="width: 5%";class="info"><b>N°</b></td>
              <td class="info"><center><b>DOCUMENTACIÓN PRESENTADA</b><center></td>
            </tr>
            <?php $i=1; ?>
             @foreach ($documents as $item)
            <tr>
              <td style="width: 5%";class="info">{!! $i !!}</td>
              <td class="info">{!! $item->requirement->name !!}</td>

            </tr>
            <?php $i++; ?>
            @endforeach


          </table>
      </div><br>
      <p align="justify">
        Que, de acuerdo a la hoja de liquidacion <b>Nª {!! $retirement_fund->id !!}</b> y liquidacion FRP-556 de la fecha 8 de abril de 2015,
        correspondiente a abril de 1987 hasta marzo de 2013 años, realizado por el Calificador de la Direccion de
        Beneficios Economicos, por el periodo de 26 años y o meses, que en fecha 18 de abril de 2015, la Unidad
        de Recuperacion y Cobranza emite Certificacion de Prestamos con Garantia de Haberes, en el mismo certifica
        que no tiene deuda con la institucion.
      </p>

      <P>Reconociendoce el monto de TOTAL de Bs., a favor del beneficiario.</P>
      <p><b>Observación:</b> {!! $retirement_fund->comment !!}</p><br>

      <p align="justify">
        Por lo que, Acesoria Legal de la Direccion de Beneficios Económicos DICTAMINA, de acuerdo a los Arts. 3,
        5, 6, 19, 20, 21, 25, 30, y disposicion primera del Reglamento Fondo de Retiro Policial Individual de la
        Mutual de Servicios al Polcia " MUSERPOL", Resolucion del Directorio Nª 01/ 2014 de la fecha 12 de marzo
        de 2014, se reconosca los derechos y se otorgue el veneficio del Fondo de Retiro Policila Individual por
        Jubilacion a favor de :
      </p>

      <p>
        <b>Sr. {!! $affiliate->getFullNametoPrint() !!}</b> con <b>CI. {!! $affiliate->identity_card !!}</b> en calidad de titular.
      </p>

@endsection
