<?php

namespace App\_clases\poi;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\poi\ClasificadorGasto
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\ClasificadorGasto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\ClasificadorGasto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\poi\ClasificadorGasto query()
 * @mixin \Eloquent
 */
class ClasificadorGasto extends Model
{
    protected $table = 'clasificador_gasto';
  
    public $primaryKey = 'idclasificador_gasto';
    
    public $timestamps = false;   
    
}