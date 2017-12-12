@extends('globalprint.wkhtml')
@section('subtitle')
@endsection
@section('content')
<style type="text/css">
    .number{
      text-align: right;
    }
    thead{display: table-header-group;}
    tfoot {display: table-row-group;}
    tr {page-break-inside: avoid; }

</style>
<div class="title2"><strong class="code">REGIONAL: {!! $city !!} </strong><strong class="code">Nº: {!! $devolution->id !!}/2017 </strong></div>

   <div id="project">
    <table class="table" style="width:100%;">
      <tr>
        <td colspan="6" class="grand info_title">
          RECONOCIMIENTO DE OBLIGACIÓN
        </td>
      </tr>
      <tr><td class="text-justify">
        Yo <strong>{{ $eco_com_applicant->getFullName() }}</strong>, mayor de edad con Cédula de Identidad Nº {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened  ? $eco_com_applicant->city_identity_card->first_shortened.'.' : ''!!}, domiciliado en la Zona {!! $address->zone ?? '-' !!}, Calle {{ $address->street ?? '-' }}, Nro. {{ $address->number_address ?? '-' }}, de la ciudad de {{ $address->city->name ?? '' }}, hábil por derecho y en mi calidad de beneficiario (a) del Complemento Económico que otorga la Mutual de Servicios al Policía – MUSERPOL al sector pasivo de la Policía Boliviana, que habiendo sido notificado por haber percibido pagos en defecto del Complemento Económico correspondiente al 1er. y 2do. Semestre de las gestiones 2015 y 2016 por un importe de Bs. {{ Util::formatMoney($devolution->total) }}  ({{ $total_dues_literal }} BOLIVIANOS),
        <strong>
          
          @if($devolution->percentage)
          expreso mi conformidad para que se efectúe el descuento con el {{ $devolution->percentage * 100 }}% del beneficio del Complemento Económico a partir del Primer Semestre de la gestión 2017, hasta cubrir el monto determinado.
          @else
            @if($devolution->deposit_number && $devolution->payment_date)
              expreso mi conformidad de manera voluntaria para efectuar la devolución del total del monto en defecto inicialmente determinado.
            @else
              expreso mi conformidad para que se efectúe el descuento del total del monto en defecto inicialmente determinado, con el beneficio del Complemento Económico del Primer semestre de la gestión 2017.
            @endif
          @endif
        </strong>
      </td></tr>
      </table>
      @include('economic_complements.info.applicant_info',['eco_com_applicant'=>$eco_com_applicant])
      @include('economic_complements.info.simple_info',['economic_complement'=>$economic_complement])
      @include('affiliates.print.devolutions.amount', ['dues'=>$devolution->dues,'devolution'=>$devolution,'total_dues_literal'=>$total_dues_literal])

      @if($devolution->deposit_number && $devolution->payment_date)
        @include('affiliates.print.devolutions.devolution_inmediate')
        @include('affiliates.print.devolutions.payment_info')
      @endif
       @if($devolution->percentage ||!$devolution->payment_date)
        <p class="size-8">
          <strong>En caso de incumplimiento al presente compromiso este podrá ser elevado a Instrumento Público de acuerdo a las normas que rigen nuestro ESTADO, en señal de plena conformidad firmo al pie del presente documento.</strong>
        </p>
       @endif
      <table>
        <tr>
          <th style="width:33%" class="no-border"></th>
          <th class="info" style="border: 0px;text-align:center; width:60%"><p>&nbsp;</p><br>----------------------------------------------------
            <strong>
              <br>
              {!! $eco_com_applicant->getFullName() !!}
              <br>
              C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened ?? ''!!}
            </strong>
          </th>
          <th class="no-border"> <div class="info" style="border: 1px solid  #3c3c3c!IMPORTANT;text-align:center;width: 150px;"><p>&nbsp;</p><br><br><br><br></div><br><span class="info" style="border: 0px;text-align:center;">Impresión Digital Pulgar Derecho</span></th>
        </tr>
      </table>
      <p class="size-10">Cabe aclarar que esta cuantificación no corresponde a gestiones anteriores al 2015.</p>
  </div>
@endsection