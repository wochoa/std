<?php

namespace App\_clases\proyectos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\Actividad
 *
 * @property int $idactividad
 * @property string|null $act_descripcion
 * @property string|null $act_desc_corta
 * @property int|null $act_plazo_probable
 * @property int|null $act_accion 0:nada
 * 1:paralizacion
 * 2:ampliacion
 * 3:adicional
 * 4:deductivo
 * 5: adelanto6: valorizacion
 * @property int $etapa_idetapa_etapa
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad whereActAccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad whereActDescCorta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad whereActDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad whereActPlazoProbable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad whereEtapaIdetapaEtapa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Actividad whereIdactividad($value)
 * @mixin \Eloquent
 */
class Actividad extends Model
{
    protected $table='proy_actividad';

    protected $primaryKey='idactividad';

    public $timestamps=false;

    public static function getActividad()
    {
        return Actividad::select('idactividad', 'act_descripcion', 'act_accion')
            ->orderBy('act_descripcion', 'asc')
            ->get();
    }

}
