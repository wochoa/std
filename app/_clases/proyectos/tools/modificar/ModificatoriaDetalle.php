<?php

namespace App\_clases\proyectos\tools\modificar;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\tools\modificar\ModificatoriaDetalle
 *
 * @property int $id
 * @property int $modificatoria_id
 * @property int $componente_id
 * @property string $det_fuente_financiamiento
 * @property string $det_id_clasif
 * @property float|null $det_acumulado_proy
 * @property float|null $det_acumulado_comp
 * @property float|null $det_acumulado
 * @property float|null $det_pim_proy
 * @property float|null $det_pim_componente
 * @property float|null $det_pim
 * @property float|null $det_de
 * @property float|null $det_a
 * @property float|null $det_nuevo_pim
 * @property string|null $det_justificacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereComponenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetAcumulado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetAcumuladoComp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetAcumuladoProy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetDe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetFuenteFinanciamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetIdClasif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetJustificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetNuevoPim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetPim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetPimComponente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereDetPimProy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereModificatoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\modificar\ModificatoriaDetalle whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ModificatoriaDetalle extends Model
{
    protected $table='proy_tools_modificatoria_det';
}
