@extends('layouts.proyectos.popup')

@section('content')

        <div class="panel-body" id="mod_reporte">

            <div class="mod_ad modal fade" tabindex="-1" role="dialog" aria-labelledby="SelAnioModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content form-group col-md-12 ">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-12">
                                    {{ Form::label('proy_nombre', 'Proyecto') }}
                                    <div>
                                        {{ Form::textarea('proy_nombre', null, array('class' => 'form-control reset', 'style'=>'padding-right: 50px;resize: none;height: 100px;', 'readonly'=>1)) }}
                                        <button type="button" class="btn btn btn-info serach" style="float: left;position: absolute;top: 19px;right: 16px;"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-12">
                                    {{ Form::label('comp_nombre', 'Componente') }}
                                    <div>
                                        {{ Form::text('comp_nombre', null, array('class' => 'form-control reset', 'style'=>'padding-right: 50px;', 'readonly'=>1)) }}
                                        <button type="button" class="btn btn btn-info serach" style="float: left;position: absolute;top: 19px;right: 16px;"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                                    {{ Form::label('det_fuente_financiamiento', 'Fuente de Financiamiento') }}
                                    {{ Form::select('det_fuente_financiamiento', [], null, array('class' => 'form-control send reset', 'required'=>1) )}}
                                </div>
                                <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                                    {{ Form::label('det_id_clasif', 'Especifica') }}
                                    {{ Form::select('det_id_clasif', [], null, array('class' => 'form-control send reset', 'required'=>1) )}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            {{ Form::hidden('id', null, array('class' => 'send'))}}
                            {{ Form::hidden('modificatoria_id', null, array('class' => 'send'))}}
                            {{ Form::hidden('componente_id', -1, array('class' => 'send'))}}
                            {{ Form::hidden('_token', csrf_token(), array('class' => 'send'))}}
                            {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning btn_guardar')) }}
                            {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger btn_cancelar')) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="mod_ad_btn">
                <div class="row">
                    <div class="form-group  col-xs-8 col-sm-4 col-lg-4">
                        {{ Form::select('tipo', [
                        'terminado'=>'Obras Terminadas en el Periodo',
                        'paralizado'=>'Obras Paralizadas en el Periodo',
						'ejecucion'=>'Obras en Ejecucion en el Periodo'
                        ], $rep, array('class' => 'form-control change_type', 'required'=>1) )}}
                    </div>
                    <div class="form-group  col-xs-4 col-sm-4 col-lg-4">
                        {{ Form::select('anio', $anios, $anio, array('class' => 'form-control change_type', 'required'=>1) )}}
                    </div>
                    <div class="col-xs-2 col-sm-2 col-lg-1">
                        <button type="button" class="btn btn-danger hidden-print btn_print_general"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-6" style="padding: 0px;">
                <div class="panel panel-default">
                    <div class="panel-heading">POR FUNCION
                        <button type="button" class="btn btn-danger hidden-print btn_print" style="position: absolute;right: 7px;top: 4px;"><i class="glyphicon glyphicon-print"></i> Imprimir</button></div>
                    <div class="panel-body">
                        <div id="list">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pedido-table">
                                    <thead>
                                    <tr class="info">
                                        <th>FUNCION</th>
                                        <th>Nro de Obras</th>
                                        <th>Monto Inversion</th>
                                        <th>Beneficiarios</th>
                                        <th class="hidden-print">Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($totalFuncion as $funcion=>$group)
                                    <tr class="alert-info" role="row">
                                        <td class="sorting_1">{{$funcion}}</td>
                                        <td class="sorting_1">{{$group->count}}</td>
                                        <td class="sorting_2">{{Money::toMoney($group->monto)}}</td>
                                        <td>{{$group->beneficiarios}}</td>
                                        <td class="hidden-print"></td>
                                    </tr>
                                    @endforeach
                                    <tr class="alert-danger" role="row">
                                        <td class="sorting_1">Total</td>
                                        <td class="sorting_1">{{$total->count}}</td>
                                        <td class="sorting_2">{{Money::toMoney($total->monto)}}</td>
                                        <td>{{$total->beneficiarios}}</td>
                                        <td class="hidden-print"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6" style="padding: 0px;">
                <div class="panel panel-default">
                    <div class="panel-heading">POR PROVINCIA
                        <button type="button" class="btn btn-danger hidden-print btn_print" style="position: absolute;right: 7px;top: 4px;"><i class="glyphicon glyphicon-print"></i> Imprimir</button></div>
                    <div class="panel-body">
                        <div id="list">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pedido-table">
                                    <thead>
                                    <tr class="info">
                                        <th>PROVINCIA</th>
                                        <th class="text-right">Nro de Obras</th>
                                        <th class="text-right">Monto Inversion</th>
                                        <th class="text-right">Beneficiarios</th>
                                        <th class="hidden-print">Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($totalProvincia as $provincia=>$group)
                                        <tr class="alert-info" role="row">
                                            <td>{{$provincia}}</td>
                                            <td class="text-right">{{$group->count}}</td>
                                            <td class="text-right">{{Money::toMoney($group->monto)}}</td>
                                            <td class="text-right">{{$group->beneficiarios}}</td>
                                            <td class="hidden-print"></td>
                                        </tr>
                                    @endforeach
                                    <tr class="alert-danger " role="row">
                                        <td>Total</td>
                                        <td>{{$total->count}}</td>
                                        <td class="text-right">{{Money::toMoney($total->monto)}}</td>
                                        <td class="text-right">{{$total->beneficiarios}}</td>
                                        <td class="hidden-print"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12" style="padding: 0px;">
                <div class="panel panel-default">
                    <div class="panel-heading">LISTADO
                        <button type="button" class="btn btn-danger hidden-print btn_print" style="position: absolute;right: 7px;top: 4px;"><i class="glyphicon glyphicon-print"></i> Imprimir</button></div>
                    <div class="panel-body">
                        <div id="list">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pedido-table">
                                    <thead>
                                    <tr class="info">
                                        <th>FUNCION</th>
                                        <th width="30%">DENOMINACION</th>
                                        <th>LOCALIZACION</th>
                                        <th>MODALIDAD</th>
                                        <th>FECHA RECEPCION</th>
                                        <th class="text-right">MONTO INVERSION</th>
                                        <th class="text-right">BENEFICIARIOS</th>
                                        <th>AVANCE</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($listado as $cod=>$registro)
                                        <tr class="alert-info" role="row">
                                            <td>{{$registro->funcion}}</td>
                                            <td>{{sprintf('SNIP: %s SIAF: %s: %s',
                                            $registro->proy_cod_snip,
                                            $registro->proy_cod_siaf,
                                            $registro->proy_nombre)}}</td>
                                            <td>{{$registro->provincia}}</td>
                                            <td>modalidad</td>
                                            <td>{{$registro->aco_programado}}</td>
                                            <td class="text-right">{{Money::toMoney($registro->proy_pip_actualizado, '')}}</td>
                                            <td class="text-right">{{$registro->proy_beneficiarios}}</td>
                                            <td>{{Money::toMoney($registro->avance, '')}} %</td>
                                        </tr>
                                    @endforeach
                                    <tr class="alert-danger" role="row">
                                        <td colspan="3">Total</td>
                                        <td colspan="2">{{$total->count}} Obras</td>
                                        <td class="text-right">{{Money::toMoney($total->monto)}}</td>
                                        <td class="text-right">{{$total->beneficiarios}}</td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

@stop
@push('style')
<style>

    @media print {
        .panel{
            font-size: 0.6em;
        }
        table thead tr th, table tbody tr td {padding: 2px !important;}
    }
</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function () {
        module = $('#mod_reporte');
        module.find('.mod_ad_btn .change_type').change( function() {
            r= '{{route('proyectos.index')}}?option=reporte&rep=%x&anio=%y';
            row = $($(this).closest('.row'));
            console.log(row);
            r = r.replace(/%x/g, row.find('select[name=\'tipo\']').val());
            r = r.replace(/%y/g, row.find('select[name=\'anio\']').val());
            location.href=r
        });

        module.find('.btn_print_general').click(function (event) {
            event.preventDefault();
            var myCallBack = function() {};
            $('#mod_reporte').print({
                deferred: $.Deferred().done(myCallBack)
            });
        })
        module.find('.btn_print').click(function (event) {
            event.preventDefault();
            console.log($(this).parent().parent().parent())
            var myCallBack = function() {};
            $(this).parent().parent().parent().print({
                deferred: $.Deferred().done(myCallBack)
            });

        })
    })
</script>
@endpush