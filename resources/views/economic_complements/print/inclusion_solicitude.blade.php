@extends('globalprint.print')

@section('formnumber')
Formulario Nº 3
@endsection

@section('content')

<div class="title2"><b>Registro: Nº {!! $economic_complement->code !!} </div>
<div id="project">
 <b>Señor (a) </b><br />
 <b>DIRECTOR (A) GENERAL EJECUTIVO</b><br />
 <b>MUTUAL DE SERVICIOS AL POLICIA</b><br />
 Presente.-<br /><br />
 <p align="justify"><b>REF: {!! $applicant_gender !!} SOLICITA NUEVA INCLUSIÓN {!! strtoupper($economic_complement->semester) !!} SEMESTRE COMPLEMENTO ECONÓMICO DE LA GESTIÓN {!! Util::getYear($economic_complement->reception_date) !!}</b></p><br />

 <p>Distinguido (a) Director (a): </p>
 <p align="justify">La presente tiene por objeto solicitar a su autoridad instruir por la unidad correspondiente <b>LA INCLUSIÓN COMO NUEVO BENEFICIARIO PARA EL PAGO DEL BENEFICIO DEL COMPLEMENTO ECONÓMICO DEL {!! strtoupper($economic_complement->semester) !!} SEMESTRE DE LA GESTIÓN {!! Util::getYear($economic_complement->reception_date) !!}.</b> </p><br />
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
                <td>{!! $item->economic_complement_requirement->shortened !!}</td>
                @if ($item->status == 1)
                    <td class="info" style='text-align:center;'>
                      <img class="circle" src="img/check.png" style="width:70%" alt="icon">
                    </td>
                @else
                  <td class="info" style='text-align:center;'>
                    <img class="circle" src="img/uncheck.png" style="width:60%" alt="icon">
                  
                  </td>
                @endif
            </tr>
            @endforeach
    </table>
    <p>Sin otro particular me despido de usted muy atentamente. </p>

    <br><br><br><br>
    <table>
              <tr>
                  <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>----------------------------------------------------------------------</th>
              </tr>
              <tr>
                <th class="info" style="border: 0px;text-align:center;"><b>{!! $eco_com_applicant->getTitleNameFull() !!}<br />C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->shortened !!} <br /> Telefono. {!! $eco_com_applicant->getPhone() !!}</b></th>

              </tr>
    </table>

</div>
@endsection
