<?php

namespace App\_clases\proyectos;

use App\_clases\proyectos\analitico\Analitico;
use App\_clases\proyectos\analitico\Version;
use App\_clases\siaf\FuenteFinanciamiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;
use Carbon\Carbon;

/**
 * App\_clases\proyectos\Proyecto
 *
 * @property int $idproy_proyecto
 * @property int|null $proy_estado
 * @property string|null $proy_nombre
 * @property int|null $proy_cod_snip
 * @property int|null $proy_cod_siaf
 * @property int|null $funcion_id
 * @property string|null $proy_funcion
 * @property int|null $proy_beneficiarios
 * @property int|null $ubigeo_id
 * @property string|null $proy_localidad
 * @property float|null $proy_pip_actualizado
 * @property float|null $proy_perfil_viable
 * @property float|null $proy_snip15
 * @property float|null $proy_snip16
 * @property string|null $proy_verificacion_viabilidad
 * @property string|null $proy_modificaciones_sin_evaluacion
 * @property string|null $proy_fech_registro_perfil
 * @property string|null $proy_fecha_exp_tec
 * @property int|null $admin_administrador
 * @property string|null $proy_ejecucion_anual
 * @property string|null $proy_tipo_proyecto 1: administracion directa
 * 2: contrato
 * 3: estudio
 * 4: otros
 * @property string $proy_fte_fto
 * @property string|null $proy_pim
 * @property string|null $proy_act_sosem
 * @property float|null $proy_ejecucion_otras_ejecutoras
 * @property string|null $proy_act_ejecucion
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereAdminAdministrador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereFuncionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereIdproyProyecto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyActEjecucion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyActSosem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyBeneficiarios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyCodSiaf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyCodSnip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyEjecucionAnual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyEjecucionOtrasEjecutoras($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyFechRegistroPerfil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyFechaExpTec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyFteFto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyFuncion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyLocalidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyModificacionesSinEvaluacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyPerfilViable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyPim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyPipActualizado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProySnip15($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProySnip16($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyTipoProyecto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereProyVerificacionViabilidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Proyecto whereUbigeoId($value)
 * @mixin \Eloquent
 */
class Proyecto extends Model
{
    protected $table = 'proy_proyecto';

    protected $primaryKey = 'idproy_proyecto';

    public $timestamps = false;

    protected $casts = [
        'idproy_proyecto'      => 'integer',
        'proy_cod_siaf'        => 'integer',
        'proy_cod_snip'        => 'integer',
        'funcion_id'           => 'integer',
        'proy_beneficiarios'   => 'integer',
        'docu_idrecepcion'     => 'integer',
        'ubigeo_id'            => 'integer',
        'proy_pip_actualizado' => 'double',
        'proy_perfil_viable'   => 'double',
        'proy_snip15'          => 'double',
        'proy_snip16'          => 'double',
    ];


    public function getForProyecto()
    {
        return json_encode((Object)[
            'idproy_proyecto'                    => $this->idproy_proyecto,
            'proy_nombre'                        => $this->proy_nombre,
            'proy_cod_snip'                      => $this->proy_cod_snip,
            'proy_cod_siaf'                      => $this->proy_cod_siaf,
            'funcion_id'                         => $this->funcion_id,
            'proy_fte_fto'                       => $this->proy_fte_fto,
            'proy_beneficiarios'                 => $this->proy_beneficiarios,
            'ubigeo_id'                          => $this->ubigeo_id,
            'proy_localidad'                     => $this->proy_localidad,
            'proy_perfil_viable'                 => $this->proy_perfil_viable,
            'proy_snip15'                        => $this->proy_snip15,
            'proy_snip16'                        => $this->proy_snip16,
            'proy_verificacion_viabilidad'       => $this->proy_verificacion_viabilidad,
            'proy_modificaciones_sin_evaluacion' => $this->proy_modificaciones_sin_evaluacion,
            'proy_fech_registro_perfil'          => $this->proy_fech_registro_perfil,
            'proy_estado'                        => $this->proy_estado,
            'proy_oficina'                       => $this->proy_oficina,
            'proy_pip_actualizado'               => $this->proy_pip_actualizado,
            'proy_pres_inc_cf'                   => $this->proy_pres_inc_cf,
        ]);
    }

