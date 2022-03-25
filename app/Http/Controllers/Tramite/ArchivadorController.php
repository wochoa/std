<?php

namespace App\Http\Controllers\Tramite;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use \App\Archivador;
use Auth;
use DB;

class ArchivadorController extends Controller
{
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        $where[] = ['arch_iddependencia', '=', Auth::user()->depe_id];
        if ($request->arch_nombre != null)
            $where[] = ['arch_nombre', 'LIKE', "%$request->arch_nombre%"];
        if ($request->arch_periodo != null)
            $where[] = ['arch_periodo', '=', "$request->arch_periodo"];

        return Archivador::select(
            'idarch',
            'arch_nombre',
            'arch_periodo',
            'arch_idusuarioa',
            'a.adm_email',
            'a.id')
            ->leftJoin('admin as a', 'a.id', '=', 'tram_archivador.arch_idusuarioa')
            ->where($where)
            ->orderBy('arch_nombre', 'asc')
            ->paginate(15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $archivador = ($request->idarch == null) ? new Archivador() : Archivador::find($request->idarch);

        $archivador->arch_iddependencia = Auth::user()->depe_id;
        $archivador->arch_idusuario = Auth::user()->id;
        $archivador->arch_nombre = $request->arch_nombre;
        $archivador->arch_periodo = $request->arch_periodo;

        if ($request->arch_idusuarioa == true) {
            $archivador->arch_idusuarioa = Auth::user()->id;
        } else {
            $archivador->arch_idusuarioa = null;
        }

        $archivador->save();

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Archivador::find($id)->getForUpdate();
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param int $id
    //  * @return \Illuminate\Http\Response
    //  */

    public function obtenerArchivadores(Request $request)
    {
        switch ($request->tipo) {

            case '3' :
                {
                    $where = [
                        ['arch_iddependencia', '=', $request->depe_id],
                    ];
                    return Archivador::select([
                        'idarch',
                        'arch_periodo',
                        'arch_nombre',
                    ])
                        ->where($where)
                        ->orderBy('arch_periodo', 'desc')
                        ->orderBy('arch_nombre', 'asc')
                        ->groupBy('idarch')
                        ->groupBy('arch_nombre')
                        ->groupBy('arch_periodo')
                        ->get()
                        ->keyBy(function ($item) {
                            return '_' . $item['idarch'];
                        });
                }
                break;
            default :
                {
                    $archivador = Archivador::select([
                        'idarch',
                        'arch_periodo',
                        'arch_nombre',
                    ])
                        ->where('arch_iddependencia', '=', Auth::user()->depe_id)
                        ->orderBy('arch_periodo', 'desc')
                        ->orderBy('arch_nombre', 'asc')
                        ->groupBy('idarch')
                        ->groupBy('arch_nombre')
                        ->groupBy('arch_periodo')
                        ->get();
                    $ar = [];
                    foreach ($archivador as $a) {
                        $ar[] = (Object)[$a->idarch, $a->arch_periodo, $a->arch_nombre];
                    }
                    return $ar;
                }
                break;
        }

    }

    public function edit(Request $request, $id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
