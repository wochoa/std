<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\PoiTarea
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiTarea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiTarea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\PoiTarea query()
 * @mixin \Eloquent
 */
class PoiTarea extends Model
{
    protected $table='poi_tarea';

    protected $primaryKey='id_tarea';

    public $timestamps=false;
}
