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

class FormatoF3Controller extends Controller
{
    public function verf3($act)
    {
        $actividades=DB::table('poi_actividad_proyecto AS act')
        ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
        ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
        ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
        ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
        ->where('act.idactividad_proyecto', '=', $act)
        ->first();
        
        
        $inversiones = DB::table('poi_actividad_actividad AS aa')
            ->leftJoin('poi_actividad_especifica AS ae', 'aa.actividad_id', '=', 'ae.especifica_id_actividad_actividad')
            ->select('aa.actividad_id AS id', 'aa.actividad_denominacion AS denominacion', 'aa.actividad_indicador AS indicador', 'aa.actividad_unidad_medida AS um', 'aa.actividad_fisica_total AS total', 
                DB::raw('sum(ae.especifica_cantidad) AS esp_cantidad'),
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
                DB::raw('count(ae.especifica_monto_total) AS con_ins_tar')
                    )
            ->where('aa.idactividad_proyecto', '=', $act)
            ->orderBy('aa.actividad_numero', 'asc')
            ->groupBy('aa.actividad_id')
            ->get();        
        $inversionrows=count($inversiones);
        
        $insumos=PoiActividadEspecifica::select('especifica_id_actividad_actividad AS idact', 'id_actividad_especifica AS id', 'especifica_fuente_financiamiento AS fuente', 'especifica_clasificador_gastos', 'especifica_unidad_medida AS um', 'especifica_cantidad AS cantidad', 'especifica_costo_referencial AS costo', 'especifica_monto_total AS monto', 'especifica_enero AS enero', 'especifica_febrero AS febrero', 'especifica_marzo AS marzo', 'especifica_abril AS abril', 'especifica_mayo AS mayo', 'especifica_junio AS junio', 'especifica_julio AS julio', 'especifica_agosto AS agosto', 'especifica_setiembre AS setiembre', 'especifica_octubre AS octubre', 'especifica_noviembre AS noviembre', 'especifica_diciembre AS diciembre')->where('especifica_id_actividad_proyecto', '=', $act)->orderBy('id_actividad_especifica')->get();
        //dd($insumos);
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
            ->where('especifica_id_actividad_proyecto', '=', $act)
            ->groupBy('especifica_id_actividad_proyecto')
            ->first();
                
        $actinsumos=PoiActividadEspecifica::select('especifica_id_actividad_actividad AS idact', 'id_actividad_especifica AS id', 'especifica_fuente_financiamiento AS act_fuente', 'especifica_clasificador_gastos', 'especifica_unidad_medida AS act_um', 'especifica_cantidad AS act_cantidad', 'especifica_monto_total AS act_monto', 'especifica_enero AS act_enero', 'especifica_febrero AS act_febrero', 'especifica_marzo AS act_marzo', 'especifica_abril AS act_abril', 'especifica_mayo AS act_mayo', 'especifica_junio AS act_junio', 'especifica_julio AS act_julio', 'especifica_agosto AS act_agosto', 'especifica_setiembre AS act_setiembre', 'especifica_octubre AS act_octubre', 'especifica_noviembre AS act_noviembre', 'especifica_diciembre AS act_diciembre')->where('especifica_id_actividad_proyecto', '=', $act)->orderBy('especifica_fuente_financiamiento')->get();
        $actinsrows=count($actinsumos);
        
        return view('poi.anteproyecto.formatof3.verf3', ['act'=>$act, 'inversiones'=>$inversiones, 'inversionrows'=>$inversionrows, 'actividades'=>$actividades, 'insumos'=>$insumos, 'insumorows'=>$insumorows, 'totalins'=>$totalins, 'actinsumos'=>$actinsumos, 'actinsrows'=>$actinsrows]);
    }
    
