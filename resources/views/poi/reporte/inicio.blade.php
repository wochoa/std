@extends('layouts.plantillaPoi')

@section('titulo')
    Nuevo|Huamalies
@endsection
@section('contenido') 

{!!Form::open(['url'=>'poi/actividad/reporte', 'class'=>'form-horizontal'])!!}
    <div style="page-break-before: always; page-break-after: always; page-break-inside:always;">
        
<!--FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->
    <div id="myPrintArea" class="container">
        <div class="form-group">
            <label for="unidad_ejecutora" class="col-md-12">Unidad Ejecutora: </label>
            <select name="unidad_ejecutora" id="unidad_ejecutora" class="form-control select2">
                <option value>Seleccione una Opción</option>
                @foreach($ejecutoras AS $ejecutora)
                    <option value="{{$ejecutora->id}}">{{$ejecutora->numero}}. {{$ejecutora->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="unidad_org" class="col-md-12">Unidad Orgánica: </label>
            <select name="unidad_org" id="unidad_org" class="form-control select2">
                <option value>Seleccione una Opción</option>
            </select>
        </div> 
        <div>                      
            <div class="col-sm-1">
                {!! Form::button('<span class="glyphicon glyphicon-search"> Buscar</span>',
                array('class'=>'btn btn-primary', 'type'=>'submit', 'style'=>'font-size: 12px;', 'id'=>'target')) !!}
            </div>  
        </div>   
        <br><br>
    <!--1. INFORMACIÓN GENERA-->    
        <div class="content" id="tabla" hidden="true">
            <!-- /.box-header -->
            <table id="example1" class="table table-bordered table-mihoverreporte">
                <thead style="background-color: #d8eaf3;">
                    <tr>
                        <th class="text-center">CÓDIGO</th>
                        <th class="text-center">NOMBRE</th>
                        <th class="text-center">ABREVIADO</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>a</td>
                        <td>a</td>
                        <td>a</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>b</td>
                        <td>b</td>
                        <td>b</td>
                    </tr>
                </tbody>
            </table>
    <!--FIN 1. INFORMACIÓN GENERA--> 
        </div>    
    </div>
    </div>
{!! Form::close() !!}
<!-- DATA TABLE -->
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script>
    
    $(document).ready(function() {
        $(".del").click(function(event) {
            if (!confirm("¿Realmente desea Eliminar?"))
                event.preventDefault();
        })
    });
    $(document).ready(function() {
        $('#example1').DataTable({
            "language":
            {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    } );

    $(document).ready(function () { 
        (function ($) { 
            $('#filtrar').keyup(function () { 
                var rex = new RegExp($(this).val(), 'i');
                $('.buscar tr').hide();
                $('.buscar tr').filter(function () {
                    return rex.test($(this).text());
                }).show(); 
            }) 
        }(jQuery)); 
    });
    
    $(document).ready(function(){
		$("#target").on( "click", function() {
			$('#tabla').show(); //muestro mediante id
		 });
	});
    
    $(document).ready(function(){
		$("#unidad_ejecutora").on( "change", function() {
			$('#tabla').hide(); //muestro mediante id
		 });
	});
    
    $(document).ready(function(){
		$("#unidad_org").on( "change", function() {
			$('#tabla').hide(); //muestro mediante id
		 });
	});
    
    $("#unidad_ejecutora").on("change", function(event){
        $("#unidad_org").empty();			
        $.get("reporte/ejecutora/" + $(this).val(), function(response, state){
            //console.log(response.length);
            $("#unidad_org").append("<option value=''>Seleccione</option>");
            $.each( response, function(key, value){
                $("#unidad_org").append("<option value='" + value.id +"'>" + value.nombre + "</option>");
            });
        });
	});
</script>
@endsection
