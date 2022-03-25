<?php

namespace App\_clases\proyectos\tools\certificar;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\tools\certificar\SolicitudCertificacion
 *
 * @property int $id
 * @property int $solc_certificado
 * @property string|null $solc_oficina
 * @property string|null $solc_fecha
 * @property string|null $solc_documento
 * @property int|null $documento_id
 * @property int|null $solc_doc_sisgedo
 * @property int|null $solc_tipo_gasto
 * @property string|null $solc_objeto
 * @property string|null $solc_tipo_proceso_seleccion
 * @property string|null $solc_otros
 * @property string|null $solc_justificacion
 * @property string|null $solc_doc_priorizacion
 * @property float|null $solc_pia
 * @property float|null $solc_pim
 * @property float|null $solc_certificacion
 * @property float|null $solc_monto_solicitado
 * @property int|null $solc_anio
 * @property int|null $solc_act_proy
 * @property int|null $solc_sec_func
 * @property int|null $solc_fuente_financiamiento
 * @property string|null $solc_id_clasif
 * @property int|null $usuario_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereDocumentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcActProy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcCertificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcCertificado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcDocPriorizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcDocSisgedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcFuenteFinanciamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcIdClasif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcJustificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcMontoSolicitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcObjeto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcOficina($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcOtros($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcPia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcPim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcSecFunc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcTipoGasto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereSolcTipoProcesoSeleccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\SolicitudCertificacion whereUsuarioId($value)
 * @mixin \Eloquent
 */
class SolicitudCertificacion extends Model
{
    protected $table='proy_tools_certificacion';

    public $timestamps=false;
}
