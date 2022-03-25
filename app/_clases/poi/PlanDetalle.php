<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\PlanDetalle
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PlanDetalle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PlanDetalle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PlanDetalle query()
 * @mixin \Eloquent
 */
class PlanDetalle extends Model
{
    protected $table='poi_plan_detalle';

    protected $primaryKey='plan_det_id';

    public $timestamps=false;


    protected $fillable =[
    	'plan_det_id',
		'plan_id',
		'plan_det_categoria',
		'plan_det_codigo',
		'plan_det_descripcion',
		'plan_det_cod_indicador',
		'plan_det_indicador',
		'plan_det_cod_unidad_medida',
		'plan_det_unidad_medida',
		'plan_det_meta',
		'detalle_padre'
    ];

    protected $guarded =[

    ];
	
	public static function obtener_oets($id){
	
		return PlanDetalle::where([
									['detalle_padre','=',$id],
									['plan_id','=','1'],
									['plan_det_categoria','=','OER']
								])
								->get();
	}
	
	public static function obtener_oet_por_indicador($id){
	
		return PlanDetalle::where([
									['plan_det_id','=',$id],
									['plan_id','=','1'],
									['plan_det_categoria','=','OER']
								])
								/*->select(
											'plan_det_id',
											'plan_det_codigo',
											'plan_det_descripcion'
										)
								->distinct()*/
								->get();
	}
	
    //----------------------OEI---------------------------------------
	public static function obtener_oeis($id){
	
		return PlanDetalle::where([
									['detalle_padre','=',$id],
									['plan_id','=','2'],
									['plan_det_categoria','=','OEI']
								])
								->get();
	}
    
    public static function obtener_oeis_por_oet($id){
	
		return PlanDetalle::where([
									['detalle_padre','=',$id],
									['plan_id','=','2'],
									['plan_det_categoria','=','OEI']
								])
								->get();
	}
    
    public static function obtener_oei_por_indicador($id){
	
		return PlanDetalle::where([
									['plan_detalle_pei','=',$id],
									['plan_id','=','2'],
									['plan_det_categoria','=','OEI']
								])
								->get();
	}
    
    public static function obtener_oei_indicador($id){
	
		return PlanDetalle::where([
									['plan_det_id','=',$id],
									['plan_id','=','2'],
									['plan_det_categoria','=','OEI']
								])
								->get();
	}
    //----------------------OEI---------------------------------------
    
    //----------------------AEI---------------------------------------
    public static function obtener_aeis($id){
	
		return PlanDetalle::where([
									['plan_detalle_pei','=',$id],
									['plan_id','=','2'],
									['plan_det_categoria','=','AEI']
								])
								->get();
	}
    
    public static function obtener_aei_por_indicador($id){
	
		return PlanDetalle::where([
									['plan_det_padre_aei','=',$id],
									['plan_id','=','2'],
									['plan_det_categoria','=','AEI']
								])
								->get();
	}
    
    public static function obtener_aei_por_meta($id){
	
		return PlanDetalle::where([
									['plan_detalle_pei','=',$id],
									['plan_id','=','2'],
									['plan_det_categoria','=','AEI']
								])
								->get();
	}
    
    public static function obtener_faltante_aei($id){
	
		return PlanDetalle::where([
									['plan_det_id','=',$id],
									['plan_id','=','2'],
									['plan_det_categoria','=','AEI']
								])
								->get();
	}
    //----------------------AEI---------------------------------------
    
	public static function obtener_aets($id){
	
		return PlanDetalle::where([
									['detalle_padre','=',$id],
									['plan_id','=','1'],
									['plan_det_categoria','=','AER']
								])
								->get();
	} 
    
	public static function obtener_aet_indicador($id){
	
		return PlanDetalle::where([
									['plan_det_id','=',$id],
									['plan_id','=','1'],
									['plan_det_categoria','=','AER']
								])
								->get();
	}
	
	public static function obtener_aet_por_indicador($padre, $id){
	
		return PlanDetalle::where([
									//['detalle_padre','=',$padre],
                                    ['plan_detalle_pei','=',$padre],
									['plan_id','=','1'],
									['plan_det_categoria','=','AER']
								])
								->get();
	}
    
    public static function obtener_um_aet_por_indicador($padre, $id, $id_indicador){
	
		return PlanDetalle::where([
									['detalle_padre','=',$padre],
									['plan_det_codigo','=',$id],
									['plan_det_cod_indicador','=',$id_indicador],
									['plan_id','=','1'],
									['plan_det_categoria','=','AER']
								])
								->get();
	}
}
