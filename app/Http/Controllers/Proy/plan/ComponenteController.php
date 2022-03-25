<?php

namespace App\Http\Controllers\Proy\plan;

use App\_clases\proyectos\plan\Componente;
use App\_clases\proyectos\Proyecto;
use App\_clases\proyectos\tools\modificar\ModificatoriaDetalle;
use Illuminate\Http\Request;

use App\_clases\utilitarios\Cadena;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    protected $anioActual = '';

    public function __construct()
    {

        $this->anioActual = Carbon::now()->year;
    }

    public function index(Request $request)
    {

    }

    public function listar(Request $request)
    {
        //***************OBTENIENDO CADENAS FUNCIONALES USADAS HASTA EL MOMENTO POR EL PROYECTO ********
        $q1 = DB::table('siaf_meta as m')
            ->select('m.programa_ppto as programa',
                'm.act_proy as prod_proy',
                'm.componente as act_al_obra',
                'funcion',
                'm.programa as division_funcional',
                'm.sub_programa as grupo_funcional',
                'm.meta',
                'finalidad',
                'm.ano_eje',
                'sec_func')
            ->where('m.act_proy', '=', $request->id_proyecto)
            ->orderBy('m.componente', 'asc');

        //*********FIN DE OBTENER CADENAS FUNCIONALES USADAS
        //********AGRUPACION DE CADENAS FUNCIONALES PARA IMPRESION*********
        $cadenas_funcionales = [];//cadenas funcionales
        foreach ($q1->get() as $dato) {
            $cf = $dato->programa . '.' . $dato->prod_proy . '.' . $dato->act_al_obra . '.' . $dato->funcion . '.' . $dato->division_funcional . '.' . $dato->grupo_funcional . '.' . $dato->meta . '.' . $dato->finalidad;
            if (!isset($cadenas_funcionales[$cf])) {
                $cadenas_funcionales[$cf] = [];
                $cadenas_funcionales[$cf] = [
                    'cadena'                  => $cf,
                    'id'                      => -1,
                    'comp_programa'           => $dato->programa,
                    'comp_prod_proy'          => $dato->prod_proy,
                    'comp_act_al_obra'        => $dato->act_al_obra,
                    'comp_funcion'            => $dato->funcion,
                    'comp_division_funcional' => $dato->division_funcional,
                    'comp_grupo_funcional'    => $dato->grupo_funcional,
                    'comp_meta'               => $dato->meta,
                    'comp_finalidad'          => $dato->finalidad,
                    'comp_nombre'             => '',
                    'comp_monto'              => 0,
                    'ejec'                    => [],
                ];
            }
            $cadenas_funcionales[$cf]['ejec'][] = ['anio' => $dato->ano_eje, 'sec_func' => $dato->sec_func];
        }
        $comp = Componente::where('comp_prod_proy', '=', $request->id_proyecto);
        foreach ($comp->get() as $data) {
            $cf = $data->getCF();
            if (!isset($cadenas_funcionales[$cf])) {
                $cadenas_funcionales[$cf] = [];
                $cadenas_funcionales[$cf] = [
                    'cadena'                  => $cf,
                    'id'                      => $data->id,
                    'comp_programa'           => sprintf("%04s", $data->comp_programa),
                    'comp_prod_proy'          => $data->comp_prod_proy,
                    'comp_act_al_obra'        => $data->comp_act_al_obra,
                    'comp_funcion'            => str_pad($data->comp_funcion, 4, "0", STR_PAD_LEFT),
                    'comp_division_funcional' => str_pad($data->comp_division_funcional, 3, "0", STR_PAD_LEFT),
                    'comp_grupo_funcional'    => str_pad($data->comp_grupo_funcional, 4, "0", STR_PAD_LEFT),
                    'comp_meta'               => str_pad($data->comp_meta, 5, "0", STR_PAD_LEFT),
                    'comp_finalidad'          => str_pad($data->comp_finalidad, 7, "0", STR_PAD_LEFT),
                    'comp_nombre'             => $data->comp_nombre,
                    'comp_monto'              => $data->comp_monto,
                ];
            } else {
                $cadenas_funcionales[$cf]['comp_nombre'] = $data->comp_nombre;
                $cadenas_funcionales[$cf]['comp_monto'] = $data->comp_monto;
                $cadenas_funcionales[$cf]['id'] = $data->id;
            }

        }
        $return = [];
        foreach ($cadenas_funcionales as $c)
            $return[] = (Object)$c;
        return json_encode($return);

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
        $componente = ($request->id == null || $request->id == -1) ? new Componente() : Componente::find($request->id);
        $componente->comp_programa = $request->comp_programa;
        $componente->comp_prod_proy = $request->comp_prod_proy;
        $componente->comp_act_al_obra = $request->comp_act_al_obra;
        $componente->comp_funcion = $request->comp_funcion;
        $componente->comp_division_funcional = $request->comp_division_funcional;
        $componente->comp_grupo_funcional = $request->comp_grupo_funcional;
        $componente->comp_meta = $request->comp_meta;
        $componente->comp_finalidad = $request->comp_finalidad;
        $componente->comp_nombre = $request->comp_nombre;
        $componente->comp_monto = $request->comp_monto;
        $componente->save();
        return json_encode([
            'cadena'                  => sprintf("%04s", $request->comp_programa) . '.' . $componente->comp_prod_proy . '.' . $componente->comp_act_al_obra . '.' . str_pad($componente->comp_funcion, 4, "0", STR_PAD_LEFT) . '.' . str_pad($componente->comp_division_funcional, 3, "0", STR_PAD_LEFT) . '.' . str_pad($componente->comp_grupo_funcional, 4, "0", STR_PAD_LEFT) . '.' . str_pad($componente->comp_meta, 5, "0", STR_PAD_LEFT) . '.' . str_pad($componente->comp_grupo_funcional, 7, "0", STR_PAD_LEFT),
            'id'                      => $componente->id,
            'comp_programa'           => $componente->comp_programa,
            'comp_prod_proy'          => $componente->comp_prod_proy,
            'comp_act_al_obra'        => $componente->comp_act_al_obra,
            'comp_funcion'            => $componente->comp_funcion,
            'comp_division_funcional' => $componente->comp_division_funcional,
            'comp_grupo_funcional'    => $componente->comp_grupo_funcional,
            'comp_meta'               => $componente->comp_meta,
            'comp_finalidad'          => $componente->comp_finalidad,
            'comp_nombre'             => $componente->comp_nombre,
            'comp_monto'              => $componente->comp_monto,
        ]);
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
        $mod = ModificatoriaDetalle::where('componente_id', '=', $request->id)->count();
        if ($mod > 0) {
            return response(['id' => $request->id, 'status' => false]);
        } else {
            Componente::destroy($request->id);
            return response(['id' => $request->id, 'status' => true]);
        }
    }
}
