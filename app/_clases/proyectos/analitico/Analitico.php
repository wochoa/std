<?php

namespace App\_clases\proyectos\analitico;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\analitico\Analitico
 *
 * @property int $analitico_id
 * @property int|null $ana_act_proy
 * @property string|null $ana_componente
 * @property string|null $ana_especifca
 * @property float|null $ana_monto
 * @property float|null $ana_modificaciones
 * @property string|null $ana_descricion
 * @property int|null $analitico_version_id 0:Borrador
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereAnaActProy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereAnaComponente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereAnaDescricion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereAnaEspecifca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereAnaModificaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereAnaMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereAnaliticoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereAnaliticoVersionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Analitico whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Analitico extends Model
{
    protected $table='proy_analitico';

    protected $primaryKey='analitico_id';

    public $timestamps=true;

    protected $hidden = ['created_at','updated_at'];

    protected $casts = [
        'analitico_id'                  =>'integer',
        'ana_act_proy'                  =>'integer',
        'ana_componente'                =>'string',
        'ana_monto'                     =>'double',
        'ana_modificaciones'            =>'double',
        'analitico_version_id'          =>'integer',
    ];

}
