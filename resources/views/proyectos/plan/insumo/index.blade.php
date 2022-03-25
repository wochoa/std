@extends('layouts.proyectos.plantilla_proyectos')

@section('content')
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="{!! route('proyectos.edit',['id'=>$proyecto->idproy_proyecto]) !!}">Editar proyecto</a></li>
    <li role="presentation"><a>Gastos</a></li>
    <li role="presentation"><a href="{{route('proyectos.{proy}.plan.componente.index',$proyecto->idproy_proyecto )}}">Componentes Tareas</a></li>
    <li role="presentation" class="active"><a>Programar</a></li>
</ul>
<div class="panel panel-default">
    <div class="panel-body">
        <div id="mod_ad_p_c_i" class="form-group col-md-12" style="display: none">
            <div class="form-group col-xs-12 col-sm-6 col-lg-3">
                {{ Form::label('componente_id', 'Componente') }}
                {{ Form::select('componente_id', $componentes, null , array('class' => 'form-control p_c_i p_c_i_reset') )}}
            </div>
            <div class="form-group col-xs-12 col-sm-6 col-lg-5">
                {{ Form::label('insu_nombre', 'Nombre Insumo') }}
                {{ Form::text('insu_nombre', null , array('class' => 'form-control p_c_i p_c_i_reset') )}}
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                {{ Form::label('insu_unidad_medida', 'U M') }}
                {{ Form::text('insu_unidad_medida', null, array('class' => 'form-control p_c_i p_c_i_reset')) }}
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-lg-2">
                {{ Form::label('insu_cantidad', 'cantidad') }}
                {{ Form::number('insu_cantidad', null, array('class' => 'form-control p_c_i p_c_i_reset')) }}
            </div>
            <div class="form-group col-xs-6 col-sm-4 col-lg-3">
                {{ Form::label('insu_id_clasifi', 'Especificas') }}
                {{ Form::select('insu_id_clasifi', $espeficicas, null , array('class' => 'form-control p_c_i p_c_i_reset') )}}
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                {{Form::hidden('id', null, array('class' => 'p_c_i'))}}
                {{Form::hidden('_token', csrf_token(), array('class' => 'p_c_i'))}}
                {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning', 'id' =>'btn_guardar_p_c_i')) }}
                {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger', 'id' =>'btn_cancelar_p_c_i')) }}
            </div>
        </div>

        <div id="mod_ad_p_c_i_btn" class="form-group col-md-12">
            {{Form::button('Agregar', array('type' => 'button', 'class' => 'btn btn-primary', 'id' =>'btn_agregar_p_c_i')) }}

            @foreach($anios as $anio)
                <a href="#" class="btn btn-info">Programar {{$anio}}</a>
            @endforeach
        </div>
        <div class="form-group col-md-12" id="p_c_i_table" style="background-color:#fff"></div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function() {

        ruta_componente = '{{route('proyectos.plan.insumo.list',$proyecto->proy_cod_siaf )}}'
        $("#p_c_i_table").load(ruta_componente);
        $("#btn_agregar_p_c_i").on("click", function(){

            $(".p_c_i_reset").each(function(){
                if($(this).prop("type")!="radio")$(this).val("");
            });
            $("[name='id']").val(-1);
            $("#mod_ad_p_c_i").slideDown(400);
            $("#mod_ad_p_c_i_btn").slideUp(400);
        });

        $("#p_c_i_table").on('click', '.edit_p_c_i', function(event){ event.preventDefault();
            var dato=$(this).data('data');
            $.each(dato,function(i,d){
                if($("[name="+i+"]").prop("type")!="radio")
                    $('[name="'+i+'"]').val(d);
                else{
                    $('#'+i+'_'+d).attr('checked', true);
                }
            })
            $("#mod_ad_p_c_i").slideDown(400);
            $("#mod_ad_p_c_i_btn").slideUp(400);
        });
        $("#p_c_i_table").on('click', '.delete_p_c_i', function(event){ event.preventDefault();
            este=this;
            if(confirm("¿Seguro que quiere eliminar este Registro?")){
                $.ajax({
                    type: "DELETE",
                    url: "{{route('proyectos.{proy}.plan.componente.destroy',[$proyecto->idproy_proyecto,'%s'])}}".replace(/%s/g, $(este).data('id')),
                    data:{'_token':'{{csrf_token()}}'},
                    dataType :'json',
                    success: function(d)
                    {
                        if(d.ok)
                        {
                            $("#p_c_i_table").load(ruta_componente);
                        }
                    },
                    error:function(d){
                        console.log(d);
                    }
                });
            }
        })


        $("#btn_cancelar_p_c_i").on("click", function(){
            $("#mod_ad_p_c_i").slideUp(400);
            $("#mod_ad_p_c_i_btn").slideDown(400);
        });
        $("#btn_guardar_p_c_i").on("click", function(){
            if($("#ana_componente").val()!=""&& $('#ana_monto').val()!="")
            {
                var dato = $(".p_c_i")
                var cont = 0;
                var envio = {};
                while(cont<dato.length){
                    if($("[name="+dato[cont].name+"]").prop("type")!="radio")
                        envio[dato[cont].name]=$("[name="+dato[cont].name+"]").val();
                    else
                        envio[dato[cont].name]=$("[name="+dato[cont].name+"]:checked").val();
                    cont++;
                }
                console.log((envio));
                $.ajax(
                    {
                        type: "POST",
                        url: "{{route('proyectos.{proy}.plan.insumo.store',$proyecto->idproy_proyecto )}}",
                        data: envio,
                        dataType :'json',
                        success: function(d)
                        {
                            if(d.ok)
                            {
                                $("#mod_ad_p_c_i").slideUp(400);
                                $("#mod_ad_p_c_i_btn").slideDown(400);
                                $("#p_c_i_table").load(ruta_componente);
                            }
                            else
                                $.fallr('show',{content:'<p>'+d.msg+'</p>',position:'center',icon:'warning'});
                        },
                        error:function(d){
                            console.log(d);
                        }
                    });
            }else alert('El campo Componente y Monto son requeridos');
        });
    });
</script>
@endpush