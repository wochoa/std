@extends('layouts.plantilla')
@section('titulo')
    Nuevo| Unidades Orgánicas
@endsection
@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              <ul class="nav nav-tabs">
                <li class="active">{{link_to_action('Directorio\DirectorioController@create', 'Explorar Unidades Orgánicas' )}}</li>
                <li>{{link_to_action('Directorio\DirectorioController@create', 'Nuevo Registro Directorio' )}}</li> 
              </ul>
            </div>
            <!--fintapmenu-->
                   
            <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">DIRECTORIO::[Búsqueda Datos]</div>
                   <div class="panel-body">
                      <!--CUERPO-->
                      <div class="col-md-12">
                        <!--@ include('tramite.administracion.unidad-organica.search')-->
                        <!--tabla-->
                        <div class="box">
                                <!-- /.tabla -->
                            <div class="box-body">
							{{--$mensaje--}}
							<!--{ !! $dataTable->table() !!}-->
							
							<table class="table table-bordered" id="users-table">
								<thead>
									<tr class="info">
										<th>Entidad</th>
										<th>Teléfono</th>
										<th>Dirección</th>
										<th>Responsable</th>
										<th>Cargo</th>
										<th>Acciones</th>
									</tr>
								</thead>
							</table>
                            </div> 
                        </div>
                        <!--FINCUERPO--> 
                       </div>
                   </div>
               </div> 
            </div>
            <!--FINPANEL Registro-->  
			<!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
     <!-- App scripts -->
			<script>
	$(document).ready(function() {
		$('#users-table').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "http://doceditor.regionhuanuco.gob.pe/tramite/public/directorio/directorio_ver",
			"columns": [
				{data:"uni_denominacion"},
				{data:"uni_fono"},
				{data:"uni_direccion"},
				{data:"per_nombre"},
				{data:"asi_cargo"},
			]
		});
	} );
	</script>
            </div>
        </div>
    </div>
    <!--ALERTA DIALOGO-->
@endsection

@push('scripts')
	
    {  !! $dataTable->scripts() !!}
	
@endpush