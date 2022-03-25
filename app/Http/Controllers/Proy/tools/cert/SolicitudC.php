<?php

namespace App\Http\Controllers\Proy\tools\cert;

use App\_clases\proyectos\tools\certificar\Detalle;
use App\_clases\proyectos\tools\certificar\Documento;
use App\_clases\proyectos\tools\certificar\SolicitudCertificacion;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class SolicitudC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return SolicitudCertificacion::where('documento_id', '=', $request->certificacion)->get();

        // if($request->listar){
        //     $solicitudes=SolicitudCertificacion::where('documento_id','=',$doc)->get();
        //     return view('proyectos.herramientas.certificar.solicitud.listar',['anio'=>$anio,'doc'=>$doc,'solicitudes'=>$solicitudes]);
        // }
        // else{
        //     return view('proyectos.herramientas.certificar.solicitud.index', ['anio'=>$anio,'doc'=>$doc]);
        // }
    }


    public function imprimir(Request $request)
    {

        $documento = Documento::find($request->id_certificacion);
        $solicitud = SolicitudCertificacion::select([
            'proy_tools_certificacion.id',
            'solc_certificado',
            'solc_tipo_gasto',
            'solc_objeto',
            'solc_tipo_proceso_seleccion',
            'solc_otros',
            'solc_justificacion',
            'solc_doc_priorizacion',
        ])
            ->where('proy_tools_certificacion.id', '=', $request->id_certificado)
            ->first();

        $detalle = Detalle::select([
            'siaf_meta.programa_ppto AS programa',
            'siaf_meta.act_proy AS prod_proy',
            'siaf_meta.componente AS act_al_obra',
            'siaf_meta.funcion',
            'siaf_meta.programa AS division_funcional',
            'siaf_meta.sub_programa AS grupo_funcional',
            'siaf_meta.sec_func',
            'siaf_meta.meta as finalidad',
            'det_fuente_financiamiento',
            'siaf_fuente_financ.nombre as fuente_financiamiento_nombre',
            'det_pia',
            'det_pim',
            'det_certificacion',
            'det_monto_solicitado',
            DB::raw("CONCAT(siaf_especifica_det.tipo_transaccion,'.',siaf_especifica_det.generica,'.',siaf_especifica_det.subgenerica,'.',siaf_especifica_det.subgenerica_det,'.',siaf_especifica_det.especifica,'.',siaf_especifica_det.especifica_det) as especifica"),
        ])
            ->join('siaf_meta', function (JoinClause $join) {
                return $join->on('siaf_meta.ano_eje', '=', 'det_anio')
                    ->on('siaf_meta.sec_func', '=', 'det_sec_func');
            })
            ->join('siaf_especifica_det', function (JoinClause $join) {
                return $join->on('siaf_especifica_det.ano_eje', '=', 'det_anio')
                    ->on('siaf_especifica_det.id_clasificador', '=', 'det_id_clasif');
            })
            ->join('siaf_fuente_financ', function (JoinClause $join) {
                return $join->on('siaf_especifica_det.ano_eje', '=', 'siaf_fuente_financ.ano_eje')
                    ->on('det_fuente_financiamiento', '=', 'siaf_fuente_financ.fuente_financ');
            })
            ->where('solicitud_id', '=', $solicitud->id)
            ->where('siaf_meta.sec_ejec', '=', config('proyectos.unidad_ejecutora'))
            ->get();

        return view('proyectos.herramientas.certificar.solicitud.imprimir',
            ['documento' => $documento, 'solicitud' => $solicitud, 'detalles' => $detalle]);
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

        $cert = ($request->id == null) ? new SolicitudCertificacion() : SolicitudCertificacion::find($request->id);

        $cert->solc_certificado = $request->solc_certificado;
        $cert->documento_id = $request->documento_id;
        $cert->solc_tipo_gasto = $request->solc_tipo_gasto;
        $cert->solc_objeto = $request->solc_objeto;
        $cert->solc_tipo_proceso_seleccion = $request->solc_tipo_proceso_seleccion;
        $cert->solc_otros = $request->solc_otros;
        $cert->solc_justificacion = $request->solc_justificacion;
        $cert->solc_doc_priorizacion = $request->solc_doc_priorizacion;
        //$cert->usuario_id                   = $request->usuario_id;//
        $cert->solc_anio = $request->solc_anio;
        //$cert->save();
        return $cert;
        return response(['ok' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($anio, $doc, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($anio, $doc, $id)
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
    public function update($anio, $doc, Request $request, $id)
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
        //SolicitudCertificacion::destroy($request->id);
        return response(['ok' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $str
     * @return string
     */
    public static function iniciales($str)
    {
        $words = explode(' ', $str);
        $iniciales = '';
        $excludeWords = array('POR');
        foreach ($words as $word) {
            if (strlen($word) > 1) {
                $iniciales .= substr($word, 0, 1);
            }
        }
        return $iniciales;
    }

}
