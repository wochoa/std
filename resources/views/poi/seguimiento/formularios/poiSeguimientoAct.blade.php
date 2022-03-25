@extends('layouts.plantillaPoi')

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
                         
                      <form class="form-horizontal">
                        
                          <!--@include('tramite.administracion.unidad-organica.search')-->
                           
                         <!--tabla-->
                        <div class="box">

                                <!-- /.tabla -->
                                <div class="box-body">
                                  <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                      <th>CÓDIGO</th>
                                      <th>NOMBRE</th>
                                      <th>ABREVIADO</th>
                                      <th>SIGLAS</th>
                                      <th>REPRESENTANTE</th>
                                      <th>DEPENDENCIA</th>
                                      <th style="width: 10px"></th>
                                      <th style="width: 10px"></th>
                                    </tr>
                                </thead>

                                <tbody> 
                                    @foreach($creditos as $credito)
                                <tr>
                                    <td>{{$credito->idcredito}}</td>
                                    <td>{{$credito->numero_credito}}</td>
                                    <td>{{$credito->usuario}}</td>
                                    <td>{{$credito->monto}}</td>
                                    <td>{{$credito->estado}}</td>
                                    <td></td>
                                    <td>
                                        <a href="../public/unidadorganica/{{$credito->idcredito}}/edit" type="button" class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a>
                                    </td>
                                    <td>
                                        <form action="../public/unidadorganica/{{$credito->idcredito}}" method="POST">
                                          {{csrf_field()}}
                                          {{method_field('DELETE')}}
                                             <button class="btn btn-danger del" type="submit"><span class="glyphicon glyphicon-remove"></span></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                  </table>
                                </div> 
                        </div>
                                    
                        <!--fintabla-->
                          
                      </form>
                      <!--FINCUERPO 
                      {{$dependencias->appends($request)->render()}}-->
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