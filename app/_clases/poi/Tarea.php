<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\Tarea
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Tarea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Tarea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Tarea query()
 * @mixin \Eloquent
 */
class Tarea extends Model
{
    protected $table = 'poi_tarea';
  
    public $primaryKey = 'id_tarea';
    
    public $timestamps = false;
    
    protected $fillable =[
        'id_tarea',
        'tar_descripcion',
        'tar_um',
        'tar_cantidad',
        'poi_actividad_proyecto_idactividad_proyecto',
        'tar_estado',
        'tar_meta_fis_t1',
        'tar_meta_fis_t2',
        'tar_meta_fis_t3',
        'tar_meta_fis_t4',
        'tar_meta_eje_t1',
        'tar_meta_eje_t2',
        'tar_meta_eje_t3',
        'tar_meta_eje_t4',
        'tar_correcciones',
        'tar_copia',
        'tar_nro_copia',
        'tar_fecha_act',
        'tar_orden_personalizado'
    ];
}