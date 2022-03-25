<?php

namespace App\Http\Controllers\Tramite;

use App\Documento;
use Carbon\Carbon;
use App\DocumentoMain;
use App\Mail\MesaElectronica\ObservarTramite;
use App\Mail\MesaElectronica\tramiteAceptado;
use App\Models\MesaElectronica\DocumentoExterno;
use App\Operacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class DocumentoExternoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'observaciones',
                'documentos_observados',
                'bus_documentos_observados',
            ],
        ]);
    }

    public function index(Request $request)
    {

        $where = function ($query) use ($request) {
            $query->where(function ($query) {
                $query->where('id_dependencia', auth()->user()->dependencia->depe_depende);
            });           
            if ($request->docu_estado != null)
                $query->where(function ($query) use ($request) {
                    $query->where('docu_estado', $request->docu_estado);
                });               
            else
            $query->where(function ($query){
                $query->where('docu_estado', 0)
                ->orWhere('docu_estado', '=', 3);
            });
            if ($request->id != null)
                $query->where(function ($query) use ($request) {
                    $query->where('docu_dni', 'LIKE', "%$request->id%")
                    ->orWhere('docu_ruc', 'LIKE', "%$request->id%")
                    ->orWhere('docu_firma', 'LIKE', "%$request->id%");
                });               
        };

        return DocumentoExterno::with(['docuArchivo', 'tipoDocumento'])
            ->where($where)
            ->paginate(10);
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

    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {
        //
    }

    public function archivar(Request $request)
    {
        foreach ($request->idDocumento as $id => $iddocumento) {
            $documento = DocumentoExterno::find($iddocumento);
            $documento->docu_estado = 1;
            $documento->docu_motivo_archivamiento = $request->motivo;
            $documento->updated_by = \Auth::id();
            $documento->save();
            \MultiMail::to($documento->docu_emailorigen)->from(array_rand (config('multimail.emails')))->queue(new ObservarTramite($documento));
        }
    }

    public function derivar(Request $request)
    {
        $user = \Auth::user();
        $r = true;
        if ($request->derivaciones != null)
            foreach ($request->operSelected as $id => $iddocumento_externo) {
                $d_ext = DocumentoExterno::find($iddocumento_externo);
                $documento = new Documento();
                if (($request->docu_idexma == null || $request->docu_idexma == '') && $request->iddocumento == null) {
                    $expediente = new DocumentoMain;
                    $expediente->dmai_idusu = $user->id;
                    $expediente->save();
                    $documento->docu_idexma = $expediente->iddocumentomain;
                } else {
                    $documento->docu_idexma = $request->docu_idexma;
                }
                $documento->docu_origen = 2;
                $documento->docu_tipo = 0;
                $documento->docu_idprioridad = 1;
                $documento->docu_idrecepcion = 1;
                $documento->docu_forma = 0;
                $documento->docu_digital = 1;
                $documento->docu_relacionado = 0;
                $documento->docu_estado = 1;
                $documento->docu_clastupa = 9;
                $documento->docu_diasatencion = 0;
                $documento->docu_iddependencia = $d_ext->docu_iddependencia;//mandar por defecto persona natural o juridica
                $documento->docu_detalle = $d_ext->docu_detalle;
                $documento->docu_firma = $d_ext->docu_firma;
                $documento->docu_cargo = $d_ext->docu_cargo;
                $documento->docu_idtipodocumento = $d_ext->docu_idtipodocumento;
                $documento->docu_fecha_doc = $d_ext->docu_fecha_doc;
                $documento->docu_numero_doc = ($d_ext->docu_numero_doc > 0) ? $d_ext->docu_numero_doc : 0;
                $documento->docu_siglas_doc = $d_ext->docu_siglas_doc;
                $documento->docu_folios = $d_ext->docu_folios;
                $documento->docu_asunto = $d_ext->docu_asunto;
                $documento->docu_dni = $d_ext->docu_dni;
                $documento->docu_telef = $d_ext->docu_telef;
                $documento->docu_domic = $d_ext->docu_domic;
                $documento->docu_emailorigen = $d_ext->docu_emailorigen;
                $documento->docu_idusuario = $user->id;
                $documento->docu_idusuariodependencia = $user->depe_id;
                $documento->save();
                $d_ext->iddocumento = $documento->iddocumento;
                $d_ext->docu_idexma = $documento->docu_idexma;
                $d_ext->docu_estado = 2;
                $d_ext->updated_by = \Auth::id();

                $d_ext->save();

                foreach ($d_ext->docuArchivo as $index => $value) {
                    $d_ext->docuArchivo[$index]->id_documento = $documento->iddocumento;
                }
                $d_ext->push();
                //operación de registro
                $op = new Operacion();
                $op->oper_iddocumento = $documento->iddocumento;

                $op->oper_iddependencia = $documento->docu_idusuariodependencia;
                $op->oper_idusuario = $documento->docu_idusuario;
                $op->oper_idtope = 1;
                $op->oper_forma = 0;
                $op->oper_procesado = false;
                $op->save();
                if (!Operacion::derivar($op, $request->derivaciones))
                    $r = false;

                \MultiMail::to($documento->docu_emailorigen)->from(array_rand (config('multimail.emails')))->queue(new tramiteAceptado($documento));
            }
        return [
            'status' => $r,
            'msg'    => ($r) ? "la derivacion se hizo correctamente" : "hubo un problema al intentar grabar la derivacion",
        ];
    }

    public function transferir(Request $request)
    {
        foreach ($request->idDocumento as $id => $iddocumento) {
            $docuento = DocumentoExterno::find($iddocumento);
            $docuento->id_dependencia = $request->id_dependencia;
            $docuento->save();
        }
    }

    public function editar(Request $request, DocumentoExterno $mpv)
    {
        $mpv->docu_numero_doc = $request->docu_numero_doc;
        $mpv->docu_siglas_doc = $request->docu_siglas_doc;
        $mpv->docu_folios = $request->docu_folios;
        $mpv->docu_asunto = $request->docu_asunto;
        $mpv->save();
    }

    public function pdf(Request $request)
    {
        $request->tipo;
        $carbon = new Carbon($request->fecha_hasta);
        $carbon->addDay();
        $where = [
            ['id_dependencia', auth()->user()->dependencia->depe_depende],
        ];
        if ($request->tipo == 1 && $request->docu_estado != null) {
            $where[] = ['tram_documento_externo.docu_estado', $request->docu_estado];
        }
        if ($request->tipo == 1) {
            $externo = DocumentoExterno::query()
                ->where($where)
                ->whereBetween('created_at', [$request->fecha_desde, $carbon->toDateString()])
                ->take(5000)
                ->get();
        } else {
            $externo = DocumentoExterno::select('tram_documento_externo.*')
                ->join('tram_documento as doc','doc.iddocumento','=','tram_documento_externo.iddocumento')
                ->where($where)
                ->where('tram_documento_externo.docu_estado', 2)
                ->whereBetween('doc.created_at', [$request->fecha_desde, $carbon->toDateString()])
                ->take(5000)
                ->get();
        }


            $externo->load(['operacion','tipoDocumento']);
        return $externo->map(function ($item) {
            $documento = $item->tipoDocumento->tdoc_descripcion.' '.str_pad($item->docu_numero_doc, 4, "0", STR_PAD_LEFT) . "-" . explode("-", $item->docu_fecha_doc)[0] . "-" . $item->docu_siglas_doc;
            $documento .= "\n ".$item->docu_folios.' folios';
            return [
                'id'              => $item->iddocumento != null?(str_pad($item->iddocumento, 8, "0", STR_PAD_LEFT)."\n".str_pad($item->docu_idexma, 8, "0", STR_PAD_LEFT)):'Doc. no derivado',
                'docu_fecha_doc'  => $item->docu_fecha_doc,
                'docu_numero_doc' => $documento,
                'datos_remitente' => $item->docu_firma ."\n".$item->docu_telef ."\n".$item->docu_emailorigen,
                'docu_asunto'     => $item->docu_asunto,
                'docu_estado'     => $item->docu_estado == 0 ? 'En espera' : ($item->docu_estado == 1?'Observado':($item->docu_estado == 2 ? 'Derivado' : 'Subsanado')),
                'docu_situacion'  => ($item->docu_estado == 1 || $item->docu_estado == 3)?$item->docu_motivo_archivamiento:($item->docu_estado == 2?$item->operacion[0]->dependenciaDestino->depe_nombre:''),
            ];
        });
    }

    public function observaciones($id, $token){
        $externo = DocumentoExterno::where('docu_token', $token)
            ->where('docu_estado', 1)
            ->without(['dependencia'])
            ->with('docuArchivo');
        if($externo->count() > 0) {
            return view('tramite.tramiteVarios.mesaPartesVirtualEditar', ['externo'=>$externo->first()]);
        } else {
            $exter = DocumentoExterno::where('docu_token', $token)->first();
           return redirect()->route('registro.mesaPartesVirtual', $exter->id_dependencia);
        }
    }
    
    public function documentos_observados($depe)
    {
        //$externo=DocumentoExterno::where(['docu_estado'=>1,'id_dependencia'=>$depe])->orderBy('id','desc')->paginate(10);;

        return view('observacioneswil',['depe'=>$depe]);
        //return $externo;
    }
    public function bus_documentos_observados(Request $request)
    {
        //$depe=$request()->depe;
        $email=$request->input('correo');//$request()->correo;
        $dni=$request->input('dni');//$request()->dni;
        $telefono=$request->input('numtel');

        

        if(strlen($dni)==8){
            $externo=DocumentoExterno::where(['docu_emailorigen'=>$email,'docu_dni'=>$dni,'docu_telef'=>$telefono])->orderBy('id','desc')->paginate(10);//'docu_estado'=>1,
        }
        else{
            $externo=DocumentoExterno::where(['docu_emailorigen'=>$email,'docu_ruc'=>$dni,'docu_telef'=>$telefono])->orderBy('id','desc')->paginate(10);//'docu_estado'=>1,
        }

        

        return view('listaobservacion',['externo'=>$externo]);

        //dd($dni);
    }
    public function derivados(Request $request)
    {
        $carbon = new Carbon($request->fecha_hasta);
        $carbon->addDay();

        $where = function ($query) use ($request) {
            $query->where('id_dependencia', auth()->user()->dependencia->depe_depende)
                ->where('tram_documento_externo.docu_estado', 2);
            if ($request->id != null)
                $query->where(function ($query) use ($request) {
                    $query->where('tram_documento_externo.docu_dni', 'LIKE', "%$request->id%")
                        ->orWhere('tram_documento_externo.docu_ruc', 'LIKE', "%$request->id%")
                        ->orWhere('tram_documento_externo.docu_firma', 'LIKE', "%$request->id%");
                });                
        };

        return DocumentoExterno::select('tram_documento_externo.*')->with(['docuArchivo','operacion','tipoDocumento'])
            ->join('tram_documento as doc','doc.iddocumento','=','tram_documento_externo.iddocumento')
            ->where($where)
            ->whereBetween('doc.created_at', [$request->fecha_desde, $carbon->toDateString()])
            ->paginate(15);
    }
}