    public function imprimirf3($act)
    {
        $actividades=DB::table('poi_actividad_proyecto AS act')
        ->join('poi AS p', 'act.poi_codigo', '=', 'p.poi_codigo')
        ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
        ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
        ->select('ue.ue_codigo AS unieje', 'ue.ue_descripcion AS nomunieje', 'o.ofi_nombre AS nomofi', 'p.poi_anio as anio', 'act.act_proy_prog_pres AS categoria', 'act.act_proy_funcion AS funcion', 'act.act_proy_div_funcional AS division', 'act.act_proy_grupo_funcional AS grupo', 'act.act_proy_prod_proy AS producto', 'act.act_proy_actividad AS actividad', 'act.act_proy_finalidad AS finalidad', 'act.act_proy_unidad_organica AS uniresponsable', 'act.act_proy_id_siaf_meta AS siaf')
        ->where('act.idactividad_proyecto', '=', $act)
        ->first();
        
        
        $inversiones = DB::table('poi_actividad_actividad AS aa')
            ->leftJoin('poi_actividad_especifica AS ae', 'aa.actividad_id', '=', 'ae.especifica_id_actividad_actividad')
            ->select('aa.actividad_id AS id', 'aa.actividad_denominacion AS denominacion', 'aa.actividad_indicador AS indicador', 'aa.actividad_unidad_medida AS um', 'aa.actividad_fisica_total AS total', 
                DB::raw('sum(ae.especifica_cantidad) AS esp_cantidad'),
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
                DB::raw('count(ae.especifica_monto_total) AS con_ins_tar')
                    )
            ->where('aa.idactividad_proyecto', '=', $act)
            ->orderBy('aa.actividad_numero', 'asc')
            ->groupBy('aa.actividad_id')
            ->get();        
        $inversionrows=count($inversiones);
        
        $insumos=PoiActividadEspecifica::select('especifica_id_actividad_actividad AS idact', 'id_actividad_especifica AS id', 'especifica_fuente_financiamiento AS fuente', 'especifica_clasificador_gastos', 'especifica_unidad_medida AS um', 'especifica_cantidad AS cantidad', 'especifica_costo_referencial AS costo', 'especifica_monto_total AS monto', 'especifica_enero AS enero', 'especifica_febrero AS febrero', 'especifica_marzo AS marzo', 'especifica_abril AS abril', 'especifica_mayo AS mayo', 'especifica_junio AS junio', 'especifica_julio AS julio', 'especifica_agosto AS agosto', 'especifica_setiembre AS setiembre', 'especifica_octubre AS octubre', 'especifica_noviembre AS noviembre', 'especifica_diciembre AS diciembre')->where('especifica_id_actividad_proyecto', '=', $act)->orderBy('id_actividad_especifica')->get();
        //dd($insumos);
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
            ->where('especifica_id_actividad_proyecto', '=', $act)
            ->groupBy('especifica_id_actividad_proyecto')
            ->first();
                
        $actinsumos=PoiActividadEspecifica::select('especifica_id_actividad_actividad AS idact', 'id_actividad_especifica AS id', 'especifica_fuente_financiamiento AS act_fuente', 'especifica_clasificador_gastos', 'especifica_unidad_medida AS act_um', 'especifica_cantidad AS act_cantidad', 'especifica_monto_total AS act_monto', 'especifica_enero AS act_enero', 'especifica_febrero AS act_febrero', 'especifica_marzo AS act_marzo', 'especifica_abril AS act_abril', 'especifica_mayo AS act_mayo', 'especifica_junio AS act_junio', 'especifica_julio AS act_julio', 'especifica_agosto AS act_agosto', 'especifica_setiembre AS act_setiembre', 'especifica_octubre AS act_octubre', 'especifica_noviembre AS act_noviembre', 'especifica_diciembre AS act_diciembre')->where('especifica_id_actividad_proyecto', '=', $act)->orderBy('especifica_fuente_financiamiento')->get();
        $actinsrows=count($actinsumos);
        
        return view('poi.anteproyecto.formatof3.imprimirf3', ['act'=>$act, 'inversiones'=>$inversiones, 'inversionrows'=>$inversionrows, 'actividades'=>$actividades, 'insumos'=>$insumos, 'insumorows'=>$insumorows, 'totalins'=>$totalins, 'actinsumos'=>$actinsumos, 'actinsrows'=>$actinsrows]);
    }    
}
