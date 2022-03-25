@extends('layouts.plantilla')

@section('titulo')
    Nuevo|Bloques
@endsection


@section('contenido')
    <div class="container">
        <div class="row">            
            <div class="col-sm-12">
            <!--tapmenu-->
            <div class="container">
              
              <ul class="nav nav-tabs">
                <li><a href="../bloques">Explorar Bloqueos</a></li>
                <li class="active"><a href="../bloques/create">Nuevo Bloqueo</a></li>
              </ul>
            </div>
            <!--fintapmenu-->
                   
             <!--PANEL Registro-->
            <div class="panel-group">
               <div class="panel panel-primary">
                   <div class="panel-heading">BLOQUEOS::[Nuevo Registro]</div>
                   <div class="panel-body" id="central">
                      <!--CUERPO-->
                      {{ Form::open(array('action' => 'Tramite\BloqueController@create','method'=>'GET', 'class' => 'form-horizontal', 'id'=>'myform')) }}
                      {{csrf_field()}}
                          <div class="form-group">
                                {{ Form::label('Tipo: ', '', ['class' =>  'col-sm-3 control-label', 'for'=>'FormGroup']) }}

                                <div class="col-sm-6">                                
                                     <select class="form-control" name="bloque_tipo", id="bloque_tipo", onchange = 'javascript:showContent(this)'> 
                                         @if($reportes_hidd == null)
                                            <option>---Seleccione Opción---</option>
                                            <option value="1">SOLO MOSTRAR MENSAJES</option>
                                            <option value="2">BLOQUEAR Y MOSTRAR MENSAJES</option>
                                            <option value="3">NO BLOQUEAR</option>
                                         @else
                                            <option>---Seleccione Opción---</option>
                                            <option value="1" {{ (1 == $reportes_hidd)?"selected":"" }} >SOLO MOSTRAR MENSAJES</option>
                                            <option value="2" {{ (2 == $reportes_hidd)?"selected":"" }} >BLOQUEAR Y MOSTRAR MENSAJES</option>
                                            <option value="3" {{ (3 == $reportes_hidd)?"selected":"" }} >NO BLOQUEAR</option>
                                         @endif                                     
                                     </select>
                                     {{ Form::hidden('reportes_hidd', $reportes_hidd, ['id'=>'text2', 'class'=>'form-control']) }}
                                 </div>

                          </div>
                          <div class="form-group">
                                {{ Form::label('Unidad Org: ', '', ['class'=>'col-sm-3 control-label'])}}
                                <div class="col-sm-1">                            
                                    {{ Form::text('', '', ['id'=>'unidad_org_rec', 'class'=>'form-control', 'readonly'])}}   
                                </div>
                                <div class="col-sm-5">
                                    <select class="form-control" name="unidad_org" id="unidad_org"><?php echo $opciones; ?></select>   
                                </div>
                          </div> 
                          <div class="form-group">
                             {{ Form::label('Usuario: ', '', ['class' =>  'col-sm-3 control-label', 'for'=>'FormGroup']) }}
                             <div class="col-sm-6">                                
                                 <select class="form-control" name="usuarios_org" id="usuarios_org"> 
                                    <option value>---Seleccione Opción---</option>                       
                                 </select>
                             </div>
                        </div>
                          <div class="form-group" style="display: block;" id="content1"> 
                            {{ Form::label('Mensaje que Mostrará: ', '', ['class' =>  'col-sm-3 control-label', 'for'=>'FormGroup']) }} 
                              <div class="col-sm-6">
                                 {{ Form::textarea('notes', null, ['class' => 'form-control', 'size' => '30x2']) }}
                             </div>
                          </div>
                          <div class="form-group">
                            {{ Form::label('', '', ['class' =>  'col-sm-3 control-label', 'for'=>'FormGroup']) }}
                             <div class="col-sm-5">                               
                                <!--{{Form::button('<span class="glyphicon glyphicon-search"></span>',array('url'=>'bloques/create', 'id'=>'enviar','class'=>'btn btn-primary','type'=>'submit'))}}-->
                                 {{ Form::button('<span class="glyphicon glyphicon-floppy-save"> Registrar</span>',
                                    array('url'=>'bloques/create', 'id'=>'enviar', 'class'=>'btn btn-primary','type'=>'submit')) }}
                             </div>
                          </div>
                      {{ Form::close() }}
                      <!--FINCUERPO--> 
                   </div>
               </div> 
            </div>
            <!--FINPANEL Registro-->  
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function(){     
        
        $("#unidad_org").change(function(){
            var id = $("#unidad_org").val();
            $.ajax({
                url:  "../bloques/"+id+"/usuarios",
                type: "GET",
                success: function(json){   
                    var select = '<option value>--Seleccione opción--</option>';
                    var option = '';
                    obj = json['usuarios_buscados']; 
                    $.each( obj, function( key, value ) {
                        option = option + '<option value="'+value['id']+'">'+value['nombre']+'</option>';
                    }); 
                    select = select + option;
                    $( "#usuarios_org" ).html( select );
                }
                
            })
        });
        
        $("#unidad_org").change(function(){
            var value = $("#unidad_org").val();
            $( "#unidad_org_rec" ).val( value );
            console.log(value);
        });
    });
    
    function showContent(c) {         
        var report =document.getElementById('bloque_tipo');
        var report_1 = document.getElementById('text2').value=report.options[report.selectedIndex].value;
        
        element1 = document.getElementById("content1");         
               
        selec = document.getElementById("bloque_tipo");
        
        if (report_1 == 3) {            
            element1.style.display='none';             
        }
        else
            element1.style.display='block';
    }
</script>
@endsection
