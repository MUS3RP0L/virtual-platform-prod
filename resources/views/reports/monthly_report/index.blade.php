@extends('app')
@section('contentheader_title')
  {!! Breadcrumbs::render('monthly_reports') !!}
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Reporte por Mes</h3>
                </div>
                <div class="panel-body">
					{!! Form::open(['url' => 'monthly_report', 'role' => 'form', 'class' => 'form-horizontal']) !!}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-lg">
                                        {!! Form::label('year', 'AÑO', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('year', $years_list, $year, ['class' => 'combobox form-control', 'required' => 'required']) !!}
                                        <span class="help-block">Seleccione el Año</span>
                                    </div>
                                </div>
							</div>
							<div class="col-md-6">
					        	<div class="form-group form-group-lg">
                                        {!! Form::label('month', 'MES', ['class' => 'col-md-3 control-label']) !!}
                                    <div class="col-md-9">
                                        {!! Form::select('month', $months_list, $month, ['class' => 'combobox form-control', 'required' => 'required']) !!}
                                        <span class="help-block">Seleccione el Mes</span>
                                    </div>
                            	</div>
                            </div>
						</div>

						<div class="row text-center">
                            <div class="form-group form-group">
                              <div class="col-md-12">
                                <button type="submit" class="btn btn-raised btn-primary">Generar</button>
                              </div>
                            </div>
                       	</div>

					{!! Form::close() !!}

				</div>

			</div>
			@if($result)
			<div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="panel-title">Totales</h3>
                        </div>
                        <div class="col-md-6">
                            <h3 class="panel-title"style="text-align: right">Bolivianos</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered table-hover" style="width:100%;font-size: 14px">
                                <tr class="success">
                                    <th></th>
                                    <th style="text-align: center">Comando General</th>
                                    <th style="text-align: center">Batallón de Seguridad</th>
                                    <th style="text-align: center">Comando y Batallón</th>
                                </tr>
                                <tr>
                                    <th>Total de Registros</th>
                                    <td style="text-align: right">{{ $count_idC }}</td>
                                    <td style="text-align: right">{{ $count_idB }}</td>
                                    <td style="text-align: right">{{ $total_count_id }}</td>
                                </tr>
                                <tr>
                                    <th>Sueldo</th>
                                    <td style="text-align: right">{{ $salaryC }}</td>
                                    <td style="text-align: right">{{ $salaryB }}</td>
                                    <td style="text-align: right">{{ $total_salary }}</td>
                                </tr>
                                <tr>
                                    <th>Bono Antigüedad</th>
                                    <td style="text-align: right">{{ $seniority_bonusC }}</td>
                                    <td style="text-align: right">{{ $seniority_bonusB }}</td>
                                    <td style="text-align: right">{{ $total_seniority_bonus }}</td>
                                </tr>
                                <tr>
                                    <th>Bono Estudio</th>
                                    <td style="text-align: right">{{ $study_bonusC }}</td>
                                    <td style="text-align: right">{{ $study_bonusB }}</td>
                                    <td style="text-align: right">{{ $total_study_bonus }}</td>
                                </tr>
                                <tr>
                                    <th>Bono Cargo</th>
                                    <td style="text-align: right">{{ $position_bonusC }}</td>
                                    <td style="text-align: right">{{ $position_bonusB }}</td>
                                    <td style="text-align: right">{{ $total_position_bonus }}</td>
                                </tr>
                               	<tr>
                                    <th>Bono Frontera</th>
                                    <td style="text-align: right">{{ $border_bonusC }}</td>
                                    <td style="text-align: right">{{ $border_bonusB }}</td>
                                    <td style="text-align: right">{{ $total_border_bonus }}</td>
                                </tr>
                                <tr>
                                    <th>Bono Oriente</th>
                                    <td style="text-align: right">{{ $east_bonusC }}</td>
                                    <td style="text-align: right">{{ $east_bonusB }}</td>
                                    <td style="text-align: right">{{ $total_east_bonus }}</td>
                                </tr>
                                <tr>
                                    <th>Bono Seguridad Ciudadana</th>
                                    <td style="text-align: right">{{ $public_security_bonusC }}</td>
                                    <td style="text-align: right">{{ $public_security_bonusB }}</td>
                                    <td style="text-align: right">{{ $total_public_security_bonus }}</td>
                                </tr>
                                <tr>
                                    <th>Ganancia</th>
                                    <td style="text-align: right">{{ $gainC }}</td>
                                    <td style="text-align: right">{{ $gainB }}</td>
                                    <td style="text-align: right">{{ $total_gain }}</td>
                                </tr>
                               	<tr>
                                    <th>Cotizable</th>
                                    <td style="text-align: right">{{ $quotableC }}</td>
                                    <td style="text-align: right">{{ $quotableB }}</td>
                                    <td style="text-align: right">{{ $total_quotable }}</td>
                                </tr>
                                <tr>
                                    <th>Fondo de Retiro</th>
                                    <td style="text-align: right">{{ $retirement_fundC }}</td>
                                    <td style="text-align: right">{{ $retirement_fundB }}</td>
                                    <td style="text-align: right">{{ $total_retirement_fund }}</td>
                                </tr>
                                <tr>
                                    <th>Seguro de Vida</th>
                                    <td style="text-align: right">{{ $mortuary_quotaC }}</td>
                                    <td style="text-align: right">{{ $mortuary_quotaB }}</td>
                                    <td style="text-align: right">{{ $total_mortuary_quota }}</td>
                                </tr>
                                <tr class="active">
                                    <th>Aporte Muserpol</th>
                                    <td style="text-align: right">{{ $totalC }}</td>
                                    <td style="text-align: right">{{ $totalB }}</td>
                                    <td style="text-align: right">{{ $total }}</td>
                                </tr>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
            @endif
		</div>
	</div>

@endsection

@push('scripts')
<script type="text/javascript">

	$(document).ready(function(){
	   $('.combobox').combobox();
	});

</script>
@endpush
