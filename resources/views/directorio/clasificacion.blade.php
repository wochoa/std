@extends('layouts.plantilla')

@section('titulo')
    Nuevo|Clasificación del directorio
@endsection
@section('contenido')
    <div class="container">
        <div class="row">
            
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              
              <ul class="nav nav-tabs">
                <li class="active"><a href="dependencias">Explorar Clasificación del directorio</a></li>
                <li>{{link_to_action('Directorio\ClasificacionController@create', 'Nuevo' )}}</li>
              </ul>
            </div>
            <!--fintapmenu--> 
                   
             <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">CLASIFICACIONES::[Búsqueda Datos]</div>
                   <div class="panel-body">
                      <!--CUERPO-->
                    <!--tabla-->
                        <div class="box">
                            <div class="box-body">
							{{$mensaje}}
								  <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                      <th>CODIGO</th>
                                      <th>NOMBRE DE LA CLASIFICACIÓN</th>
                                      <th style="width: 10px"></th>
                                      <th style="width: 10px"></th>
                                    </tr>
                                </thead>

                                <tbody> 
                                @foreach($clasificaciones as $clasificacion)
                                <tr>
                                    <td>{{$clasificacion->cla_id}}</td>
                                    <td>{{$clasificacion->cla_descripcion}}</td>
                                    <td><!--EDITAR-->
                                        {{Html :: linkAction('Directorio\ClasificacionController@edit', '', array ($clasificacion->cla_id),array('class'=>'btn btn-info glyphicon glyphicon-pencil','type'=>'button'))}}
                                    </td>
                                    <td><!--ELIMINAR-->
                                        {{Form::open([ 'method'  => 'delete', 'route' => ['dependencias.destroy', $clasificacion->cla_id]])}}
                                          {{csrf_field()}}
                                          {{method_field('DELETE')}}
                                             
                                        {{Form::button('<span class="glyphicon glyphicon-remove"></span>',array('class'=>'btn btn-danger del','type'=>'submit'))}}
                                        {{Form::close()}}
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                  </table>
                                </div> 
                        </div>
                        <!--PAGINACION ↓↓-->
                        {{$clasificaciones->appends($request)->render()}}                
                        <!--fintabla-->
                      <!--FINCUERPO--> 
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
