<?php

namespace App\_clases\proyectos\tools\modificar;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\tools\modificar\Modificatoria
 *
 * @property int $id
 * @property int|null $modif_anio
 * @property string|null $modif_titulo
 * @property string|null $modif_fecha_aprovacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria whereModifAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria whereModifFechaAprovacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria whereModifTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\Modificatoria whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Modificatoria extends Model
{
    protected $table='proy_tools_modificatoria';
}
