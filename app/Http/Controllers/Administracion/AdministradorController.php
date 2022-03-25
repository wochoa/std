<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Dependencia;
use Caffeinated\Shinobi\Models\Role;

class AdministradorController extends Controller
{
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function administrador()
    {

        return view('layouts.plantillaAdministrador');
    }

    public function rol()
    {
        return view('administrador.roles');
    }

    public function usuario()
    {

         return view('administrador.usuariosGeneral');
    }

    public function usuarioRrhh()
    {
        return view('tramite.administracion.usuariosRrhh');
    }

    public function comunicacionIntena()
    {
        return view('administrador.comunicacionInterna');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return $this->usuario($request);
    }

    public function createRol(Request $request)
    {
        return $this->rol($request);
    }
    public function createComunicacionInterna(Request $request)
    {
        return $this->comunicacionIntena($request);
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
        return $this->usuario($request);
    }

    public function editRol(Request $request, $id)
    {
        return $this->rol($request);
    }
    public function editComunicacionInterna(Request $request)
    {
        return $this->comunicacionIntena($request);
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

    public function createRrhh(Request $request)
    {
        return $this->usuarioRrhh($request);
    }

    public function editRrhh(Request $request)
    {
        return $this->usuarioRrhh($request);
    }
}
