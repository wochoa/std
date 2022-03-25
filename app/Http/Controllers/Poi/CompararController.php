<?php

namespace App\Http\Controllers\Poi;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use DB;

class CompararController extends Controller
{
    public function index(Request $request)
    {
        /*$id=64;
        $clasificador=trim('2.1.1 1.1 2');*/
        
        if($request){ 
            
            $id= trim($request->get('ex_ofi_codigo')); //Oficina  
            $clas= trim($request->get('cg_clasificador')); //Clasificador  
            
            
            $oficina=DB::table('poi_nuevo_excel as poi')
                ->join('unidad_ejecutora as ue', 'poi.nuevo_ue_codigo_nacional', '=', 'ue.ue_codigo_nacional')
                ->select('poi.nuevo_ue_codigo_nacional as id', 'ue.ue_descripcion as nombre')
                ->groupBy('poi.nuevo_ue_codigo_nacional')
                ->orderBy('poi.nuevo_ue_codigo_nacional', 'asc')
                ->get(); 
            
            $poi=DB::table('poi_nuevo_excel as p')
                ->join('unidad_ejecutora as ue', 'p.nuevo_ue_codigo_nacional', '=', 'ue.ue_codigo_nacional')
                ->select('p.nuevo_ue_codigo_nacional as codOfi', 'ue.ue_descripcion as nomOfi')
                ->where('p.nuevo_ue_codigo_nacional', $id)
                ->orderBy('ue.ue_descripcion', 'asc')
                ->groupBy('ue.ue_descripcion')
                ->get();     

            $total=DB::table('poi_nuevo_excel as poi')
                ->join('poi_pia_excel as pia', function ($join) {
                    $join->on('poi.nuevo_ue_codigo_nacional', '=', 'pia.pia_codigo_ejecutora')
                        ->on('poi.nuevo_cg_clasificador', '=', 'pia.pia_clasificador')
                        ->on('poi.nuevo_est_func_pres_codigo_presupuestal', '=', 'pia.pia_cod_programa_presupuestal')
                        ->on('poi.nuevo_est_func_pres_producto_proyecto', '=', 'pia.pia_cod_producto_presupestal')
                        ->on('poi.nuevo_est_func_pres_actividad_obra', '=', 'pia.pia_cod_actividad_obra_presupuestal')
                        ->on('poi.nuevo_est_func_pres_funcion', '=', 'pia.pia_cod_funcion_presupuestal')
                        ->on('poi.nuevo_est_func_pres_division_funcional', '=', 'pia.pia_cod_div_funcional')
                        ->on('poi.nuevo_est_func_pres_grupo_funcional', '=', 'pia.pia_cod_grupo_funcional')
                        ->on('poi.nuevo_est_func_pres_finalidad', '=', 'pia.pia_cod_finalidad')
                        ->on('poi.nuevo_est_func_meta', '=', 'pia.pia_cod_unidad_medida')               
                        ->on('poi.nuevo_poi_pres_fuente_financiamiento', '=', 'pia.pia_fuente_financamiento'); })               
                ->select('poi.nuevo_cg_clasificador AS clas', 'poi.nuevo_est_func_pres_codigo_presupuestal AS cod', 'poi.nuevo_est_func_pres_producto_proyecto AS prod', 'poi.nuevo_est_func_pres_actividad_obra AS act', 'poi.nuevo_est_func_pres_funcion AS func', 'poi.nuevo_est_func_pres_division_funcional AS div', 'poi.nuevo_est_func_pres_grupo_funcional AS grup', 'poi.nuevo_est_func_pres_finalidad AS final', 'poi.nuevo_est_func_meta AS met', 'poi.nuevo_poi_pres_fuente_financiamiento as fuen', DB::raw('sum(poi.nuevo_pres_ini_monto) AS totalpoi'), DB::raw('sum(pia.pia_monto_total_tarea) AS totalpia'), DB::raw('sum(pia.pia_monto_redondeo_mas) AS totalpiamas'), DB::raw('sum(pia.pia_monto_redondeo_menos) AS totalpiamenos'))
                        
                ->where('poi.nuevo_cg_clasificador', 'LIKE','%'.$clas.'%')
                ->where('pia.pia_clasificador', 'LIKE','%'.$clas.'%')
                ->where('poi.nuevo_ue_codigo_nacional', $id)
                ->where('pia.pia_codigo_ejecutora', $id)
                ->groupBy('pia.pia_cod_programa_presupuestal')
                ->groupBy('pia.pia_cod_producto_presupestal')
                ->groupBy('pia.pia_cod_actividad_obra_presupuestal')
                ->groupBy('pia.pia_cod_funcion_presupuestal')
                ->groupBy('pia.pia_cod_div_funcional')
                ->groupBy('pia.pia_cod_grupo_funcional')
                ->groupBy('pia.pia_cod_finalidad')
                ->groupBy('pia.pia_cod_unidad_medida')
                ->groupBy('pia.pia_fuente_financamiento')
                ->get();
            //dd($total);
            return view('poi.comparar', ['poi'=>$poi, 'oficina'=>$oficina, 'total'=>$total]);
        }
    }        
    
    public function clasificador($id)
    {
        $clasificador=DB::table('poi_nuevo_excel')
            ->select('nuevo_cg_clasificador as id')
            ->where('nuevo_ue_codigo_nacional', '=', $id)
            ->orderBy('nuevo_cg_clasificador', 'asc')
            ->groupBy('nuevo_cg_clasificador')
            ->get();
        return response()->json(array('clasificador'=> $clasificador), 200);
    }
      
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
