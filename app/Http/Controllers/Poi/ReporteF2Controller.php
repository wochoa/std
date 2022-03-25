<?php

namespace App\Http\Controllers\Poi;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\_clases\poi\PlanDetalle;
use App\_clases\siaf\SiafMeta;
use Illuminate\Support\Facades\DB;

class ReporteF2Controller extends Controller
{
    public function inicio($poi, $uniorg, $anio)
    {
        $anio_eje=$anio-1;
        
        $mision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as mision')->where('plan_det_id', '=', 1)->first();
        
        $vision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as vision')->where('plan_det_id', '=', 2)->first();
            
        $unidadejecutoras = DB::table('poi AS p')
            ->join('oficina AS o', 'p.oficina', '=', 'o.ofi_codigo')
            ->join('unidad_ejecutora AS ue', 'o.unidad_ejecutora_ue_codigo', '=', 'ue.ue_codigo')
            ->select('ue.ue_codigo AS codunieje', 'o.ofi_nombre AS uniorganica', 'ue.ue_descripcion AS nombreejecutora', 'p.poi_anio AS anio1')
            ->where('p.poi_codigo', '=', $poi)            
            ->first();
        
        //----------------------------------ACTIVIDADES FORMTO F1------------------------------------------
        $unidadorganicas = DB::table('unidad_ejecutora AS uni')
            ->join('oficina AS ofi', 'uni.ue_codigo', '=', 'ofi.unidad_ejecutora_ue_codigo')            
            ->join('poi', 'ofi.ofi_codigo', '=', 'poi.oficina')
            ->join('poi_actividad_proyecto AS actpro', 'poi.poi_codigo', '=', 'actpro.poi_codigo')
            ->selectRaw('ofi.ofi_codigo AS numorden, ofi.ofi_nombre AS nombreunidad, (SELECT
                count(*)
                FROM
                oficina
                INNER JOIN poi ON poi.oficina = oficina.ofi_codigo
                INNER JOIN poi_actividad_proyecto ON poi_actividad_proyecto.poi_codigo = poi.poi_codigo
                INNER JOIN unidad_ejecutora ON oficina.unidad_ejecutora_ue_codigo = unidad_ejecutora.ue_codigo
                WHERE
                unidad_ejecutora.ue_codigo = '."'".$uniorg."'".' AND
                poi.poi_anio = 2017 AND
                oficina.ofi_codigo = ofi.ofi_codigo
                GROUP BY
                oficina.ofi_codigo) AS conteo')
            ->where('uni.ue_codigo', '=', $uniorg)                      
            ->where('poi.poi_anio', '=', $anio)
            ->orderBy('ofi.ofi_codigo', 'asc')
            ->groupBy('ofi.ofi_codigo')
            ->get();
        
        $organicas = DB::table('unidad_ejecutora AS unie')
            ->join('oficina AS of', 'unie.ue_codigo', '=', 'of.unidad_ejecutora_ue_codigo')
            ->join('poi', 'of.ofi_codigo', '=', 'poi.oficina')
            ->join('poi_actividad_proyecto AS actp', 'poi.poi_codigo', '=', 'actp.poi_codigo')
            ->select('unie.ue_codigo AS coduni', 'unie.ue_descripcion AS nombreeje', 'unie.ue_anio AS aniou', 'of.ofi_codigo AS orden', 'of.ofi_nombre AS nombreuni', 'actp.idactividad_proyecto AS codigoact', 'actp.act_proy_denominacion AS nombreact', 'actp.act_proy_indicador AS nombreind', 'actp.act_proy_um AS nombreum')
            ->where('unie.ue_codigo', '=', $uniorg)            
            ->where('poi.poi_anio', '=', $anio)
            ->orderBy('of.ofi_codigo', 'asc')
            ->get();
        //-----------------------------FIN ACTIVIDADES FORMTO F1------------------------------------------
        
        $pois = DB::table('unidad_ejecutora AS ue')
            ->join('siaf_meta AS sm', 'ue.ue_codigo_nacional', '=', 'sm.SEC_EJEC')
            ->select('sm.FUNCION as funcion', 'sm.PROGRAMA as division', 'sm.SUB_PROGRA as grupo', 'sm.PROGRAMA_P as categoria', 'sm.ACT_PROY as producto', 'sm.COMPONENTE as obra', 'sm.FINALIDAD as finalidad', 'sm.SEC_FUNC as meta')
            ->where('ue.ue_codigo', '=', $uniorg)
            ->where('sm.ANO_EJE', '=', $anio_eje)
            ->where('sm.SEC_FUNC', '=', 97)
            ->get();              
        
        $tareas = DB::table('poi')
            ->join('poi_actividad_proyecto as pa', 'poi.poi_codigo', '=', 'pa.poi_codigo')
            ->join('poi_proy_tarea as pt', 'pa.idactividad_proyecto', '=', 'pt.poi_actividad_proyecto_idactividad_proyecto')
            ->selectRaw('pa.idactividad_proyecto as idact, pa.act_proy_denominacion as nomact, pa.act_proy_indicador as indact, pa.act_proy_um as medact, pa.act_proy_prog_pres as catact, pa.act_proy_fuente_finan1 as fueact1, pa.act_proy_fuente_finan2 as fueact2, pa.act_proy_fuente_finan3 as fueact3, pa.act_proy_fuente_finan4 as fueact4, pa.act_proy_fuente_finan5 as fueact5, (SELECT
			count(*)
                FROM
                    poi
                INNER JOIN poi_actividad_proyecto ON poi_actividad_proyecto.poi_codigo = poi.poi_codigo
                INNER JOIN poi_proy_tarea ON poi_actividad_proyecto.idactividad_proyecto = poi_proy_tarea.poi_actividad_proyecto_idactividad_proyecto
                WHERE
                    poi_actividad_proyecto.idactividad_proyecto = pa.idactividad_proyecto
                GROUP BY
                    poi_actividad_proyecto.idactividad_proyecto
                ORDER BY
			poi_actividad_proyecto.idactividad_proyecto ASC) AS tareacont')
            ->where('poi.poi_codigo', '=', $poi)
            ->orderBy('pt.poi_actividad_proyecto_idactividad_proyecto', 'asc')
            ->groupBy('pa.idactividad_proyecto')
            ->get();
       //dd($tareas);
        
		return view('poi.reportef2', [ 'pois'=>$pois, 'unidadejecutoras'=>$unidadejecutoras, 'organicas'=>$organicas, 'unidadorganicas'=>$unidadorganicas, 'mision'=>$mision, 'vision'=>$vision, 'tareas'=>$tareas]);
    }
    
