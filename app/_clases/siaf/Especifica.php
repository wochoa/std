<?php

namespace App\_clases\siaf;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * App\_clases\siaf\Especifica
 *
 * @property string|null $ANO_EJE
 * @property int|null $TIPO_TRANS
 * @property int|null $GENERICA
 * @property int|null $SUBGENERIC
 * @property int|null $SUBGENERI2
 * @property int|null $ESPECIFICA
 * @property int|null $ESPECIFIC2
 * @property string|null $ID_CLASIFI
 * @property string|null $DESCRIPCIO
 * @property string|null $AMBITO
 * @property string|null $ESTADO
 * @property string|null $EXCLUSIVO_
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereAMBITO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereDESCRIPCIO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereESPECIFIC2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereESPECIFICA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereESTADO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereEXCLUSIVO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereGENERICA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereIDCLASIFI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereSUBGENERI2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereSUBGENERIC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\Especifica whereTIPOTRANS($value)
 * @mixin \Eloquent
 */
class Especifica extends Model
{

    protected $table = 'siaf_especifica_det';

    public $timestamps = false;
    public static $especificas;

    public static function getEspecificas($anio)
    {
        return Especifica::select([
            DB::raw("CONCAT(tipo_transaccion,'.',generica,'.',subgenerica,'.',subgenerica_det,'.',especifica,'.',especifica_det) as especifica"),
            'descripcion',
            'id_clasificador',
        ])
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->where('ano_eje', '=', $anio)
            ->get();
    }

    public static function getEspecificasToSelectCached()
    {
        return Especifica::$especificas = Cache::remember('especificas', 3600, function () {
            return Especifica::getEspecificasToSelect3();
        });
    }

    public static function getEspecificasToSelect($year = null)
    {
        $especificas = [];
        if ($year == null) {
            $year = Carbon::now()->year;
        }
        return $esp = Especifica::select([
            DB::raw("CONCAT(tipo_transaccion,'.',generica,'.',subgenerica,'.',subgenerica_det,'.',especifica,'.',especifica_det) as especifica"),
            'descripcion',
            'id_clasificador',
        ])
            ->orderBy('tipo_transaccion')
            ->orderBy('generica')
            ->orderBy('subgenerica')
            ->orderBy('subgenerica_det')
            ->orderBy('especifica')
            ->orderBy('especifica_det', 'asc')
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->where('ano_eje', '=', $year);
        foreach ($esp->get() as $data) {
            $especificas[$data->id_clasificador] = $data->especifica . ' - ' . $data->descripcion;
        }
        return $especificas;
    }

    public static function getEspecificasToSelect3($year = null)
    {
        $especificas = [];
        if ($year == null) {
            $year = Carbon::now()->year;
        }
        $esp = Especifica::select([
            DB::raw("CONCAT(tipo_transaccion,'.',generica,'.',subgenerica,'.',subgenerica_det,'.',especifica,'.',especifica_det) as especifica"),
            'descripcion',
            'id_clasificador',
        ])
            ->orderBy('tipo_transaccion')
            ->orderBy('generica')
            ->orderBy('subgenerica')
            ->orderBy('subgenerica_det')
            ->orderBy('especifica')
            ->orderBy('especifica_det', 'asc')
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->where('ano_eje', '=', $year);
        foreach ($esp->get() as $data) {
            $especificas[$data->id_clasificador] = $data->especifica . ' - ' . $data->descripcion;
        }
        return $especificas;
    }

    public static function getEspecificasToSelectInList($list = [], $year = null)
    {
        $especificas = [];
        if ($year == null) {
            $year = Carbon::now()->year;
        }
        $esp = Especifica::select([
            DB::raw("CONCAT(tipo_transaccion,'.',generica,'.',subgenerica,'.',subgenerica_det,'.',especifica,'.',especifica_det) as especifica"),
            \DB::raw('(SELECT e.descripcion FROM siaf_especifica AS e WHERE e.tipo_transaccion = siaf_especifica_det.tipo_transaccion AND e.generica = siaf_especifica_det.generica AND e.subgenerica = siaf_especifica_det.subgenerica AND e.subgenerica_det = siaf_especifica_det.subgenerica_det AND e.especifica = siaf_especifica_det.especifica AND e.ano_eje = siaf_especifica_det.ano_eje) AS ESP'),
            'descripcion',
            'id_clasificador',
        ])
            ->orderBy('tipo_transaccion')
            ->orderBy('generica')
            ->orderBy('subgenerica')
            ->orderBy('subgenerica_det')
            ->orderBy('especifica')
            ->orderBy('especifica_det', 'asc')
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->whereIn('id_clasificador', $list)
            ->where('ano_eje', '=', $year);
        $conv = array("COSTO DE " => "",);
        foreach ($esp->get() as $data) {
            $especificas[$data->id_clasificador] = $data->especifica . ' - ' . $data->ESP . ' </br> ' . strtr($data->descripcion, $conv);
        }
        return $especificas;
    }

