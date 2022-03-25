<?
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=FORMATOF3.xls");
exit(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>FORMATO F-3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen">
    <style>
        .texto {
            font-size:11px;
            font-family: Tahoma;
        }
    </style>
    
    <style media="print">                
        table, th, td {
            font-size:8px;
            font-family: Tahoma;
        }
        
        .texto {
            font-size:11px;
            font-family: Tahoma;
        }
        
        .text-center {
            text-align: center;
        }
        
        /*------------------------------class = "table"------------------------------------*/
        /*------------------------------class = "table"------------------------------------*/
        .table{
            border-collapse: collapse;
            text-align: left;
            width: 100%;  
            font-family: Tahoma;  
            background: #fff;
            border: 1px solid #DDDDDD; 
            margin-bottom: 8px;
        }

        .table thead th {    
            color: #333333;  
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 8px;
            font-weight: bold;
            border-bottom: 2px solid #DDDDDD;  
            border-left: 1px solid #DDDDDD;  
        }

        .table tbody td {
            color: #333333;    
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 3px;
            padding-right: 3px;
            font-size: 8px;  
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
        
    </style>
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('js/jQuery.print.js')}}"></script>  
</head>

<body>
<!------------------------------------------------------------------------------------------------------------------------------>  
    <div style="page-break-before: always; page-break-after: always; page-break-inside:always;">
