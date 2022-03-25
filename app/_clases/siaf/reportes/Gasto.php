<?php

namespace App\_clases\siaf\reportes;

use Cache;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;

/**
 * App\_clases\siaf\reportes\Gasto
 *
 * @property string|null $ANO_EJE
 * @property string|null $SEC_EJEC
 * @property string|null $act_proy
 * @property string|null $SEC_FUNC
 * @property string|null $FUENTE_FIN
 * @property string|null $EXPEDIENTE
 * @property string|null $CICLO
 * @property string|null $FASE
 * @property string|null $SECUENCIA_E
 * @property string|null $CERTIFICAD
 * @property string|null $SECUENCIA_C
 * @property string|null $ID_CLASIFI
 * @property float|null $MONTO
 * @property string|null $RUC
 * @property string|null $MEJOR_FECH
 * @property string|null $mes
 * @property string|null $SECUENCIA_
 * @property string|null $NOTAS
 * @property string|null $cps
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereACTPROY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereCERTIFICAD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereCICLO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereCps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereEXPEDIENTE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereFASE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereFUENTEFIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereIDCLASIFI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereMEJORFECH($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereMONTO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereMes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereNOTAS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereRUC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereSECEJEC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereSECFUNC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereSECUENCIA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereSECUENCIAC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Gasto whereSECUENCIAE($value)
 * @mixin \Eloquent
 */
class Gasto extends Model
{
    protected $table = 'siaf_wgastos';

    public $timestamps = false;

    protected $casts = [
        'monto' => 'double',
    ];
    protected $dates = [
        'fecha_autorizacion',
    ];

    public static function getDevengadoResumenCached($anio, $oficina = 0, $act_proy = 'all')
    {
        return Cache::remember('devengadoResumen', 900, function () use ($anio, $oficina, $act_proy) {
            return Gasto::getDevengadoResumen($anio, $oficina, $act_proy);
        });
    }

    public static function getDevengadoResumen($anio, $oficina = 0, $act_proy = 'all')
    {
        $oficinas = [
        ];
        $reporte  = Gasto::select([
            DB::raw('Sum(monto) AS monto'),
            'fecha_autorizacion',
        ])
            ->where('sec_ejec', '=', config('proyectos.unidad_ejecutora'))
            ->where('ano_eje', '=', $anio)
            ->where('ciclo', '=', 'G')
            ->where('fase', '=', 'D')
            ->groupBy('fecha_autorizacion')
            ->groupBy('monto');
        if ($act_proy != 'all')
            $reporte->whereIn('act_proy', explode(',', $act_proy));
        return $reporte->get();
    }


    public static function getGastos($anio, $oficina = null, $act_proy = 'all', $girado)
    {
        $where = [
            ['ano_eje', '=', $anio],
            ['ciclo', '=', 'G']
        ];
        if($girado){
            $where[] = ['fase', '=', 'G'];
        } else {
            $where[] = ['fase', '=', 'D'];
        }

        $gastos = Gasto::select([DB::raw('sum(monto) as monto'), 'mes', 'dia', 'fecha_autorizacion'])
            ->where($where)
            ->groupBy('mes')
            ->groupBy('dia')
            ->groupBy('fecha_autorizacion');
        if ($act_proy != 'all')
            $gastos->whereIn('act_proy', explode(',', $act_proy));
        if ($oficina != null) {
            $gastos
                ->leftJoin('proy_presupuesto', function ($leftJoin) {
                    $leftJoin->on('ano_eje', '=', 'proy_presupuesto.proy_siaf_anio')
                        ->on('sec_ejec', '=', 'proy_presupuesto.proy_sec_ejec')
                        ->on('sec_func', '=', 'proy_presupuesto.proy_siaf_sec_func');
                })
                ->where('proy_tram_dependencia', '=', $oficina);
        }

        return $gastos->get();
    }

    public static function informacionDiaria(Collection $gastos)
    {
        $gastos = $gastos->groupBy(function ($item, $key) {
            return $item['mes'];
        });
        $gastos->each(function (Collection $item, $key) use ($gastos) {
            $item = $item->groupBy(function ($item, $key) {
                return $item['dia'];
            });

            $item->each(function (Collection $item2, $key2) use ($item) {

                $item[$key2] = $item2->sum('monto');
            });

            $gastos[$key] = $item;

        });


        return $gastos;
    }


