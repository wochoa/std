<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\Oficina
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\_clases\poi\Poi[] $oficina_poi
 * @property-read int|null $oficina_poi_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Oficina newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Oficina newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Oficina query()
 * @mixin \Eloquent
 */
class Oficina extends Model
{
    protected $table='oficina';

    protected $primaryKey='ofi_codigo';

    public $timestamps=false;
    
    public function oficina_poi()
    {
        return $this->hasMany('App\_clases\poi\Poi', 'oficina', 'poi_codigo');
    }    
}

