@extends('globalprint.print')
@section('title2')

@endsection
@section('content')
<style type="text/css">
    
    .number{
      text-align: right;
    }
  </style>
    <div id="project">
    <div class="title2"><b>{!! $economic_complement->getCode() !!} </div>


  {{--Información beneficiario--}}
  @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
    <table class="table" style="width:100%;">
      <tr>
          <td colspan="4" class="grand service">
          INFORMACIÓN BENEFICIARIO
            @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
             - CAUSAHABIENTE
            @endif
          </td>
      </tr>
      <tr>
          <td>NOMBRE:</td><td nowrap>{!! $affiliate->last_name !!} {!! $affiliate->mothers_last_name !!} {!! $affiliate->first_name !!}</td>
          <td>C.I.:</td><td nowrap>  {!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card->first_shortened ?? '' !!}</td>
      </tr>
      <tr>
        <td>TELÉFONO:</td>
        <td>
              @foreach(explode(',',$affiliate->phone_number) as $phone)
                {!! $phone !!}<br/>
              @endforeach
        </td>
        <td>CELULAR:</td>
        <td>
             @foreach(explode(',',$affiliate->cell_phone_number) as $phone)
              {!! $phone !!}<br/>
             @endforeach
        </td>
      </tr>
      <tr>
          <td>FECHA NACIMIENTO:</td><td> {!! $affiliate->getShortBirthDate() !!}</td><td>EDAD:</td><td>{!! $affiliate->getHowOld() !!}</td>
      </tr>
    </table>
  @endif
  {{--Información derechohabiente--}}
    <table class="table" style="width:100%;">
      <tr>
          <td colspan="4" class="grand service">
              INFORMACIÓN BENECIFIARIO
              @if($eco_com_applicant->economic_complement->economic_complement_modality->economic_complement_type->id > 1)
               - DERECHOHABIENTE
              @endif
          </td>
      </tr>
      <tr>
          <td>NOMBRE:</td><td nowrap>{!! $eco_com_applicant->last_name !!} {!! $eco_com_applicant->mothers_last_name !!} {!! $eco_com_applicant->first_name !!} {!! $eco_com_applicant->second_name !!}</td>
          <td>C.I.:</td><td nowrap>{!! $eco_com_applicant->identity_card !!} {{$eco_com_applicant->city_identity_card->first_shortened ?? ''}}
          </td>
      </tr>
      @if ($eco_com_applicant->surname_husband)
      <tr>
          <td>APELLIDO ESPOSO:</td><td colspan="3">{!! $eco_com_applicant->surname_husband !!}</td>
      </tr>
      @endif
      <tr>
          <td>FECHA NACIMIENTO:</td><td> {!! $eco_com_applicant->getShortBirthDate() !!}</td><td>EDAD:</td><td>{!! $eco_com_applicant->getHowOld() !!}</td>
      </tr>
      <tr>
        <td>TELÉFONO:</td>
        <td>
              @foreach(explode(',',$eco_com_applicant->phone_number) as $phone)
                {!! $phone !!}<br/>
              @endforeach
        </td>
        <td>CELULAR:</td>
        <td>
             @foreach(explode(',',$eco_com_applicant->cell_phone_number) as $phone)
              {!! $phone !!}<br/>
             @endforeach
        </td>
      </tr>
    </table>

  {{--Información apoderado--}}  
@if($economic_complement->has_legal_guardian)
    <table>
      <tr>
        <td colspan="4" class="grand service">INFORMACIÓN DEL APODERADO</td>
      </tr>
      <tr>
        <td>NOMBRE:</td><td nowrap>{!! $economic_complement_legal_guardian->last_name !!} {!! $economic_complement_legal_guardian->mother_name !!} {!! $economic_complement_legal_guardian->first_name !!}</td><td>C.I.:</td><td nowrap>{!! $economic_complement_legal_guardian->identity_card !!} {!! $economic_complement_legal_guardian->city_identity_card->first_shortened ?? '' !!}</td>
      </tr>
      <td>TELÉFONO:</td>
      <td>
          @foreach(explode(',',$economic_complement_legal_guardian->phone_number) as $phone)
            {!! $phone !!}<br/>
          @endforeach
      </td>
      <td>CELULAR:</td>
      <td>
          @foreach(explode(',',$economic_complement_legal_guardian->cell_phone_number) as $phone)
            {!! $phone !!}<br/>
          @endforeach
      </td>
    </table>
@endif

