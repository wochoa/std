<?php

namespace App\Http\Controllers\Tramite;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dependencia;
use DB;

class EntidadExternaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where                      =[];
            $where[]                =['depe_depende', '=', null];
            $where[]                =['depe_tipo', '=', 2];
        if($request->iddependencia!=null)
            $where[]                =['iddependencia','=',"$request->iddependencia"];
        if($request->depe_nombre!=null)
            $where[]                =['depe_nombre','LIKE',"%$request->depe_nombre%"];
        if($request->depe_representante!=null)
            $where[]                =['depe_representante','LIKE',"%$request->depe_representante%"];

        $dependencias               =Dependencia::select(
                                                        'iddependencia',
                                                        'depe_nombre',
                                                        'depe_abreviado',
                                                        'depe_sigla',
                                                        'depe_representante')
                                                    ->where($where)
                                                    ->orderBy('iddependencia','asc')
                                                    ->paginate(15);
        return $dependencias;  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $dependencias                       =($request->iddependencia==null)?new Dependencia():Dependencia::find($request->iddependencia);
            $dependencias->depe_nombre          =$request->depe_nombre;
            $dependencias->depe_abreviado       =$request->depe_abreviado;
            $dependencias->depe_sigla           =$request->depe_sigla;
            $dependencias->depe_representante   =$request->depe_representante;
            $dependencias->depe_cargo           =$request->depe_cargo;
            $dependencias->depe_tipo            =2;
            $dependencias->depe_proyectado      =0;
            $dependencias->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Dependencia::select(
                                    'iddependencia',
                                    'depe_nombre',
                                    'depe_abreviado',
                                    'depe_sigla',
                                    'depe_representante',
                                    'depe_cargo',
                                    'depe_tipo',
                                    'depe_proyectado')
                                ->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
