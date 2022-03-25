<?php

namespace App\_clases\proyectos\tools\certificar;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\tools\certificar\Detalle
 *
 * @property int $id
 * @property int|null $solicitud_id
 * @property string|null $det_secuencia
 * @property string|null $det_correlativ
 * @property int|null $det_anio
 * @property int|null $det_sec_func
 * @property int|null $det_fuente_financiamiento
 * @property string|null $det_id_clasif
 * @property float|null $det_pia
 * @property float|null $det_pim
 * @property float|null $det_monto_solicitado
 * @property float|null $det_certificacion
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetCertificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetCorrelativ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetFuenteFinanciamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetIdClasif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetMontoSolicitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetPia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetPim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetSecFunc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereDetSecuencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Detalle whereSolicitudId($value)
 * @mixin \Eloquent
 */
class Detalle extends Model
{
    protected $table='proy_tools_certificar_det';

    public $timestamps=false;

}
