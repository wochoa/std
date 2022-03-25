<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\UnidadEjecutora
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\UnidadEjecutora newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\UnidadEjecutora newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\UnidadEjecutora query()
 * @mixin \Eloquent
 */
class UnidadEjecutora extends Model
{
    protected $table = 'unidad_ejecutora';
  
    public $primaryKey = 'ue_codigo';
    
    public $timestamps = false;
}