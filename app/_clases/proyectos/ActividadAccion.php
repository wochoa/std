<?php

namespace App\_clases\proyectos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\ActividadAccion
 *
 * @property int $id
 * @property string|null $descripcion
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadAccion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadAccion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadAccion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadAccion whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadAccion whereId($value)
 * @mixin \Eloquent
 */
class ActividadAccion extends Model
{
    protected $table='proy_actividad_accion';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $hidden = ['created_at','updated_at'];

    public static function getActividadAccion()
    {
        return ActividadAccion::select(['id','descripcion'])
            ->orderBy('id','asc')->get();
    }
}
