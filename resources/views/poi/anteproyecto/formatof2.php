@extends('layouts.plantillaPoi')
@section('titulo')
    Formato F2| Actividad
@endsection


@section('contenido')
<!------------------------------------------------------------------------------------------------------------------------------>  
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
                    <td width="14%" style="text-align: center">(Número y Nombre de la Unidad Ejecutora)</td>
                    <td width="10%" class="active"><b>1.2. Unidad Orgánica</b></td>
                    <td width="37%" style="text-align: center">(Nombre de la Unidad Orgánica) {{ $id_poi }}</td>
                    <td width="10%" class="active"><b>1.3. Año</b></td>
                    <td width="37%" style="text-align: center">(Año de Formulación)</td>
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
                    <td colspan="2">(DEscripción de la Visión Regional)</td>
                    <td class="active"><b>2.2. Misión Institucional</b></td>
                    <td colspan="2">(Descripción de la Misión Institucional-PEI)</td>
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
                    <td>9001</td>    
                    <td colspan="3">Acciones Centrales</td>    
                </tr>
                
                <tr>
                    <td>9002</td>    
                    <td colspan="3">Asignación Presupuestaria que no resulta en Productos</td>    
                </tr>
                
                <tr>
                    <td>0000</td>    
                    <td colspan="3">(Programa Presupuestal)</td>    
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
                    <td>(cód. func.)</td>
                    <td>(cód. div. func.)</td>
                    <td>(cód. grup. func.)</td>
                    <td>(cód. cat. pres.)</td>
                    <td>(cód. prod./proy.)</td>
                    <td>(cód. act./acc./obr.)</td>
                    <td>(cód. final)</td>
                    <td>(cód. meta SIAF)</td>
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
                    <td>(Nombre de la Unidad)</td>
                    <td>(De la Actv)</td>
                    <td colspan="4">(Nombre de la act. 1)</td>
                    <td colspan="3">(Nombre del Indicador)</td>
                    <td colspan="2">(U.M. del Indicador)</td>
                    <td colspan="2">(Valor de la Meta)</td>
                    <td colspan="2">(Monto Financ.)</td>
                    <td><b> - </b></td>
                    <td><b> - </b></td>
                    <td><b> - </b></td>
                    <td><b> - </b></td>
                    <td><b> - </b></td>
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
                    <td colspan="2">Actividad 1</td>
                    <td colspan="6"> - </td>
                    <td colspan="3"> - </td>
                    <td colspan="3"> - </td>
                    <td colspan="4"> - </td>
                    <td colspan="2"> - </td>
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
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACTIVIDAD/PROYECTO-->
<!------------------------------------------------------------------------------------------------------------------------------->    
@endsection