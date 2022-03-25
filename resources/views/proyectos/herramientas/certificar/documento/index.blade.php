@extends('layouts.proyectos.herramientas.tab_documento')
@section('tabContent')
    <div class="panel-body" id="certificar_module">
        <div class="mod_ad modal fade" tabindex="-1" role="dialog" aria-labelledby="SelAnioModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content form-group col-md-12 ">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-xs-6 col-sm-4">
                                {{ Form::label('doc_reg_sisgedo', 'Reg SISGEDO') }}
                                <div>
                                {{ Form::number('doc_reg_sisgedo', null, array('class' => 'form-control send reset', 'style'=>'padding-right: 50px;','required'=>1)) }}
                                    <button type="button" class="btn btn btn-info" id="serach_doc" style="float: left;position: absolute;top: 19px;right: 16px;"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-6">
                                {{ Form::label('doc_oficina', 'Oficina') }}
                                {{ Form::text('doc_oficina', null , array('class' => 'form-control send reset','required'=>1) )}}
                            </div>
                            <div class="form-group col-xs-12 col-sm-6">
                                {{ Form::label('doc_documento', 'Nro Documento') }}
                                {{ Form::text('doc_documento', null, array('class' => 'form-control send reset','required'=>1)) }}
                            </div>
                            <div class="form-group col-xs-6 col-sm-6">
                                {{ Form::label('doc_fecha', 'Fecha') }}
                                {{ Form::date('doc_fecha', null, array('class' => 'form-control send reset')) }}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-xs-12 col-sm-12">
                        {{ Form::hidden('id', null, array('class' => 'send'))}}
                        {{ Form::hidden('doc_exp_sisgedo', null, array('class' => 'send'))}}
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
    function zeroFill( number, width )
    {
        width -= number.toString().length;
        if ( width > 0 )
        {
            return new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
        }
        return number + ""; // always return a string
    }

    $('#certificar_module').saveModule({
        rList: '{{route('proyectos.herramientas.{anio}.certificar.index',[$anio] )}}?listar=1',
        rDelete:'{{route('proyectos.herramientas.{anio}.certificar.destroy',[$anio,'%s'])}}',
        rSave:'{{route('proyectos.herramientas.{anio}.certificar.store',[$anio] )}}',
        token:'{{csrf_token()}}'
    });
    $("#serach_doc").on("click",function(event){event.preventDefault();
        $.ajax({url: "http://www.regionhuanuco.gob.pe/portal/proyectos/json/sisgedo_request.php",
            data:{doc:$(this).prev().val()},type:"GET",dataType :"json", success: function(result){
            if(result.ok)
            {
                $("#doc_documento").val(result.texp_descripcion+" N "+zeroFill(result.expe_numero_doc,5)+" "+result.expe_siglas_doc)
                //$("#doc_documento").val(result.exma_id)
                $("#doc_oficina").val(result.depe_nombre)
                $("#doc_fecha").val(result.expe_fecha_doc)
            }else
            {alert("No se encuentra el documento!");}
        }});
    });

</script>
@endpush