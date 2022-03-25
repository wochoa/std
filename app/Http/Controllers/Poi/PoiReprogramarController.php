<?php

namespace App\Http\Controllers\Poi;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class PoiReprogramarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	  public function index( $proy, $nro_mod, $est_func_prog, $clas )
    {
	}
    public function indice( $proy, $nro_mod, $est_func_prog, $clas )
    {
        /*$reprogramacion =\DB::table('poi_reprogramacion_tarea_esp')
			->where('rep_ap_numero','=',$nro_mod)
			->where('act_proy','=',$proy)		
			->get(); */
		$reprogramacion =\DB::table('poi_propuesta_modificar')
			->select(DB::raw('
								ppm_id,
								est_func_prog_origen,
								(SELECT
									ofi.ofi_nombre
									FROM
									oficina AS ofi
									INNER JOIN poi_proy_poi AS ppp ON ppp.oficina = ofi.ofi_codigo
									INNER JOIN poi_proy_actividad_proyecto AS ppap ON ppap.poi_codigo = ppp.poi_codigo
									WHERE
									ppap.idactividad_proyecto = actividad_proyecto
								) AS unidad_origen,
								(SELECT
									CONCAT(
									est_func_pres_codigo_presupuestal,".",
									est_func_pres_producto_proyecto,".",
									est_func_pres_actividad_obra,".",
									est_func_pres_funcion,".",
									est_func_pres_division_funcional,".",
									est_func_pres_grupo_funcional,".",
									est_func_pres_finalidad,".",
									est_func_meta)
									FROM
									poi_estructura_funcional_presupuestal
									WHERE
									id_est_func_pres = est_func_prog_origen 
								) AS cadena_pres_origen,
								(SELECT act_proy_denominacion FROM poi_proy_actividad_proyecto WHERE idactividad_proyecto=actividad_proyecto) AS act_proy_origen_desc,
								clasificador,
								(SELECT CONCAT(cg_clasificador, cg_descripcion) FROM clasificador_gasto WHERE idclasificador_gasto = clasificador_id) AS cg_descripcion,
								ppm_monto_n,
								actividad_proyecto_destino,
								(SELECT
									ofi.ofi_nombre
									FROM
									oficina AS ofi
									INNER JOIN poi_proy_poi AS ppp ON ppp.oficina = ofi.ofi_codigo
									INNER JOIN poi_proy_actividad_proyecto AS ppap ON ppap.poi_codigo = ppp.poi_codigo
									WHERE
									ppap.idactividad_proyecto = actividad_proyecto_destino
								) AS unidad_destino,
								(SELECT act_proy_denominacion FROM poi_proy_actividad_proyecto WHERE idactividad_proyecto=actividad_proyecto_destino) AS act_proy_dest_desc,
								est_fun_prog_dest,
								(SELECT
									CONCAT(
									est_func_pres_codigo_presupuestal,".",
									est_func_pres_producto_proyecto,".",
									est_func_pres_actividad_obra,".",
									est_func_pres_funcion,".",
									est_func_pres_division_funcional,".",
									est_func_pres_grupo_funcional,".",
									est_func_pres_finalidad,".",
									est_func_meta)
									FROM
									poi_estructura_funcional_presupuestal
									WHERE
									id_est_func_pres = est_fun_prog_dest 
								) AS cadena_pres,
								clasificador_destino,
								(SELECT CONCAT(cg_clasificador, cg_descripcion) FROM clasificador_gasto WHERE idclasificador_gasto = clasificador_id_destino) AS cg_descripcion_destino,
								ppm_tipo_modificacion,
								ppm_fuente_financiamiento_origen AS ff,
								ppm_aprobacion_sectorista,
								IF (poi_propuesta_modificar.ppm_aprobacion_sectorista = 1,"Aprobado","Sin aprobar") AS estado_aprobacion_sectorista'))
			->where('actividad_proyecto','=',$proy)
			->where('ppm_numero','=',$nro_mod)
			->where('est_func_prog_origen','=',$est_func_prog)
			->where('clasificador_id','=',$clas)
			->get(); 
		$reprogramacion_habilitante =\DB::table('poi_propuesta_modificar')
			->select(DB::raw('
								ppm_id,
								est_func_prog_origen,
								(SELECT
									ofi.ofi_nombre
									FROM
									oficina AS ofi
									INNER JOIN poi_proy_poi AS ppp ON ppp.oficina = ofi.ofi_codigo
									INNER JOIN poi_proy_actividad_proyecto AS ppap ON ppap.poi_codigo = ppp.poi_codigo
									WHERE
									ppap.idactividad_proyecto = actividad_proyecto
								) AS unidad_origen,
								(SELECT
									CONCAT(
									est_func_pres_codigo_presupuestal,".",
									est_func_pres_producto_proyecto,".",
									est_func_pres_actividad_obra,".",
									est_func_pres_funcion,".",
									est_func_pres_division_funcional,".",
									est_func_pres_grupo_funcional,".",
									est_func_pres_finalidad,".",
									est_func_meta)
									FROM
									poi_estructura_funcional_presupuestal
									WHERE
									id_est_func_pres = est_func_prog_origen 
								) AS cadena_pres_origen,
								(SELECT act_proy_denominacion FROM poi_proy_actividad_proyecto WHERE idactividad_proyecto=actividad_proyecto) AS act_proy_origen_desc,
								clasificador,
								(SELECT CONCAT(cg_clasificador, cg_descripcion) FROM clasificador_gasto WHERE idclasificador_gasto = clasificador_id) AS cg_descripcion,
								ppm_monto_p,
								actividad_proyecto_destino,
								(SELECT
									ofi.ofi_nombre
									FROM
									oficina AS ofi
									INNER JOIN poi_proy_poi AS ppp ON ppp.oficina = ofi.ofi_codigo
									INNER JOIN poi_proy_actividad_proyecto AS ppap ON ppap.poi_codigo = ppp.poi_codigo
									WHERE
									ppap.idactividad_proyecto = actividad_proyecto_destino
								) AS unidad_destino,
								(SELECT act_proy_denominacion FROM poi_proy_actividad_proyecto WHERE idactividad_proyecto=actividad_proyecto_destino) AS act_proy_desc,
								est_fun_prog_dest,
								(SELECT
									CONCAT(
									est_func_pres_codigo_presupuestal,".",
									est_func_pres_producto_proyecto,".",
									est_func_pres_actividad_obra,".",
									est_func_pres_funcion,".",
									est_func_pres_division_funcional,".",
									est_func_pres_grupo_funcional,".",
									est_func_pres_finalidad,".",
									est_func_meta)
									FROM
									poi_estructura_funcional_presupuestal
									WHERE
									id_est_func_pres = est_fun_prog_dest 
								) AS cadena_pres,
								clasificador,
								(SELECT CONCAT(cg_clasificador, cg_descripcion) FROM clasificador_gasto WHERE idclasificador_gasto = clasificador_id_destino) AS cg_descripcion_destino,
								ppm_tipo_modificacion,
								ppm_fuente_financiamiento_destino AS ff,
								ppm_aprobacion_sectorista,
								IF (poi_propuesta_modificar.ppm_aprobacion_sectorista = 1,"Aprobado","Sin aprobar") AS estado_aprobacion_sectorista'))
			->where('actividad_proyecto_destino','=',$proy)
			->where('ppm_numero','=',$nro_mod)
			->where('est_fun_prog_dest','=',$est_func_prog)
			->where('clasificador_id_destino','=',$clas)
			->get(); 
        //dd($reprogramacion);
		return view('poi.poiReprogramacion',["reprogramacion"=>$reprogramacion, "reprogramacion_habilitante"=>$reprogramacion_habilitante]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
		$dependencias=\DB::table('poi_propuesta_modificar')->where('ppm_id',$id)->delete();
        echo "<script>window.history.back(-1)</script>";
    }
}
