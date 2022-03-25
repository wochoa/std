<?php

namespace App\_clases\proyectos\plan;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

/**
 * App\_clases\proyectos\plan\Programar
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanCompId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanFftt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanIdClasifi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanM9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar wherePlanProyecto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Programar whereVersionId($value)
 * @mixin \Eloquent
 */
class Programar extends Model
{
    protected $table = 'proy_plan';
    public $timestamps = true;

    public static function getProgramacionResumen($anio, $oficina = 0, $act_proy = 'all')
    {
        return [];
        $oficinas = [];
        $where = [
            ['proy_plan_anio', '=', $anio],
            ['proy_plan_mes.proy_plan_monto', '>', DB::raw(0)],
            [
                'proy_plan_mes.version_id',
                '=',
                DB::raw('(SELECT Max(v.id) FROM proy_plan_version AS v WHERE v.vers_proyecto = proy_plan_mes.proy_plan_proyecto AND v.vers_anio = proy_plan_mes.`proy_plan_anio`)'),
            ],
        ];
        if ($act_proy != 'all')
            $where[] = ['g.asig_act_proy', 'LIKE', $act_proy];

        $programado = DB::table('proy_plan_mes')
            ->select([
                DB::raw('Sum(proy_plan_mes.proy_plan_monto) AS monto'),
                DB::raw('((proy_plan_mes.proy_plan_mes-1)%12)+1 as mes'),
            ])
            ->where($where)
            ->groupBy('proy_plan_anio')
            ->groupBy(DB::raw('proy_plan_mes % 12'))
            ->groupBy('mes')
            ->orderBy('mes');
        $dias_p = [];
        foreach ($programado->get() as $prg) {
            $dias_p[$prg->mes - 1] = $prg->monto;
        }
        return $dias_p;
    }
}
