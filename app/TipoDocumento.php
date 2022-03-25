<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TipoDocumento
 *
 * @property int $idtdoc
 * @property string $tdoc_descripcion
 * @property string $tdoc_abreviado
 * @property int $tdoc_correlativo
 * @property string $tdoc_fecha
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento whereIdtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento whereTdocAbreviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento whereTdocCorrelativo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento whereTdocDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento whereTdocFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TipoDocumento extends Model
{
    protected $table='tram_tipodocumento';
    protected $primaryKey = 'idtdoc';

    protected $casts = [
      'tdoc_mpv' => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public static function getTiposAsArray()
    {
        $td = TipoDocumento::select(['idtdoc','tdoc_descripcion'])->orderBy('tdoc_descripcion', 'asc')->get();
        $return = [];
        foreach ($td as $id=>$value)
        {
            $return[$value->idtdoc]=$value;

        }
        return $return;
    }
}
