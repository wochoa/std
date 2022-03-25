@extends('layouts.proyectos.tab_edit')

@section('tabContent')
        <div id="analitico_content" class="panel-body">
            <div class="mod_ad modal fade" tabindex="-1" role="dialog" aria-labelledby="SelAnioModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content form-group col-md-12 ">
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_programa', 'Programa') }}
                            {{ Form::select('comp_programa', $programas, null , array('class' => 'form-control send  reset') )}}
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_prod_proy', 'Prod / Proy') }}
                            {{ Form::text('comp_prod_proy', $proyecto->proy_cod_siaf, array('class' => 'form-control send','readonly'=>true)) }}
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_act_al_obra', 'Act / Al / Obra') }}
                            {{ Form::text('comp_act_al_obra', null, array('class' => 'form-control send')) }}
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_funcion', 'Funcion') }}
                            {{ Form::select('comp_funcion', $funciones_plan, null , array('class' => 'form-control send  reset') )}}
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_division_funcional', 'Division Funcional') }}
                            {{ Form::select('comp_division_funcional', $divisiones_funcionales, null , array('class' => 'form-control send  reset') )}}
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_grupo_funcional', 'Grupo Funcional') }}
                            {{ Form::select('comp_grupo_funcional', $grupos_funcionales, null , array('class' => 'form-control send  reset') )}}
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_meta', 'Meta') }}
                            {{ Form::text('comp_meta', null, array('class' => 'form-control send')) }}
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_finalidad', 'Finalidad') }}
                            {{ Form::text('comp_finalidad', null, array('class' => 'form-control send')) }}
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            {{ Form::label('comp_monto', 'Monto Total') }}
                            {{ Form::number('comp_monto', null, array('step'=>'any', 'class' => 'form-control send  reset')) }}
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            {{ Form::label('comp_nombre', 'Descripcion') }}
                            {{ Form::text('comp_nombre', null, array('class' => 'form-control send  reset')) }}
                        </div>
                        <div class="form-group col-xs-12 col-sm-12">
                            {{Form::hidden('id', null, array('class' => 'send'))}}
                            {{Form::hidden('_token', csrf_token(), array('class' => 'send'))}}
                            {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning btn_guardar')) }}
                            {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger btn_cancelar')) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12 mod_ad_btn">
                {{Form::button('Agregar', array('type' => 'button', 'class' => 'btn btn-primary btn_agregar')) }}
            </div>
            <div class="form-group col-md-12 load_table" style="background-color:#fff"></div>
        </div>
@endsection
@push('style')
<style>
    #analitico_content .mod_ad #comp_programa optgroup[label='Inactivo']{background-color: #ff3e3e;}
</style>
@endpush
@push('scripts')
<script>
    $('#analitico_content').saveModule({
        rList: '{{route('proyectos.plan.componente.list',$proyecto->proy_cod_siaf )}}',
        rDelete: '{{route('proyectos.{proy}.plan.componente.destroy',[$proyecto->idproy_proyecto,'%s'])}}',
        rSave:'{{route('proyectos.{proy}.plan.componente.store',$proyecto->idproy_proyecto )}}',
        token:'{{csrf_token()}}'
    });
</script>
@endpush