<?php

namespace App\_clases\proyectos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\Obra
 *
 * @property int $idobra
 * @property int|null $proy_proyecto_idproy_proyecto
 * @property int|null $obr_vinculo
 * @property int|null $obr_estado 0: condiciones previas: 1
 * 1: en ejecucion: 2
 * 2: en liquidacion: 5
 * 3: paralizado: 3
 * 4: Finalizado: 6
 * 5: por recepcionar: 4
 * 6: en estudio
 * 7: otros
 * @property string|null $obr_componentes_metas
 * @property string|null $obr_descripcion_estado
 * @property string|null $obr_nombre
 * @property int|null $obr_beneficiarios
 * @property int|null $distrito_dis_codigo
 * @property string|null $obr_tipo_proceso
 * @property string|null $obr_proceso_seleccion
 * @property float|null $obr_valor_referencial
 * @property string|null $obr_modalidad_ejecucion 1: administracion directa
 * 2: contrato
 * 3: estudio
 * 4: otros
 * @property float|null $obr_monto_contrato
 * @property float|null $obr_monto_exp_tec monto expediente tecnico
 * @property string|null $obr_numero_contrato
 * @property string|null $obr_fecha_contrato
 * @property int $obr_plazo
 * @property string|null $obr_fecha_inicio_ejecucion
 * @property string|null $obr_fte_fto
 * @property string|null $obr_otros
 * @property string|null $obr_contrato_ejecucion
 * @property string|null $obr_direccion_ejecutor
 * @property string|null $obr_residente_nombre
 * @property string|null $obr_residente_correo
 * @property string|null $obr_residente_direccion
 * @property string|null $obr_residente_celular
 * @property string|null $obr_monitor_nombre
 * @property string|null $obr_monitor_correo
 * @property string|null $obr_monitor_direccion
 * @property string|null $obr_monitor_celular
 * @property string|null $obr_image
 * @property string|null $obr_fecha_exp_tec
 * @property string|null $obr_fecha_reg_perfil
 * @property int|null $obr_car_fia_fiel_cumplimiento_requiere
 * @property int|null $obr_car_fia_adelanto_directo_requiere
 * @property int|null $obr_car_fia_adelanto_material_requiere
 * @property string|null $obr_nombre_ejecutor
 * @property string|null $obr_representante_ejecutor
 * @property string|null $obr_ejecutor_empresas
 * @property float|null $obr_fr
 * @property int|null $monitor_idadmin
 * @property float|null $obr_val_acumulada
 * @property float|null $obr_monto_contatado
 * @property int|null $regulation_idregulation
 * @property int|null $obr_vigente
 * @property int|null $obr_tipo_contrato 1:expediente tecnico
 * 2:ejecucion
 * 3:supervicion
 * 4:otros
 * @property string|null $obr_contratista_ruc
 * @property int|null $obr_contrato_principal 0:false
 * 1:true
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereDistritoDisCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereIdobra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereMonitorIdadmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrBeneficiarios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrCarFiaAdelantoDirectoRequiere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrCarFiaAdelantoMaterialRequiere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrCarFiaFielCumplimientoRequiere($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrComponentesMetas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrContratistaRuc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrContratoEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrContratoPrincipal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrDescripcionEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrDireccionEjecutor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrEjecutorEmpresas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrFechaContrato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrFechaExpTec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrFechaInicioEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrFechaRegPerfil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrFteFto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrModalidadEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrMonitorCelular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrMonitorCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrMonitorDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrMonitorNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrMontoContatado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrMontoContrato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrMontoExpTec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrNombreEjecutor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrNumeroContrato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrOtros($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrPlazo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrProcesoSeleccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrRepresentanteEjecutor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrResidenteCelular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrResidenteCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrResidenteDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrResidenteNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrTipoContrato($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrTipoProceso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrValAcumulada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrValorReferencial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrVigente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereObrVinculo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereProyProyectoIdproyProyecto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Obra whereRegulationIdregulation($value)
 * @mixin \Eloquent
 */
class Obra extends Model
{
    protected $table = 'proy_obra';

    protected $primaryKey = 'idobra';

    public $timestamps = false;
    protected $dates = [
        'obr_fecha_contrato',
        'obr_fecha_inicio_ejecucion',
    ];
    protected $casts = [
        'obr_fecha_contrato'         => 'datetime:Y-m-d',
        'obr_fecha_inicio_ejecucion' => 'datetime:Y-m-d',
    ];

    public static function getObra($id)
    {
        return Obra::select([
            'idobra',
            'proy_proyecto_idproy_proyecto',
            'obr_nombre',
            'obr_componentes_metas',
            'obr_modalidad_ejecucion',
            'obr_estado',
            'obr_tipo_contrato',
            'obr_monto_exp_tec',
            'obr_numero_contrato',
            'obr_fecha_exp_tec',
            'obr_proceso_seleccion',
            'obr_nombre_ejecutor',
            'obr_direccion_ejecutor',
            'obr_representante_ejecutor',
            'obr_contratista_ruc',
            'obr_contrato_ejecucion',
            'obr_monto_contrato',
            'obr_fecha_contrato',
            'obr_fecha_inicio_ejecucion',
            'obr_plazo',
            'obr_otros',
        ])
            ->where('proy_proyecto_idproy_proyecto', '=', $id)
            ->orderBy('idobra', 'desc')
            ->get();
    }

    public function getForObra()
    {
        return json_encode((Object)[
            'idobra'                        => $this->idobra,
            'proy_proyecto_idproy_proyecto' => $this->proy_proyecto_idproy_proyecto,
            'obr_nombre'                    => $this->obr_nombre,
            'obr_componentes_metas'         => $this->obr_componentes_metas,
            'obr_modalidad_ejecucion'       => $this->obr_modalidad_ejecucion,
            'obr_estado'                    => $this->obr_estado,
            'obr_tipo_contrato'             => $this->obr_tipo_contrato,
            'obr_monto_exp_tec'             => $this->obr_monto_exp_tec,
            'obr_numero_contrato'           => $this->obr_numero_contrato,
            'obr_fecha_exp_tec'             => $this->obr_fecha_exp_tec,
            'obr_proceso_seleccion'         => $this->obr_proceso_seleccion,
            'obr_nombre_ejecutor'           => $this->obr_nombre_ejecutor,
            'obr_direccion_ejecutor'        => $this->obr_direccion_ejecutor,
            'obr_representante_ejecutor'    => $this->obr_representante_ejecutor,
            'obr_contratista_ruc'           => $this->obr_contratista_ruc,
            'obr_contrato_ejecucion'        => $this->obr_contrato_ejecucion,
            'obr_monto_contrato'            => $this->obr_monto_contrato,
            'obr_fecha_contrato'            => $this->obr_fecha_contrato,
            'obr_fecha_inicio_ejecucion'    => $this->obr_fecha_inicio_ejecucion,
            'obr_plazo'                     => $this->obr_plazo,
            'obr_otros'                     => $this->obr_otros,
        ]);
    }
}
