<div class="box box-success box-solid">
    <div class="box-header with-border">
        <div class="row">
            <div class="col-md-12">
                <h3 class="box-title"><span class="glyphicon glyphicon-user"></span> {!! $affiliate->getTittleName() !!}</h3>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-responsive" style="width:100%;">
                    <tr>
                        <td style="border-top:0px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Grado</strong>
                                </div>
                                <div class="col-md-6" data-toggle="tooltip" data-placement="bottom" data-original-title="{!! $affiliate->degree->name !!}">
                                    {!! $affiliate->degree->shortened !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Fecha de Ingreso</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! $affiliate->getShortDateEntry() !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table" style="width:100%;">
                    <tr>
                        <td style="border-top:0px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Carnet Identidad</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! $affiliate->city_identity_card_id ? $affiliate->identity_card . ' ' . $affiliate->city_identity_card->shortened : $affiliate->identity_card !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Matrícula</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! $affiliate->registration !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Categoría</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! $affiliate->category->getPercentage() !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
