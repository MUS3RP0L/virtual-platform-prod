@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
            <ol class="breadcrumb">
              
              <li class="active">Afiliados Observados</li>
            </ol>
        </div>
        <div class="col-md-12 text-right">
                
        
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Afiliados Observados" style="margin: 0;">
                    <a href="{!! url('get_afi_observations') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>
          <div class="btn-group"  data-toggle="tooltip" data-original-title="Comparar Complemento 2018 y 2017" style="margin: 0;">
                    <a href="{!! url('get_eco_com_compare2018_2017') !!}" class="btn btn-success btn-raised bg-blue" ><i class="glyphicon glyphicon-save glyphicon-lg"></i></a>
          </div>
          
          
        </div>          
    </div>

@endsection

@section('main-content')

<style type="text/css">
.inputSearch
{
    background-image: url('img/searching.png');
    background-position: 0px left;
    background-repeat: no-repeat;
    padding:0 0 0 20px;
    border-top: 0px;
    border-right: 0px;
    border-left: 0px;
    width: 100%;
      
}
</style>

<div class="row">
       
</div>
@endsection   
@push('scripts')
<script>

</script>
@endpush

