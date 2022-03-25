<?php

namespace App\_clases\siaf\reportes;

use App\_clases\siaf\FuenteFinanciamiento;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

/**
 * App\_clases\siaf\reportes\Certificado
 *
 * @property string|null $ANO_EJE
 * @property string|null $SEC_EJEC
 * @property string|null $SEC_FUNC
 * @property string|null $act_proy
 * @property string|null $CERTIFICADO
 * @property string|null $CORRELATIV
 * @property string|null $ID_CLASIFI
 * @property string|null $FUENTE_FIN
 * @property string|null $SECUENCIA
 * @property string|null $SECUENCIA_
 * @property string|null $ESTADO_REG
 * @property string|null $DISPOSIT_COD
 * @property string|null $GLOSA
 * @property string|null $FECHA
 * @property string|null $NUM_DOC
 * @property float|null $MONTO
 * @property float|null $COMPROMETI
 * @property string|null $DISPOSITIVO
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereACTPROY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereCERTIFICADO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereCOMPROMETI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereCORRELATIV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereDISPOSITCOD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereDISPOSITIVO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereESTADOREG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereFECHA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereFUENTEFIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereGLOSA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereIDCLASIFI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereMONTO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereNUMDOC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereSECEJEC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereSECFUNC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Certificado whereSECUENCIA($value)
 * @mixin \Eloquent
 */
class Certificado extends Model
{
    protected $table = 'siaf_wcert';

    public $timestamps = false;

    protected $casts = [
        'monto' => 'double',
    ];

