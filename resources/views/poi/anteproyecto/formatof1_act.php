@extends('layouts.plantillaPoi')

@section('titulo')
    Nuevo| Unidades Orgánicas
@endsection

@section('estilo')
@parent

@endsection

@section('contenido')
    <div class="container">
        <div class="row">
            
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              
              <ul class="nav nav-tabs">
                <li class="active"><a href="unidadorganica">Explorar Unidades Orgánicas</a></li>
                <li><a href="unidadorganica/create">Nuevo Unidades Orgánicas</a></li> 
              </ul>
            </div>
            <!--fintapmenu-->
                   
            
                      <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">UNIDAD ORGÁNICA::[Búsqueda Datos]</div>
                   <div class="panel-body">
                      <!--CUERPO-->
                      <div class="col-md-12">
                          {{ Form::open(array('action' => 'Poi\AnteproyectoFormatoF2@create_actividad')) }}
						  {!! Form::text('codigo', '40') !!}
						  {{ Form::submit('Agregar Actividad', array('class'=>'btn btn-primary')) }}
						  {{ Form::close() }}
                      <form class="form-horizontal">
                        {{link_to_action('Poi\AnteproyectoFormatoF2@create_actividad', 'Nueva Actividad', array(40) )}}
                          <!--include('tramite.administracion.unidad-organica.search')-->
                           
                         <!--tabla-->
                        <div class="box">

                                <!-- /.tabla -->
                                <div class="box-body">
                                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-mihover" id="tabla_detalle">
