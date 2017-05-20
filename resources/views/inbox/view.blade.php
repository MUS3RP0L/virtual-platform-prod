@extends('app')
@section('contentheader_title')

    <div class="row">
        <div class="col-md-8">
            {!! Breadcrumbs::render('users') !!}
        </div>
        <div class="col-md-4 text-right">
            <a href="{!! url('user/create') !!}" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Nuevo">&nbsp;
                <i class="glyphicon glyphicon-plus"></i>&nbsp;
            </a>
        </div>
    </div>

@endsection
@section('main-content')

<div class="col-md-6">
	<div class="box box-danger">
		<div class="box-header with-border">
			<h3 class="box-title">Recibidos</h3>
		</div>
		<div class="box-body" style="width: 95%">
			<table class="table">
				<thead>
					<tr>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>John</td>
						<td>Doe</td>
						<td>john@example.com</td>
					</tr>
					<tr>
						<td>Mary</td>
						<td>Moe</td>
						<td>mary@example.com</td>
					</tr>
					<tr>
						<td>July</td>
						<td>Dooley</td>
						<td>july@example.com</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="box box-success">
		<div class="box-header with-border">
			<h3 class="box-title">HECHOS</h3>
		</div>
		<div class="box-body" style="width: 95%">
			<table class="table">
				<thead>
					<tr>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>John</td>
						<td>Doe</td>
						<td>john@example.com</td>
					</tr>
					<tr>
						<td>Mary</td>
						<td>Moe</td>
						<td>mary@example.com</td>
					</tr>
					<tr>
						<td>July</td>
						<td>Dooley</td>
						<td>july@example.com</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>


@endsection