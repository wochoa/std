<?php

namespace App\Http\Controllers\Tramite;

use App\DocumentoMain;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Documento;

class ExpedienteController extends Controller
{

    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => ['index', 'buscar']]);
    }

    public function index(Request $request)
    {
        return Documento::select([
            'iddocumento',
            'docu_origen',
            'docu_fecha_doc',
            'td.tdoc_descripcion',
            'docu_numero_doc',
            'docu_siglas_doc',
            'docu_asunto',
            'docu_firma',
            'tde.depe_nombre',
            'docu_idexma',
        ])
            ->join('tram_tipodocumento as td', 'docu_idtipodocumento', '=', 'td.idtdoc')
            ->leftJoin('tram_dependencia as tde', 'docu_iddependencia', '=', 'tde.iddependencia')
            ->where('docu_idexma', '=', $request->iddocumento)
            ->orderBy('docu_fecha_doc', 'asc')
            ->get();
    }


    public function buscar(Request $request)
    {
        $expediente = DocumentoMain::find($request->id);
        //return $expediente;
        $doc = [];
        if ($expediente != null) {
            $doc = Documento::select([
                'docu_idtipodocumento',
                'docu_numero_doc',
                'docu_siglas_doc',
                'docu_asunto',
            ])
                ->where('docu_idexma', '=', $expediente->iddocumentomain)
                ->orderBy('created_at', 'desc')
                ->get();
        } else
            return [];
        $expediente->doc = $doc;
        return $expediente;
        //return ['iddocumentomain'=>$expediente->iddocumentomain,'created_at'=>$expediente->created_at,'doc'=>$doc];

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