    public static function getProyectos()
    {
        return Proyecto::select(['idproy_proyecto', 'proy_nombre', 'proy_cod_snip', 'proy_cod_siaf'])
            ->orderBy('idproy_proyecto','asc')
            ->get();
    }

    public static function getListado($rep, $anio)
    {
        switch ($rep) {
            case 'terminado':
                return Proyecto::getTerminadas($anio);
                break;
            case 'paralizado':
                return Proyecto::getParalizados();
                break;
            case 'ejecucion':
                return Proyecto::getEjecucion($anio);
                break;
        }

    }

    public static function GetFuentesFinanciamientoEnAnio($proy, $anio)
    {
        $ft = FuenteFinanciamiento::getFuenteFinanciamientoToSelect($anio);
        $consulta = DB::table('siaf_wpresupuesto')->select(['fuente_financ'])
            ->where('act_proy', '=', $proy)
            ->where('ano_eje', '=', $anio)
            ->groupBy('fuente_financ');
        $fftts = [];
        //dd($consulta->toSql());
        foreach ($consulta->get() as $fftt) {
            $fftts['Con Presupuesto'][$fftt->fuente_financ] = $ft[$fftt->fuente_financ];
            unset($ft[$fftt->fuente_financ]);
        }
        foreach ($ft as $fftt => $nombre) {
            $fftts['Sin Presupuesto'][$fftt] = $nombre;
        }
        return $fftts;
    }

    /**
     * @param $proy
     * @param $version
     * @return array
     */
    public static function GetEjecucionAcumulada($proy, $version)
    {
        $analitico = Analitico::where('ana_act_proy', '=', $proy)->where('analitico_version_id', '=', $version)->orderBy('ana_componente')->orderBy('ana_especifca')->get();
        $an = [];
        foreach ($analitico as $d) {
            if (!isset($an[$d->ana_componente]))
                $an[$d->ana_componente] = [];
            $an[$d->ana_componente][$d->ana_especifca] = $d;
            $an[$d->ana_componente][$d->ana_especifca]->ejecutado = 0;
            $an[$d->ana_componente][$d->ana_especifca]->program = true;
        }
        $ejecucion = DB::table('siaf_wgastos_resumen')->select([
            'siaf_meta.componente',
            'siaf_wgastos_resumen.id_clasificador',
            DB::raw('Sum(siaf_wgastos_resumen.monto) as monto'),
        ])
            ->join('siaf_meta', function (JoinClause $join) {
                return $join
                    ->on('siaf_wgastos_resumen.ano_eje', '=', 'siaf_meta.ano_eje')
                    ->on('siaf_wgastos_resumen.sec_ejec', '=', 'siaf_meta.sec_ejec')
                    ->on('siaf_wgastos_resumen.sec_func', '=', 'siaf_meta.sec_func');
            })
            ->where('siaf_wgastos_resumen.act_proy', '=', $proy)
            ->groupBy('siaf_meta.componente')
            ->groupBy('siaf_wgastos_resumen.id_clasificador')
            ->get();
        foreach ($ejecucion as $dato) {
            if ($dato->monto > 0) {
                if (!isset($an[$dato->componente]))
                    $an[$dato->componente] = [];
                if (!isset($an[$dato->componente][$dato->id_clasificador])) {
                    $an[$dato->componente][$dato->id_clasificador] = (Object)[
                        'analitico_id'       => '-1',
                        'ana_act_proy'       => $proy,
                        'ana_monto'          => 0,
                        'ejecutado'          => $dato->monto,
                        'ana_modificaciones' => 0,
                        'ana_descricion'     => 'EJECUTADO NO PROGRAMADO',
                        'program'            => false,
                    ];
                }

                $an[$dato->componente][$dato->id_clasificador]->ejecutado += $dato->monto;
            }
        }
        $a = [];
        $c = 0;
        foreach ($an as $componente) {
            $a[$c] = [];
            foreach ($componente as $value) {
                $a[$c][] = $value;
            }
            $c++;
        }

        return $a;

    }

