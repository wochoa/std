@extends('layouts.proyectos.plantilla_proyectos')
@section('content')
    <div class="form-body" id="cnt_modulo" style="text-align: center;">
        <div class="row">

            <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                {{ Form::label('cnt_nombre', 'NOMBRE') }}
                {{ Form::text('cnt_nombre', '', array('class' => 'form-control send verif', 'placeholder' => 'contrato') )}}
            </div>

            <div class="form-group col-xs-4 col-sm-4 col-lg-4">
                    {{ Form::label('cnt_dni', 'DNI') }}
                    {{ Form::text('cnt_dni', '', array('class' => 'form-control send verif', 'placeholder' => 'contrato') )}}
            </div>

            <div class="form-group col-xs-8 col-sm-8 col-lg-8">
                    {{ Form::label('cnt_direccion', 'DIRECCION') }}
                    {{ Form::text('cnt_direccion', '', array('class' => 'form-control send verif', 'placeholder' => 'contrato') )}}
            </div>

            <div class="form-group col-xs-6 col-sm-6 col-lg-6">
                    {{ Form::label('cnt_cargo', 'CARGO') }}
                    {{ Form::select('cnt_cargo',[''=>'SELECCIONE', '9'=>'ASISTENTE TECNICO DE INSPECTOR', '10'=>'ASISTENTE TECNICO DE RESIDENTE', '11'=>'AUXILIAR ADMINISTRATIVO', '12'=>'ING CIVIL DE CAMPO'], '', array('class' => 'form-control send verif') )}}
                    {{ Form::hidden('cnt_cargo_txt', null, array('class' => 'send') )}}
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-lg-3">
                {{ Form::label('cnt_finicio', 'INICIO') }}
                {{ Form::date('cnt_finicio', ''  , array('class' => 'form-control send verif') )}}
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-lg-3">
                {{ Form::label('cnt_ffin', 'FIN') }}
                {{ Form::date('cnt_ffin', ''  , array('class' => 'form-control send verif') )}}
            </div>

            <div class="form-group col-xs-1 col-sm-1 col-lg-1">
            {{ Form::label('cnt_proced', 'OFICINA') }}<br>
             {{ Form::text('cnt_procednro', '47', array('class' => 'form-control') )}}
            </div>

            <div class="form-group col-xs-8 col-sm-8 col-lg-8"><br>
             {{ Form::select('cnt_proced', [''=>'OFICINA'], null, array('class' => 'form-control send') )}}
             {{ Form::hidden('cnt_proced_nombre', null, array('class' => 'form-control send') )}}
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-lg-3">
                {{ Form::label('cnt_expe_sisgedo', 'EXP SISGEDO') }}
                {{ Form::number('cnt_expe_sisgedo', '', array('class' => 'form-control send verif reset')) }}
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-lg-3">
               {{ Form::label('cnt_ref1', 'REF1') }}
               {{ Form::select('cnt_ref1', [''=>'SELECCIONE'], null, array('class' => 'form-control send ref') )}}
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-lg-3">
               {{ Form::label('cnt_ref2', 'REF2') }}
               {{ Form::select('cnt_ref2', [''=>'SELECCIONE'], null, array('class' => 'form-control send ref') )}}
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-lg-3">
               {{ Form::label('cnt_ref3', 'REF3') }}
               {{ Form::select('cnt_ref3', [''=>'SELECCIONE'], null, array('class' => 'form-control send ref') )}}
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-lg-3">
               {{ Form::label('cnt_ref4', 'REF4') }}
               {{ Form::select('cnt_ref4', [''=>'SELECCIONE'], null, array('class' => 'form-control send ref') )}}
            </div>

            <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                    {{ Form::label('cnt_obra', 'OBRA') }}
                    {{ Form::textarea('cnt_obra', null, array('class' => 'form-control send', 'size' => '30x2') )}}
                    {{ Form::hidden('cnt_idobra', null, array('class' => 'send') )}}
            </div>

            <div class="form-group col-xs-4 col-sm-4 col-lg-4">
               {{ Form::label('cnt_meta', 'META') }}
               {{ Form::select('cnt_meta', [''=>'SELECCIONE'], null, array('class' => 'form-control send') )}}
            </div>

            <div class="form-group col-xs-4 col-sm-4 col-lg-4">
                {{ Form::label('cnt_ff', 'FUENTE DE FINANCIAMIENTO') }}
                {{ Form::select('cnt_ff', [''=>'SELECCIONE'], null,array('class' => 'form-control send') )}}
            </div>

            <div class="form-group col-xs-4 col-sm-4 col-lg-4">
                {{ Form::label('cnt_especifica', 'ESPECIFICA') }}
                {{ Form::select('cnt_especifica', [''=>'SELECCIONE'], null, array('class' => 'form-control send') )}}
            </div>

            <div class="form-group col-xs-9 col-sm-9 col-lg-9">
                {{ Form::label('cnt_cfp', 'CADENA FUNCIONAL') }}
                {{ Form::text('cnt_cfp', '' , array('class' => 'form-control send verif') )}}
            </div>

            <div class="form-group col-xs-3 col-sm-3 col-lg-3">
                {{ Form::label('cnt_monto', 'MONTO') }}
                {{ Form::text('cnt_monto', '', array('class' => 'form-control send verif reset')) }}
            </div>

            <div class="form-group col-xs-12 col-sm-12 col-lg-12">
                {{ Form::button('Guardar', array('type' => 'button', 'class' => 'btn btn-warning large btn_guardar')) }}
                {{ Form::button('Cancelar', array('type' => 'button', 'class' => 'btn btn-danger btn_cancelar')) }}
            </div>
        </div>

    </div>
    <div id='Find_Obra' class="mod_ad modal fade" tabindex="-1" role="dialog" aria-labelledby="datatable">
        <div class="modal-dialog modal-lg" role="document">
            <div id="datatable" class="modal-content form-group col-md-12 ">

            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>

    function zeroFill( number, width ){
        width -= number.toString().length;
        if ( width > 0 )
        {
            return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
        }
        return number + ""; // always return a string
    }
    
    function checkCampos(obj) {
        var camposRellenados = true;
        obj.find(".verif").each(function() {
        var $this = $(this);
                if( $this.val().length <= 0 ) {
                    camposRellenados = false;
                    return false;
                    
                }
        });
        if(camposRellenados == false) {
            return false;
        }
        else {
            return true;
        }
    }
    function Loadff(lnk,data,element,compare){
        $.get(
        lnk,
        data,
        function(e){
            element.empty();
            element.append('<option value="">SELECCIONE</option>');
            console.log($.parseJSON(e));
            $.each($.parseJSON(e), function(key, value){

                if(value.FUENTE_FIN == compare){
                    element.append('<option value="'+value.FUENTE_FIN+'" selected="selected">'+value.FUENTE_FIN+'</option>');
                }else{
                    element.append('<option value="'+value.FUENTE_FIN+'">'+value.FUENTE_FIN+'</option>');
                }
            }); 
        });
        
    }
    function Loadespecifica(lnk,data,element,compare){
        $.get(
        lnk,
        data,
        function(e){
            element.empty();
            element.append('<option value="">SELECCIONE</option>');
            $.each($.parseJSON(e), function(key, value){
                if(value.ESPECIFICA == compare){
                    element.append('<option value="'+value.ESPECIFICA+'" selected="selected">'+value.ESPECIFICA+'</option>');
                }else{
                    element.append('<option value="'+value.ESPECIFICA+'">'+value.ESPECIFICA+'</option>');
                }
            }); 
        });
        
    }
    function Loadmeta(lnk,data,element,compare=""){
        $.get(
        lnk,
        data,
        function(e){
            element.empty();
            element.append('<option value="">SELECCIONE</option>');
            $.each($.parseJSON(e), function(key, value){
                m = zeroFill(value.SEC_FUNC,4) + " - " + value.COMPONENTE_NOMBRE
                if(m == compare){
                    element.append('<option value="'+m+'" data-data="'+value.SEC_FUNC+'" selected="selected">'+m+'</option>');
                }else{
                    element.append('<option value="'+m+'" data-data="'+value.SEC_FUNC+'">'+m+'</option>');
                }
            }); 
        }); 
    }
    function Loadcf(lnk,data,element){
        $.get(
        lnk,
        data,
        function(e){
            element.empty();
            element.val(e);

        });   
    }
    function Loadoficinas(lnk,data,element,compare=""){
        $.ajax({
            url: lnk, 
            data:data,
            type:"GET",
            dataType :"json", 
            success: function(result){
            if(result.ok)
            {
                element.empty();
                $.each(result.depes, function(key, val){
                    if(val.depe_id == compare){
                        element.append('<option value="'+val.depe_id+'" selected="selected">'+val.depe_nombre+'</option>');
                        $("[name='cnt_proced_nombre']").val(val.depe_nombre);
                    }else{
                        element.append('<option value="'+val.depe_id+'">'+val.depe_nombre+'</option>');
                    }
                });
            }else
            {alert("No se encuentra!");}
        }});
    }

    $( document ).ready(function() {
        Loadoficinas(
            "http://www.regionhuanuco.gob.pe/portal/proyectos/json/sisgedo_request.php",
            {depe:'3'},
            $("[name='cnt_proced']"),
            '47'
            );
    });

    $("#cnt_expe_sisgedo").on("focusout",function(event){event.preventDefault();
        $.ajax({url: "http://www.regionhuanuco.gob.pe/portal/proyectos/json/sisgedo_request.php",
            data:{exp:$(this).val(),order:'DESC'},type:"GET",dataType :"json", success: function(result){
            if(result.ok)
            {
                ref = ""
                var cnt_ref = $(".ref");
                cnt_ref.empty();
                cnt_ref.append('<option value="">SELECCIONE</option>');
                $.each(result.docs, function(key, val){
                    ref =val.texp_descripcion+" Nº "+zeroFill(val.expe_numero_doc,5)+"-"+val.expe_fecha_doc.split('-')[0]+"-"+val.expe_siglas_doc;
                    cnt_ref.append('<option value="'+ref+'">'+ref+'</option>');
                });
            }else{
                $("#cnt_expe_sisgedo").val('');
                $("#cnt_expe_sisgedo").focus();
                $(".ref").empty();
            }
        }});
    });

    $("#cnt_modulo").on("focus",'#cnt_obra',function(event){
        $('#Find_Obra').modal();
        $.get("{{route('proyectos.herramientas.documento.buscar')}}", function(e){
            $('#datatable').html(e)
        });
    });

    $('#datatable').on("click",'.return',function(event){event.preventDefault();
        
        Loadmeta(
            "{{route('proyectos.herramientas.documento.buscarMeta',[$anio])}}",
            $(this).data('data'),
            $("[name='cnt_meta']")
        );
        $("[name='cnt_obra']").val($(this).data('data').proy_nombre);
        $("[name='cnt_idobra']").val($(this).data('data').proy_cod_siaf);
        $('#Find_Obra').modal('toggle');

    });

    $("#cnt_modulo").on("change",'#cnt_meta',function(event){
        Loadff(
            "{{route('proyectos.herramientas.documento.buscarFf', [$anio])}}",
            {sec_func :$(this).find('option:selected').data('data')},
            $("[name='cnt_ff']")
        );
        Loadespecifica(
            "{{route('proyectos.herramientas.documento.buscarEsp', [$anio])}}",
            {sec_func :$(this).find('option:selected').data('data')},
            $("[name='cnt_especifica']")
        );
        Loadcf(
            "{{route('proyectos.herramientas.documento.buscarCf',[$anio])}}",
            {sec_func :$(this).find('option:selected').data('data')},
            $("[name='cnt_cfp']")
        );

    }); 

    $("#cnt_modulo").on("click",'.btn_guardar',function(event){
        form = $('.send');
            var formvalidation = $("#cnt_modulo");
            var check = checkCampos(formvalidation);
            if(check) {
               var id;
                $.ajax({
                    url: "{{route('proyectos.herramientas.documento.savecnt')}}",
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(e){
                        if(e.ok){
                           location.reload();
                    }else{
                        alert('Ups! algo salio mal')
                    }
                    }
                });
            }
            else {
                alert('NECESITA COMPLETAR TODOS LOS CAMPOS')
            }
    });

    $("[name='cnt_procednro']").on("focusout",function(event){event.preventDefault();
        var dato = $(this).val();
        $("[name='cnt_proced'] option[value='"+dato+"']").prop('selected', true);
        $("[name='cnt_proced_nombre']").val($("[name='cnt_proced'] option[value='"+dato+"']").text());
    });

    $("[name='cnt_procednro']").on("focus",function(event){event.preventDefault();
        $(this).val('');
    });

    $("[name='cnt_proced']").on("change",function(event){event.preventDefault();
        $("[name='cnt_procednro']").val($(this).val());
        $("[name='cnt_proced_nombre']").val($("[name='cnt_proced'] option:selected").text());
    });

    $("[name='cnt_cargo']").change(function() {
        $("[name='cnt_cargo_txt']").val($("[name='cnt_cargo'] option:selected").text());
    });

    $("#cnt_modulo").on("click",'.btn_cancelar',function(event){
       
    });
</script>
@endpush