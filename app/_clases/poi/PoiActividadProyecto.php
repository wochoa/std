<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\PoiActividadProyecto
 *
 * @property-read \App\_clases\poi\Poi $poi
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadProyecto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadProyecto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadProyecto query()
 * @mixin \Eloquent
 */
class PoiActividadProyecto extends Model
{
    protected $table='poi_actividad_proyecto';

    protected $primaryKey='idactividad_proyecto';

    public $timestamps=false;
    
    public function poi()
    {
        return $this->belongsTo('App\_clases\poi\Poi', 'poi_codigo', 'poi_codigo')->where('poi_anio', '=', 2018);
    }
    
    public function poi_codigo_actividad($id_poi)
    {
        return $this->belongsTo('App\_clases\poi\Poi', 'oficina', 'ofi_codigo')->where('poi_codigo', '=', $id_poi);
    }
}

