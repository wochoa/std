<?php

namespace App\Http\Controllers\Tramite;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\TipoDocumento;
use DB;

class TipoDocumentoController extends Controller
{

    public function index(Request $request)
    {
            $where              =[];
            if($request->tdoc_descripcion!=null)
                $where[]        =['tdoc_descripcion','LIKE',"%$request->tdoc_descripcion%"];

            return TipoDocumento::select(['idtdoc',
                'tdoc_descripcion',
                'tdoc_abreviado',
                'tdoc_mpv'
            ])
                ->where($where)
                ->orderBy('idtdoc', 'asc')
                ->paginate(10);

    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $tipoDocumento                          = ($request->idtdoc==null)?new TipoDocumento():TipoDocumento::find($request->idtdoc);
        $tipoDocumento->tdoc_descripcion        = $request->tdoc_descripcion;
        $tipoDocumento->tdoc_abreviado          = $request->tdoc_abreviado;
        $tipoDocumento->tdoc_correlativo        = $request->tdoc_correlativo;
        $tipoDocumento->tdoc_mpv                = $request->tdoc_mpv;
        $tipoDocumento->save();

    }


    public function show($id)
    {
        return TipoDocumento::select(['idtdoc',
                                        'tdoc_descripcion',
                                        'tdoc_abreviado',
                                        'tdoc_correlativo',
                                        'tdoc_mpv'])
                                ->where('idtdoc',$id)
                                ->first();
    }



    public function obtenerTipoDocumento()
    {
        //reporte
        return TipoDocumento::select('idtdoc','tdoc_descripcion')
                                ->orderBy('tdoc_descripcion','asc')
                                ->get()
                                ->keyBy(function ($item){
                                    return '_'.$item['idtdoc'];
                                });

    }

    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

    }
    public function  getTipos(Request $request)
    {
        $tipo = TipoDocumento::select('idtdoc','tdoc_descripcion')
                                ->orderBy('tdoc_descripcion', 'asc')
                                ->get();
            $r = [];
            foreach($tipo as $t){
                $r[] = (Object)[$t->idtdoc,$t->tdoc_descripcion];
            }
            return $r;
    }

    public function mpv()
    {
        return TipoDocumento::select(['idtdoc','tdoc_descripcion'])
            ->where('tdoc_mpv',1)
            ->orderBy('tdoc_descripcion','asc')
            ->get();
    }
}
