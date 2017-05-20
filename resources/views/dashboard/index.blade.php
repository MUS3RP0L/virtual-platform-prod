@extends('app')

@section('contentheader_title')

{!! Breadcrumbs::render('dashboard') !!}

@endsection

@section('main-content')
@can('economic_complement')
<div class="row">
	<div class="col-md-4">
		@include('dashboard.economic_complement_by_type')
		
	</div>
	<div class="col-md-4">
		@include('dashboard.economic_complement_by_type_of_modalities')
	</div>
	<div class="col-md-4">
		@include('dashboard.complementary_economic_by_departments')	
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		@include('dashboard.economic_complement_of_the_management')
	</div>
</div>
@endcan
@can('manage')

<div class="row">

	<div class="col-md-4">
		@include('dashboard.affiliates_by_state')	
	</div>
	<div class="col-md-8">
		@include('dashboard.contributions_by_management')
	</div>

</div>

<div class="row">

	{{-- <div class="col-md-4">
		@include('dashboard.affiliates_by_type')
	</div> --}}
	<div class="col-md-8">
		@include('dashboard.voluntary_management_contributions')
		
	</div>

</div>

<div class="row">
	<div class="col-md-4">
		@include('dashboard.affiliates_by_district')

	</div>
	<div class="col-md-8">
		@include('dashboard.procedures_of_the_management')
	</div>

</div>
@endcan




@endsection
@push('scripts')

<script type="text/javascript">

	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var options = {
		responsive: true,
		tooltipTemplate: " <%=label%>: <%= value + ' Bs' %>",
		legend: {
			display: true
		},
	};

//for complement economic

var barChartDataSemestre = {
	type:'bar',
	data:{
		labels : {!! json_encode($economic_complement_bar[0]) !!},
		datasets : [
		{
			label: 'Hola',
			backgroundColor: [
			'rgba(54, 162, 235, 0.2)'
			],
			borderColor:[
			'rgba(54, 162, 235, 1)'
			],
			borderWith:1,
			data : {!! json_encode($economic_complement_bar[1]) !!}
		}
		]
	}

}



</script>

@endpush
