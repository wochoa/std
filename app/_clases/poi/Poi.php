<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\Poi
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Poi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Poi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\Poi query()
 * @mixin \Eloquent
 */
class Poi extends Model
{
    protected $table='poi';

    protected $primaryKey='poi_codigo';

    public $timestamps=false;
}

