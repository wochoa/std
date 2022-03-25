@extends('layouts.proyectos.plantilla_proyectos')
@section('content')
<?php use Carbon\Carbon;
    $tipo = array();
    foreach ($asunto as $key => $value) {
      $tipo[$value->id] = $value->tda_nombre;
    }
?>
    <div class="form-body" id="reporte_modulo" style="text-align: center;">
      <div class="form-group col-xs-3 col-sm-3 col-lg-3">
             {{ Form::select('rep_tipo', $tipo , '14' , array('class' => 'form-control send verif') )}}
      </div>
		  <div class="form-group col-xs-3 col-sm-3 col-lg-3">
             {{ Form::date('rep_fechainicio', ''  , array('class' => 'form-control send verif') )}}
   		</div>
   		<div class="form-group col-xs-3 col-sm-3 col-lg-3">
             {{ Form::date('rep_fechafin', ''  , array('class' => 'form-control send verif') )}}
   		</div>
   		<div class="form-group col-xs-2 col-sm-2 col-lg-2">
   			{{ Form::button('Buscar', array('type' => 'button', 'class' => 'btn btn-warning small btn_buscar')) }}
   		</div>
   		<div class="form-group col-xs-12 col-sm-12 col-lg-12" id="table">
             <table class="table table-striped" id="cadenas-table">
                <thead>
                <tr>
                    <th width="10%">EXP SISGEDO</th>
                    <th width="50%">PROYECTO</th>
                    <th width="10%">META</th>
                    <th width="10%"width=>ESPECIFICA</th>
                    <th width="10%">FECHA</th>
                    <th width="10%">MONTO</th>
                </tr>
                </thead>
                <tbody class="rep"></tbody>
            </table>
   		</div>       
    </div>
@endsection
@push('scripts')
<script>
  $("#reporte_modulo").on("click",'.btn_buscar',function(event){
        table=$('#cadenas-table');
        table.DataTable({
            processing: true,
            serverSide: false,
      ajax: '{{ route('proyectos.herramientas.documento.nuevoReporte') }}?listar=1&tipo='+$("[name='rep_tipo']").val()+'&fini'+$("[name='rep_fechafin']").val()+'&ffin='+$("[name='doc_proced_cod']").val(),
      columns: [
                { data: 'td_expeSISGEDO', name: 'tools_document.td_expeSISGEDO' },
                { data: 'proyecto', name: 'tools_document.proyecto'},
                { data: 'meta', name: 'tools_document.meta'},
                { data: 'especifica', name: 'tools_document.especifica'},
                { data: 'td_fecha', name: 'tools_document.td_fecha'},
                { data: 'monto', name: 'tools_document.monto'}
            ],
            displayLength: 25,
            language: {
                lengthMenu: "Mostrando _MENU_ Documentos por pagina.",
                zeroRecords: "No hay Documentos cargados en este momento (Intente modificando los filtros).",
                info: "Mostrando del _START_ al _END_ de _TOTAL_ Documentos",
                infoEmpty: "No se encontaron Documentos",
                infoFiltered: "(Filtrado de un total de _MAX_ Documentos)"
            },
            order: [[ 2, 'desc' ]]
        });
  });
</script>
@endpush
