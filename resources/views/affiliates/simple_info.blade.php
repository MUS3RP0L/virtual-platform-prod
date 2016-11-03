<div class="col-md-6">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Información de Afiliado</h3>
                </div>
            </div>
        </div>
        <div class="panel-body" style="font-size: 14px">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-responsive" style="width:100%;">
                        <tr>
                            <td style="border-top:1px solid #d4e4cd;">
                                <div class="row">
                                    <div class="col-md-6">Grado</div>
                                    <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->degree->name !!}">
                                        {!! $affiliate->degree->shortened !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top:1px solid #d4e4cd;border-bottom:1px solid #d4e4cd;">
                                <div class="row">
                                    <div class="col-md-6">Estado</div>
                                    <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->affiliate_state->state_type->name !!}">
                                        {!! $affiliate->affiliate_state->name !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table" style="width:100%;">
                        <tr>
                            <td style="border-top:1px solid #d4e4cd;">
                                <div class="row">
                                    <div class="col-md-6">Carnet Identidad</div>
                                    <div class="col-md-6">
                                        {!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-top:1px solid #d4e4cd;border-bottom:1px solid #d4e4cd;">
                                <div class="row">
                                    <div class="col-md-6">Núm. de Matrícula</div>
                                    <div class="col-md-6">
                                        {!! $affiliate->registration !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
