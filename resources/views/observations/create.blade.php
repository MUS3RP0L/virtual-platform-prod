<!-- Modal -->
<div class="modal fade" id="observationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			{!! Form::open(['url' => 'observation']) !!}
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Crear una Observacion para el afiliado {{ $affiliate->identity_card}} </h4>
			</div>
			<div class="modal-body">

				{!! Form::token() !!}
				{!! Form::label('observation_type_id', 'Tipo', ['']) !!}

				<div class="form-group">

					{!! Form::select('observation_type_id', $observations_types, '', ['class' => 'col-md-2 combobox form-control','required' => 'required']) !!}

				</div>
				{!! Form::label('message', 'Mensaje:', []) !!}
				@if(isset($ObservationType))
				{!! Form::textarea('message', '', ['class'=>'form-control','required' => 'required']) !!}
					@else
					{!! Form::textarea('message', null, ['class'=>'form-control']) !!}
				@endif
				{!! Form::label('is_enabled', 'Habilitado', ['']) !!}
				<div class="form-group">
				    <div class="checkbox">
				        <label><input type="checkbox" name="is_enabled">
				        </label>
				    </div>
				</div>
				{!! Form::hidden('affiliate_id', $affiliate->id) !!}
			</div>
			<div class="modal-footer">
				<div class="text-center">
					<a href="#" data-dismiss="modal" class="btn btn-raised btn-warning">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;&nbsp;</a>
					&nbsp;&nbsp;&nbsp;
					<button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Guardar">&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;&nbsp;</button>
				</div>
			</div>
				{!! Form::close() !!}
		</div>
	</div>
</div>
