<!DOCTYPE html>
<html lang="en">

<head>
    <title>HUAMALIES</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen">
    
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/select2.min.css')}}">
    <style>                
        table, th, td {
            font-size:10px;
            font-family: Tahoma;
        }
        
        texto{
            font-size:6px;
            font-family: Tahoma;
        }
        
        /*------------------------------class = "table"------------------------------------*/
        table{
            border-collapse: collapse;
            text-align: left;
            width: 100%;  
            font-family: Tahoma;  
            background: #fff;
            border: 1px solid #DDDDDD; 
            margin-bottom: 10px;
        }

        table thead th {    
            color: #333333;  
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 11px;
            font-weight: bold;
            border-bottom: 2px solid #DDDDDD;  
            border-left: 1px solid #DDDDDD;  
        }

        table tbody td {
            color: #333333;    
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 11px;  
            font-weight: normal;  
            border: 1px solid #DDDDDD; 
        }
        /*------------------------------class = "table"------------------------------------*/

        /*------------------------------class = "primary"------------------------------------*/
        .info2 {
            background-color: #B5D4EB; 
        }

        .info2 th {
            background-color: #B5D4EB; 
        }

        .info2 td {
            background-color: #B5D4EB; 
        }
        /*------------------------------class = "primary"------------------------------------*/

        /*------------------------------class = "info2"------------------------------------*/
        .active2 {
            background-color: #EAEAEA; 
        }

        .active2 th {
            background-color: #EAEAEA; 
        }

        .active2 td {
            background-color: #EAEAEA; 
        }
        /*------------------------------class = "info2"------------------------------------*/
        .footnotes { 
            page-break-after:always; 
        }
        
        .table-mihover>tbody>tr:hover {
            background-color: #EFDA9C
        }
        
        .chosen-container {
            width: 100% !important;
        }
    </style>
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('js/jQuery.print.js')}}"></script>
</head>

<body>   
    <div style="page-break-before: always; page-break-after: always; page-break-inside:always;">
        
