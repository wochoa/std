<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Recepcion
 *
 * @property int $idrecepcion
 * @property string $rece_descripcion
 * @property string $rece_abreviado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Recepcion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Recepcion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Recepcion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Recepcion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Recepcion whereIdrecepcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Recepcion whereReceAbreviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Recepcion whereReceDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Recepcion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Recepcion extends Model
{
    protected $table = 'tram_recepcion';
}