    public function index()
    {
        $mision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as mision')->where('plan_det_id', '=', 1)->first();
        
        $vision = DB::table('poi_plan_detalle')->select('plan_det_descripcion as vision')->where('plan_det_id', '=', 2)->first();
        
        $prog_p = DB::table('siaf_programa_ppto_nombre')
			 ->where( 'ANO_EJE','=','2017' )//Año de ejecución
			 ->whereNotIn( 'PROGRAMA_P',[9001, 9002] )//C.E.
			 ->select( 'PROGRAMA_P AS id', 'NOMBRE AS nombre')
             ->orderBy('PROGRAMA_P','ASC')
			 ->get();
        
        $meta = DB::table('siaf_meta')
            ->select('ID', 'SEC_FUNC as numero')
            ->where('ANO_EJE', 2017)
            ->distinct()
            ->get();
        
        $ces = DB::table('poi_plan_detalle')
			 ->where( 'plan_id','=','1' )//PDRC
			 ->where( 'plan_det_categoria','=','EE' )//C.E.
			 ->select( 'plan_det_id as id', 'plan_det_codigo as codigo', 'plan_det_descripcion as nombre' )
             ->orderBy('plan_det_codigo','ASC')
			 ->get();
        
        return view('poi.formatof2.anteproyecto', ['prog_p'=>$prog_p, 'meta'=>$meta, 'mision'=>$mision, 'vision'=>$vision, 'ces'=>$ces]);
    }
    
    public function metaID(Request $request, $id)
    {
        if($request->ajax()){
				$meta = SiafMeta::obtener_metas_por_id($id);
				return response()->json($meta);
		}
    }
    
    public function obtener_oets(Request $request, $tipo, $ce){
		
		if($request->ajax()){
			switch($tipo){
			case 1://obtiene todos los oets
				$oets = PlanDetalle::obtener_oets($ce);
				return response()->json($oets);
				break;
			case 2://obtiene los oets de acuerdo al indicador seleccionado
				$oets = PlanDetalle::obtener_oet_por_indicador($ce);
				return response()->json($oets);
				break;
			case 3://obtiene todos los aets
				$aets = PlanDetalle::obtener_aets($ce);
				return response()->json($aets);
				break;
			}
		}
	}
    
    public function create($usuario, $unidad )
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        
    }
}
