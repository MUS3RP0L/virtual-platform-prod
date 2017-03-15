@extends('globalprint.print')

@section('formnumber')
Formulario Nº 2
@endsection

@section('content')
<div class="title2"><b>Registro: Nº {!! $economic_complement->code !!}</div>
<div id="project">
  <table>
  <tr>
      <td colspan="5" class="grand service" style="text-align:left;">I. INFORMACIÓN DERECHOHABIENTE</td>
  </tr>
  <tr>
  <td class="grand service" style="text-align:center" ><h4><b>CI.<h4><b></td>
  <td class="grand service" style="text-align:center;"><h4><b>NOMBRES Y APELLIDOS</h4></b></td>
  <td class="grand service" style="text-align:center;width: 16%;"><h4><b>FECHA NACIMIENTO</h4></b></td>
  <td class="grand service" style="text-align:center;"><h4><b>TIPO RENTA</h4></b></td>
  <td class="grand service" style="text-align:center;"><h4><b>Nº CUA/NUA</h4></b></td>

  </tr>
  <tr>
  <th class="info" style="text-align:center;"><h4>{!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->shortened !!} </h4></th>
  <th class="info" style="text-align:center;"><h4>{!! $eco_com_applicant->getTitleNameFull() !!}</h4></th>
  <th class="info" style="text-align:center;width: 16%;"><h4>{!! $eco_com_applicant->getShortBirthDate() !!}</h4></th>
  <th class="info" style="text-align:center;"><h4> {!! $eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->name !!}</h4></th>
  <th class="info" style="text-align:center;"><h4>{!! $affiliate->nua !!}</h4></th>

  </tr>

</table>
<table>
  <tr>
      <td colspan="5" class="grand service" style="text-align:left;">II. INFORMACIÓN CAUSAHABIENTE</td>
  </tr>
  <tr>
  <td class="grand service" style="text-align:center;" ><h4><b>CI.</h4></b></td>
  <td class="grand service" style="text-align:center;"><h4><b>NOMBRES Y APELLIDOS</b></h4></td>
  <td class="grand service" style="text-align:center;width: 16%;"><h4><b>FECHA NACIMIENTO</h4></b></td>
  <td class="grand service" style="text-align:center;"><h4><b>TIPO RENTA</h4></b></td>
  <td class="grand service" style="text-align:center;"><h4><b>Nº CUA/NUA</h4></b></td>

  </tr>
  <tr>
  <th class="info" style="text-align:center;"><h4>{!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card ? $affiliate->city_identity_card->shortened : '' !!} </h4></th>
  <th class="info" style="text-align:center;"><h4>{!! $affiliate->getTittleNamePrint() !!}</h4></th>
  <th class="info" style="text-align:center;width: 16%;"><h4>{!! $affiliate->getShortBirthDate() !!}</h4></th>
  <th class="info" style="text-align:center;"><h4>{!! $economic_complement->economic_complement_modality->economic_complement_type->name !!}</h4></th>
  <th class="info" style="text-align:center;"><h4>{!! $affiliate->nua !!}</h4></th>

  </tr>

