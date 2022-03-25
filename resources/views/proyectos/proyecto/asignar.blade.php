<style>td {padding: 0px 8px !important;}</style>
<div class="panel panel-info">
    <div class="panel-heading text-center">
        <h3 class="panel-title">Presupuesto Analitico<a class="pull-right"><i class="glyphicon glyphicon-chevron-up"></i></a></h3>
    </div>
    <div id="analitico_content" class="panel-body">
        <div class="form-group col-md-12 mod_ad" style="display: none">
            <div class="form-groupcol-xs-12 col-sm-12 col-lg-6">
                {{ Form::label('asig_componente', 'Componente') }}
                {{ Form::select('asig_componente', $componentes, null , array('class' => 'form-control send reset', 'data-def'=>'<option value="%s" class="remove">%s - COMPONENTE DESHABILITADO</option>') )}}
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-6">
                {{ Form::label('asig_oficina', 'Oficina') }}
                {{ Form::select('asig_oficina', $oficinas, null , array('class' => 'form-control send reset') )}}
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-6">
                {{ Form::label('asig_anio', 'Año') }}
                {{ Form::select('asig_anio', $anios, null , array('class' => 'form-control send reset') )}}
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                {{Form::hidden('asig_act_proy', $proyecto->proy_cod_siaf, array('class' => 'send'))}}
                {{Form::hidden('analitico_id', null, array('class' => 'send'))}}
                {{Form::hidden('_token', csrf_token(), array('class' => 'send'))}}
                {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning btn_guardar')) }}
                {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger btn_cancelar')) }}
            </div>
        </div>
        <div class="form-group col-md-12 mod_ad_btn">
            {{Form::button('Agregar', array('type' => 'button', 'class' => 'btn btn-primary btn_agregar')) }}
        </div>
        <div class="form-group col-md-12 load_table" style="background-color:#fff"></div>
    </div>
</div>
@push('scripts')
<script>
    modulo = $('#analitico_content').saveModule({
        id: '[name=\'analitico_id\']',
        rList: '{{route('proyectos.{act_proy}.analitico.index',$proyecto->proy_cod_siaf )}}',
        rDelete: '{{route('proyectos.{act_proy}.analitico.destroy',[$proyecto->proy_cod_siaf,'%s'])}}',
        rSave:'{{route('proyectos.{act_proy}.analitico.store',$proyecto->proy_cod_siaf )}}',
        requiredFields:['ana_componente','ana_monto'],
        modal:false
    });
</script>
@endpush