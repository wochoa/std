<?php

namespace App\_clases\procesoseleccion;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * App\_clases\procesoseleccion\Puesto
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\procesoseleccion\Puesto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\procesoseleccion\Puesto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\procesoseleccion\Puesto query()
 * @mixin \Eloquent
 */
class Puesto extends Model
{
   protected $table='cas_puesto';

    protected $primaryKey='id_cas_puesto';

    public $timestamps=false;


    protected $fillable =[
    	'id_cas_puesto',
		'cas_pue_oficina',
		'cas_pue_puesto',
		'cas_pue_remuneracion',
		'cas_pue_tipo_recurso',
		'cas_pue_cantidad_plazas',
		'cas_pue_proceso_seleccion',
		'cas_pue_orden_oficina_convocatoriaa'
    ];

    protected $guarded =[

    ];
	
	public static function existe( $campo, $valor ){
		$query_cantidad = DB::table('cas_puesto')
			 ->select(DB::raw('COUNT(id_cas_puesto) AS cantidad') )
             ->where($campo,$valor)
			 ->first();
		
		return ( $query_cantidad->cantidad > 0 ) ? true : false ;
	}
	
	public static function obtener_id( $campo, $valor ){
		$query_id = DB::table('cas_puesto')
			 ->select('id_cas_puesto as id')
             ->where($campo,$valor)
			 ->first();
		
		return $query_id->id;
	}
	
	public static function existe_varias_condiciones( $condiciones ){
		$query_cantidad = DB::table('cas_puesto')
			 ->select(DB::raw('COUNT(id_cas_puesto) AS cantidad') )
             ->where($condiciones)
			 ->first();
		
		return ( $query_cantidad->cantidad > 0 ) ? true : false ;
	}
	
	public static function obtener_id_varias_condiciones( $condiciones ){
		$query_id = DB::table('cas_puesto')
			 ->select('id_cas_puesto as id')
             ->where($condiciones)
			 ->first();
		
		return $query_id->id;
	}

}

