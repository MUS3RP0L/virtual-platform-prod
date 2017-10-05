@extends('globalprint.wkhtml')

@section('formnumber')
Formulario Nº 3
@endsection

@section('content')

<div class="title2"><strong>Trámite Nº: {!! $economic_complement->code !!}</strong> </div>
<div id="project">
 <strong>Señor (a) </strong><br />
 <strong>DIRECTOR (A) GENERAL EJECUTIVO</strong><br />
 <strong>MUTUAL DE SERVICIOS AL POLICIA</strong><br />
 Presente.-<br />
 <p align="justify"><strong>REF: {!! $applicant_type !!} SOLICITA NUEVA INCLUSIÓN {!! strtoupper($economic_complement->semester) !!} SEMESTRE COMPLEMENTO ECONÓMICO DE LA GESTIÓN {!! Util::getYear($economic_complement->reception_date) !!}</strong></p>

 <p>Distinguido (a) Director (a): </p>
 <p align="justify">La presente tiene por objeto solicitar a su autoridad instruir por la unidad correspondiente <strong>LA INCLUSIÓN COMO NUEVO BENEFICIARIO PARA EL PAGO DEL BENEFICIO DEL COMPLEMENTO ECONÓMICO DEL {!! strtoupper($economic_complement->semester) !!} SEMESTRE DE LA GESTIÓN {!! Util::getYear($economic_complement->reception_date) !!}.</strong> </p><br />
 <p>Para tal efecto, adjunto folder con los requisitos exigidos de acuerdo al siguiente detalle: </p>

 <table>
           <tr>
              <th class="grand">N°</th>
              <th class="grand">REQUISITO</th>
              <th class="grand">ESTADO</th>

            </tr>
            <?php $i=1;?>
            @foreach($eco_com_submitted_document as $i=>$item)
            <tr>
                <td><center>{!! $i+1 !!}</center></td>
                <td>{!! $item->economic_complement_requirement->name !!}</td>
                @if ($item->status == 1)
                    <td class="info" style='text-align:center;'>
                      <img class="circle" src="{{ asset('img/check.png') }}" >
                    </td>
                @else
                  <td class="info" style='text-align:center;'>
                    <img class="circle" src="{{ asset('img/uncheck.png') }}" >
                  
                  </td>
                @endif
            </tr>
            @endforeach
    </table>
    <p>Sin otro particular me despido de usted muy atentamente. </p>
    <table>
      <tr>
          <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p>----------------------------------------------------------------------</th>
      </tr>
      <tr>
        <th class="info" style="border: 0px;text-align:center;">
        <strong>{!! $eco_com_applicant->getTitleNameFull() !!}
        <br />C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened !!} <br /> Telefono. {!! $eco_com_applicant->getPhone() !!}</strong></th>
      </tr>
    </table>

</div>
@endsection
