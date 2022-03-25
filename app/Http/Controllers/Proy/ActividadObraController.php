<?php

namespace App\Http\Controllers\Proy;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\_clases\proyectos\ObraEstado;
use App\_clases\proyectos\ActividadObra;
use App\_clases\proyectos\ActividadAccion;
use App\_clases\proyectos\Actividad;
use App\_clases\proyectos\Obra;
use Carbon\Carbon;
use DB;

class ActividadObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        switch ($request->tipo) {

            case '1':
                {
                    $where = [
                        ['obra_idobra', '=', $request->obra_idobra],
                        ['a.act_accion', '=', 0],
                        ['actividad_idactividad', '<>', 7],
                    ];
                    break;
                }
            case '2':
                {

                    $where = function ($query) use ($request) {
                        $query->where('obra_idobra', '=', $request->obra_idobra)->where('actividad_idactividad', '=', 7)->where('aco_vinculo', '=', $request->aco_vinculo);
                    };
                    break;
                }
            case '3':
                {
                    $where = function ($query) use ($request) {
                        $query->where('obra_idobra', '=', $request->obra_idobra)->where('a.act_accion', '=', 1)
                            ->orWhere('obra_idobra', '=', $request->obra_idobra)->where('a.act_accion', '=', 2)
                            ->orWhere('obra_idobra', '=', $request->obra_idobra)->where('a.act_accion', '=', 5);
                    };
                    break;
                }
            case '4':
            {
                $where = function ($query) use ($request) {
                    $query->where('obra_idobra', '=', $request->obra_idobra)->where('a.act_accion', '=', 3)
                        ->orwhere('obra_idobra', '=', $request->obra_idobra)->where('a.act_accion', '=', 4);
                };
            }
        }

        $actividad = ActividadObra::select([
            'idactividades',
            'actividad_idactividad',
            'obra_idobra',
            'e.eta_descripcion',
            'a.act_descripcion',
            'aco_inicio',
            'aco_programado',
            'aco_orden',
            'a.act_accion as aco_accion',
            'aco_accion_numero',
            'aco_ocurrencia',
            'aco_numero',
            'aco_creado',
            'aco_observacion',
            'aco_meta_financiero',
            'aco_avance_financiero',
            'aco_saldo_amortizado',
            'aco_girado',
            'aco_amor_reajuste',
            'aco_amor_deduc',
            'aco_amor_deduc_det',
            'aco_amor_ad',
            'aco_amor_am',
            'aco_amor_reten',
            'aco_amor_otros',
            'aco_vinculo',
        ])
            ->join('proy_actividad as a', 'actividad_idactividad', '=', 'a.idactividad')
            ->join('proy_etapa as e', 'e.idetapa_etapa', '=', 'a.etapa_idetapa_etapa')
            ->where($where)
            ->orderBy('aco_programado', 'asc')
            ->get();

        if ($request->tipo == 2) {

            if ($request->aco_vinculo > 0 && count($actividad) > 0) {
                $contrato = ActividadObra::select([
                    'aco_accion_numero as obr_monto_contrato',
                    DB::raw("0 as total_deductivo"),
                ])
                    ->where('obra_idobra', '=', $request->obra_idobra)
                    ->where('actividad_idactividad', '=', 20)
                    ->where('idactividades', '=', $request->aco_vinculo)
                    ->first();
            } elseif ($request->aco_vinculo == 0 && count($actividad) > 0) {
                $contrato = Obra::select([
                    'obr_monto_contrato',
                    DB::raw("SUM(pa.aco_accion_numero) as total_deductivo"),
                ])
                    ->join('proy_actividad_obra as pa', 'pa.obra_idobra', '=', 'idobra')
                    ->join('proy_actividad as a', 'pa.actividad_idactividad', '=', 'a.idactividad')
                    ->where('idobra', '=', $request->obra_idobra)
                    //->where('a.act_accion', '=', 4)
                    ->where('pa.aco_accion','=',4)
                    ->groupBy('idobra')
                    ->groupBy('proy_obra.obr_monto_contrato')
                    ->first();

                if ($contrato == null) {
                    $contrato = Obra::select([
                        'obr_monto_contrato',
                        DB::raw("0 as total_deductivo"),
                    ])
                        ->where('idobra', '=', $request->obra_idobra)
                        ->first();
                }
            } elseif ($request->aco_vinculo == -1 && count($actividad) > 0) {
                $contrato = Obra::select([
                    'obr_monto_contrato',
                    DB::raw("SUM(aco_accion_numero) as total_deductivo"),
                ])
                    ->join('proy_actividad_obra as pa', 'pa.obra_idobra', '=', 'idobra')
                    ->join('proy_actividad as a', 'pa.actividad_idactividad', '=', 'a.idactividad')
                    ->where('idobra', '=', $request->obra_idobra)
                    ->where('a.act_accion', '=', 4)
                    ->groupBy('idobra')
                    ->groupBy('proy_obra.obr_monto_contrato')
                    ->first();
            } else {
                $contrato = null;
            }

            return json_encode((Object)['data' => $actividad, 'contrato' => $contrato]);
            return $actividad;
        } else {
            return $actividad;
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        switch ($request->tipo) {
            case '1' :
                {
                    $this->guardarActividadObra($request);
                }
                break;
            case '2' :
                {
                    $this->editarValorizacion($request);
                }
                break;
            case '3' :
            case '4' :
                {
                    $this->editarControlPlazos($request);
                }
                break;
            case '5' :
                {
                    $this->editarProgramarActividad($request);
                }
                break;
        }

    }

    public function guardarActividadObra(Request $request)
    {
        $actividad = ($request->idactividades == null) ? new ActividadObra() : ActividadObra::find($request->idactividades);
        $actividad->actividad_idactividad = $request->actividad_idactividad;
        $actividad->aco_inicio = $request->aco_inicio;
        // if (($request->aco_accion == 1 || $request->aco_accion == 2) && $request->aco_accion_numero != null) {
        //     $temp1 = new Carbon($request->aco_inicio);
        //     $temp1->addDays($request->aco_accion_numero);
        //     $actividad->aco_programado = $temp1;
        // } else {
        //     $actividad->aco_programado = $request->aco_programado;
        // }
        $actividad->aco_ocurrencia = $request->aco_ocurrencia;
        $actividad->aco_orden = $request->aco_orden;
        //$actividad->aco_accion = $request->aco_accion;
        $actividad->aco_accion_numero = $request->aco_accion_numero;
        $actividad->obra_idobra = $request->obra_idobra;
        $actividad->aco_vinculo = $request->aco_vinculo;
        $actividad->aco_creado = $request->aco_creado;
        $actividad->aco_observacion = $request->aco_observacion;
        $actividad->save();

    }

    public function editarValorizacion(Request $request)
    {
        $actividad = ActividadObra::find($request->idactividades);
        //dd([$actividad,(double)$request->aco_accion_numero]);
        $actividad->aco_ocurrencia = $request->aco_ocurrencia;
        $actividad->aco_accion_numero = (double)$request->aco_accion_numero;
        $actividad->aco_avance_financiero = (double)$request->aco_avance_financiero;
        $actividad->aco_amor_reajuste = (double)$request->aco_amor_reajuste;
        $actividad->aco_amor_deduc_det = json_encode($request->aco_amor_deduc_det);
        $actividad->aco_amor_ad = (double)$request->aco_amor_ad;
        $actividad->aco_amor_am = (double)$request->aco_amor_am;
        $actividad->aco_amor_reten = (double)$request->aco_amor_reten;
        $actividad->aco_amor_otros = (double)$request->aco_amor_otros;
        $actividad->aco_girado = (double)$request->aco_girado;
        //$actividad->aco_doc_imprimir_acumulados = $request->aco_doc_imprimir_acumulados;
        $actividad->aco_vinculo = $request->aco_vinculo;
        $actividad->aco_numero = $request->aco_numero;
        $actividad->aco_doc_supervisor = $request->aco_doc_supervisor;
        $actividad->aco_doc_supervisor_fecha = $request->aco_doc_supervisor_fecha;
        $actividad->aco_observacion = $request->aco_observacion;
        //$actividad->aco_doc_supervisor_reg_sisgedo = $request->aco_doc_supervisor_reg_sisgedo;
        //$actividad->aco_doc_emitido_sisgedo_expe = $request->aco_doc_emitido_sisgedo_expe;
        $actividad->save();
    }

    public function editarControlPlazos(Request $request)
    {
        $actividad = ActividadObra::find($request->idactividades);
        $actividad->aco_inicio = $request->aco_inicio;
        $actividad->aco_accion_numero = $request->aco_accion_numero;
        $actividad->aco_numero = $request->aco_numero;
        $actividad->aco_observacion = $request->aco_observacion;
        $actividad->save();
    }

    public function editarProgramarActividad(Request $request)
    {

        $actividad = ActividadObra::find($request->idactividades);
        $actividad->aco_inicio = $request->aco_inicio;
        $actividad->aco_programado = $request->aco_programado;
        $actividad->aco_meta_financiero = $request->aco_meta_financiero;
        $actividad->save();
    }

    public function show($id)
    {
        return ActividadObra::find($id)->getForActividad();
    }

    public function obtenerActividad()
    {
        return Actividad::getActividad();
    }

    public static function actividadHash()
    {
        return md5(utf8_decode(json_encode(Actividad::getActividad(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function obtenerActividadAccion()
    {
        return ActividadAccion::getActividadAccion();
    }

    public static function obtenerActividadAccionHash()
    {
        return md5(utf8_decode(json_encode(ActividadAccion::getActividadAccion(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function obtenerAdicionalObra(Request $request)
    {
        $where = [
            ['obra_idobra', '=', $request->idobra],
            ['actividad_idactividad', '=', 20],
        ];
        return ActividadObra::select([
            'idactividades',
            'aco_numero',
            'aco_accion_numero',
            'actividad_idactividad',
            'pa.act_descripcion',
            'aco_vinculo',
        ])
            ->join('proy_actividad as pa', 'pa.idactividad', '=', 'actividad_idactividad')
            ->where($where)
            ->orderBy('idactividades', 'asc')
            ->get();
    }

    public function ejecucionGeneral(Request $request)
    {
        $counter = 0;
        $counter2 = 0;
        $orden = 0;
        $plazo = 0;
        $plazo2 = 0;
        $tipoContrato = 0;
        $v1 = null;
        $v2 = null;
        $obra = Obra::select('obr_fecha_inicio_ejecucion', 'obr_tipo_contrato', 'obr_plazo')
            ->where('idobra', '=', $request->id)
            ->first();
        $fecha = $obra->obr_fecha_inicio_ejecucion->copy()->addDays(-1);
        $tipoContrato = $obra->obr_tipo_contrato;
        if ($fecha != null && ($tipoContrato == 2 || $tipoContrato == 3)) {
            $tempF = $fecha;
            $plazo = $obra->obr_plazo;
            $plazo2 = ActividadObra::select([DB::raw("SUM(aco_accion_numero) as al")])
                ->join('proy_actividad as a', 'actividad_idactividad', '=', 'a.idactividad')
                ->where('obra_idobra', '=', $request->id)
                ->whereIn('a.act_accion', [1, 2])
                ->first();
            if ($plazo2 != null) {
                $plazo = $plazo + $plazo2;
            }
            $cond = true;
            while ($cond) {
                $tempF2 = $tempF->copy()->addDays(1);
                $tempF = $tempF2->copy()->lastOfMonth();
                $counter = $counter + $tempF->diffInDays($fecha);
                $fecha = $tempF;
                if ($orden >= 100) {
                    $cond = false;
                    break;
                }
                if ($counter >= $plazo) {
                    if ($counter2 < $plazo) {
                        $fecha = $fecha->year . '-' . $fecha->month . '-' . ($plazo - $counter2);
                        $counter2 = $counter2 + 100;
                    } else {
                        $cond = false;
                        break;
                    }
                } else {
                    $counter2 = $counter;
                }
                $where = [
                    ['obra_idobra', '=', $request->id],
                ];
                $v1 = ActividadObra::select([DB::raw("MAX(aco_ocurrencia)")])
                    ->join('proy_actividad as a', 'actividad_idactividad', '=', 'a.idactividad')
                    ->where($where)
                    ->where('a.act_accion', '=', 1)
                    ->whereBetween('aco_inicio', 'aco_ocurrencia')
                    ->first();
                $v2 = ActividadObra::select([DB::raw("MIN(aco_inicio)")])
                    ->join('proy_actividad as a', 'actividad_idactividad', '=', 'a.idactividad')
                    ->where($where)
                    ->where('a.act_accion', '=', 1)
                    ->whereBetween('aco_inicio', 'aco_ocurrencia')
                    ->first();
                $idact = ActividadObra::select('idactividades')
                    ->where($where)
                    ->where('actividad_idactividad', '=', 7)
                    ->where('aco_orden', '=', $orden)
                    ->where('aco_creado', '=', 1)
                    ->first();

                if ($v1 == null && $v2 == null) {
                    if ($idact == null) {
                        $actividad = new ActividadObra();
                    } else {
                        $actividad = ActividadObra::find($idact);
                    }
                    $actividad->aco_inicio = $tempF2;
                    $actividad->aco_programado = $fecha;
                    $actividad->aco_orden = $orden;
                    $actividad->actividad_idactividad = 7;
                    $actividad->obra_idobra = $request->id;
                    $actividad->aco_uso_de_pruebas = 'v1 IS NULL AND v2 IS NULL__';
                    $actividad->save();

                    $orden++;
                } elseif ($v1 != null && $v2 == null) {
                    $tempF2 = $v1->copy()->addDays(1);
                    $fecha = $tempF2->copy()->lastOfMonth();
                    if ($idact == null) {
                        $actividad1 = new ActividadObra();
                        $actividad1->aco_inicio = $tempF2;
                        $actividad1->actividad_idactividad = 7;
                    } else {
                        $actividad1 = ActividadObra::find($idact);
                        $actividad1->aco_inicio = $v1->copy()->addDays(1);
                    }
                    $actividad1->aco_programado = $fecha;
                    $actividad1->aco_orden = $orden;
                    $actividad1->obra_idobra = $request->id;
                    $actividad1->aco_uso_de_pruebas = 'v1 IS NOT NULL AND v2 IS NULL__';
                    $actividad1->save();
                    $orden++;
                } elseif ($v1 == null && $v2 != null) {
                    if ($idact == null) {
                        $actividad4 = new ActividadObra();
                    } else {
                        $actividad5 = ActividadObra::find($idact);

                    }
                    $actividad4->aco_inicio = $tempF2;
                    $actividad4->aco_programado = $v2->copy()->addDays(-1);
                    $actividad4->aco_orden = $orden;
                    $actividad4->actividad_idactividad = 7;
                    $actividad4->obra_idobra = $request->id;
                    $actividad5->aco_uso_de_pruebas = 'v1 IS NOT NULL AND v2 IS NOT NULL__';
                    $actividad5->save();
                    $orden++;
                }
            }
        }
        $act = ActividadObra::where('obra_idobra', '=', $request->id)
            ->where('aco_orden', '>', $orden)
            ->where('actividad_idactividad', '=', 7)
            ->where('aco_creado', '=', 1)
            ->delete();
    }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
