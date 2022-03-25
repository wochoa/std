<?php

namespace App\Http\Controllers\Poi;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class PoiActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		
		//consulta
		/*
		SELECT
					ap.idactividad_proyecto,
					ap.act_proy_denominacion,
					ap.act_proy_indicador,
					ap.act_proy_um,
					ap.act_proy_fuente_finan,
					ap.act_proy_unidad_organica,
					ap.act_proy_unid_ejecutora,
					ap.act_proy_funcion,
					ap.act_proy_div_funcional,
					ap.act_proy_grupo_funcional,
					ap.act_proy_prog_pres,
					ap.act_proy_prod_proy,
					ap.act_proy_actividad,
					ap.act_proy_finalidad,
					ap.act_proy_pdrc_ee,
					ap.act_proy_pdrc_oer,
					ap.act_proy_pdrc_oe,
					ap.act_proy_pdrc_otros,
					ap.act_proy_pei_d,
					ap.act_proy_pei_oeg,
					ap.act_proy_pei_oe,
					ap.act_proy_otros,
					ap.act_proy_descripcion,
					ap.act_proy_local_benef,
					ap.act_proy_est_operativa,
					ap.poi_codigo,
					ap.act_proy_unidad_organica,
					ap.act_proy_estado,
					ap.act_proy_cantidad,
					ap.act_proy_prioridad,
					(SELECT
						count(tar.id_tarea) 
						FROM
						poi_proy_tarea AS tar
						WHERE
						tar.poi_actividad_proyecto_idactividad_proyecto = ap.idactividad_proyecto AND
						tar.tar_estado <> 0
					) AS nrotareas,
					(SELECT
						count( distinct tar.id_tarea)
						FROM
						poi_proy_tarea AS tar
						INNER JOIN poi_proy_insumo ON poi_proy_insumo.id_tarea = tar.id_tarea
						WHERE
						tar.poi_actividad_proyecto_idactividad_proyecto = ap.idactividad_proyecto AND
						tar.tar_estado <> 0 AND
						poi_proy_insumo.ins_estado <> 0
						GROUP BY
						tar.poi_actividad_proyecto_idactividad_proyecto

					) AS nrotareasins,
					(SELECT
							IFNULL(
							SUM(
							(IFNULL(pdpp.detprod_ene,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_feb,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_mar,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_abr,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_may,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_jun,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_jul,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_ago,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_set,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_oct,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_nov,0)* IFNULL(pdpp.precio,1)+
							IFNULL(pdpp.detprod_dic,0)* IFNULL(pdpp.precio,1) ) ), 0)
							FROM
							poi_fase2_pres_ini_tarea AS pf2pit
							INNER JOIN poi_detalle_producto_pac AS pdpp ON pdpp.id_pres_ini_tar = pf2pit.id_pres_ini_tar
							INNER JOIN poi_proy_tarea AS ppt ON pf2pit.id_tarea = ppt.id_tarea
							WHERE
							pdpp.detprod_estado = 1 AND
							pf2pit.tar_pres_ini_estado = 1 AND
							ppt.tar_estado = 1 AND
							ppt.poi_actividad_proyecto_idactividad_proyecto = ap.idactividad_proyecto
							GROUP BY
							ppt.poi_actividad_proyecto_idactividad_proyecto
					) AS ppto
					FROM
					poi_proy_actividad_proyecto AS ap	
					
					WHERE
					ap.poi_codigo = ".$poi_codigo)." AND ap.act_proy_estado<>0
		*/
		//retorno
		$actividades = DB::table('poi_proy_actividad_proyecto')
			->where('poi_codigo','=',40)
			->orderBy('act_proy_orden_personalizado','ASC')
			->orderBy('idactividad_proyecto','ASC')
			->get();
		return view('poi.poiActividad',["actividades"=>$actividades]);
    }
	
	public function show($id)
    {
        return "hola".$id;
    }

}
