<?php

namespace App\Http\Controllers\Proy;

use Illuminate\Http\Request;

use App\_clases\proyectos\PresupuestoMeta;
use App\_clases\siaf\SiafMeta;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class GastosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function metas(Request $request)
    {
       return SiafMeta::getMetas($request->anio);
    }

    public static function metasHash()
    {
        $anio = Carbon::now()->year;
        return md5(utf8_decode(json_encode(SiafMeta::getMetas($anio), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )));
    }


    public function storePresupuesto(Request $request)
    {
        $count = PresupuestoMeta::where('proy_siaf_anio','=',$request->proy_siaf_anio)
                                        ->where('proy_sec_ejec','=',$request->proy_sec_ejec)
                                        ->where('proy_siaf_sec_func','=',$request->proy_siaf_sec_func)
                                        ->count();

        $presupuesto = ($count==0 && $request->id_presupuesto == null)?new PresupuestoMeta():PresupuestoMeta::find($request->id_presupuesto);

        $presupuesto->proy_siaf_anio                      = $request->proy_siaf_anio;
        $presupuesto->proy_sec_ejec                       = $request->proy_sec_ejec;
        $presupuesto->proy_siaf_sec_func                  = $request->proy_siaf_sec_func;
        $presupuesto->proy_tram_dependencia               = $request->proy_tram_dependencia;
        $presupuesto->proy_user_id                        = \Auth::id();
        $presupuesto->save();
        return $presupuesto;
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
