<div class="box box-success box-solid">
    <div class="box-header with-border">
        <div class="row">
            <div class="col-md-12">
                <h3 class="box-title"><span class="glyphicon glyphicon-info-sign"></span> Información Adicional</h3>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-responsive" style="width:100%;">
                    <tr>
                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Semestre</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! $economic_complement->semester !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Gestión</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! $economic_complement->getYear() !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tipo</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! $eco_com_type . "-" . $eco_com_modality !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-responsive" style="width:100%;">
                    <tr>
                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Ciudad</strong>
                                </div>
                                <div class="col-md-6">
                                    {!! $economic_complement->city ? $economic_complement->city->name : '' !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:0px;border-bottom:1px solid #f4f4f4;">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Estado</strong>
                                </div>
                                <div class="col-md-6">
                                    -
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