    public static function GetEjecucionAcumuladaAnio($proy, $year, $version)
    {
        $analitico = Analitico::where('ana_act_proy', '=', $proy)
            ->where('analitico_version_id', '=', $version)
            ->orderBy('ana_componente')->orderBy('ana_especifca')->get();
        //dd([$version[0]->version,$proy]);
        $an = ['t' => 0, 'm' => 0];
        foreach ($analitico as $d) {
            if (!isset($an[$d->ana_componente]))
                $an[$d->ana_componente] = ['t' => 0, 'm' => 0];

            $an['t'] += $d->ana_monto;
            $an['m'] += $d->ana_modificaciones;
            $an[$d->ana_componente]['t'] += $d->ana_monto;
            $an[$d->ana_componente]['m'] += $d->ana_modificaciones;
            $an[$d->ana_componente][$d->ana_especifca] = $d;
        }
        $ejecucion = DB::table('siaf_meta')->select([
            'siaf_meta.componente',
            'siaf_wgastos.id_clasificador',
            DB::raw('Sum(siaf_wgastos.monto) as monto'),
        ])
            ->join('siaf_wgastos', function (JoinClause $join) {
                return $join
                    ->on('siaf_wgastos.ano_eje', '=', 'siaf_meta.ano_eje')
                    ->on('siaf_wgastos.sec_ejec', '=', 'siaf_meta.sec_ejec')
                    ->on('siaf_wgastos.sec_func', '=', 'siaf_meta.sec_func');
            })
            ->where('siaf_meta.act_proy', '=', $proy)
            ->where('siaf_meta.ano_eje', '<', $year)
            ->groupBy('siaf_meta.componente')
            ->groupBy('siaf_wgastos.id_clasificador')
            ->get();
        $ejec = ['monto' => 0];
        foreach ($ejecucion as $dato) {

            if (!isset($ejec[$dato->componente]))
                $ejec[$dato->componente] = ['monto' => 0];
            $ejec['monto'] += $dato->monto;
            $ejec[$dato->componente]['monto'] += $dato->monto;
            $ejec[$dato->componente][$dato->id_clasificador] = $dato->monto;

            if ($dato->monto > 0) {
                if (!isset($an[$dato->componente]))
                    $an[$dato->componente] = ['t' => 0, 'm' => 0];
                if (!isset($an[$dato->componente][$dato->id_clasificador])) {
                    $an[$dato->componente][$dato->id_clasificador] = (Object)[
                        'analitico_id'       => '-1',
                        'ana_act_proy'       => $proy,
                        'ana_componente'     => $dato->componente,
                        'ana_especifca'      => $dato->id_clasificador,
                        'ana_monto'          => 0,
                        'ana_modificaciones' => 0,
                        'ana_descricion'     => 'EJECUTADO NO PROGRAMADO',
                    ];
                }
            }
        }
        return [$ejec, $an];

    }

