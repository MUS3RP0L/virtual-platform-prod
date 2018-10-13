@extends('globalprint.wkhtml')

@section('content')

<div class="title2"><strong class="code">DOC - {!! $doc_number !!} </strong><strong class="code">Trámite Nº: {!! $economic_complement->code !!} </strong><strong class="code">Nº Afiliado: {!! $affiliate->id !!} </strong></div>
<div id="project">
  <table class="table" style="width:100%; font-size:14px;">
    <tr>
      <td colspan="7" class="grand info_title">
        INFORMACIÓN DEL BENEFICIARIO
        @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
        - DERECHOHABIENTE
        @endif
      </td>
    </tr>
    <tr >
      <td colspan="1"><strong>NOMBRE:</strong></td>
      <td colspan="2" nowrap>{!! $eco_com_applicant->getFullName() !!}</td>
      <td><strong>GRADO:</strong></td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td>
      <td><strong>CATEGORÍA:</strong></td><td>{!! $economic_complement->category->getPercentage() !!}</td>
    </tr>
    <tr>
      <td><strong>C.I.:</strong></td><td nowrap colspan="2">{!! $eco_com_applicant->identity_card !!} {{$eco_com_applicant->city_identity_card->first_shortened ?? ''}}</td>
      <td><strong>FECHA DE NAC.:</strong></td><td> {!! $eco_com_applicant->getShortBirthDate() !!}</td>
      <td><strong>EDAD:</strong></td><td>{!! $eco_com_applicant->getAge() !!} AÑOS</td>
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
      <td><strong>LUGAR DE NAC.:</strong></td>
      <td colspan="2">{!! $eco_com_applicant->city_birth->name ?? '' !!}</td>
    </tr>
  </table>
  <p align="justify"> Yo, <strong>{!! $eco_com_applicant->getTitleNameFull() !!}</strong> boliviano (a) de nacimiento con Cédula de Identidad <strong>N° {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened ?? '' !!}</strong> .
    con estado civil <strong>{!! $eco_com_applicant->getCivilStatus() !!}</strong> y con residencia actualmente en el Departamento de <strong>{!! $economic_complement->city ? $economic_complement->city->name : '' !!}</strong>.; mayor de edad,
    y hábil por derecho; consiente de la responsabilidad que asumo ante la Mutual de Servicios al Policía – MUSERPOL,
    de manera voluntaria y sin que medie ningún tipo de presión, mediante la presente, <strong>DECLARO LO SIGUIENTE:</strong>
  </p>
  <table>
    <tr>
      <td>1</td>
      <td style="text-align:justify">
        No percibo una pensión de jubilación por Riesgo Común y/o Profesional o Invalidez Común y/o Profesional, por lo cual, la prestación o renta en curso de pago que percibo por parte de las Administradoras del Fondo de Pensiones (AFP’s), Aseguradoras o Sistema de Reparto corresponde a una <strong>PRESTACIÓN POR VEJEZ O RENTA DE JUBILACIÓN</strong>, por lo que estaré a la espera de la respectiva valoración de la documentación presentada a efecto que se determine si mi prestación se enmarca en la normativa de acceso al beneficio del Complemento Económico, detallado en detallado en los Decreto Supremo N° 1446, 3231 y otros.
      </td>
    </tr>
    <tr>
      <td>2</td>
      <td style="text-align:justify">
        Pertenezco al sector pasivo de la Policía Boliviana y acredito con la Certificación de Años de Servicio emitido por el Comando General de la Policía Boliviana como mínimo de 16 años de servicio, asimismo, <strong>No</strong> fui dado de baja en forma obligatoria o voluntaria de la Policía Boliviana.
      </td>
    </tr>
    <tr>
      <td>3</td>
      <td style="text-align:justify">
        La información y documentación proporcionada por mi persona, tanto verbal como la contenida en documentos respecto a los requisitos mínimos para acceder al Beneficio del Complemento Económico, es totalmente <strong>legal y fidedigna</strong>, por lo que me hago totalmente responsable de la misma.
      </td>
    </tr>
    <tr>
      <td>4</td>
      <td style="text-align:justify">No tengo sentencia condenatoria ejecutoriada por delitos cometidos contra la MUSEPOL y/o MUSERPOL.</td>
    </tr>
    <tr>
      <td>5</td>
      <td style="text-align:justify">
        Estoy consciente de que existe la probabilidad de ser excluido (a) por salario, por percibir una prestación por vejez <strong>IGUAL O SUPERIOR</strong> al haber básico más categoría que perciban los miembros del servicio activo de la Policía Boliviana en el grado correspondiente, tal como lo señala en el Decreto Supremo N° 1446, modificado mediante Decreto Supremo N° 3231 de 28 de junio de 2017, Artículo 17, Parágrafo I y el Reglamento del Beneficio del Complemento Económico.
      </td>
    </tr>
    <tr>
      <td>6</td>
      <td style="text-align:justify">
        En caso de no informar oportunamente que percibo una prestación por vejez o solidaria de vejez y simultáneamente una prestación por invalidez (concurrencia), me comprometo y acepto a proceder con la devolución de posibles pagos en defecto determinados a través de la Contrastación de información proporcionada por la Autoridad competente.
      </td>
    </tr>
    <tr>
      <td>7</td>
      <td style="text-align:justify">
        Estoy de acuerdo en proceder con la devolución de montos cobrados indebidamente o subsanar cualquier observación en caso de producirse alguna inconsistencia a causa del contenido de la documentación presentada, información proporcionada por entidades externas, error del sistema u otros que se presenten, conforme prevé el Art. 28° del reglamento del Complemento Económico.
      </td>
    </tr>
  </table>
<p align="justify">En mérito de los datos registrados en forma precedente, el interesado aprueba y ratifica su tenor de manera íntegra, quien en señal de conformidad en forma expresa y voluntaria firma el presente documento en la ciudad de {{ $user->city->name ?? 'La Paz' }}, {!! $date !!}.</p>
<br>
<table>
            
          <tr>
              <th class="no-border" style="width:33%"> 
                
                &nbsp;
              </th>
              <th class="info" style="border: 0px;text-align:center; width:33%"><p>&nbsp;</p><br>----------------------------------------------------
                <strong>
                <br>
                {!! $eco_com_applicant->getTitleNameFull() !!}
                <br>
                C.I. {!! $eco_com_applicant->identity_card !!} {!! $eco_com_applicant->city_identity_card->first_shortened ?? ''!!}
                </strong>
              </th>
              <th class="no-border" style="width:33%;">
                <div  style="border: 1px solid  #3c3c3c!IMPORTANT;text-align:center;width: 100%;">
                  <p>&nbsp;</p>
                  <br><br><br><br>
                </div>
                <br>
                <span class="info" style="border: 0px;text-align:center;">Impresión Digital Pulgar Derecho</span>
              </th>

          </tr>
        
</table>
<p align="justify"><strong class="size-10">Nota.- El presente documento tiene carácter de DECLARACIÓN JURADA, por lo que en caso de evidenciarse la falsedad de este, se procederá con las acciones legales pertinentes. </strong></p>
</div>
@endsection
