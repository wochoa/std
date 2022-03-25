<?php

namespace App\_clases\siaf;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\siaf\SiafUnidadDeMedida
 *
 * @property int|null $UNIDAD_MED
 * @property string|null $NOMBRE
 * @property string|null $ABREVIATUR
 * @property string|null $AMBITO
 * @property string|null $ESTADO
 * @property string|null $ES_LOGISTI
 * @property string|null $ES_PRESUPU
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida whereABREVIATUR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida whereAMBITO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida whereESLOGISTI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida whereESPRESUPU($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida whereESTADO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida whereNOMBRE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafUnidadDeMedida whereUNIDADMED($value)
 * @mixin \Eloquent
 */
class SiafUnidadDeMedida extends Model
{
    protected $table = 'siaf_unidad_medida';

    public $timestamps = false;


    protected $fillable = [
        'unidad_medida',
        'nombre',
    ];


    public static function obtener_todo_para_select()
    {
        $um = SiafUnidadDeMedida::all();
        $arreglo = [];
        foreach ($um as $unidad) {
            $arreglo[$unidad->unidad_medida] = $unidad;
        }
        return $arreglo;
    }

}
