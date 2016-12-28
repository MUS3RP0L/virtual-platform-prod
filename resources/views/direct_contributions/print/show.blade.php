@extends('print')

@section('content')


<div id="project">
    <table >
        <tr>
            <td class="info" style="border: 0px;">N°: {{ trim($direct_contribution->code) }}  </td>
            <td class="info" style="border: 0px;" >Titular: {{ trim($affiliate->getTittleName()) }}</td>
            <td class="info" style="border: 0px;" >Matrícula: {{ $affiliate->registration }}</td>
        </tr>
        <tr>
            <td class="info" style="border: 0px;" > Tipo: {{ $affiliate->affiliate_state->name }}</td>
            <td class="info" style="border: 0px;" > Grado: {{ $affiliate->degree->name }}</td>
        </tr>
    </table>

</div>
<div id="project">
    <table>
      <tr>
          <td colspan="6" class="grand service" style="text-align:center;">Periodo: {{ $direct_contribution->period() }}  </td>
      </tr>
      <tr>
        <td class="grand service" style="text-align:center;" >Cotizable</td>
        <td class="grand service" style="text-align:center;">Aporte</td>
        <td class="grand service" style="text-align:center;">F.R.P.</td>
        <td class="grand service" style="text-align:center;">Cuota Mortuoria</td>
        <td class="grand service" style="text-align:center;">Ajuste IPC</td>
        <td class="grand service" style="text-align:center;">Total Aporte</td>
      </tr>
      <tr>
        <th class="info" style="text-align:center;" >{{ $direct_contribution->quotable }}</th>
        <th class="info" style="text-align:center;">{{ $direct_contribution->subtotal }}</th>
        <th class="info" style="text-align:center;">{{ $direct_contribution->retirement_fund }}</th>
        <th class="info" style="text-align:center;">{{ $direct_contribution->mortuary_quota }}</th>
        <th class="info" style="text-align:center;">{{ $direct_contribution->ipc }}</th>
        <th class="info" style="text-align:center;">{{ $direct_contribution->total }}</th>
      </tr>
    </table>
    <h4 style="text-align: left"> SON: {{ Util::convertir($direct_contribution->total,'Bolivianos','Centavos') }}.</h4>
    <br>
    <br>
    <br>
    <br>
    <table>
          <tr>
              <th class="info" style="border: 0px;text-align:center;">--------------------------------</th>
              <th class="info" style="border: 0px;text-align:center;">--------------------------------</th>
              <th class="info" style="border: 0px;text-align:center;">--------------------------------</th>
          </tr>
          <tr>
              <th class="info" style="border: 0px;text-align:center;" >ELABORADO POR</th>
              <th class="info" style="border: 0px;text-align:center;" >PAGADO POR</th>
              <th class="info" style="border: 0px;text-align:center;" >COBRADO POR</th>
          </tr>
    </table>

    <p>***Esta liquidación no es válida sin el Refrendo y Sello de Tesorería***</p>
</div>




@endsection
