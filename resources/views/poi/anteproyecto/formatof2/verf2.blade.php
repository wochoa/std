<!DOCTYPE html>
<html lang="en">

<head>
    <title>HUAMALIES</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{asset('js/jquery.js')}}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://alxlit.name/bootstrap-chosen/bootstrap.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
    <style>
        .centrar{
            text-align: center;
        }
        
        .texto{
            font-family: "Arial Narrow";
            font-size: 11px;
            font-style: normal;
	        font-variant: normal;
            color: white;
            text-align: center;
        }
        
        .texto-tabla > thead > tr >th,
        .texto-tabla > tbody > tr >td,
        .texto-tabla > tfoot > tr >td{
            font-family: Tahoma;
            font-size: 9px;
            font-style: normal;
	        font-variant: normal;
        }
        
        /*------------------------------class = "table"------------------------------------*/
                
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > td,
        .table-bordered > tfoot > tr > td {            
            border: 1px solid #000000;
            border-right-width:0px;
            border-left-width:0px;
            border-bottom: 1px solid #000000;
            border-top: 1px solid #000000;
            border-right: 1px solid #000000;
            border-left: 1px solid #000000;
        }
        /*------------------------------class = "table"------------------------------------*/

        /*------------------------------class = "primary"------------------------------------*/
        .info2 {
            background-color: #4F81BD; 
            color:white;
        }

        .info2 th {
            background-color: #4F81BD; 
            color:white;
        }

        .info2 td {
            background-color: #4F81BD; 
            color:white;
        }
        /*------------------------------class = "primary"------------------------------------*/

        /*------------------------------class = "info2"------------------------------------*/
        .active2 {
            background-color: #D2E3F8;             
        }

        .active2 th {
            background-color: #D2E3F8;             
        }

        .active2 td {
            background-color: #D2E3F8;             
        }
        
        .financiera {
            background-color: #ACF0A3; 
        }
        
        .fisica {
            background-color: #FFA5A5; 
        }
        
        .financieratar {
            background-color: #DFFFDA; 
        }
        
        .fisicatar {
            background-color: #FDD6D6; 
        }
        /*------------------------------class = "info2"------------------------------------*/
            
        .table-mihover>tbody>tr:hover {
            background-color: #EFDA9C
        }        
    </style>    
    
</head>

<body>   
    <div style="page-break-before: always; page-break-after: always; page-break-inside:always;">
        
