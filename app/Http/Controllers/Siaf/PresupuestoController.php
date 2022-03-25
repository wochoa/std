<?php

namespace App\Http\Controllers\Siaf;

use Carbon\Carbon;
use App\_clases\siaf\Especifica;
use App\_clases\siaf\ActProyNombre;
use App\_clases\siaf\EspecificaGasto;
use App\_clases\siaf\DispositivoLegal;
use App\_clases\siaf\MaestroDocumento;
use App\_clases\siaf\reportes\Presupuesto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\_clases\siaf\FuenteFinanciamiento;
use App\_clases\proyectos\plan\cadena_funcional\Funcion;
use App\_clases\proyectos\plan\cadena_funcional\Programa;
use App\_clases\proyectos\plan\cadena_funcional\Componente;
use App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional;
use App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional;

class PresupuestoController extends Controller
{

    public static function index(Request $request)
    {
        if (isset($request->ano_eje)) {

            $where = function ($query) use ($request) {
                $query->where('sec_ejec', '=', config('proyectos.unidad_ejecutora'));
                $query->where('ano_eje', '=', $request->ano_eje);
                if (isset($request->fuente_financ))
                    $query->where('fuente_financ', '=', $request->fuente_financ);
                if (isset($request->componente))
                    $query->where('componente', '=', $request->componente);
                if (isset($request->id_clasificador))
                    $query->where('id_clasificador', '=', $request->id_clasificador);
                if (isset($request->act_proy))
                    $query->where('act_proy', '=', $request->act_proy);
                if (isset($request->sec_func))
                    $query->where('sec_func', '=', $request->sec_func);
            };
            $query = Presupuesto::select(
                [
                    'sec_func',
                    'fuente_financ',
                    'componente',
                    'pia',
                    'pim',
                    'id_clasificador',
                    'act_proy',
                    'monto_cert',
                    'monto_comp_anual',
                    'monto_comp',
                    'monto_dev',
                    'g_1',
                    'g_2',
                    'g_3',
                    'g_4',
                    'g_5',
                    'g_6',
                    'g_7',
                    'g_8',
                    'g_9',
                    'g_10',
                    'g_11',
                    'g_12',
                ])->where($where);

            if ($request->oficina != null) {
                $query
                    ->leftJoin('proy_presupuesto', function ($leftJoin) {
                        $leftJoin->on('ano_eje', '=', 'proy_presupuesto.proy_siaf_anio')
                            ->on('sec_ejec', '=', 'proy_presupuesto.proy_sec_ejec')
                            ->on('sec_func', '=', 'proy_presupuesto.proy_siaf_sec_func');
                    })
                    ->where('proy_tram_dependencia', '=', $request->oficina);
            }
            if (isset($request->prioritarios) && $request->prioritarios)
                $query->orderBy('pim', 'desc')->limit(10);

            return $query->get();
        } else
            abort(428, 'ano_eje es requerido.');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
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

    public function getPrioritarios(Request $request)
    {

        if (isset($request->ano_eje)) {

            $where = function ($query) use ($request) {
                $query->where('sec_ejec', '=', config('proyectos.unidad_ejecutora'));
                $query->where('ano_eje', '=', $request->ano_eje);
                if (isset($request->fuente_financ))
                    $query->where('fuente_financ', '=', $request->fuente_financ);
                if (isset($request->componente))
                    $query->where('componente', '=', $request->componente);
                if (isset($request->id_clasificador))
                    $query->where('id_clasificador', '=', $request->id_clasificador);
                if (isset($request->act_proy))
                    $query->where('act_proy', '=', $request->act_proy);
                if (isset($request->sec_func))
                    $query->where('sec_func', '=', $request->sec_func);
            };
            $query = Presupuesto::select(
                [
                    'sec_func',
                    'fuente_financ',
                    'componente',
                    'pia',
                    'pim',
                    'id_clasificador',
                    'act_proy',
                    'monto_cert',
                    'monto_comp_anual',
                    'monto_comp',
                    'monto_dev',
                    'g_1',
                    'g_2',
                    'g_3',
                    'g_4',
                    'g_5',
                    'g_6',
                    'g_7',
                    'g_8',
                    'g_9',
                    'g_10',
                    'g_11',
                    'g_12',
                ])->where($where);
            if (isset($request->prioritarios) && $request->prioritarios)
                $query->orderBy('pim', 'desc')->limit(10);

            return $query->get();
        } else
            abort(428, 'ano_eje es requerido.');
    }

    public function fuenteFinanciamiento()
    {
        return FuenteFinanciamiento::getFuenteFinanc();
    }

    public static function fuenteFinanciamientoHash()
    {
        return md5(utf8_decode(json_encode(FuenteFinanciamiento::getFuenteFinanc(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function especificaDetalleGasto()
    {
        return Especifica::getEspecificaDetalle();
    }

    public static function especificaDetalleGastoHash()
    {
        return md5(utf8_decode(json_encode(Especifica::getEspecificaDetalle(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function especificaGasto()
    {
        return EspecificaGasto::getEspecificaGasto();
    }

    public static function especificaGastoHash()
    {
        return md5(utf8_decode(json_encode(EspecificaGasto::getEspecificaGasto(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function componenteNombre()
    {
        return Componente::getComponenteNombre();
    }

    public static function componenteNombreHash()
    {
        return md5(utf8_decode(json_encode(Componente::getComponenteNombre(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function dispositivosLegales()
    {
        return DispositivoLegal::getDispositivoLegal();
    }

    public static function dispositivosLegalesHash()
    {
        return md5(utf8_decode(json_encode(DispositivoLegal::getDispositivoLegal(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function maestroDocumento()
    {
        return MaestroDocumento::getMaestroDocumento();
    }

    public static function maestroDocumentoHash()
    {
        return md5(utf8_decode(json_encode(MaestroDocumento::getMaestroDocumento(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function programasComponente()
    {
        return Programa::getProgramasNombre();
    }
    public static function programasComponenteHash()
    {
        return md5(utf8_decode(json_encode(Programa::getProgramasNombre(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function funciones()
    {
        return Funcion::getComponentesToSelect();
    }

    public static function funcionHash()
    {
        return md5(utf8_decode(json_encode(Funcion::getComponentesToSelect(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function divisionesFuncionales()
    {
        return DivisionFuncional::getDivisionFuncional();
    }

    public static function divisionesFuncionalesHash()
    {
        return md5(utf8_decode(json_encode(DivisionFuncional::getDivisionFuncional(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function gruposFuncionales()
    {
        return GrupoFuncional::getGrupoFuncional();
    }

    public static function gruposFuncionalesHash()
    {
        return md5(utf8_decode(json_encode(GrupoFuncional::getGrupoFuncional(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function actProyecto(Request $request)
    {
        return ActProyNombre::getActProyNombre($request->anio);
    }

    public static function actProyectoHash()
    {
        $anio = Carbon::now()->year;
        return md5(utf8_decode(json_encode(ActProyNombre::getActProyNombre($anio), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }
    public function totalProyecto()
    {
        return ActProyNombre::getTotalAnio();

    }
}
