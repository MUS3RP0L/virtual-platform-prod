@extends('app')

@section('contentheader_title')

    <div class="row">
        <div class="col-md-10">
            {!! Breadcrumbs::render('affiliates') !!}
        </div>
        <div class="col-md-2 text-right">
            <div data-toggle="tooltip" data-placement="top" data-original-title="Nuevo">
                <a href="" class="btn btn bg-olive" data-toggle="modal" data-target="#myModal-personal">
                    <span class="fa fa-lg fa-plus" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('main-content')
   <form action="{{url('observations')}}" method="POST">
    <input type="text" name="input_text">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <input type="file" name="excel" >
    <button type="summit">enviar</button>
    </form>
    
@endsection