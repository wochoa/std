<?php

namespace App\Http\Controllers\Tramite;

use App\Plantilla;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlantillasController extends Controller
{

    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [
            ['plt_iddependencia', '=', Auth::user()->depe_id],
            //['plt_idusuario','=',Auth::user()->idadmin],
        ];
        if ($request->idadmin != null)
            $where[] = ['plt_idadmin', '=', $request->idadmin];

        $p = Plantilla::where($where)
            ->where(function ($query) {
                $query->whereNull('plt_idadmin')
                    ->orWhere('plt_idadmin', '=', Auth::user()->id);
            })
            ->orderBy('plt_idadmin')
            ->orderBy('created_at', 'desc');
        //return ($p->get()[0]->plt_datos);
        return (isset($request->todo) && $request->todo) ? $p->get() : $p->paginate(10);
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

        $plantilla = ($request->id == null) ? new Plantilla() : Plantilla::find($request->id);

        $plantilla->plt_nombre        = $request->plt_nombre;
        $plantilla->plt_plantilla     = $request->plt_plantilla;
        $plantilla->plt_datos         = $request->plt_datos;
        $plantilla->plt_derivaciones  = $request->plt_derivaciones;
        $plantilla->plt_referencias   = $request->plt_referencias;
        $documento                    = (Object)$request->plt_datos['documento'];
        $plantilla->plt_idadmin       = ($documento->docu_tipo) ? $documento->docu_idusuario : null;
        $plantilla->plt_iddependencia = $documento->docu_iddependencia;

        return json_encode((Object)['status' => $plantilla->save()]);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Plantilla::find($id)->getForPlantilla();
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
    public function destroy($id)
    {
        //
    }
}
