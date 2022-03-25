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
    <script>
      $(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
    </script>
    
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
        
        .texto-modal{
            font-family: Tahoma;
            font-size: 10px;
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
        
        /*------------------------------class = "success"------------------------------------*/
        .success2 {
            background-color: #C4D79B; 
        }

        .success2 th {
            background-color: #C4D79B; 
        }

        .success2 td {
            background-color: #C4D79B; 
        }
        /*------------------------------class = "success"------------------------------------*/

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
        
        .chosen-container {
            width: 100% !important;
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
                    <th class="texto" width="100%">FORMATO F-3: CUADRO DE ASIGNACIÓN POR INSUMOS DE LA ACTIVIDAD OPERATIVA / ACCIÓN DE INVERSIÓN</th>
                </tr>
            </thead>            
        </table>
    <!--FIN TITULO-->
       
    <!--3. ARTICULACIÓN PRESUPUESTARIA-->     
        <table class="table table-bordered table-condensed texto-tabla table-mihover">    
            <thead>
                <tr class="info2">
                    <th colspan="28">3. PROGRAMACIÓN DE ESPECÍFICAS DE GASTOS</th>
                </tr>
            </thead>
            <tbody style="text-align: center">   
                <!------------------------------------- PROGRAMACIÓN -------------------------------------->
                <tr>
                    <td class="active2" rowspan="2"><b>CENTRO DE COSTO</b></td>
                    <td class="active2" rowspan="2"><b>ACTIVIDAD / ACCIÓN DE INVERSIÓN</b></td>
                    <td class="active2" rowspan="2"><b>INDICADOR</b></td>
                    <td class="active2" rowspan="2"><b>UNIDAD DE MEDIDA</b></td>
                    <td class="active2" rowspan="2"><b>META ANUAL</b></td>
                    <td class="active2" rowspan="2"><b>F.F.</b></td>
                    <td class="active2" colspan="5"><b>CLASIFICADOR</b></td>
                    <td class="active2" rowspan="2" width="10%" colspan="2"><b>DESCRIPCIÓN</b></td>
                    <td class="active2" rowspan="2"><b>UNIDAD DE MEDIDA</b></td>
                    <td class="active2" rowspan="2"><b>CANTIDAD</b></td>
                    <td class="active2" colspan="12"><b>PROGRAMACIÓN MENSUAL</b></td>
                    <td class="active2" rowspan="2"><b>TOTAL</b></td>
                </tr>
                <tr class="active2">
                    <td><b>GG</b></td>
                    <td><b>Sub G1</b></td>
                    <td><b>Sub G2</b></td>
                    <td><b>Esp 1</b></td>
                    <td><b>Esp 2</b></td>
                    <td width="4%"><b>Ene</b></td>
                    <td width="4%"><b>Feb</b></td>
                    <td width="4%"><b>Mar</b></td>
                    <td width="4%"><b>Abr</b></td>
                    <td width="4%"><b>May</b></td>
                    <td width="4%"><b>Jun</b></td>
                    <td width="4%"><b>Jul</b></td>
                    <td width="4%"><b>Ago</b></td>
                    <td width="4%"><b>Set</b></td>
                    <td width="4%"><b>Oct</b></td>
                    <td width="4%"><b>Nov</b></td>
                    <td width="4%"><b>Dic</b></td>
                </tr>
                @php($i=0)
                @php($ins=1)
                @if($insumorows!=0)
                @foreach($insumos AS $insumo)
                    <tr>
                        @if($i==0)
                            <td rowspan="{{$insumorows}}">{{$actividad->nomofi}}</td>
                            <td rowspan="{{$insumorows}}">{{$inversion->denominacion}}</td>
                            <td rowspan="{{$insumorows}}">{{$inversion->indicador}}</td>
                            <td rowspan="{{$insumorows}}">{{$inversion->um}}</td>
                            <td rowspan="{{$insumorows}}">{{$inversion->total}}</td>
                            @php($i++)
                        @endif
                        <td>{{$insumo->fuente}}</td>
                        @php
                            $str = $insumo->clasificador->cg_clasificador;
                            $separar = str_replace(" ", ".",$str);
                            $clasificador = explode(".",$separar);
                        @endphp
                        <td>{{$clasificador[0]}}.{{$clasificador[1]}}</td>
                        <td>{{$clasificador[2]}}</td>
                        <td>{{$clasificador[3]}}</td>
                        <td>{{$clasificador[4]}}</td>
                        <td>{{$clasificador[5]}}</td>
                        <td>                            
                            {{$insumo->clasificador->cg_descripcion}}
                        </td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#{{$insumo->id}}" title="Editar - {{$insumo->id}}"><span class="glyphicon glyphicon-pencil text-center" style="font-size: 11px; color: black; padding-bottom:10px;"></span></a>
                        <!-------------------------Modal------------------------------------------------------------>
                            <div class="modal fade bd-example-modal-lg" id="{{$insumo->id}}" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
                                <div id="editinsumo">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <h4 class="modal-title" id="myModalLabel" style="text-align: center"><b>EDITAR: Insumo N° {{$ins}}</b></h4>
                                    </div>
                                    {!!Form::open(['url'=>'poi/anteproyecto/editarinsumos/'.$insumo->id, 'class'=>'form-horizontal'])!!}
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        {!!Form::hidden('especifica_id_actividad_actividad_edit', $inv, ['class'=>'form-control', 'id'=>'especifica_id_actividad_actividad_edit'])!!}
                                        {!!Form::hidden('especifica_id_actividad_proyecto_edit', $act, ['class'=>'form-control', 'id'=>'especifica_id_actividad_proyecto_edit'])!!}
                                        <div class="form-group">
                                            {!!Form::label('Fuente Finan.', null, ['class'=>'col-sm-2 control-label'])!!}
                                            <div class="col-sm-9 input-group">
                                                <select name="especifica_fuente_financiamiento_edit" id="especifica_fuente_financiamiento_edit" class="form-control" required>
                                                    <option value> Seleccione Opción</option>  
                                                    @if($insumo->fuente == 1)
                                                        <option value="1" selected>1.RO-Recursos Ordinarios</option>   
                                                        <option value="2">2.RDR-Recursos Directamente Recudados</option>
                                                        <option value="3">3.ROOC-Recursos por Operaciones Oficiales de Crédito</option>
                                                        <option value="4">4.DyT-Donaciones y Tranferencias</option>
                                                        <option value="5">5.RD-Recursos Determinados</option>
                                                    @elseif($insumo->fuente == 2)
                                                        <option value="1">1.RO-Recursos Ordinarios</option>   
                                                        <option value="2" selected>2.RDR-Recursos Directamente Recudados</option>
                                                        <option value="3">3.ROOC-Recursos por Operaciones Oficiales de Crédito</option>
                                                        <option value="4">4.DyT-Donaciones y Tranferencias</option>
                                                        <option value="5">5.RD-Recursos Determinados</option>
                                                    @elseif($insumo->fuente == 3)
                                                        <option value="1">1.RO-Recursos Ordinarios</option>   
                                                        <option value="2">2.RDR-Recursos Directamente Recudados</option>
                                                        <option value="3" selected>3.ROOC-Recursos por Operaciones Oficiales de Crédito</option>
                                                        <option value="4">4.DyT-Donaciones y Tranferencias</option>
                                                        <option value="5">5.RD-Recursos Determinados</option>
                                                    @elseif($insumo->fuente == 4)
                                                        <option value="1">1.RO-Recursos Ordinarios</option>   
                                                        <option value="2">2.RDR-Recursos Directamente Recudados</option>
                                                        <option value="3">3.ROOC-Recursos por Operaciones Oficiales de Crédito</option>
                                                        <option value="4" selected>4.DyT-Donaciones y Tranferencias</option>
                                                        <option value="5">5.RD-Recursos Determinados</option>
                                                    @elseif($insumo->fuente == 5)
                                                        <option value="1">1.RO-Recursos Ordinarios</option>   
                                                        <option value="2">2.RDR-Recursos Directamente Recudados</option>
                                                        <option value="3">3.ROOC-Recursos por Operaciones Oficiales de Crédito</option>
                                                        <option value="4">4.DyT-Donaciones y Tranferencias</option>
                                                        <option value="5" selected>5.RD-Recursos Determinados</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group text-left">
                                            {!!Form::label('Específica', null, ['class'=>'col-sm-2 control-label'])!!}
                                            <div class="col-sm-9 input-group">
                                                <select name="especifica_clasificador_gastos_edit" id="especifica_clasificador_gastos_edit" class="chosen-select" required>
                                                    <option value> Seleccione Opción</option>
                                                    @foreach($gastos AS $gasto)
                                                        @if($insumo->especifica_clasificador_gastos == $gasto->id)
                                                            <option value="{{$gasto->id}}" selected>{{$gasto->clasificador}} - {{$gasto->nombre}}</option>
                                                        @else
                                                            <option value="{{$gasto->id}}">{{$gasto->clasificador}} - {{$gasto->nombre}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!!Form::label('Unid. Medida', null, ['class'=>'col-sm-2 control-label'])!!}
                                            <div class="col-sm-9 input-group">
                                                {!!Form::text('especifica_unidad_medida_edit', $insumo->um, ['class'=>'form-control', 'required'=>'', 'placeholder'=>'Ingrese la Unid. de Medida', 'id'=>'especifica_unidad_medida_edit'])!!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!!Form::label('Cant.(insumo)', null, ['class'=>'col-sm-2 control-label'])!!}
                                            <div class="col-sm-9 input-group">
                                                {!!Form::number('especifica_cantidad_edit', $insumo->cantidad, ['class'=>'form-control', 'required'=>'', 'placeholder'=>'Ingrese la Cantidad(Insumo)', 'id'=>'especifica_cantidad_edit'])!!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {!!Form::label('Monto Total', null, ['class'=>'col-sm-2 control-label'])!!}
                                            <div class="col-sm-9 input-group">
                                                {!!Form::number('especifica_monto_total_edit', $insumo->monto, ['class'=>'form-control', 'id'=>'especifica_monto_total_edit', 'placeholder'=>'Ingrese el Monto para cada mes', 'readonly'])!!}
                                            </div>
                                        </div>
                                        <br>
                                        <table class="table-bordered table-condensed success2">
                                            <thead class="info">
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
                                            <tbody>
                                                <tr>
                                                    <td>{!!Form::text('edit_enero', $insumo->enero, ['class'=>'form-control suma', 'id'=>'edit_enero'])!!}</td>
                                                    <td>{!!Form::text('edit_febrero', $insumo->febrero, ['class'=>'form-control suma', 'id'=>'edit_febrero'])!!}</td>
                                                    <td>{!!Form::text('edit_marzo', $insumo->marzo, ['class'=>'form-control suma', 'id'=>'edit_marzo'])!!}</td>
                                                    <td>{!!Form::text('edit_abril', $insumo->abril, ['class'=>'form-control suma', 'id'=>'edit_abril'])!!}</td>
                                                    <td>{!!Form::text('edit_mayo', $insumo->mayo, ['class'=>'form-control suma', 'id'=>'edit_mayo'])!!}</td>
                                                    <td>{!!Form::text('edit_junio', $insumo->junio, ['class'=>'form-control suma', 'id'=>'edit_junio'])!!}</td>
                                                    <td>{!!Form::text('edit_julio', $insumo->julio, ['class'=>'form-control suma', 'id'=>'edit_julio'])!!}</td>
                                                    <td>{!!Form::text('edit_agosto', $insumo->agosto, ['class'=>'form-control suma', 'id'=>'edit_agosto'])!!}</td>
                                                    <td>{!!Form::text('edit_setiembre', $insumo->setiembre, ['class'=>'form-control suma', 'id'=>'edit_setiembre'])!!}</td>
                                                    <td>{!!Form::text('edit_octubre', $insumo->octubre, ['class'=>'form-control suma', 'id'=>'edit_octubre'])!!}</td>
                                                    <td>{!!Form::text('edit_noviembre', $insumo->noviembre, ['class'=>'form-control suma', 'id'=>'edit_noviembre'])!!}</td>
                                                    <td>{!!Form::text('edit_diciembre', $insumo->diciembre, ['class'=>'form-control suma', 'id'=>'edit_diciembre'])!!}</td>
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
                            </div>
                            <!-------------------------Fin Modal-----------------------------------------------------> {!!Form::open(['class'=>'form-horizontal'])!!}   
                            {{csrf_field()}}
                                <a href="{{ url('poi/anteproyecto/deleteinsumos/'.$act.'/'.$inv.'/'.$insumo->id) }}" title="Eliminar"><span class="glyphicon glyphicon-trash del" style="font-size: 11px; color: black;"></span></a>
                            {!!Form::close()!!}
                        <br><br>
                        </td>
                        <td>{{$insumo->um}}</td>
                        <td>{{$insumo->cantidad}}</td>
                        <td>{{$insumo->enero}}</td>
                        <td>{{$insumo->febrero}}</td>
                        <td>{{$insumo->marzo}}</td>
                        <td>{{$insumo->abril}}</td>
                        <td>{{$insumo->mayo}}</td>
                        <td>{{$insumo->junio}}</td>
                        <td>{{$insumo->julio}}</td>
                        <td>{{$insumo->agosto}}</td>
                        <td>{{$insumo->setiembre}}</td>
                        <td>{{$insumo->octubre}}</td>
                        <td>{{$insumo->noviembre}}</td>
                        <td>{{$insumo->diciembre}}</td>
                        <td>{{$insumo->monto}}</td>
                    </tr>
                    @php($ins++)
                @endforeach
                
                <!------------------------------------- PROGRAMACIÓN -------------------------------------->
                
                <!------------------------------------- SUB TOTAL ----------------------------------------->
                <tr class="success2">
                    <td colspan="13" class="text-center"><b>SUB TOTAL</b></td>
                    <td></td>
                    <td><b>{{$totalins->total_cantidad}}</b></td>
                    <td><b>{{$totalins->total_enero}}</b></td>
                    <td><b>{{$totalins->total_febrero}}</b></td>
                    <td><b>{{$totalins->total_marzo}}</b></td>
                    <td><b>{{$totalins->total_abril}}</b></td>
                    <td><b>{{$totalins->total_mayo}}</b></td>
                    <td><b>{{$totalins->total_junio}}</b></td>
                    <td><b>{{$totalins->total_julio}}</b></td>
                    <td><b>{{$totalins->total_agosto}}</b></td>
                    <td><b>{{$totalins->total_setiembre}}</b></td>
                    <td><b>{{$totalins->total_octubre}}</b></td>
                    <td><b>{{$totalins->total_noviembre}}</b></td>
                    <td><b>{{$totalins->total_diciembre}}</b></td>
                    <td><b>{{$totalins->total_monto}}</b></td>
                </tr>
                @endif
            </tbody>
        </table>
    <!--FIN 3. ARTICULACIÓN PRESUPUESTARIA-->         
        <div>
            <a href="{{url('poi/anteproyecto/f2/'.$act)}}" class="btn btn-primary"><i class="glyphicon glyphicon-fast-backward"></i> Atras</a> 
            <button class="btn btn-success pull-right" data-toggle="modal" data-target="#adinsumo"><i class="glyphicon glyphicon-plus"></i> Insumos</button>
            <!-------------------------Modal------------------------------------------------------------>
            <div class="modal fade bd-example-modal-lg texto-modal" id="adinsumo" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h5 class="modal-title" id="myModalLabel" style="text-align: center"><b>Agregar Insumo a la Actividad: </b><br>{{$inversion->denominacion}}</h5>
                    </div>
                    {!!Form::open(['url'=>'poi/anteproyecto/guardarinsumosf2', 'class'=>'form-horizontal'])!!}
                    <div class="modal-body">
                        {!!Form::hidden('especifica_id_actividad_proyecto', $act, ['class'=>'form-control', 'id'=>'especifica_id_actividad_proyecto'])!!}
                        {!!Form::hidden('especifica_id_actividad_actividad', $inv, ['class'=>'form-control', 'id'=>'especifica_id_actividad_actividad'])!!}
                        <div class="form-group">
                            {!!Form::label('Fuente Finan.', null, ['class'=>'col-sm-2 control-label'])!!}
                            <div class="col-sm-9 input-group">
                                <select name="especifica_fuente_financiamiento" id="fuente_financiamiento_actividad" class="form-control" required>
                                    <option value> Seleccione Opción</option>
                                    <option value="1">1.RO-Recursos Ordinarios</option>
                                    <option value="2">2.RDR-Recursos Directamente Recudados</option>
                                    <option value="3">3.ROOC-Recursos por Operaciones Oficiales de Crédito</option>
                                    <option value="4">4.DyT-Donaciones y Tranferencias</option>
                                    <option value="5">5.RD-Recursos Determinados</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-left">
                            {!!Form::label('Específica', null, ['class'=>'col-sm-2 control-label'])!!}
                            <div class="col-sm-9 input-group">
                                <select name="especifica_clasificador_gastos" id="especifica_clasificador_gastos" class="chosen-select" required>
                                    <option value> Seleccione Opción</option>
                                    @foreach($gastos AS $gasto)
                                        <option value="{{$gasto->id}}">{{$gasto->clasificador}} - {{$gasto->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('Unid. Medida', null, ['class'=>'col-sm-2 control-label'])!!}
                            <div class="col-sm-9 input-group">
                                {!!Form::text('especifica_unidad_medida', null, ['class'=>'form-control', 'required'=>'', 'placeholder'=>'Ingrese la Unid. de Medida', 'id'=>'especifica_unidad_medida'])!!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!!Form::label('Cant.(insumo)', null, ['class'=>'col-sm-2 control-label'])!!}
                            <div class="col-sm-9 input-group">
                                {!!Form::number('especifica_cantidad', null, ['class'=>'form-control', 'required'=>'', 'placeholder'=>'Ingrese la Cantidad(Insumo)', 'id'=>'especifica_cantidad'])!!}
                            </div>
                        </div>
                        <!--<div class="form-group">
                            {!!Form::label('Costo Ref.', null, ['class'=>'col-sm-2 control-label'])!!}
                            <div class="col-sm-9 input-group">
                                {!!Form::number('especifica_costo_referencial', null, ['class'=>'form-control', 'required'=>'', 'placeholder'=>'Ingrese la Cantidad(Insumo)', 'id'=>'especifica_costo_referencial'])!!}
                            </div>
                        </div>-->
                        <div class="form-group">
                            {!!Form::label('Monto Total',null, ['class'=>'col-sm-2 control-label'])!!}
                            <div class="col-sm-9 input-group">
                                {!!Form::number('especifica_monto_total', '', ['class'=>'form-control', 'id'=>'especifica_monto_total', 'placeholder'=>'Ingrese el Monto para cada mes', 'readonly'])!!}
                                <div class="hide alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>La cantidad debe de ser mayor a 0</div>
                            </div>
                        </div>
                        <br>
                        <table class="table-bordered table-condensed">
                            <thead class="success2">
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
                            <tbody class="success2">
                                <tr>
                                    <td>{!!Form::text('esp_enero', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_enero'])!!}</td>
                                    <td>{!!Form::text('esp_febrero', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_febrero'])!!}</td>
                                    <td>{!!Form::text('esp_marzo', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_marzo'])!!}</td>
                                    <td>{!!Form::text('esp_abril', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_abril'])!!}</td>
                                    <td>{!!Form::text('esp_mayo', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_mayo'])!!}</td>
                                    <td>{!!Form::text('esp_junio', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_junio'])!!}</td>
                                    <td>{!!Form::text('esp_julio', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_julio'])!!}</td>
                                    <td>{!!Form::text('esp_agosto', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_agosto'])!!}</td>
                                    <td>{!!Form::text('esp_setiembre', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_setiembre'])!!}</td>
                                    <td>{!!Form::text('esp_octubre', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_octubre'])!!}</td>
                                    <td>{!!Form::text('esp_noviembre', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_noviembre'])!!}</td>
                                    <td>{!!Form::text('esp_diciembre', '0.00', ['class'=>'form-control suma2', 'id'=>'esp_diciembre'])!!}</td>
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
        </div>
    </div>
    </div>    
    <br> <br>    
</div>    
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACT
<!------------------------------------------------------------------------------------------------------------------------------->  
<!-- Select2 -->
<script src="{{asset('plugins/select2/select2.full.min.js')}}"></script>
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script>
    $(document).ready(function() {
        $(".del").click(function(event) {
            if (!confirm("¿Realmente desea Eliminar?"))
                event.preventDefault();
        })
    });
    
    $('document').ready(function(){
        $('.suma').keyup(function(){
            var valortotal = $(this).parent().parent().parent().parent().parent();
           // alert(123);
            var value = (parseFloat(valortotal.find('#edit_enero').val()) + parseFloat(valortotal.find('#edit_febrero').val()) + parseFloat(valortotal.find('#edit_marzo').val()) + parseFloat(valortotal.find('#edit_abril').val()) + parseFloat(valortotal.find('#edit_mayo').val()) + parseFloat(valortotal.find('#edit_junio').val()) + parseFloat(valortotal.find('#edit_julio').val()) + parseFloat(valortotal.find('#edit_agosto').val()) + parseFloat(valortotal.find('#edit_setiembre').val()) + parseFloat(valortotal.find('#edit_octubre').val()) + parseFloat(valortotal.find('#edit_noviembre').val()) + parseFloat(valortotal.find('#edit_diciembre').val()));            
            valortotal.find('#especifica_monto_total_edit').val( value.toFixed(2) );
        });
    }); 
    
    $(".select2-container").select2();
    
    $('#adinsumo').find('form').submit(function (event) {
	    selector = "#especifica_monto_total";
        input =$(selector);
        if((input.val()>0)){}
        else {
            input.next().removeClass('hide');
            event.preventDefault();
        }
    })
    
    $('document').ready(function(){
        $('.suma2').keyup(function(){
            var value = (parseFloat($('#esp_enero').val()) + parseFloat($('#esp_febrero').val()) + parseFloat($('#esp_marzo').val()) + parseFloat($('#esp_abril').val()) + parseFloat($('#esp_mayo').val()) + parseFloat($('#esp_junio').val()) + parseFloat($('#esp_julio').val()) + parseFloat($('#esp_agosto').val()) + parseFloat($('#esp_setiembre').val()) + parseFloat($('#esp_octubre').val()) + parseFloat($('#esp_noviembre').val()) + parseFloat($('#esp_diciembre').val()));            
            $("#especifica_monto_total").val( value.toFixed(2) );
        });
    });     
    
    $(document).ready(function() {
      $(".js-example-basic-single").select2();
    });
</script>
</body>

</html>