<?php

namespace App\Http\Controllers\Proy;

use App\_clases\proyectos\Funcion;
use App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional;
use App\_clases\proyectos\plan\cadena_funcional\Finalidad;
use App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional;
use App\_clases\proyectos\plan\cadena_funcional\Programa;
use App\_clases\proyectos\plan\cadena_funcional\Componente;
use App\_clases\proyectos\Proyecto;
use App\_clases\siaf\Especifica;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Fpdf;
use Response;

use App\_clases\proyectos\ProyectosPDFF;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Object_;
use Yajra\Datatables\Facades\Datatables;

class ProyectoAsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'cli_nombre' => 'required|max:255',
            'cli_telefono' => 'max:255',
            'cli_distrito' => 'max:255',
            'cli_direccion' => 'max:255',
        ]);
        $cliente = new Cliente();
        $cliente->cli_nombre = $request->cli_nombre;
        $cliente->cli_telefono = $request->cli_telefono;
        $cliente->cli_distrito = $request->cli_distrito;
        $cliente->cli_direccion = $request->cli_direccion;
        $cliente->save();
        return redirect('cliente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return view('web.cliente.show',['cliente'=>Cliente::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {

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
        return redirect('proyectos/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cliente::destroy($id);
    }

}
