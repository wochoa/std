<?php

namespace App\_clases\siaf\reportes;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

/**
 * App\_clases\siaf\reportes\Compromiso
 *
 * @property string|null $ANO_EJE
 * @property string|null $SEC_EJEC
 * @property string|null $act_proy
 * @property string|null $SEC_FUNC
 * @property string|null $FUENTE_FIN
 * @property string|null $CERTIFICAD
 * @property string|null $SECUENCIA
 * @property string|null $SECUENCIA_
 * @property string|null $ID_CLASIFI
 * @property float|null $MONTO
 * @property string|null $COD_DOC
 * @property string|null $NOMBRE
 * @property string|null $NUM_DOC
 * @property string|null $CONCEPTO
 * @property string|null $FECHA_DOC
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereACTPROY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereCERTIFICAD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereCODDOC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereCONCEPTO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereFECHADOC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereFUENTEFIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereIDCLASIFI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereMONTO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereNOMBRE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereNUMDOC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereSECEJEC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereSECFUNC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Compromiso whereSECUENCIA($value)
 * @mixin \Eloquent
 */
class Compromiso extends Model
{
    protected $table = 'proy_siaf_comp';

    public $timestamps = false;

    protected $casts = [
        'monto' => 'double',
    ];
    protected $dates = [
        'fecha_doc',
    ];

    public static function getCompromisosForGastos($anio, $fuente, $funcion, $clasi, $cert, $secuencia)
    {
        $where = [
            ['sec_ejec', '=', config('proyectos.unidad_ejecutora')],
            ['ano_eje', '=', $anio],
            ['fuente_financ', '=', $fuente],
            ['sec_func', '=', $funcion],
            ['id_clasificador', '=', $clasi],
            ['certificado', '=', $cert],
            ['secuencia_padre', '=', $secuencia],
        ];

        $certificados = Compromiso::select(['*'])
            ->where($where)
            ->orderBy('secuencia', 'ASC');

        $new = array(
            'type'            => 'gasto',
            'ano_eje'         => $anio,
            'sec_func'        => $funcion,
            'fuente_financ'   => $fuente,
            'id_clasificador' => $clasi,
            'secuencia_padre' => $secuencia,
            'cert'            => $cert . '_' . $secuencia,
            'compromiso'      => '',
            'expediente_siaf' => null,
            'contrato'        => '',
            'concepto'        => '',
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
        );
        $cert = [];
        foreach ($certificados->get() as $d) {
            $id = $d->secuencia;
            if ($d->monto > 0) {
                if (!isset($cert[$id]))
                    $cert[$id] = (object)$new;
                $cert[$id] = Compromiso::agregar($cert[$id], $d);
                $cert[$id]->compromiso = $id;
                $cert[$id]->contrato = "$d->nombre - $d->num_doc";
                $cert[$id]->concepto = $d->glosa;
            }
        }
        return $cert;
    }

    public static function getCompromisosForCertificado($to, $anio, $fuente, $funcion, $clasi)
    {
        $where = [
            ['sec_ejec', '=', config('proyectos.unidad_ejecutora')],
            ['ano_eje', '=', $anio],
            ['fuente_financ', '=', $fuente],
            ['sec_func', '=', $funcion],
            ['id_clasificador', '=', $clasi],
        ];

        $certificados = Compromiso::select(['*'])
            ->where($where)
            ->orderBy('secuencia', 'ASC');

        $new = array(
            'type'            => 'gasto',
            'ano_eje'         => $anio,
            'sec_func'        => $funcion,
            'fuente_financ'   => $fuente,
            'id_clasificador' => $clasi,
            'compromiso'      => '',
            'concepto'        => '',
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
        );
        $cert = $to;
        foreach ($certificados->get() as $d) {
            $id = $d->certificado . '_' . $d->secuencia_padre;
            if ($d->monto > 0) {
                if (!isset($cert[$id]))
                    $cert[$id] = (object)$new;
                $cert[$id] = Compromiso::agregar($cert[$id], $d);
            }
        }
        return $cert;
    }

