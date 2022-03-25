<?php

namespace App\_clases\siaf\reportes;

use App\_clases\siaf\Especifica;
use App\_clases\siaf\ElementoGasto;
use App\_clases\siaf\FuenteFinanciamiento;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

/**
 * App\_clases\siaf\reportes\Presupuesto
 *
 * @property string|null $ANO_EJE
 * @property string|null $SEC_EJEC
 * @property string|null $SEC_FUNC
 * @property string|null $FUENTE_FIN
 * @property string|null $COMPONENTE
 * @property float|null $pia
 * @property string|null $ID_CLASIFI
 * @property string|null $act_proy
 * @property string|null $meta_name
 * @property float|null $modificacion
 * @property float|null $pim
 * @property float|null $monto_cert
 * @property string|null $certs
 * @property float|null $monto_comp_anual
 * @property float|null $monto_comp
 * @property float|null $monto_dev
 * @property float|null $g_1
 * @property float|null $g_2
 * @property float|null $g_3
 * @property float|null $g_4
 * @property float|null $g_5
 * @property float|null $g_6
 * @property float|null $g_7
 * @property float|null $g_8
 * @property float|null $g_9
 * @property float|null $g_10
 * @property float|null $g_11
 * @property float|null $g_12
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereACTPROY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereCOMPONENTE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereCerts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereFUENTEFIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG11($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG12($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereG9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereIDCLASIFI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereMetaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereModificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereMontoCert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereMontoComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereMontoCompAnual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereMontoDev($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto wherePia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto wherePim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereSECEJEC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Presupuesto whereSECFUNC($value)
 * @mixin \Eloquent
 */
class Presupuesto extends Model
{
    protected $table = 'siaf_wpresupuesto';

    public $timestamps = false;
    protected $casts = [
        'pia'              => 'double',
        'modif'            => 'double',
        'pim'              => 'double',
        'monto_cert'       => 'double',
        'monto_comp_anual' => 'double',
        'monto_comp'       => 'double',
        'monto_dev'        => 'double',
        'g_1'              => 'double',
        'g_2'              => 'double',
        'g_3'              => 'double',
        'g_4'              => 'double',
        'g_5'              => 'double',
        'g_6'              => 'double',
        'g_7'              => 'double',
        'g_8'              => 'double',
        'g_9'              => 'double',
        'g_10'             => 'double',
        'g_11'             => 'double',
        'g_12'             => 'double',
    ];

    public static function getPresupuestoForProy($anio, $proy)
    {
        $presupuesto = Presupuesto::select([
            'componente',
            'act_proy',
            'fuente_financ',
            'id_clasificador',
            'pia',
            'modif',
            \DB::raw('sum(pia) AS pia'),
            \DB::raw('sum(modif) AS modif'),
            \DB::raw('sum(pim) AS pim'),
        ])
            ->where('ano_eje', '=', $anio)
            ->where('act_proy', '=', $proy)
            ->groupBy('componente')
            ->groupBy('act_proy')
            ->groupBy('fuente_financ')
            ->groupBy('id_clasificador')
            ->groupBy('pia')
            ->groupBy('modif')
            ->groupBy('pim');
        $prs         = ['t' => 0];
        foreach ($presupuesto->get() as $d) {
            if (!isset($prs[$d->componente]))
                $prs[$d->componente] = ['t' => 0];
            $prs['t']                                 += $d->pim;
            $prs[$d->componente]['t']                 += $d->pim;
            $prs[$d->componente][$d->id_clasificador] = $d;
        }
        return $prs;
    }

    public static function PresupuestoPrioritario($ano_eje, $oficina)
    {
        if (isset($ano_eje)) {

            $where = function ($query) use ($ano_eje) {
                $query->where('sec_ejec', '=', config('proyectos.unidad_ejecutora'));
                $query->where('ano_eje', '=', $ano_eje);
            };
            $query = Presupuesto::select(
                [
                    'sec_func',
                    'componente',
                    DB::raw('sum(pim) as pim'),
                    DB::raw('max(act_proy) as act_proy'),
                    DB::raw('sum(monto_cert) as monto_cert'),
                    DB::raw('sum(monto_comp_anual) as monto_comp_anual'),
                    DB::raw('sum(monto_comp) as monto_comp'),
                    DB::raw('sum(monto_dev) as monto_dev'),
                ]
            )->where($where);

            if ($oficina != null) {
                $query
                    ->leftJoin('proy_presupuesto', function ($leftJoin) {
                        $leftJoin->on('ano_eje', '=', 'proy_presupuesto.proy_siaf_anio')
                            ->on('sec_ejec', '=', 'proy_presupuesto.proy_sec_ejec')
                            ->on('sec_func', '=', 'proy_presupuesto.proy_siaf_sec_func');
                    })
                    ->where('proy_tram_dependencia', '=', $oficina);
            }
            $query
                ->groupBy('sec_func')
                ->groupBy('componente')
                ->orderBy('pim', 'desc')->limit(9);

            return $query->get();
        } else
            abort(428, 'ano_eje es requerido.');
    }

