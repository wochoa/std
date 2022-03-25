<!DOCTYPE html>
<html lang="en">

<head>
    <title>FORMATO F-2</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{asset('js/jquery.js')}}"></script>
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
    
    @include('tramite.stylesheet')
    @include('tramite.scripts')
    
    @section('metas')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endsection 
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
                <tr bgcolor="#98CCF4">
                    <th style="text-align: center" width="100%">FORMATO F-2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO</th>
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
                    <td width="25%" style="text-align: center">(Número y Nombre de la Unidad Ejecutora)</td>
                    <td width="15%" class="active"><b>1.2. Unidad Orgánica</b></td>
                    <td width="25%" style="text-align: center">(Nombre de la Unidad Orgánica)</td>
                    <td width="10%" class="active"><b>1.3. Año</b></td>
                    <td width="10%" style="text-align: center">(Año de Formulación)</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 1. INFORMACIÓN GENERA--> 
       
    <!--2. ALINEAMIENTO ESTRATÉGICO-->     
        <table class="table table-bordered table-condensed" width="100%">    
            <thead>
                <tr class="info">
                    <th colspan="8">2. ALINEAMIENTO ESTRATÉGICO</th>
                </tr>
            </thead>
            <tbody style="text-align: center">
                <tr>
                    <td class="active" colspan="2"><b>2.1. Visión Regional</b></td>
                    <td colspan="2">{{$vision->vision}}</td>
                    <td class="active"><b>2.2. Misión Institucional</b></td>
                    <td colspan="3">{{$mision->mision}}</td>
                </tr>
                
                <tr>
                    <td class="active" colspan="2"><b>2.3. Plan Estratégico</b></td>
                    <td class="active"><b>2.4. Código</b></td>
                    <td class="active"><b>2.5. Descripción</b></td>
                    <td class="active" rowspan="2" style="padding-top: 25px" width="20%"><b>2.6. Indicador</b></td>
                    <td class="active" rowspan="2" style="padding-top: 25px"><b>2.7. Unidad de Medida</b></td>
                    <td class="active" rowspan="2" style="padding-top: 25px" width="10%" colspan="2"><b>2.8. Meta</b></td>
                </tr>
                   
                <tr>
                    <td class="active" rowspan="3" style="padding-top: 20px"><b>2.3.1. PDRC Huánuco al 2021</b></td>
                    <td class="active"><b>C.E.</b></td>
                    <td colspan="2">
                        <select class="form-control select2" name="sel_cei" id="sel_cei">
                        <option value>--- Selecione Opción ---</option>
                        @foreach($ces as $ce)
                            <option value="{{$ce->id}}">{{$ce->codigo}}.- {{$ce->nombre}}</option>
                        @endforeach
                        </select>
                    </td>
                </tr>
                   
                <tr>
                    <td class="active"><b>O.E.T.</b></td>
                    <td colspan="2">
                        <select class="form-control select2" name="sel_oet" id="sel_oet">
                        <option value>--- Selecione Opción ---</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control select2" name="sel_oet_indicador" id="sel_oet_indicador">
                        </select>
                    </td>
                    <td>
                        <select class="form-control select2" name="sel_oet_unidad_medida" id="sel_oet_unidad_medida">
                        </select>
                    </td>
                    <td>
                        <input style="text-align: center" type="text" name="plan_det_id" id="plan_det_id" class="form-control" readonly>
                    </td>
                    <td>
                        <input style="text-align: center" type="text" name="meta_oet" id="meta_oet" class="form-control" readonly>
                    </td>
                </tr>
                   
                <tr>
                    <td class="active"><b>A.E.T.</b></td>
                    <td>(Del A.E.T.)</td>
                    <td>(Acción Estratégico Territorial)</td>
                    <td>(Nombre del Indicador del A.E.T.)</td>
                    <td>(Unidad de Medida del Indicador del A.E.T.)</td>
                    <td>(Meta Anual)</td>
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
                    <td>(Meta Anual)</td>
                </tr>
                
                <tr>
                    <td class="active"><b>A.E.I.</b></td>
                    <td>(Del A.E.I.)</td>
                    <td>(Acción Estratégico Institucional)</td>
                    <td>(Nombre del Indicador del A.E.I.)</td>
                    <td>(Unidad de Medida del Indicador del A.E.I.)</td>
                    <td>(Meta Anual)</td>
                    <td>(Meta Anual)</td>
                </tr>
            </tbody>
        </table>
    <!--FIN 2. ALINEAMIENTO ESTRATÉGICO--> 
       
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
                    <td>
                        <label class="radio-inline"><input type="radio" name="cat_presupuestal" id="cate1" value="9001"><b> 9001</b></label>   
                    </td> 
                    <td colspan="3">Acciones Centrales</td>    
                </tr>
                
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="cat_presupuestal" id="cate2" value="9002"><b> 9002</b></label>
                    </td>    
                    <td colspan="3">Asignación Presupuestaria que no resulta en Productos</td>    
                </tr>
                
                <tr>
                    <td>
                        <label class="radio-inline"><input type="radio" name="cat_presupuestal" id="cate3" value="9000"><b> 0000</b></label>
                    </td>    
                    <td colspan="3">
                        <select class="form-control select2" name="prog_pres" id="prog_pres">
                        <option value>--- Selecione Opción ---</option>
                        @foreach($prog_p as $prog)
                            <option value="{{$prog->id}}">{{$prog->id}}.- {{$prog->nombre}}</option>
                        @endforeach
                        </select>
                    </td>    
                    <td colspan="2">(Resultado final o específico del PP)</td>    
                    <td>(Indicador del PP)</td>    
                    <td>(Meta del PP)</td>    
                </tr>
                
                <tr>
                    <td class="active" rowspan="2"><b>3.7. Estructura Funcional Programática</b></td>
                    <td class="active"><b>Función</b></td>
                    <td class="active"><b>Divición Funcional</b></td>
                    <td class="active"><b>Grupo Funcional</b></td>
                    <td class="active"><b>Categoría Presupuestal</b></td>
                    <td class="active"><b>Prodcuto/Proyecto</b></td>
                    <td class="active"><b>Actividad/Acción/Obra</b></td>
                    <td class="active"><b>Finalidad</b></td>
                    <td class="active"><b>Meta Presupuetaria</b></td>
                </tr>
                
                <tr>
                    <td><input type="text" id="funcion" name="funcion" class="form-control art_pres" readonly></td>
                    <td><input type="text" id="div_funcional" name="div_funcional" class="form-control art_pres" readonly></td>
                    <td><input type="text" id="grupo_funcional" name="grupo_funcional" class="form-control art_pres" readonly></td>
                    <td><input type="text" id="cat_pres" name="cat_pres" class="form-control art_pres" readonly></td>
                    <td><input type="text" id="prod_proy" name="prod_proy" class="form-control art_pres" readonly></td>
                    <td><input type="text" id="act_obra" name="act_obra" class="form-control art_pres" readonly></td>
                    <td><input type="text" id="finalidad" name="finalidad" class="form-control art_pres" readonly></td>
                    <td>
                        <select class="form-control select2" name="sel_meta_presupuestaria" id="sel_meta_presupuestaria">
                        <option value> Nro°</option>
                        @foreach($meta as $met)
                            <option value="{{$met->ID}}">{{$met->numero}}</option>
                        @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    <!--FIN 3. ARTICULACIÓN PRESUPUESTARIA--> 
    
    <!--4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->        
        <table class="table table-bordered table-condensed"> 
        <!--TITULOS-->     
            <thead>
                <tr class="info">
                    <th colspan="20">4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD</th>
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
                <tr style="text-align: center">
                    <td>
                        <select class="form-control select2" name="meta_pres" id="meta_pres">
                        <option value> Nro°</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" id="codigo_actividad" name="codigo_actividad" class="form-control">
                    </td>
                    <td colspan="4">
                        <input type="text" id="nombre_actividad" name="nombre_actividad" class="form-control">
                    </td>
                    <td colspan="3">
                        <input type="text" id="nombre_indicador" name="nombre_indicador" class="form-control">
                    </td>
                    <td colspan="2">
                        <input type="text" id="um_indicador" name="um_indicador" class="form-control">
                    </td>
                    <td colspan="2">
                        <input type="text" id="valor_meta" name="valor_meta" class="form-control">
                    </td>
                    <td colspan="2">
                        <input type="text" id="monto_financiamiento" name="monto_financiamiento" class="form-control">
                    </td>
                    <td>
                        <input type="checkbox" value="1" id="fuente_finan1" name="fuente_finan1">
                    </td>
                    <td>
                        <input type="checkbox" value="2" id="fuente_finan2" name="fuente_finan2">
                    </td>
                    <td>
                        <input type="checkbox" value="3" id="fuente_finan3" name="fuente_finan3">
                    </td>
                    <td>
                        <input type="checkbox" value="4" id="fuente_finan4" name="fuente_finan4">
                    </td>
                    <td>
                        <input type="checkbox" value="5" id="fuente_finan5" name="fuente_finan5">
                    </td>
                </tr> 
        <!--FIN CUERPO 1-->
                       
        <!--CUERPO 2-->
                <tr style="text-align: center">
                    <td class="active" colspan="2"><b>4.8. Actividad-Proyecto</b></td>
                    <td class="active" colspan="6"><b>4.8.1. Descripción</b></td>
                    <td class="active" colspan="3"><b>4.8.2. Localización</b></td>
                    <td class="active" colspan="3"><b>4.8.3. Beneficiarios</b></td>
                    <td class="active" colspan="4"><b>4.8.4. Estrategia(s) Operativa(s)</b></td>
                    <td class="active" colspan="2"><b>4.9. Prioridad</b></td>
                </tr>
                   
                <tr style="text-align: center">
                    <td colspan="2"><input type="text" id="nombre_act" name="nombre_act" class="form-control"></td>
                    <td colspan="6"><textarea class="form-control" id="descripcion" name="descripcion"></textarea></td>
                    <td colspan="3"><textarea class="form-control" id="localizacion" name="localizacion"></textarea></td>
                    <td colspan="3"><textarea class="form-control" id="beneficiarios" name="beneficiarios"></textarea></td>
                    <td colspan="4"><textarea class="form-control" id="estrategias" name="estrategias"></textarea></td>
                    <td colspan="2"><textarea class="form-control" id="prioridad" name="prioridad"></textarea></td>
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
                    <td class="active" rowspan="2"><b>Total I Anual</b></td>
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
                    <td class="active" rowspan="2"><b>Actividad 1</b></td>
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
                    <td class="active"> - </td>
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
                    <td class="active"> - </td>
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
                    <td class="active"> - </td>
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
                    <td class="active"> - </td>
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
                    <td class="active"> - </td>
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
                    <td class="active"> - </td>
                </tr>
        <!--FIN CUERPO 3-->        
            </tbody>
        </table>
    <!--FIN 4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->     
    
    </div>    
    </div>    
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->
<script type="text/javascript">
    $('input:radio[name=cat_presupuestal]').change(function () {
        $('input:radio[name=cat_presupuestal]').each(function(){
            
            td = $(this).closest('td');
            td.next().removeClass('info');
        })
            td = $(this).closest('td');
            td.next().addClass('info');
            console.log(td);
        });
    
        $("#nombre_actividad").blur(function() {
            var id = $(this).val();
            $("#nombre_act").val(id);
        });
    
    
        $("#sel_cei").on("change", function(event){
			$("#sel_oet").empty();
			$("#sel_oet_indicador").empty();
			$("#sel_oet_unidad_medida").empty();
			$("#plan_det_id").val('');
			$("#meta_oet").empty();
				//tipo 1 para obtener los oets
			$.get("oetid/1/" + $(this).val(), function(response, state){
				$("#sel_oet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");
				if(response.length == 1){
					$("#sel_oet_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
					$("#sel_oet_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
					$("#plan_det_id").val( response[0].plan_det_id );
					$("#meta_oet").val( response[0].plan_det_meta );
				}
				else{
					$("#sel_oet_indicador").append("<option value=''>Seleccione</option>");
					$("#sel_oet_unidad_medida").append("<option value=''>Seleccione</option>");
					$.each( response, function(key, value){
						$("#sel_oet_indicador").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_indicador + ". " + value.plan_det_indicador + "</option>");
					});
				}
				$("#sel_oet_unidad_medida").change();
			});
        });
        
        $("#sel_oet_unidad_medida").on("change", function(event){
			$("#sel_aet").empty();
			$("#sel_aet_indicador").empty();
			$("#sel_aet_unidad_medida").empty();
			$("#plan_det_id_aet").val('');
			$("#meta_aet").empty();
				//tipo 3 para obtener los aets
			$.get("oet/3/" + $(this).val(), function(response, state){
				console.log(response.length);
				if(response.length == 1){
					$("#sel_aet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");
					$("#sel_aet_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
					$("#sel_aet_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
					$("#plan_det_id_aet").val( response[0].plan_det_id );
					$("#meta_aet").text( response[0].plan_det_meta );
				}
				else{
					$("#sel_aet").append("<option value=''>Seleccione</option>");
					$("#sel_aet_indicador").append("<option value=''>Seleccione</option>");
					$("#sel_aet_unidad_medida").append("<option value=''>Seleccione</option>");
					cod_anterior=0;
					$.each( response, function(key, value){
						if( cod_anterior != value.plan_det_codigo ){
							cod_anterior = value.plan_det_codigo
							$("#sel_aet").append("<option value='" + value.plan_det_codigo +"'>" + value.plan_det_codigo + ". " + value.plan_det_descripcion + "</option>");
						}
					});
				}
			});
		});
    
        $("#sel_meta_presupuestaria").on("change", function(event){
			$(".art_pres").empty();
			
			$.get("metasid/" + $(this).val(), function(response, state){
				$("#funcion").val( response[0].FUNCION );
				$("#div_funcional").val( response[0].PROGRAMA );
				$("#grupo_funcional").val( response[0].SUB_PROGRA );
				$("#cat_pres").val( response[0].PROGRAMA_P );
				$("#prod_proy").val( response[0].FUNCION );
				$("#act_obra").val( response[0].ACT_PROY );
				$("#finalidad").val( response[0].FINALIDAD );
			});
		});
    
        /*$("#meta_pres").on("change", function(event) {
            $("#funcion").val('Buscando ...');
            $("#div_funcional").val('Buscando ...');
            $("#grupo_funcional").val('Buscando ...');
            $("#cat_pres").val('Buscando ...');
            $("#prod_proy").val('Buscando ...');
            $("#act_obra").val('Buscando ...');
            $("#finalidad").val('Buscando ...');
            var id = $(this).val();
            $.ajax({
              url: "{{url('poi/metasid')}}",
              data: {
              dni: id
              },
              type: "POST",
              success: function(json) {
                $("#funcion").val(json['funcion']);
                $("#div_funcional").val(json['div_funcional']);
                $("#grupo_funcional").val(json['grupo_funcional']);
                $("#cat_pres").val(json['cat_pres']);
                $("#prod_proy").val(json['prod_proy']);
                $("#act_obra").val(json['act_obra']);
                $("#finalidad").val(json['finalidad']);
              }
            });
        });*/
</script>
<!------------------------------------------------------------------------------------------------------------------------------->    
</body>

</html>