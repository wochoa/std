<?php

namespace App\Http\Controllers\Proy;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\_clases\proyectos\Obra;
use App\_clases\proyectos\ObraEstado;

class ObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return Obra::getObra($request->proy_proyecto_idproy_proyecto);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $contrato = ($request->idobra == null) ? new Obra() : Obra::find($request->idobra);
        $contrato->proy_proyecto_idproy_proyecto = $request->proy_proyecto_idproy_proyecto;
        $contrato->obr_nombre = $request->obr_nombre;
        $contrato->obr_componentes_metas = $request->obr_componentes_metas;
        $contrato->obr_modalidad_ejecucion = $request->obr_modalidad_ejecucion;
        $contrato->obr_fte_fto = $request->obr_fte_fto;
        $contrato->obr_estado = $request->obr_estado;
        $contrato->obr_tipo_contrato = $request->obr_tipo_contrato;
        $contrato->obr_monto_exp_tec = $request->obr_monto_exp_tec;
        $contrato->obr_numero_contrato = $request->obr_numero_contrato;
        $contrato->obr_fecha_exp_tec = $request->obr_fecha_exp_tec;
        $contrato->obr_proceso_seleccion = $request->obr_proceso_seleccion;
        $contrato->obr_nombre_ejecutor = $request->obr_nombre_ejecutor;
        $contrato->obr_direccion_ejecutor = $request->obr_direccion_ejecutor;
        $contrato->obr_representante_ejecutor = $request->obr_representante_ejecutor;
        $contrato->obr_contrato_ejecucion = $request->obr_contrato_ejecucion;
        $contrato->obr_monto_contrato = $request->obr_monto_contrato;
        $contrato->obr_fecha_contrato = $request->obr_fecha_contrato;
        $contrato->obr_fecha_inicio_ejecucion = $request->obr_fecha_inicio_ejecucion;
        $contrato->obr_plazo = $request->obr_plazo;
        $contrato->obr_otros = $request->obr_otros;
        $contrato->save();
        //return $contrato;
    }

    public function obtenerEstadoObra()
    {
        return ObraEstado::select('id', 'descripcion')
            ->get();
    }

    public function show(Request $request)
    {
        return Obra::find($request->id)->getForObra();
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
