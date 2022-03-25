@extends('layouts.plantilla')

@section('titulo')
    Nuevo| Puesto
@endsection


@section('contenido')
    <div class="container">
        <div class="row">
            
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              
              <ul class="nav nav-tabs">
                <li><a href="{{route('procesocas.puesto.index')}}">Explorar Puestos</a></li>
                <li class="active"><a href="{{route('procesocas.puesto.create')}}">Nuevo Puesto</a></li>
              </ul>
            </div>
            <!--fintapmenu-->
              <!--<form class="form-horizontal" action="../usuarios" method="POST">-->
			  {{ Form::open(array('action' => 'ProcesoSeleccion\PuestoController@store', 'class' => 'form-horizontal')) }}
              {{csrf_field()}}      
             <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">PUESTO DEL PROCESO DE SELECCIÓN::[Nuevo Proceso]</div>
                   <div class="panel-body">
                      <!--CUERPO-->
                     
                          <div class="form-group">
								{{ Form::label('Proceso de Selección:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::select('cas_pue_proceso_seleccion', $proceso_seleccion, null, [ 'id' => 'cas_pue_proceso_seleccion', 'class' => 'form-control', 'required' => 'required' ]) }}
                             </div>
                          </div>
                          <div class="form-group">
								{{ Form::label('Unidad Orgánica u Oficina:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::select('sel_cas_pue_oficina', $oficina, null, [ 'id' => 'sel_cas_pue_oficina', 'class' => 'form-control autocompletable', 'required' => 'required' ]) }}
								{{ Form::text('txt_cas_pue_oficina', '', ['id' =>  'txt_cas_pue_oficina', 'class' => 'form-control mayuscula', 'autocomplete'=>'off', 'placeholder'=>'Si no encuentra la unidad escríbala aquí' ])}}
                             </div>
                          </div>
						  <div class="form-group">
								{{ Form::label('Nombre del puesto:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::text('cas_pue_puesto', '', ['id' =>  'cas_pue_puesto', 'class' => 'form-control mayuscula', 'required' => 'required'])}}
                             </div>
                          </div>
						  <div class="form-group">
								{{ Form::label('Número de plazas:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::number('cas_pue_cantidad_plazas', '', ['id' =>  'cas_pue_cantidad_plazas', 'class' => 'form-control', 'required' => 'required', 'placeholder' =>  'Digite sólo números', 'min'=>'1' ])}}
                             </div>
                          </div>
                          <div class="form-group">
								{{ Form::label('Remuneración:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::number('cas_pue_remuneracion', '', ['id' =>  'cas_pue_remuneracion', 'class' => 'form-control', 'required' => 'required', 'min'=>'0', 'step'=>'0.01', 'placeholder' =>  'Digite sólo números' ])}}
                             </div>
                          </div>
                          <div class="form-group">
								{{ Form::label('Tipo de recurso: ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::text('cas_pue_tipo_recurso', '', ['id' =>  'cas_pue_tipo_recurso', 'class' => 'form-control'] )}}
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
			  {{ Form::close() }}
            </div>
        </div>
    </div>
	<script>
		$(document).ready(function() {
		  $(".autocompletable").select2();
		});
	</script>
@endsection
