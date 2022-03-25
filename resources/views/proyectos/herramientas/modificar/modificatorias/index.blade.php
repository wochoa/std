@extends('layouts.proyectos.herramientas.tab_modificar')
@section('titulo'){{ 'Listado de Modificatorias'}}@endsection
@section('tabContent')
    <div class="panel-body" id="modificar_module">
        <div class="mod_ad modal fade" tabindex="-1" role="dialog" aria-labelledby="SelAnioModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content form-group col-md-12 ">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-6">
                                {{ Form::label('modif_titulo', 'Titulo') }}
                                {{ Form::text('modif_titulo', null , array('class' => 'form-control send reset') )}}
                            </div>
                            <div class="form-group col-xs-6 col-sm-6">
                                {{ Form::label('modif_fecha_aprovacion', 'Fecha') }}
                                {{ Form::date('modif_fecha_aprovacion', null, array('class' => 'form-control send reset')) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                        {{ Form::hidden('id', null, array('class' => 'send'))}}
                        {{ Form::hidden('_token', csrf_token(), array('class' => 'send'))}}
                        {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning btn_guardar')) }}
                        {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger btn_cancelar')) }}
                    </div>
                </div>
            </div>
        </div>
        <div id="mod_ad_p_c_i_btn" class="form-group col-md-12 mod_ad_btn">
        {{Form::button('Agregar', array('type' => 'button', 'class' => 'btn btn-primary btn_agregar')) }}

        </div>
        <div class="col-md-12 load_table" id="p_c_i_table" style="background-color:#fff"></div>
    </div>
@endsection
@push('scripts')
<script>
    $('#modificar_module').saveModule({
        rList:'{{route('proyectos.herramientas.{anio}.modificar.index',[$anio] )}}?listar=1',
        rDelete:'{{route('proyectos.herramientas.{anio}.modificar.destroy',[$anio,'%s'])}}',
        rSave:'{{route('proyectos.herramientas.{anio}.modificar.store',[$anio] )}}',
        token:'{{csrf_token()}}'
    });
</script>
@endpush