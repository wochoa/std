@extends('layouts.plantillaPoi')
@section('titulo')
    Formato F1| Actividades
@endsection


@section('contenido')
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              
              <ul class="nav nav-tabs">
                <li><a href="../usuarios">Explorar Puestos</a></li>
                <li class="active"><a href="../usuarios/create">Nuevo Crédito</a></li> 
              </ul>
            </div>
            <!--fintapmenu-->
              <!--<form class="form-horizontal" action="../usuarios" method="POST">-->
				  {{ Form::open(array('action' => 'Poi\AnteproyectoFormatoF2@create_actividad')) }}
					{{csrf_field()}}
					{{ Form::hidden('codigo', '40') }}
					{{ Form::submit('Agregar Actividad', array('class'=>'btn btn-primary')) }}
					{ {link_to_action('Poi\AnteproyectoFormatoF2@create_actividad', 'Nueva Actividad', array(40) )} }
				  {{ Form::close() }}
             <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
			   
				<!--TITULO-->
					<table class="table table-bordered">
						<thead>
							<tr bgcolor="#98CCF4">
								<th style="text-align: center" width="100%">FORMATO F-1: RESUMEN DE PROGRAMACIÓN POR UNIDAD EJECUTORA</th>
							</tr>
						</thead>            
					</table>
				<!--FIN TITULO-->
				
				<!--1. INFORMACIÓN GENERA-->    
					<table class="table table-bordered table-condensed">    
						<thead>
							<tr class="info">
								<th width="100%" colspan="5">1. INFORMACIÓN GENERAL</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="15%" class="active"><b>1.1. Unidad Ejecutora</b></td>
								<td width="14%" style="text-align: center">(Código de la Unidad Ejecutora)</td>
								<td width="24%" style="text-align: center">(Nombre de la Unidad Ejecutora)</td>
								<td width="10%" class="active"><b>1.2. Año</b></td>
								<td width="37%" style="text-align: center">(Año de Formulación)</td>
							</tr>
						</tbody>
					</table>
				<!--FIN 1. INFORMACIÓN GENERA--> 
				
				<!--2. ALINEAMIENTO ESTRATÉGICO-->     
					<table class="table table-bordered table-condensed">    
						<thead>
							<tr class="info">
								<th width="100%" colspan="4">2. ALINEAMIENTO ESTRATÉGICO</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="active"><b>2.1. Visión Regional</b></td>
								<td style="text-align: center">(DEscripción de la Visión Regional)</td>
								<td class="active"><b>2.2. Misión Institucional</b></td>
								<td style="text-align: center">(Descripción de la Misión Institucional)</td>
							</tr>
						</tbody>
					</table>
				<!--FIN 2. ALINEAMIENTO ESTRATÉGICO-->
				
				<!--3. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->
				   <div style="overflow-x: scroll;">
					   <table class="table table-bordered table-condensed">
					<!--TITULOS-->     
						<thead>
							<tr class="info">
								<th colspan="18">3. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD</th>
							</tr>
						</thead>
					<!--FIN TITULOS-->
					
					<!--SUBTITULOS-->
						<tbody>
							<tr style="text-align: center" class="active">
								<td rowspan="3"><b>3.1. Número</b></td>
								<td rowspan="3"><b>3.2. Unidad Orgánica</b></td>
								<td rowspan="3"><b>3.3. Unidad Responsable</b></td>
								<td rowspan="3"><b>3.4. Código</b></td>
								<td rowspan="3"><b>3.5. Actividades/ Proy</b></td>
								<td rowspan="3"><b>3.6. Indicadores</b></td>
								<td rowspan="3"><b>3.7. Unidad de Medida</b></td>
								<td colspan="8"><b>3.8. Programación Trimestral</b></td>
								<td colspan="2"><b>3.9. Meta Anual</b></td>
								<td rowspan="3"><b>3.10. Fuente de Financiami ento</b></td>
							</tr>          
						  
							<tr style="text-align: center" class="active">
								<td colspan="2"><b>I Trim.</b></td>
								<td colspan="2"><b>II Trim.</b></td>
								<td colspan="2"><b>III Trim.</b></td>
								<td colspan="2"><b>VI Trim.</b></td>
								<td rowspan="2"><b>Física</b></td>
								<td rowspan="2"><b>Financiera</b></td>
							</tr>
							
							<tr style="text-align: center" class="active">                    
								<td><b>Física</b></td>
								<td><b>Financiera</b></td>                    
								<td><b>Física</b></td>
								<td><b>Financiera</b></td>                    
								<td><b>Física</b></td>
								<td><b>Financiera</b></td>                    
								<td><b>Física</b></td>
								<td><b>Financiera</b></td>
							</tr>
					<!--FIN SUBTITULOS-->
								   
					<!--CUERPO 1-->
							<tr style="text-align: center">
								<td rowspan="3">(Número de Orden)</td>
								<td rowspan="3">(Nombre de la Unidad Orgánica)</td>
								<td>(Unidad Responsable de la Actividad)</td>
								<td>(De la Activ.)</td>
								<td>(Actividad 1)</td>
								<td>(Nombre del Indicador de la Actividad 1)</td>
								<td>(U. M. del Indicador)</td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>
								<td>(Cód. de FF)</td>
							</tr>
							
							<tr style="text-align: center">
								<td>(Unidad Responsable de la Actividad)</td>
								<td>(De la Activ.)</td>
								<td>(Actividad 1)</td>
								<td>(Nombre del Indicador de la Actividad 1)</td>
								<td>(U. M. del Indicador)</td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>
								<td>(Cód. de FF)</td>
							</tr>
							
							<tr style="text-align: center" class="active">  
								<td colspan="5">Sub Total de la Unidad Orgánica</td>
								<td> - </td>                    
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
							</tr>
					<!--FIN CUERPO 1-->
								   
					<!--CUERPO 2-->
							<tr style="text-align: center">
								<td rowspan="3">(Número de Orden)</td>
								<td rowspan="3">(Nombre de la Unidad Orgánica)</td>
								<td>(Unidad Responsable de la Actividad)</td>
								<td>(De la Activ.)</td>
								<td>(Actividad 1)</td>
								<td>(Nombre del Indicador de la Actividad 1)</td>
								<td>(U. M. del Indicador)</td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>
								<td>(Cód. de FF)</td>
							</tr>
							
							<tr style="text-align: center">
								<td>(Unidad Responsable de la Actividad)</td>
								<td>(De la Activ.)</td>
								<td>(Actividad 1)</td>
								<td>(Nombre del Indicador de la Actividad 1)</td>
								<td>(U. M. del Indicador)</td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>
								<td>(Cód. de FF)</td>
							</tr>
							
							<tr style="text-align: center" class="active">                    
								<td colspan="5">Sub Total de la Unidad Orgánica</td>
								<td> - </td>                    
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>                    
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
							</tr>
					<!--FIN CUERPO 2-->        
						</tbody>
					</table>
				   </div>
				<!--FIN 3. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD--> 
				
				<!--4. PROGRAMACIÓN OPERATIVA DE LA UNIDAD EJECUTORA-->        
					<table class="table table-bordered table-condensed"> 
					<!--TITULOS-->     
						<thead>
							<tr class="info">
								<th colspan="18">4. PROGRAMACIÓN OPERATIVA DE LA UNIDAD EJECUTORA</th>
							</tr>
						</thead>
					<!--FIN TITULOS-->
					
					<!--SUBTITULOS-->
						<tbody>
							<tr style="text-align: center" class="active">
								<td><b>4.1. Unidad Ejecutora</b></td>
								<td colspan="2"><b>4.2. Total I Trim. </b></td>
								<td colspan="2"><b>4.3. Total I Trim. </b></td>
								<td colspan="2"><b>4.4. Total I Trim. </b></td>
								<td colspan="2"><b>4.5. Total I Trim. </b></td>
								<td colspan="2"><b>4.6. Total I Trim. </b></td>
								<td><b>4.7. FF. </b></td>
							</tr>  
					<!--FIN SUBTITULOS-->
								   
					<!--CUERPO 1-->
							<tr style="text-align: center">
								<td>(Código y NOmbre de la Unidad Ejecutora)</td>                   
								<td> - </td>
								<td>(Financiera)</td>                    
								<td> - </td>
								<td>(Financiera)</td>                    
								<td> - </td>
								<td>(Financiera)</td>                    
								<td> - </td>
								<td>(Financiera)</td>                    
								<td> - </td>
								<td>(Financiera)</td>
								<td>(Cód. de FF)</td>
							</tr>   
					<!--FIN CUERPO 1-->   
					   
						</tbody>
					</table>
				<!--FIN 4. PROGRAMACIÓN OPERATIVA DE LA UNIDAD EJECUTORA-->
	
                   <div class="panel-heading">PUESTO DEL PROCESO DE SELECCIÓN::[Nuevo Proceso]</div>
                   <div class="panel-body">
                      <!--CUERPO-->
                     
                          <div class="form-group">
								{{ Form::label('Proceso de Selección:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{  { Form::select('cas_pue_proceso_seleccion', $proceso_seleccion, null, [ 'id' => 'cas_pue_proceso_seleccion', 'class' => 'form-control', 'required' => 'required' ]) }}
                             </div>
                          </div>                          
						  
						  <div class="form-group">
                             <label class="col-sm-3 control-label" for="FormGroup"></label>
                             <div class="col-sm-7">
                                 {{ Form::submit('Guardar Datos del Puesto', ['class' => 'btn btn-success ' ] ) }}
                             </div>
                          </div>  
                                              
                      
                      <!--FINCUERPO--> 
                   </div>
               </div> 
            </div>
            <!--FINPANEL Registro--> 
            </div>
        </div>
    </div>
	<script>
		$(document).ready(function() {
		  $(".autocompletable").select2();
		});
	</script>
@endsection
