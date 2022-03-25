<?php

namespace App\_clases\proyectos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\ActividadObra
 *
 * @property int $idactividades
 * @property string|null $aco_observacion
 * @property string|null $aco_ocurrencia
 * @property int|null $aco_demora
 * @property string|null $aco_inicio
 * @property string|null $aco_programado
 * @property string|null $aco_ideal
 * @property int|null $aco_orden
 * @property int|null $aco_numero
 * @property int|null $actividad_idactividad
 * @property int|null $obra_idobra
 * @property int|null $aco_vinculo 0:contractual, else numero de adicional
 * @property int|null $aco_accion 0 : NINGUNO
 * 1: PARALIZACION
 * 2: AMPLIACION
 * 3: ADICIONAL
 * 4: DEDUCTIVO
 * 5: ADELANTO
 * @property float|null $aco_accion_numero
 * @property float|null $aco_avance_financiero
 * @property float|null $aco_avance_val
 * @property float|null $aco_avance_fisico
 * @property float|null $aco_meta_fisico
 * @property float|null $aco_meta_financiero
 * @property float|null $aco_saldo_amortizado
 * @property float|null $aco_girado
 * @property int|null $aco_creado 0 : manual
 * 1 : automatico
 * @property string|null $aco_uso_de_pruebas
 * @property float|null $aco_amor_ad
 * @property float|null $aco_amor_am
 * @property float|null $aco_amor_reajuste
 * @property float|null $aco_amor_deduc
 * @property array|null $aco_amor_deduc_det
 * @property float|null $aco_amor_reten
 * @property float|null $aco_amor_otros
 * @property string|null $aco_doc_supervisor
 * @property string|null $aco_doc_supervisor_fecha
 * @property int|null $aco_doc_supervisor_reg_sisgedo
 * @property string|null $aco_doc_emitido
 * @property int|null $aco_doc_emitido_sisgedo
 * @property int|null $aco_doc_emitido_sisgedo_expe
 * @property int|null $aco_doc_emitido_sisgedo_num_doc
 * @property int|null $aco_doc_emitido_generado
 * @property int|null $aco_doc_imprimir_acumulados
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAccionNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAmorAd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAmorAm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAmorDeduc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAmorDeducDet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAmorOtros($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAmorReajuste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAmorReten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAvanceFinanciero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAvanceFisico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoAvanceVal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoCreado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDemora($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocEmitido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocEmitidoGenerado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocEmitidoSisgedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocEmitidoSisgedoExpe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocEmitidoSisgedoNumDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocImprimirAcumulados($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocSupervisor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocSupervisorFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoDocSupervisorRegSisgedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoGirado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoIdeal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoMetaFinanciero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoMetaFisico($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoObservacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoOcurrencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoProgramado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoSaldoAmortizado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoUsoDePruebas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereAcoVinculo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereActividadIdactividad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereIdactividades($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ActividadObra whereObraIdobra($value)
 * @mixin \Eloquent
 */
class ActividadObra extends Model
{
    protected $table = 'proy_actividad_obra';

    protected $primaryKey = 'idactividades';

    protected $dates = [
        'aco_programado',
        'aco_inicio',
    ];

    protected $casts = [
        'aco_accion_numero'     => 'double',
        'aco_avance_financiero' => 'double',
        'aco_avance_val'        => 'double',
        'aco_avance_fisico'     => 'double',
        'aco_meta_fisico'       => 'double',
        'aco_meta_financiero'   => 'double',
        'aco_saldo_amortizado'  => 'double',
        'aco_girado'            => 'double',
        'aco_amor_ad'           => 'double',
        'aco_amor_am'           => 'double',
        'aco_amor_reajuste'     => 'double',
        'aco_amor_deduc'        => 'double',
        'aco_amor_reten'        => 'double',
        'aco_amor_otros'        => 'double',
        'idactividades'         => 'integer',
        'aco_demora'            => 'integer',
        'aco_orden'             => 'integer',
        'aco_numero'            => 'integer',
        'actividad_idactividad' => 'integer',
        'obra_idobra'           => 'integer',
        'aco_vinculo'           => 'integer',
        'aco_accion'            => 'integer',
        'aco_creado'            => 'integer',
        'aco_amor_deduc_det'    => 'array',
        'aco_programado'        => 'datetime:Y-m-d',
        'aco_inicio'            => 'datetime:Y-m-d',
    ];

    public $timestamps = false;

    public function getForActividad()
    {

        return json_encode((Object)[
            'idactividades'         => $this->idactividades,
            'actividad_idactividad' => $this->actividad_idactividad,
            'obra_idobra'           => $this->obra_idobra,
            'aco_inicio'            => $this->aco_inicio,
            'aco_programado'        => $this->aco_programado,
            'aco_ocurrencia'        => $this->aco_ocurrencia,
            'aco_orden'             => $this->aco_orden,
            'aco_accion'            => $this->aco_accion,
            'aco_numero'            => $this->aco_numero,
            'aco_accion_numero'     => $this->aco_accion_numero,
            'aco_creado'            => $this->aco_creado,
            'aco_observacion'       => $this->aco_observacion,
            'aco_observacion_otro'  => $this->aco_observacion_otro,
            'aco_meta_financiero'   => $this->aco_meta_financiero,
            'aco_avance_financiero' => $this->aco_avance_financiero,
            'aco_saldo_amortizado'  => $this->aco_saldo_amortizado,
            'aco_girado'            => $this->aco_girado,
            'aco_amor_reajuste'     => $this->aco_amor_reajuste,
            'aco_amor_deduc'        => $this->aco_amor_deduc,
            'aco_amor_deduc_det'    => $this->aco_amor_deduc_det,
            'aco_amor_ad'           => $this->aco_amor_ad,
            'aco_amor_am'           => $this->aco_amor_am,
            'aco_amor_reten'        => $this->aco_amor_reten,
            'aco_amor_otros'        => $this->aco_amor_otros,
            'aco_vinculo'           => $this->aco_vinculo,
        ]);
    }
}
