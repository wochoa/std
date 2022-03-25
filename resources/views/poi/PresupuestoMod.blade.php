@extends('layouts.plantillaPoi')

@section('titulo')
    Nuevo| Presupuesto Modificado
@endsection

@section('contenido')
<div class="container-fluid">
  {!! Form::open(array('url' => 'poi/presupuestomod', 'class' => 'form-horizontal', 'method' =>'POST')) !!} 
   {{csrf_field()}}
    <!--PANEL Registro-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">MODIFICAR PRESUPUESTO::[Nuevo Registro]</div>
                <div class="panel-body">
                    <!--CUERPO-->
                    <div class="form-group">
                        {{ Form::label('Unidad Ejecutora:* ', '', ['class' => 'col-sm-3 control-label'])}}
                        <div class="col-sm-6">                            
                            <select class="form-control" name="unidad_ejecutora" id="unidad_ejecutora">
                                @foreach($unidades as $unidad)
                                    <option value="{{ $unidad->codigo }}">{{ $unidad->nombre }}</option>
                                @endforeach
                            </select>                            
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('POI:* ', '', ['class' => 'col-sm-3 control-label'])}}
                        <div class="col-sm-6">
                            <select class="form-control" name="poi" id="poi">
                                @foreach($pois as $poi)
                                    <option value="{{ $poi->poi_codigo }}" selected>{{ $poi->ofi_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Estructura Funcional:* ', '', ['class' => 'col-sm-3 control-label'])}}
                        <div class="col-sm-6">
                            <select class="form-control" name="estructura_funcional_prog_pres" id="estructura_funcional_prog_pres">
                                <option value>--- Seleccione Opción ---</option>
                                @foreach($estructuras as $estructura)
                                    <option value="{{ $estructura->codigo }}">{{ $estructura->est1.'.'.$estructura->est2.'.'.$estructura->est3.'.'.$estructura->est4.'.'.$estructura->est5.'.'.$estructura->est6.'.'.$estructura->est7.'.'.$estructura->est8 }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Clasificador Gasto:* ', '', ['class' => 'col-sm-3 control-label'])}}
                        <div class="col-sm-6">
                            <select class="form-control autocompletable" name="clasificador_gasto" id="clasificador_gasto">
                                <option value>--- Seleccione Opción ---</option>
                                @foreach($clasificador as $clasificado)
                                    <option value="{{ $clasificado->codigo }}">{{ $clasificado->clasificador.'-'.$clasificado->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Monto:* ', '', ['class' => 'col-sm-3 control-label'])}}
                        <div class="col-sm-6">
                            {{ form::number('pres_mod_monto', '', ['class' =>'form-control', 'id'  =>'pres_mod_monto']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Fuente Financiamiento:* ', '', ['class' => 'col-sm-3 control-label'])}}
                        <div class="col-sm-6">
                            <select class="form-control" name="poi_pres_fuente_financiamiento" id="poi_pres_fuente_financiamiento">
                                <option value>--- Seleccione Opción ---</option>
                                <option value="1"> 1</option>
                                <option value="2"> 2</option>
                                <option value="3"> 3</option>
                                <option value="4"> 4</option>
                                <option value="5"> 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Año:* ', '', ['class' => 'col-sm-3 control-label'])}}
                        <div class="col-sm-6">
                            {{ form::number('pres_mod_anio', date('Y'), ['class' =>'form-control', 'id'  =>'pres_mod_anio']) }}
                        </div>
                    </div> 
                    
                    <!--FINCUERPO-->
                    <div class="form-group">
                        {{Form::label('','', ['class'=>'col-sm-3 control-label'])}}
                        <div class="col-sm-5">
                            {{ Form::button('<span class="glyphicon glyphicon-floppy-save"> Registrar</span>',array('class'=>'btn btn-primary','type'=>'submit', 'style'=>'padding-bottom: 10px;'))}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--FINPANEL Registro-->
  {!! Form::close() !!}
</div>   


<!--ALERTA DIALOGO-->
<script>
    $(document).ready(function() {
      $(".autocompletable").select2();
    });
</script>

<!--FIN ALERTA DIALOGO-->
@endsection
