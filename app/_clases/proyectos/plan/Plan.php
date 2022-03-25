<?php

namespace App\_clases\proyectos\plan;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\plan\Plan
 *
 * @property int $id
 * @property int|null $plan_comp_id
 * @property string|null $plan_fftt
 * @property string|null $plan_id_clasifi
 * @property int|null $plan_anio
 * @property int|null $version_id
 * @property int|null $plan_proyecto
 * @property float|null $plan_m1
 * @property float|null $plan_m2
 * @property float|null $plan_m3
 * @property float|null $plan_m4
 * @property float|null $plan_m5
 * @property float|null $plan_m6
 * @property float|null $plan_m7
 * @property float|null $plan_m8
 * @property float|null $plan_m9
 * @property float|null $plan_m10
 * @property float|null $plan_m11
 * @property float|null $plan_m12
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanCompId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanFftt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanIdClasifi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanM9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan wherePlanProyecto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Plan whereVersionId($value)
 * @mixin \Eloquent
 */
class Plan extends Model
{
    protected $table = 'proy_plan';
    public $timestamps=true;

    protected $casts = [
        'plan_m1'          =>'double',
        'plan_m2'          =>'double',
        'plan_m3'          =>'double',
        'plan_m4'          =>'double',
        'plan_m5'          =>'double',
        'plan_m6'          =>'double',
        'plan_m7'          =>'double',
        'plan_m8'          =>'double',
        'plan_m9'          =>'double',
        'plan_m10'         =>'double',
        'plan_m11'         =>'double',
        'plan_m12'         =>'double',
    ];
}
