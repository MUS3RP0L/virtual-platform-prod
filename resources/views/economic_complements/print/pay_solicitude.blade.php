@extends('globalprint.print')

@section('formnumber')
Formulario Nº 4
@endsection

@section('content')

<div class="title2"><b>Registro: Nº {!! $affiliate->registration !!}/{!! Util::getYear(date('Y-m-d')) !!}</div>
<div id="project">
 <b>Señor (a) </b><br />
 <b>DIRECTOR (A) GENERAL EJECUTIVO</b><br />
 <b>MUTUAL DE SERVICIOS AL POLICIA</b><br />
 Presente.-<br /><br />
 <p><b>REF: SOLICITUD PAGO COMPLEMENTO ECONÓMICO.............. SEMESTRE GESTIÓN.......... COMO BENEFICIARIOHABITUAL..................</b></p><br />

 <p>Distinguido (a) Director (a): </p>
 <p align="justify">La presente tiene por objeto solicitar a su autoridad pueda instruir por la unidad correspondiente hacerme el <b>PAGO DEL BENEFICIO DEL COMPLEMENTO ECONÓMICO DEL...........SEMESTRE DE LA GESTIÓN............. </b>en razón que mi persona fue beneficiario en el semestre anterior.</p>
 <p>Para tal efecto, adjunto folder con los requisitos exigidos de acuerdo al siguiente detalle:</p>

 <table>
           <tr>
              <th class="grand">N°</th>
              <th class="grand">REQUISITO</th>
              <th class="grand">ESTADO</th>

            </tr>

</table>

 <p>Sin otro particular me despido de usted my atentamente. </p> <br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <table>
              <tr>
                  <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>----------------------------------------------------------------------</th>



              </tr>
              <tr>
                <th class="info" style="border: 0px;text-align:center;"><b>{!! $affiliate->getTittleNamePrint() !!}<br />C.I. {!! $affiliate->identity_card !!} <br /> Telefono. {!! $affiliate->phone !!}</b></th>

              </tr>
    </table>

</div>
@endsection
