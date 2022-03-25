<?php

namespace App\_clases\directorio;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * App\_clases\directorio\Asignacion
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Asignacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Asignacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Asignacion query()
 * @mixin \Eloquent
 */
class Asignacion extends Model
{
   protected $table='dir_asignacion';

    protected $primaryKey='asi_id';

    public $timestamps=false;


    protected $fillable =[
    	'asi_id',
		'persona_id',
		'unidad',
		'asi_fecha_inicio',
		'asi_fecha_termino',
		'asi_vigente',
		'asi_cargo',
		'asi_tipo'
    ];

    protected $guarded =[

    ];
	
	public static function existe( $campo, $valor ){
		$query_cantidad = DB::table('dir_asignacion')
			 ->select(DB::raw('COUNT(asi_id) AS cantidad') )
             ->where($campo,$valor)
			 ->first();
		
		return ( $query_cantidad->cantidad > 0 ) ? true : false ;
	}
	
	public static function obtener_id( $campo, $valor ){
		$query_id = DB::table('dir_asignacion')
			 ->select('asi_id')
             ->where($campo,$valor)
			 ->first();
		
		return $query_id->asi_id;
	}

}