</table>
  <p align="justify">Yo, <b>{!! $eco_com_applicant->getTitleNameFull() !!}</b> boliviano (a) de nacimiento con Cédula de Identidad <b>N° {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->shortened !!} </b> .
    con estado civil <b>{!! $eco_com_applicant->getCivilStatus() !!}</b> y con residencia actualmente en el Departamento de <b>{!! $economic_complement->city->name !!}</b>.; mayor de edad,
    y hábil por derecho; consiente de la responsabilidad que asumo ante la Mutual de Servicios al Policía – MUSERPOL,
    de manera voluntaria y sin que medie ningún tipo de presión, mediante la presente, <b>DECLARO LO SIGUIENTE:</b>
  </p>
  <table>
    <tr>
      <td>1</td>
      <td style="text-align:justify;font-size:0.9em;">No me encuentro realizando una actividad laboral pública o privada incurriendo en <b>Doble Percepción</b>.</td>
    </tr>
    <tr>
      <td>2</td>
      <td style="text-align:justify;font-size:0.9em;">No percibo una renta y/o pensión de jubilación por Riesgo Común y/o Profesional e Invalidez Común y/o Profesional o Muerte, por lo cual, la renta o pensión en curso de pago que percibo por parte de las Administradoras del Fondo de Pensiones (AFP’S), Aseguradoras o en su caso del SENASIR es una <b>PRESTACIÓN POR VIUDEDAD DERIVADA DE VEJEZ DEL CAUSAHABIENTE</b>, en aplicación del Artículo N° 17, Parágrafo I del Decreto Supremo N° 1446 de fecha 19 de diciembre de 2012.</td>
    </tr>
    <tr>
      <td>3</td>
      <td style="text-align:justify;font-size:0.9em;">Mi causahabiente perteneció al sector pasivo de la Policía Boliviana y acredita en la Certificación de Años de Servicio emitido por el Comando General de la Policía Boliviana como mínimo de 16 años de servicio, asimismo, <b>No</b> fue dado de baja en forma obligatoria o voluntaria de la Policía Boliviana.</td>
    </tr>
    <tr>
      <td>4</td>
      <td style="text-align:justify;font-size:0.9em;">La información y documentación proporcionada por mi persona, tanto verbal como la contenida en documentos respecto a los requisitos mínimos para acceder al Beneficio del Complemento Económico, es totalmente <b>real y fidedigna</b>, por lo que me hago totalmente responsable de la misma.</td>
    </tr>
    <tr>
      <td>5</td>
      <td style="text-align:justify;font-size:0.9em;">Mi causahabiente y mi persona no se encuentra en calidad de denunciado, imputado, acusado o sentenciado con proceso judicial seguido por la MUSEPOL y/o MUSERPOL en mi contra. Asimismo, no tengo sentencia condenatoria ejecutoriada por delitos cometidos contra la Policía Boliviana y/o MUSEPOL y/o MUSERPOL.</td>
    </tr>
    <tr>
      <td>6</td>
      <td style="text-align:justify;font-size:0.9em;">No he contraído nuevo matrimonio; estado que puede ser verificado según Certificación original de verificación de partidas matrimoniales emitida por el Servicio de Registro Civil – SERECI.</td>
    </tr>
    <tr>
      <td>7</td>
      <td style="text-align:justify;font-size:0.9em;">Estoy consciente de que existe la probabilidad de ser excluido (a) por salario, por percibir una prestación por vejez <b>IGUAL O SUPERIOR</b> al haber básico más categoría que perciban los miembros del servicio activo de la Policía Boliviana en el grado correspondiente, tal como lo señala en el Decreto Supremo N° 1446, Artículo 17, Parágrafo I y el Reglamento del Beneficio del Complemento Económico.</td>
    </tr>

    <tr>
      <td>8</td>
      <td style="text-align:justify;font-size:0.9em;">Estoy de acuerdo en proceder con la devolución de montos percibidos indebidamente en caso de producirse alguna inconsistencia a causa del contenido de la documentación presentada, información proporcionada por entidades externas, error del sistema u otros que se presenten.
      </td>
    </tr>
    <tr>
      <td>9</td>
      <td style="text-align:justify;font-size:0.9em;">De presentarse una tercera persona que acredite igual o mayor derecho para acceder al Beneficio del Complemento Económico por mi causahabiente, estoy de acuerdo en que la Mutual de Servicios al Policía no se hace responsable por la suspensión del mencionado Beneficio y estoy de acuerdo a realizar devolución de montos cobrados.</td>
    </tr>
  </table>
<p align="justify">En mérito de los datos registrados en forma precedente, el interesado aprueba y ratifica su tenor de manera íntegra, quien en señal de conformidad en forma expresa y voluntaria firma el presente documento en la ciudad de La Paz, {!! Util::getfulldate($economic_complement->reception_date)!!}.</p>

<table>
          <tr>
              <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
              <th class="info" style="border-bottom: 1px solid  #5D6975!IMPORTANT;text-align:center;width: 22%;"><p>&nbsp;</p><br></th>
              <th class="info" style="border: 0px;text-align:center;width: 10%;"></th>

          </tr>
          <tr>
            <th class="info" style="border: 0px;text-align:center;">{!! $eco_com_applicant->getTitleNameFull() !!} <br>C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->shortened !!} Telefono. {!! $eco_com_applicant->getPhone() !!}</th>
            <th class="info" style="border: 0px;text-align:center;">Huella Digital Pulgar Derecho</th>
            <th class="info" style="border: 0px;text-align:center;width: 10%;"></th>
          </tr>



</table>
<p align="justify"><b>Nota.- El presente documento tiene carácter de DECLARACIÓN JURADA, por lo que en caso de evidenciarse la falsedad de este, se procederá con las acciones legales pertinentes. </b></p>
</div>
@endsection
