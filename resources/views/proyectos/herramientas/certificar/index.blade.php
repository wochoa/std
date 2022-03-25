@extends('layouts.proyectos.herramientas.tab_certificar')
@section('tabContent')
    <div class="panel-body" id="certificar_module">
        <div id="mod_ad_p_c_i" class="form-group col-md-12 mod_ad" style="display: none">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                        {{ Form::label('solc_certificado', 'Certificacion') }}
                        {{ Form::number('solc_certificado', null, array('class' => 'form-control send reset')) }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                        {{ Form::label('solc_oficina', 'Oficina') }}
                        {{ Form::text('solc_oficina', null , array('class' => 'form-control send reset') )}}
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-lg-4">
                        {{ Form::label('solc_documento', 'Nro Documento') }}
                        {{ Form::text('solc_documento', null, array('class' => 'form-control send reset')) }}
                    </div>
                    <div class="form-group col-xs-6 col-sm-6 col-lg-2">
                        {{ Form::label('solc_fecha', 'Fecha') }}
                        {{ Form::date('solc_fecha', null, array('class' => 'form-control send reset')) }}
                    </div>
                    <div class="form-group col-xs-6 col-sm-6 col-lg-2">
                        {{ Form::label('solc_tipo_gasto', 'Tipo de Gasto') }}
                        {{ Form::select('solc_tipo_gasto', [1=>'Gasto Corriente', 2=>'Gasto de Capital'],null, array('class' => 'form-control send reset')) }}
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                        {{ Form::label('solc_objeto', 'Objeto') }}
                        {{ Form::text('solc_objeto', null , array('class' => 'form-control send reset') )}}
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                        {{ Form::label('solc_tipo_proceso_seleccion', 'Tipo de Seleccion') }}
                        {{ Form::text('solc_tipo_proceso_seleccion', null , array('class' => 'form-control send reset') )}}
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                        {{ Form::label('solc_otros', 'Otros') }}
                        {{ Form::text('solc_otros', null , array('class' => 'form-control send reset') )}}
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                        {{ Form::label('solc_justificacion', 'Justificacion') }}
                        {{ Form::text('solc_justificacion', null , array('class' => 'form-control send reset') )}}
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                        {{ Form::label('solc_doc_priorizacion', 'Doc Priorizacion') }}
                        {{ Form::text('solc_doc_priorizacion', null , array('class' => 'form-control send reset') )}}
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-lg-6">
                        {{ Form::label('solc_id_clasif', 'Especifica') }}
                        {{ Form::select('solc_id_clasif', $especificas,null, array('class' => 'form-control send reset')) }}
                    </div>
                </div>
            </div>
            <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                {{ Form::label('solc_pia', 'PIA') }}
                {{ Form::number('solc_pia', null, array('class' => 'form-control send reset', 'readonly'=>1)) }}
            </div>
            <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                {{ Form::label('solc_pim', 'PIM') }}
                {{ Form::number('solc_pim', null, array('class' => 'form-control send reset', 'readonly'=>1)) }}
            </div>
            <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                {{ Form::label('solc_certificacion', 'Monto Certificado') }}
                {{ Form::number('solc_certificacion', null, array('class' => 'form-control send reset', 'readonly'=>1)) }}
            </div>
            <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                {{ Form::label('solc_saldo_por_certificar', 'Saldo por Certificar') }}
                {{ Form::number('solc_saldo_por_certificar', null, array('class' => 'form-control send reset', 'readonly'=>1)) }}
            </div>
            <div class="form-group col-xs-6 col-sm-3 col-lg-2">
                {{ Form::label('solc_monto_solicitado', 'Monto Solicitado') }}
                {{ Form::number('solc_monto_solicitado', null, array('class' => 'form-control send reset')) }}
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                {{ Form::hidden('id', null, array('class' => 'send'))}}
                {{ Form::hidden('solc_anio', null, array('class' => 'send'))}}
                {{ Form::hidden('solc_act_proy', null, array('class' => 'send'))}}
                {{ Form::hidden('solc_sec_func', null, array('class' => 'send'))}}
                {{ Form::hidden('solc_fuente_financiamiento', null, array('class' => 'send'))}}
                {{ Form::hidden('_token', csrf_token(), array('class' => 'send'))}}
                {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning btn_guardar')) }}
                {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger btn_cancelar')) }}
            </div>
        </div>
        <div id="mod_ad_p_c_i_btn" class="form-group col-md-12 mod_ad_btn">
            <!--{{Form::button('Agregar', array('type' => 'button', 'class' => 'btn btn-primary btn_agregar')) }}-->

        </div>
        <div class="form-group col-md-12 load_table" id="p_c_i_table" style="background-color:#fff"></div>
    </div>
@endsection
@push('scripts')
<script>
    $('#certificar_module').saveModule({
        rList: '{{route('proyectos.herramientas.certificar.index',[$proy,$anio] )}}?listar=1',
        rDelete:'{{route('proyectos.herramientas.certificar.destroy',[$proy,$anio,'%s'])}}',
        rSave:'{{route('proyectos.herramientas.certificar.store',[$proy,$anio] )}}'
    });
</script>
@endpush