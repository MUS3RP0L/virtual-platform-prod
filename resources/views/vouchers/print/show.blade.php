@extends('print')
@section('content')

<div id="project">
    <table>
        <tr>
            <td class="grand service" style="border: 0px;">
            <div >Recibimos de: {{ $affiliate->getFullNametoPrint() }}</div>
            </td>
            <td class="grand service" style="border: 0px;"> N° Recibo: {{ $voucher->code }}</td>
        </tr>

    </table>
</div>

<div id="project">
    <table>
        <tr>
          <td colspan="3" class="grand service" style="text-align:center;">Periodo: {{ $direct_contribution->period() }}  </td>
        </tr>
      <tr>
        <td class="grand service" style="text-align:center;" >Total a Pagar</td>
        <td class="grand service" style="text-align:center;">Concepto</td>
        <td class="grand service" style="text-align:center;">Forma de Pago</td>

      </tr>
      <tr>
        <th class="info" style="text-align:center;" >Bs. {{ $voucher->total }}</th>
        <th class="info" style="text-align:center;">Aporte Voluntario Auxilio Mortuorio</th>
        <th class="info" style="text-align:center;"> Efectivo </th>

      </tr>
    </table>
    <h4 style="text-align:left;"> SON: {{ Util::convertir($voucher->total,'Bolivianos','Centavos') }}.</h4>
    <br>
    <br>
    <br>
    <br>
    <table>
          <tr>
              <th class="info" style="border: 0px;text-align:center;">-------------------------------------------</th>

          </tr>
          <tr>
              <th class="info" style="border: 0px;text-align:center;" >COBRADO POR</th>
          </tr>
    </table>

</div>

@endsection
