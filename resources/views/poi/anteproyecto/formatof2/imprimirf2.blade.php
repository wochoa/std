<!DOCTYPE html>
<html lang="en">

<head>
    <title>HUAMALIES</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen">
    
    <style>
        .table{
            border-collapse: collapse;
            text-align: left;
            width: 100%;  
            font-family: "Arial Narrow";  
            background: #fff;
            border: 1px solid #000000; 
            margin-bottom: 8px;
            font-size: 11px;
        }
        
        .text-center > thead > tr >th,
        .text-center > tbody > tr >td,
        .text-center > tfoot > tr >td{
            text-align: center;
        }
        
        .text-center{
            text-align: center;
        }
        
        .text-right > thead > tr >th,
        .text-right > tbody > tr >td,
        .text-right > tfoot > tr >td{
            text-align: right;
        }
        
        .text-right{
            text-align: right;
        }
        
        .text-left > thead > tr >th,
        .text-left > tbody > tr >td,
        .text-left > tfoot > tr >td{
            text-align: left;
        }
        
        .text-left{
            text-align: left;
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
        /*------------------------------class = "info2"------------------------------------*/
                 
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
        <table class="table table-bordered table-condensed texto-tabla"> 
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
                    <td>{{$inversion->numero}}</td>
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
                    <td style="text-align: left;" class="active2" rowspan="2" colspan="2">Actividad {{$tar}} : <b>{{$inversion->denominacion}}</b></td>
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
                
        <!--FIN CUERPO 3-->                   
            </tbody>
        </table>
    <!--FIN 4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->                       
    
        </div>
    </div>   
</div>    
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACT--------------------------------------------------------------->  
<script>
    $(document).ready(function () {
        var myCallBack = function() {window.close();};
        $('#myPrintArea').print({deferred: $.Deferred().done(myCallBack)});
    })
</script>
</body>

</html>