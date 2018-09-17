<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>MUSERPOL</title>
    {!! Html::style('bower_components/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('bower_components/Ionicons/css/ionicons.min.css') !!}
    {!! Html::style('css/AdminLTE.css') !!}
    @if(env('MIX_APP') == 'test')
        {!! Html::style('css/skins/skin-green-test.css') !!}
    @elseif(env('MIX_APP') == 'dev')
        {!! Html::style('css/skins/skin-green-dev.css') !!}
    @elseif(env('MIX_APP') == 'prod')
        {!! Html::style('css/skins/skin-green.css') !!}
    @endif
    {!! Html::style('plugins/iCheck/square/green.css') !!}
    {!! Html::style('bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('bower_components/bootstrap-material-design/dist/css/bootstrap-material-design.min.css') !!}
    {!! Html::style('bower_components/bootstrap-material-design/dist/css/ripples.min.css') !!}
    {!! Html::style('bower_components/data-tables/media/css/dataTables.bootstrap.min.css') !!}
    {!! Html::style('bower_components/bootstrap-combobox/css/bootstrap-combobox.css') !!}
    {!! Html::style('bower_components/datePicker/css/bootstrap-datepicker3.css') !!}
    {!! Html::style('vendor/selectize/dist/css/selectize.css') !!}
    {!! Html::style('css/print.css') !!}
</head>
