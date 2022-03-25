<!DOCTYPE html>
<html lang="en">

<head>
    <title>FORMATO F-2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen">
    <style>
        table, th, td {
            font-size:11px;
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
        .info {
            background-color: #D9EDF7; 
        }

        .info th {
            background-color: #D9EDF7; 
        }

        .info td {
            background-color: #D9EDF7; 
        }
        /*------------------------------class = "primary"------------------------------------*/

        /*------------------------------class = "info"------------------------------------*/
        .active {
            background-color: #F5F5F5; 
        }

        .active th {
            background-color: #F5F5F5; 
        }

        .active td {
            background-color: #F5F5F5; 
        }
        /*------------------------------class = "info"------------------------------------*/
        .footnotes { 
            page-break-after:always; 
        }
    </style>
</head>

<body>
    
<!----------------------------------------------------------------------------------------------------------------->
    <div class="container-fluid">
       <!--TITULO-->
        <table class="table table-bordered">
            <thead>
                <tr bgcolor="#98CCF4">
                    <th style="text-align: center" width="100%">FORMATO F-1: RESUMEN DE PROGRAMACIÓN POR UNIDAD EJECUTORA</th>
                </tr>
            </thead>            
        </table>
    <!--FIN TITULO-->
    
    <!--1. INFORMACIÓN GENERA-->    
        <table class="table table-bordered table-condensed">    
            <thead>
                <tr class="info">
                    <th colspan="5">1. INFORMACIÓN GENERAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="active"><b>1.1. Unidad Ejecutora</b></td>
                    <td style="text-align: center">{{ $unidadejecutoras->codunieje }}</td>
                    <td style="text-align: center">{{ $unidadejecutoras->nombreejecutora }}</td>
                    <td class="active"><b>1.2. Año</b></td>
                    <td style="text-align: center">{{ $unidadejecutoras->anio1 }}</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 1. INFORMACIÓN GENERA--> 
       
    <!--2. ALINEAMIENTO ESTRATÉGICO-->     
        <table class="table table-bordered table-condensed">    
            <thead>
                <tr class="info">
                    <th colspan="4">2. ALINEAMIENTO ESTRATÉGICO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="active"><b>2.1. Visión Regional</b></td>
                    <td style="text-align: center">{{ $mision->mision }}</td>
                    <td class="active"><b>2.2. Misión Institucional</b></td>
                    <td style="text-align: center">{{ $vision->vision }}</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 2. ALINEAMIENTO ESTRATÉGICO--> 
    
    <!--3. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->        
        <table class="table table-bordered table-condensed"> 
        <!--TITULOS-->     
            <thead>
                <tr class="info">
                    <th colspan="18">3. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD</th>
                </tr>
            </thead>
        <!--FIN TITULOS-->
        
        <!--SUBTITULOS-->            
            <tbody>
                <tr style="text-align: center" class="active">
                    <td rowspan="3"><b>3.1. Número</b></td>
                    <td rowspan="3"><b>3.2. Unidad Orgánica</b></td>
                    <td rowspan="3"><b>3.3. Unidad Responsable</b></td>
                    <td rowspan="3"><b>3.4. Código</b></td>
                    <td rowspan="3"><b>3.5. Actividades/ Proy</b></td>
                    <td rowspan="3"><b>3.6. Indicadores</b></td>
                    <td rowspan="3"><b>3.7. Unidad de Medida</b></td>
                    <td colspan="8"><b>3.8. Programación Trimestral</b></td>
                    <td colspan="2"><b>3.9. Meta Anual</b></td>
                    <td rowspan="3"><b>3.10. Fuente de Financiami ento</b></td>
                </tr>          
              
                <tr style="text-align: center" class="active">
                    <td colspan="2"><b>I Trim.</b></td>
                    <td colspan="2"><b>II Trim.</b></td>
                    <td colspan="2"><b>III Trim.</b></td>
                    <td colspan="2"><b>VI Trim.</b></td>
                    <td rowspan="2"><b>Física</b></td>
                    <td rowspan="2"><b>Financiera</b></td>
                </tr>
                
                <tr style="text-align: center" class="active">                    
                    <td><b>Física</b></td>
                    <td><b>Financiera</b></td>                    
                    <td><b>Física</b></td>
                    <td><b>Financiera</b></td>                    
                    <td><b>Física</b></td>
                    <td><b>Financiera</b></td>                    
                    <td><b>Física</b></td>
                    <td><b>Financiera</b></td>
                </tr>
        <!--FIN SUBTITULOS-->
            
        @foreach($unidadorganicas as $unidadorganica)               
        <!--CUERPO 1-->                             
                @php ($cont = 0) 
                @foreach($organicas as $organica)
                    @if($unidadorganica->numorden == $organica->orden)
                    @php ($cont++) 
                <tr style="text-align: center">                   
                    @if($cont==1)
                        <td rowspan="{{ $unidadorganica->conteo + 1}}">{{ $unidadorganica->numorden }}</td>
                        <td rowspan="{{ $unidadorganica->conteo + 1}}">{{ $unidadorganica->nombreunidad }}</td>
                    @endif                    
                    <td>(Unidad Responsable de la Actividad)</td>
                    <td>{{ $organica->codigoact }}</td>
                    <td>{{ $organica->nombreact }}</td>
                    <td>{{ $organica->nombreind }}</td>
                    <td>{{ $organica->nombreum }}</td>                    
                    <td> - </td>
                    <td> - </td>                    
                    <td> - </td>
                    <td> - </td>                    
                    <td> - </td>
                    <td> - </td>                    
                    <td> - </td>
                    <td> - </td>                    
                    <td> - </td>
                    <td> - </td>
                    <td>(Cód. de FF)</td>
                    @endif
                </tr>
                @endforeach
                
                <tr style="text-align: center" class="active">  
                    <td colspan="5">Sub Total de la Unidad Orgánica</td>
                    <td> - </td>                    
                    <td> - </td>                    
                    <td> - </td>
                    <td> - </td>                    
                    <td> - </td>
                    <td> - </td>                    
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                </tr>                  
        <!--FIN CUERPO 1-->
            @endforeach  
            </tbody>            
        </table>
    <!--FIN 3. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD--> 
    
    <!--4. PROGRAMACIÓN OPERATIVA DE LA UNIDAD EJECUTORA-->        
        <table class="table table-bordered table-condensed"> 
        <!--TITULOS-->     
            <thead>
                <tr class="info">
                    <th colspan="18">4. PROGRAMACIÓN OPERATIVA DE LA UNIDAD EJECUTORA</th>
                </tr>
            </thead>
        <!--FIN TITULOS-->
        
        <!--SUBTITULOS-->
            <tbody>
                <tr style="text-align: center" class="active">
                    <td><b>4.1. Unidad Ejecutora</b></td>
                    <td colspan="2"><b>4.2. Total I Trim. </b></td>
                    <td colspan="2"><b>4.3. Total I Trim. </b></td>
                    <td colspan="2"><b>4.4. Total I Trim. </b></td>
                    <td colspan="2"><b>4.5. Total I Trim. </b></td>
                    <td colspan="2"><b>4.6. Total I Trim. </b></td>
                    <td><b>4.7. FF. </b></td>
                </tr>  
        <!--FIN SUBTITULOS-->
        
        <!--CUERPO 1-->
                <tr style="text-align: center">
                    <td>{{ $unidadejecutoras->codunieje }}.- {{ $unidadejecutoras->nombreejecutora }}</td>                   
                    <td> - </td>
                    <td>(Financiera)</td>                    
                    <td> - </td>
                    <td>(Financiera)</td>                    
                    <td> - </td>
                    <td>(Financiera)</td>                    
                    <td> - </td>
                    <td>(Financiera)</td>                    
                    <td> - </td>
                    <td>(Financiera)</td>
                    <td>(Cód. de FF)</td>
                </tr>   
        <!--FIN CUERPO 1-->   
           
            </tbody>
        </table>
    </div>
        
    <!--FIN 4. PROGRAMACIÓN OPERATIVA DE LA UNIDAD EJECUTORA-->   
<!----------------------------------------------------------------------------------------------------------------->
    
    <?php $cout=1;?>
    <div style="page-break-before: always; page-break-after: always; page-break-inside:always;">
        <div id="myPrintArea" class="container-fluid">
<!--FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->    
        <div>
            <h3></h3>    
        </div>
        
        <!--<p>The .table class adds basic styling (light padding-top and only horizontal dividers) to a table:</p>-->
    <!--TITULO-->
        <table class="table table-bordered">
            <thead>
                <tr bgcolor="#98CCF4">
                    <th style="text-align: center" width="100%">FORMATO F-2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO - ACTIVIDAD N° {{$cout}}</th>
                </tr>
            </thead>            
        </table>
    <!--FIN TITULO-->
       
    <!--1. INFORMACIÓN GENERA-->    
        <table class="table table-bordered table-condensed">    
            <thead>
                <tr class="info">
                    <th width="100%" colspan="6">1. INFORMACIÓN GENERAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                        <td width="15%" class="active"><b>1.1. Unidad Ejecutora</b></td>
                        <td width="14%" style="text-align: center">{{ strtoupper($unidadejecutoras->codunieje.'.- '.$unidadejecutoras->nombreejecutora) }}</td>
                        <td width="10%" class="active"><b>1.2. Unidad Orgánica</b></td>
                        <td width="37%" style="text-align: center">{{ strtoupper($unidadejecutoras->uniorganica) }}</td>
                        <td width="10%" class="active"><b>1.3. Año</b></td>
                        <td width="37%" style="text-align: center">{{ $unidadejecutoras->anio1 }}</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 1. INFORMACIÓN GENERA--> 
       
    <!--2. ALINEAMIENTO ESTRATÉGICO-->     
        <table class="table table-bordered table-condensed" width="100%">    
            <thead>
                <tr class="info">
                    <th colspan="7">2. ALINEAMIENTO ESTRATÉGICO</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                <tr>
                    <td class="active" colspan="2"><b>2.1. Visión Regional</b></td>
                    <td colspan="2">{{ $mision->mision }}</td>
                    <td class="active"><b>2.2. Misión Institucional</b></td>
                    <td colspan="2">{{ $vision->vision }}</td>
                </tr>
                
                <tr>
                    <td class="active" colspan="2"><b>2.3. Plan Estratégico</b></td>
                    <td class="active"><b>2.4. Código</b></td>
                    <td class="active"><b>2.5. Descripción</b></td>
                    <td class="active" rowspan="2" style="padding-top: 13px"><b>2.6. Indicador</b></td>
                    <td class="active" rowspan="2" style="padding-top: 13px"><b>2.7. Unidad de Medida</b></td>
                    <td class="active" rowspan="2" style="padding-top: 13px"><b>2.8. Meta</b></td>
                </tr>
                   
                <tr>
                    <td class="active" rowspan="3" style="padding-top: 20px"><b>2.3.1. PDRC Huánuco al 2021</b></td>
                    <td class="active"><b>C.E.</b></td>
                    <td>(Del C.E.)</td>
                    <td>(Componente Estratégico Territorial)</td>
                </tr>
                   
                <tr>
                    <td class="active"><b>O.E.T.</b></td>
                    <td>(Del O.E.T.)</td>
                    <td>(Objetivo Estratégico Territorial)</td>
                    <td>(Nombre del Indicador del O.E.T.)</td>
                    <td>(Unidad de Medida del Indicador del O.E.T.)</td>
                    <td>(Meta Anual)</td>
                </tr>
                   
                <tr>
                    <td class="active"><b>A.E.T.</b></td>
                    <td>(Del A.E.T.)</td>
                    <td>(Acción Estratégico Territorial)</td>
                    <td>(Nombre del Indicador del A.E.T.)</td>
                    <td>(Unidad de Medida del Indicador del A.E.T.)</td>
                    <td>(Meta Anual)</td>
                </tr>
                
                <tr>
                    <td class="active" rowspan="2" style="padding-top: 15px"><b>2.3.2. PEI 2017-2019</b></td>
                    <td class="active"><b>O.E.I.</b></td>
                    <td>(Del O.E.I.)</td>
                    <td>(Objetivo Estratégico Institucional)</td>
                    <td>(Nombre del Indicador del O.E.I.)</td>
                    <td>(Unidad de Medida del Indicador del O.E.I.)</td>
                    <td>(Meta Anual)</td>
                </tr>
                
                <tr>
                    <td class="active"><b>A.E.I.</b></td>
                    <td>(Del A.E.I.)</td>
                    <td>(Acción Estratégico Institucional)</td>
                    <td>(Nombre del Indicador del A.E.I.)</td>
                    <td>(Unidad de Medida del Indicador del A.E.I.)</td>
                    <td>(Meta Anual)</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 2. ALINEAMIENTO ESTRATÉGICO--> 
    
        @foreach($pois as $poi)
    <!--3. ARTICULACIÓN PRESUPUESTARIA-->     
        <table class="table table-bordered table-condensed">    
            <thead>
                <tr class="info">
                    <th colspan="9">3. ARTICULACIÓN PRESUPUESTARIA</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                <tr>
                    <td class="active" rowspan="4" style="padding-top: 30px"><b>3.1. Categoría Presupuestal</b></td>
                    <td class="active"><b>3.2. Código</b></td>
                    <td class="active" colspan="3"><b>3.3. Denominación</b></td>
                    <td class="active" colspan="2" rowspan="3" style="padding-top: 30px"><b>3.4. Resultado Final o Específico</b></td>
                    <td class="active" rowspan="3" style="padding-top: 30px"><b>3.5. Inidicador</b></td>
                    <td class="active" rowspan="3" style="padding-top: 30px"><b>3.6. Meta</b></td>
                </tr>
                
                <tr>
                    @if($poi->categoria == 9001)
                        <td>9001</td>    
                        <td colspan="3">Acciones Centrales</td>    
                    @else
                        <td> - </td>    
                        <td colspan="3"> - </td> 
                    @endif
                </tr>
                
                <tr>
                    @if($poi->categoria == 9002)
                        <td>9002</td>    
                        <td colspan="3">Asignación Presupuestaria que no resulta en Productos</td>  
                    @else
                        <td> - </td>    
                        <td colspan="3"> - </td> 
                    @endif
                </tr>
                
                <tr>
                    @if($poi->categoria != 9001 && $poi->categoria != 9002)
                        <td>{{ $poi->categoria }}</td>    
                        <td colspan="3">(Programa Presupuestal)</td> 
                        <td colspan="2">(Resultado final o específico del PP)</td>    
                        <td>(Indicador del PP)</td>    
                        <td>(Meta del PP)</td>    
                    @else
                        <td> - </td>    
                        <td colspan="3"> - </td> 
                        <td colspan="2"> - </td>    
                        <td> - </td>    
                        <td> - </td> 
                    @endif   
                </tr>
                
                <tr>
                    <td class="active" rowspan="2"><b>3.7. Estructura Funcional Programática</b></td>
                    <td class="active"><b>Función</b></td>
                    <td class="active"><b>Divición Funcional</b></td>
                    <td class="active"><b>Grupo Funcional</b></td>
                    <td class="active"><b>Categoría Presupuestal</b></td>
                    <td class="active"><b>Producto/Proyecto</b></td>
                    <td class="active"><b>Actividad/Acción/Obra</b></td>
                    <td class="active"><b>Finalidad</b></td>
                    <td class="active"><b>Meta Presupuetaria</b></td>
                </tr>
                
                <tr>
                    <td>{{ $poi->funcion }}</td>
                    <td>{{ $poi->division }}</td>
                    <td>{{ $poi->grupo }}</td>
                    <td>{{ $poi->categoria }}</td>
                    <td>{{ $poi->producto }}</td>
                    <td>{{ $poi->obra }}</td>
                    <td>{{ $poi->finalidad }}</td>
                    <td>{{ $poi->meta }}</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 3. ARTICULACIÓN PRESUPUESTARIA--> 
        @endforeach
        
    <!--4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->        
        <table class="table table-bordered table-condensed"> 
        <!--TITULOS-->     
            <thead>
                <tr class="info">
                    <th colspan="21">4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD</th>
                </tr>
            </thead>
        <!--FIN TITULOS-->
        
        <!--SUBTITULOS-->
            <tbody>
                <tr style="text-align: center">
                    <td class="active" rowspan="2"><b>4.1. Unidad Responsable</b></td>
                    <td class="active" rowspan="2"><b>4.2. Código</b></td>
                    <td class="active" colspan="4" rowspan="2"><b>4.3. Denominacion de la Actividad</b></td>
                    <td class="active" colspan="3" rowspan="2"><b>4.4. Indicador</b></td>
                    <td class="active" colspan="2" rowspan="2"><b>4.5. Unidad de Medida</b></td>
                    <td class="active" colspan="4"><b>4.6. Meta Anual</b></td>
                    <td class="active" colspan="5"><b>4.7. Fuente de Financiamiento</b></td>
                    <td class="active" rowspan="2"><b>4.7.1. Meta</b></td>
                </tr> 
                
                <tr style="text-align: center">
                    <td class="active" colspan="2"><b>Física</b></td>
                    <td class="active" colspan="2"><b>Financiera</b></td>
                    <td class="active"><b>RO</b></td>
                    <td class="active"><b>RDR</b></td>
                    <td class="active"><b>ROOC</b></td>
                    <td class="active"><b>DyT</b></td>
                    <td class="active"><b>RD</b></td>
                </tr>  
        <!--FIN SUBTITULOS-->
                      
        <!--CUERPO 1-->
            @foreach($tareas as $tarea)
                <tr style="text-align: center">
                    <td>{{ strtoupper($unidadejecutoras->uniorganica) }}</td>
                    <td>{{ $tarea->idact }}</td>
                    <td colspan="4">{{ $tarea->nomact }}</td>
                    <td colspan="3">{{ $tarea->indact }}</td>
                    <td colspan="2">{{ $tarea->medact }}</td>
                    <td colspan="2">(Valor de la Meta)</td>
                    <td colspan="2">(Monto Financ.)</td>
                    @if( $tarea->fueact1 == 1)
                        <td><b> x </b></td>
                    @else
                        <td><b></b></td>
                    @endif
                    @if( $tarea->fueact2 == 2)
                        <td><b> x </b></td>
                    @else
                        <td><b></b></td>
                    @endif
                    @if( $tarea->fueact3 == 3)
                        <td><b> x </b></td>
                    @else
                        <td><b></b></td>
                    @endif
                    @if( $tarea->fueact4 == 4)
                        <td><b> x </b></td>
                    @else
                        <td><b></b></td>
                    @endif
                    @if( $tarea->fueact5 == 5)
                        <td><b> x </b></td>
                    @else
                        <td><b></b></td>
                    @endif
                    <td><b>meta</b></td>
                </tr> 
            @endforeach
        <!--FIN CUERPO 1-->
                       
        <!--CUERPO 2-->
                <tr style="text-align: center">
                    <td class="active" colspan="2"><b>4.8. Actividad-Proyecto</b></td>
                    <td class="active" colspan="6"><b>4.8.1. Descripción</b></td>
                    <td class="active" colspan="3"><b>4.8.2. Localización</b></td>
                    <td class="active" colspan="3"><b>4.8.3. Beneficiarios</b></td>
                    <td class="active" colspan="4"><b>4.8.4. Estrategia(s) Operativa(s)</b></td>
                    <td class="active" colspan="3"><b>4.9. Prioridad</b></td>
                </tr>
                   
                <tr style="text-align: center">
                    <td colspan="2"></td>
                    <td colspan="6"></td>
                    <td colspan="3"></td>
                    <td colspan="3"></td>
                    <td colspan="4"> - </td>
                    <td colspan="3"> - </td>
                </tr> 
        <!--FIN CUERPO 2-->
                       
        <!--CUERPO 3-->
                <tr style="text-align: center">
                    <td class="active" rowspan="2"><b>4.10. Actividad-Proyecto/Tarea-Componente</b></td>
                    <td class="active" colspan="2" rowspan="2"><b>Unidad de Medida</b></td>
                    <td class="active" colspan="3"><b>I Trimestre</b></td>
                    <td class="active" rowspan="2"><b>Total al I Trim</b></td>
                    <td class="active" colspan="3"><b>II Trimestre</b></td>
                    <td class="active" rowspan="2"><b>Total al II Trim</b></td>
                    <td class="active" colspan="3"><b>III Trimestre</b></td>
                    <td class="active" rowspan="2"><b>Total al III Trim</b></td>
                    <td class="active" colspan="3"><b>VI Trimestre</b></td>
                    <td class="active" rowspan="2"><b>Total al IV Trim</b></td>
                    <td class="active" colspan="2" rowspan="2"><b>Total I Anual</b></td>
                </tr>
                
                <tr style="text-align: center">
                    <td class="active"><b>Ene</b></td>
                    <td class="active"><b>Feb</b></td>
                    <td class="active"><b>Mar</b></td>
                    <td class="active"><b>Abr</b></td>
                    <td class="active"><b>May</b></td>
                    <td class="active"><b>Jun</b></td>
                    <td class="active"><b>Jul</b></td>
                    <td class="active"><b>Ago</b></td>
                    <td class="active"><b>Set</b></td>
                    <td class="active"><b>Oct</b></td>
                    <td class="active"><b>Nov</b></td>
                    <td class="active"><b>Dic</b></td>
                </tr>
                <!--------------------------------------------------->
                <tr style="text-align: center">
                    <td class="active" rowspan="2"><b>Act{{$cout++}}: </b>Actividad 1</td>
                    <td class="active"><b>Física</b></td>
                    <td>( - )</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td class="active" colspan="2"> - </td>
                </tr>
                
                <tr style="text-align: center">
                    <td class="active"><b>Financiera</b></td>
                    <td> S/. </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td class="active" colspan="2"> - </td>
                </tr>
                <!--------------------------------------------------->
                <tr style="text-align: center">
                    <td class="active" rowspan="2"><b>Tarea 1.1</b></td>
                    <td class="active"><b>Física</b></td>
                    <td>( - )</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td class="active" colspan="2"> - </td>
                </tr>
                
                <tr style="text-align: center">
                    <td class="active"><b>Financiera</b></td>
                    <td> S/. </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td class="active" colspan="2"> - </td>
                </tr>
                <!--------------------------------------------------->
                <tr style="text-align: center">
                    <td class="active" rowspan="2"><b>Tarea 1.2</b></td>
                    <td class="active"><b>Física</b></td>
                    <td>( - )</td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td class="active" colspan="2"> - </td>
                </tr>
                
                <tr style="text-align: center">
                    <td class="active"><b>Financiera</b></td>
                    <td> S/. </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="active"> - </td>
                    <td class="active" colspan="2"> - </td>
                </tr>
        <!--FIN CUERPO 3-->        
            </tbody>
        </table>
    <!--FIN 4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->     
    
    </div>    
</div>    
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->
<!------------------------------------------------------------------------------------------------------------------------------->    
</body>

</html>