@extends('globalprint.wkhtml')

@section('formnumber')
Formulario Nº 3
@endsection

@section('content')

<div class="title2"><strong class="code">DOC - {!! $doc_number !!} </strong><strong class="code">Trámite Nº: {!! $economic_complement->code !!} </strong></div>
   <div id="project">  
<div id="project">
<table class="table" style="width:100%;">
    <tr>
      <td colspan="6" class="grand info_title">
        INFORMACIÓN DEL BENECIFIARIO
      </td>
    </tr>
    <tr >
      <td colspan="1"><strong>NOMBRE:</strong></td><td colspan="5" nowrap>{!! $eco_com_applicant->getFullName() !!}</td>
    </tr>
    <tr>
      <td><strong>C.I.:</strong></td><td nowrap>{!! $eco_com_applicant->identity_card !!} {{$eco_com_applicant->city_identity_card->first_shortened ?? ''}}</td>
      <td><strong>FECHA NAC:</strong></td><td> {!! $eco_com_applicant->getShortBirthDate() !!}</td>
      <td><strong>EDAD:</strong></td><td>{!! $eco_com_applicant->getHowOld() !!}</td>
    </tr>
    <tr>
      <td><strong>TELÉFONO:</strong></td>
      <td>
        {!! explode(',',$eco_com_applicant->phone_number)[0] !!}<br/>
      </td>
      <td><strong>CELULAR:</strong></td>
      <td>
        {!! explode(',',$eco_com_applicant->cell_phone_number)[0] !!}<br/>
      </td>
      <td><strong>Lugar de Nac.</strong></td>
      <td>{!! $eco_com_applicant->city_birth->second_shortened ?? '' !!}</td>
    </tr>
  </table>

{{--Información del trámite--}}
<table>
  <tr>
    <td colspan="6" class="grand info_title">INFORMACIÓN DEL TRÁMITE</td>
  </tr>
  <tr>
    <td><strong>MODALIDAD: </strong></td><td>{{ $economic_complement->economic_complement_modality->shortened ?? '' }}</td>
    <td><strong>GRADO:</strong></td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td>
    <td><strong>CATEGORÍA:</strong></td><td>{!! $economic_complement->category->getPercentage() !!}</td>
  </tr>
  <tr>
    <td><strong>REGIONAL:</strong></td><td>{!! $economic_complement->city->name !!}</td>    
    <td><strong>GESTIÓN:</strong></td><td> {!! $economic_complement->getYear() !!}</td>
    <td><strong>SEMESTRE:</strong></td><td>{!! $economic_complement->getSemester() !!}</td>
  </tr>
  <tr>
    <td><strong>ENTE GESTOR:</strong></td><td>{!! $affiliate->pension_entity->name ?? '' !!}</td>
    <td><strong>TIPO DE TRÁMITE: </strong></td><td>{!! $economic_complement->reception_type !!}</td>    
    <td><strong>FECHA DE RECEPCIÓN:</strong></td><td>{!! $economic_complement->getReceptionDate() !!}</td>
  </tr>
</table>
<div id="project">
 <strong>Señor (a) </strong><br />
 <strong>DIRECTOR (A) GENERAL EJECUTIVO</strong><br />
 <strong>MUTUAL DE SERVICIOS AL POLICIA</strong><br />
 Presente.-<br />
 <p align="justify"><strong>REF: {!! $applicant_type !!} SOLICITA NUEVA INCLUSIÓN {!! strtoupper($economic_complement->semester) !!} SEMESTRE COMPLEMENTO ECONÓMICO DE LA GESTIÓN {!! Util::getYear($economic_complement->reception_date) !!}</strong></p>

 <p>Distinguido (a) Director (a): </p>
 <p align="justify">La presente tiene por objeto solicitar a su autoridad instruir por la unidad correspondiente <strong>LA INCLUSIÓN COMO NUEVO BENEFICIARIO PARA EL PAGO DEL BENEFICIO DEL COMPLEMENTO ECONÓMICO DEL {!! strtoupper($economic_complement->semester) !!} SEMESTRE DE LA GESTIÓN {!! Util::getYear($economic_complement->reception_date) !!}.</strong> </p>
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
    <br><br><br>
    <table>
      <tr>
          <th class="info" style="border: 0px;text-align:center;"><br>
            ----------------------------------------------------------------------<br>
            <strong>{!! $eco_com_applicant->getFullName() ?? '' !!}<br />C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened ?? '' !!} <br /> Telefono. {!! $eco_com_applicant->getPhone() !!}</strong>
          </th>
      </tr>
    </table>

</div>
@endsection
