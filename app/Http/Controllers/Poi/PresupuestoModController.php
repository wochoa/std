<?php

namespace App\Http\Controllers\Poi;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use DB;

class PresupuestoModController extends Controller
{
    public function index(Request $request)
    {
		return view('welcome');
    }
    
    public function modificar()
    {
        
    }
    
    public function create($usuario, $unidad )
    {
        $periodo = DB::table('poi_periodo')
            ->select('poi_periodo_anio AS anio')
            ->where('poi_periodo_estado', '=', 1)
            ->first();
        
        $unidades = DB::table('unidad_ejecutora as unid')
            ->join('oficina as of', 'unid.ue_codigo', '=', 'of.unidad_ejecutora_ue_codigo')
            ->join('usuario_oficina as uof', 'of.ofi_codigo', '=', 'uof.oficina')
            ->select('unid.ue_codigo as codigo', 'unid.ue_descripcion as nombre')
            ->where('uof.usuario', '=', $usuario)
            ->get();
        
        $pois = DB::table('poi')
            ->join('oficina as ofi', 'poi.oficina', '=', 'ofi.ofi_codigo')
            ->leftJoin('usuario_oficina as usu', 'ofi.ofi_codigo', '=', 'usu.oficina')
            ->select('poi.poi_codigo as poi_codigo', 'ofi.ofi_codigo as ofi_codigo', 'ofi.ofi_nombre as ofi_nombre')
            ->where('poi.poi_anio', '=', $periodo->anio)
            ->where('usu.usuario', '=', $usuario)
            ->get();
        
        $estructuras = DB::table('poi_estructura_funcional_presupuestal as est')
            ->select('est.id_est_func_pres as codigo', 'est.est_func_pres_codigo_presupuestal as est1', 'est.est_func_pres_producto_proyecto as est2', 'est.est_func_pres_actividad_obra as est3', 'est.est_func_pres_funcion as est4', 'est.est_func_pres_division_funcional as est5', 'est.est_func_pres_grupo_funcional as est6', 'est.est_func_pres_finalidad as est7', 'est.est_func_meta as est8')
            ->get();
        
        $clasificador = DB::table('clasificador_gasto as clag')
            ->select('clag.idclasificador_gasto as codigo', 'clag.cg_clasificador as clasificador', 'clag.cg_descripcion as descripcion')
            ->get();
        
        return view('poi.PresupuestoMod', ['unidades'=>$unidades, 'pois'=>$pois, 'estructuras'=>$estructuras, 'clasificador'=>$clasificador, 'periodo'=>$periodo]);
    }

    public function store(Request $request)
    {
        /*$adm_horaingreso=$date->toDateTimeString();
        $created_at=$date->toDateTimeString();*/
        
        $unidad_ejecutora = $request->input('unidad_ejecutora');
        $poi = $request->input('poi');
        $estructura_funcional_prog_pres = $request->input('estructura_funcional_prog_pres');
        $clasificador_gasto = $request->input('clasificador_gasto');
        $pres_mod_monto = $request->input('pres_mod_monto');        
        //$meta_ant = $request->input('meta_ant');        
        $poi_pres_fuente_financiamiento = $request->input('poi_pres_fuente_financiamiento');
        //$pres_modificacion = $request->input('pres_modificacion');
        $pres_mod_anio = $request->input('pres_mod_anio');
        //$pres_mod_numero = $request->input('pres_mod_numero');
        
        
        $presupuestoMod=\DB::table('poi_presupuesto_modificado')
            ->insert(['unidad_ejecutora'=>$unidad_ejecutora, 'poi'=>$poi, 'estructura_funcional_prog_pres'=>$estructura_funcional_prog_pres, 'clasificador_gasto'=>$clasificador_gasto, 'pres_mod_monto'=>$pres_mod_monto, 'poi_pres_fuente_financiamiento'=>$poi_pres_fuente_financiamiento, 'pres_mod_anio'=>$pres_mod_anio]);
        
        return Redirect('poi/presupuestomod')->with('msg', 'LOS DATOS FUERON GUARDADOS SATISFACTORIAMENTE.');
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
