<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Prioridad
 *
 * @property int $idprioridad
 * @property string $prio_descripcion
 * @property string $prio_abreviado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prioridad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prioridad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prioridad query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prioridad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prioridad whereIdprioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prioridad wherePrioAbreviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prioridad wherePrioDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Prioridad whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Prioridad extends Model
{
    protected $table='tram_prioridad';
   
}
