<?php

namespace App\_clases\proyectos\plan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\plan\Insumo
 *
 * @property int $id
 * @property int $componente_id
 * @property string $insu_nombre
 * @property string|null $insu_unidad_medida
 * @property float|null $insu_cantidad
 * @property string $insu_id_clasifi
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo whereComponenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo whereInsuCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo whereInsuIdClasifi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo whereInsuNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Insumo whereInsuUnidadMedida($value)
 * @mixin \Eloquent
 */
class Insumo extends Model
{
    protected $table='proy_plan_insumo';
    public $timestamps=false;
}
