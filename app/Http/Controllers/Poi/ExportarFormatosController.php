<?php

namespace App\Http\Controllers\Poi;

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
use DB;

class ExportarFormatosController extends Controller
{
    /*------------------------------------- EXPORTAR F3 -----------------------------------------------------------*/    
    public function exportarf3($act)
    {
        $actividad = DB::table('poi_actividad_proyecto AS ap')
            ->leftJoin('poi_actividad_especifica as aesp', 'ap.idactividad_proyecto', '=', 'aesp.especifica_id_actividad_proyecto')
            ->select('ap.act_proy_denominacion AS actividad', DB::raw('sum(aesp.especifica_monto_total) AS acttotal'), DB::raw('sum(aesp.especifica_enero) AS actenero'), DB::raw('sum(aesp.especifica_febrero) AS actfebrero'), DB::raw('sum(aesp.especifica_marzo) AS actmarzo'), DB::raw('sum(aesp.especifica_abril) AS actabril'), DB::raw('sum(aesp.especifica_mayo) AS actmayo'), DB::raw('sum(aesp.especifica_junio) AS actjunio'), DB::raw('sum(aesp.especifica_julio) AS actjulio'), DB::raw('sum(aesp.especifica_agosto) AS actagosto'), DB::raw('sum(aesp.especifica_setiembre) AS actsetiembre'), DB::raw('sum(aesp.especifica_octubre) AS actoctubre'), DB::raw('sum(aesp.especifica_noviembre) AS actnoviembre'), DB::raw('sum(aesp.especifica_diciembre) AS actdiciembre'), DB::raw('sum(aesp.especifica_enero+aesp.especifica_febrero+aesp.especifica_marzo) AS acttri1'), DB::raw('sum(aesp.especifica_abril+aesp.especifica_mayo+aesp.especifica_junio) AS acttri2'), DB::raw('sum(aesp.especifica_julio+aesp.especifica_agosto+aesp.especifica_setiembre) AS acttri3'), DB::raw('sum(aesp.especifica_octubre+aesp.especifica_noviembre+aesp.especifica_diciembre) AS acttri4'))
            ->groupBy('ap.idactividad_proyecto')
            ->where('ap.idactividad_proyecto', '=', $act)->first();
        
        $tareas = DB::table('poi_tarea AS t')
            ->leftJoin('poi_actividad_especifica AS ae', 't.id_tarea', '=', 'ae.especifica_id_tarea')
            ->select('id_tarea', 'tar_descripcion AS tarea', DB::raw('sum(ae.especifica_monto_total) AS tartotal'), DB::raw('sum(ae.especifica_enero) AS tarenero'), DB::raw('sum(ae.especifica_febrero) AS tarfebrero'), DB::raw('sum(ae.especifica_marzo) AS tarmarzo'), DB::raw('sum(ae.especifica_abril) AS tarabril'), DB::raw('sum(ae.especifica_mayo) AS tarmayo'), DB::raw('sum(ae.especifica_junio) AS tarjunio'), DB::raw('sum(ae.especifica_julio) AS tarjulio'), DB::raw('sum(ae.especifica_agosto) AS taragosto'), DB::raw('sum(ae.especifica_setiembre) AS tarsetiembre'), DB::raw('sum(ae.especifica_octubre) AS taroctubre'), DB::raw('sum(ae.especifica_noviembre) AS tarnoviembre'), DB::raw('sum(ae.especifica_diciembre) AS tardiciembre'), DB::raw('sum(ae.especifica_enero+ae.especifica_febrero+ae.especifica_marzo) AS tartri1'), DB::raw('sum(ae.especifica_abril+ae.especifica_mayo+ae.especifica_junio) AS tartri2'), DB::raw('sum(ae.especifica_julio+ae.especifica_agosto+ae.especifica_setiembre) AS tartri3'), DB::raw('sum(ae.especifica_octubre+ae.especifica_noviembre+ae.especifica_diciembre) AS tartri4'))
            ->where('poi_actividad_proyecto_idactividad_proyecto', '=', $act)
            ->orderBy('t.id_tarea', 'asc')
            ->groupBy('t.id_tarea')
            ->get();
        $tareasrow = count($tareas);
        
        $insumos = DB::table('poi_actividad_proyecto AS apr')
            ->leftJoin('poi_actividad_especifica as aes', 'apr.idactividad_proyecto', '=', 'aes.especifica_id_actividad_proyecto')
            ->join('clasificador_gasto AS cg', 'aes.especifica_clasificador_gastos', '=', 'cg.idclasificador_gasto')
            ->select('cg.cg_descripcion AS insumo', 'cg.cg_clasificador AS clasificador', 'aes.especifica_id_tarea AS id_tarea', 'aes.especifica_fuente_financiamiento AS fuente', 'aes.especifica_clasificador_gastos', 'aes.especifica_unidad_medida AS um', 'aes.especifica_cantidad AS cantidad', 'aes.especifica_costo_referencial AS costo', 'aes.especifica_monto_total AS monto', 'aes.especifica_enero AS enero', 'aes.especifica_febrero AS febrero', 'aes.especifica_marzo AS marzo', DB::raw('sum(aes.especifica_enero+aes.especifica_febrero+aes.especifica_marzo) AS tri1'), 'aes.especifica_abril AS abril', 'aes.especifica_mayo AS mayo', 'aes.especifica_junio AS junio', DB::raw('sum(aes.especifica_abril+aes.especifica_mayo+aes.especifica_junio) AS tri2'), 'aes.especifica_julio AS julio', 'aes.especifica_agosto AS agosto', 'aes.especifica_setiembre AS setiembre', DB::raw('sum(aes.especifica_julio+aes.especifica_agosto+aes.especifica_setiembre) AS tri3'), 'aes.especifica_octubre AS octubre', 'aes.especifica_noviembre AS noviembre', 'aes.especifica_diciembre AS diciembre', DB::raw('sum(aes.especifica_octubre+aes.especifica_noviembre+aes.especifica_diciembre) AS tri4'),
                    
                    DB::raw('(SELECT
                    count(*)
                    FROM
                    poi_actividad_proyecto
                    INNER JOIN poi_actividad_especifica ON poi_actividad_proyecto.idactividad_proyecto = poi_actividad_especifica.especifica_id_actividad_proyecto
                    WHERE
                    poi_actividad_especifica.especifica_id_tarea = aes.especifica_id_tarea ) AS con_ins')
                     
                    )
            ->where('apr.idactividad_proyecto', '=', $act)
            ->groupBy('aes.id_actividad_especifica')
            ->get();
        //dd($insumos);
        
        $clasificadores = DB::table('poi_actividad_especifica AS pae')
            ->join('clasificador_gasto AS cg', 'pae.especifica_clasificador_gastos', '=', 'cg.idclasificador_gasto')
            ->select('pae.especifica_clasificador_gastos', 'cg.cg_clasificador AS clasificador', 'cg.cg_descripcion AS nombreclasf', DB::raw('sum(pae.especifica_cantidad) AS clacantidad'), DB::raw('sum(pae.especifica_monto_total) AS clamonto'), DB::raw('sum(pae.especifica_enero) AS claenero'), DB::raw('sum(pae.especifica_febrero) AS clafebrero'), DB::raw('sum(pae.especifica_marzo) AS clamarzo'), DB::raw('sum(pae.especifica_abril) AS claabril'), DB::raw('sum(pae.especifica_mayo) AS clamayo'), DB::raw('sum(pae.especifica_junio) AS clajunio'), DB::raw('sum(pae.especifica_julio) AS clajulio'), DB::raw('sum(pae.especifica_agosto) AS claagosto'), DB::raw('sum(pae.especifica_setiembre) AS clasetiembre'), DB::raw('sum(pae.especifica_octubre) AS claoctubre'), DB::raw('sum(pae.especifica_noviembre) AS clanoviembre'), DB::raw('sum(pae.especifica_diciembre) AS cladiciembre'), DB::raw('sum(pae.especifica_enero+pae.especifica_febrero+pae.especifica_marzo) AS clatri1'), DB::raw('sum(pae.especifica_abril+pae.especifica_mayo+pae.especifica_junio) AS clatri2'), DB::raw('sum(pae.especifica_julio+pae.especifica_agosto+pae.especifica_setiembre) AS clatri3'), DB::raw('sum(pae.especifica_octubre+pae.especifica_noviembre+pae.especifica_diciembre) AS clatri4'))
            ->where('pae.especifica_id_actividad_proyecto', '=', $act)
            ->orderBy('pae.especifica_clasificador_gastos', 'asc')
            ->groupBy('pae.especifica_clasificador_gastos')
            ->get();
        $clasifrow = count($clasificadores);
        
        $clasiftotal = PoiActividadEspecifica::select(DB::raw('sum(especifica_monto_total) AS totalmonto'), DB::raw('sum(especifica_monto_total) AS totalmonto'), DB::raw('sum(especifica_enero) AS totalenero'), DB::raw('sum(especifica_febrero) AS totalfebrero'), DB::raw('sum(especifica_marzo) AS totalmarzo'), DB::raw('sum(especifica_abril) AS totalabril'), DB::raw('sum(especifica_mayo) AS totalmayo'), DB::raw('sum(especifica_junio) AS totaljunio'), DB::raw('sum(especifica_julio) AS totaljulio'), DB::raw('sum(especifica_agosto) AS totalagosto'), DB::raw('sum(especifica_setiembre) AS totalsetiembre'), DB::raw('sum(especifica_octubre) AS totaloctubre'), DB::raw('sum(especifica_noviembre) AS totalnoviembre'), DB::raw('sum(especifica_diciembre) AS totaldiciembre'), DB::raw('sum(especifica_enero+especifica_febrero+especifica_marzo) AS totaltri1'), DB::raw('sum(especifica_abril+especifica_mayo+especifica_junio) AS totaltri2'), DB::raw('sum(especifica_julio+especifica_agosto+especifica_setiembre) AS totaltri3'), DB::raw('sum(especifica_octubre+especifica_noviembre+especifica_diciembre) AS totaltri4'))
            ->where('especifica_id_actividad_proyecto', '=', $act)
            ->groupBy('especifica_id_actividad_proyecto')
            ->first();
        //dd($clasifrow);
                
        return view('poi.huamalies.exportarf3', ['act'=>$act, 'actividad'=>$actividad, 'tareas'=>$tareas, 'tareasrow'=>$tareasrow, 'insumos'=>$insumos, 'clasificadores'=>$clasificadores, 'clasifrow'=>$clasifrow, 'clasiftotal'=>$clasiftotal]);
    }
    
    public function index()
    {
        
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
