<?php

namespace App\Http\Controllers\Proy\tools\cert;

use App\_clases\proyectos\tools\certificar\Detalle;
use App\_clases\proyectos\tools\certificar\Documento;
use App\_clases\proyectos\tools\certificar\SolicitudCertificacion;
use App\_clases\siaf\reportes\Certificado;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class DetalleC extends Controller
{

    public function index(Request $request)
    {

        $solicitud = SolicitudCertificacion::find($request->id);
        $detalle = Detalle::where('solicitud_id', '=', $request->id)->get();
        //listar el detalle de certificados para seleccionar lo que se incluira en el reporte
        $arreglo = [];
        $certificado = $this->getCertificadosToArray($solicitud->solc_anio, $solicitud->solc_certificado, $arreglo);

        return json_encode((Object)[
            'certificado' => $certificado,
            'detalle'     => $detalle,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }

    private function getCertificadosToArray($anio, $certificado, $arreglo)
    {
        /*$certtificados = Certificado::where('ano_eje','=',$anio)
            ->where('sec_ejec','=',config('proyectos.unidad_ejecutora'))
            ->where('certificado','=',$certificado)->get();*/
        $certtificados = Certificado::select([
            'siaf_wcert.ano_eje',
            'siaf_wcert.sec_func',
            'siaf_wcert.fuente_financ',
            'siaf_wcert.certificado',
            'siaf_wcert.id_clasificador',
            'siaf_wcert.secuencia',
            'siaf_wcert.correlativo',
            //'siaf_wcert.cadena_fun',
            'siaf_wcert.fecha_doc',
            'siaf_wcert.num_doc',
            //'siaf_wcert.ESPECIFICA',
            'siaf_wcert.monto',
            'siaf_wcert.estado_registro',
            'siaf_wpresupuesto.pia',
            'siaf_wpresupuesto.pim',
            'siaf_wpresupuesto.monto_cert',
            DB::raw('1 as _token'),
            DB::raw('-1 as id'),
        ])
            ->join('siaf_wpresupuesto', function (JoinClause $join) {
                $join->on('siaf_wpresupuesto.ano_eje', '=', 'siaf_wcert.ano_eje')
                    ->on('siaf_wpresupuesto.sec_ejec', '=', 'siaf_wcert.sec_ejec')
                    ->on('siaf_wpresupuesto.sec_func', '=', 'siaf_wcert.sec_func')
                    ->on('siaf_wpresupuesto.id_clasificador', '=', 'siaf_wcert.id_clasificador')
                    ->on('siaf_wpresupuesto.fuente_financ', '=', 'siaf_wcert.fuente_financ');
                return $join;
            })
            ->where('siaf_wcert.ano_eje', '=', $anio)
            ->where('siaf_wcert.sec_ejec', '=', config('proyectos.unidad_ejecutora'))
            ->where('siaf_wcert.certificado', 'LIKE', "%$certificado%")
            ->orderBy('siaf_wcert.secuencia', 'DESC')
            ->orderBy('siaf_wcert.correlativo', 'DESC');
        return $certtificados->get();

        foreach ($certtificados->get() as $cert) {
            $meta = $cert->sec_func;
            $esp = $cert->id_clasificador;
            $corr = $cert->secuencia . '-' . $cert->correlativo;
            if (!isset($arreglo[$anio])) {
                $arreglo[$anio] = [];
            }
            if (!isset($arreglo[$anio][$corr])) {
                $arreglo[$anio][$corr] = [];
            }
            if (!isset($arreglo[$anio][$corr][$meta])) {
                $arreglo[$anio][$corr][$meta] = [];
            }
            if (!isset($arreglo[$anio][$corr][$meta][$esp])) {
                $arreglo[$anio][$corr][$meta][$esp] = [];
            }
            $arreglo[$anio][$corr][$meta][$esp]['c'] = $cert;
        }
        return $arreglo;
    }

    private function getDetalleToArray($sol, $arreglo)
    {
        $detalle = Detalle::where('solicitud_id', '=', $sol);
        //dd($arreglo);
        foreach ($detalle->get() as $cert) {
            $anio = $cert->det_anio;
            $meta = $cert->det_sec_func;
            $esp = $cert->det_id_clasif;
            $corr = $cert->det_secuencia . '-' . $cert->det_correlativ;
            if (!isset($arreglo[$anio])) {
                $arreglo[$anio] = [];
                dd('no coincide Anio:' . $anio);
            }
            if (!isset($arreglo[$anio][$corr])) {
                $arreglo[$anio][$corr] = [];
                dd('no coincide Correlativo');
            }
            if (!isset($arreglo[$anio][$corr][$meta])) {
                $arreglo[$anio][$corr][$meta] = [];
                dd('no coincide Meta');
            }
            if (!isset($arreglo[$anio][$corr][$meta][$esp])) {
                $arreglo[$anio][$corr][$meta][$esp] = [];
                dd('no coincide Especifica');
            }
            if (isset($arreglo[$anio][$corr][$meta][$esp]['c'])) {
                $arreglo[$anio][$corr][$meta][$esp]['c']->id = $cert->id;
                $arreglo[$anio][$corr][$meta][$esp]['d'] = $cert;
            } else
                dd('no coincide');
        }
        return $arreglo;
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
        if ($request->key == -1) {
            $cert = new Detalle();
            $cert->solicitud_id = $request->solicitud_id;
            $cert->det_secuencia = $request->secuencia;
            $cert->det_correlativ = $request->correlativo;
            $cert->det_anio = $request->ano_eje;
            $cert->det_sec_func = $request->sec_func;
            $cert->det_fuente_financiamiento = $request->fuente_financ;
            $cert->det_id_clasif = $request->id_clasificador;
            //$cert->det_pia                      = $request->pia;
            $cert->det_pim = $request->pim;
            $cert->det_certificacion = ($request->monto_cert > $request->monto) ? $request->monto_cert - $request->monto : 0;
            $cert->det_monto_solicitado = $request->monto;
            $cert->save();
            return $cert;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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
    public function destroy(Request $request)
    {
        Detalle::destroy($request->key);
        return response(['ok' => 1]);
    }
}
