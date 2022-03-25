<?php

namespace App\_clases\directorio;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * App\_clases\directorio\Persona
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Persona newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Persona newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Persona query()
 * @mixin \Eloquent
 */
class Persona extends Model
{
   protected $table='dir_persona';

    protected $primaryKey='per_id';

    public $timestamps=false;


    protected $fillable =[
    	'per_id',
		'per_dni',
		'per_nombre',
		'per_apellido',
		'per_fono',
		'per_direccion',
		'per_email'
    ];

    protected $guarded =[

    ];
	
	public static function existe( $campo, $valor ){
		$query_cantidad = DB::table('dir_persona')
			 ->select(DB::raw('COUNT(per_id) AS cantidad') )
             ->where($campo,$valor)
			 ->first();
		
		return ( $query_cantidad->cantidad > 0 ) ? true : false ;
	}
	
	public static function obtener_id( $campo, $valor ){
		$query_id = DB::table('dir_persona')
			 ->select('per_id')
             ->where($campo,$valor)
			 ->first();
		
		return $query_id->per_id;
	}

}