{{--Información del trámite--}}
<table>
  <tr>
    <td colspan="4" class="grand service">INFORMACIÓN DEL TRÁMITE</td>
  </tr>
  <tr>
    <td>TIPO:</td><td>{{$economic_complement->economic_complement_modality->shortened}}</td><td>ENTE GESTOR:</td><td>{!! $affiliate->pension_entity->name ?? '' !!}</td>
  </tr>
  <tr>
    <td>GRADO:</td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td><td>CATEGORÍA:</td><td>{!! $economic_complement->category->getPercentage() !!}</td>
  </tr>
  <tr>
    <td>SEMESTRE:</td><td>{!! $economic_complement->semester !!}</td><td>GESTIÓN:</td><td> {!! $economic_complement->getYear() !!}</td>
  </tr>
</table>
<table>
  <tr>
    <td colspan="3" class="grand service" ><strong>CÁLCULO DEL TOTAL PAGADO</strong></td>
  </tr>
  <tr>
    <td class="grand service" rowspan="2"><b>DETALLE</b></td>
    <td class="grand service" colspan="2"><b style="text-align: center">FRACCIÓN CALCULADO</b></td>
  </tr>
  <tr>
    <td class="grand service"><b>A FAVOR</b></td><td class="grand service"><b>DESCUENTO</b></td>
  </tr>
  <tr>
    <td>FRACCIÓN DE SALDO ACUMULADO</td><td class="number">{{$economic_complement->aps_total_fsa}}</td><td></td>
  </tr>
  <tr>
    <td>FRACCIÓN COMPLEMENTARIA</td><td class="number">{{$economic_complement->aps_total_cc}}</td><td></td>
  </tr>
  <tr>
    <td>FRACCIÓN SOLIDARIA</td><td class="number">{{$economic_complement->aps_total_fs}}</td><td></td>
  </tr>
  <tr>
    <td class="grand service"><b>TOTAL</b></td><td class="number"><b>{{$eco_tot_frac}}</b></td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td class="grand service" rowspan="2"><b>CONCEPTO</b></td>
    <td class="grand service" colspan="2"><b style="text-align: center">MONTO CALCULADO</b></td>
  </tr>
  <tr>
    <td class="grand service"><b>A FAVOR</b></td><td class="grand service"><b>DESCUENTO</b></td>
  </tr>
  <tr>
    <td>RENTA BOLETA</td><td class="number">{{$sub_total_rent}}</td><td></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REINTEGRO</td><td></td><td class="number">{{$reimbursement}}</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RENTA DIGNIDAD</td><td></td><td class="number">{{$dignity_pension}}</td>
  </tr>
  <tr>
    <td><b>RENTA TOTAL NETA</b></td><td class="number"><b>{{$total_rent_calc}}</b></td><td></td>
  </tr>
  <tr>
    <td>REFERENTE SALARIAL</td><td class="number">{{$salary_reference}}</td><td></td>
  </tr>
  <tr>
    <td>ANTIGÜEDAD</td><td class="number">{{$seniority}}</td><td></td>
  </tr>
  <tr>
    <td>SALARIO COTIZABLE</td><td class="number">{{$salary_quotable}}</td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td>DIFERENCIA</td><td class="number">{{$difference}}</td><td></td>
  </tr>
  <tr>
    <td class="grand service">TOTAL SEMESTRE(DIF * 6 Meses)</td><td class="number">{{$total_amount_semester}}</td><td></td>
  </tr>
  <tr>
    <td>FACTOR COMPLEMENTO</td><td class="number">{{$factor_complement}} %</td><td></td>
  </tr>
  <tr>
    <td class="grand service"><b>TOTAL COMP. EC. (TS * FC)</b></td><td class="number"><b>{{$eco_com_prev}}</b></td><td></td>
  </tr>
  <tr>
    <td &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CUENTAS POR COBRAR</td><td></td><td></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MORA POR PRÉSTAMOS</td><td></td><td class="number" >{{$economic_complement->amount_loan}}</td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DISPOSICIÓN DE FONDOS</td><td></td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
  <td class="grand service"><b>TOTAL PAGADO COMP. ECO.</b></td><td class="number"><b>{{$total}}</b></td><td></td>
  </tr>
  <tr>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td colspan="3" class="grand service">NOTA</td>
  </tr>
  <tr>
    <td colspan="3"><b> </b>{!!$economic_complement->comment!!}</td>
  </tr>
</table>
<table>
  <tr>
    <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>-------------------------------------------</th>
  </tr>
  <tr>
    <th class="info" style="border: 0px;text-align:center;"><b>Elaborado por {!! $user_1->first_name !!} {!! $user_1->last_name !!} <br> {!! $user_1->getAllRolesToString() !!}</b></th>        
  </tr>
</table>

</div>
@endsection