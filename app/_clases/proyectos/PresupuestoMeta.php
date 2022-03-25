<?php

namespace App\_clases\proyectos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;
use Carbon\Carbon;

/**
 * App\_clases\proyectos\PresupuestoMeta
 *
 * @property int $id
 * @property int|null $proy_siaf_anio
 * @property int|null $proy_sec_ejec
 * @property int|null $proy_siaf_sec_func
 * @property int|null $proy_tram_dependencia
 * @property int|null $proy_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta whereProySecEjec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta whereProySiafAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta whereProySiafSecFunc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta whereProyTramDependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta whereProyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\PresupuestoMeta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PresupuestoMeta extends Model
{
    protected $table='proy_presupuesto';

    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
        'id'                    =>'integer',
        'proy_siaf_anio'        =>'integer',
        'proy_sec_ejec'         =>'integer',
        'proy_siaf_sec_func'    =>'string',
    ];

    public static function getSecfuncOficina($anio)
    {
        return PresupuestoMeta::select('id','proy_siaf_anio','proy_sec_ejec','proy_siaf_sec_func','proy_tram_dependencia')
                                ->where('proy_siaf_anio','=', $anio)
                                ->get();
    }
}