    public static function GetEjecucionAcumulada2($proy, $version)
    {
        $analitico = Analitico::where('ana_act_proy', '=', $proy)->where('analitico_version_id', '=', $version)->orderBy('ana_componente')->orderBy('ana_especifca')->get();
        $an = [];
        foreach ($analitico as $d) {
            if (!isset($an[$d->ana_componente]))
                $an[$d->ana_componente] = [];
            $an[$d->ana_componente][$d->ana_especifca] = $d;
        }
        $ejecucion = DB::table('siaf_wgastos_resumen')->select([
            'siaf_meta.componente',
            'siaf_wgastos_resumen.id_clasificador',
            DB::raw('Sum(siaf_wgastos_resumen.monto) as monto'),
        ])
            ->join('siaf_meta', function (JoinClause $join) {
                return $join
                    ->on('siaf_wgastos_resumen.ano_eje', '=', 'siaf_meta.ano_eje')
                    ->on('siaf_wgastos_resumen.sec_ejec', '=', 'siaf_meta.sec_ejec')
                    ->on('siaf_wgastos_resumen.sec_func', '=', 'siaf_meta.sec_func');
            })
            ->where('siaf_wgastos_resumen.act_proy', '=', $proy)
            ->groupBy('siaf_meta.componente')
            ->groupBy('siaf_wgastos_resumen.id_clasificador')
            ->get();
        $ejec = [];
        foreach ($ejecucion as $dato) {
            if (!isset($ejec[$dato->componente]))
                $ejec[$dato->componente] = ['monto' => 0];
            $ejec[$dato->componente]['monto'] += $dato->monto;
            $ejec[$dato->componente][$dato->id_clasificador] = $dato->monto;

            if ($dato->monto > 0) {
                if (!isset($an[$dato->componente]))
                    $an[$dato->componente] = [];
                if (!isset($an[$dato->componente][$dato->id_clasificador])) {
                    $an[$dato->componente][$dato->id_clasificador] = (Object)[
                        'analitico_id'       => '-1',
                        'ana_act_proy'       => $proy,
                        'ana_componente'     => $dato->componente,
                        'ana_especifca'      => $dato->id_clasificador,
                        'ana_monto'          => 0,
                        'ana_modificaciones' => 0,
                        'ana_descricion'     => 'EJECUTADO NO PROGRAMADO',
                    ];
                }
            }
        }
        return [$ejec, $an];

    }

    public static function getParalizados()
    {
        $proy = \DB::table('proy_actividad_obra')
            ->select([
                'proy_actividad_obra.aco_programado',
                'proy_proyecto.proy_cod_snip',
                'proy_proyecto.proy_cod_siaf',
                'proy_proyecto.proy_nombre',
                'proy_proyecto.proy_beneficiarios',
                'proy_proyecto.proy_pip_actualizado',
                'proy_proyecto_funcion.func_descripcion AS funcion',
                'provincia.pro_nombre AS provincia',
                'proy_actividad_obra.aco_programado AS fecha_termino',
                'proy_obra.obr_modalidad_ejecucion',
                'proy_proyecto_funcion.id AS asfuncion_id',
                'provincia.pro_codigo',
                \DB::raw('avance_fisico(proy_obra.idobra)*100 AS avance'),
            ])
            ->join('DIM_TIEMPO', 'DIM_TIEMPO.Fecha', '=', 'proy_actividad_obra.aco_programado')
            ->join('proy_obra', 'proy_actividad_obra.obra_idobra', '=', 'proy_obra.idobra')
            ->join('proy_proyecto', 'proy_obra.proy_proyecto_idproy_proyecto', '=', 'proy_proyecto.idproy_proyecto')
            ->leftJoin('proy_proyecto_funcion', 'proy_proyecto_funcion.id', '=', 'proy_proyecto.funcion_id')
            ->leftJoin('distrito', 'proy_proyecto.ubigeo_id', '=', 'distrito.dis_codigo')
            ->leftJoin('provincia', 'provincia.pro_codigo', '=', 'distrito.provincia_pro_codigo')
            ->where('proy_actividad_obra.actividad_idactividad', '=', 13)
            ->where('proy_actividad_obra.aco_inicio', '<', Carbon::now())
            ->where('proy_actividad_obra.aco_ocurrencia', '>', Carbon::now())
            ->get();
        //dd($proy->toSql());
        return $proy;
    }

