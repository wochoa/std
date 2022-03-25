@extends('layouts.plantilla')

@section('titulo')
    Nuevo| Crédito
@endsection


@section('contenido')
    <div class="container">
        <div class="row">
            
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              
              <ul class="nav nav-tabs">
                <li><a href="../usuarios">Explorar Créditos</a></li>
                <li class="active"><a href="../usuarios/create">Nuevo Crédito</a></li> 
              </ul>
            </div>
            <!--fintapmenu-->
              <!--<form class="form-horizontal" action="../usuarios" method="POST">-->
			  {{ Form::open(array('action' => 'ProcesoSeleccion\ProcesoSeleccionController@store', 'class' => 'form-horizontal')) }}
              {{csrf_field()}}      
             <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">PROCESO DE SELECCIÓN::[Nuevo Proceso]</div>
                   <div class="panel-body">
                      <!--CUERPO-->
                     
                          <div class="form-group">
								{{ Form::label('Descripción:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::text('proc_sel_cas_descripcion', '', ['id' =>  'proc_sel_cas_descripcion', 'class' => 'form-control mayuscula', 'placeholder' =>  'Nombre del proceso de selección completo', 'required' => 'required'])}}
                             </div>
                          </div>
                          <div class="form-group">
								{{ Form::label('Fecha de Inicio:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::date('proc_sel_cas_fecha_inicio', '', ['id' =>  'proc_sel_cas_fecha_inicio', 'class' => 'form-control', 'required' => 'required'])}}
                             </div>
                          </div>
						  <div class="form-group">
								{{ Form::label('fecha de término:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::date('proc_sel_cas_fecha_termino', '', ['id' =>  'proc_sel_cas_fecha_termino', 'class' => 'form-control', 'required' => 'required'])}}
                             </div>
                          </div>
                          <div class="form-group">
								{{ Form::label('Fecha fin de inscripción:* ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::date('cas_proc_sel_fecha_fin_inscripcion', '', ['id' =>  'cas_proc_sel_fecha_fin_inscripcion', 'class' => 'form-control', 'required' => 'required'])}}
                             </div>
                          </div>
                          <div class="form-group">
								{{ Form::label('Fecha de resultados: ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::date('cas_proc_sel_fecha_resultados', '', ['id' =>  'cas_proc_sel_fecha_resultados', 'class' => 'form-control', 'required' => 'required'] )}}
                             </div>
                          </div>
                          <div class="form-group">
								{{ Form::label('Número de concurso: ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								@foreach($nro_concurso as $concursos_nro)
								{{ Form::number('cas_proc_sel_nro_concurso', ($concursos_nro->nro_concurso+1), ['id' =>  'cas_proc_sel_nro_concurso', 'class' => 'form-control', 'placeholder' =>  'Digite un número menor, o igual al mostrado', 'min'=>($concursos_nro->nro_concurso), 'max'=>($concursos_nro->nro_concurso+1) ])}}
								@endforeach
                             </div>
                          </div>
						  
						  <div class="form-group">
                             <label class="col-sm-3 control-label" for="FormGroup"></label>
                             <div class="col-sm-7">
                                 {{ Form::submit('Guardar Datos del Proceso de Selección', ['class' => 'btn btn-success ' ] ) }}
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
@endsection
