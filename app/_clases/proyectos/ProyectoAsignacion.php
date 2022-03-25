<?php

namespace App\_clases\proyectos;

use App\_clases\proyectos\analitico\Analitico;
use App\_clases\siaf\FuenteFinanciamiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;
use Carbon\Carbon;

/**
 * App\_clases\proyectos\ProyectoAsignacion
 *
 * @property int $id
 * @property int|null $asig_act_proy
 * @property string|null $asig_oficina
 * @property int|null $asig_anio
 * @property int|null $asig_componente
 * @property string|null $asig_estado
 * @property string|null $asig_responzable
 * @property string|null $asig_tag1
 * @property string|null $asig_tag2
 * @property string|null $asig_tag3
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigActProy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigComponente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigOficina($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigResponzable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigTag1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigTag2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereAsigTag3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoAsignacion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProyectoAsignacion extends Model
{
    protected $table='proy_proyecto_asignacion';
    public $timestamps=true;


}
