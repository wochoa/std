<?php

namespace App\Http\Controllers\Proy\tools;

use App\_clases\proyectos\tools\modificar\Modificatoria;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ModificatoriaC extends Controller
{

    public function index(Request $request)
    {
        return Modificatoria::select(['id','modif_anio','modif_titulo','modif_fecha_aprovacion'])
                                ->where('modif_anio','=',$request->anio)
                                ->orderBy('id', 'desc')
                                ->get();
    }
    public function allPosts(Request $request)
    {

        $columns = array(
            0 =>'id',
            1 =>'title',
            2=> 'body',
            3=> 'created_at',
            4=> 'id',
        );

        $totalData = Modificatoria::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = Modificatoria::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  Modificatoria::where('id','LIKE',"%{$search}%")
                ->orWhere('title', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Modificatoria::where('id','LIKE',"%{$search}%")
                ->orWhere('title', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('posts.show',$post->id);
                $edit =  route('posts.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['title'] = $post->title;
                $nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $anio
     * @return \Illuminate\Http\Response
     */
    public function create($anio)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $anio
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $modif                              = ($request->id == null)?new Modificatoria():Modificatoria::find($request->id);

        $modif->modif_anio                  = $request->modif_anio;
        $modif->modif_titulo                = $request->modif_titulo;
        $modif->modif_fecha_aprovacion      = $request->modif_fecha_aprovacion;
        $modif->save();
        return $modif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $anio
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($anio, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $anio
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($anio, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $anio
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($anio, Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $anio
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Modificatoria::destroy($request->id);
        return response(['id'=>$request->id]);
    }
}