    public static function getCompromisosForGastos($anio, $fuente, $funcion, $clasi, $cert, $secuencia, $secuencia_c)
    {
        $where = [
            ['sec_ejec', '=', config('proyectos.unidad_ejecutora')],
            ['ano_eje', '=', $anio],
            ['fuente_financ', '=', $fuente],
            ['sec_func', '=', $funcion],
            ['id_clasificador', '=', $clasi],
        ];
        if ($cert != 'null') {
            $where[] = ['certificado', '=', $cert];
            $where[] = ['certificado_secuencia_padre', '=', $secuencia];
            $where[] = ['certificado_secuencia', '=', $secuencia_c];
        }

        $gasto = \DB::table('siaf_wgastos')
            ->select([
                'siaf_wgastos.ano_eje',
                'siaf_wgastos.sec_ejec',
                'siaf_wgastos.act_proy',
                'siaf_wgastos.sec_func',
                'siaf_wgastos.fuente_financ',
                'siaf_wgastos.expediente',
                'siaf_wgastos.secuencia',
                'siaf_wgastos.id_clasificador',
                'siaf_wgastos.certificado',
                'siaf_wgastos.certificado_secuencia',
                'siaf_wgastos.certificado_secuencia_padre',
                'siaf_wgastos.notas',
                'siaf_wgastos.monto',
                'siaf_wgastos.fecha_autorizacion',
                'siaf_wgastos.mes',
                'siaf_wgastos.cps',
                'siaf_wgastos.ruc',
                'siaf_persona.nombre',
            ])
            ->leftJoin('siaf_persona', 'siaf_persona.ruc', '=', 'siaf_wgastos.ruc')
            ->where($where)
            ->orderBy('ano_eje', 'DESC');

        $new    = [
            'type'            => 'gasto',
            'ano_eje'         => $anio,
            'sec_func'        => $funcion,
            'fuente_financ'   => $fuente,
            'id_clasificador' => $clasi,
            'cert'            => $cert . '_' . $secuencia,
            'compromiso'      => $secuencia_c,
            'expediente'      => '',
            'desc2'           => '',
            'desc3'           => '',
            'monto_pim'       => (float)0,
            'monto_cert'      => (float)0,
            'monto_comp'      => (float)0,
            'monto_dev'       => (float)0,
            'g_1'             => (float)0,
            'g_2'             => (float)0,
            'g_3'             => (float)0,
            'g_4'             => (float)0,
            'g_5'             => (float)0,
            'g_6'             => (float)0,
            'g_7'             => (float)0,
            'g_8'             => (float)0,
            'g_9'             => (float)0,
            'g_10'            => (float)0,
            'g_11'            => (float)0,
            'g_12'            => (float)0,
            'g_tot'           => (float)0,
        ];
        $gastos = [];
        foreach ($gasto->get() as $d) {
            $id = $d->expediente;//.'_'.$d->secuencia;
            if ($d->monto > 0) {
                if (!isset($gastos[$id]))
                    $gastos[$id] = (object)$new;
                $gastos[$id]             = Gasto::agregar($gastos[$id], $d);
                $gastos[$id]->expediente = $id;
                $gastos[$id]->nota_d     = $d->notas;
                $gastos[$id]->fecha      = $d->fecha_autorizacion;
                $gastos[$id]->cps        = $d->cps;
                $gastos[$id]->proveedor  = $d->ruc . ' - ' . $d->nombre;
            }
        }
        return $gastos;
    }