    public static function getCompromisosForProyAll($to, $proy, $formato)
    {
        $where = [['sec_ejec', '=', config('proyectos.unidad_ejecutora')], ['act_proy', '=', $proy]];
        $certificados = Compromiso::select(['*'])
            ->where($where)
            ->orderBy('ano_eje', 'ASC')
            ->orderBy('fuente_financ', 'ASC')
            ->orderBy('sec_func', 'ASC')
            ->orderBy('id_clasificador', 'ASC')
            ->orderBy('certificado', 'ASC')
            ->orderBy('secuencia', 'ASC')
            ->orderBy('secuencia_padre', 'ASC');

        $new = array(
            'type'       => 'gasto',
            'compromiso' => '',
            'concepto'   => '',
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
        );
        $prs = $to;
        switch ($formato) {
            default:
            case 1:
                {
                    foreach ($certificados->get() as $d) {
                        if ($d->monto > 0) {
                            $id = $d->certificado . '-' . $d->secuencia_padre;
                            $id2 = $d->certificado . '-' . $d->secuencia;
                            if (isset($prs[$d->ano_eje]) && isset($prs[$d->ano_eje][$d->fuente_financ]) &&
                                isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func]) &&
                                isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador]) &&
                                isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]))
                                $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2] = ['t' => (object)$new];
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2]['t'] = Compromiso::agregar($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t'] = Compromiso::agregar($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2]['t']->compromiso = "$d->nombre - $d->num_doc";
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id][$id2]['t']->concepto = $d->glosa;
                        }
                    }
                }
                break;
            case 2:
                {
                    foreach ($certificados->get() as $d) {
                        if ($d->monto > 0) {
                            $id = $d->certificado . '-' . $d->secuencia_padre;
                            $id2 = $d->certificado . '-' . $d->secuencia;
                            if (isset($prs[$d->ano_eje]) &&
                                isset($prs[$d->ano_eje][$d->sec_func]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]))
                                $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2] = ['t' => (object)$new];
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2]['t'] = Compromiso::agregar($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t'] = Compromiso::agregar($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2]['t']->compromiso = "$d->nombre - $d->num_doc";
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id][$id2]['t']->concepto = $d->glosa;
                        }
                    }
                }
                break;
            case 3:
                {
                    foreach ($certificados->get() as $d) {
                        if ($d->monto > 0) {
                            $id = $d->certificado . '-' . $d->secuencia_padre;
                            $id2 = $d->certificado . '-' . $d->secuencia;
                            if (isset($prs[$d->ano_eje]) &&
                                isset($prs[$d->ano_eje][$d->sec_func]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ]))
                                $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->id_clasificador][$id][$id2] = ['t' => (object)$new];
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id][$id2]['t'] = Compromiso::agregar($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id][$id2]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t'] = Compromiso::agregar($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id][$id2]['t']->compromiso = "$d->nombre - $d->num_doc";
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id][$id2]['t']->concepto = $d->glosa;
                        }
                    }
                }
                break;
        }
        return $prs;
    }

    public static function getNewObject()
    {
        $new = array(
            'type'       => 'gasto',
            'compromiso' => '',
            'concepto'   => '',
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
        );
        return (object)$new;
    }

    static function agregar($to, $from)
    {
        $to->monto_comp += $from->monto;
        return $to;
    }

    public static function getCompromisoResumen($anio, $oficina = null, $act_proy = 'all', $sec_ejec)
    {
        $oficinas = [
        ];
        $reporte = Compromiso::from('proy_siaf_comp AS c')
            ->select([
                DB::raw('Sum(monto) AS monto'),
                'c.fecha_doc',
            ])
            ->where('c.sec_ejec', '=', $sec_ejec)
            ->where('c.ano_eje', '=', $anio)
            ->groupBy('fecha_doc');
        if ($act_proy != 'all')
            $reporte->whereIn('c.act_proy', explode(',', $act_proy));
        if($oficina!=null){
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

    public static function getCompromisosAnual($anio, $oficina = null, $act_proy = 'all', $show, $notas, $cuentaCorriente, $anulaciones)
    {
        $where = [
            ['ano_eje', '=', $anio],
        ];
        if ($notas != null || $notas != '')
            $where[] = ['glosa', 'LIKE', "%" . str_replace(" ", "%", $notas) . "%"];
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

        $compromiso = Compromiso::select([
            'ano_eje',
            'act_proy',
            'sec_func',
            'certificado',
            'secuencia',
            'secuencia_padre',
            'id_clasificador',
            'monto',
            'nombre',
            'num_doc',
            'glosa',
            'fecha_doc',
        ])
            ->where($where)
            ->orderBy('fecha_doc', 'desc')
            ->take($show);
        if ($act_proy != 'all')
            $compromiso->whereIn('act_proy', explode(',', $act_proy));
        if($oficina!=null){
            $compromiso
                ->leftJoin('proy_presupuesto', function ($leftJoin) {
                    $leftJoin->on('ano_eje', '=', 'proy_presupuesto.proy_siaf_anio')
                        ->on('sec_ejec', '=', 'proy_presupuesto.proy_sec_ejec')
                        ->on('sec_func', '=', 'proy_presupuesto.proy_siaf_sec_func');
                })
                ->where('proy_tram_dependencia', '=', $oficina);
        }
        return $compromiso->get();
    }
}
