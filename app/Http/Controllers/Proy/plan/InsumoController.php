<?php

namespace App\Http\Controllers\Proy\plan;

use App\_clases\proyectos\plan\Componente;
use App\_clases\proyectos\plan\Insumo;
use App\_clases\proyectos\Proyecto;
use App\_clases\siaf\Especifica;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InsumoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($proy)
    {
        $anios=[2017];
        $proyecto =Proyecto::find($proy);
        return view('proyectos.plan.insumo.index',[
            'anios'=>$anios,
            'proyecto' => $proyecto,
            'componentes'=>Componente::getComponentesToSelect($proyecto->proy_cod_siaf),
            'espeficicas' =>Especifica::getEspecificasToSelectforObra()
        ]);
    }
    public function listar($proy)
    {
        $anios=[2017];
        $componentes = Componente::where('comp_prod_proy', '=', $proy)->get();
        return view('proyectos.plan.insumo.list',[
            'anios'=>$anios,
            'componentes'=>$componentes,
            'espeficicas' =>Especifica::getEspecificasToSelectLight()
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->id=='-1'){
            $insumo = new Insumo();
            $insumo->componente_id =            $request->componente_id;
            $insumo->insu_nombre =              $request->insu_nombre;
            $insumo->insu_unidad_medida =       $request->insu_unidad_medida;
            $insumo->insu_cantidad =            $request->insu_cantidad;
            $insumo->insu_id_clasifi =          $request->insu_id_clasifi;
            $insumo->save();
        }
        else{
            $insumo = Insumo::find($request->id);
            $insumo->componente_id =            $request->componente_id;
            $insumo->insu_nombre =              $request->insu_nombre;
            $insumo->insu_unidad_medida =       $request->insu_unidad_medida;
            $insumo->insu_cantidad =            $request->insu_cantidad;
            $insumo->insu_id_clasifi =          $request->insu_id_clasifi;
            $insumo->save();;
        }
        return ['ok'=>'true','id'=>$insumo->id];
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
