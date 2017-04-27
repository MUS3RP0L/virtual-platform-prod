@extends('app')

@section('contentheader_title')
    {!! Breadcrumbs::render('report_generator') !!}
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                    <h3 class="box-title"><span class="glyphicon glyphicon-export"></span>&nbsp;&nbsp;Lista de trámites modificados</h3>
            </div>

            <br />
            <div class="box-body">
                    <div class="row">
                         {!! Form::open(['method' => 'POST', 'route' => ['export_updated_list'], 'class' => 'form-horizontal', 'files' => true ]) !!}

                                <div class="col-md-4 col-md-offset-2">
                                    <div class="form-group">
                                        {!! Form::label('year', 'Gestión', ['class' => 'col-md-4 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::select('year', $year_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                            <span class="help-block">Seleccione Gestión</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        {!! Form::label('semester', 'Semestre', ['class' => 'col-md-4 control-label']) !!}
                                        <div class="col-md-6">
                                            {!! Form::select('semester',$semester1_list, null, ['class' => 'combobox form-control', 'required' ]) !!}
                                            <span class="help-block">Seleccione Semestre</span>
                                        </div>
                                    </div>
                                </div>

                            <br>
                            <div class="col-md-12">
                                <div class="row text-center">
                                    <div class="form-group">
                                        <div class="col-md-12">

                                            <button type="submit" class="btn btn-raised btn-success" data-toggle="tooltip" data-placement="bottom" data-original-title="Exportar">&nbsp;<span class="glyphicon glyphicon-export"></span>&nbsp;</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}



                     </div>
           </div>

       </div>
    </div>
</div>


@endsection

@push('scripts')
<script>

    $(document).ready(function(){
       $('.combobox').combobox();
    });

</script>
@endpush
