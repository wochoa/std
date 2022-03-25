<?php

namespace App\_clases\directorio;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * App\_clases\directorio\Clasificacion
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Clasificacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Clasificacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Clasificacion query()
 * @mixin \Eloquent
 */
class Clasificacion extends Model
{
   protected $table='dir_clasificacion';

    protected $primaryKey='cla_id';

    public $timestamps=false;


    protected $fillable =[
    	'cla_descripcion'
    ];

    protected $guarded =[

    ];
	
	public static function existe( $campo, $valor ){
		$query_cantidad = DB::table('dir_clasificacion')
			 ->select(DB::raw('COUNT(cla_id) AS cantidad') )
             ->where($campo,$valor)
			 ->first();
		
		return ( $query_cantidad->cantidad > 0 ) ? true : false ;
	}
	/*
	public static function obtener_id( $campo, $valor ){
		$query_id = DB::table('cred_cliente')
			 ->select('id_cliente')
             ->where($campo,$valor)
			 ->first();
		
		return $query_id->id_cliente;
	}*/

}