    public static function getGastosForCompromiso($gastos, $anio, $fuente, $funcion, $clasi, $cert, $secuencia)
    {
        $where = [
            ['sec_ejec', '=', config('proyectos.unidad_ejecutora')],
            ['ano_eje', '=', $anio],
            ['fuente_financ', '=', $fuente],
            ['sec_func', '=', $funcion],
            ['id_clasificador', '=', $clasi],
        ];
        if ($cert != 'null') {
            $where[] = ['certificado', '=', $cert];
            $where[] = ['certificado_secuencia_padre', '=', $secuencia];
        }

        $gasto = Gasto::select(['*'])
            ->where($where)
            ->orderBy('ano_eje', 'DESC');

        $new = [
            'type'                        => 'gasto',
            'ano_eje'                     => $anio,
            'sec_func'                    => $funcion,
            'fuente_financ'               => $fuente,
            'id_clasificador'             => $clasi,
            'cert'                        => $cert . '_' . $secuencia,
            'certificado_secuencia_padre' => $secuencia,
            'compromiso'                  => '',
            'expediente_siaf'             => null,
            'concepto'                    => '',
            'monto_pim'                   => (float)0,
            'monto_cert'                  => (float)0,
            'monto_comp'                  => (float)0,
            'monto_dev'                   => (float)0,
            'g_1'                         => (float)0,
            'g_2'                         => (float)0,
            'g_3'                         => (float)0,
            'g_4'                         => (float)0,
            'g_5'                         => (float)0,
            'g_6'                         => (float)0,
            'g_7'                         => (float)0,
            'g_8'                         => (float)0,
            'g_9'                         => (float)0,
            'g_10'                        => (float)0,
            'g_11'                        => (float)0,
            'g_12'                        => (float)0,
            'g_tot'                       => (float)0,
        ];
        foreach ($gasto->get() as $d) {
            $id = $d->certificado_secuencia;
            if ($d->monto > 0) {
                if ($id != '') {
                    if (!isset($gastos[$id]))
                        $gastos[$id] = (object)$new;
                    $gastos[$id] = Gasto::agregar($gastos[$id], $d);
                } else {
                    $id                      = 'null';
                    $gastos[$id]             = (object)$new;
                    $gastos[$id]             = Gasto::agregar($gastos[$id], $d);
                    $gastos[$id]->compromiso = 0;
                    $gastos[$id]->concepto   = "-------";
                }
            }
        }
        return $gastos;
    }

    public static function getGastosForCertificado($gastos, $anio, $fuente, $funcion, $clasi)
    {
        $where = [
            ['sec_ejec', '=', config('proyectos.unidad_ejecutora')],
            ['ano_eje', '=', $anio],
            ['fuente_financ', '=', $fuente],
            ['sec_func', '=', $funcion],
            ['id_clasificador', '=', $clasi],
        ];

        $gasto = Gasto::select(['*'])
            ->where($where)
            ->orderBy('ano_eje', 'DESC');

        $new = [
            'type'            => 'gasto',
            'ano_eje'         => $anio,
            'sec_func'        => $funcion,
            'fuente_financ'   => $fuente,
            'id_clasificador' => $clasi,
            'concepto'        => '',
            'cert'            => '',
            'monto_pim'       => (float)0,
            'monto_cert'      => (float)0,
            'monto_comp'      => (float)0,
            'monto_dev'       => (float)0,
            'g_1'             => (float)0,
            'g_2'             => (float)0,
            'g_3'             => (float)0,
            'g_4'             => (float)0,
            'g_5'             => (float)0,
            'g_6'             => (float)0,
            'g_7'             => (float)0,
            'g_8'             => (float)0,
            'g_9'             => (float)0,
            'g_10'            => (float)0,
            'g_11'            => (float)0,
            'g_12'            => (float)0,
        ];
        foreach ($gasto->get() as $d) {
            $id = $d->certificado . '_' . $d->certificado_secuencia_padre;
            if ($d->monto > 0) {
                if ($id != '_') {
                    if (!isset($gastos[$id]))
                        $gastos[$id] = (object)$new;
                    $gastos[$id] = Gasto::agregar($gastos[$id], $d);
                } else {
                    $id                    = 'null-null';
                    $gastos[$id]           = (object)$new;
                    $gastos[$id]           = Gasto::agregar($gastos[$id], $d);
                    $gastos[$id]->concepto = "-------";
                    $gastos[$id]->cert     = 0;
                }
            }
        }
        return $gastos;
    }

