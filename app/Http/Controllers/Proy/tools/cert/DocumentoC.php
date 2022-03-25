<?php

namespace App\Http\Controllers\Proy\tools\cert;

use App\_clases\proyectos\tools\certificar\Documento;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DocumentoC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $anio = $request->anio;
        return Documento::whereBetween('doc_fecha',[$anio.'-01-01', $anio.'-12-31'])->orderBy('doc_reg_sisgedo', 'desc')->get();

        if($request->listar){
            //dd(Documento::where('doc_fecha',$anio)->orderBy('doc_reg_sisgedo', 'desc')->toSql());
            //return view('proyectos.herramientas.certificar.documento.listar', ['anio'=>$anio,'documentos'=>Documento::whereBetween('doc_fecha',[$anio.'-01-01', $anio.'-12-31'])->orderBy('doc_reg_sisgedo', 'desc')->get()]);
        }
        else{
            return view('proyectos.herramientas.certificar.documento.index',['anio'=>$anio]);
        }
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
        $doc                        = ($request->id == null)?new Documento():Documento::find($request->id);

        $doc->doc_documento         = $request->doc_documento;
        $doc->doc_fecha             = $request->doc_fecha;
        $doc->doc_oficina           = $request->doc_oficina;
        $doc->doc_reg_sisgedo       = $request->doc_reg_sisgedo;
        $doc->save();
        return response(['ok'=>1]);
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
