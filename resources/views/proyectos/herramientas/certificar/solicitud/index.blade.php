@extends('layouts.proyectos.herramientas.tab_documento')
@section('tabContent')
    <div class="panel-body" id="certificar_module">
        <div class="mod_ad modal fade" tabindex="-1" role="dialog" aria-labelledby="SelAnioModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content form-group col-md-12 ">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-xs-6 col-sm-3">
                                {{ Form::label('solc_certificado', 'Certificacion') }}
                                {{ Form::number('solc_certificado', null, array('class' => 'form-control send reset','required'=>1)) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-xs-6 col-sm-6">
                                {{ Form::label('solc_tipo_gasto', 'Tipo de Gasto') }}
                                {{ Form::select('solc_tipo_gasto', [1=>'Gasto Corriente', 2=>'Gasto de Capital'],null, array('class' => 'form-control send reset')) }}
                            </div>
                            <div class="form-group col-xs-12 col-sm-6">
                                {{ Form::label('solc_objeto', 'Objeto') }}
                                {{ Form::text('solc_objeto', null , array('class' => 'form-control send reset') )}}
                            </div>
                            <div class="form-group col-xs-12 col-sm-6">
                                {{ Form::label('solc_tipo_proceso_seleccion', 'Tipo de Seleccion') }}
                                {{ Form::text('solc_tipo_proceso_seleccion', null , array('class' => 'form-control send reset') )}}
                            </div>
                            <div class="form-group col-xs-12 col-sm-6">
                                {{ Form::label('solc_otros', 'Otros') }}
                                {{ Form::text('solc_otros', null , array('class' => 'form-control send reset') )}}
                            </div>
                            <div class="form-group col-xs-12 col-sm-6">
                                {{ Form::label('solc_justificacion', 'Justificacion') }}
                                {{ Form::text('solc_justificacion', null , array('class' => 'form-control send reset') )}}
                            </div>
                            <div class="form-group col-xs-12 col-sm-6">
                                {{ Form::label('solc_doc_priorizacion', 'Doc Priorizacion') }}
                                {{ Form::text('solc_doc_priorizacion', null , array('class' => 'form-control send reset') )}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12">
                {{ Form::hidden('id', null, array('class' => 'send'))}}
                {{ Form::hidden('documento_id', $doc, array('class' => 'send'))}}
                {{ Form::hidden('_token', csrf_token(), array('class' => 'send'))}}
                {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning btn_guardar')) }}
                {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger btn_cancelar')) }}
            </div>
                </div>
            </div>
        </div>
        <div class="form-group col-md-12 mod_ad_btn">
        {{Form::button('Agregar', array('type' => 'button', 'class' => 'btn btn-primary btn_agregar')) }}

        </div>
        <div class="col-md-12 load_table" id="p_c_i_table" style="background-color:#fff"></div>
    </div>
@endsection
@push('scripts')
<script>
    $('#certificar_module').saveModule({
        rList: '{{route('proyectos.herramientas.certificar.solicitud.index',[$anio,$doc] )}}?listar=1',
        rDelete:'{{route('proyectos.herramientas.certificar.solicitud.destroy',[$anio,$doc,'%s'])}}',
        rSave:'{{route('proyectos.herramientas.certificar.solicitud.store',[$anio,$doc] )}}',
        rPrint:'{{route('proyectos.herramientas.certificar.print',[$doc,'%s'] )}}',
        token:'{{csrf_token()}}'
    });
</script>
@endpush