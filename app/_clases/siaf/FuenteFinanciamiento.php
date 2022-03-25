<?php

namespace App\_clases\siaf;

use App\_clases\utilitarios\Cadena;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\siaf\FuenteFinanciamiento
 *
 * @property string|null $ANO_EJE
 * @property string|null $ORIGEN
 * @property string|null $FUENTE_FIN
 * @property string|null $NOMBRE
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\FuenteFinanciamiento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\FuenteFinanciamiento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\FuenteFinanciamiento query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\FuenteFinanciamiento whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\FuenteFinanciamiento whereFUENTEFIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\FuenteFinanciamiento whereNOMBRE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\FuenteFinanciamiento whereORIGEN($value)
 * @mixin \Eloquent
 */
class FuenteFinanciamiento extends Model
{

    protected $table = 'siaf_fuente_financ';

    public $timestamps = false;

    public static function getFuenteFinanciamientoToSelect($anio = '')
    {
        $fuentes = [];
        if ($anio == '')
            $anio = Carbon::now()->year;
        $esp = FuenteFinanciamiento::select([
            'fuente_financ',
            'nombre',
        ])
            ->where('ano_eje', '=', $anio);
        foreach ($esp->get() as $data) {
            $fuentes[$data->fuente_financ] = Cadena::iniciales($data->nombre) . ' - ' . $data->nombre;
        }
        return $fuentes;
    }

    public static function getFuenteFinanciamiento($anio = '', $fte = '')
    {
        $fuentes = '';
        if ($anio == '')
            $anio = Carbon::now()->year;
        $esp = FuenteFinanciamiento::select([
            'fuente_financ',
            'nombre',
        ])
            ->where('ano_eje', '=', $anio)
            ->where('fuente_financ', '=', $fte);
        $data = $esp->get()[0];
        $fuentes = Cadena::iniciales($data->nombre) . ' - ' . $data->nombre;
        return $fuentes;
    }

    public static function getFuenteFinanc()
    {
        return FuenteFinanciamiento::select(['fuente_financ', 'nombre'])
            ->where('ano_eje', '=',  Carbon::now()->year)
            ->orderBy('fuente_financ','asc')
            ->get();
    }
}
