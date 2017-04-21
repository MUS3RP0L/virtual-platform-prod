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
				{!! Form::label('title', 'Titulo:', ['']) !!}
				{!! Form::text('title', null, ['class'=>'form-control']) !!}
				{!! Form::label('message', 'Mensaje:', []) !!}
				{!! Form::textarea('message', null, ['class'=>'form-control']) !!}
				{!! Form::hidden('affiliate_id', $affiliate->id  ) !!}
				{!! Form::hidden('module_id', Auth::user()->roles()->first()->module_id ) !!}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
						{!! Form::submit('Guardar Observacion!',['class'=>"btn btn-primary"]) !!}
			</div>
						{!! Form::close() !!}
		</div>
	</div>
</div>