<?php

namespace App\Http\Controllers\Tramite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \App\Dependencia;
use \App\Archivador;
use \App\User;
use Auth;
class CatalogoController extends Controller
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

    public function archivador()
    {
        
        //$anio = Date('Y');
        /*$carbon = Carbon::now();
        $periodos =[];
        for($i = $carbon->format('Y'); $i >= 2015; $i--){
            $periodos[]=[$i];
        }*/
        
        return view('tramite.catalogos.archivador');
    }

    public function tipoDocumento()
    {
        return view('tramite.catalogos.tipodocumento');
    }

    public function prioridades()
    {
        return view('tramite.catalogos.tipoprioridad');
    }

    public function recepcion()
    {
        return view('tramite.catalogos.formarecepcion');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return $this->archivador($request);
    }

    public function createTipoDocumento(Request $request)
    {
        return $this->tipoDocumento($request);
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
    public function edit(Request $request, $id)
    {
        return $this->archivador($request);
    }

    public function editTipoDocumento(Request $request, $id)
    {
        return $this->tipoDocumento($request);
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