    public static function getTerminadas($anio)
    {
        return \DB::table('proy_actividad_obra')
            ->select([
                'proy_proyecto.proy_cod_snip',
                'proy_proyecto.proy_cod_siaf',
                'proy_proyecto.proy_nombre',
                'proy_proyecto.proy_beneficiarios',
                'proy_proyecto.proy_pip_actualizado',
                'proy_proyecto_funcion.func_descripcion AS funcion',
                'provincia.pro_nombre AS provincia',
                'proy_actividad_obra.aco_programado',
                'proy_obra.obr_modalidad_ejecucion',
                'proy_proyecto_funcion.id AS asfuncion_id',
                'provincia.pro_codigo',
                \DB::raw('100 as avance'),
            ])
            ->join('DIM_TIEMPO', 'DIM_TIEMPO.Fecha', '=', 'proy_actividad_obra.aco_programado')
            ->join('proy_obra', 'proy_actividad_obra.obra_idobra', '=', 'proy_obra.idobra')
            ->join('proy_proyecto', 'proy_obra.proy_proyecto_idproy_proyecto', '=', 'proy_proyecto.idproy_proyecto')
            ->leftJoin('proy_proyecto_funcion', 'proy_proyecto_funcion.id', '=', 'proy_proyecto.funcion_id')
            ->leftJoin('distrito', 'proy_proyecto.ubigeo_id', '=', 'distrito.dis_codigo')
            ->leftJoin('provincia', 'provincia.pro_codigo', '=', 'distrito.provincia_pro_codigo')
            ->where('proy_actividad_obra.actividad_idactividad', '=', 15)
            ->where('DIM_TIEMPO.Anio', '=', $anio)
            ->get();
    }

    public static function getEjecucion($anio)
    {
        $proy = \DB::table('proy_obra')
            ->select([
                'proy_proyecto.proy_cod_snip',
                'proy_proyecto.proy_cod_siaf',
                'proy_proyecto.proy_nombre',
                'proy_proyecto.proy_beneficiarios',
                'proy_proyecto.proy_pip_actualizado',
                'proy_proyecto_funcion.func_descripcion AS funcion',
                'provincia.pro_nombre AS provincia',
                'proy_obra.obr_fecha_inicio_ejecucion AS aco_programado',
                'proy_obra.obr_modalidad_ejecucion',
                'proy_proyecto_funcion.id AS asfuncion_id',
                'provincia.pro_codigo',
                \DB::raw('avance_fisico(proy_obra.idobra)*100 AS avance'),
            ])
            ->join('proy_proyecto', 'proy_obra.proy_proyecto_idproy_proyecto', '=', 'proy_proyecto.idproy_proyecto')
            ->leftJoin('proy_proyecto_funcion', 'proy_proyecto_funcion.id', '=', 'proy_proyecto.funcion_id')
            ->leftJoin('distrito', 'proy_proyecto.ubigeo_id', '=', 'distrito.dis_codigo')
            ->leftJoin('provincia', 'provincia.pro_codigo', '=', 'distrito.provincia_pro_codigo')
            ->where('obr_tipo_contrato', '=', 2)
            ->where('proy_obra.obr_fecha_inicio_ejecucion', '<', Carbon::now())
            ->where(\DB::raw('DATE_ADD(proy_obra.obr_fecha_inicio_ejecucion,INTERVAL (proy_obra.obr_plazo + IFNULL((SELECT SUM(aco_accion_numero) FROM proy_actividad_obra WHERE actividad_idactividad in(19, 24) AND obra_idobra = idobra),0)) DAY)'), '>', Carbon::now())
            ->groupBy('proy_obra.idobra')
            ->get();
        //dd($proy->toSql());
        return $proy;
    }