<caption><h3>LISTA DE ACTIVIDADES/PROYECTOS</h3></caption>
    <thead>
        <tr>
            <th width="11%" rowspan="3" style="text-align: center">Unidad Responsable</th>
            <th width="13%" rowspan="3" style="text-align: center">Actividad y/o Proyecto</th>
            <th width="10%" rowspan="3" style="text-align: center">Indicadores</th>
            <th width="10%" rowspan="3" style="text-align: center">Unidad de medida</th>
           <!-- <th width="20%" colspan="8" style="text-align: center">PROGRAMACION TRIMESTRAL</th>-->
            <th width="10%" style="text-align: center">META ANUAL</th>
            <!--<th width="11%" rowspan="3" style="text-align: center">FUENTE DE FINANCIAMIENTO</th>-->
            <th width="8%" rowspan="3" style="text-align: center">PPTO.</th>
            <!--<th width="14%" rowspan="3" style="text-align: center">Acciones</th>-->
           <!--<th width="5%" rowspan="3" style="text-align: center">Nro. tareas</th>
            <th width="5%" rowspan="3" style="text-align: center">Nro. tareas con insumos</th>-->
            <?php //if($poi_codigo==40){ ?><!--<th width="5%" rowspan="3" style="text-align: center">Prioridad</th>--><?php // }?>
        </tr>
       <!-- <tr>
          <th colspan="2" style="text-align: center">I TRIM</th>
          <th colspan="2" style="text-align: center">II TRIM</th>
          <th colspan="2" style="text-align: center">III TRIM</th>
          <th colspan="2" style="text-align: center">IV TRIM</th>
          <th width="5%" rowspan="2" style="text-align: center">FISICA</th>
          <th width="5%" rowspan="2" style="text-align: center">FINANCIERA PIA</th>
        </tr>
        <tr>
          <th style="text-align: center">FISICA</th>
          <th style="text-align: center">FINANCIERA</th>
          <th style="text-align: center">FISICA</th>
          <th style="text-align: center">FINANCIERA</th>
          <th style="text-align: center">FISICA</th>
          <th style="text-align: center">FINANCIERA</th>
          <th style="text-align: center">FISICA</th>
          <th style="text-align: center">FINANCIERA</th>
        </tr>-->
    </thead>
    <tbody>
        <?php 
			/*$falta[1] = array( 0=>$row_result["fc"],1=>"Fiel Cumplimiento");
			$falta[2] = array( 0=>$row_result["ad"],1=>"Adelanto Directo");
			$falta[3] = array( 0=>$row_result["am"],1=>"Adelanto de Materiales");
			if(count($carta_fianza)>0) { 
			$clas='even'; 
			foreach($carta_fianza as $id=> $dato)
			{ 
				if($clas=='odd')$clas='even';else $clas='odd';
				if($dato['cafi_estado']==1)
				{
					$color = 'blue'; $estado = 'Reemplazado';
				} 
				else if($dato['cafi_estado']==2)
				{
					$color = 'blue'; $estado = 'Cancelado';
				}
				else
				{
					if($dato['estado']<=0){ $color = 'red'; $estado = 'Vencido';} 
					else if($dato['estado']<=15) {$color = 'orange'; $estado = 'Por vencerce<br>Quedan '.$dato['estado'].' dias';} 
					else {$color = 'green'; $estado = 'Vigente<br>Quedan '.$dato['estado'].' dias';}
				}
				$falta[$dato['proy_cf_tipo_idproy_cf_tipo']][0]=0;*/
				/*while($row_result=mysql_fetch_assoc($result))
			{
				$clase_color="red";
				if($row_result['nrotareas'] > 0 && ($row_result['nrotareasins'] == $row_result['nrotareas'] ) ){
					$clase_color="green";
				}
				else{
					$clase_color="ambar";
				}*/
        ?>
		@ foreach( $  actividades as $  actividad)
        <tr class="gradeU <?php //echo $clase_color ?>" >
            <td class="enlace" id="{{$actividad->idactividad_proyecto}}?>" >{ {  $actividad->act_proy_unidad_organica}}</td>
            <td class="enlace" id="{{$actividad->idactividad_proyecto}}" >{   {   $actividad->act_proy_denominacion}}</td>
            <td class="enlace" id="{{$actividad->idactividad_proyecto}}" >{ {  $actividad->act_proy_indicador}}</td>
            <td class="enlace" id="{{$actividad->idactividad_proyecto}}" >{ {  $actividad->act_proy_um}}</td>
            <td class="enlace" id="{{$actividad->idactividad_proyecto}}" >{ {  $actividad->idactividad_proyecto}}</td>
            <!--<td ><?php  ?></td>
            <td><?php  ?></td>
            <td ><?php ?></td>
            <td ><?php  ?></td>
            <td ><?php  ?></td>
            <td ><?php  ?></td>
            <td ><?php  ?></td>
            <td ><?php  ?></td>
            <td ><?php  ?></td>
            <td style="background-color:<?php //echo $color;?>; color:white;"><div ><?php //echo $estado; ?></div></td>-->
            <!--<td><center><input type="button" name="cf_<?php //echo $row_result['idactividad_proyecto'] ?>" id="cf_<?php //echo $row_result['idactividad_proyecto'] ?>" value="<?php //unset($dato['estado']); echo htmlentities(json_encode($dato)); ?>"><a href="#" class="button with_icon24_notext edit_cf" title="Editar" data-id="<?php //echo $row_result['idactividad_proyecto'] ?>"><span class="icon24_sprite i24_brush"></span></a></center></td>-->
            <td class="enlace" id="<?php //echo $row_result['idactividad_proyecto'] ?>" ><?php //echo toMoney($row_result['ppto']);  ?></td>
           <!-- <td class="enlace" id="<?php //echo $row_result['idactividad_proyecto'] ?>" ><?php  ?></td>-->
           <!-- <td class="enlace" id="<?php //echo $row_result['idactividad_proyecto'] ?>" ><?php  ?>  <?php //if($poi_codigo==40){ ?>| <!--<a href="poi_especificas.php?nivel=10&actividad=<?php //echo $row_result['idactividad_proyecto'] ?>" target="_blank"> Ver</a>--> <!--<a href="poi_especificas_detalle.php?nivel=12&poi=<?php //echo $poi_codigo; ?>" target="_blank"> Ver</a> | <a href="poi_especificas.php?nivel=11&poi=<?php //echo $poi_codigo ?>" target="_blank"> Ver</a>--><?php //} ?> <!--</td>-->
            
        </td> <center></center></td>
        </tr>
		@  endforeach
    </tbody>
</table>

                                </div> 
                        </div>
                                    
                        <!--fintabla-->
                          
                      </form>
                      <!--FINCUERPO 
                      {   $actividades->appends($request)->render()   }-->
                       </div>
                   </div>
               </div> 
            </div>
            <!--FINPANEL Registro-->  
                
            </div>
        </div>
    </div>
    <!--ALERTA DIALOGO-->
<script>
    $(document).ready(function(){
        $(".del").click(function(event){
            if(!confirm("¿Realmente desea Eliminar?"))
                event.preventDefault();
        })

    });
    
</script>

<!--FIN ALERTA DIALOGO-->
@endsection
