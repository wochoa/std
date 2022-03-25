<?php

namespace App\Http\Controllers\Proy;

use App\_clases\proyectos\TagsDetalle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TagDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->json) {
            return TagsDetalle::getToSelectedTypeHead(
                $request->tag_anio,
                $request->proyecto_id);
        }
        dd($request->json);
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
        $det = TagsDetalle::where('tag_anio' , '=', $request->tag_anio)
            ->where('proyecto_id' , '=', $request->proyecto_id)
            ->where('tag_id' , '=', $request->tag_id)->get();
        if(count($det)==0){
            $tagD = new TagsDetalle();
            $tagD->tag_anio = $request->tag_anio;
            $tagD->proyecto_id = $request->proyecto_id;
            $tagD->tag_id = $request->tag_id;
            $tagD->save();
            return response(['ok'=>1]);
        }
        else
            return response(['ok'=>0]);
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
    public function destroy($id, Request $request)
    {
        $det = TagsDetalle::where('tag_anio' , '=', $request->tag_anio)
            ->where('proyecto_id' , '=', $request->proyecto_id)
            ->where('tag_id' , '=', $request->tag_id)->get();
        if (count($det)>0) {
            foreach ($det as $d) {
                $d->delete();
            }
            return response(['ok'=>1]);
        }
        else
            return response(['ok'=>0]);
    }
}
