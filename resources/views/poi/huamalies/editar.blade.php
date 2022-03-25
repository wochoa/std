@extends('layouts.plantillaPoi')

@section('titulo')
    Nuevo|Huamalies
@endsection
@section('contenido') 

{!! Form::open(array('url' => 'poi/huamalies/'.$id, 'method' =>'PUT')) !!}  {{csrf_field()}}  
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
                    <td width="25%" style="text-align: center">{{$actividades->unieje}}.- {{strtoupper($actividades->nomunieje)}}</td>
                    <td width="15%" class="active"><b>1.2. Unidad Orgánica</b></td>
                    <td width="25%" style="text-align: center">{{strtoupper($actividades->nomofi)}}</td>
                    <td width="10%" class="active"><b>1.3. Año</b></td>
                    <td width="10%" style="text-align: center">{{$actividades->anio}}</td>
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
                    <td class="active2" rowspan="3" style="padding-top: 20px"><b>2.3.1. PDRC Huánuco al 2021</b></td>
                    <td class="active2"><b>C.E.</b></td>
                    <td colspan="2">
                        <select class="form-control select2" name="sel_cei" id="sel_cei">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($ces as $ce)
                                @if($cadena->ce == $ce->id)
                                    <option value="{{$ce->id}}" selected>{{$ce->codigo}}.- {{$ce->nombre}}</option>
                                @else
                                    <option value="{{$ce->id}}">{{$ce->codigo}}.- {{$ce->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="active2"><b>O.E.T.</b></td>
                    <td colspan="2">
                        <select name="sel_oet" id="sel_oet" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($oets AS $oet)
                                @if($cadena->oet == $oet->id)
                                    <option value="{{$oet->id}}" selected>{{$oet->codigo}}.- {{$oet->nombre}}</option>
                                @else
                                    <option value="{{$oet->id}}">{{$oet->codigo}}.- {{$oet->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="sel_oet_indicador" id="sel_oet_indicador" class="form-control select2">
                            @foreach($oets AS $oet)
                                @if($cadena->oet == $oet->id)
                                    <option value="{{$oet->id}}" selected>{{$oet->codindicador}}.- {{$oet->indicador}}</option>
                                @else
                                    <option value="{{$oet->id}}">{{$oet->codindicador}}.- {{$oet->indicador}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="sel_oet_unidad_medida" id="sel_oet_unidad_medida" class="form-control select2">
                            @foreach($oets AS $oet)
                                @if($cadena->oet == $oet->id)
                                    <option value="{{$oet->id}}" selected>{{$oet->codmedida}}.- {{$oet->medida}}</option>
                                @else
                                    <option value="{{$oet->id}}">{{$oet->codindicador}}.- {{$oet->indicador}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td><input name="plan_det_id_oet" id="plan_det_id_oet" class="form-control" type="text" value="{{$cadena->oet}}" readonly></td>
                    <td>
                        <select name="meta_oet" id="meta_oet" class="form-control select2">
                            <option value>---</option>
                            @foreach($oets AS $oet)
                                @if($cadena->oet == $oet->id)
                                    <option value="{{$oet->id}}" selected>{{$oet->meta}}</option>
                                @else
                                    <option value="{{$oet->id}}">{{$oet->meta}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="active2"><b>A.E.T.</b></td>
                    <td colspan="2">
                        <select name="sel_aet" id="sel_aet" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($aets AS $aet)
                                @if($cadena->aet == $aet->id)
                                    <option value="{{$aet->id}}" selected>{{$aet->codigo}}.- {{$aet->nombre}}</option>
                                @else
                                    <option value="{{$aet->id}}">{{$aet->codigo}}.- {{$aet->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="sel_aet_indicador" id="sel_aet_indicador" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($aets AS $aet)
                                @if($cadena->aet == $aet->id)
                                    <option value="{{$aet->id}}" selected>{{$aet->codindicador}}.- {{$aet->indicador}}</option>
                                @else
                                    <option value="{{$aet->id}}">{{$aet->codindicador}}.- {{$aet->indicador}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="sel_aet_unidad_medida" id="sel_aet_unidad_medida" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($aets AS $aet)
                                @if($cadena->aet == $aet->id)
                                    <option value="{{$aet->id}}" selected>{{$aet->codmedida}}.- {{$aet->medida}}</option>
                                @else
                                    <option value="{{$aet->id}}">{{$aet->codmedida}}.- {{$aet->medida}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td><input name="plan_det_id_aet" id="plan_det_id_aet" class="form-control" type="text" value="{{$cadena->aet}}" readonly></td>
                    <td>
                        <select name="meta_aet" id="meta_aet" class="form-control select2" type="text">
                           <option value>---</option>
                            @foreach($aets AS $aet)
                                @if($cadena->aet == $aet->id)
                                    <option value="{{$aet->id}}" selected>{{$aet->meta}}</option>
                                @else
                                    <option value="{{$aet->id}}">{{$aet->meta}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="active2" rowspan="2" style="padding-top: 15px"><b>2.3.2. PEI 2017-2019</b></td>
                    <td class="active2"><b>O.E.I.</b></td>
                    <td colspan="2">
                        <select name="sel_oei" id="sel_oei" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($oeis AS $oei)
                                @if($cadena->oei == $oei->id)
                                    <option value="{{$oei->id}}" selected>{{$oei->codigo}}.- {{$oei->nombre}}</option>
                                @else
                                    <option value="{{$oei->id}}">{{$oei->codigo}}.- {{$oei->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="sel_oei_indicador" id="sel_oei_indicador" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($oeis AS $oei)
                                @if($cadena->oei == $oei->id)
                                    <option value="{{$oei->id}}" selected>{{$oei->codindicador}}.- {{$oei->indicador}}</option>
                                @else
                                    <option value="{{$oei->id}}">{{$oei->codindicador}}.- {{$oei->indicador}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="sel_oet_unidad_medida" id="sel_oei_unidad_medida" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($oeis AS $oei)
                                @if($cadena->oei == $oei->id)
                                    <option value="{{$oei->id}}" selected>{{$oei->codmedida}}.- {{$oei->medida}}</option>
                                @else
                                    <option value="{{$oei->id}}">{{$oei->codmedida}}.- {{$oei->medida}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td><input name="plan_det_id_oei" id="plan_det_id_oei" class="form-control" type="text" value="{{$cadena->oei}}" readonly></td>
                    <td>
                        <select name="meta_oei" id="meta_oei" class="form-control select2">
                            <option value>---</option>
                            @foreach($oeis AS $oei)
                                @if($cadena->oei == $oei->id)
                                    <option value="{{$oei->id}}" selected>{{$oei->meta}}</option>
                                @else
                                    <option value="{{$oei->id}}">{{$oei->meta}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="active2"><b>A.E.I.</b></td>
                    <td colspan="2">
                        <select name="sel_aei" id="sel_aei" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($aeis AS $aei)
                                @if($cadena->aei == $aei->id)
                                    <option value="{{$aei->id}}" selected>{{$aei->codigo}}.- {{$aei->nombre}}</option>
                                @else
                                    <option value="{{$aei->id}}">{{$aei->codigo}}.- {{$aei->nombre}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="sel_aei_indicador" id="sel_aei_indicador" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($aeis AS $aei)
                                @if($cadena->aei == $aei->id)
                                    <option value="{{$aei->id}}" selected>{{$aei->codindicador}}.- {{$aei->indicador}}</option>
                                @else
                                    <option value="{{$aei->id}}">{{$aei->codindicador}}.- {{$aei->indicador}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="sel_aet_unidad_medida" id="sel_aei_unidad_medida" class="form-control select2">
                            <option value>--- Selecione Opción ---</option>
                            @foreach($aeis AS $aei)
                                @if($cadena->aei == $aei->id)
                                    <option value="{{$aei->id}}" selected>{{$aei->codmedida}}.- {{$aei->medida}}</option>
                                @else
                                    <option value="{{$aei->id}}">{{$aei->codmedida}}.- {{$aei->medida}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                    <td><input name="plan_det_id_aei" id="plan_det_id_aei" class="form-control" type="text" value="{{$cadena->aei}}" readonly></td>
                    <td>
                        <select name="meta_aei" id="meta_aei" class="form-control select2">
                            <option value>---</option>
                            @foreach($aeis AS $aei)
                                @if($cadena->aei == $aei->id)
                                    <option value="{{$aei->id}}" selected>{{$aei->meta}}</option>
                                @else
                                    <option value="{{$aei->id}}">{{$aei->meta}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
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
                    @if($actividades->categoria==9001)
                        <td class="info">
                            <label class="radio-inline"><input type="radio" name="cat_presupuestal" id="cate1" value="9001" checked><b> 9001</b></label>   
                        </td> 
                        <td colspan="3" class="info">Acciones Centrales</td>    
                    @else
                        <td> - </td> 
                        <td colspan="3"> - </td>
                    @endif
                </tr>
                
                <tr>
                    @if($actividades->categoria==9002)
                        <td class="info">
                            <label class="radio-inline"><input type="radio" name="cat_presupuestal" id="cate2" value="9002" checked><b> 9002</b></label>
                        </td>    
                        <td colspan="3" class="info">Asignación Presupuestaria que no resulta en Productos</td> 
                    @else
                        <td> - </td> 
                        <td colspan="3"> - </td>
                    @endif   
                </tr>
                
                <tr>
                    @if($actividades->categoria!=9002 && $actividades->categoria!=9001)
                        <td class="info">
                            <label class="radio-inline"><input type="radio" name="cat_presupuestal" id="cate3" value="{{$actividades->categoria}}" checked><b> {{$actividades->categoria}}</b></label>
                        </td>    
                        <td colspan="3" class="info">{{$prog_p->nombre}} </td>    
                        <td colspan="2" class="info">(Resultado final o específico del PP)</td>    
                        <td class="info">(Indicador del PP)</td>    
                        <td class="info">(Meta del PP)</td>
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
                    <td class="active"><b>División Funcional</b></td>
                    <td class="active"><b>Grupo Funcional</b></td>
                    <td class="active"><b>Categoría Presupuestal</b></td>
                    <td class="active"><b>Producto/Proyecto</b></td>
                    <td class="active"><b>Actividad/Acción/Obra</b></td>
                    <td class="active"><b>Finalidad</b></td>
                    <td class="active"><b>Meta Presupuetaria</b></td>
                </tr>
                
                <tr>
                    <td><input type="text" id="funcion" name="funcion" class="form-control text-center" value="{{$actividades->funcion}}" readonly></td>
                    <td><input type="text" id="div_funcional" name="div_funcional" class="form-control text-center" value="{{$actividades->division}}" readonly></td>
                    <td><input type="text" id="grupo_funcional" name="grupo_funcional" class="form-control text-center" value="{{$actividades->grupo}}" readonly></td>
                    <td><input type="text" id="cat_pres" name="cat_pres" class="form-control text-center" value="{{$actividades->categoria}}" readonly></td>
                    <td><input type="text" id="prod_proy" name="prod_proy" class="form-control text-center" value="{{$actividades->producto}}" readonly></td>
                    <td><input type="text" id="act_obra" name="act_obra" class="form-control text-center" value="{{$actividades->actividad}}" readonly></td>
                    <td width="10%">
                        <select class="form-control" name="sel_finalidad" id="sel_finalidad">
                            <option value="{{$actividades->finalidad}}">{{$actividades->finalidad}}</option>
                        </select>
                    <td>
                        <select class="form-control" name="sel_meta_presupuestaria" id="sel_meta_presupuestaria">
                            <option value> Nro°</option>
                            @foreach($metas AS $meta)
                                @if($actividades->siaf == $meta->id)
                                    <option value="{{$meta->id}}" selected>{{$meta->meta}}</option>   
                                @else
                                    <option value="{{$meta->id}}">{{$meta->meta}}</option>   
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    <!--FIN 3. ARTICULACIÓN PRESUPUESTARIA--> 
    
    <div style="display:none;">
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
                    <td>{{$actividades->uniresponsable}}</td>
                    <td>
                        <input type="text" id="codigo_actividad" name="codigo_actividad" class="form-control text-center" value="{{$actividades->actid}}" readonly>
                    </td>
                    <td colspan="4" width="21%">
                        <textarea id="nombre_actividad" name="nombre_actividad" class="form-control text-center" style="font-size:11px; font-family: Tahoma;" readonly>{{$actividades->nomact}}</textarea>
                    </td>
                    <td colspan="3">
                        <input type="text" id="nombre_indicador" name="nombre_indicador" class="form-control text-center" value="{{$actividades->indicador}}">
                    </td>
                    <td colspan="2">
                        <input type="text" id="um_indicador" name="um_indicador" class="form-control text-center" value="{{$actividades->medida}}">
                    </td>
                    <td colspan="2">
                        <input type="text" id="valor_meta" name="valor_meta" class="form-control" value="{{$actividades->fisica}}">
                    </td>
                    <td colspan="2">
                        <input type="text" id="monto_financiamiento" name="monto_financiamiento" class="form-control" value="{{$fuente->total}}">
                    </td>
                    @if($actividades->fuente1 == 1)
                        <input type="hidden" name="fuente_finan1" value="1">
                        <td class="info"><b>{{$fuente->total}}</b></td>
                    @else
                        <td></td>
                    @endif
                    @if($actividades->fuente1 == 2)
                        <input type="hidden" name="fuente_finan1" value="2">
                        <td class="info"><b>{{$fuente->total}}</b></td>
                    @else
                        <td></td>
                    @endif
                    @if($actividades->fuente1 == 3)
                        <input type="hidden" name="fuente_finan1" value="3">
                        <td class="info"><b>{{$fuente->total}}</b></td>
                    @else
                        <td> </td>
                    @endif
                    @if($actividades->fuente1 == 4)
                        <input type="hidden" name="fuente_finan1" value="4">
                        <td class="info"><b>{{$fuente->total}}</b></td>
                    @else
                        <td></td>
                    @endif
                    @if($actividades->fuente1 == 5)
                        <input type="hidden" name="fuente_finan1" value="5">
                        <td class="info"><b>{{$fuente->total}}</b></td>
                    @else
                        <td></td>
                    @endif
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
                    <td colspan="2"><textarea id="nombre_act" name="nombre_act" class="form-control text-center" style="font-size:11px; font-family: Tahoma;" readonly>{{$actividades->nomact}}</textarea></td>
                    <td colspan="6"><textarea class="form-control" id="descripcion" name="descripcion">{{$actividades->descripcion}}</textarea></td>
                    <td colspan="3"><textarea class="form-control" id="localizacion" name="localizacion">{{$actividades->local}}</textarea></td>
                    <td colspan="3"><textarea class="form-control" id="beneficiarios" name="beneficiarios">{{$actividades->beneficio}}</textarea></td>
                    <td colspan="4"><textarea class="form-control" id="estrategias" name="estrategias">{{$actividades->estrategia}}</textarea></td>
                    <td colspan="2" width="8%">
                        <select class="form-control" name="prioridad" id="prioridad">
                            <option value> ------- </option>
                            @if($actividades->siaf == 1)
                                <option value="1" selected> NORMAL </option>
                                <option value="2"> URGENTE </option>
                            @else
                                <option value="1"> NORMAL </option>
                                <option value="2"> URGENTE </option>
                            @endif
                        </select>
                    </td>
                </tr> 
        <!--FIN CUERPO 2-->
                       
        
            </tbody>
        </table>
    <!--FIN 4. PROGRAMACIÓN OPERATIVA POR ACTIVIDAD-->     
    </div>
    
    </div>    
    <div class="col-xs-12">
        <a href="#" onclick="javascript:window.close()" class="btn btn-danger"><i class="glyphicon glyphicon-off"></i> Salir</a>
        <a href="{{url('poi/anteproyecto/f2/'.$id)}}" class="btn btn-primary"><i class="glyphicon glyphicon-fast-backward"></i> Volver</a>
        <button class="btn btn-success pull-right"><i class="glyphicon glyphicon-save"></i> Guardar</button>
    </div>
    <br> <br>
    </div>    
    
{!! Form::close() !!}
<!--FIN FORMATO F2: PROGRAMACIÓN OPERATIVA DE LA ACT
<!------------------------------------------------------------------------------------------------------------------------------->  
<script type="text/javascript">
              
    /*$("#meta_oet").change(function(){
        $('#plan_det_id_oet').val($(this).val());
	});          
    $("#meta_aet").change(function(){
        $('#plan_det_id_aet').val($(this).val());
	});          
    $("#meta_oei").change(function(){
        $('#plan_det_id_oei').val($(this).val());
	});          
    $("#meta_aei").change(function(){
        $('#plan_det_id_aei').val($(this).val());
	});*/
    //--------------------- CEI -----------------------
    $("#sel_cei").on("change", function(event){
        $("#sel_oet").empty();        
        $("#sel_oet_indicador").empty();
        $("#sel_oet_unidad_medida").empty();
        $("#plan_det_id_oet").val('');
        $("#meta_oet").empty();  
        $("#sel_aet").empty();          
        $("#sel_aet_indicador").empty();
        $("#sel_aet_unidad_medida").empty();
        $("#plan_det_id_aet").val('');
        $("#meta_aet").val(''); 
        $("#sel_oei").empty();          
        $("#sel_oei_indicador").empty();
        $("#sel_oei_unidad_medida").empty();
        $("#plan_det_id_oei").val('');
        $("#meta_oei").val('');    
        $("#sel_aei").empty();          
        $("#sel_aei_indicador").empty();
        $("#sel_aei_unidad_medida").empty();
        $("#plan_det_id_aei").val('');
        $("#meta_aei").val('');    
        //tipo 1 para obtener los oets
        $.get("../oet/1/" + $(this).val(), function(response, state){
            $("#sel_oet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");
            if(response.length == 1){    
                $("#sel_oet_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
                $("#sel_oet_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
                $("#plan_det_id_oet").val( response[0].plan_det_id );
                $("#meta_oet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_meta + "</option>");
                $("#meta_oet").change();
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
    
    //--------------------- OET -----------------------
    $("#sel_oet_indicador").on("change", function(event){
        $("#sel_oet_unidad_medida").empty();
        $("#plan_det_id_oet").val('');
        $("#meta_oet").empty();
        $("#sel_oei").empty();          
        $("#sel_oei_indicador").empty();
        $("#sel_oei_unidad_medida").empty();
        $("#plan_det_id_oei").val('');
        $("#meta_oei").empty();  
        $("#sel_aei").empty();          
        $("#sel_aei_indicador").empty();
        $("#sel_aei_unidad_medida").empty();
        $("#plan_det_id_aei").val('');
        $("#meta_aei").empty();  
        //tipo 2 para obtener los oets
        $.get("../oet/2/" + $(this).val(), function(response, state){
            $.each( response, function(key, value){
                $("#sel_oet_unidad_medida").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_unidad_medida + ". " + value.plan_det_unidad_medida + "</option>");                
                $("#plan_det_id_oet").val( value.plan_det_id );
                $("#meta_oet").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_meta + "</option>"); 
            });
        $("#sel_oet_unidad_medida").change();
        });   
        
        $.get("../oei/1/" + $("#sel_cei").val(), function(response, state){            
            if(response.length == 1){
                    //$("#sel_oet").change();
                    $("#sel_oei").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");						
                    $("#sel_oei_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
                    $("#sel_oei_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
                    $("#plan_det_id_oei").val( response[0].plan_det_id );
                    $("#meta_oei").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_meta + "</option>");
                    //$("#sel_oei").change();
            }
            else{
                $("#sel_oei").append("<option value=''>Seleccione</option>");
                $("#sel_oei_indicador").append("<option value=''>Seleccione</option>");
                $("#sel_oei_unidad_medida").append("<option value=''>Seleccione</option>");
                var cod_anterior=0;
                $.each( response, function(key, value){                    
                    if( cod_anterior != value.plan_det_codigo ){
                        cod_anterior = value.plan_det_codigo
                        $("#sel_oei").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_codigo + ". " + value.plan_det_descripcion + "</option>");	
                    }
                });
            }
        });
    });
    
    //--------------------- AET -----------------------
    $("#sel_oet_unidad_medida").on("change", function(event){
        $("#sel_aet").empty();
        $("#sel_aet_indicador").empty();
        $("#sel_aet_unidad_medida").empty();
        $("#plan_det_id_aet").val('');
        $("#meta_aet").empty();
        //tipo 3 para obtener los aets
        $.get("../oet/3/" + $(this).val(), function(response, state){
            //console.log(response.length);
            if(response.length == 1){
                $("#sel_aet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");
                $("#sel_aet_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
                $("#sel_aet_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
                $("#plan_det_id_aet").val( response[0].plan_det_id );
                $("#meta_aet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_meta + "</option>");
            }
            else{
                $("#sel_aet").append("<option value=''>Seleccione</option>");
                $("#sel_aet_indicador").append("<option value=''>Seleccione</option>");
                $("#sel_aet_unidad_medida").append("<option value=''>Seleccione</option>");
                cod_anterior=0;
                $.each( response, function(key, value){
                    if( cod_anterior != value.plan_det_codigo ){
                        cod_anterior = value.plan_det_codigo
                        $("#sel_aet").append("<option value='" + value.plan_det_id+"'>" + value.plan_det_codigo + ". " + value.plan_det_descripcion + "</option>");
                    }
                });
            }
        });
    });
    
    //--------------------- AET2 -----------------------
    $("#sel_aet").on("change", function(event){
        $("#sel_aet_unidad_medida").empty();
        $("#sel_aet_indicador").empty();
        $("#plan_det_id_aet").val('');
        $("#meta_aet").empty();
            //tipo 4 para obtener los oets
        $.get("../aet/1/" + $(this).val() + "/"  + $(this).val(), function(response, state){
            if( response.length == 1){
                $("#sel_aet_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
                $("#sel_aet_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
                $("#plan_det_id_aet").val( response[0].plan_det_id );
                $("#meta_aet").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_meta + "</option>");
            }
            else{
                $("#sel_aet_indicador").append("<option value=''>Seleccione</option>");
                $("#sel_aet_unidad_medida").append("<option value=''>Seleccione</option>");
                $.each( response, function(key, value){
                    $("#sel_aet_indicador").append("<option value='" + value.plan_det_id +"' data-cod_ind='" + value.plan_det_cod_indicador +"' >" + value.plan_det_cod_indicador + ". " + value.plan_det_indicador + "</option>");
                });
            }
        });
    });
    //--------------------- AET 3 -----------------------
    $("#sel_aet_indicador").on("change", function(event){
        $("#sel_aet_unidad_medida").empty();
        $("#plan_det_id_aet").val('');
        $("#meta_aet").empty();
            //tipo 3 para obtener los oets
        $.get("../aet/2/" + $(this).val() + "/"  + $(this).val(), function(response, state){
            //console.log(response.length);
            $.each( response, function(key, value){
                $("#sel_aet_unidad_medida").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_unidad_medida + ". " + value.plan_det_unidad_medida + "</option>");                
                $("#plan_det_id_aet").val( value.plan_det_id );
                $("#meta_aet").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_meta + "</option>"); 
            });
        });
    });
    
    //--------------------- OEI -----------------------
    $("#sel_oei").on("change", function(event){
        $("#sel_oei_indicador").empty();
        $("#sel_oei_unidad_medida").empty();
        $("#plan_det_id_oei").val('');
        $("#meta_oei").empty();
        $.get("../oei/2/" + $(this).val(), function(response, state){
            //console.log(response.length);
            if(response.length == 1){
                $("#sel_oei_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
                $("#sel_oei_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
                $("#plan_det_id_oei").val( response[0].plan_det_id );
                $("#meta_oei").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_meta + "</option>");
            }
            else{
                $("#sel_oei_indicador").append("<option value=''>Seleccione</option>");
                $("#sel_oei_unidad_medida").append("<option value=''>Seleccione</option>");
                //cod_anterior=0;
                $.each( response, function(key, value){
                        $("#sel_oei_indicador").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_indicador + ". " + value.plan_det_indicador + "</option>");
                    
                });
            }
        });
    });
    //--------------------- OEI 2 -----------------------
    $("#sel_oei_indicador").on("change", function(event){
        $("#sel_oei_unidad_medida").empty();
        $("#plan_det_id_oei").val('');
        $("#meta_oei").empty();
            //tipo 3 para obtener los oets
        $.get("../oei/5/" + $(this).val(), function(response, state){
            //console.log(response.length);
            $.each( response, function(key, value){
                $("#sel_oei_unidad_medida").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_unidad_medida + ". " + value.plan_det_unidad_medida + "</option>");                
                $("#plan_det_id_oei").val( value.plan_det_id );
                $("#meta_oei").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_meta + "</option>"); 
            });
        });
    });
    //--------------------- OEI 3 -----------------------
    $("#meta_oet").on("change", function(event){
        $("#sel_oei").empty();
        $("#sel_oei_indicador").empty();
        $("#sel_oei_unidad_medida").empty();
        $("#plan_det_id_oei").val('');
        $("#meta_oei").empty();
            //tipo 3 para obtener los oets
        $.get("../oei/6/" + $(this).val(), function(response, state){
            //console.log(response.length);
            $.each( response, function(key, value){
                $("#sel_oei").append("<option value='" + value.plan_det_id+"'>" + value.plan_det_codigo + ". " + value.plan_det_descripcion + "</option>");
                $("#sel_oei_indicador").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_indicador + ". " + value.plan_det_indicador + "</option>");               
                $("#sel_oei_unidad_medida").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_unidad_medida + ". " + value.plan_det_unidad_medida + "</option>");                
                $("#plan_det_id_oei").val( value.plan_det_id );
                $("#meta_oei").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_meta + "</option>"); 
            });
        $("#sel_oei_unidad_medida").change();
        });
    });
    
    
    //--------------------- AEI -----------------------
    $("#sel_oei").on("change", function(event){
        $("#sel_aei").empty();
        $("#sel_aei_indicador").empty();
        $("#sel_aei_unidad_medida").empty();
        $("#plan_det_id_aei").val('');
        $("#meta_aei").empty();
        $.get("../oei/3/" + $(this).val(), function(response, state){
            if(response.length == 1){
                $("#sel_aei").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");
                $("#sel_aei_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
                $("#sel_aei_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
                $("#plan_det_id_aei").val( response[0].plan_det_id );
                $("#meta_aei").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_meta + "</option>");
            }
            else{
                $("#sel_aei").append("<option value=''>Seleccione</option>");
                cod_anterior=0;
                $.each( response, function(key, value){
                    if( cod_anterior != value.plan_det_codigo ){
                        cod_anterior = value.plan_det_codigo
                        $("#sel_aei").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_codigo + ". " + value.plan_det_descripcion + "</option>");
                    }
                });
            }
        });
    });
    
    //--------------------- AEI 2 -----------------------
    $("#sel_aei").on("change", function(event){
        $("#sel_aei_indicador").empty();
        $("#sel_aei_unidad_medida").empty();
        $("#plan_det_id_aei").val('');
        $("#meta_aei").empty();
        $.get("../oei/4/" + $(this).val(), function(response, state){
            if(response.length == 1){
                $("#sel_aei_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
                $("#sel_aei_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
                $("#plan_det_id_aei").val( response[0].plan_det_id );
                $("#meta_aei").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_meta + "</option>");
            }
            else{
                $("#sel_aei_indicador").append("<option value=''>Seleccione</option>");
                $("#sel_aei_unidad_medida").append("<option value=''>Seleccione</option>");                
                $.each( response, function(key, value){
                    $("#sel_aei_indicador").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_indicador + ". " + value.plan_det_indicador + "</option>");
                });
            }
        });
    });    
    //--------------------- AEI 3 -----------------------
    $("#sel_oei_unidad_medida").on("change", function(event){
        $("#sel_aei_indicador").empty();
        $("#sel_aei_unidad_medida").empty();
        $("#plan_det_id_aei").val('');
        $("#meta_aei").empty();
        $.get("../oei/7/" + $(this).val(), function(response, state){
            console.log(response.length);
            if(response.length == 1){
                $("#sel_aei").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_codigo + ". " + response[0].plan_det_descripcion + "</option>");
                $("#sel_aei_indicador").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_indicador + ". " + response[0].plan_det_indicador + "</option>");
                $("#sel_aei_unidad_medida").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_cod_unidad_medida + ". " + response[0].plan_det_unidad_medida + "</option>");
                $("#plan_det_id_aei").val( response[0].plan_det_id );
                $("#meta_aei").append("<option value='" + response[0].plan_det_id +"'>" + response[0].plan_det_meta + "</option>");
            }
            else{
                $("#sel_aei").append("<option value=''>Seleccione</option>");              
                cod_anterior=0;
                $.each( response, function(key, value){
                    if( cod_anterior != value.plan_det_codigo ){
                        cod_anterior = value.plan_det_codigo
                            $("#sel_aei").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_codigo + ". " + value.plan_det_descripcion + "</option>");     
                    }
                });
            }
        });
    });
    //---------------------AEI 4 -----------------------
    $("#sel_aei_indicador").on("change", function(event){
        $("#sel_aei_unidad_medida").empty();
        $("#plan_det_id_aei").val('');
        $("#meta_aei").empty();
            //tipo 3 para obtener los oets
        $.get("../oei/8/" + $(this).val(), function(response, state){
            //console.log(response.length);
            $.each( response, function(key, value){
                $("#sel_aei_unidad_medida").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_cod_unidad_medida + ". " + value.plan_det_unidad_medida + "</option>");                
                $("#plan_det_id_aei").val( value.plan_det_id );
                $("#meta_aei").append("<option value='" + value.plan_det_id +"'>" + value.plan_det_meta + "</option>"); 
            });
        });
    });
    
    //--------------------- META PRESUPUESTARIA -----------------------
    $("#sel_meta_presupuestaria").on("change", function(event){		
        $("#sel_finalidad").empty();
        $.get("../siafmetadatos/" + $(this).val(), function(response, state){
            if(response.length == 1){
                $("#sel_finalidad").append("<option value='" + response[0].FINALIDAD +"'>" + response[0].FINALIDAD +  "</option>");
            }
            else{
                $("#sel_finalidad").append("<option value=''>Seleccione</option>");
                $.each( response, function(key, value){
                    $("#sel_finalidad").append("<option value='" + value.FINALIDAD +"'>" + value.FINALIDAD + "</option>");
                });
            }
        });
    });
            
    </script>  
    
@endsection