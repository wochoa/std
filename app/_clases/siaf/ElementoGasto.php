<?php

namespace App\_clases\siaf;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\_clases\siaf\ElementoGasto
 *
 * @property string|null $ANO_EJE
 * @property string|null $ELEMENTO_G
 * @property string|null $ID_CLASIFI
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\ElementoGasto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\ElementoGasto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\ElementoGasto query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\ElementoGasto whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\ElementoGasto whereELEMENTOG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\ElementoGasto whereIDCLASIFI($value)
 * @mixin \Eloquent
 */
class ElementoGasto extends Model
{

    protected $table = 'siaf_elemento_gasto';

    public $timestamps = false;
    public static $elementos;

    public static function getElemento($anio)
    {
        return ElementoGasto::select([
            DB::raw("CONCAT(categ_gasto,'.',grupo_gasto,'.',modalidad_gasto,'.',siaf_elemento_gasto.elemento_gasto) as elemento"),
            'nombre.nombre as descripcion',
            'id_clasificador',
        ])
            ->join('siaf_elemento_gasto_nombre as nombre', 'siaf_elemento_gasto.elemento_gasto', '=', 'nombre.elemento_gasto')
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->where('siaf_elemento_gasto.ano_eje', '=', $anio)
            ->get();
    }

    public static function getElementoToSelectCached()
    {
        return ElementoGasto::$elementos = Cache::remember('elementos', 3600, function () {
            return ElementoGasto::getElementoToSelect();
        });
    }

    public static function getElementoToSelect()
    {
        $especificas = [];
        $esp = ElementoGasto::select([
            DB::raw("CONCAT(categ_gasto,'.',grupo_gasto,'.',modalidad_gasto,'.',siaf_elemento_gasto.elemento_gasto) as elemento"),
            'nombre.nombre as descripcion',
            'id_clasificador',
        ])
            ->join('siaf_elemento_gasto_nombre as nombre', 'siaf_elemento_gasto.elemento_gasto', '=', 'nombre.elemento_gasto')
            ->orderBy('categ_gasto')
            ->orderBy('grupo_gasto')
            ->orderBy('modalidad_gasto')
            ->orderBy('siaf_elemento_gasto.elemento_gasto')
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->where('siaf_elemento_gasto.ano_eje', '=', 2008);
        foreach ($esp->get() as $data) {
            $especificas[$data->id_clasificador] = $data->elemento . ' - ' . $data->descripcion;
        }
        return $especificas;
    }

    public static function getElementoToSelectLight()
    {
        $especificas = [];
        $esp = ElementoGasto::select([
            DB::raw("CONCAT(categ_gasto,'.',grupo_gasto,'.',modalidad_gasto,'.',elemento_gasto) as elemento"),
            'id_clasificador',
        ])
            ->orderBy('categ_gasto')
            ->orderBy('grupo_gasto')
            ->orderBy('modalidad_gasto')
            ->orderBy('elemento_gasto')
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->where('ano_eje', '=', 2008);
        foreach ($esp->get() as $data) {
            $especificas[$data->id_clasificador] = $data->elemento;
        }
        return $especificas;
    }
}