<!--FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->
    <div id="myPrintArea" class="container-fluid">
        <div>
            <h3></h3>    
        </div>       
        
        <!--<p>The .table class adds basic styling (light padding-top and only horizontal dividers) to a table:</p>-->
    <!--TITULO-->
        <table class="table table-bordered" style="font-size:11px; font-family: Tahoma;">
            <thead>
                <tr bgcolor="#98CCF4">
                    <th style="text-align: center" width="100%">FORMATO F-3: CUADRO DE ASIGNACIÓN POR INSUMOS POR TAREAS/COMPONENTES</th>
                </tr>
            </thead>                        
        </table>
        
        <div style="text-align: center">
            <label style="font-size:11px; font-family: Tahoma;">01. ACTIVIDAD/PROYECTO N°01: </label>
            <input type="text" id="actividadProy" size="100%" value="{{$actividad->actividad}}" class="texto text-center">
        </div>
        <h3></h3>
    <!--FIN TITULO-->
       
    <!--1. INFORMACIÓN GENERA-->    
        <table class="table table-bordered table-condensed" style="font-size:9px; font-family: Tahoma;">    
            <tbody>
                <tr class="info">
                    <td style="text-align: center" rowspan="2">IDT</td>
                    <td style="text-align: center" rowspan="2">1. TAREAS</td>
                    <td style="text-align: center" rowspan="2">2. INSUMOS  </td>
                    <td style="text-align: center" rowspan="2">3. UM (Insumo)</td>
                    <td style="text-align: center" rowspan="2">4. CANTID AD (Insu mo)</td>
                    <td style="text-align: center" rowspan="2">FF</td>
                    <td style="text-align: center" rowspan="2">GG</td>
                    <td style="text-align: center" rowspan="2">Sub G1</td>
                    <td style="text-align: center" rowspan="2">Sub G2</td>
                    <td style="text-align: center" rowspan="2">Esp 1</td>
                    <td style="text-align: center" rowspan="2">Esp 2</td>
                    <td style="text-align: center" rowspan="2">7. COST  O REFER  EN  CIAL</td>
                    <td style="text-align: center" rowspan="2">8. MONTO TOTAL</td>
                    <td style="text-align: center" colspan="17">9. Distribución Presupuestal de los Recursos(Programación de Devangados)</td>
                </tr>
                
                <tr class="active">
                    <td><b>Ene</b></td>
                    <td><b>Feb</b></td>
                    <td><b>Mar</b></td>
                    <td><b>Total I Trimestre</b></td>                    
                    <td><b>Abr</b></td>
                    <td><b>May</b></td>
                    <td><b>Jun</b></td>
                    <td><b>Total II Trimestre</b></td>   
                    <td><b>Jul</b></td>
                    <td><b>Ago</b></td>
                    <td><b>Set</b></td>
                    <td><b>Total III Trimestre</b></td>   
                    <td><b>Oct</b></td>
                    <td><b>Nov</b></td>
                    <td><b>Dic</b></td>
                    <td><b>Total IV Trimestre</b></td>   
                    <td><b>TOTAL</b></td>   
                </tr>
            </tbody>
            
        @if($tareasrow != 0)
            <tbody>
                <tr class="text-right">
                    <td colspan="12" class="active text-left"><b>Actividad 1</b></td>
                    <td class="info"><b>{{$actividad->acttotal}}</b></td>
                    <td class="active">{{$actividad->actenero}}</td>
                    <td class="active">{{$actividad->actfebrero}}</td>
                    <td class="active">{{$actividad->actmarzo}}</td>
                    <td class="active"><b>{{$actividad->acttri1}}</b></td>
                    <td class="active">{{$actividad->actabril}}</td>
                    <td class="active">{{$actividad->actmayo}}</td>
                    <td class="active">{{$actividad->actjunio}}</td>
                    <td class="active"><b>{{$actividad->acttri2}}</b></td>
                    <td class="active">{{$actividad->actjulio}}</td>
                    <td class="active">{{$actividad->actagosto}}</td>
                    <td class="active">{{$actividad->actsetiembre}}</td>
                    <td class="active"><b>{{$actividad->acttri3}}</b></td>
                    <td class="active">{{$actividad->actoctubre}}</td>
                    <td class="active">{{$actividad->actnoviembre}}</td>
                    <td class="active">{{$actividad->actdiciembre}}</td>
                    <td class="active"><b>{{$actividad->acttri4}}</b></td>
                    <td class="info"><b>{{$actividad->acttotal}}</b></td>
                </tr>
        <!------------------------------------TAREA 01----------------------------------------> 
               
            @php($con_tar=1)  
            @foreach($tareas AS $tarea)
            @php($frack=1)  
                
                @foreach($insumos AS $insumo)
                @if($insumo->id_tarea == $tarea->id_tarea)
                <tr style="text-align: center">                    
                    @if($frack==1)
                        <td width="1%" rowspan="{{$insumo->con_ins}}" class="active"><b>{{$con_tar}}</b></td>
                        <td width="7%" rowspan="{{$insumo->con_ins}}" class="active"><b>{{$tarea->tarea}}</b></td> 
                        @php($frack++)
                    @endif 
                    <td width="6%" class="text-left">{{$insumo->insumo}}</td>
                    <td width="4%" class="text-center">{{$insumo->um}}</td>
                    <td width="4%" class="active text-center">{{$insumo->cantidad}}</td>
                    <td width="2%" class="text-center">{{$insumo->fuente}}</td>
                    <td width="2%" class="text-center" colspan="5">{{$insumo->clasificador}}</td>
                    <td width="4%" class="active text-center">{{$insumo->costo}}</td>
                    <td width="4%" class="active text-center">{{$insumo->monto}}</td>
                    @if($insumo->enero != 0)
                        <td width="3%" >{{$insumo->enero}}</td>
                    @else
                        <td width="3%" ></td>
                    @endif
                    @if($insumo->febrero != 0)
                        <td width="3%" >{{$insumo->febrero}}</td>
                    @else
                        <td width="3%" ></td>
                    @endif
                    @if($insumo->marzo != 0)
                        <td width="3%" >{{$insumo->marzo}}</td>
                    @else
                        <td width="3%" ></td>
                    @endif                    
                    <td width="4%" class="active">{{$insumo->tri1}}</td> 
                    @if($insumo->abril != 0)   
                        <td width="3%" >{{$insumo->abril}}</td>
                    @else
                        <td width="3%" ></td>
                    @endif
                    @if($insumo->mayo != 0)   
                        <td width="3%" >{{$insumo->mayo}}</td>
                    @else
                        <td width="3%" ></td>
                    @endif
                    @if($insumo->junio != 0)   
                        <td width="3%" >{{$insumo->junio}}</td>       
                    @else
                        <td width="3%" ></td>
                    @endif
                    <td width="4%" class="active">{{$insumo->tri2}}</td>
                    @if($insumo->julio != 0)     
                        <td width="3%" >{{$insumo->julio}}</td> 
                    @else
                        <td width="3%" ></td>
                    @endif
                    @if($insumo->agosto != 0)     
                        <td width="3%" >{{$insumo->agosto}}</td>       
                    @else
                        <td width="3%" ></td>
                    @endif
                    @if($insumo->setiembre != 0)     
                        <td width="3%" >{{$insumo->setiembre}}</td>       
                    @else
                        <td width="3%" ></td>
                    @endif
                    <td width="4%" class="active">{{$insumo->tri3}}</td>
                    @if($insumo->octubre != 0)    
                        <td width="3%" >{{$insumo->octubre}}</td>   
                    @else
                        <td width="3%" ></td>
                    @endif
                    @if($insumo->noviembre != 0)    
                        <td width="3%" >{{$insumo->noviembre}}</td>   
                    @else
                        <td width="3%" ></td>
                    @endif
                    @if($insumo->diciembre != 0)    
                        <td width="3%" >{{$insumo->diciembre}}</td>   
                    @else
                        <td width="3%" ></td>
                    @endif
                    <td width="4%" class="active">{{$insumo->tri4}}</td>
                    <td width="6%" class="active">{{$insumo->monto}}</td>                    
                </tr>                 
                @endif
                @endforeach
                
                <tr class="text-right">
                    <td colspan="12" class="text-center"><b>TOTAL TAREA {{$con_tar}}</b></td>
                    <td class="info"><b>{{$tarea->tartotal}}</b></td>
                    <td class="active">{{$tarea->tarenero}}</td>
                    <td class="active">{{$tarea->tarfebrero}}</td>
                    <td class="active">{{$tarea->tarmarzo}}</td>
                    <td class="active"><b>{{$tarea->tartri1}}</b></td>
                    <td class="active">{{$tarea->tarabril}}</td>
                    <td class="active">{{$tarea->tarmayo}}</td>
                    <td class="active">{{$tarea->tarjunio}}</td>
                    <td class="active"><b>{{$tarea->tartri2}}</b></td>
                    <td class="active">{{$tarea->tarjulio}}</td>
                    <td class="active">{{$tarea->taragosto}}</td>
                    <td class="active">{{$tarea->tarsetiembre}}</td>
                    <td class="active"><b>{{$tarea->tartri3}}</b></td>
                    <td class="active">{{$tarea->taroctubre}}</td>
                    <td class="active">{{$tarea->tarnoviembre}}</td>
                    <td class="active">{{$tarea->tardiciembre}}</td>
                    <td class="active"><b>{{$tarea->tartri4}}</b></td>
                    <td class="info"><b>{{$tarea->tartotal}}</b></td>
                </tr>
            @php($con_tar++)
            @endforeach
        <!--------------------------------FIN TAREA 01---------------------------------------->        
                <tr>
                    <td colspan="30"></td>
                </tr>
        <!-------------------------------TOTAL ACTIVIDAD N01---------------------------------->   
                <tr class="text-right">
                    <td colspan="12" class="info text-center"><b>TOTAL ACTIVIDAD N°01</b></td>
                    <td class="info"><b>{{$clasiftotal->totalmonto}}</b></td>
                    <td class="active">{{$clasiftotal->totalenero}}</td>
                    <td class="active">{{$clasiftotal->totalfebrero}}</td>
                    <td class="active">{{$clasiftotal->totalmarzo}}</td>
                    <td class="info"><b>{{$clasiftotal->totaltri1}}</b></td>
                    <td class="active">{{$clasiftotal->totalabril}}</td>
                    <td class="active">{{$clasiftotal->totalmayo}}</td>
                    <td class="active">{{$clasiftotal->totaljunio}}</td>
                    <td class="info"><b>{{$clasiftotal->totaltri2}}</b></td>
                    <td class="active">{{$clasiftotal->totaljulio}}</td>
                    <td class="active">{{$clasiftotal->totalagosto}}</td>
                    <td class="active">{{$clasiftotal->totalsetiembre}}</td>
                    <td class="info"><b>{{$clasiftotal->totaltri3}}</b></td>
                    <td class="active">{{$clasiftotal->totaloctubre}}</td>
                    <td class="active">{{$clasiftotal->totalnovembre}}</td>
                    <td class="active">{{$clasiftotal->totaldiciembre}}</td>
                    <td class="info"><b>{{$clasiftotal->totaltri4}}</b></td>
                    <td class="info"><b>{{$clasiftotal->totalmonto}}</b></td>
                </tr> 
        <!-------------------------FIN TOTAL ACTIVIDAD N01---------------------------------->                   
            </tbody>
        @endif
            
    <!-----------------------------------RESUMEN POR ESPECÍFICAS--------------------------------------------> 
            <tbody>
                <tr>
                    <td colspan="30"><br><br></td>
                </tr>
               
                <tr  class="info">
                    <td style="text-align: center" colspan="2"><b>ACTIVIDAD/PROYECTO</b></td>
                    <td style="text-align: center" colspan="11"><b>10. RESUMEN POR ESPECÍFICAS</b></td>
                    <td style="text-align: center"><b>Ene</b></td>
                    <td style="text-align: center"><b>Feb</b></td>
                    <td style="text-align: center"><b>Mar</b></td>
                    <td style="text-align: center"><b>I Trim</b></td>
                    <td style="text-align: center"><b>Abr</b></td>
                    <td style="text-align: center"><b>May</b></td>
                    <td style="text-align: center"><b>Jun</b></td>
                    <td style="text-align: center"><b>II Trim</b></td>
                    <td style="text-align: center"><b>Jul</b></td>
                    <td style="text-align: center"><b>Ago</b></td>
                    <td style="text-align: center"><b>Set</b></td>
                    <td style="text-align: center"><b>III Trim</b></td>
                    <td style="text-align: center"><b>Oct</b></td>
                    <td style="text-align: center"><b>Nov</b></td>
                    <td style="text-align: center"><b>Dic</b></td>
                    <td style="text-align: center"><b>IV Trim</b></td>
                    <td style="text-align: center"><b>  TOTAL  </b></td>
                </tr>
        
        @if($tareasrow != 0)
                @php($fra=1)
                @foreach($clasificadores AS $clasificador)
                <tr class="text-right">
                    @if($fra==1)
                        <td width="8%" class="active text-center" rowspan="{{$clasifrow}}" colspan="2"><b>{{$actividad->actividad}}</b></td>  
                        @php($fra++)
                    @endif
                    <td width="6%" class="active text-center">{{$clasificador->nombreclasf}}</td>
                    <td width="4%"></td>
                    <td width="4%" class="active">{{$clasificador->clacantidad}}</td>
                    <td width="2%"> - </td>
                    <td width="2%" colspan="5" class="text-center">{{$clasificador->clasificador}}</td>
                    <td width="4%" class="active"></td>
                    <td width="4%" class="active">{{$clasificador->clamonto}}</td>
                    <td width="3%">{{$clasificador->claenero}}</td>
                    <td width="3%">{{$clasificador->clafebrero}}</td>
                    <td width="3%">{{$clasificador->clamarzo}}</td>
                    <td width="4%" class="active">{{$clasificador->clatri1}}</td>
                    <td width="3%">{{$clasificador->claabril}}</td>
                    <td width="3%">{{$clasificador->clamayo}}</td>
                    <td width="3%">{{$clasificador->clajunio}}</td>
                    <td width="4%" class="active">{{$clasificador->clatri2}}</td>
                    <td width="3%">{{$clasificador->clajulio}}</td>
                    <td width="3%">{{$clasificador->claagosto}}</td>
                    <td width="3%">{{$clasificador->clasetiembre}}</td>
                    <td width="4%" class="active">{{$clasificador->clatri3}}</td>
                    <td width="3%">{{$clasificador->claoctubre}}</td>
                    <td width="3%">{{$clasificador->clanoviembre}}</td>
                    <td width="3%">{{$clasificador->cladiciembre}}</td>
                    <td width="4%" class="active">{{$clasificador->clatri4}}</td>
                    <td width="6%" class="info">{{$clasificador->clamonto}}</td>
                </tr>
                @endforeach                                  
                                   
                <tr class="text-right">
                    <td class="info text-center" colspan="12"><b>TOTAL</b></td>
                    <td class="info"><b>{{$clasiftotal->totalmonto}}</b></td>
                    <td class="active">{{$clasiftotal->totalenero}}</td>
                    <td class="active">{{$clasiftotal->totalfebrero}}</td>
                    <td class="active">{{$clasiftotal->totalmarzo}}</td>
                    <td class="info"><b>{{$clasiftotal->totaltri1}}</b></td>
                    <td class="active">{{$clasiftotal->totalabril}}</td>
                    <td class="active">{{$clasiftotal->totalmayo}}</td>
                    <td class="active">{{$clasiftotal->totaljunio}}</td>
                    <td class="info"><b>{{$clasiftotal->totaltri2}}</b></td>
                    <td class="active">{{$clasiftotal->totaljulio}}</td>
                    <td class="active">{{$clasiftotal->totalagosto}}</td>
                    <td class="active">{{$clasiftotal->totalsetiembre}}</td>
                    <td class="info"><b>{{$clasiftotal->totaltri3}}</b></td>
                    <td class="active">{{$clasiftotal->totaloctubre}}</td>
                    <td class="active">{{$clasiftotal->totalnoviembre}}</td>
                    <td class="active">{{$clasiftotal->totaldiciembre}}</td>
                    <td class="info"><b>{{$clasiftotal->totaltri4}}</b></td>
                    <td class="info"><b>{{$clasiftotal->totalmonto}}</b></td>
                </tr>   
            </tbody>            
        @endif
        
        </table>
    <!-----------------------------------FIN RESUMEN POR ESPECÍFICAS-------------------------------------------->  
    
    </div>    
    </div> 
     
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->
<!------------------------------------------------------------------------------------------------------------------------------->    
</body>
    

</html>