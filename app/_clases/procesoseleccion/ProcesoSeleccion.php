<?php

namespace App\_clases\procesoseleccion;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * App\_clases\procesoseleccion\ProcesoSeleccion
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\procesoseleccion\ProcesoSeleccion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\procesoseleccion\ProcesoSeleccion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\procesoseleccion\ProcesoSeleccion query()
 * @mixin \Eloquent
 */
class ProcesoSeleccion extends Model
{
   protected $table='cas_proceso_seleccion';

    protected $primaryKey='id_proc_sel_cas';

    public $timestamps=false;


    protected $fillable =[
    	'id_proc_sel_cas',
		'proc_sel_cas_descripcion',
		'proc_sel_cas_fecha_inicio',
		'proc_sel_cas_fecha_termino',
		'cas_proc_sel_fecha_fin_inscripcion',
		'cas_proc_sel_fecha_resultados',
		'cas_proc_sel_estado',
		'cas_proc_sel_nro_concurso',
		'cas_proc_sel_horainicio',
		'cas_proc_sel_horatermino_inscripcion',
		'cas_proc_sel_estado_calificacion_etapa1',
		'cas_proc_sel_estado_calificacion_etapa2'
    ];

    protected $guarded =[

    ];
	
	public static function existe( $campo, $valor ){
		$query_cantidad = DB::table('cas_proceso_seleccion')
			 ->select(DB::raw('COUNT(id_proc_sel_cas) AS cantidad') )
             ->where($campo,$valor)
			 ->first();
		
		return ( $query_cantidad->cantidad > 0 ) ? true : false ;
	}
	
	public static function obtener_id( $campo, $valor ){
		$query_id = DB::table('cas_proceso_seleccion')
			 ->select('id_proc_sel_cas as id')
             ->where($campo,$valor)
			 ->first();
		
		return $query_id->id;
	}

}

