<?php

namespace App\_clases\proyectos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\ObraEstado
 *
 * @property int $id
 * @property string|null $descripcion
 * @property int|null $etapa 0 condiciones previas 1 ejecucion 2 culminada 3 entregada 4 liquidada
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ObraEstado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ObraEstado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ObraEstado query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ObraEstado whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ObraEstado whereEtapa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ObraEstado whereId($value)
 * @mixin \Eloquent
 */
class ObraEstado extends Model
{
    protected $table='proy_obra_estados';

    protected $primaryKey='id';
}
