<?php

namespace App\Http\Controllers\Tramite;

use App\Dependencia;
use App\Documento;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Support\Str;
use Storage;

class EnProcesoController extends Controller
{
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $prioridades = \DB::table('tram_prioridad')->select('idprioridad', 'prio_descripcion')->get();

        //Recepciones
        $recepciones = \DB::table('tram_recepcion')->get();

        //admin
        $usuario = User::select('id',
            DB::raw("CONCAT(adm_name,' ',adm_lastname) as nombre"),
            'adm_cargo',
            'adm_inicial')
            ->where('id', '=', Auth::user()->id)
            ->first();

        return view('tramite.documentos.proceso', ['prioridades' => $prioridades,
                                                   'recepciones' => $recepciones,
                                                   'usuario'     => $usuario]);

    }

    public function preview()
    {
        dd("hola");
    }
    public function makePlantilla()
    {
        $prioridades = \DB::table('tram_prioridad')->select('idprioridad', 'prio_descripcion')->get();


        //Recepciones
        $recepciones = \DB::table('tram_recepcion')->get();

        //admin
        $usuario = User::select(['id',
                                 DB::raw("CONCAT(adm_name,' ',adm_lastname) as nombre"),
                                 'adm_cargo',
                                 'adm_inicial'])
            ->where('id', '=', Auth::user()->id)
            ->first();

        return view('tramite.documentos.makePlantilla', ['prioridades' => $prioridades,
                                                         'recepciones' => $recepciones,
                                                         'usuario'     => $usuario]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return $this->index($request);
    }

    public function generarDocumentosCreate(Request $request)
    {
        return $this->generarDocumentos($request);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        
        $documento = Documento::find($id);

        if (isset($documento)) {
            $depe = Dependencia::select('depe_recibetramite')
                    ->where('iddependencia', '=', Documento::find($id)->docu_idusuariodependencia)
                    ->first();
            $user = Auth::user();
            if (Auth::user()->can('admin') || $user->id == Documento::find($id)->docu_idusuario || (2 == Documento::find($id)->docu_origen && Documento::find($id)->depe_origen == $user->depe_id && 1 == $depe->depe_recibetramite))
                return $this->index($request);
            else
                return redirect()->route('tramite.enproceso.index');
        } else {
            return redirect()->route('tramite.enproceso.index');
        }            
       
    }

    public function generarDocumentosEdit(Request $request, $id)
    {
        return $this->index($request);
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            //get filename with extension
            $extencion       = $request->file('file')->getClientOriginalExtension();
            $filenametostore = $request->file('file')->getClientOriginalName();
            $filenametostore = 'temp/' . Str::random(15) . '.' . $extencion;

            Storage::disk('tramite')->put($filenametostore, fopen($request->file('file'), 'r+'));
            //Store $filenametostore in the database
            return $filenametostore;
        }
    }

    public function response(Request $request)
    {
                
        return $this->index($request);
       
    }

}
