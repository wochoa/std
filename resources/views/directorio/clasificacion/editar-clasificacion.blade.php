@extends('layouts.plantilla')

@section('titulo')
    Editar| Clasificaciión
@endsection


@section('contenido')
    <div class="container">
        <div class="row">
            
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              
              <ul class="nav nav-tabs">
                <li><a href="../unidadorganica">Explorar clasificaciones de directorio</a></li>
                <li class="active"><a href="../unidadorganica/create">Nuevo clasificaciones</a></li> 
              </ul>
            </div>
            <!--fintapmenu-->
			 {{Form::open(array('class' => 'form-horizontal', 'method' =>'PATCH', 'route' => ['directorio.clasificacion.update', $clasificaciones_edit->cla_id]))}}
             {{csrf_field()}}
             {{method_field('PATCH')}}
             <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">DATOS DE LA CLASIFICACIÓN DEL DIRECTORIO</div>
                   <div class="panel-body">
                      <!--CUERPO-->
                          
                         <div class="form-group">
                            {{Form::label('Descripción', '', ['class'=>'col-sm-3 control-label', 'for'=>'depe_nombre'])}}
                             <div class="col-sm-7">
                            {{Form::text('cla_descripcion',$clasificaciones_edit->cla_descripcion, ['class' => 'form-control mayuscula','id' =>'cla_descripcion', 'placeholder'=>'Máximo 40 caracteres', 'required'=>'required', 'maxlength'=>'40' ])}}
                             </div>
                          </div>                           
						<div class="form-group">
                            {{Form::label('', '', ['class'=>'col-sm-3 control-label', 'for'=>'FormGroup'])}}
                             <div class="col-sm-7">
                             {{ Form::button('<span class="glyphicon glyphicon-ok-circle"> Registrar</span>',array('class'=>'btn btn-primary','type'=>'submit'))}}
                             </div>
                          </div>  
                      
                      <!--FINCUERPO--> 
                   </div>
               </div> 
            </div>
            <!--FINPANEL Registro--> 
               {{Form::close()}} 
              <!--</form> -->
            </div>
        </div>
    </div>
@endsection
