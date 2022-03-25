<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Plantilla
 *
 * @property int $id
 * @property string|null $plt_nombre
 * @property string|null $plt_plantilla
 * @property mixed|null $plt_datos
 * @property int|null $plt_idadmin
 * @property int|null $plt_iddependencia
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla wherePltDatos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla wherePltIdadmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla wherePltIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla wherePltNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla wherePltPlantilla($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plantilla whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Plantilla extends Model
{
    protected $table = 'tram_plantilla';
    //
    protected $casts = [
        'plt_referencias'  => 'array',
        'plt_derivaciones' => 'array',
        'plt_datos'        => 'object',
    ];

    public function getForPlantilla()
    {
        return json_encode((Object)[
            'id'                => $this->id,
            'plt_nombre'        => $this->plt_nombre,
            'plt_plantilla'     => $this->plt_plantilla,
            'plt_datos'         => $this->plt_datos,
            'plt_derivaciones'  => $this->plt_derivaciones,
            'plt_referencias'   => $this->plt_referencias,
            'plt_idadmin'       => $this->plt_idadmin,
            'plt_iddependencia' => $this->plt_iddependencia,
        ]);
    }
}
