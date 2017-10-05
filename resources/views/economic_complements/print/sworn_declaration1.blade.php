@extends('globalprint.wkhtml')

@section('content')
<style>
  body{
    font-weight: 100;
    font-size: 12px;
  }
</style>

<div class="title2"><strong class="code">Trámite Nº: {!! $economic_complement->code !!} </strong></div>
<div id="project">
  <table class="table" style="width:100%;">
    <tr>
      <td colspan="6" class="grand info_title">
        INFORMACIÓN DEL BENECIFIARIO
        @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
        - DERECHOHABIENTE
        @endif
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
        {{ explode(',',$eco_com_applicant->phone_number)[0] }}
      </td>
      <td><strong>CELULAR:</strong></td>
      <td>
        {{ explode(',',$eco_com_applicant->cell_phone_number)[0] }}
      </td>
      <td><strong>Lugar de Nac.</strong></td>
      <td>{!! $eco_com_applicant->city_birth->second_shortened ?? '' !!}</td>
    </tr>
  </table>
  <p align="justify"> Yo, <strong>{!! $eco_com_applicant->getTitleNameFull() !!}</strong> boliviano (a) de nacimiento con Cédula de Identidad <strong>N° {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened !!}</strong> .
    con estado civil <strong>{!! $eco_com_applicant->getCivilStatus() !!}</strong> y con residencia actualmente en el Departamento de <strong>{!! $economic_complement->city ? $economic_complement->city->name : '' !!}</strong>.; mayor de edad,
    y hábil por derecho; consiente de la responsabilidad que asumo ante la Mutual de Servicios al Policía – MUSERPOL,
    de manera voluntaria y sin que medie ningún tipo de presión, mediante la presente, <strong>DECLARO LO SIGUIENTE:</strong>
  </p>
  <table>
    <tr>
      <td>1</td>
      <td style="text-align:justify">No percibo una renta y/o pensión de jubilación por Riesgo Común y/o Profesional e Invalidez Común y/o Profesional o Muerte, por lo cual, la renta o pensión en curso de pago que percibo por parte de las Administradoras del Fondo de Pensiones (AFP’S), Aseguradoras o en su caso del SENASIR es una <strong>PRESTACIÓN POR VEJEZ</strong>, en aplicación del Artículo N° 17, Parágrafo I del Decreto Supremo N° 1446 de fecha 19 de diciembre de 2012.</td>
    </tr>
    <tr>
      <td>2</td>
      <td style="text-align:justify">Pertenezco al sector pasivo de la Policía Boliviana y acredito en la Certificación de Años de Servicio emitido por el Comando General de la Policía Boliviana como mínimo de 16 años de servicio, asimismo, <strong>No</strong> fui dado de baja en forma obligatoria o voluntaria de la Policía Boliviana.</td>
    </tr>
    <tr>
      <td>3</td>
      <td style="text-align:justify">La información y documentación proporcionada por mi persona, tanto verbal como la contenida en documentos respecto a los requisitos mínimos para acceder al Beneficio del Complemento Económico, es totalmente <strong>real y fidedigna</strong>, por lo que me hago totalmente responsable de la misma.
      </td>
    </tr>
    <tr>
      <td>4</td>
      <td style="text-align:justify">No me encuentro en calidad de denunciado, imputado, acusado o sentenciado con proceso judicial seguido por la MUSEPOL y/o MUSERPOL en mi contra. Asimismo, no tengo sentencia condenatoria ejecutoriada por delitos cometidos contra la Policía Boliviana y/o MUSEPOL y/o MUSERPOL.</td>
    </tr>
    <tr>
      <td>5</td>
      <td style="text-align:justify">Estoy consciente de que existe la probabilidad de ser excluido (a) por salario, por percibir una prestación por vejez <strong>IGUAL O SUPERIOR</strong> al haber básico más categoría que perciban los miembros del servicio activo de la Policía Boliviana en el grado correspondiente, tal como lo señala en el Decreto Supremo N° 1446, Artículo 17, Parágrafo I y el Reglamento del Beneficio del Complemento Económico.</td>
    </tr>
    <tr>
      <td>7</td>
      <td style="text-align:justify">Estoy de acuerdo en proceder con la devolución de montos cobrados indebidamente en caso de producirse alguna inconsistencia a causa del contenido de la documentación presentada, información proporcionada por entidades externas, error del sistema u otros que se presenten.</td>
    </tr>
  </table>
<p align="justify">En mérito de los datos registrados en forma precedente, el interesado aprueba y ratifica su tenor de manera íntegra, quien en señal de conformidad en forma expresa y voluntaria firma el presente documento en la ciudad de La Paz, {!! $date !!}.</p>
<br>
<table>
          <tr>
              <th class="info" style="border: 0px;text-align:center; width:60%"><p>&nbsp;</p><br>----------------------------------------------------
                <br>
                {!! $eco_com_applicant->getTitleNameFull() !!}<br>C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened ?? ''!!}</span>
              </th>
              <th class="info" style="border: 1px solid  #3c3c3c!IMPORTANT;text-align:center;width: 30%;"><p>&nbsp;</p><br><br><br><br></th>
          </tr>
          <tr>
            <th class="info" style="border: 0px;text-align:center;" ><span class="size-11">
              </th>
             
            <th class="info" style="border: 0px;text-align:center;">Huella Digital Pulgar Derecho</th>
            <th class="info" style="border: 0px;text-align:center;width: 10%;"></th>
          </tr>
</table>
<p align="justify"><strong class="size-10">Nota.- El presente documento tiene carácter de DECLARACIÓN JURADA, por lo que en caso de evidenciarse la falsedad de este, se procederá con las acciones legales pertinentes. </strong></p>
</div>
@endsection
