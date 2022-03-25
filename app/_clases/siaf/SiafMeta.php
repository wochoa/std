<?php

namespace App\_clases\siaf;

use Illuminate\Database\Eloquent\Model;
use DB;
use Cache;

/**
 * App\_clases\siaf\SiafMeta
 *
 * @property int|null $ANO_EJE
 * @property string|null $SEC_EJEC
 * @property string|null $SEC_FUNC
 * @property string|null $FUNCION
 * @property string|null $PROGRAMA
 * @property string|null $SUB_PROGRA
 * @property string|null $ACT_PROY
 * @property string|null $COMPONENTE
 * @property string|null $META
 * @property string|null $FINALIDAD
 * @property string|null $NOMBRE
 * @property float|null $MONTO
 * @property float|null $CANTIDAD
 * @property string|null $UNIDAD_MED
 * @property string|null $PROGRAMA_P
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereACTPROY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereCANTIDAD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereCOMPONENTE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereFINALIDAD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereFUNCION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereMETA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereMONTO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereNOMBRE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta wherePROGRAMA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta wherePROGRAMAP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereSECEJEC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereSECFUNC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereSUBPROGRA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\SiafMeta whereUNIDADMED($value)
 * @mixin \Eloquent
 */
class SiafMeta extends Model
{
    protected $table = 'siaf_meta';

    public $timestamps = false;

    protected $casts = [
        'ano_eje'       => 'integer',
        'sec_ejec'      => 'string',
        'sec_func'      => 'string',
        'funcion'       => 'string',
        'programa'      => 'string',
        'sub_programa'  => 'string',
        'act_proy'      => 'string',
        'componente'    => 'string',
        'meta'          => 'string',
        'finalidad'     => 'string',
        'nombre'        => 'string',
        'monto'         => 'double',
        'programa_ppto' => 'string',
    ];
    protected $fillable = [
        'ano_eje',
        'sec_ejec',
        'sec_func',
        'funcion',
        'programa',
        'sub_programa',
        'act_proy',
        'componente',
        'meta',
        'finalidad',
        'nombre',
        'monto',
        'cantidad',
        'unidad_med',
        'programa_ppto',
    ];

    protected $guarded = [

    ];

    public static function getMetasCached($anio)
    {
        return Especifica::$especificas = Cache::remember('metasCached', 3600, function () use ($anio) {
            return SiafMeta::getMetas($anio);
        });
    }

    public static function getMetas($anio = null)
    {
        $where = [
            ['siaf_meta.sec_ejec', '=', config('proyectos.unidad_ejecutora')],
        ];
        if ($anio != null)
            $where[] = ['siaf_meta.ano_eje', '=', $anio];

        return SiafMeta::select([
            'siaf_meta.ano_eje',
            'siaf_meta.sec_ejec',
            'siaf_meta.sec_func',
            'siaf_meta.programa_ppto',
            'siaf_meta.funcion',
            'siaf_meta.sub_programa',
            'siaf_meta.act_proy',
            'siaf_meta.componente',
            'siaf_meta.meta',
            'siaf_meta.finalidad',
            'siaf_componente_nombre.nombre',
            'siaf_meta.programa',
            'proy_presupuesto.id as id_presupuesto',
            'proy_presupuesto.proy_tram_dependencia',
            DB::raw("SUM(siaf_wpresupuesto.pim) AS pim"),
        ])
            ->join("siaf_componente_nombre", function ($join) {
                $join->on("siaf_meta.ano_eje", "=", "siaf_componente_nombre.ano_eje")
                    ->on("siaf_meta.componente", "=", "siaf_componente_nombre.componente");
            })
            ->leftJoin('proy_presupuesto', function ($leftJoin) {
                $leftJoin->on('siaf_meta.ano_eje', '=', 'proy_presupuesto.proy_siaf_anio')
                    ->on('siaf_meta.sec_ejec', '=', 'proy_presupuesto.proy_sec_ejec')
                    ->on('siaf_meta.sec_func', '=', 'proy_presupuesto.proy_siaf_sec_func');
            })
            ->leftJoin('siaf_wpresupuesto', function ($leftJoin) {
                $leftJoin->on('siaf_meta.ano_eje', '=', 'siaf_wpresupuesto.ano_eje')
                    ->on('siaf_meta.sec_ejec', '=', 'siaf_wpresupuesto.sec_ejec')
                    ->on('siaf_meta.sec_func', '=', 'siaf_wpresupuesto.sec_func');
            })
            ->groupBy('siaf_meta.ano_eje')
            ->groupBy('siaf_meta.sec_ejec')
            ->groupBy('siaf_meta.sec_func')
            ->groupBy('siaf_meta.programa_ppto')
            ->groupBy('siaf_meta.funcion')
            ->groupBy('siaf_meta.sub_programa')
            ->groupBy('siaf_meta.act_proy')
            ->groupBy('siaf_meta.componente')
            ->groupBy('siaf_meta.meta')
            ->groupBy('siaf_meta.finalidad')
            ->groupBy('siaf_componente_nombre.nombre')
            ->groupBy('siaf_meta.programa')
            ->groupBy('id_presupuesto')
            ->groupBy('proy_presupuesto.proy_tram_dependencia')
            ->orderBy('siaf_meta.sec_func', 'ASC')
            ->where($where)
            ->get();
    }

    public static function obtener_metas_por_anio_select($anio)
    {

        return SiafMeta::where([
            ['ano_eje', '=', $anio],
        ])
            ->select(
                'ID',
                'sec_func'
            )
            ->distinct()
            ->pluck('sec_func', 'ID');
    }

    public static function obtener_metas_por_id($id)
    {

        return SiafMeta::where([
            ['ID', '=', $id],
        ])
            ->get();
    }

    public static function obtener_metas_por_proyecto_y_anio($proy, $anio, $sec_ejec)
    {

        return SiafMeta::where([
            ['act_proy', '=', $proy],
            ['ano_eje', '=', $anio],
            ['sec_ejec', '=', $sec_ejec],
        ])
            ->get();
    }

    public static function getCadenaFuncional($meta, $anio)
    {
        $cf = SiafMeta::where('sec_func', '=', $meta)
            ->where('ano_eje', '=', $anio)
            ->where('sec_ejec', '=', config('proyectos.unidad_ejecutora'))
            ->first();
        //dd($cf);
        return $cf->programa_ppto . ' ' . $cf->act_proy . ' ' . $cf->componente . ' ' . $cf->funcion . ' ' . $cf->programa . ' ' . $cf->sub_programa . ' - ' . $cf->sec_func;
    }

    public static function getCF($meta, $anio, $sec_ejec)
    {
        $cf = SiafMeta::where('sec_func', '=', $meta)
            ->where('ano_eje', '=', $anio)
            ->where('sec_ejec', '=', $sec_ejec)
            ->first();
        //dd($cf);
        return $cf->programa_ppto . '.' . $cf->act_proy . '.' . $cf->componente . '.' . $cf->funcion . '.' . $cf->programa . '.' . $cf->sub_programa . '.' . $cf->sec_func;
    }
}
