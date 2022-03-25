<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\PoiActividadActividad
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadActividad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadActividad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadActividad query()
 * @mixin \Eloquent
 */
class PoiActividadActividad extends Model
{
    protected $table = 'poi_actividad_actividad';
  
    public $primaryKey = 'actividad_id';
    
    public $timestamps = false;   
}