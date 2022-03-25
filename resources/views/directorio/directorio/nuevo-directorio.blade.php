@extends('layouts.plantilla')

@section('titulo')
    Nuevo| Directorio
@endsection


@section('contenido')
    <div class="container">
        <div class="row">
            
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              
              <ul class="nav nav-tabs">
                <li>{{link_to('directorio/directorio', 'Explorar Directorio' )}}
                <li class="active">{{link_to('#', 'Nuevo Registro Directorio' )}}</li> 
              </ul>
            </div>
            <!--fintapmenu-->
              {{ Form::open(array('action' => 'Directorio\DirectorioController@store', 'class' => 'form-horizontal', 'method' =>'POST')) }}
              {{csrf_field()}}      
             <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">DATOS DE LA ENTIDAD / UNIDAD</div>
                   <div class="panel-body">
                      <!--CUERPO-->
                     
                          <div class="form-group">
                              {{ Form::label('Dependencia Superior', '', ['class'=>'col-sm-3 control-label', 'for'=>'superior'])}}
                            <div class="col-sm-7">
                                <!--FOREACH-->
                                 <select class="form-control" name="superior">
									<option value="">Seleccione</option>
                                @foreach($unidades as $superior)
                                   <option value="{{$superior->uni_id}}">{{$superior->uni_denominacion}}</option>
                                @endforeach
                               </select>
                             </div>
                          </div>
						  
						  <div class="form-group">
                              {{ Form::label('Tipo:', '', ['class'=>'col-sm-3 control-label', 'for'=>'tipo_unidad'])}}
                            <div class="col-sm-7">
                                <!--FOREACH-->
                                 <select class="form-control" name="tipo_unidad" required="required">
									<option value="">Seleccione</option>
                                @foreach($tipo_unidad as $tipo)
                                   <option value="{{$tipo->tip_uni_id}}">{{$tipo->tip_uni_denominacion}}</option>
                                @endforeach
                               </select>
                             </div>
                          </div>
                          
                         <div class="form-group">
                            {{Form::label('Nombre de la Entidad / Unidad', '', ['class'=>'col-sm-3 control-label', 'for'=>'uni_denominacion', 'required'=>'required'])}}
                             <div class="col-sm-7">
                            {{Form::text('uni_denominacion','', ['class' => 'form-control mayuscula','id' =>'uni_denominacion'])}}
                             </div>
                          </div>
                          <div class="form-group">
                            {{Form::label('Teléfono(s)/Celular(es)', '', ['class'=>'col-sm-3 control-label', 'for'=>'uni_fono'])}}
                             <div class="col-sm-7">
                            {{Form::text('uni_fono','', ['class' => 'form-control','id' =>'uni_fono'])}}
                             </div>
                          </div>
                          <div class="form-group">
                            {{Form::label('Dirección', '', ['class'=>'col-sm-3 control-label', 'for'=>'uni_direccion'])}}
                             <div class="col-sm-7">
                            {{Form::text('uni_direccion','', ['class' => 'form-control mayuscula','id' =>'uni_direccion', 'required'=>'required'])}}
                             </div>
                          </div>
                          <div class="form-group">
                            {{Form::label('Dirección web o URL', '', ['class'=>'col-sm-3 control-label', 'for'=>'uni_direccion_web'])}}
                             <div class="col-sm-7">
                            {{Form::text('uni_direccion_web','', ['class' => 'form-control','id' =>'uni_direccion_web'])}}
                             </div>
                          </div>
                          <div class="form-group">
                            {{Form::label('Contactos Redes, cuentas diversas:', '', ['class'=>'col-sm-3 control-label', 'for'=>'uni_contactos_varios'])}}
                             <div class="col-sm-7">
                            {{Form::text('uni_contactos_varios','', ['class' => 'form-control','id' =>'uni_contactos_varios'])}}
                             </div>
                          </div>                    
                        <div class="form-group">
                             {{ Form::label('Lugar: ', '', ['class' =>  'col-sm-3 control-label'])}}
                             <div class="col-sm-7">
								{{ Form::select('ubigeo', $ubigeo, null, [ 'id' => 'ubigeo', 'class' => 'form-control', 'required'=>'required' ]) }}
                             </div>
                        </div>                      
                      
                      <!--FINCUERPO--> 
                   </div>
               </div> 
            </div>
            <!--FINPANEL Registro--> 
             
            <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">DATOS DEL RESPONSABLE</div>
                   <div class="panel-body">
                      <!--CUERPO-->
						  <div class="form-group">
                            {{Form::label('DNI:', '', ['class'=>'col-sm-3 control-label', 'for'=>'per_dni'])}}
                             <div class="col-sm-7">
                            {{Form::number('per_dni','', ['class' => 'form-control','id' =>'per_dni','min' =>'0','max' =>'999999999999999'])}}
                             </div>
                          </div>
						  <div class="form-group">
                            {{Form::label('Nombres:', '', ['class'=>'col-sm-3 control-label', 'for'=>'per_nombre'])}}
                             <div class="col-sm-7">
                            {{Form::text('per_nombre','', ['class' => 'form-control mayuscula','id' =>'per_nombre', 'required'=>'required'])}}
                             </div>
                          </div>  
						  <div class="form-group">
                            {{Form::label('Apellidos:', '', ['class'=>'col-sm-3 control-label', 'for'=>'per_apellido'])}}
                             <div class="col-sm-7">
                            {{Form::text('per_apellido','', ['class' => 'form-control mayuscula','id' =>'per_apellido', 'required'=>'required'])}}
                             </div>
                          </div>   
						  <div class="form-group">
                            {{Form::label('Teléfono(s)', '', ['class'=>'col-sm-3 control-label', 'for'=>'per_fono'])}}
                             <div class="col-sm-7">
                            {{Form::text('per_fono','', ['class' => 'form-control','id' =>'per_fono'])}}
                             </div>
                          </div>  
						  <div class="form-group">
                            {{Form::label('Dirección:', '', ['class'=>'col-sm-3 control-label', 'for'=>'per_direccion'])}}
                             <div class="col-sm-7">
                            {{Form::text('per_direccion','', ['class' => 'form-control mayuscula','id' =>'per_direccion'])}}
                             </div>
                          </div>
						  <div class="form-group">
                            {{Form::label('Email:', '', ['class'=>'col-sm-3 control-label', 'for'=>'per_email'])}}
                             <div class="col-sm-7">
                            {{Form::text('per_email','', ['class' => 'form-control','id' =>'per_email'])}}
                             </div>
                          </div>  
						  <div class="form-group">
                            {{Form::label('Cargo:', '', ['class'=>'col-sm-3 control-label', 'for'=>'asi_cargo'])}}
                             <div class="col-sm-7">
                            {{Form::text('asi_cargo','', ['class' => 'form-control mayuscula','id' =>'asi_cargo'])}}
                             </div>
                          </div>  
                      
                      <!--FINCUERPO--> 
                   </div>
               </div> 
            </div>
               <!--FINPANEL Registro-->
			
			<!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">{{Form::label('NOMBRES DE LOS COLABORADORES', '', ['class'=>'label_enlace','id' =>'label_colaboradores'])}}</div>
                   <div class="panel-body" id="div_colaboradores" style="display:none;">
                      <!--CUERPO-->
						  <div class="form-group">
                            {{Form::label('Colaboradores:', '', ['class'=>'col-sm-3 control-label', 'for'=>'uni_colaboradores'])}}
                             <div class="col-sm-7">
                            {{Form::textarea('uni_colaboradores','', ['class' => 'form-control mayuscula','id' =>'uni_colaboradores'])}}
                             </div>
                          </div>                   
                      
                      <!--FINCUERPO--> 
                   </div>
               </div> 
            </div>
               <!--FINPANEL Registro-->
			   
			<!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading"></div>
                   <div class="panel-body">
                      <!--CUERPO-->
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
	
	<script>
		$("#label_colaboradores").on("click", function(){
			$("#div_colaboradores").toggle("slow");
		});
	</script>
@endsection
