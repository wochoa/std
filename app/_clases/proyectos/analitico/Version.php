<?php

namespace App\_clases\proyectos\analitico;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\analitico\Version
 *
 * @property int $id
 * @property int|null $vers_proyecto
 * @property int|null $vers_version
 * @property string|null $vers_fecha
 * @property int|null $vers_responzable
 * @property string|null $vers_cargo
 * @property string|null $vers_observacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereVersCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereVersFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereVersObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereVersProyecto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereVersResponzable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Version whereVersVersion($value)
 * @mixin \Eloquent
 */
class Version extends Model
{
    protected $table = 'proy_analitico_version';
    public $timestamps=true;

    protected $hidden = ['updated_at'];

    protected $casts = [
        'id'                      =>'integer',
        'vers_proyecto'           =>'integer',
        'vers_version'            =>'integer',
        'vers_responzable'        =>'integer',
    ];

}