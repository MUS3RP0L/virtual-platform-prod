@extends('globalprint.print')

@section('formnumber')
Formulario Nº 1
@endsection

@section('content')

<div class="title2"><b>Registro: Nº {!! $affiliate->registration !!}/{!! Util::getYear(date('Y-m-d')) !!}</div>
<div id="project">
  <table>
              <tr>
                <th colspan="2" class="grand service"><b>DATOS DEL TITULAR<b></th>
              </tr>

              <tr>
                <th class="grand service"><h5><b>NOMBRE Y APELLIDOS</h5></b></th>
                <td><h4>{!! $affiliate->degree->shortened !!} {!! $affiliate->name !!}</h4></td>
              </tr>
              <tr>
                <th class="grand service"><h5><b>CARNET DE IDENTIDAD</b></h5></th>
                <td><h4>{!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card !!}</h4></td>
              </tr>

              <tr>
                <th class="grand service"><h5><b>FECHA DE NACIMIENTO</h5></b></th>
                <td ><h4>{!! $affiliate->getFullDateNactoPrint() !!}</h4></td>
              </tr>
              <tr>
                <th class="grand service"><h5><b>TIPO DE RENTA</h5></b></th>
                <td ><h4> VIUDEDAD</h4></td>
              </tr>
              <tr>
                <th class="grand service"><h5><b>Nº. CUA/NUA</h5></b></th>
                <td ><h4>{!! $affiliate->nua !!}</h4></td>
              </tr>

  </table>
  <p align="justify"> Yo, <b>{!! $affiliate->name !!}</b> boliviano (a) de nacimiento con Cédula de Identidad <b>N° {!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card !!}</b> .
    con estado civil <b>{!! $affiliate->civil_status !!}</b> y con residencia actualmente en el Departamento de <b>{!! $affiliate->city_birth !!}</b>.; mayor de edad,
    y hábil por derecho; consiente de la responsabilidad que asumo ante la Mutual de Servicios al Policía – MUSERPOL,
    de manera voluntaria y sin que medie ningún tipo de presión, mediante la presente, <b>DECLARO LO SIGUIENTE:</b>
  </p>
  <table>
    <tr>
      <td>1</td>
      <td style="text-align:justify">No me encuentro realizando una actividad laboral pública o privada incurriendo en <b>Doble Percepción</b>.</td>
    </tr>
    <tr>
      <td>2</td>
      <td style="text-align:justify">No percibo una renta y/o pensión de jubilación por Riesgo Común y/o Profesional e Invalidez Común y/o Profesional o Muerte, por lo cual, la renta o pensión en curso de pago que percibo por parte de las Administradoras del Fondo de Pensiones (AFP’S), Aseguradoras o en su caso del SENASIR es una <b>PRESTACIÓN POR VEJEZ</b>, en aplicación del Artículo N° 17, Parágrafo I del Decreto Supremo N° 1446 de fecha 19 de diciembre de 2012.</td>
    </tr>
    <tr>
      <td>3</td>
      <td style="text-align:justify">Pertenezco al sector pasivo de la Policía Boliviana y acredito en la Certificación de Años de Servicio emitido por el Comando General de la Policía Boliviana como mínimo de 16 años de servicio, asimismo, <b>No</b> fui dado de baja en forma obligatoria o voluntaria de la Policía Boliviana.</td>
    </tr>
    <tr>
      <td>4</td>
      <td style="text-align:justify">La información y documentación proporcionada por mi persona, tanto verbal como la contenida en documentos respecto a los requisitos mínimos para acceder al Beneficio del Complemento Económico, es totalmente <b>real y fidedigna</b>, por lo que me hago totalmente responsable de la misma.
      </td>
    </tr>
    <tr>
      <td>5</td>
      <td style="text-align:justify">No me encuentro en calidad de denunciado, imputado, acusado o sentenciado con proceso judicial seguido por la MUSEPOL y/o MUSERPOL en mi contra. Asimismo, no tengo sentencia condenatoria ejecutoriada por delitos cometidos contra la Policía Boliviana y/o MUSEPOL y/o MUSERPOL.</td>
    </tr>
    <tr>
      <td>6</td>
      <td style="text-align:justify">Estoy consciente de que existe la probabilidad de ser excluido (a) por salario, por percibir una prestación por vejez <b>IGUAL O SUPERIOR</b> al haber básico más categoría que perciban los miembros del servicio activo de la Policía Boliviana en el grado correspondiente, tal como lo señala en el Decreto Supremo N° 1446, Artículo 17, Parágrafo I y el Reglamento del Beneficio del Complemento Económico.</td>
    </tr>
    <tr>
      <td>7</td>
      <td style="text-align:justify">Estoy de acuerdo en proceder con la devolución de montos cobrados indebidamente en caso de producirse alguna inconsistencia a causa del contenido de la documentación presentada, información proporcionada por entidades externas, error del sistema u otros que se presenten.</td>
    </tr>
  </table>
<p align="justify">En mérito de los datos registrados en forma precedente, el interesado aprueba y ratifica su tenor de manera íntegra, quien en señal de conformidad en forma expresa y voluntaria firma el presente documento en la ciudad de La Paz, {!! Util::getfulldate(date('Y-m-d')) !!}.</p>
<br>
<table>
          <tr>
              <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
              <th class="info" style="border-bottom: 1px solid  #5D6975!IMPORTANT;text-align:center;width: 25%;"><p>&nbsp;</p><br></th>
              <th class="info" style="border: 0px;text-align:center;width: 15%;"></th>

          </tr>
          <tr>
            <th class="info" style="border: 0px;text-align:center;">{!! $affiliate->name !!}<br>C.I. {!! $affiliate->identity_card !!} Telefono. {!! $affiliate->phone !!}</th>
            <th class="info" style="border: 0px;text-align:center;">Huella Digital Pulgar Derecho</th>
            <th class="info" style="border: 0px;text-align:center;width: 15%;"></th>
          </tr>



</table>
<p align="justify"><b>Nota.- El presente documento tiene carácter de DECLARACIÓN JURADA, por lo que en caso de evidenciarse la falsedad de este, se procederá con las acciones legales pertinentes. </b></p>
</div>
@endsection
