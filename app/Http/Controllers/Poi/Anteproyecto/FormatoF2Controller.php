<?php

namespace App\Http\Controllers\Poi\Anteproyecto;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\_clases\poi\Poi;
use App\_clases\poi\PoiActividadProyecto;
use App\_clases\poi\PlanDetalle;
use App\_clases\siaf\SiafMeta;
use App\_clases\poi\PoiTarea;
use App\_clases\poi\PoiActividadEspecifica;
use App\_clases\poi\UnidadEjecutora;
use App\_clases\poi\Oficina;
use App\_clases\poi\ClasificadorGasto;
use App\_clases\poi\PoiActividadActividad;
use DB;

class formatoF2Controller extends Controller
{
    public function verf2($id)
    {
        $mision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as mision')->where('plan_det_id', '=', 1)->first();
        
        $vision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as vision')->where('plan_det_id', '=', 2)->first();
        
        $actividades=DB::table('poi_actividad_proyecto AS act')
            ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
            ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
            ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
            ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.idactividad_proyecto AS actid', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_pdrc_oet_meta1 AS meta_oet_1', 'act.act_proy_pdrc_oet_meta2 AS meta_oet_2', 'act.act_proy_pdrc_aet_meta1 AS meta_aet_1', 'act.act_proy_pdrc_aet_meta2 AS meta_aet_2', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
            ->where('act.idactividad_proyecto', '=', $id)
            ->first();
        
        $inversiones = DB::table('poi_actividad_actividad AS aa')
            ->leftJoin('poi_actividad_especifica AS ae', 'aa.actividad_id', '=', 'ae.especifica_id_actividad_actividad')
            ->select('aa.actividad_id AS id', 'aa.actividad_numero AS numero', 'aa.actividad_denominacion AS denominacion', 'aa.actividad_indicador AS indicador', 'aa.actividad_unidad_medida AS um', 'aa.actividad_descripcion AS descripcion', 'aa.actividad_tareas_operativas AS tareas', 'aa.actividad_beneficiarios AS beneficiarios', 'aa.actividad_localizacion AS localizacion', 'aa.actividad_prioridad_oei AS prioridad', 'aa.actividad_fisica_enero AS enero', 'aa.actividad_fisica_febrero AS febrero', 'aa.actividad_fisica_marzo AS marzo', 'aa.actividad_fisica_abril AS abril', 'aa.actividad_fisica_mayo AS mayo', 'aa.actividad_fisica_junio AS junio', 'aa.actividad_fisica_julio AS julio', 'aa.actividad_fisica_agosto AS agosto', 'aa.actividad_fisica_setiembre AS setiembre', 'aa.actividad_fisica_octubre AS octubre', 'aa.actividad_fisica_noviembre AS noviembre', 'aa.actividad_fisica_diciembre AS diciembre', 'aa.actividad_fisica_total AS total', 
                DB::raw('sum(ae.especifica_enero) AS esp_enero'),
                DB::raw('sum(ae.especifica_febrero) AS esp_febrero'),
                DB::raw('sum(ae.especifica_marzo) AS esp_marzo'),
                DB::raw('sum(ae.especifica_abril) AS esp_abril'),
                DB::raw('sum(ae.especifica_mayo) AS esp_mayo'),
                DB::raw('sum(ae.especifica_junio) AS esp_junio'),
                DB::raw('sum(ae.especifica_julio) AS esp_julio'),
                DB::raw('sum(ae.especifica_agosto) AS esp_agosto'),
                DB::raw('sum(ae.especifica_setiembre) AS esp_setiembre'),
                DB::raw('sum(ae.especifica_octubre) AS esp_octubre'),
                DB::raw('sum(ae.especifica_noviembre) AS esp_noviembre'),
                DB::raw('sum(ae.especifica_diciembre) AS esp_diciembre'),
                DB::raw('sum(ae.especifica_monto_total) AS esp_monto_total'),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 1 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff1'
                        ),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 2 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff2'
                        ),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 3 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff3'
                        ),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 4 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff4'
                        ),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 5 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff5'
                        )
                    )
            ->where('aa.idactividad_proyecto', '=', $id)
            ->orderBy('aa.actividad_numero', 'asc')
            ->groupBy('aa.actividad_id')
            ->get();
        //dd($inversiones);
        $inversionrows=count($inversiones);   
        
        $ce=DB::table('poi_actividad_proyecto AS aproy')
            ->join('poi_plan_detalle AS pdet', 'aproy.act_proy_pdrc_ee', '=', 'pdet.plan_det_id')
            ->select('pdet.plan_det_codigo AS id', 'pdet.plan_det_descripcion AS descripcion')
            ->where('aproy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($ce))
            $ce=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        );
        
        $oet=DB::table('poi_actividad_proyecto AS proy')
            ->join('poi_plan_detalle AS det', 'proy.act_proy_pdrc_oet_meta1', '=', 'det.plan_det_id')
            ->select('det.plan_det_codigo AS id', 'det.plan_det_descripcion AS descripcion','det.plan_det_indicador AS indicador', 'det.plan_det_unidad_medida AS medida', 'det.plan_det_id AS meta1', 'det.plan_det_meta AS meta2')
            ->where('proy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($oet))
            $oet=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $aet=DB::table('poi_actividad_proyecto AS pro')
            ->join('poi_plan_detalle AS de', 'pro.act_proy_pdrc_aet_meta1', '=', 'de.plan_det_id')
            ->select('de.plan_det_codigo AS id', 'de.plan_det_descripcion AS descripcion', 'de.plan_det_indicador AS indicador', 'de.plan_det_unidad_medida AS medida', 'de.plan_det_id AS meta1', 'de.plan_det_meta AS meta2')
            ->where('pro.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($aet))
            $aet=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $oei=DB::table('poi_actividad_proyecto AS proy')
            ->join('poi_plan_detalle AS det', 'proy.act_proy_objetivo_id_meta', '=', 'det.plan_det_id')
            ->select('det.plan_det_codigo AS id', 'det.plan_det_descripcion AS descripcion','det.plan_det_indicador AS indicador', 'det.plan_det_unidad_medida AS medida', 'det.plan_det_id AS meta1', 'det.plan_det_meta AS meta2')
            ->where('proy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($oei))
            $oei=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $aei=DB::table('poi_actividad_proyecto AS pro')
            ->join('poi_plan_detalle AS de', 'pro.act_proy_accion_id_meta', '=', 'de.plan_det_id')
            ->select('de.plan_det_codigo AS id', 'de.plan_det_descripcion AS descripcion', 'de.plan_det_indicador AS indicador', 'de.plan_det_unidad_medida AS medida', 'de.plan_det_id AS meta1', 'de.plan_det_meta AS meta2')
            ->where('pro.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($aei))
            $aei=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
                        
        return view('poi.anteproyecto.formatof2.verf2', ['actividades'=>$actividades, 'mision'=>$mision, 'vision'=>$vision, 'ce'=>$ce, 'oet'=>$oet, 'aet'=>$aet, 'oei'=>$oei, 'aei'=>$aei, 'id'=>$id, 'inversiones'=>$inversiones, 'inversionrows'=>$inversionrows]);
    }

    public function guardarf2(Request $request)
    {
        $actividad = $request->idactividad_proyecto;
        
        $inversiones = new PoiActividadActividad();
        $inversiones->idactividad_proyecto = $request->idactividad_proyecto;
        $inversiones->actividad_numero = $request->actividad_numero;
        $inversiones->actividad_denominacion = mb_strtoupper($request->actividad_denominacion);
        $inversiones->actividad_indicador = mb_strtoupper($request->actividad_indicador);
        $inversiones->actividad_unidad_medida = mb_strtoupper($request->actividad_unidad_medida);
        $inversiones->actividad_descripcion = mb_strtoupper($request->actividad_descripcion);
        $inversiones->actividad_tareas_operativas = mb_strtoupper($request->actividad_tareas_operativas);
        $inversiones->actividad_beneficiarios = mb_strtoupper($request->actividad_beneficiarios);
        $inversiones->actividad_localizacion = mb_strtoupper($request->actividad_localizacion);
        $inversiones->actividad_prioridad_oei = mb_strtoupper($request->actividad_prioridad);
        $inversiones->actividad_fisica_enero = $request->actividad_fisica_enero;
        $inversiones->actividad_fisica_febrero = $request->actividad_fisica_febrero;
        $inversiones->actividad_fisica_marzo = $request->actividad_fisica_marzo;
        $inversiones->actividad_fisica_abril = $request->actividad_fisica_abril;
        $inversiones->actividad_fisica_mayo = $request->actividad_fisica_mayo;
        $inversiones->actividad_fisica_junio = $request->actividad_fisica_junio;
        $inversiones->actividad_fisica_julio = $request->actividad_fisica_julio;
        $inversiones->actividad_fisica_agosto = $request->actividad_fisica_agosto;
        $inversiones->actividad_fisica_setiembre = $request->actividad_fisica_setiembre;
        $inversiones->actividad_fisica_octubre = $request->actividad_fisica_octubre;
        $inversiones->actividad_fisica_noviembre = $request->actividad_fisica_noviembre;
        $inversiones->actividad_fisica_diciembre = $request->actividad_fisica_diciembre;
        $inversiones->actividad_fisica_total = $request->actividad_fisica_total;
        $inversiones->save();
        
        return redirect('poi/anteproyecto/f2/'.$actividad)->with('msg', 'La Actividad Operativa fue Creada Satisfactoriamente.');
    }

    public function editarf2(Request $request, $id)
    {
        $actividad = $request->idactividad_proyecto_edit;
        $inversiones = PoiActividadActividad::find($id);
        $inversiones->actividad_denominacion = mb_strtoupper($request->actividad_denominacion_edit);
        $inversiones->actividad_indicador = mb_strtoupper($request->actividad_indicador_edit);
        $inversiones->actividad_unidad_medida = mb_strtoupper($request->actividad_unidad_medida_edit);
        $inversiones->actividad_descripcion = mb_strtoupper($request->actividad_descripcion_edit);
        $inversiones->actividad_tareas_operativas = mb_strtoupper($request->actividad_tareas_operativas_edit);
        $inversiones->actividad_beneficiarios = mb_strtoupper($request->actividad_beneficiarios_edit);
        $inversiones->actividad_localizacion = mb_strtoupper($request->actividad_localizacion_edit);
        $inversiones->actividad_prioridad_oei = mb_strtoupper($request->actividad_prioridad_edit);
        $inversiones->actividad_fisica_enero = $request->actividad_fisica_enero_edit;
        $inversiones->actividad_fisica_febrero = $request->actividad_fisica_febrero_edit;
        $inversiones->actividad_fisica_marzo = $request->actividad_fisica_marzo_edit;
        $inversiones->actividad_fisica_abril = $request->actividad_fisica_abril_edit;
        $inversiones->actividad_fisica_mayo = $request->actividad_fisica_mayo_edit;
        $inversiones->actividad_fisica_junio = $request->actividad_fisica_junio_edit;
        $inversiones->actividad_fisica_julio = $request->actividad_fisica_julio_edit;
        $inversiones->actividad_fisica_agosto = $request->actividad_fisica_agosto_edit;
        $inversiones->actividad_fisica_setiembre = $request->actividad_fisica_setiembre_edit;
        $inversiones->actividad_fisica_octubre = $request->actividad_fisica_octubre_edit;
        $inversiones->actividad_fisica_noviembre = $request->actividad_fisica_noviembre_edit;
        $inversiones->actividad_fisica_diciembre = $request->actividad_fisica_diciembre_edit;
        $inversiones->actividad_fisica_total = $request->actividad_fisica_total_edit;
        $inversiones->save();
        
        return redirect('poi/anteproyecto/f2/'.$actividad)->with('msg', 'La Actividad Operativa fue Editada Satisfactoriamente.');
    }

    public function insumosf2($act, $inv)
    {
        $actividad=DB::table('poi_actividad_proyecto AS act')
        ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
        ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
        ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
        ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
        ->where('act.idactividad_proyecto', '=', $act)
        ->first();
        
        $inversion=PoiActividadActividad::select('actividad_id AS id', 'actividad_denominacion AS denominacion', 'actividad_indicador AS indicador', 'actividad_unidad_medida AS um', 'actividad_fisica_total AS total')->where('idactividad_proyecto', '=', $act)->where('actividad_id', '=', $inv)->orderBy('actividad_numero', 'asc')->first();
        
        $insumos=PoiActividadEspecifica::select('id_actividad_especifica AS id', 'especifica_fuente_financiamiento AS fuente', 'especifica_clasificador_gastos', 'especifica_unidad_medida AS um', 'especifica_cantidad AS cantidad', 'especifica_costo_referencial AS costo', 'especifica_monto_total AS monto', 'especifica_enero AS enero', 'especifica_febrero AS febrero', 'especifica_marzo AS marzo', 'especifica_abril AS abril', 'especifica_mayo AS mayo', 'especifica_junio AS junio', 'especifica_julio AS julio', 'especifica_agosto AS agosto', 'especifica_setiembre AS setiembre', 'especifica_octubre AS octubre', 'especifica_noviembre AS noviembre', 'especifica_diciembre AS diciembre')->where('especifica_id_actividad_actividad', '=', $inv)->orderBy('id_actividad_especifica')->get();
        $insumorows = count($insumos);
        
        $totalins=PoiActividadEspecifica::select(DB::raw('sum(especifica_cantidad) AS total_cantidad'), DB::raw('sum(especifica_enero) AS total_enero'),
        DB::raw('sum(especifica_febrero) AS total_febrero'), 
        DB::raw('sum(especifica_marzo) AS total_marzo'),
        DB::raw('sum(especifica_abril) AS total_abril'),
        DB::raw('sum(especifica_mayo) AS total_mayo'),
        DB::raw('sum(especifica_junio) AS total_junio'),
        DB::raw('sum(especifica_julio) AS total_julio'),
        DB::raw('sum(especifica_agosto) AS total_agosto'),
        DB::raw('sum(especifica_setiembre) AS total_setiembre'),
        DB::raw('sum(especifica_octubre) AS total_octubre'),
        DB::raw('sum(especifica_noviembre) AS total_noviembre'),
        DB::raw('sum(especifica_diciembre) AS total_diciembre'),
        DB::raw('sum(especifica_monto_total) AS total_monto'))
            ->where('especifica_id_actividad_actividad', '=', $inv)
            ->groupBy('especifica_id_actividad_actividad')
            ->first();
        
        $gastos=ClasificadorGasto::select('idclasificador_gasto AS id', 'cg_descripcion AS nombre', DB::raw('Replace(cg_clasificador, " ", ".") AS clasificador'))
            ->having( DB::raw('LENGTH(clasificador)'), '>=','11')
            ->get();
        
        return view('poi.anteproyecto.formatof2.insumosf2', ['act'=>$act, 'inv'=>$inv, 'inversion'=>$inversion, 'actividad'=>$actividad, 'insumos'=>$insumos, 'insumorows'=>$insumorows, 'gastos'=>$gastos, 'totalins'=>$totalins]);
    }

    public function guardarinsumosf2(Request $request)
    {
        $actividad = $request->especifica_id_actividad_proyecto;
        $inversion = $request->especifica_id_actividad_actividad;
        //dd($actividad);
        $especifica = new PoiActividadEspecifica();
        $especifica->especifica_id_actividad_proyecto = $request->especifica_id_actividad_proyecto;
        $especifica->especifica_id_actividad_actividad = $request->especifica_id_actividad_actividad;
        $especifica->especifica_fuente_financiamiento = $request->especifica_fuente_financiamiento;
        $especifica->especifica_clasificador_gastos = $request->especifica_clasificador_gastos;
        $especifica->especifica_unidad_medida = mb_strtoupper($request->especifica_unidad_medida);
        $especifica->especifica_cantidad = $request->especifica_cantidad;
        //$especifica->especifica_costo_referencial = $request->especifica_costo_referencial;
        $especifica->especifica_monto_total = $request->especifica_monto_total;
        $especifica->especifica_enero = $request->esp_enero;
        $especifica->especifica_febrero = $request->esp_febrero;
        $especifica->especifica_marzo = $request->esp_marzo;
        $especifica->especifica_abril = $request->esp_abril;
        $especifica->especifica_mayo = $request->esp_mayo;
        $especifica->especifica_junio = $request->esp_junio;
        $especifica->especifica_julio = $request->esp_julio;
        $especifica->especifica_agosto = $request->esp_agosto;
        $especifica->especifica_setiembre = $request->esp_setiembre;
        $especifica->especifica_octubre = $request->esp_octubre;
        $especifica->especifica_noviembre = $request->esp_noviembre;
        $especifica->especifica_diciembre = $request->esp_diciembre;
        $especifica->save();
        
        return redirect('poi/anteproyecto/insumosf2/'.$actividad.'/'.$inversion)->with('msg', 'El Insumo fue Creado Satisfactoriamente.');
    }
    
    public function editarinsumos(Request $request, $id)
    {
        $actividad = $request->especifica_id_actividad_proyecto_edit;
        $inversion = $request->especifica_id_actividad_actividad_edit;
        
        $especifica = PoiActividadEspecifica::find($id);
        $especifica->especifica_id_actividad_proyecto = $request->especifica_id_actividad_proyecto_edit;
        $especifica->especifica_id_actividad_actividad = $request->especifica_id_actividad_actividad_edit;
        $especifica->especifica_fuente_financiamiento = $request->especifica_fuente_financiamiento_edit;
        $especifica->especifica_clasificador_gastos = $request->especifica_clasificador_gastos_edit;
        $especifica->especifica_unidad_medida = mb_strtoupper($request->especifica_unidad_medida_edit);
        $especifica->especifica_cantidad = $request->especifica_cantidad_edit;
        //$especifica->especifica_costo_referencial = $request->especifica_costo_referencial_edit;
        $especifica->especifica_monto_total = $request->especifica_monto_total_edit;
        $especifica->especifica_enero = $request->edit_enero;
        $especifica->especifica_febrero = $request->edit_febrero;
        $especifica->especifica_marzo = $request->edit_marzo;
        $especifica->especifica_abril = $request->edit_abril;
        $especifica->especifica_mayo = $request->edit_mayo;
        $especifica->especifica_junio = $request->edit_junio;
        $especifica->especifica_julio = $request->edit_julio;
        $especifica->especifica_agosto = $request->edit_agosto;
        $especifica->especifica_setiembre = $request->edit_setiembre;
        $especifica->especifica_octubre = $request->edit_octubre;
        $especifica->especifica_noviembre = $request->edit_noviembre;
        $especifica->especifica_diciembre = $request->edit_diciembre;
        $especifica->save();
        
        return redirect('poi/anteproyecto/insumosf2/'.$actividad.'/'.$inversion)->with('msg', 'El Insumo fue Editado Satisfactoriamente.');
    }
    
    public function deleteinsumos($act, $inv, $id)
    {     
        $especifica = PoiActividadEspecifica::find($id);
        $especifica->delete();
        
        return redirect('poi/anteproyecto/insumosf2/'.$act.'/'.$inv)->with('msg', 'El Insumo fue Eliminado de la Tabla.');
    }
    
    public function imprimirf2($id)
    {
        $mision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as mision')->where('plan_det_id', '=', 1)->first();
        
        $vision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as vision')->where('plan_det_id', '=', 2)->first();
        
        $actividades=DB::table('poi_actividad_proyecto AS act')
            ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
            ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
            ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
            ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.idactividad_proyecto AS actid', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_pdrc_oet_meta1 AS meta_oet_1', 'act.act_proy_pdrc_oet_meta2 AS meta_oet_2', 'act.act_proy_pdrc_aet_meta1 AS meta_aet_1', 'act.act_proy_pdrc_aet_meta2 AS meta_aet_2', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
            ->where('act.idactividad_proyecto', '=', $id)
            ->first();
        
        $inversiones = DB::table('poi_actividad_actividad AS aa')
            ->leftJoin('poi_actividad_especifica AS ae', 'aa.actividad_id', '=', 'ae.especifica_id_actividad_actividad')
            ->select('aa.actividad_id AS id', 'aa.actividad_numero AS numero', 'aa.actividad_denominacion AS denominacion', 'aa.actividad_indicador AS indicador', 'aa.actividad_unidad_medida AS um', 'aa.actividad_descripcion AS descripcion', 'aa.actividad_tareas_operativas AS tareas', 'aa.actividad_beneficiarios AS beneficiarios', 'aa.actividad_localizacion AS localizacion', 'aa.actividad_prioridad_oei AS prioridad', 'aa.actividad_fisica_enero AS enero', 'aa.actividad_fisica_febrero AS febrero', 'aa.actividad_fisica_marzo AS marzo', 'aa.actividad_fisica_abril AS abril', 'aa.actividad_fisica_mayo AS mayo', 'aa.actividad_fisica_junio AS junio', 'aa.actividad_fisica_julio AS julio', 'aa.actividad_fisica_agosto AS agosto', 'aa.actividad_fisica_setiembre AS setiembre', 'aa.actividad_fisica_octubre AS octubre', 'aa.actividad_fisica_noviembre AS noviembre', 'aa.actividad_fisica_diciembre AS diciembre', 'aa.actividad_fisica_total AS total', 
                DB::raw('sum(ae.especifica_enero) AS esp_enero'),
                DB::raw('sum(ae.especifica_febrero) AS esp_febrero'),
                DB::raw('sum(ae.especifica_marzo) AS esp_marzo'),
                DB::raw('sum(ae.especifica_abril) AS esp_abril'),
                DB::raw('sum(ae.especifica_mayo) AS esp_mayo'),
                DB::raw('sum(ae.especifica_junio) AS esp_junio'),
                DB::raw('sum(ae.especifica_julio) AS esp_julio'),
                DB::raw('sum(ae.especifica_agosto) AS esp_agosto'),
                DB::raw('sum(ae.especifica_setiembre) AS esp_setiembre'),
                DB::raw('sum(ae.especifica_octubre) AS esp_octubre'),
                DB::raw('sum(ae.especifica_noviembre) AS esp_noviembre'),
                DB::raw('sum(ae.especifica_diciembre) AS esp_diciembre'),
                DB::raw('sum(ae.especifica_monto_total) AS esp_monto_total'),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 1 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff1'
                        ),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 2 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff2'
                        ),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 3 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff3'
                        ),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 4 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff4'
                        ),
                DB::raw(
                        '(SELECT
                            Sum(poi_actividad_especifica.especifica_monto_total)
                        FROM
                            poi_actividad_especifica
                        WHERE
                            poi_actividad_especifica.especifica_id_actividad_proyecto = '."'".$id."'".' AND
                            poi_actividad_especifica.especifica_fuente_financiamiento = 5 AND
                            poi_actividad_especifica.especifica_id_actividad_actividad = aa.actividad_id
                        GROUP BY
                            poi_actividad_especifica.especifica_fuente_financiamiento,
                            poi_actividad_especifica.especifica_id_actividad_actividad
                        ORDER BY
                            poi_actividad_especifica.especifica_id_actividad_actividad ASC) AS ff5'
                        )                    
                    )
            ->where('aa.idactividad_proyecto', '=', $id)
            ->orderBy('aa.actividad_numero', 'asc')
            ->groupBy('aa.actividad_id')
            ->get();
        $inversionrows=count($inversiones);   
        
        $ce=DB::table('poi_actividad_proyecto AS aproy')
            ->join('poi_plan_detalle AS pdet', 'aproy.act_proy_pdrc_ee', '=', 'pdet.plan_det_id')
            ->select('pdet.plan_det_codigo AS id', 'pdet.plan_det_descripcion AS descripcion')
            ->where('aproy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($ce))
            $ce=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        );
        
        $oet=DB::table('poi_actividad_proyecto AS proy')
            ->join('poi_plan_detalle AS det', 'proy.act_proy_pdrc_oet_meta1', '=', 'det.plan_det_id')
            ->select('det.plan_det_codigo AS id', 'det.plan_det_descripcion AS descripcion','det.plan_det_indicador AS indicador', 'det.plan_det_unidad_medida AS medida', 'det.plan_det_id AS meta1', 'det.plan_det_meta AS meta2')
            ->where('proy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($oet))
            $oet=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $aet=DB::table('poi_actividad_proyecto AS pro')
            ->join('poi_plan_detalle AS de', 'pro.act_proy_pdrc_aet_meta1', '=', 'de.plan_det_id')
            ->select('de.plan_det_codigo AS id', 'de.plan_det_descripcion AS descripcion', 'de.plan_det_indicador AS indicador', 'de.plan_det_unidad_medida AS medida', 'de.plan_det_id AS meta1', 'de.plan_det_meta AS meta2')
            ->where('pro.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($aet))
            $aet=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $oei=DB::table('poi_actividad_proyecto AS proy')
            ->join('poi_plan_detalle AS det', 'proy.act_proy_objetivo_id_meta', '=', 'det.plan_det_id')
            ->select('det.plan_det_codigo AS id', 'det.plan_det_descripcion AS descripcion','det.plan_det_indicador AS indicador', 'det.plan_det_unidad_medida AS medida', 'det.plan_det_id AS meta1', 'det.plan_det_meta AS meta2')
            ->where('proy.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($oei))
            $oei=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
        
        $aei=DB::table('poi_actividad_proyecto AS pro')
            ->join('poi_plan_detalle AS de', 'pro.act_proy_accion_id_meta', '=', 'de.plan_det_id')
            ->select('de.plan_det_codigo AS id', 'de.plan_det_descripcion AS descripcion', 'de.plan_det_indicador AS indicador', 'de.plan_det_unidad_medida AS medida', 'de.plan_det_id AS meta1', 'de.plan_det_meta AS meta2')
            ->where('pro.idactividad_proyecto', '=', $id)
            ->first();
        
        if (is_null($aei))
            $aei=(object)array(
                        "id" => "",
                        "descripcion" => "",
                        "indicador" => "",
                        "medida" => "",
                        "meta1" => "",
                        "meta2" => "",
                        );
                                
        return view('poi.anteproyecto.formatof2.imprimirf2', ['actividades'=>$actividades, 'mision'=>$mision, 'vision'=>$vision, 'ce'=>$ce, 'oet'=>$oet, 'aet'=>$aet, 'oei'=>$oei, 'aei'=>$aei, 'id'=>$id, 'inversiones'=>$inversiones, 'inversionrows'=>$inversionrows]);
    }
    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