    public static function getCertificadosForGastos($anio, $fuente, $funcion, $clasi)
    {
        $where = [
            ['sec_ejec', '=', config('proyectos.unidad_ejecutora')],
            ['ano_eje', '=', $anio],
            ['fuente_financ', '=', $fuente],
            ['sec_func', '=', $funcion],
            ['id_clasificador', '=', $clasi],
        ];

        $certificados = Certificado::select(['*'])
            ->where($where)
            ->orderBy('certificado', 'ASC')
            ->orderBy('secuencia', 'ASC');

        $new = [
            'type'            => 'gasto',
            'ano_eje'         => $anio,
            'sec_func'        => $funcion,
            'fuente_financ'   => $fuente,
            'id_clasificador' => $clasi,
            'concepto'        => '',
            'compromiso'      => null,
            'expediente_siaf' => null,
            'cert'            => '',
            'dispositivo'     => '',
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
        $cert = [];
        foreach ($certificados->get() as $d) {
            $id = $d->certificado . '_' . $d->secuencia;
            if ($d->monto > 0) {
                if (!isset($cert[$id]))
                    $cert[$id] = (object)$new;
                $cert[$id] = Certificado::agregar($cert[$id], $d);
                $cert[$id]->concepto = $d->glosa;
                $cert[$id]->dispositivo = $d->dispositivo;
                $cert[$id]->cert = "$id";
            }
        }
        return $cert;
    }

    public static function getCertificadosForProyAll($prs, $proy, $formato)
    {
        $where = [['sec_ejec', '=', config('proyectos.unidad_ejecutora')], ['act_proy', '=', $proy]];
        $certificados = Certificado::select([
            'ano_eje',
            'fuente_financ',
            'sec_func',
            'id_clasificador',
            'certificado',
            'secuencia',
            'glosa',
            'dispositivo',
            \DB::raw('Sum(siaf_wcert.monto) AS monto'),
        ])
            ->where($where)
            ->orderBy('ano_eje', 'ASC')
            ->orderBy('fuente_financ', 'ASC')
            ->orderBy('sec_func', 'ASC')
            ->orderBy('id_clasificador', 'ASC')
            ->orderBy('certificado', 'ASC')
            ->orderBy('secuencia', 'ASC')

            ->groupBy('ano_eje')
            ->groupBy('sec_ejec')
            ->groupBy('sec_func')
            ->groupBy('fuente_financ')
            ->groupBy('certificado')
            ->groupBy('id_clasificador')
            ->groupBy('secuencia')
            ->groupBy('glosa')
            ->groupBy('dispositivo');

        $new = [
            'type'        => 'gasto',
            'concepto'    => '',
            'certificado' => '',
            'dispositivo' => '',
            'monto_pim'   => (float)0,
            'monto_cert'  => (float)0,
            'monto_comp'  => (float)0,
            'monto_dev'   => (float)0,
            'g_1'         => (float)0,
            'g_2'         => (float)0,
            'g_3'         => (float)0,
            'g_4'         => (float)0,
            'g_5'         => (float)0,
            'g_6'         => (float)0,
            'g_7'         => (float)0,
            'g_8'         => (float)0,
            'g_9'         => (float)0,
            'g_10'        => (float)0,
            'g_11'        => (float)0,
            'g_12'        => (float)0,
            'g_tot'       => (float)0,
        ];
        $cert = [];
        switch ($formato) {
            default:
            case 1: {
                    foreach ($certificados->get() as $d) {
                        if ($d->monto > 0) {
                            $id = $d->certificado . '-' . $d->secuencia;
                            if (isset($prs[$d->ano_eje]) && isset($prs[$d->ano_eje][$d->fuente_financ]) && isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func]) && isset($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador]))
                                $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id] = ['t' => (object)$new];
                            //echo $d->ano_eje.'>'.$d->fuente_financ.'>'.$d->sec_func.'>'.$d->id_clasificador.'>'.$id.''.$d->monto.'</br>';
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t'] = Certificado::agregar($prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t']->concepto = $d->glosa;
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t']->dispositivo = $d->dispositivo;
                            $prs[$d->ano_eje][$d->fuente_financ][$d->sec_func][$d->id_clasificador][$id]['t']->certificado = "$id";
                        }
                    }
                }
                break;
            case 2: {
                    foreach ($certificados->get() as $d) {
                        if ($d->monto > 0) {
                            $id = $d->certificado . '-' . $d->secuencia;
                            if (
                                isset($prs[$d->ano_eje]) &&
                                isset($prs[$d->ano_eje][$d->sec_func]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador])
                            )
                                $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id] = ['t' => (object)$new];
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t'] = Certificado::agregar($prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t']->concepto = $d->glosa;
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t']->dispositivo = $d->dispositivo;
                            $prs[$d->ano_eje][$d->sec_func][$d->fuente_financ][$d->id_clasificador][$id]['t']->certificado = "$id";
                        }
                    }
                }
                break;
            case 3: {
                    foreach ($certificados->get() as $d) {
                        if ($d->monto > 0) {
                            $id = $d->certificado . '-' . $d->secuencia;
                            if (
                                isset($prs[$d->ano_eje]) &&
                                isset($prs[$d->ano_eje][$d->sec_func]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador]) &&
                                isset($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ])
                            )
                                $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->id_clasificador][$id] = ['t' => (object)$new];
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t'] = Certificado::agregar($prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t'], $d);
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t']->concepto = $d->glosa;
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t']->dispositivo = $d->dispositivo;
                            $prs[$d->ano_eje][$d->sec_func][$d->id_clasificador][$d->fuente_financ][$id]['t']->certificado = "$id";
                        }
                    }
                }
                break;
        }
        return $prs;
    }

    public static function getNewObject()
    {
        $new = [
            'type'        => 'gasto',
            'concepto'    => '',
            'certificado' => '',
            'dispositivo' => '',
            'monto_pim'   => (float)0,
            'monto_cert'  => (float)0,
            'monto_comp'  => (float)0,
            'monto_dev'   => (float)0,
            'g_1'         => (float)0,
            'g_2'         => (float)0,
            'g_3'         => (float)0,
            'g_4'         => (float)0,
            'g_5'         => (float)0,
            'g_6'         => (float)0,
            'g_7'         => (float)0,
            'g_8'         => (float)0,
            'g_9'         => (float)0,
            'g_10'        => (float)0,
            'g_11'        => (float)0,
            'g_12'        => (float)0,
            'g_tot'       => (float)0,
        ];
        return (object)$new;
    }

    static function agregar($to, $from)
    {
        $to->monto_cert += $from->monto;
        //$to->monto_comp +=$from->COMPROMETI;
        return $to;
    }

    public static function getCertificadoResumen($anio, $oficina = null, $act_proy = 'all', $sec_ejec)
    {
        $oficinas = [];
        $reporte = Certificado::select([
            DB::raw('Sum(monto) AS monto'),
            'fecha_doc',
        ])
            ->where('sec_ejec', '=', $sec_ejec)
            ->where('ano_eje', '=', $anio)
            ->groupBy('fecha_doc');
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

    public static function getCertificados($anio, $oficina = null, $act_proy = 'all', $show, $notas, $cuentaCorriente, $anulaciones)
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

        $certificado = Certificado::select([
            'ano_eje',
            'sec_func',
            'act_proy',
            'certificado',
            'id_clasificador',
            'glosa',
            'fecha_doc',
            'num_doc',
            'monto',
        ])
            ->where($where)
            ->orderBy('fecha_doc', 'desc')
            ->take($show);
        if ($act_proy != 'all')
            $certificado->whereIn('act_proy', explode(',', $act_proy));

        if ($oficina != null) {
            $certificado
                ->leftJoin('proy_presupuesto', function ($leftJoin) {
                    $leftJoin->on('ano_eje', '=', 'proy_presupuesto.proy_siaf_anio')
                        ->on('sec_ejec', '=', 'proy_presupuesto.proy_sec_ejec')
                        ->on('sec_func', '=', 'proy_presupuesto.proy_siaf_sec_func');
                })
                ->where('proy_tram_dependencia', '=', $oficina);
        }
        return $certificado->get();
    }
}