    public static function getEspecificasToSelectLight()
    {
        $especificas = [];
        $mytime = Carbon::now();
        $esp = Especifica::select([
            DB::raw("CONCAT(tipo_transaccion,'.',generica,'.',subgenerica,'.',subgenerica_det,'.',especifica,'.',especifica_det) as especifica"),
            'id_clasificador',
        ])
            ->orderBy('tipo_transaccion', 'asc')
            ->orderBy('generica', 'asc')
            ->orderBy('subgenerica', 'asc')
            ->orderBy('subgenerica_det', 'asc')
            ->orderBy('especifica', 'asc')
            ->orderBy('especifica_det', 'asc')
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->where('ano_eje', '=', $mytime->year);
        foreach ($esp->get() as $data) {
            $especificas[$data->id_clasificador] = $data->especifica;
        }
        return $especificas;
    }

    public static function getEspecificasToSelectforObra()
    {
        $especificas = [];
        $mytime = Carbon::now();
        $esp = DB::table('siaf_especifica_det as e_d')
            ->join('siaf_especifica AS e', function ($join) {
                $join->on('e.tipo_transaccion', '=', 'e_d.tipo_transaccion')
                    ->on('e.generica', '=', 'e_d.generica')
                    ->on('e.subgenerica', '=', 'e_d.subgenerica')
                    ->on('e.subgenerica_det', '=', 'e_d.subgenerica_det')
                    ->on('e.especifica', '=', 'e_d.especifica');
            })
            ->select([
                DB::raw("CONCAT(e_d.tipo_transaccion,'.',e_d.generica,'.',e_d.subgenerica,'.',e_d.subgenerica_det,'.',e_d.especifica,'.',e_d.especifica_det) as especifica"),
                'e_d.descripcion',
                'e.descripcion as ESP',
                'e_d.id_clasificador',
                DB::raw("CONCAT(e_d.tipo_transaccion,'.',e_d.generica,'.',e_d.subgenerica,'.',e_d.subgenerica_det,'.',e_d.especifica) as agrupacion"),
            ])
            ->where('e_d.id_clasificador', '<>', 'AAAAAAA')
            ->where('e_d.tipo_transaccion', '=', '2')
            ->where('e_d.generica', '=', '6')
            ->where('e_d.ano_eje', '=', $mytime->year)
            ->orderBy('e_d.tipo_transaccion', 'asc')
            ->orderBy('e_d.generica', 'asc')
            ->orderBy('e_d.subgenerica', 'asc')
            ->orderBy('e_d.subgenerica_det', 'asc')
            ->orderBy('e_d.especifica', 'asc')
            ->orderBy('e_d.especifica_det', 'asc');
        foreach ($esp->get() as $data) {
            //if(!isset($especificas[$data->agrupacion]))$especificas[$data->agrupacion]=[];
            $especificas[$data->agrupacion . " - " . $data->ESP][$data->id_clasificador] = $data->especifica . ' - ' . $data->descripcion;
        }
        return $especificas;
    }

    public static function getEspecificasToSelect2()
    {
        $especificas = [];
        $mytime = Carbon::now();
        $esp = DB::table('siaf_especifica_det as e_d')
            ->join('siaf_especifica AS e', function ($join) {
                $join->on('e.tipo_transaccion', '=', 'e_d.tipo_transaccion')
                    ->on('e.generica', '=', 'e_d.generica')
                    ->on('e.subgenerica', '=', 'e_d.subgenerica')
                    ->on('e.subgenerica_det', '=', 'e_d.subgenerica_det')
                    ->on('e.especifica', '=', 'e_d.especifica');
            })
            ->select([
                DB::raw("CONCAT(e_d.tipo_transaccion,'.',e_d.generica,'.',e_d.subgenerica,'.',e_d.subgenerica_det,'.',e_d.especifica,'.',e_d.especifica_det) as especifica"),
                'e_d.descripcion',
                'e.descripcion as ESP',
                'e_d.id_clasificador',
                DB::raw("CONCAT(e_d.tipo_transaccion,'.',e_d.generica,'.',e_d.subgenerica,'.',e_d.subgenerica_det,'.',e_d.especifica) as agrupacion"),
            ])
            ->where('e_d.id_clasificador', '<>', 'AAAAAAA')
            ->where('e_d.tipo_transaccion', '=', '2')
            ->whereIn('e_d.generica', ['6', '3'])
            ->where('e_d.ano_eje', '=', $mytime->year)
            ->orderBy('e_d.tipo_transaccion', 'asc')
            ->orderBy('e_d.generica', 'asc')
            ->orderBy('e_d.subgenerica', 'asc')
            ->orderBy('e_d.subgenerica_det', 'asc')
            ->orderBy('e_d.especifica', 'asc')
            ->orderBy('e_d.especifica_det', 'asc');
        foreach ($esp->get() as $data) {
            $especificas[$data->agrupacion . " - " . $data->ESP][$data->id_clasificador] = $data->especifica . ' - ' . $data->descripcion;
        }
        return $especificas;
    }

    public static function getEspecificaDetalle()
    {
        return Especifica::select([
            'id_clasificador',
            DB::RAW("CONCAT(tipo_transaccion,'.',generica,'.',subgenerica,'.',subgenerica_det,'.',especifica,'.',especifica_det) as clasifi"),
            'descripcion',
        ])
            ->where('ano_eje', '=', Carbon::now()->year)
            ->where('id_clasificador', '<>', 'AAAAAAA')
            ->get();
    }
}
