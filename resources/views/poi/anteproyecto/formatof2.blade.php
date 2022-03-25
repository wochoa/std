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
								<th style="text-align: center" width="100%">FORMATO F-2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO</th>
							</tr>
						</thead>            
					</table>
				<!--FIN TITULO-->
				   
				<!--1. INFORMACIÓN GENERA-->    
					<table class="table table-bordered table-condensed">    
						<thead>
							<tr class="info">
								<th width="100%" colspan="6">1. INFORMACIÓN GENERAL</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="15%" class="active"><b>1.1. Unidad Ejecutora</b></td>
								<td width="14%" style="text-align: center">(Número y Nombre de la Unidad Ejecutora)</td>
								<td width="10%" class="active"><b>1.2. Unidad Orgánica</b></td>
								<td width="37%" style="text-align: center">(Nombre de la Unidad Orgánica) {{ $id_poi }}</td>
								<td width="10%" class="active"><b>1.3. Año</b></td>
								<td width="37%" style="text-align: center">(Año de Formulación)</td>
							</tr>
						</tbody>
					</table>
				<!--FIN 1. INFORMACIÓN GENERA--> 
				   
				<!--2. ALINEAMIENTO ESTRATÉGICO-->     
					<table class="table table-bordered table-condensed" width="100%">    
						<thead>
							<tr class="info">
								<th colspan="7">2. ALINEAMIENTO ESTRATÉGICO</th>
							</tr>
						</thead>
						<tbody style="text-align: center">
							<tr>
								<td class="active" colspan="2"><b>2.1. Visión Regional</b></td>
								<td colspan="2">(DEscripción de la Visión Regional)</td>
								<td class="active"><b>2.2. Misión Institucional</b></td>
								<td colspan="2">(Descripción de la Misión Institucional-PEI)</td>
							</tr>
							
							<tr>
								<td class="active" colspan="2"><b>2.3. Plan Estratégico</b></td>
								<td class="active"><b>2.4. Código</b></td>
								<td class="active"><b>2.5. Descripción</b></td>
								<td class="active" rowspan="2" style="padding-top: 13px"><b>2.6. Indicador</b></td>
								<td class="active" rowspan="2" style="padding-top: 13px"><b>2.7. Unidad de Medida</b></td>
								<td class="active" rowspan="2" style="padding-top: 13px"><b>2.8. Meta</b></td>
							</tr>
							   
							<tr>
								<td class="active" rowspan="3" style="padding-top: 20px"><b>2.3.1. PDRC Huánuco al 2021</b></td>
								<td class="active"><b>C.E.</b></td>
								<td colspan="2">
									{{Form::select('sel_cei', $ces, null, [ 'id' => 'sel_cei', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
							</tr>
							   
							<tr>
								<td class="active"><b>O.E.T.</b></td>
								<td colspan="2">
									{{Form::select('sel_oet', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_oet', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_oet_indicador', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_oet_indicador', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_oet_unidad_medida', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_oet_unidad_medida', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::text('plan_det_id', '', [ 'id' => 'plan_det_id', 'class' => 'form-control', 'required' => 'required' ] ) }}
									{{Form::label('meta_oet', '', [ 'id' => 'meta_oet', 'class' => 'form-control']) }}
								</td>
							</tr>
							   
							<tr>
								<td class="active"><b>A.E.T.</b></td>
								<td colspan="2">
									{{Form::select('sel_aet', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_aet', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_aet_indicador', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_aet_indicador', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_aet_unidad_medida', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_aet_unidad_medida', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::text('plan_det_id_aet', '', [ 'id' => 'plan_det_id_aet', 'class' => 'form-control', 'required' => 'required' ] ) }}
									{{Form::label('meta_aet', '', [ 'id' => 'meta_aet', 'class' => 'form-control']) }}
								</td>
							</tr>
							
							<tr>
								<td class="active" rowspan="2" style="padding-top: 15px"><b>2.3.2. PEI 2017-2019</b></td>
								<td class="active"><b>O.E.I.</b></td>
								<td colspan="2">
									<select name="" class="form-control" required>
										<option value="">Seleccione</option>
										@foreach($oeis as $oei)
										<option value="{{$oei->plan_det_id}}">{{$oei->plan_det_codigo.'. '.$oei->plan_det_descripcion}}</option>
										@endforeach
									</select>
								</td>
								<td>(Nombre del Indicador del O.E.I.)</td>
								<td>(Unidad de Medida del Indicador del O.E.I.)</td>
								<td>(Meta Anual)</td>
							</tr>
							
							<tr>
								<td class="active"><b>A.E.I.</b></td>
								<td colspan="2">
									{{Form::select('sel_aei', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_aei', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
								<td>(Nombre del Indicador del A.E.I.)</td>
								<td>(Unidad de Medida del Indicador del A.E.I.)</td>
								<td>(Meta Anual)</td>
							</tr>
						</tbody>
					</table>
				<!--FIN 2. ALINEAMIENTO ESTRATÉGICO--> 
				   
				<!--3. ARTICULACIÓN PRESUPUESTARIA-->     
					<table class="table table-bordered table-condensed">    
						<thead>
							<tr class="info">
								<th colspan="9">3. ARTICULACIÓN PRESUPUESTARIA</th>
							</tr>
						</thead>
						<tbody style="text-align: center">
							<tr>
								<td class="active" rowspan="4" style="padding-top: 30px"><b>3.1. Categoría Presupuestal</b></td>
								<td class="active"><b>3.2. Código</b></td>
								<td class="active" colspan="3"><b>3.3. Denominación</b></td>
								<td class="active" colspan="2" rowspan="3" style="padding-top: 30px"><b>3.4. Resultado Final o Específico</b></td>
								<td class="active" rowspan="3" style="padding-top: 30px"><b>3.5. Inidicador</b></td>
								<td class="active" rowspan="3" style="padding-top: 30px"><b>3.6. Meta</b></td>
							</tr>
							
							<tr>
								<td>{{Form::radio('categoria_presupuestal', '9001', false, [ "id"=>"cat_pres_9001", "required" => "required"] ) }}
									{{Form::label('cat_pres_9001','9001') }}
								</td>    
								<td colspan="3">
								Acciones Centrales
								</td>    
							</tr>
							
							<tr>
								<td>
									{{Form::radio('categoria_presupuestal', '9002', false, [ "id"=>"cat_pres_9002", "required" => "required"] ) }}
									{{Form::label('cat_pres_9002','9002') }}
								</td>    
								<td colspan="3">Asignación Presupuestaria que no resulta en Productos</td>    
							</tr>
							
							<tr>
								<td>{{Form::radio('categoria_presupuestal', '0000', false, [ "id"=>"cat_pres_0000", "required" => "required"] ) }}
									{{Form::label('cat_pres_0000','0000') }}</td>    
								<td colspan="3">
									{{Form::select('sel_cat_pres', $prog_pres, null, [ 'id' => 'sel_cat_pres', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>    
								<td colspan="2">(Resultado final o específico del PP)</td>    
								<td>(Indicador del PP)</td>    
								<td>(Meta del PP)</td>    
							</tr>
							
							<tr>
								<td class="active" rowspan="2"><b>3.7. Estructura Funcional Programática</b></td>
								<td class="active"><b>Función</b></td>
								<td class="active"><b>Divición Funcional</b></td>
								<td class="active"><b>Grupo Funcional</b></td>
								<td class="active"><b>Categoría Presupuestal</b></td>
								<td class="active"><b>Prodcuto/Proyecto</b></td>
								<td class="active"><b>Actividad/Acción/Obra</b></td>
								<td class="active"><b>Finalidad</b></td>
								<td class="active"><b>Meta Presupuetaria</b></td>
							</tr>
							
							<tr>
								<td>
									{{Form::select('sel_aei', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_funcion', 'class' => 'form-control art_pres', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_aei', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_div_funcional', 'class' => 'form-control art_pres', 'required' => 'required'] ) }}
								</td>
								<td>
									{{Form::select('sel_aei', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_grupo_funcional', 'class' => 'form-control art_pres', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_aei', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_cat_pres', 'class' => 'form-control art_pres', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_aei', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_prod_proy', 'class' => 'form-control art_pres', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_aei', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_act_obra', 'class' => 'form-control art_pres', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('sel_aei', ['placeholder'=>'Seleccione'], null, [ 'id' => 'sel_finalidad', 'class' => 'form-control art_pres', 'required' => 'required' ] ) }}
								</td>
								<td>
									{{Form::select('meta_presupuestaria', $meta_presupuestaria, null, [ 'id' => 'sel_meta_presupuestaria', 'class' => 'form-control', 'required' => 'required' ] ) }}
								</td>
							</tr>
						</tbody>
					</table>
				<!--FIN 3. ARTICULACIÓN PRESUPUESTARIA--> 
				
				<!--4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->        
					<table class="table table-bordered table-condensed"> 
					<!--TITULOS-->     
						<thead>
							<tr class="info">
								<th colspan="20">4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD</th>
							</tr>
						</thead>
					<!--FIN TITULOS-->
					
					<!--SUBTITULOS-->
						<tbody>
							<tr style="text-align: center">
								<td class="active" rowspan="2"><b>4.1. Unidad Responsable</b></td>
								<!--<td class="active" rowspan="2"><b>4.2. Código</b></td>-->
								<td class="active" colspan="4" rowspan="2"><b>4.3. Denominacion de la Actividad</b></td>
								<td class="active" colspan="3" rowspan="2"><b>4.4. Indicador</b></td>
								<td class="active" colspan="2" rowspan="2"><b>4.5. Unidad de Medida</b></td>
								<td class="active" colspan="4"><b>4.6. Meta Anual</b></td>
								<td class="active" colspan="5"><b>4.7. Fuente de Financiamiento</b></td>
							</tr> 
							
							<tr style="text-align: center">
								<td class="active" colspan="2"><b>Física</b></td>
								<td class="active" colspan="2"><b>Financiera</b></td>
								<td class="active"><b>RO</b></td>
								<td class="active"><b>RDR</b></td>
								<td class="active"><b>ROOC</b></td>
								<td class="active"><b>DyT</b></td>
								<td class="active"><b>RD</b></td>
							</tr>  
					<!--FIN SUBTITULOS-->
								   
					<!--CUERPO 1-->
							<tr style="text-align: center">
								<td>{{Form::select('sel_unidad_responsable',['placeholder'=>'Seleccione'], null, ['required'=>'required'] )}}</td>
								<!--<td>(De la Actv)</td>-->
								<td colspan="4">{{Form::text('act_proy_denominacion','',["required"=>"required","readonly"=>"readonly"])}}</td>
								<td colspan="3">{{Form::text('act_proy_indicador','',["required"=>"required"])}}</td>
								<td colspan="2">{{Form::text('act_proy_unidad_medida','',["required"=>"required"])}}</td>
								<td colspan="2">{{Form::text('act_proy_cantidad','',["required"=>"required"])}}</td>
								<td colspan="2">(Monto Financ.)</td>
								<td><b> {{Form::checkbox('act_proy_ff_1','1',false)}} </b></td>
								<td><b> {{Form::checkbox('act_proy_ff_2','2',false)}} </b></td>
								<td><b> {{Form::checkbox('act_proy_ff_3','3',false)}} </b></td>
								<td><b> {{Form::checkbox('act_proy_ff_4','4',false)}} </b></td>
								<td><b> {{Form::checkbox('act_proy_ff_5','5',false)}} </b></td>
							</tr> 
					<!--FIN CUERPO 1-->
								   
					<!--CUERPO 2-->
							<tr style="text-align: center">
								<td class="active" colspan="2"><b>4.8. Actividad-Proyecto</b></td>
								<td class="active" colspan="6"><b>4.8.1. Descripción</b></td>
								<td class="active" colspan="3"><b>4.8.2. Localización</b></td>
								<td class="active" colspan="3"><b>4.8.3. Beneficiarios</b></td>
								<td class="active" colspan="4"><b>4.8.4. Estrategia(s) Operativa(s)</b></td>
								<td class="active" colspan="2"><b>4.9. Prioridad</b></td>
							</tr>
							   
							<tr style="text-align: center">
								<td colspan="2">{{Form::label('act_proy_denominacion','',["id"=>"act_proy_nombre"])}}</td>
								<td colspan="6"> {{Form::textarea('act_proy_descripcion','',["required"=>"required"])}} </td>
								<td colspan="3"> {{Form::textarea('act_proy_localizacion','',["required"=>"required"])}} </td>
								<td colspan="3"> {{Form::textarea('act_proy_beneficiarios','',["required"=>"required"])}} </td>
								<td colspan="4"> {{Form::textarea('act_proy_est_oper','',["required"=>"required"])}} </td>
								<td colspan="2"> - </td>
							</tr> 
					<!--FIN CUERPO 2-->
								   
					<!--CUERPO 3-->
							<tr style="text-align: center">
								<td class="active" rowspan="2"><b>4.10. Actividad-Proyecto/Tarea-Componente</b></td>
								<td class="active" colspan="2" rowspan="2"><b>Unidad de Medida</b></td>
								<td class="active" colspan="3"><b>I Trimestre</b></td>
								<td class="active" rowspan="2"><b>Total al I Trim</b></td>
								<td class="active" colspan="3"><b>II Trimestre</b></td>
								<td class="active" rowspan="2"><b>Total al II Trim</b></td>
								<td class="active" colspan="3"><b>III Trimestre</b></td>
								<td class="active" rowspan="2"><b>Total al III Trim</b></td>
								<td class="active" colspan="3"><b>VI Trimestre</b></td>
								<td class="active" rowspan="2"><b>Total al IV Trim</b></td>
								<td class="active" rowspan="2"><b>Total I Anual</b></td>
							</tr>
							
							<tr style="text-align: center">
								<td class="active"><b>Ene</b></td>
								<td class="active"><b>Feb</b></td>
								<td class="active"><b>Mar</b></td>
								<td class="active"><b>Abr</b></td>
								<td class="active"><b>May</b></td>
								<td class="active"><b>Jun</b></td>
								<td class="active"><b>Jul</b></td>
								<td class="active"><b>Ago</b></td>
								<td class="active"><b>Set</b></td>
								<td class="active"><b>Oct</b></td>
								<td class="active"><b>Nov</b></td>
								<td class="active"><b>Dic</b></td>
							</tr>
							<!--------------------------------------------------->
							<tr style="text-align: center">
								<td class="active" rowspan="2"><b>Actividad 1</b></td>
								<td class="active"><b>Física</b></td>
								<td>( - )</td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td class="active"> - </td>
							</tr>
							
							<tr style="text-align: center">
								<td class="active"><b>Financiera</b></td>
								<td> S/. </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td class="active"> - </td>
							</tr>
							<!--------------------------------------------------->
							<tr style="text-align: center">
								<td class="active" rowspan="2"><b>Tarea 1.1</b></td>
								<td class="active"><b>Física</b></td>
								<td>( - )</td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td class="active"> - </td>
							</tr>
							
							<tr style="text-align: center">
								<td class="active"><b>Financiera</b></td>
								<td> S/. </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td class="active"> - </td>
							</tr>
							<!--------------------------------------------------->
							<tr style="text-align: center">
								<td class="active" rowspan="2"><b>Tarea 1.2</b></td>
								<td class="active"><b>Física</b></td>
								<td>( - )</td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td class="active"> - </td>
							</tr>
							
							<tr style="text-align: center">
								<td class="active"><b>Financiera</b></td>
								<td> S/. </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td> - </td>
								<td> - </td>
								<td> - </td>
								<td class="active"> - </td>
								<td class="active"> - </td>
							</tr>
					<!--FIN CUERPO 3-->        
						</tbody>
					</table>
				<!--FIN 4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->     
	
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
		
		$("#sel_cei").on("change", function(event){
			$("#sel_oet").empty();
			$("#sel_oet_indicador").empty();
			$("#sel_oet_unidad_medida").empty();
			$("#plan_det_id").val('');
			$("#meta_oet").empty();
				//tipo 1 para obtener los oets
			$.get("oet/1/" + $(this).val(), function(response, state){
				$("#sel_oet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");
				if(response.length == 1){
					$("#sel_oet_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
					$("#sel_oet_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
					$("#plan_det_id").val( response[0].plan_det_id );
					$("#meta_oet").text( response[0].plan_det_meta );
				}
				else{
					$("#sel_oet_indicador").append("<option value=''>Seleccione</option>");
					$("#sel_oet_unidad_medida").append("<option value=''>Seleccione</option>");
					$.each( response, function(key, value){
						$("#sel_oet_indicador").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_indicador + ". " + value.plan_det_indicador + "</option>");
					});
				}
				$("#sel_oet_unidad_medida").change();
				/*console.log(response );
				console.log(state);*/
			});
		});
		
		$("#sel_oet_indicador").on("change", function(event){
			$("#sel_oet_unidad_medida").empty();
			$("#plan_det_id").val('');
			$("#meta_oet").empty();
				//tipo 1 para obtener los oets
			$.get("oet/2/" + $(this).val(), function(response, state){
					$.each( response, function(key, value){
						$("#sel_oet_unidad_medida").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_unidad_medida + ". " + value.plan_det_unidad_medida + "</option>");
						$("#sel_oet_unidad_medida").change();
						$("#plan_det_id").val( value.plan_det_id );
						$("#meta_oet").text( value.plan_det_meta );
					});
			});
		});
		
		$("#sel_oet_unidad_medida").on("change", function(event){
			$("#sel_aet").empty();
			$("#sel_aet_indicador").empty();
			$("#sel_aet_unidad_medida").empty();
			$("#plan_det_id_aet").val('');
			$("#meta_aet").empty();
				//tipo 3 para obtener los aets
			$.get("oet/3/" + $(this).val(), function(response, state){
				console.log(response.length);
				if(response.length == 1){
					$("#sel_aet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");
					$("#sel_aet_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
					$("#sel_aet_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
					$("#plan_det_id_aet").val( response[0].plan_det_id );
					$("#meta_aet").text( response[0].plan_det_meta );
				}
				else{
					$("#sel_aet").append("<option value=''>Seleccione</option>");
					$("#sel_aet_indicador").append("<option value=''>Seleccione</option>");
					$("#sel_aet_unidad_medida").append("<option value=''>Seleccione</option>");
					cod_anterior=0;
					$.each( response, function(key, value){
						if( cod_anterior != value.plan_det_codigo ){
							cod_anterior = value.plan_det_codigo
							$("#sel_aet").append("<option value='" + value.plan_det_codigo +"'>" + value.plan_det_codigo + ". " + value.plan_det_descripcion + "</option>");
							//$("#sel_aet_unidad_medida").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_unidad_medida + ". " + value.plan_det_unidad_medida + "</option>");
						}
					});
				}
				/*console.log(response );
				console.log(state);*/
			});
		});
		
		$("#sel_aet").on("change", function(event){
			$("#sel_aet_unidad_medida").empty();
			$("#sel_aet_indicador").empty();
			$("#plan_det_id_aet").val('');
			$("#meta_aet").empty();
				//tipo 4 para obtener los oets
			$.get("aet/1/" + $("#plan_det_id").val() + "/"  + $(this).val(), function(response, state){
				if( response.length == 1){
					$("#sel_aet_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
					$("#sel_aet_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
					$("#plan_det_id_aet").val( response[0].plan_det_id );
					$("#meta_aet").text( response[0].plan_det_meta );
				}
				else{
					$("#sel_aet_indicador").append("<option value=''>Seleccione</option>");
					$("#sel_aet_unidad_medida").append("<option value=''>Seleccione</option>");
					$.each( response, function(key, value){
						$("#sel_aet_indicador").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_indicador + ". " + value.plan_det_indicador + "</option>");
						//$("#sel_aet_unidad_medida").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_unidad_medida + ". " + value.plan_det_unidad_medida + "</option>");
					});
				}
			});
		});
		
		//$("#sel_cei").select2();
		
		$("#sel_meta_presupuestaria").on("change", function(event){
			$(".art_pres").empty();
			
			$.get("siafmetadatos/" + $(this).val(), function(response, state){
				$("#sel_funcion").append("<option value='" + response[0].FUNCION +"'>" + response[0].FUNCION +  "</option>");
				$("#sel_div_funcional").append("<option value='" + response[0].FUNCION +"'>" + response[0].FUNCION +  "</option>");
				$("#sel_grupo_funcional").append("<option value='" + response[0].FUNCION +"'>" + response[0].FUNCION +  "</option>");
				$("#sel_cat_pres").append("<option value='" + response[0].PROGRAMA_P +"'>" + response[0].PROGRAMA_P +  "</option>");
				$("#sel_prod_proy").append("<option value='" + response[0].FUNCION +"'>" + response[0].FUNCION +  "</option>");
				$("#sel_act_obra").append("<option value='" + response[0].ACT_PROY +"'>" + response[0].ACT_PROY +  "</option>");
				$("#sel_finalidad").append("<option value='" + response[0].FINALIDAD +"'>" + response[0].FINALIDAD +  "</option>");
			});
		});
	</script>
@endsection
