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
<div class="title2">
</div>
   <div id="project">  
      <table class="table" style="width:100%;">
      {{-- affiliate--}}
        <tr>
          <td colspan="6" class="grand info_title">
            INFORMACIÓN DEL AFILIADO
          </td>
        </tr>
        <tr >
          <td colspan="1"><strong>NOMBRE:</strong></td><td colspan="5" nowrap>{!! $affiliate->getFullNamePrintTotal() !!}</td>
        </tr>
        <tr>
          <td><strong>C.I.:</strong></td><td nowrap>{!! $affiliate->identity_card !!} {{$affiliate->city_identity_card->first_shortened ?? ''}}</td>
          <td><strong>GÉNERO:</strong></td><td>{!! $affiliate->getGender() !!}</td>
          <td><strong>FECHA DE NAC.:</strong></td><td> {!! $affiliate->getShortBirthDate() !!}</td>
        </tr>
        <tr>
          <td><strong>EDAD:</strong></td><td>{!! $affiliate->getAge() !!} AÑOS</td>
          <td><strong>LUGAR DE NAC.:</strong></td><td>{!! $affiliate->city_birth->second_shortened ?? '' !!}</td>
          <td><strong>ESTADO CIVIL:</strong></td><td>{!! $affiliate->getCivilStatus() !!}</td>
        </tr>
        <tr>
          <td><strong>TELÉFONO:</strong></td>
          <td>{!! explode(',',$affiliate->phone_number)[0] !!}</td>
          <td><strong>CELULAR:</strong></td><td>{!! explode(',',$affiliate->cell_phone_number)[0] !!}</td>
          <td><strong>NUA/CUA:</strong></td><td>{!! $affiliate->nua !!}</td>
        </tr>
      {{-- /affiliate--}}
      </table>
      <table class="table" style="width:100%;">
      {{-- Información Policial Actual--}}
        <tr>
          <td colspan="8" class="grand info_title">
            INFORMACIÓN POLICIAL ACTUAL
          </td>
        </tr>
        <tr>
          <td><strong>ESTADO:</strong></td><td>{!! strtoupper($affiliate->affiliate_state->name) ?? '' !!}</td>
          <td><strong>TIPO DE ESTADO:</strong></td><td>{!! strtoupper($affiliate->affiliate_state->affiliate_state_type->name) ?? '' !!}</td>
          <td><strong>TIPO:</strong></td><td>{!! strtoupper($affiliate->type) ?? '' !!}</td>
          <td><strong>NÚM. DE ÍTEM:</strong></td><td>{!! $affiliate->item !!}</td>
        </tr>
        <tr>
          <td><strong>CATEGORIA:</strong></td><td>{!! strtoupper($affiliate->category->name) ?? '' !!}</td>
          <td><strong>GRADO:</strong></td><td>{!! strtoupper($affiliate->degree->shortened) ?? '' !!}</td>
          <td><strong>FECHA DE INGRESO:</strong></td><td>{!! $affiliate->getShortDateEntry() !!}</td>
          <td><strong>ENTE GESTOR:</strong></td><td>{!! $affiliate->pension_entity->type ?? '' !!}</td>
        </tr>
      {{-- /I nformación Policial Actual--}}
      </table>
      <table class="table" style="width:100%;">
      {{-- Información Policial Actual--}}
        <thead>
          <td colspan="3" class="grand info_title">
            HISTORIAL DEL AFILIADO
          </td>
          <tr>
            <td class="grand service"><strong>#</strong></td>
            <td class="grand service"><strong>FECHA</strong></td>
            <td class="grand service"><strong>DESCRIPCIÓN</strong></td>
          </tr>
          
        </thead>
        <tbody>
        @foreach($affiliate_records as $index=>$record)
          <tr>
            <td class="number service">{!! $index+1 !!}</td>
            <td class="service">{!! Util::getAllDate($record->date) !!}</td>
            <td>{!! $record->message !!}</td>
          </tr>
        @endforeach
        </tbody>
      {{-- /I nformación Policial Actual--}}
      </table>
      <p>
        <strong>NOTA:</strong> El historial del afiliado es una información proporcionada por COMANDO.
      </p>
  </div>
@endsection