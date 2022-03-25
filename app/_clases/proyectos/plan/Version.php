<?php

namespace App\_clases\proyectos\plan;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\plan\Version
 *
 * @property int $id
 * @property int|null $vers_proyecto
 * @property int|null $vers_version
 * @property int|null $vers_anio
 * @property int|null $vers_responzable
 * @property string|null $vers_cargo
 * @property string|null $vers_observacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereVersAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereVersCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereVersObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereVersProyecto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereVersResponzable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Version whereVersVersion($value)
 * @mixin \Eloquent
 */
class Version extends Model
{
    protected $table = 'proy_plan_version';
    public $timestamps=true;

    protected $hidden = ['updated_at'];
 
    protected $casts = [
        'id'                      =>'integer',
        'vers_proyecto'           =>'integer',
        'vers_anio'            =>'integer',
        'vers_version'            =>'integer',
        'vers_responzable'        =>'integer',
    ];
}