    public static function getGastosForProyAll($to, $proy, $formato)
    {
        $where = [['sec_ejec', '=', config('proyectos.unidad_ejecutora')], ['act_proy', '=', $proy], ['fase', '=', 'D']];

        $gasto = \DB::table('siaf_wgastos')
            ->select([
                'siaf_wgastos.ano_eje',
                'siaf_wgastos.sec_ejec',
                'siaf_wgastos.act_proy',
                'siaf_wgastos.sec_func',
                'siaf_wgastos.fuente_financ',
                'siaf_wgastos.expediente',
                'siaf_wgastos.secuencia',
                'siaf_wgastos.id_clasificador',
                'siaf_wgastos.certificado',
                'siaf_wgastos.certificado_secuencia',
                'siaf_wgastos.certificado_secuencia_padre',
                'siaf_wgastos.notas',
                'siaf_wgastos.monto',
                'siaf_wgastos.fecha_autorizacion',
                'siaf_wgastos.mes',
                'siaf_wgastos.cps',
                'siaf_wgastos.ruc',
                'siaf_persona.nombre',
            ])
            ->leftJoin('siaf_persona', 'siaf_persona.ruc', '=', 'siaf_wgastos.ruc')
            ->where($where)
            ->orderBy('ano_eje', 'DESC');

        $new = [
            'type'       => 'gasto',
            'expediente' => '',
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
        ];
        $prs = $to;
        switch ($formato) {
            default:
            case 1:
                {
                    foreach ($gasto->get() as $d) {
                        if ($d->monto > 0) {
                            $id   = $d->certificado . '-' . $d->certificado_secuencia_padre;
                            $id2  = $d->certificado . '-' . $d->certificado_secuencia;
                            $id_e = $d->expediente . '-' . $d->secuencia;
                            if (!isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]))
                                $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id] = ['t' => Certificado::getNewObject()];
                            if (!isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2]))
                                $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2] = ['t' => Compromiso::getNewObject()];
                            if (isset($prs[$d->ano_eje]) && isset($prs[$d->ano_eje][$d->fuente_financ]) &&
                                isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func]) &&
                                isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador]) &&
                                isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]) &&
                                isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2]))
                                $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2][$id_e] = ['t' => (object)$new];
                            //echo $d->ano_eje." > ".$d->fuente_financ." > ".$d->sec_func." > ".$d->id_clasificador." > ".$id." > ".$id2." > ".$id_e;
                            //dd($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador]);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2][$id_e]['t']             = Gasto::agregar($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2][$id_e]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2]['t']                    = Gasto::agregar($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t']                          = Gasto::agregar($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2][$id_e]['t']->expediente = $id_e;
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2][$id_e]['t']->nota_d     = $d->notas;
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2][$id_e]['t']->fecha      = $d->fecha_autorizacion;
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2][$id_e]['t']->cps        = $d->cps;
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2][$id_e]['t']->proveedor  = $d->ruc . ' - ' . $d->nombre;

                        }
                    }
                }
                break;
            case 2:
                {
                    foreach ($gasto->get() as $d) {
                        if ($d->monto > 0) {
                            $id  = $d->certificado . '-' . $d->certificado_secuencia_padre;
                            $id2 = $d->certificado . '-' . $d->SECUENCIA;
                            if (isset($prs[$d->ano_eje]) &&
                                isset($prs[$d->ano_eje][$d->sec_func]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]))
                                $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2] = ['t' => (object)$new];
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2]['t']             = Compromiso::agregar($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t']                   = Compromiso::agregar($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2]['t']->compromiso = "$d->nombre - $d->NUM_DOC";
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2]['t']->concepto   = $d->CONCEPTO;
                        }
                    }
                }
                break;
            case 3:
                {
                    foreach ($gasto->get() as $d) {
                        if ($d->monto > 0) {
                            $id  = $d->certificado . '-' . $d->certificado_secuencia_padre;
                            $id2 = $d->certificado . '-' . $d->SECUENCIA;
                            if (isset($prs[$d->ano_eje]) &&
                                isset($prs[$d->ano_eje][$d->sec_func]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ]))
                                $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->id_clasificador][$id][$id2] = ['t' => (object)$new];
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id][$id2]['t']             = Compromiso::agregar($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id][$id2]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t']                   = Compromiso::agregar($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id][$id2]['t']->compromiso = "$d->nombre - $d->NUM_DOC";
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id][$id2]['t']->concepto   = $d->CONCEPTO;
                        }
                    }
                }
                break;
        }
        return $prs;
    }

    static function agregar($to, $from)
    {
        $to->monto_dev += $from->monto;
        switch ($from->mes) {
            case 1:
                {
                    $to->g_1 += $from->monto;
                }
                break;
            case 2:
                {
                    $to->g_2 += $from->monto;
                }
                break;
            case 3:
                {
                    $to->g_3 += $from->monto;
                }
                break;
            case 4:
                {
                    $to->g_4 += $from->monto;
                }
                break;
            case 5:
                {
                    $to->g_5 += $from->monto;
                }
                break;
            case 6:
                {
                    $to->g_6 += $from->monto;
                }
                break;
            case 7:
                {
                    $to->g_7 += $from->monto;
                }
                break;
            case 8:
                {
                    $to->g_8 += $from->monto;
                }
                break;
            case 9:
                {
                    $to->g_9 += $from->monto;
                }
                break;
            case 10:
                {
                    $to->g_10 += $from->monto;
                }
                break;
            case 11:
                {
                    $to->g_11 += $from->monto;
                }
                break;
            case 12:
                {
                    $to->g_12 += $from->monto;
                }
                break;
        }
        return $to;
    }

    public static function getCompromisosMes($anio, $oficina = null, $act_proy = 'all', $show, $notas, $cuentaCorriente, $anulaciones)
    {
        $where = [
            ['ano_eje', '=', $anio],
            ['ciclo', '=', 'G'],
            ['fase', '=', 'C'],
        ];
        if ($notas != null || $notas != '')
            $where[] = ['notas', 'LIKE', "%" . str_replace(" ", "%", $notas) . "%"];
        if (!$cuentaCorriente || $cuentaCorriente == 'false') {
            $where[] = ['act_proy', '<>', '3999999'];
        } else {
            $where[] = ['act_proy', '=', '3999999'];
        }

        if (!$anulaciones || $anulaciones == 'false') {
            $where[] = ['monto', '>', 0];
        } else {
            $where[] = ['monto', '<', 0];
        }

        $reporte = Gasto::select([
            'ano_eje',
            'sec_func',
            'act_proy',
            'expediente',
            'certificado',
            'certificado_secuencia',
            'id_clasificador',
            'monto',
            'fecha_autorizacion',
            'mes',
            'notas',
        ])
            ->where($where)
            ->orderBy('fecha_autorizacion', 'DESC')
            ->take($show);
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
        return $reporte->get();
    }

    public static function getDevengados($anio, $oficina = null, $act_proy = 'all', $show, $notas, $cuentaCorriente, $anulaciones, $girado)
    {
        $where = [
            ['ano_eje', '=', $anio],
            ['ciclo', '=', 'G']
        ];
        if($girado){
            $where[] = ['fase', '=', 'G'];
        } else {
            $where[] = ['fase', '=', 'D'];
        }
        if ($notas != null || $notas != '')
            $where[] = ['notas', 'LIKE', "%" . str_replace(" ", "%", $notas) . "%"];
        if (!$cuentaCorriente || $cuentaCorriente == 'false') {
            $where[] = ['act_proy', '<>', '3999999'];
        } else {
            $where[] = ['act_proy', '=', '3999999'];
        }

        if (!$anulaciones || $anulaciones == 'false') {
            $where[] = ['monto', '>', 0];
        } else {
            $where[] = ['monto', '<', 0];
        }

        $reporte = Gasto::select([
            'ano_eje',
            'sec_func',
            'act_proy',
            'expediente',
            'certificado',
            'certificado_secuencia',
            'id_clasificador',
            'monto',
            'fecha_autorizacion',
            'mes',
            'notas',
            'cps',
        ])
            ->where($where)
            ->orderBy('fecha_autorizacion', 'DESC')
            ->take($show);
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
        return $reporte->get();
    }

    //ASCENSORS

    /**
     * Get the user's full name.
     *
     * @return int
     */
    public function getDayAttribute()
    {
        return $this->fecha_autorizacion->day;
    }

    public static function getPresupuestoGastoProyectos()
    {
        //girados
        $where = [
            ['ciclo', '=', 'G'],
            ['fase', '=', 'G']
        ];


        $gastos = Gasto::select([DB::raw('sum(monto) as monto'), 'ano_eje','act_proy'])
            ->where($where)
            ->groupBy('ano_eje')
            ->groupBy('act_proy')
            ->orderBy('ano_eje', 'asc')
            ->get();

        $presupuesto = Presupuesto::select([
            DB::raw('Sum(pim) AS pim'),
            'ano_eje',
            'act_proy'
        ])
            ->groupBy('ano_eje')
            ->groupBy('act_proy')
            ->orderBy('ano_eje', 'asc')
            ->get();

            return response()->json(['gastos' => $gastos, 'presupuesto' => $presupuesto]);
    }
}
