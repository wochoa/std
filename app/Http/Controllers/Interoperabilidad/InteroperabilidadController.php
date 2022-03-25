<?php

namespace App\Http\Controllers\Interoperabilidad;

use App\Documento;
use App\Operacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Interoperabilidad\Anexo;
use Storage;
use DB;
use App\Models\Interoperabilidad\Despacho;
use App\Models\Interoperabilidad\Recepcion;
use App\Models\Interoperabilidad\Docexterno;
use App\Models\Interoperabilidad\Docprincipal;
use App\Http\Controllers\Tramite\DocumentoController;

class InteroperabilidadController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $documento = Documento::where('iddocumento', $request->idDocumento)->with(['archivos','dependencia'])->first();
            $documento->load('anexos', 'archivoPrincipal');
            $entidad = (Object)$request->entidad;
            //despacho
            $despacho = new Despacho();
            $despacho->vnumregstd = $documento->iddocumento;//NUMERO DE REGISTRO DEL SISTEMA DE TRAMITE DOCUMENTARIO DE LA ENTIDAD(nullable)
            //$despacho->vanioregstd = '';//AÑO DE REGISTRO EN EL SISTEMA DE TRAMITE DOCUMENTARIO DE LA ENTIDAD(nullable)
            $despacho->ctipdociderem = '1';//TIPO DE DOCUMENTO DE IDENTIDAD DEL REMITENTE 1 = DNI, 2 = CARNET DE EXTRANJERIA
            $despacho->vnumdociderem = $documento->dependencia['depe_dni'];//NUMERO DE DOCUMENTO DE ENTIDAD DEL REMITENTE
            $despacho->vcoduniorgrem = $documento->docu_idusuariodependencia;//CODIGO DE UNIDAD ORGANICA DEL REMITENTE
            $despacho->vuniorgrem = $documento->dependencia['depe_nombre'];//NOMBRE DE LA UNIDAD ORGANICA DE LA ENTIDAD EMISORA QUE REGISTRA EL DOCUMENTO (nullable)
            $despacho->vcuo = $request->cuo;//CODIGO UNICO DE OPERACION DEL DOCUMENTO (nullable)
            $despacho->vrucentrec = $entidad->vrucent;//RUC DE LA ENTIDAD RECEPTORA
            $despacho->vnomentrec = $entidad->vnoment;//NOMBRE DE LA ENTIDAD RECEPTORA
            // $despacho->vnumregstdrec = '';//NUMERO DE REGISTRO EN EL SISTEMA DE TRAMITE DOCUMENTARIO DE LA ENTIDAD RECEPTORA (nullable)
            // $despacho->vanioregstdrec = '';//AÑO DE REGISTRO EN EL SISTEMA DE TRAMITE DOCUMENTARIO DE LA ENTIDAD RECEPTORA (nullable)
            // $despacho->vuniorgstdrec = '';//NOMBRE DE LA UNIDAD ORGANICA A LA QUE SE LE DERIVO EL DOCUMENTO DE LA ENTIDAD RECEPTORA (nullable)
            // $despacho->vdesanxstdrec = ''; //(nullable)
            // $despacho->dfecregstdrec = '';//FECHA DE REGISTRO EN EL SISTEMA DE TRAMITE DOCUMENTARIO DE LA ENTIDAD RECEPTORA (nullable)
            // $despacho->vusuregstdrec = '';//USUARIO QUE REGISTRA EL DOCUMENTO EN EL SISTEMA DE TRAMITE DOCUMENTARIO DE LA ENTIDAD RECEPTORA (nullable)
            // $despacho->bcarstdrec = '';//CARGO DE RECEPCION EN EL SISTEMA DE TRAMITE DOCUMENTRIO DE LA ENTIDAD RECEPTORA (nullable)
            // $despacho->vobs = ''; //(nullable)
            //$despacho->vcuoref = '';//CUO DE REFERENCIA PARA LA IDENTIFICACION DE LOS DOCUMENTOS OBSERVADOS QUE ESTAN SIENDO SUBSANADOS (nullable)
            $despacho->cflgest = 'P';//(Default) FLAG QUE INDICA SI EL ESTADO DEL DOCUMENTO P = PENDIENTE, E = ENVIADO, R = RECIBIDO, O = OBSERVADO, S = SUBSANADO, N = NO PRESENTADO
            $despacho->cflgenv = 'N';//default
            //$despacho->dfecenv = '';//FECHA DE ENVIO DEL DOCUMENTO (nullable)
            $despacho->vusureg = Auth::user()->id;//USUARIO QU REALIZA EL REGISTRO DEL DOCUMENTO EN LA TABLA DE DESPACHO
            $despacho->dfecreg = now();//(default) FECHA DE REGISTRO DEL DOCUMENTO EN LA TABLA DE DESPACHO
            // $despacho->vusumod = '';//USUARIO QUE MODIFICA (nullable)
            // $despacho->dfecmod = '';//FECHA DE MODIFICACION (nullable)
            $despacho->save();

            //externo
            $docExterno = new Docexterno();
            $docExterno->vnomentemi = env('TITULO_PAGINA');//NOMBRE DE LA ENTIDAD EMISORA
            $docExterno->ccodtipdoc = $documento->docu_idtipodocumento == 1? '01':'02';//TIPO DE DOCUMENTO DE TRAMITE
            $docExterno->vnumdoc = $documento->docu_idtipodocumento == 1? 'OFICIO':'CARTA';//NOMBRE DE DOCUMENTO DE TRAMITE
            $docExterno->dfecdoc = $documento->docu_fecha_doc;//FECHA DEL DOCUMENTO
            //implementar
            $docExterno->vuniorgdst = 'PREDIDENCIA';//NOMBRE DE LA UNIDAD ORGANICA DE DESTINO
            $docExterno->vnomdst = 'JUAN PEREZ';//NOMBRE DEL DESTINATARIO
            $docExterno->vnomcardst = 'PRESIDENTE';//CARGO DEL DESTINATARIO

            $docExterno->vasu = $documento->docu_asunto;//ASUNTO DEL DOCUMENTO
            $docExterno->cindtup = 'S';//INDICADOR DE TUPA S= SIN TUPA, C = CONTUPA (nullable)
            $docExterno->snumanx = count($documento->anexos);//NUMERO DE ANEXOS (nullable)
            $docExterno->snumfol = $documento->docu_folios;//(default 0)NUMERO DE FOLIO
            $docExterno->vurldocanx = route('tramite.documento.listarAnexos',['psw'=>$documento->docu_contrasenia,'name'=>$documento->iddocumento]);//URL DEL DOCUMENTO ANEXO (nullable)

            $docExterno->sidemiext = $despacho->sidemiext;//foreign_key de iotdtc_despacho (nullable)
            //$docExterno->sidrecext = 3;//foreign_key de iotdtc_recepcion (nullable)
            $docExterno->save();

            //documento_principal
            $principal = new Docprincipal();
            $principal->siddocext = $docExterno->siddocext;//FOREIGN KEY "iotdtm_doc_externo"
            $principal->vnomdoc = $documento->archivoPrincipal->file_name;//NOMBRE DEL DOCUMENTO

            $archivosData = Storage::disk('tramite')->get($documento->archivoPrincipal->file_url);
            $principal->bpdfdoc =  base64_encode($archivosData);//convertir a base 64 CONTIENE DOCUMENTO PDF
            //$principal->ccodest = '';//CÓDIGO DE ESTADO DEL REGISTRO 1 = ACTIVO, 0 = INACTIVO'
            //$principal->dfecreg = '';//(default) FECHA DE REGISTRO
            $principal->save();

            foreach ($documento->anexos as $archivo) {
                    //Anexos
                    $anexo = new Anexo();
                    $anexo->siddocext = $docExterno->siddocext;//FOREIGN KEY "iotdtm_doc_externo"
                    $anexo->vnomdoc = $archivo['file_name'];//NOMBRE DEL DOCUMENTO
                    //$anexo->dfecreg = '';//(default) FECHA DE REGISTRO
                    $anexo->save();

            }
            //(new DocumentoController())->documentoArchivar(new Request());
            Operacion::docArchivarAdjuntar($request->idOperacion, (Object)$request->datoDocumento);

            $status = true;
            return response()->json(['status' => $status, 'msg'    => ($status) ? "Se registro correctamente " : "hubo un problema al intentar realizar la operacion"], 200);
        });

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

    public function despachos(Request $request)
    {
        return Despacho::query()->paginate(15);
    }

    public function recepcionados(Request $request)
    {
        return Recepcion::query()->paginate(15);
    }
}
