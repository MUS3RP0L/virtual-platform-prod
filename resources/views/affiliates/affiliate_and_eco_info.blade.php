<style>
    td:not(:last-child) { border-right:2px solid #DDD;border-bottom:1px solid red;}
</style>
<div class="box box-success box-solid">
    <div class="box-header with-border">
        <div class="row">
            <div class="col-md-12">
                <h3 class="box-title"><span class="glyphicon glyphicon-user"></span> <span data-toggle="tooltip" data-placement="top" data-original-title="Ir al Afiliado">Afiliado: <a href="{{ url('affiliate', $affiliate->id) }}">{!! $affiliate->getTittleName() !!} </a>
                </span></h3>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive" style="width:100%;">
                    <thead>
                        <tr>
                            <th>CI</th>
                            <th>NUA/CUA</th>
                            <th>Grado</th>
                            <th>Categoría</th>  
                            <th>Gestión</th>
                            <th>Semestre</th>
                            <th>Ciudad</th>
                            <th>Modalidad</th>
                            <th>Tipo de Recepción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom:1px solid red ">
                            <td>{!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card->first_shortened ?? '' !!}</td>
                            <td>{!! $affiliate->nua ?? '-' !!}</td>
                            <td><span data-toggle="tooltip" data-placement="top" data-original-title="{!! $affiliate->degree->name !!}">{!! $affiliate->degree->shortened ?? '-' !!}</span></td>
                            <td>{!! $affiliate->category->getPercentage() !!}</td>
                            <td>{!! $economic_complement->getYear() ?? '-' !!}</td>
                            <td>{!! $economic_complement->semester !!}</td>
                            <td>{!! $economic_complement->city ? $economic_complement->city->name : '-' !!}</td>
                            <td>{!! $eco_com_type . " - " . $eco_com_modality !!}</td>
                            <td>{{ $economic_complement->reception_type ?? '-'  }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
