<?php

namespace App\_clases\directorio;

use Illuminate\Database\Eloquent\Model;

use DB;

/**
 * App\_clases\directorio\Unidad
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Unidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Unidad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\directorio\Unidad query()
 * @mixin \Eloquent
 */
class Unidad extends Model
{
   protected $table='dir_unidad';

    protected $primaryKey='uni_id';

    public $timestamps=false;


    protected $fillable =[
    	'uni_id',
		'uni_denominacion',
		'uni_fono',
		'uni_direccion',
		'uni_direccion_web',
		'uni_contactos_varios',
		'ubigeo',
		'superior',
		'tipo_unidad',
		'uni_colaboradores'
    ];

    protected $guarded =[

    ];
	
	public static function existe( $campo, $valor ){
		$query_cantidad = DB::table('dir_unidad')
			 ->select(DB::raw('COUNT(uni_id) AS cantidad') )
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