    public static function getPresupuestoForProyAll($proy, $formato, $anio = null)
    {
        $anio        = ($anio == null) ? Carbon::now()->year : $anio;
        $presupuesto = Presupuesto::select(['*'])
            ->where('act_proy', '=', $proy)
            ->where('sec_ejec', '=', config('proyectos.unidad_ejecutora'))
            ->orderBy('ano_eje', 'DESC')
            ->orderBy('sec_func', 'ASC');
        if ($proy == 3999999) {
            $presupuesto->where('ano_eje', '=', $anio);
        }
        $especificas = Especifica::getEspecificasToSelectCached();
        $elemento = ElementoGasto::getElementoToSelectCached();
        $fuente = FuenteFinanciamiento::getFuenteFinanciamientoToSelect();
        $new    = [
            'type'       => 'gasto',
            'desc1'      => '',
            'desc2'      => '',
            'desc3'      => '',
            'monto_pim'  => (float)0,
            'monto_cert' => (float)0,
            'monto_comp' => (float)0,
            'monto_dev'  => (float)0,
            'g_1'        => (float)0,
            'g_2'        => (float)0,
            'g_3'        => (float)0,
            'g_4'        => (float)0,
            'g_5'        => (float)0,
            'g_6'        => (float)0,
            'g_7'        => (float)0,
            'g_8'        => (float)0,
            'g_9'        => (float)0,
            'g_10'       => (float)0,
            'g_11'       => (float)0,
            'g_12'       => (float)0,
            'g_tot'      => (float)0,
        ];/*,
            'p_1'=>(float)0,'p_2'=>(float)0,'p_3'=>(float)0,'p_4'=>(float)0,'p_5'=>(float)0,'p_6'=>(float)0,
            'p_7'=>(float)0,'p_8'=>(float)0,'p_9'=>(float)0,'p_10'=>(float)0,'p_11'=>(float)0,'p_12'=>(float)0,'p_tot'=>(float)0,
            'p_mes'=>(float)0);*/
        $prs = [];
        switch ($formato) {
            default:
            case 1: {
                    foreach ($presupuesto->get() as $d) {
                        if ($d->pim > 0) {
                            if (!isset($prs[$d->ano_eje]))
                                $prs[$d->ano_eje] = ['t' => (object)$new];
                            if (!isset($prs[$d->ano_eje][$d->fuente_financ]))
                                $prs[$d->ano_eje][$d->fuente_financ] = ['t' => (object)$new];
                            if (!isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func]))
                                $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func] = ['t' => (object)$new];
                            $prs[$d->ano_eje]['t']                                                              = Presupuesto::agregar($prs[$d->ano_eje]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ]['t']                                           = Presupuesto::agregar($prs[$d->ano_eje][$d->fuente_financ]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ]['t']->desc1                                    = $fuente[$d->fuente_financ];
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func]['t']                             = Presupuesto::agregar($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func]['t']->desc1                      = $d->sec_func . " - " . $d->COMPONENTE_NOMBRE;
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador]['t']        = Presupuesto::agregar((object)$new, $d);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador]['t']->desc1 = ($d->ano_eje>=2009)?$especificas[$d->id_clasificador]: $elemento[$d->id_clasificador];
                        }
                    }
                }
                break;
            case 2: {
                    foreach ($presupuesto->get() as $d) {
                        if ($d->pim > 0) {
                            if (!isset($prs[$d->ano_eje]))
                                $prs[$d->ano_eje] = ['t' => (object)$new];
                            if (!isset($prs[$d->ano_eje][$d->sec_func]))
                                $prs[$d->ano_eje][$d->sec_func] = ['t' => (object)$new];
                            if (!isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ]))
                                $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ] = ['t' => (object)$new];
                            $prs[$d->ano_eje]['t']                                                              = Presupuesto::agregar($prs[$d->ano_eje]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func]['t']                                                = Presupuesto::agregar($prs[$d->ano_eje][$d->sec_func]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func]['t']->desc1                                         = $d->sec_func . " - " . $d->COMPONENTE_NOMBRE;
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ]['t']                             = Presupuesto::agregar($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ]['t']->desc1                      = $fuente[$d->fuente_financ];
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador]['t']        = Presupuesto::agregar((object)$new, $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador]['t']->desc1 = ($d->ano_eje >= 2009) ? $especificas[$d->id_clasificador] : $elemento[$d->id_clasificador];
                        }
                    }
                }
                break;
            case 3: {
                    foreach ($presupuesto->get() as $d) {
                        if ($d->pim > 0) {
                            if (!isset($prs[$d->ano_eje]))
                                $prs[$d->ano_eje] = ['t' => (object)$new];
                            if (!isset($prs[$d->ano_eje][$d->sec_func]))
                                $prs[$d->ano_eje][$d->sec_func] = ['t' => (object)$new];
                            if (!isset($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador]))
                                $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador] = ['t' => (object)$new];

                            $prs[$d->ano_eje]['t']                                                              = Presupuesto::agregar($prs[$d->ano_eje]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func]['t']                                                = Presupuesto::agregar($prs[$d->ano_eje][$d->sec_func]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func]['t']->desc1                                         = $d->sec_func . " - " . $d->COMPONENTE_NOMBRE;
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador]['t']                           = Presupuesto::agregar($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador]['t']->desc1                    = $especificas[$d->id_clasificador];
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ]['t']        = Presupuesto::agregar((object)$new, $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ]['t']->desc1 = ($d->ano_eje >= 2009) ? $especificas[$d->id_clasificador] : $elemento[$d->id_clasificador];
                        }
                    }
                }
                break;
        }

        return $prs;
    }

    static function agregar($to, $from)
    {
        $to->monto_pim  += $from->pim;
        $to->monto_cert += $from->monto_cert;
        $to->monto_comp += $from->monto_comp;
        $to->monto_dev  += $from->monto_dev;
        $to->g_1        += $from->g_1;
        $to->g_2        += $from->g_2;
        $to->g_3        += $from->g_3;
        $to->g_4        += $from->g_4;
        $to->g_5        += $from->g_5;
        $to->g_6        += $from->g_6;
        $to->g_7        += $from->g_7;
        $to->g_8        += $from->g_8;
        $to->g_9        += $from->g_9;
        $to->g_10       += $from->g_10;
        $to->g_11       += $from->g_11;
        $to->g_12       += $from->g_12;
        return $to;
    }

    public static function getPresupuestoForProyFftt($anio, $proy, $fftt)
    {
        $presupuesto = Presupuesto::select([
            'componente',
            'act_proy',
            'fuente_financ',
            'id_clasificador',
            'pia',
            'modif',
            \DB::raw('sum(pia) AS pia'),
            \DB::raw('sum(modif) AS modif'),
            \DB::raw('sum(pim) AS pim'),
        ])
            ->where('ano_eje', '=', $anio)
            ->where('act_proy', '=', $proy)
            ->where('fuente_financ', '=', $fftt)
            ->groupBy('componente')
            ->groupBy('id_clasificador')
            ->groupBy('fuente_financ')
            ->groupBy('act_proy')
            ->groupBy('pia')
            ->groupBy('modif')
            ->groupBy('pim');
        $prs         = ['t' => 0];
        foreach ($presupuesto->get() as $d) {
            if (!isset($prs[$d->componente]))
                $prs[$d->componente] = ['t' => 0];
            $prs['t']                                 += $d->pim;
            $prs[$d->componente]['t']                 += $d->pim;
            $prs[$d->componente][$d->id_clasificador] = $d;
        }
        return $prs;
    }

    public static function getPresupuestoResumen($anio, $oficina = null, $act_proy = 'all')
    {
        $oficinas = [];
        $where    = [['ano_eje', '=', $anio]];

        $reporte = Presupuesto::select([
            DB::raw('Sum(pim) AS pim'),
        ])
            ->where($where);
        if ($act_proy != 'all')
            $reporte->whereIn('act_proy', explode(',', $act_proy));
        if ($oficina != null) {
            $reporte
                ->leftJoin('proy_presupuesto', function ($leftJoin) {
                    $leftJoin->on('ano_eje', '=', 'proy_presupuesto.proy_siaf_anio')
                        ->on('sec_ejec', '=', 'proy_presupuesto.proy_sec_ejec')
                        ->on('sec_func', '=', 'proy_presupuesto.proy_siaf_sec_func');
                })
                ->where('proy_tram_dependencia', '=', $oficina);
        }

        return $reporte->first();
    }
}
