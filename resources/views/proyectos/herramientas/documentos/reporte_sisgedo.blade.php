@extends('layouts.proyectos.plantilla_proyectos')
@section('content')
<?php use Carbon\Carbon; ?>
    <div class="form-body" id="sisgedo_modulo" style="text-align: center;">
		<div class="form-group col-xs-4 col-sm-4 col-lg-4">
             {{ Form::date('s_fechainicio', ''  , array('class' => 'form-control send verif') )}}
   		</div>
   		<div class="form-group col-xs-4 col-sm-4 col-lg-4">
             {{ Form::date('s_fechafin', ''  , array('class' => 'form-control send verif') )}}
   		</div>
   		<div class="form-group col-xs-4 col-sm-4 col-lg-4">
   			{{ Form::button('Buscar', array('type' => 'button', 'class' => 'btn btn-warning small btn_buscar')) }}
            {{ Form::button('Imprimir', array('type' => 'button', 'class' => 'btn btn-danger small btn_imprimir')) }}
   		</div>
   		<div class="form-group col-xs-12 col-sm-12 col-lg-12" id="table">
             <table class="table table-striped" id="cadenas-table">
                <thead>
                <tr>
                    <th colspan="9">EXP SISGEDO</th>
                </tr>
                </thead>
                <tbody class="rep"></tbody>
            </table>
   		</div>       
    </div>
@endsection
@push('scripts')
<script>
$( document ).ready(function() {
	
});

$("#sisgedo_modulo").on("click",'.btn_buscar',function(event){
  var tbody = $(".rep");
	$.ajax({
    url: "http://www.regionhuanuco.gob.pe/portal/proyectos/json/sisgedo_reporte.php",
		data:{fini:$("[name='s_fechainicio']").val(),ffin:$("[name='s_fechafin']").val()},
		type:"GET",dataType :"json",
		success: function(result){
		if(result.ok)
		{
			$.each(result.exma_id, function(key, value){
          tbody.append('<tr><th colspan="9">'+key+'</th></tr>');
          console.log(value);
          $.each(value.expe_id, function(k, val){
            tbody.append('<tr><td>'+k+'</td><td>'+val.expe_fecha+'</td><td>'+val.texp_descripcion+'-'+val.expe_numero_doc+'-'+val.expe_siglas_doc+'</td><td>'+val.expe_folios+'</td><td>'+val.expe_asunto+'</td><td>'+val.id_usu+'</td><td>'+val.idusu_depe+'</td></tr>');
          });
      });
		}else
		{alert("No se encuentra!");}
	}});
});
</script>
@endpush