<!--FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->
    <div id="myPrintArea" class="container-fluid">
        <div>
            <h3></h3>    
        </div>
        @if(Session::has('msg'))
            <div class="alert alert-danger">   
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>        
                <strong>ATENCIÓN!</strong> {{ Session::get('msg') }}.
            </div>
        @endif
        <!--<p>The .table class adds basic styling (light padding-top and only horizontal dividers) to a table:</p>-->
    <div class="table-responsive"> 
    <!--TITULO-->
        <table class="table table-bordered">
            <thead>
                <tr bgcolor="#244062">
                    <th class="texto" width="100%">FORMATO F-2: PROGRAMACIÓN DE LA ACTIVIDAD OPERATIVA / ACCIÓN DE INVERSIÓN</th>
                </tr>
            </thead>            
        </table>
    <!--FIN TITULO-->
       
    <!--1. info2RMACIÓN GENERA-->    
        <table class="table table-bordered table-condensed texto-tabla">    
            <thead>
                <tr class="info2">
                    <th width="100%" colspan="7">1. INFORMACIÓN GENERAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="15%" class="active2"><b>1.1. Unidad Ejecutora</b></td>
                    <td width="5%" style="text-align: center">{{$actividades->unieje}}</td>
                    <td width="20%" style="text-align: center">{{strtoupper($actividades->nomunieje)}}</td>
                    <td width="15%" class="active2"><b>1.2. Centro de Costo</b></td>
                    <td width="25%" style="text-align: center">{{strtoupper($actividades->nomofi)}}</td>
                    <td width="10%" class="active2"><b>1.3. Periodo</b></td>
                    <td width="10%" style="text-align: center">{{$actividades->anio}}</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 1. info2RMACIÓN GENERA--> 
       
    <!--2. ALINEAMIENTO ESTRATÉGICO-->     
        <table class="table table-bordered table-condensed texto-tabla" width="100%">    
            <thead>
                <tr class="info2">
                    <th colspan="8">2. ALINEAMIENTO ESTRATÉGICO</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                <tr>
                    <td class="active2" colspan="2"><b>2.1. Visión Regional</b></td>
                    <td colspan="2">{{strtoupper($vision->vision)}}</td>
                    <td class="active2"><b>2.2. Misión Institucional</b></td>
                    <td colspan="3">{{strtoupper($mision->mision)}}</td>
                </tr>
                
                <tr>
                    <td class="active2" colspan="2"><b>2.3. Plan Estratégico</b></td>
                    <td class="active2"><b>2.4. Código</b></td>
                    <td class="active2"><b>2.5. Descripción</b></td>
                    <td class="active2" rowspan="2" style="padding-top: 25px" width="20%"><b>2.6. Indicador</b></td>
                    <td class="active2" rowspan="2" style="padding-top: 25px"><b>2.7. Unidad de Medida</b></td>
                    <td class="active2" rowspan="2" style="padding-top: 25px" width="10%" colspan="2"><b>2.8. Meta</b></td>
                </tr>
                   
                <tr>
                    <td class="active2" rowspan="3" style="padding-top: 20px"><b>2.3.1. PDRC Huánuco al 2021</b></td>
                    <td class="active2"><b>C.E.</b></td>
                    <td>{{$ce->id}}</td>
                    <td>{{$ce->descripcion}}</td>
                </tr>
                  
                <tr>
                    <td class="active2"><b>O.E.T.</b></td>
                    <td>{{$oet->id}}</td>
                    <td>{{$oet->descripcion}}</td>
                    <td>{{$oet->indicador}}</td>
                    <td>{{$oet->medida}}</td>
                    <td>{{$oet->meta1}}</td>
                    <td>{{$oet->meta2}}</td>
                </tr>
                   
                <tr>
                    <td class="active2"><b>A.E.T.</b></td>
                    <td>{{$aet->id}}</td>
                    <td>{{$aet->descripcion}}</td>
                    <td>{{$aet->indicador}}</td>
                    <td>{{$aet->medida}}</td>
                    <td>{{$aet->meta1}}</td>
                    <td>{{$aet->meta2}}</td>
                </tr>
                
                <tr>
                    <td class="active2" rowspan="2" style="padding-top: 15px"><b>2.3.2. PEI 2017-2019</b></td>
                    <td class="active2"><b>O.E.I.</b></td>
                    <td>{{$oei->id}}</td>
                    <td>{{$oei->descripcion}}</td>
                    <td>{{$oei->indicador}}</td>
                    <td>{{$oei->medida}}</td>
                    <td>{{$oei->meta1}}</td>
                    <td>{{$oei->meta2}}</td>
                </tr>
                
                <tr>
                    <td class="active2"><b>A.E.I.</b></td>
                    <td>{{$aei->id}}</td>
                    <td>{{$aei->descripcion}}</td>
                    <td>{{$aei->indicador}}</td>
                    <td>{{$aei->medida}}</td>
                    <td>{{$aei->meta1}}</td>
                    <td>{{$aei->meta2}}</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 2. ALINEAMIENTO ESTRATÉGICO--> 
       
    <!--3. ARTICULACIÓN PRESUPUESTARIA-->     
        <table class="table table-bordered table-condensed texto-tabla">    
            <thead>
                <tr class="info2">
                    <th colspan="9">3. ARTICULACIÓN PRESUPUESTARIA</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                                
                <tr>
                    <td class="active2" rowspan="2"><b>3.1. Estructura Funcional Programática</b></td>
                    <td class="active2"><b>Función</b></td>
                    <td class="active2"><b>División Funcional</b></td>
                    <td class="active2"><b>Grupo Funcional</b></td>
                    <td class="active2"><b>Categoría Presupuestal</b></td>
                    <td class="active2"><b>Producto/Proyecto</b></td>
                    <td class="active2"><b>Actividad/Acción/Obra</b></td>
                    <td class="active2"><b>Finalidad</b></td>
                    <td class="active2"><b>Meta Presupuetaria</b></td>
                </tr>
                
                <tr>
                    <td>{{$actividades->funcion}}</td>
                    <td>{{$actividades->division}}</td>
                    <td>{{$actividades->grupo}}</td>
                    <td>{{$actividades->categoria}}</td>
                    <td>{{$actividades->producto}}</td>
                    <td>{{$actividades->actividad}}</td>
                    <td>{{$actividades->finalidad}}</td>
                    <td>{{$actividades->siaf}}</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 3. ARTICULACIÓN PRESUPUESTARIA--> 
    
    <!--4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->        
        <table class="table table-bordered table-condensed texto-tabla table-mihover"> 
        <!--TITULOS-->     
            <thead>
                <tr class="info2">
                    <th colspan="21">4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD</th>
                </tr>
            </thead>
        <!--FIN TITULOS-->
        
        <!--SUBTITULOS-->
            <tbody>
                <tr style="text-align: center">
                    <td class="active2" rowspan="2" width="10%"><b>4.1. Número</b></td>
                    <td class="active2" colspan="6" rowspan="2"><b>4.2. Denominacion de la Actividad Operativa o Inversión</b></td>
                    <td class="active2" colspan="3" rowspan="2"><b>4.3. Indicador</b></td>
                    <td class="active2" colspan="2" rowspan="2"><b>4.4. Unidad de Medida</b></td>
                    <td class="active2" colspan="4"><b>4.5. Meta Anual</b></td>
                    <td class="active2" colspan="5"><b>4.6. Fuente de Financiamiento (S/.)</b></td>
                </tr> 
                
                <tr style="text-align: center">
                    <td class="active2" colspan="2"><b>Física</b></td>
                    <td class="active2" colspan="2"><b>Financiera</b></td>
                    <td class="active2"><b>RO</b></td>
                    <td class="active2"><b>RDR</b></td>
                    <td class="active2"><b>ROOC</b></td>
                    <td class="active2"><b>DyT</b></td>
                    <td class="active2"><b>RD</b></td>
                </tr>  
        <!--FIN SUBTITULOS-->
        
        <!--CUERPO 1-->
            @php($i=1)
            @foreach($inversiones AS $inversion)
                <tr style="text-align: center">
                    <td>
                        {{$inversion->numero}}
                        <a style="color: black;" href="#" data-toggle="modal" data-target="#{{$i}}" title="Editar"><span class="glyphicon glyphicon-pencil pull-left" style="font-size: 13px;"></span></a>
                        <!-------------------------Modal------------------------------------------------------------>
                        <div class="modal fade bd-example-modal-lg" id="{{$i}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title text-center" id="myModalLabel">Editar Actividad Operativa:{{$inversion->numero}} <br>{{$inversion->denominacion}}</h4>
                                </div>
                                {!!Form::open(['url'=>'poi/anteproyecto/editarf2/'.$inversion->id, 'class'=>'form-horizontal'])!!}
                                <div class="modal-body">
                                    {!!Form::hidden('actividad_id', $inversion->id, ['class'=>'form-control', 'id'=>'actividad_id'])!!}
                                    {!!Form::hidden('idactividad_proyecto_edit', $id, ['class'=>'form-control', 'id'=>'idactividad_proyecto_edit'])!!}
                                    <div class="form-group">
                                        {!!Form::label('Denominación', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            <textarea class="form-control" id="actividad_denominacion_edit" name="actividad_denominacion_edit" required>{{$inversion->denominacion}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Indicador', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_indicador_edit', $inversion->indicador, ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_indicador_edit'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Unid. Medida', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_unidad_medida_edit', $inversion->um, ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_unidad_medida_edit'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Descripción', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            <textarea class="form-control" id="actividad_descripcion_edit" name="actividad_descripcion_edit" required>{{$inversion->descripcion}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Tareas Ope.', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            <textarea class="form-control" id="actividad_tareas_operativas_edit" name="actividad_tareas_operativas_edit" required>{{$inversion->tareas}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Beneficiarios', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_beneficiarios_edit', $inversion->beneficiarios, ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_beneficiarios_edit'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Localización', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_localizacion_edit', $inversion->localizacion, ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_localizacion_edit'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Prioridad OEI', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_prioridad_edit', $inversion->prioridad, ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_prioridad_edit'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Cantidad',null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::number('actividad_fisica_total_edit', $inversion->total, ['class'=>'form-control', 'readonly'=>'true', 'id'=>'actividad_fisica_total_edit', 'placeholder'=>'Ingrese la Cant. para cada Mes'])!!}
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table-bordered table-condensed">
                                        <thead class="active2">
                                            <tr>
                                                <th class="text-center">Enero</th>
                                                <th class="text-center">Febrero</th>
                                                <th class="text-center">Marzo</th>
                                                <th class="text-center">Abril</th>
                                                <th class="text-center">Mayo</th>
                                                <th class="text-center">Junio</th>
                                                <th class="text-center">Julio</th>
                                                <th class="text-center">Agosto</th>
                                                <th class="text-center">Setiembre</th>
                                                <th class="text-center">Octubre</th>
                                                <th class="text-center">Noviembre</th>
                                                <th class="text-center">Diciembre</th>
                                            </tr>                            
                                        </thead>
                                        <tbody class="active2">
                                            <tr>
                                                <td>{!!Form::text('actividad_fisica_enero_edit', ($inversion->enero)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_enero_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_febrero_edit', ($inversion->febrero)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_febrero_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_marzo_edit', ($inversion->marzo)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_marzo_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_abril_edit', ($inversion->abril)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_abril_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_mayo_edit', ($inversion->mayo)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_mayo_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_junio_edit', ($inversion->junio)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_junio_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_julio_edit', ($inversion->julio)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_julio_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_agosto_edit', ($inversion->agosto)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_agosto_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_setiembre_edit', ($inversion->setiembre)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_setiembre_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_octubre_edit', ($inversion->octubre)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_octubre_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_noviembre_edit', ($inversion->noviembre)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_noviembre_edit'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_diciembre_edit', ($inversion->diciembre)?:0, ['class'=>'form-control sumar', 'id'=>'actividad_fisica_diciembre_edit'])!!}</td>
                                            </tr>
                                        </tbody>                        
                                    </table>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" name="cancel">Cancelar</button>
                                  <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                                {!!Form::close()!!}
                              </div>
                            </div>
                        </div>
                        <!-------------------------Fin Modal------------------------------------------------------------>
                    </td>
                    <td colspan="6">{{$inversion->denominacion}}</td>
                    <td colspan="3">{{$inversion->indicador}}</td>
                    <td colspan="2">{{$inversion->um}}</td>
                    <td colspan="2">{{$inversion->total}}</td>
                    <td colspan="2">{{$inversion->esp_monto_total}}</td>                    
                    <td class="text-right">{{$inversion->ff1}}</td>                    
                    <td class="text-right">{{$inversion->ff2}}</td>                    
                    <td class="text-right">{{$inversion->ff3}}</td>                    
                    <td class="text-right">{{$inversion->ff4}}</td>                    
                    <td class="text-right">{{$inversion->ff5}}</td>         
                </tr> 
                @php($i++)
            @endforeach
        <!--FIN CUERPO 1-->    
                         
        <!--CUERPO 2-->
                <tr style="text-align: center">
                    <td class="active2" colspan="3"><b>4.7. Actividad-Proyecto</b></td>
                    <td class="active2" colspan="6"><b>4.7.1. Descripción</b></td>
                    <td class="active2" colspan="3"><b>4.7.2. Tareas Operativa(s)</b></td>
                    <td class="active2" colspan="3"><b>4.7.3. Beneficiarios</b></td>
                    <td class="active2" colspan="4"><b>4.7.4. Localización</b></td>
                    <td class="active2" colspan="2"><b>4.8. Prioridad OEI</b></td>
                </tr>
                @php($num=1)
                @foreach($inversiones AS $inversion)   
                    <tr style="text-align: center">
                        <td style="text-align: justify" colspan="3">{{$num}}.- {{$inversion->denominacion}}</td>
                        <td colspan="6">{{$inversion->descripcion}}</td>
                        <td colspan="3">{{$inversion->tareas}}</td>
                        <td colspan="3">{{$inversion->beneficiarios}}</td>
                        <td colspan="4">{{$inversion->localizacion}}</td>
                        <td colspan="2">{{$inversion->prioridad}}</td>
                    </tr> 
                    @php($num++)
                @endforeach
        <!--FIN CUERPO 2-->
        <!--CUERPO 3-->
                <tr style="text-align: center">
                    <td class="active2" rowspan="2" colspan="2" width="20%"><b>4.10. Actividad-Proyecto/Tarea-Componente</b></td>
                    <td class="active2" colspan="2" rowspan="2"><b>Unidad de Medida</b></td>
                    <td class="active2" colspan="3"><b>I Trimestre</b></td>
                    <td class="active2" rowspan="2"><b>Total I Trim</b></td>
                    <td class="active2" colspan="3"><b>II Trimestre</b></td>
                    <td class="active2" rowspan="2"><b>Total II Trim</b></td>
                    <td class="active2" colspan="3"><b>III Trimestre</b></td>
                    <td class="active2" rowspan="2"><b>Total III Trim</b></td>
                    <td class="active2" colspan="3"><b>IV Trimestre</b></td>
                    <td class="active2" rowspan="2"><b>Total IV Trim</b></td>
                    <td class="active2" rowspan="2"><b>Total I Anual</b></td>
                </tr>
                
                <tr style="text-align: center">
                    <td class="active2" width="4%"><b>Ene</b></td>
                    <td class="active2" width="4%"><b>Feb</b></td>
                    <td class="active2" width="4%"><b>Mar</b></td>
                    <td class="active2" width="4%"><b>Abr</b></td>
                    <td class="active2" width="4%"><b>May</b></td>
                    <td class="active2" width="4%"><b>Jun</b></td>
                    <td class="active2" width="4%"><b>Jul</b></td>
                    <td class="active2" width="4%"><b>Ago</b></td>
                    <td class="active2" width="4%"><b>Set</b></td>
                    <td class="active2" width="4%"><b>Oct</b></td>
                    <td class="active2" width="4%"><b>Nov</b></td>
                    <td class="active2" width="4%"><b>Dic</b></td>
                </tr>
                <!--------------------------------------------------->
                @php($i=str_pad($i, 3, "0", STR_PAD_LEFT))  
                <!--------------------------------------------------->
                @php($tar=1)                    
                @if($inversionrows != 0)
                @foreach($inversiones AS $inversion)
                <tr class="text-center">
                    <td style="text-align: left;" class="active2" rowspan="2" colspan="2">      
                        <a href="{{url('poi/anteproyecto/insumosf2/'.$id.'/'.$inversion->id)}}" class="btn btn-success btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span> Clas.</a>
                        Actividad {{$tar}} : <b>{{$inversion->denominacion}}</b>                        
                    </td>
                    <td class="active2"><b>Física</b></td>
                    <td class="fisicatar">( - )</td>
                    <td class="fisicatar">{{$inversion->enero}}</td>
                    <td class="fisicatar">{{$inversion->febrero}}</td>
                    <td class="fisicatar">{{$inversion->marzo}}</td>
                    <td class="active2"><b>{{$inversion->enero+$inversion->febrero+$inversion->marzo}}</b></td>
                    <td class="fisicatar">{{$inversion->abril}}</td>
                    <td class="fisicatar">{{$inversion->mayo}}</td>
                    <td class="fisicatar">{{$inversion->junio}}</td>
                    <td class="active2"><b>{{$inversion->abril+$inversion->mayo+$inversion->junio}}</b></td>
                    <td class="fisicatar">{{$inversion->julio}}</td>
                    <td class="fisicatar">{{$inversion->agosto}}</td>
                    <td class="fisicatar">{{$inversion->setiembre}}</td>
                    <td class="active2"><b>{{$inversion->julio+$inversion->agosto+$inversion->setiembre}}</b></td>
                    <td class="fisicatar">{{$inversion->octubre}}</td>
                    <td class="fisicatar">{{$inversion->noviembre}}</td>
                    <td class="fisicatar">{{$inversion->diciembre}}</td>
                    <td class="active2"><b>{{$inversion->octubre+$inversion->noviembre+$inversion->diciembre}}</b></td>
                    <td class="active2"><b>{{$inversion->total}}</b></td>
                </tr>
                
                    <tr style="text-align: right" class="texto-tabla">
                        <td class="active2 text-center"><b>Financiera</b></td>
                        <td class="financieratar text-center"> S/. </td>
                        <td class="financieratar">{{$inversion->esp_enero}}</td>
                        <td class="financieratar">{{$inversion->esp_febrero}}</td>
                        <td class="financieratar">{{$inversion->esp_marzo}}</td>
                        <td class="active2"><b>{{$inversion->esp_enero+$inversion->esp_febrero+$inversion->esp_marzo}}</b></td>
                        <td class="financieratar">{{$inversion->esp_abril}}</td>
                        <td class="financieratar">{{$inversion->esp_mayo}}</td>
                        <td class="financieratar">{{$inversion->esp_junio}}</td>
                        <td class="active2"><b>{{$inversion->esp_abril+$inversion->esp_mayo+$inversion->esp_junio}}</b></td>
                        <td class="financieratar">{{$inversion->esp_julio}}</td>
                        <td class="financieratar">{{$inversion->esp_agosto}}</td>
                        <td class="financieratar">{{$inversion->esp_setiembre}}</td>
                        <td class="active2"><b>{{$inversion->esp_julio+$inversion->esp_agosto+$inversion->esp_setiembre}}</b></td>
                        <td class="financieratar">{{$inversion->esp_octubre}}</td>
                        <td class="financieratar">{{$inversion->esp_noviembre}}</td>
                        <td class="financieratar">{{$inversion->esp_diciembre}}</td>
                        <td class="active2"><b>{{$inversion->esp_octubre+$inversion->esp_noviembre+$inversion->esp_diciembre}}</b></td>
                        <td class="active2"><b>{{$inversion->esp_monto_total}}</b></td>
                    </tr>
                @php($tar++)
                @endforeach
                @endif
                <!---------------------------------------------------> 
                            
                <tr style="text-align: center">
                    <td class="active2" rowspan="2">
                        <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#tarea_modal"><i class="glyphicon glyphicon-plus"></i> Act. {{$tar}}</button>
                        
                        <!-------------------------Modal------------------------------------------------------------>
                        <div class="modal fade bd-example-modal-lg" id="tarea_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Nueva Actividad Operativa - Inversiones {{$i}}</h4>
                                </div>
                                {!!Form::open(['url'=>'poi/anteproyecto/guardarf2', 'class'=>'form-horizontal'])!!}
                                <div class="modal-body">
                                    {!!Form::hidden('idactividad_proyecto', $id, ['class'=>'form-control', 'id'=>'idactividad_proyecto'])!!}
                                    {!!Form::hidden('actividad_numero', $i, ['class'=>'form-control', 'id'=>'actividad_numero'])!!}
                                    <div class="form-group">
                                        {!!Form::label('Denominación', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            <textarea class="form-control" id="actividad_denominacion" name="actividad_denominacion" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Indicador', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_indicador', '', ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_indicador'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Unid. Medida', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_unidad_medida', '', ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_unidad_medida'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Descripción', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            <textarea class="form-control" id="actividad_descripcion" name="actividad_descripcion" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Tareas Ope.', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            <textarea class="form-control" id="actividad_tareas_operativas" name="actividad_tareas_operativas" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Beneficiarios', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_beneficiarios', '', ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_beneficiarios'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Localización', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_localizacion', '', ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_localizacion'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!!Form::label('Prioridad OEI', null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::text('actividad_prioridad', '', ['class'=>'form-control', 'required'=>'', 'id'=>'actividad_prioridad'])!!}
                                        </div>
                                    </div>                                   
                                    <div class="form-group">
                                        {!!Form::label('Cantidad',null, ['class'=>'col-sm-2 control-label'])!!}
                                        <div class="col-sm-9 input-group">
                                            {!!Form::number('actividad_fisica_total', '', ['class'=>'form-control', 'readonly'=>'true', 'id'=>'actividad_fisica_total', 'placeholder'=>'Ingrese la Cant. para cada Mes'])!!}
                                            <div class="hide alert alert-danger">La cantidad debe de ser mayor a 0</div>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table-bordered table-condensed">
                                        <thead class="active2">
                                            <tr>
                                                <th class="text-center">Enero</th>
                                                <th class="text-center">Febrero</th>
                                                <th class="text-center">Marzo</th>
                                                <th class="text-center">Abril</th>
                                                <th class="text-center">Mayo</th>
                                                <th class="text-center">Junio</th>
                                                <th class="text-center">Julio</th>
                                                <th class="text-center">Agosto</th>
                                                <th class="text-center">Setiembre</th>
                                                <th class="text-center">Octubre</th>
                                                <th class="text-center">Noviembre</th>
                                                <th class="text-center">Diciembre</th>
                                            </tr>                            
                                        </thead>
                                        <tbody class="active2">
                                            <tr>
                                                <td>{!!Form::text('actividad_fisica_enero', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_enero'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_febrero', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_febrero'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_marzo', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_marzo'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_abril', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_abril'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_mayo', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_mayo'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_junio', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_junio'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_julio', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_julio'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_agosto', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_agosto'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_setiembre', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_setiembre'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_octubre', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_octubre'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_noviembre', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_noviembre'])!!}</td>
                                                <td>{!!Form::text('actividad_fisica_diciembre', '0', ['class'=>'form-control sumar2', 'id'=>'actividad_fisica_diciembre'])!!}</td>
                                            </tr>
                                        </tbody>                        
                                    </table>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" name="cancel">Cancelar</button>
                                  <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                                {!!Form::close()!!}
                              </div>
                            </div>
                        </div>
                        <!-------------------------Fin Modal------------------------------------------------------------>
                    </td>
        <!--FIN CUERPO 3-->                   
            </tbody>
        </table>
    <!--FIN 4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->                      
    <!--LISTA TAREAS,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,-->     
    
        </div>
    </div>    
    <div class="col-xs-12">
        <a href="#" onclick="javascript:window.close()" class="btn btn-danger"><i class="glyphicon glyphicon-off"></i> Salir</a>
        <a href="{{url('poi/exportarf2/'.$id)}}" class="btn btn-primary"><i class="glyphicon glyphicon-save-file"></i> Excel</a>
        <a href="{{url('poi/huamalies/'.$id.'/edit')}}" class="btn btn-warning pull-right"><span class="glyphicon glyphicon-pencil"></span> Editar</a>        
    </div>
    <br> <br>
</div>    
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACT
<!------------------------------------------------------------------------------------------------------------------------------->  
<!-- Select2 -->
<script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script>
    
    $(".select2-container").select2();
    
    $('document').ready(function(){
        $('.sumar').keyup(function(){
            var valortotal = $(this).parent().parent().parent().parent().parent();
            //alert(123);
            var value = (parseFloat(valortotal.find('#actividad_fisica_enero_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_febrero_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_marzo_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_abril_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_mayo_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_junio_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_julio_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_agosto_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_setiembre_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_octubre_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_noviembre_edit').val()) + parseFloat(valortotal.find('#actividad_fisica_diciembre_edit').val()));            
            valortotal.find('#actividad_fisica_total_edit').val( value.toFixed(2) );
        });
    });
    
    $('document').ready(function(){
        $('.sumar2').keyup(function(){
            var value = (parseFloat($('#actividad_fisica_enero').val()) + parseFloat($('#actividad_fisica_febrero').val()) + parseFloat($('#actividad_fisica_marzo').val()) + parseFloat($('#actividad_fisica_abril').val()) + parseFloat($('#actividad_fisica_mayo').val()) + parseFloat($('#actividad_fisica_junio').val()) + parseFloat($('#actividad_fisica_julio').val()) + parseFloat($('#actividad_fisica_agosto').val()) + parseFloat($('#actividad_fisica_setiembre').val()) + parseFloat($('#actividad_fisica_octubre').val()) + parseFloat($('#actividad_fisica_noviembre').val()) + parseFloat($('#actividad_fisica_diciembre').val()));            
            $("#actividad_fisica_total").val( value );
        });
    });
    
    $('#tarea_modal').find('form').submit(function (event) {
	    selector = "#actividad_fisica_total";
        input =$(selector);
        if((input.val()>0)){}
        else {
            input.next().removeClass('hide');
            event.preventDefault();
        }
    })    
    
    $(document).ready(function() {
      $(".js-example-basic-single").select2();
    });
</script>
</body>

</html>