<!--FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->
    <div id="myPrintArea" class="container-fluid">
        <div>
            <h3></h3>    
        </div>
        
        <!--<p>The .table class adds basic styling (light padding-top and only horizontal dividers) to a table:</p>-->
    <!--TITULO-->
        <table class="table table-bordered">
            <thead>
                <tr bgcolor="#B5D4EB">
                    <th style="text-align: center" width="100%">FORMATO F-2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO</th>
                </tr>
            </thead>            
        </table>
    <!--FIN TITULO-->
       
    <!--1. info2RMACIÓN GENERA-->    
        <table class="table table-bordered table-condensed">    
            <thead>
                <tr class="info2">
                    <th width="100%" colspan="6">1. INFORMACIÓN GENERAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="15%" class="active2"><b>1.1. Unidad Ejecutora</b></td>
                    <td width="25%" style="text-align: center">{{$actividades->unieje}}.- {{strtoupper($actividades->nomunieje)}}</td>
                    <td width="15%" class="active2"><b>1.2. Unidad Orgánica</b></td>
                    <td width="25%" style="text-align: center">{{strtoupper($actividades->nomofi)}}</td>
                    <td width="10%" class="active2"><b>1.3. Año</b></td>
                    <td width="10%" style="text-align: center">{{$actividades->anio}}</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 1. info2RMACIÓN GENERA--> 
       
    <!--2. ALINEAMIENTO ESTRATÉGICO-->     
        <table class="table table-bordered table-condensed" width="100%">    
            <thead>
                <tr class="info2">
                    <th colspan="8">2. ALINEAMIENTO ESTRATÉGICO</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                <tr>
                    <td class="active2" colspan="2"><b>2.1. Visión Regional</b></td>
                    <td colspan="2">{{$vision->vision}}</td>
                    <td class="active2"><b>2.2. Misión Institucional</b></td>
                    <td colspan="3">{{$mision->mision}}</td>
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
        <table class="table table-bordered table-condensed">    
            <thead>
                <tr class="info2">
                    <th colspan="9">3. ARTICULACIÓN PRESUPUESTARIA</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                <tr>
                    <td class="active2" rowspan="4" style="padding-top: 30px"><b>3.1. Categoría Presupuestal</b></td>
                    <td class="active2"><b>3.2. Código</b></td>
                    <td class="active2" colspan="3"><b>3.3. Denominación</b></td>
                    <td class="active2" colspan="2" rowspan="3" style="padding-top: 30px"><b>3.4. Resultado Final o Específico</b></td>
                    <td class="active2" rowspan="3" style="padding-top: 30px"><b>3.5. Inidicador</b></td>
                    <td class="active2" rowspan="3" style="padding-top: 30px"><b>3.6. Meta</b></td>
                </tr>          
                <tr>
                    @if($actividades->categoria==9001)
                        <td class="info2"><b> 9001</b></td> 
                        <td colspan="3" class="info2">Acciones Centrales</td>    
                    @else
                        <td> - </td> 
                        <td colspan="3"> - </td>
                    @endif
                </tr>
                
                <tr>
                    @if($actividades->categoria==9002)
                        <td class="info2"><b> 9002</b></td>    
                        <td colspan="3" class="info2">Asignación Presupuestaria que no resulta en Productos</td> 
                    @else
                        <td> - </td> 
                        <td colspan="3"> - </td>
                    @endif   
                </tr>
                
                <tr>
                    @if($actividades->categoria!=9002 && $actividades->categoria!=9001)
                        <td class="info2"><b> {{$actividades->categoria}}</b></td>    
                        <td colspan="3" class="info2">{{$prog_p->nombre}}</td>    
                        <td colspan="2" class="info2">(Resultado final o específico del PP)</td>    
                        <td class="info2">(Indicador del PP)</td>    
                        <td class="info2">(Meta del PP)</td>
                    @else
                        <td> - </td> 
                        <td colspan="3"> - </td>
                        <td colspan="2"> - </td>
                        <td> - </td>
                        <td> - </td>
                    @endif
                </tr>
                
                <tr>
                    <td class="active2" rowspan="2"><b>3.7. Estructura Funcional Programática</b></td>
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
        <table class="table table-bordered table-condensed"> 
        <!--TITULOS-->     
            <tbody>
                <tr class="info2">
                    <th colspan="20">4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD</th>
                </tr>
            </tbody>
        <!--FIN TITULOS-->
        
        <!--SUBTITULOS-->
            <tbody>
                <tr style="text-align: center">
                    <td class="active2" rowspan="2"><b>4.1. Unidad Responsable</b></td>
                    <td class="active2" rowspan="2"><b>4.2. Código</b></td>
                    <td class="active2" colspan="4" rowspan="2"><b>4.3. Denominacion de la Actividad</b></td>
                    <td class="active2" colspan="3" rowspan="2"><b>4.4. Indicador</b></td>
                    <td class="active2" colspan="2" rowspan="2"><b>4.5. Unidad de Medida</b></td>
                    <td class="active2" colspan="4"><b>4.6. Meta Anual</b></td>
                    <td class="active2" colspan="5"><b>4.7. Fuente de Financiamiento</b></td>
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
                <tr style="text-align: center">
                    <td>{{$actividades->uniresponsable}}</td>
                    <td>{{$actividades->actid}}</td>
                    <td colspan="4">{{$actividades->nomact}}</td>
                    <td colspan="3">{{$actividades->indicador}}</td>
                    <td colspan="2">{{$actividades->medida}}</td>
                    <td colspan="2">{{$actividades->fisica}}</td>
                    <td colspan="2">{{$fuente->total}}</td>
                    @if($actividades->fuente1 == 1)
                        <td> {{$fuente->total}} </td>
                    @else
                        <td></td>
                    @endif
                    
                    @if($actividades->fuente2 == 2)
                        <td> {{$fuente->total}} </td>
                    @else
                        <td></td>
                    @endif
                    
                    @if($actividades->fuente3 == 3)
                        <td> {{$fuente->total}} </td>
                    @else
                        <td></td>
                    @endif
                    
                    @if($actividades->fuente4 == 4)
                        <td> {{$fuente->total}} </td>
                    @else
                        <td></td>
                    @endif
                    
                    @if($actividades->fuente5 == 5)
                        <td> {{$fuente->total}} </td>
                    @else
                        <td></td>
                    @endif
                </tr> 
        <!--FIN CUERPO 1-->
                       
        <!--CUERPO 2-->
                <tr style="text-align: center">
                    <td class="active2" colspan="2"><b>4.8. Actividad-Proyecto</b></td>
                    <td class="active2" colspan="6"><b>4.8.1. Descripción</b></td>
                    <td class="active2" colspan="3"><b>4.8.2. Localización</b></td>
                    <td class="active2" colspan="3"><b>4.8.3. Beneficiarios</b></td>
                    <td class="active2" colspan="4"><b>4.8.4. Estrategia(s) Operativa(s)</b></td>
                    <td class="active2" colspan="2"><b>4.9. Prioridad</b></td>
                </tr>
                   
                <tr style="text-align: center">
                    <td colspan="2">{{$actividades->nomact}}</td>
                    <td colspan="6">{{$actividades->descripcion}}</td>
                    <td colspan="3">{{$actividades->local}}</td>
                    <td colspan="3">{{$actividades->beneficio}}</td>
                    <td colspan="4">{{$actividades->estrategia}}</td>
                    @if($actividades->prioridad==1)
                        <td colspan="2">NORMAL</td>
                    @else
                        <td colspan="2">URGENTE</td>
                    @endif
                </tr> 
        <!--FIN CUERPO 2-->
        <!--CUERPO 3-->
                <tr style="text-align: center">
                    <td class="active2" rowspan="2"><b>4.10. Actividad-Proyecto/Tarea-Componente</b></td>
                    <td class="active2" colspan="2" rowspan="2"><b>Unidad de Medida</b></td>
                    <td class="active2" colspan="3"><b>I Trimestre</b></td>
                    <td class="active2" rowspan="2"><b>Total al I Trim</b></td>
                    <td class="active2" colspan="3"><b>II Trimestre</b></td>
                    <td class="active2" rowspan="2"><b>Total al II Trim</b></td>
                    <td class="active2" colspan="3"><b>III Trimestre</b></td>
                    <td class="active2" rowspan="2"><b>Total al III Trim</b></td>
                    <td class="active2" colspan="3"><b>IV Trimestre</b></td>
                    <td class="active2" rowspan="2"><b>Total al IV Trim</b></td>
                    <td class="active2" rowspan="2"><b>Total I Anual</b></td>
                </tr>
                
                <tr style="text-align: center">
                    <td class="active2"><b>Ene</b></td>
                    <td class="active2"><b>Feb</b></td>
                    <td class="active2"><b>Mar</b></td>
                    <td class="active2"><b>Abr</b></td>
                    <td class="active2"><b>May</b></td>
                    <td class="active2"><b>Jun</b></td>
                    <td class="active2"><b>Jul</b></td>
                    <td class="active2"><b>Ago</b></td>
                    <td class="active2"><b>Set</b></td>
                    <td class="active2"><b>Oct</b></td>
                    <td class="active2"><b>Nov</b></td>
                    <td class="active2"><b>Dic</b></td>
                </tr>
                <!--------------------------------------------------->
                @if($tareasrow != 0)
                <tr style="text-align: center">
                    <td class="active2" rowspan="2">{{$actividades->nomact}}</td>
                    <td class="active2"><b>Física</b></td>
                    <td>( - )</td>
                    <td>{{$acttareas->act_enero}}</td>
                    <td>{{$acttareas->act_febrero}}</td>
                    <td>{{$acttareas->act_marzo}}</td>
                    <td class="active2">{{$acttareas->act_tri1}}</td>
                    <td>{{$acttareas->act_abril}}</td>
                    <td>{{$acttareas->act_mayo}}</td>
                    <td>{{$acttareas->act_junio}}</td>
                    <td class="active2">{{$acttareas->act_tri2}}</td>
                    <td>{{$acttareas->act_julio}}</td>
                    <td>{{$acttareas->act_agosto}}</td>
                    <td>{{$acttareas->act_setiembre}}</td>
                    <td class="active2">{{$acttareas->act_tri3}}</td>
                    <td>{{$acttareas->act_octubre}}</td>
                    <td>{{$acttareas->act_noviembre}}</td>
                    <td>{{$acttareas->act_diciembre}}</td>
                    <td class="active2">{{$acttareas->act_tri4}}</td>
                    <td class="active2">{{$acttareas->act_total}}</td>
                </tr>
                    <!--------------------------------------------------->
                    @if($actinsumosrow != 0)
                    <tr style="text-align: right">
                        <td class="active2 text-center"><b>Financiera</b></td>
                        <td class="financiera text-center"> S/. </td>
                        <td class="financiera">{{$actinsumos->insenero}}</td>
                        <td class="financiera">{{$actinsumos->insfebrero}}</td>
                        <td class="financiera">{{$actinsumos->insmarzo}}</td>
                        <td class="active2"><b>{{$actinsumos->instri1}}</b></td>
                        <td class="financiera">{{$actinsumos->insabril}}</td>
                        <td class="financiera">{{$actinsumos->insmayo}}</td>
                        <td class="financiera">{{$actinsumos->insjunio}}</td>
                        <td class="active2"><b>{{$actinsumos->instri2}}</b></td>
                        <td class="financiera">{{$actinsumos->insjulio}}</td>
                        <td class="financiera">{{$actinsumos->insagosto}}</td>
                        <td class="financiera">{{$actinsumos->inssetiembre}}</td>
                        <td class="active2"><b>{{$actinsumos->instri3}}</b></td>
                        <td class="financiera">{{$actinsumos->insoctubre}}</td>
                        <td class="financiera">{{$actinsumos->insnoviembre}}</td>
                        <td class="financiera">{{$actinsumos->insdiciembre}}</td>
                        <td class="active2"><b>{{$actinsumos->instri4}}</b></td>
                        <td class="active2"><b>{{$actinsumos->instotal}}</b></td>
                    </tr>
                    @else
                    <tr style="text-align: right">
                        <td class="active2 text-center"><b>Financiera</b></td>
                        <td class="financiera text-center"> S/. </td>
                        <td class="financiera"> - </td>
                        <td class="financiera"> - </td>
                        <td class="financiera"> - </td>
                        <td class="active2"><b> - </b></td>
                        <td class="financiera"> - </td>
                        <td class="financiera"> - </td>
                        <td class="financiera"> - </td>
                        <td class="active2"><b> - </b></td>
                        <td class="financiera"> - </td>
                        <td class="financiera"> - </td>
                        <td class="financiera"> - </td>
                        <td class="active2"><b> - </b></td>
                        <td class="financiera"> - </td>
                        <td class="financiera"> - </td>
                        <td class="financiera"> - </td>
                        <td class="active2"><b> - </b></td>
                        <td class="active2"><b> - </b></td>
                    </tr>
                    @endif
                    <!--------------------------------------------------->
                @else
                <tr style="text-align: right">
                    <td class="active2 text-center" rowspan="2">{{$actividades->nomact}}</td>
                    <td class="active2 text-center"><b>Física</b></td>
                    <td class="fisica text-center">( - )</td>
                    <td class="fisica"> - </td>
                    <td class="fisica"> - </td>
                    <td class="fisica"> - </td>
                    <td class="active2"><b> - </b></td>
                    <td class="fisica"> - </td>
                    <td class="fisica"> - </td>
                    <td class="fisica"> - </td>
                    <td class="active2"><b> - </b></td>
                    <td class="fisica"> - </td>
                    <td class="fisica"> - </td>
                    <td class="fisica"> - </td>
                    <td class="active2"><b> - </b></td>
                    <td class="fisica"> - </td>
                    <td class="fisica"> - </td>
                    <td class="fisica"> - </td>
                    <td class="active2"><b> - </b></td>
                    <td class="active2"><b> - </b></td>
                </tr>
                
                <tr style="text-align: right">
                    <td class="active2 text-center"><b>Financiera</b></td>
                    <td class="financiera text-center"> S/. </td>
                    <td class="financiera"> - </td>
                    <td class="financiera"> - </td>
                    <td class="financiera"> - </td>
                    <td class="active2"><b> - </b></td>
                    <td class="financiera"> - </td>
                    <td class="financiera"> - </td>
                    <td class="financiera"> - </td>
                    <td class="active2"><b> - </b></td>
                    <td class="financiera"> - </td>
                    <td class="financiera"> - </td>
                    <td class="financiera"> - </td>
                    <td class="active2"><b> - </b></td>
                    <td class="financiera"> - </td>
                    <td class="financiera"> - </td>
                    <td class="financiera"> - </td>
                    <td class="active2"><b> - </b></td>
                    <td class="active2"><b> - </b></td>
                </tr>                
                @endif
                <!--------------------------------------------------->
                @php($tar=1)                    
                @foreach($tareas AS $tarea)
                <tr style="text-align: center" class="texto">
                    <td class="active2" rowspan="2">Tarea {{$tar}} : <b>{{$tarea->tarea}}</b></td>
                    <td class="active2"><b>Física</b></td>
                    <td>( - )</td>
                    <td>{{$tarea->tar_enero}}</td>
                    <td>{{$tarea->tar_febrero}}</td>
                    <td>{{$tarea->tar_marzo}}</td>
                    <td class="active2">{{$tarea->tar_enero+$tarea->tar_febrero+$tarea->tar_marzo}}</td>
                    <td>{{$tarea->tar_abril}}</td>
                    <td>{{$tarea->tar_mayo}}</td>
                    <td>{{$tarea->tar_junio}}</td>
                    <td class="active2">{{$tarea->tar_abril+$tarea->tar_mayo+$tarea->tar_junio}}</td>
                    <td>{{$tarea->tar_julio}}</td>
                    <td>{{$tarea->tar_agosto}}</td>
                    <td>{{$tarea->tar_setiembre}}</td>
                    <td class="active2">{{$tarea->tar_julio+$tarea->tar_agosto+$tarea->tar_setiembre}}</td>
                    <td>{{$tarea->tar_octubre}}</td>
                    <td>{{$tarea->tar_noviembre}}</td>
                    <td>{{$tarea->tar_diciembre}}</td>
                    <td class="active2">{{$tarea->tar_octubre+$tarea->tar_noviembre+$tarea->tar_diciembre}}</td>
                    <td class="active2">{{$tarea->total}}</td>
                </tr>
                
                <tr style="text-align: right" class="texto">
                    <td class="active2 text-center"><b>Financiera</b></td>
                    <td class="financieratar text-center"> S/. </td>
                    <td class="financieratar">{{$tarea->tarenero}}</td>
                    <td class="financieratar">{{$tarea->tarfebrero}}</td>
                    <td class="financieratar">{{$tarea->tarmarzo}}</td>
                    <td class="active2"><b>{{$tarea->tartri1}}</b></td>
                    <td class="financieratar">{{$tarea->tarabril}}</td>
                    <td class="financieratar">{{$tarea->tarmayo}}</td>
                    <td class="financieratar">{{$tarea->tarjunio}}</td>
                    <td class="active2"><b>{{$tarea->tartri2}}</b></td>
                    <td class="financieratar">{{$tarea->tarjulio}}</td>
                    <td class="financieratar">{{$tarea->taragosto}}</td>
                    <td class="financieratar">{{$tarea->tarsetiembre}}</td>
                    <td class="active2"><b>{{$tarea->tartri3}}</b></td>
                    <td class="financieratar">{{$tarea->taroctubre}}</td>
                    <td class="financieratar">{{$tarea->tarnoviembre}}</td>
                    <td class="financieratar">{{$tarea->tardiciembre}}</td>
                    <td class="active2"><b>{{$tarea->tartri4}}</b></td>
                    <td class="active2"><b>{{$tarea->tartotal}}</b></td>
                </tr>
                @php($tar++)
                @endforeach
                <!--------------------------------------------------->            
        <!--FIN CUERPO 3-->                   
            </tbody>
        </table>
    <!--FIN 4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->                      
        </div>    
    </div>    
    
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACT
<!------------------------------------------------------------------------------------------------------------------------------->  
<!-- Select2 -->
    <script>
        $(document).ready(function () {
            var myCallBack = function() {window.close();};
            $('#myPrintArea').print({deferred: $.Deferred().done(myCallBack)});
        })
    </script>
</body>

</html>