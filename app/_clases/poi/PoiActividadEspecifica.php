<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\PoiActividadEspecifica
 *
 * @property-read \App\_clases\poi\ClasificadorGasto $clasificador
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadEspecifica newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadEspecifica newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiActividadEspecifica query()
 * @mixin \Eloquent
 */
class PoiActividadEspecifica extends Model
{
    protected $table = 'poi_actividad_especifica';
  
    public $primaryKey = 'id_actividad_especifica';
    
    public $timestamps = false;   
    
    public function clasificador()
    {
        return $this->belongsTo('App\_clases\poi\ClasificadorGasto', 'especifica_clasificador_gastos', 'idclasificador_gasto');
    }
}