    public static function groupFuncionForReporte($proyectos)
    {
        $acarreo = [];
        foreach ($proyectos as $proyecto) {
            if (!isset($acarreo[$proyecto->funcion])) {
                $acarreo[$proyecto->funcion] = (Object)([
                    'count'         => 1,
                    'monto'         => $proyecto->proy_pip_actualizado,
                    'beneficiarios' => $proyecto->proy_beneficiarios,
                ]);
            } else {
                $acarreo[$proyecto->funcion]->count++;
                $acarreo[$proyecto->funcion]->monto += $proyecto->proy_pip_actualizado;
                $acarreo[$proyecto->funcion]->beneficiarios += $proyecto->proy_beneficiarios;
            }
        }
        return $acarreo;
    }

    public static function groupFuncionForPDF($proyectos)
    {
        $acarreo = [];
        foreach ($proyectos as $proyecto) {
            if (!isset($acarreo[$proyecto->funcion])) {
                $acarreo[$proyecto->funcion] = (Object)([
                    'funcion'       => $proyecto->funcion,
                    'count'         => 1,
                    'monto'         => $proyecto->proy_pip_actualizado,
                    'beneficiarios' => $proyecto->proy_beneficiarios,
                ]);
            } else {
                $acarreo[$proyecto->funcion]->count++;
                $acarreo[$proyecto->funcion]->monto += $proyecto->proy_pip_actualizado;
                $acarreo[$proyecto->funcion]->beneficiarios += $proyecto->proy_beneficiarios;
            }
        }
        return $acarreo;
    }

    public static function groupProvinciaForReporte($proyectos)
    {
        $acarreo = [];
        foreach ($proyectos as $proyecto) {
            if (!isset($acarreo[$proyecto->provincia])) {
                $acarreo[$proyecto->provincia] = (Object)([
                    'count'         => 1,
                    'monto'         => $proyecto->proy_pip_actualizado,
                    'beneficiarios' => $proyecto->proy_beneficiarios,
                ]);
            } else {
                $acarreo[$proyecto->provincia]->count++;
                $acarreo[$proyecto->provincia]->monto += $proyecto->proy_pip_actualizado;
                $acarreo[$proyecto->provincia]->beneficiarios += $proyecto->proy_beneficiarios;
            }
        }
        return $acarreo;
    }

    public static function groupProvinciaForPDF($proyectos)
    {
        $acarreo = [];
        foreach ($proyectos as $proyecto) {
            if (!isset($acarreo[$proyecto->provincia])) {
                $acarreo[$proyecto->provincia] = (Object)([
                    'provincia'     => $proyecto->provincia,
                    'count'         => 1,
                    'monto'         => $proyecto->proy_pip_actualizado,
                    'beneficiarios' => $proyecto->proy_beneficiarios,
                ]);
            } else {
                $acarreo[$proyecto->provincia]->count++;
                $acarreo[$proyecto->provincia]->monto += $proyecto->proy_pip_actualizado;
                $acarreo[$proyecto->provincia]->beneficiarios += $proyecto->proy_beneficiarios;
            }
        }
        return $acarreo;
    }

    public static function groupTotalForReporte($proyectos)
    {
        $acarreo = (Object)(['count' => 0, 'monto' => 0, 'beneficiarios' => 0]);
        foreach ($proyectos as $proyecto) {
            $acarreo->count++;
            $acarreo->monto += $proyecto->proy_pip_actualizado;
            $acarreo->beneficiarios += $proyecto->proy_beneficiarios;
        }
        return $acarreo;
    }

    public static function groupTotalForPDF($proyectos)
    {
        $acarreo = [];

        //dd($acarreo);
        foreach ($proyectos as $proyecto) {

            $acarreo[] = (Object)([
                'funcion'       => $proyecto->funcion,
                'denominacion'  => ($proyecto->proy_nombre),
                'localizacion'  => $proyecto->provincia,
                'modalidad'     => $proyecto->obr_modalidad_ejecucion,
                'fecha'         => $proyecto->aco_programado,
                'monto'         => $proyecto->proy_pip_actualizado,
                'beneficiarios' => $proyecto->proy_beneficiarios,
                'avance'        => $proyecto->avance,
            ]);
        }
        return $acarreo;
    }
}
