<?php

namespace App\Http\Controllers\Tramite;

use App\Documento;
use App\DocumentoMain;
use App\Mail\MesaElectronica\SolicitudTramite;
use App\Models\MesaElectronica\DocumentoExterno;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;


use App\Operacion;
use App\TipoDocumentoCorrel;
use App\Dependencia;
use App\Plantilla;
use App\DocGenerado;
use App\File;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Mail;
use phpDocumentor\Reflection\Types\Object_;
use Storage;
use Intervention\Image\ImageManagerStatic as Image;

class DocumentoController extends Controller
{

    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', [
            'except' => [
                'listarAnexos',
                'printPdf',
                'printPdf2',
                'printPdfR',
                'buscarDocumento',
                'buscarDocDigital',
                'buscarDocExterno',
                'nuevoDocExterno',
                'fileSave',
                'upload',
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $where = [
            ['o.oper_procesado', '=', 0],
            ['o.oper_iddependencia', '=', Auth::user()->depe_id],
            ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
        ];
        if (is_numeric($request->iddocumento) || $request->iddocumento == null)
            $request->iddocumento = intval($request->iddocumento);
        else
            return json_encode((Object)['current_page' => 1, 'data' => [], 'total' => 0]);
        if ($request->idadmin != null)
            $where[] = ['o.oper_idusuario', $request->idadmin];
        if ($request->iddocumento != null)
            $where[] = ['iddocumento', $request->iddocumento];
        if ($request->oper_idtope != null)
            $where[] = ['o.oper_idtope', $request->oper_idtope];
        if ($request->docu_digital != null)
            $where[] = ['docu_digital', $request->docu_digital];
        return Documento::select([
            'o.idoperacion',
            'iddocumento',
            'docu_idexma',
            'docu_origen',
            'docu_fecha_doc',
            'o.oper_forma',
            'o.oper_acciones',
            'o.oper_detalledestino',
            'docu_folios',
            'td.tdoc_descripcion',
            'docu_numero_doc',
            'docu_siglas_doc',
            'docu_firma',
            'docu_cargo',
            'docu_asunto',
            'docu_iddependencia as depe_origen',
            'o.oper_idtope',
            'o.oper_depeid_d as depe_destino',
            'o.oper_usuid_d',
            'docu_idtipodocumento',
            //'u.adm_name as name_usuario_destino',
            //'u.adm_lastname as lastname_usuario_destino',
            'docu_idusuario',
            //'u.depe_id',
            'o.oper_idusuario',
            'u1.adm_estado',
            'docu_doc_generado',
            'docu_firma_electronica',
            'docu_digital',
            'depe.depe_recibetramite',
            'o.created_at',
        ])
            ->with('docuArchivo')
            ->join('tram_operacion as o', 'iddocumento', '=', 'o.oper_iddocumento')
            ->join('tram_tipodocumento as td', 'docu_idtipodocumento', '=', 'td.idtdoc')
            ->leftJoin('tram_dependencia AS depe', 'o.oper_iddependencia', '=', 'depe.iddependencia')
            //->leftJoin('admin as u', 'oper_usuid_d', '=', 'u.id')
            ->leftJoin('admin as u1', 'o.oper_idusuario', '=', 'u1.id')
            ->where($where)
            ->where(function ($query) {
                $query->where('o.oper_idtope', '=', 1)
                    ->orWhere('o.oper_idtope', '=', 2);
            })
            ->orderBy('o.idoperacion', 'asc')
            ->paginate(10);

    }

    public function countDocumento($tipo)
    {
        switch ($tipo) {
            case '1' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '<>', 3],
                        ['oper_idtope', '<>', 4],
                    ];
                }
                break;
            case '2' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '=', 2],
                    ];
                }
                break;
            case '3' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '<>', 3],
                        ['oper_idtope', '<>', 4],
                        ['oper_idusuario', '=', Auth::user()->id],
                    ];
                }
                break;
            case '4' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_depeid_d', '=', Auth::user()->depe_id],
                        //['oper_idusuario', '<>', Auth::user()->id],
                        ['oper_idtope', '=', 2],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                    ];

                    return Operacion::where($where)
                        ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                        ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                        ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia')
                        ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                        ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
                        ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
                        ->count();
                }
                break;
            case '5' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_depeid_d', '=', Auth::user()->depe_id],
                        ['oper_usuid_d', '=', Auth::user()->id],
                        ['oper_idtope', '=', 2],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                    ];

                    return Operacion::where($where)
                        ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                        ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                        ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia')
                        ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                        ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
                        ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
                        ->count();
                }
                break;
            case '6' :
                {
                    $where = [
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['oper_procesado', '=', 0],
                        ['oper_idtope', '<>', 1],
                        ['oper_idtope', '<>', 2],
                    ];
                    return Operacion::where($where)
                        ->count();
                }
                break;
            case '7' :
                {
                    $where = [
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['oper_procesado', '=', 0],
                        ['oper_idtope', '<>', 1],
                        ['oper_idtope', '<>', 2],
                        ['oper_idusuario', '=', Auth::user()->id],
                    ];
                    return Operacion::where($where)
                        ->count();
                }
                break;
            case '8' :
                {
                    $where = [
                        ['plt_iddependencia', '=', Auth::user()->depe_id],
                    ];
                    return Plantilla::where($where)
                        ->count();
                }
                break;
            case '9' :
                {
                    $where = [
                        ['plt_iddependencia', '=', Auth::user()->depe_id],
                        ['plt_idadmin', '=', Auth::user()->id],
                    ];
                    return Plantilla::where($where)
                        ->count();
                }
                break;
            case '10' :
                {
                    $where = [
                        ['dgen_iddependencia', '=', Auth::user()->depe_id],
                    ];
                    return DocGenerado::where($where)
                        ->count();
                }
                break;
            case '11' :
                {
                    $where = [
                        ['dgen_iddependencia', '=', Auth::user()->depe_id],
                        ['dgen_idadmin', '=', Auth::user()->id],
                    ];
                    return DocGenerado::where($where)
                        ->count();
                }
                break;
            case '12' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '=', 2],
                        ['oper_idusuario', '=', Auth::user()->id],
                    ];
                }
                break;
            case '13' :
                {
                    $where = [
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['oper_procesado', '=', 0],
                        ['oper_idtope', '<>', 1],
                        ['oper_idtope', '<>', 2],
                        ['oper_idusuario', '=', Auth::user()->id],
                        ['oper_tarchi_id', '=', 0],
                    ];
                    return Operacion::where($where)
                        ->count();
                }
                break;
            case '14' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '<>', 3],
                        ['oper_idtope', '<>', 4],
                        ['docu_digital', true],
                    ];
                }
                break;
            case '15' :
                {
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_iddependencia', '=', Auth::user()->depe_id],
                        ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
                        ['oper_idtope', '<>', 3],
                        ['oper_idtope', '<>', 4],
                        ['oper_idusuario', '=', Auth::user()->id],
                        ['docu_digital', true],
                    ];
                }
                break;
        }
        return Operacion::where($where)
            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
            ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
            ->count();

    }

    public function obtenerTotal()
    {

        $arreglo = [
            "totalProceso"               => $this->countDocumento(1),
            "derivadosProceso"           => $this->countDocumento(2),
            "usuarioProceso"             => $this->countDocumento(3),
            "totalRecibir"               => $this->countDocumento(4),
            "usuarioRecibir"             => $this->countDocumento(5),
            "totalArchivado"             => $this->countDocumento(6),
            "usuarioArchivados"          => $this->countDocumento(7),
            "totalPlantilla"             => $this->countDocumento(8),
            "usuarioPlantilla"           => $this->countDocumento(9),
            "totalDocGenerados"          => $this->countDocumento(10),
            "usuarioDocGenerados"        => $this->countDocumento(11),
            "usuarioDerivadosProceso"    => $this->countDocumento(12),
            'usuariosArchivadosTemporal' => $this->countDocumento(13),
            'totalMpv'                   => $this->countDocumento(14),
            'usuariosMpv'                => $this->countDocumento(15),
        ];
        return response()->json((Object)$arreglo);
    }

    public function buscarDocDigital(Request $request)
    {
        $recaptcha_url      = env('RECAPTCHA_URL');
        $recaptcha_secret   = env('RECAPTCHA_SECRET');
        $recaptcha_response = $request->token;
        $recaptcha          = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha          = json_decode($recaptcha);
        if ($recaptcha->success) {
            $documento = Documento::select('iddocumento')
                ->where('iddocumento', '=', $request->iddocumento)
                ->where('docu_contrasenia', '=', $request->docu_contrasenia)
                ->get();


            if (count($documento) > 0) {
                $digitales = File::select('id', 'id_documento', 'file_url')
                    ->where('id_documento', '=', $request->iddocumento)
                    ->get();
                $digi      = [];
                foreach ($digitales as $digital) {
                    $index = strpos($digital->file_url, '-');
                    if (!$index) {
                        $digi = ['id' => $digital->id];
                    }
                }
                return ['status' => true, 'data' => $digi];
            } else {
                return ['status' => false, 'data' => []];
            }
        }
    }

    public function buscarDocExterno(Request $request)
    {
        $recaptcha_url      = env('RECAPTCHA_URL');
        $recaptcha_secret   = env('RECAPTCHA_SECRET');
        $recaptcha_response = $request->token;
        $recaptcha          = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha          = json_decode($recaptcha);

        $carbon = new Carbon($request->docu_fecha_hasta);
        $carbon->addDay();

        if ($recaptcha->success) {

            switch ($request->busquedaEspecifico) {
                case 'false':
                    {
                        $where = function ($query) use ($request) {
                            $query->where('docu_origen', '=', 2);
                            $count         = 0;
                            $currentOpcion = '';
                            foreach (json_decode($request->selectOption) as $opcion => $value) {
                                if ($value) {
                                    $count++;
                                    $currentOpcion = $opcion;
                                }
                            }
                            if ($count > 1)
                                $query->where($where = function ($query) use ($request) {
                                    $opciones = json_decode($request->selectOption);
                                    if (false && env("DB_CONNECTION") == 'mysql') {
                                        $cadena = '';
                                        if ($opciones->docu_detalle)
                                            $cadena .= 'docu_detalle, ';
                                        if ($opciones->docu_firma)
                                            $cadena .= 'docu_firma, ';
                                        if ($opciones->docu_numero_doc)
                                            $cadena .= 'docu_numero_doc, ';
                                        if ($opciones->docu_siglas_doc)
                                            $cadena .= 'docu_siglas_doc, ';
                                        if ($opciones->docu_asunto)
                                            $cadena .= 'docu_asunto, ';
                                        if ($opciones->docu_dni)
                                            $cadena .= 'docu_dni, ';
                                        $cadena = substr($cadena, 0, -2);
                                        $query->WhereRaw("MATCH($cadena) AGAINST('" . $request->docu_asunto . "')");
                                    } else
                                        foreach (explode(" ", $request->docu_asunto) as $dato) {

                                            $query->where($where = function ($query) use ($opciones, $dato) {
                                                if ($opciones->docu_detalle)
                                                    $query->orWhere('docu_detalle', 'LIKE', "%$dato%");
                                                if ($opciones->docu_firma)
                                                    $query->orWhere('docu_firma', 'LIKE', "%$dato%");
                                                if ($opciones->docu_numero_doc && is_numeric($dato))
                                                    $query->orWhere('docu_numero_doc', '=', $dato);
                                                if ($opciones->docu_siglas_doc)
                                                    $query->orWhere('docu_siglas_doc', 'LIKE', "%$dato%");
                                                if ($opciones->docu_asunto)
                                                    $query->orWhere('docu_asunto', 'LIKE', "%$dato%");
                                                if ($opciones->docu_dni && is_numeric($dato))
                                                    $query->orWhere('docu_dni', 'LIKE', "%$dato%");
                                            });
                                        }
                                });
                            elseif ($currentOpcion === 'docu_numero_doc' || $currentOpcion === 'docu_dni')
                                if (is_numeric($request->docu_asunto) || $request->docu_asunto == null)
                                    $query->where($currentOpcion, '=', intval($request->docu_asunto));
                                else
                                    $query->where($currentOpcion, 'LIKE', "%" . str_replace(" ", "%", $request->docu_asunto) . "%");
                        };
                    }
                    break;
                case 'true':
                    {

                        $where = [
                            ['docu_origen', '=', 2],
                        ];

                        if ($request->docu_asunto != null)
                            $where[] = [
                                'docu_asunto',
                                'LIKE',
                                "%" . str_replace(" ", "%", $request->docu_asunto) . "%",
                            ];
                        if ($request->docu_dni != null)
                            $where[] = ['docu_dni', '=', $request->docu_dni];
                        if ($request->docu_firma != null)
                            $where[] = ['docu_firma', 'LIKE', "%$request->docu_firma%"];
                        if ($request->docu_detalle != null)
                            $where[] = ['docu_detalle', 'LIKE', "%$request->docu_detalle%"];
                        if ($request->docu_numero_doc != null)
                            $where[] = ['docu_numero_doc', '=', $request->docu_numero_doc];
                        if ($request->docu_iddependencia != null)
                            $where[] = ['docu_iddependencia', '=', $request->docu_iddependencia];
                        if ($request->docu_siglas_doc != null)
                            $where[] = ['docu_siglas_doc', 'LIKE', "%$request->docu_siglas_doc%"];
                    }
                    break;
            }

            return Documento::select([
                'iddocumento',
                'docu_idexma',
                'docu_fecha_doc',
                'docu_folios',
                'docu_detalle',
                'td.tdoc_descripcion',
                'docu_numero_doc',
                'docu_siglas_doc',
                'docu_firma',
                'docu_cargo',
                'docu_asunto',
                'docu_dni',
            ])
                ->join('tram_tipodocumento as td', 'td.idtdoc', '=', 'docu_idtipodocumento')
                ->whereBetween('docu_fecha_doc', [$request->docu_fecha_desde, $request->docu_fecha_hasta])
                ->where($where)
                ->orderBy('iddocumento', 'asc')
                ->paginate(15);
        }
    }

    public function documentoDerivar(Request $request)
    {
        $r = true;
        foreach ($request->operSelected as $idOpe) {
            $o = Operacion::find($idOpe);
            if ($o == null)
                Log::info('Error personalizado de Walther : ' . json_encode(['request' => $request->all()]));
            if (!Operacion::derivar($o, (Object)$request->derivaciones))
                $r = false;
        }
        return json_encode((object)[
            'status' => $r,
            'msg'    => ($r) ? "la derivacion se hizo correctamente" : "hubo un problema al intentar grabar la derivacion",
        ]);
    }

    public function documentoArchivar(Request $request)
    {
        Operacion::docArchivarAdjuntar($request->idDocumento, (Object)$request->datoDocumento);
    }

    public function documentoAdjuntar(Request $request)
    {
        Operacion::docArchivarAdjuntar($request->idDocumento, (Object)$request->datoDocumento);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function porRecibir(Request $request)
    {
        $where = [
            ['o.oper_procesado', '=', 0],
            ['o.oper_depeid_d', '=', Auth::user()->depe_id],
            ['o.oper_idtope', '=', 2],
            ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
        ];

        if (is_numeric($request->iddocumento) || $request->iddocumento == null)
            $request->iddocumento = intval($request->iddocumento);
        else
            return json_encode((Object)['current_page' => 1, 'data' => [], 'total' => 0]);

        if ($request->iddocumento != null) {
            $where[] = ['iddocumento', '=', $request->iddocumento];
        }
        if ($request->idadmin != null) {
            $where[] = ['o.oper_usuid_d', '=', $request->idadmin];
        }

        return Documento::select([
            'o.idoperacion',
            'iddocumento',
            'docu_idexma',
            'docu_origen',
            'docu_fecha_doc',
            'o.oper_forma',
            'docu_folios',
            'td.tdoc_descripcion',
            'docu_numero_doc',
            'docu_siglas_doc',
            'ddoc.depe_nombre as depe_nombre_destino',
            'docu_detalle',
            'ddest.depe_nombre as depe_nombre_origen',
            'docu_firma',
            'docu_cargo',
            'docu_asunto',
            'docu_digital',
            'u.adm_name as name_usuario',
            'u.adm_lastname as lastname_usuario',
            'o.created_at',
            'u1.adm_name as name_usuario_destino',
            'u1.adm_lastname as lastname_usuario_destino',
            'o.oper_usuid_d',
        ])
            ->with('docuArchivo')
            ->join('tram_operacion as o', 'iddocumento', '=', 'o.oper_iddocumento')
            ->join('tram_tipodocumento as td', 'docu_idtipodocumento', '=', 'td.idtdoc')
            ->leftJoin('tram_dependencia as ddoc', 'o.oper_depeid_d', '=', 'ddoc.iddependencia')
            ->leftJoin('tram_dependencia as ddest', 'docu_iddependencia', '=', 'ddest.iddependencia')
            ->leftJoin('admin AS u1', 'o.oper_usuid_d', '=', 'u1.id')
            ->join('admin AS u', 'o.oper_idusuario', '=', 'u.id')
            ->where($where)
            ->orderBy('o.idoperacion', 'asc')
            ->paginate(10);

    }

    public function recepcionar(Request $request)
    {

        Operacion::recepcion($request->recibir, (Object)$request->derivaciones, $request->tipoDoc);
    }

    public function archivados(Request $request)
    {
        $where = [

            ['o.oper_iddependencia', '=', Auth::user()->depe_id],
            ['o.oper_procesado', '=', 0],
        ];

        if (is_numeric($request->iddocumento) || $request->iddocumento == null)
            $request->iddocumento = intval($request->iddocumento);
        else
            return json_encode((Object)['current_page' => 1, 'data' => [], 'total' => 0]);

        if ($request->oper_idusuario != null) {
            $where[] = ['o.oper_idusuario', '=', $request->oper_idusuario];
        }
        if ($request->idarch != null) {
            $where[] = ['o.oper_idarchivador', '=', $request->idarch];
        }
        if ($request->oper_tarchi_id != null) {
            $where[] = ['o.oper_tarchi_id', '=', $request->oper_tarchi_id];
        }
        if ($request->iddocumento != null) {
            $where[] = ['o.oper_iddocumento', '=', $request->iddocumento];
        }

        return Documento::select([
            'o.idoperacion',
            'iddocumento',
            'o.oper_iddocumento',
            'o.oper_iddocumento_adj',
            'ta.arch_periodo',
            'ta.arch_nombre',
            'tdo.tdoc_descripcion',
            'docu_origen',
            'docu_fecha_doc',
            'docu_numero_doc',
            'docu_siglas_doc',
            'docu_firma',
            'docu_cargo',
            'o.oper_acciones',
            'docu_asunto',
            'docu_digital',
            'td.depe_nombre',
            'o.created_at as fecha_archivado',
            'a.adm_name',
            'a.adm_lastname',
            'o.oper_idprocesado',
        ])
            ->with('docuArchivo')
            ->join('tram_operacion as o', 'iddocumento', '=', 'o.oper_iddocumento')
            ->join('tram_tipodocumento as tdo', 'docu_idtipodocumento', '=', 'tdo.idtdoc')
            ->join('tram_dependencia as td', 'o.oper_iddependencia', '=', 'td.iddependencia')
            ->leftJoin('tram_archivador as ta', 'o.oper_idarchivador', '=', 'ta.idarch')
            ->join('admin as a', 'o.oper_idusuario', '=', 'a.id')
            ->where($where)
            //->whereIn('oper_idtope', [3, 4])
            ->where(function ($query) {
                $query->where('o.oper_idtope', '=', 3)
                    ->orWhere('o.oper_idtope', '=', 4);
            })
            ->orderBy('o.idoperacion', 'desc')
            ->paginate(10);

    }

    public function devolverProceso(Request $request)
    {
        $r = Operacion::devolverdocProceso($request->devolver);
        return json_encode((object)[
            'status' => $r,
            'msg'    => ($r) ? "la operacion se realizo correctamente" : "hubo un problema al intentar realizar la operacion",
        ]);
    }

    public function eliminarDerivacion(Request $request)
    {
        $r = Operacion::eliminarDocDerivacion($request->devolver);
        return json_encode((object)[
            'status' => $r,
            'msg'    => ($r) ? "la operacion se realizo correctamente" : "hubo un problema al intentar realizar la operacion",
        ]);
    }

    public function liberarDocumento(Request $request)
    {
        $r = Operacion::liberarDocProceso($request->idOperacion, (Object)$request->datoOperacion);
        return json_encode((Object)[
            'status' => $r,
            'msg'    => ($r) ? "Se libero correctamente el documento" : "hubo un problema al intentar realizar la operacion",
        ]);
    }


    public function generarObservacion(Request $request)
    {
        $r = Operacion::generarDocObservacion($request->idOperacion, (Object)$request->datoOperacion);
        return json_encode((Object)[
            'status' => $r,
            'msg'    => ($r) ? "Se registro correctamente la observacion" : "hubo un problema al intentar realizar la operacion",
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $documento = (Object)$request->documento;
        if (!isset($documento->docu_idexma))
            $documento->docu_idexma = '';
        if (!isset($documento->docu_digital))
            $documento->docu_digital = false;
        $create = ($documento->iddocumento == null);
        if ($create) {
            $anio        = substr($documento->docu_fecha_doc, 0, 4);
            $where       = [
                ['tdco_idtipodocumento', '=', $documento->docu_idtipodocumento],
                ['tdco_iddependencia', '=', $documento->docu_iddependencia],
                ['tdco_idusuario', '=', ($documento->docu_tipo) ? $documento->docu_idusuario : null],
                ['tdco_periodo', '=', $anio],
            ];
            $correlativo = TipoDocumentoCorrel::select('id', 'tdco_numero')->where($where)->first();

            if ($correlativo != null) {
                $documento->correlativo     = $correlativo->id;
                $documento->docu_numero_doc = str_pad($correlativo->tdco_numero, 6, "0", STR_PAD_LEFT);
            }
        }
        try {
            return DocumentoController::guardarDocumeto($documento, (Object)$request->derivaciones, true, $request->edit,  (Object)$request->operaciones);
        } catch (QueryException $e) {
            Log::info('Error personalizado de Walther guardar documento : ' . json_encode([
                    'error'   => $e,
                    'request' => $request->all(),
                ]));
            report($e);
            abort(500, $e);
        }
    }

    public function enviarSMS()
    {
        return Operacion::enviarSMS();
    }

    public static function guardarDocumeto($r_doc, $derivaciones, $ret = false, $edit,  $operaciones_adjuntar)
    {
        return DB::transaction(function () use ($r_doc, $derivaciones, $ret, $edit, $operaciones_adjuntar) {
            //creamos el documento o obtenemos el documento dependiendo si existe iddocumento o no
            $create = (!isset($r_doc->iddocumento) || $r_doc->iddocumento == null);
            $doc    = ($create) ? new Documento() : Documento::find($r_doc->iddocumento);
            $doc= $doc->fill((Array)$r_doc);
            //obtener ultimo id registro de documento main para crear un nuevo expediente de ser el caso
            if (($r_doc->docu_idexma == null || $r_doc->docu_idexma == '') && $create) {
                $expediente             = new DocumentoMain;
                $expediente->dmai_idusu = $r_doc->docu_idusuario;
                $expediente->save();
                $doc->docu_idexma = $expediente->iddocumentomain;
            } else {
                $doc->docu_idexma = $r_doc->docu_idexma;
            }

            $doc->docu_iddependencia        = ($r_doc->docu_iddependencia == null) ? Auth::user()->depe_id : $r_doc->docu_iddependencia;//dependencia cuando se recepciona por mesa de partes
            $doc->docu_firma                = ($r_doc->docu_firma == null) ? 'Edite' : $r_doc->docu_firma;
            $doc->docu_idtipodocumento      = ($r_doc->docu_idtipodocumento == null) ? 5 : $r_doc->docu_idtipodocumento;//tipo documento cuando se recepciona por mesa de partes
            $doc->docu_numero_doc           = ($r_doc->docu_numero_doc > 0) ? $r_doc->docu_numero_doc : 0;
            $doc->docu_forma                = 0;//default  0 -> Original   1 -> Copia
            $doc->docu_relacionado          = 0;//default
            $doc->docu_idusuario            = Auth::id();
            $doc->docu_estado               = 1;//por defecto 1
            if ($create) {
                $doc->docu_contrasenia = Str::random(8);
            }
            $doc->save();
            if (count($r_doc->docu_archivo) > 0) {
                $anio = substr($doc->docu_fecha_doc, 0, 4);
                $path = '\\' . $anio . '\\' . $doc->docu_iddependencia . '\\' . $doc->docu_idtipodocumento;
                $path .= ($doc->docu_tipo) ? '\\' . $doc->docu_idusuario : '';
                DocumentoController::guardarFile($r_doc->docu_archivo, $doc, $path);
            }
            if ($doc->docu_origen == 1 && $create) {
                TipoDocumentoCorrel::addCorrelativo($doc, $r_doc->correlativo);
            }

            if ($create) {
                //operación de registro
                $op                   = new Operacion();
                $op->oper_iddocumento = $doc->iddocumento;
                if ($doc->docu_origen == 2) {
                    $op->oper_iddependencia = $doc->docu_idusuariodependencia;
                } else {
                    $op->oper_iddependencia = $doc->docu_iddependencia;
                }
                $op->oper_idusuario = $doc->docu_idusuario;
                $op->oper_idtope    = 1;
                $op->oper_forma     = 0;
                //requeridos
                $op->oper_procesado = false;
                //$op->enviarSMS(); falta implementar
                $op->save();
                if ($derivaciones != null) {
                    Operacion::derivar($op, $derivaciones);
                }
            } else {
                $op = Operacion::where('oper_iddocumento', '=', $doc->iddocumento)->orderBy('idoperacion', 'asc')->first();
                if ($derivaciones != null) {
                    Operacion::derivar($op, $derivaciones);
                }
            }
            $generado = collect($r_doc->docu_archivo)->where('file_generado', 1);
            if (count($generado) == 1 && $generado->first()['edit']) {
                $doc->load('operaciones');
                $operaciones = collect($doc->operaciones);
                $first       = $operaciones->first();
                $destinos    = $operaciones
                    ->where('oper_idprocesado', $first->idoperacion)
                    ->where('oper_es_destino', 1);
                DocumentoController::guardarFileGenerado($generado->first(), $doc, $path, $destinos->toArray());
            }
            if ($operaciones_adjuntar != null) {
                Operacion::adjuntarRespuesta($doc->getIdString(), $operaciones_adjuntar);
            }

            if ($ret)
                return $doc;
            else
                return ['iddocumento' => $doc->iddocumento, 'docu_idexma' => $doc->docu_idexma];
        });
    }

    public function getFileHtml(File $file)
    {
        return Storage::disk('tramite')->get($file->file_html);
        return Response::make($file, 200, ['Content-Type' => Storage::disk('tramite')->getMimeType($file->file_html)]);
    }

    public static function guardarFileGenerado($archivo, Documento $docu, $path, $destinos)
    {
        $archivo  = (Object)$archivo;
        $has_id   = isset($archivo->id) && $archivo->id != null && $archivo->id != 'null';
        $file_doc = (!$has_id) ? new File() : File::find($archivo->id);
        $doc_gen  = [
            'dgen_derivaciones' => $destinos,
            'dgen_referencias'  => $docu->docu_referencias,
            'dgen_html'         => $archivo->file_html,];
        $file     = $path . '\\' . $docu->getIdString() . '.pdf';
        $html     = '\\html' . $path . '\\' . $docu->getIdString() . '.html';
        Storage::disk('tramite')->put($file, DocGeneradoController::printPdf2((Object)$doc_gen, $docu)::Output($docu->getIdString() . '.pdf', 'S'));
        Storage::disk('tramite')->put($html, $archivo->file_html);
        $size = Storage::disk('tramite')->size($file);

        $file_doc->file_html      = $html;
        $file_doc->file_url       = $file;
        $file_doc->file_name      = $archivo->file_name;
        $file_doc->file_tipo      = $archivo->file_tipo;
        $file_doc->file_size      = $size;
        $file_doc->file_mostrar   = $archivo->file_mostrar;
        $file_doc->file_principal = $archivo->file_principal;
        $file_doc->file_generado  = $archivo->file_generado;
        $file_doc->id_documento   = $docu->getIdString();
        $file_doc->save();
    }

    public static function guardarFile(Array $docu_archivo, $docu, $path)
    {
        foreach ($docu_archivo as $archivo) {
            $archivo      = (Object)$archivo;
            $has_id       = isset($archivo->id) && $archivo->id != null && $archivo->id != 'null';
            $has_url      = isset($archivo->file_url) && $archivo->file_url != null && $archivo->id != 'null';
            $has_generado = (isset($archivo->file_generado) && $archivo->file_generado);
            //dd($has_id);
            $file_doc = (!$has_id) ? new File() : File::find($archivo->id);
            if ($has_url && !$has_id && $archivo->file_mostrar) {
                if (strpos($archivo->file_tipo, 'image') === 0) {

                    $maxiAncho      = 1500;
                    $maxiAlto       = 1500;
                    $archivosImagen = Storage::disk('tramite')->get($archivo->file_url);
                    $imagen         = Image::make($archivosImagen);

                    $anchura       = $imagen->width();
                    $altura        = $imagen->height();
                    $relacionAncho = $anchura / $maxiAncho;
                    $relacionAlto  = $altura / $maxiAlto;
                    if ($relacionAlto > $relacionAncho && $relacionAlto > 1)
                        // resize the image to a height of 200 and constrain aspect ratio (auto width)
                        $imagen->resize(null, $maxiAlto, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    else if ($relacionAncho > 1)
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $imagen->resize($maxiAncho, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    $porcion = explode("/", $archivo->file_url)[1];
                    $file    = $path . '\\' . $docu->getIdString() . '-' . $porcion;
                    Storage::disk('tramite')->put($file, $imagen->encode('jpg', 80));
                    Storage::disk('tramite')->delete($archivo->file_url);
                } else {
                    $porcion = explode("/", $archivo->file_url)[1];
                    $file    = $path . '\\' . $docu->getIdString() . '-' . $porcion;
                    Storage::disk('tramite')->move($archivo->file_url, $file);
                }
                $file_doc->file_url       = $file;
                $file_doc->file_name      = $archivo->file_name;
                $file_doc->file_tipo      = $archivo->file_tipo;
                $file_doc->file_size      = $archivo->file_generado?0:$archivo->file_size;//falta colocar cuando es doc_generado
                $file_doc->file_mostrar   = $archivo->file_mostrar;
                $file_doc->file_principal = $archivo->file_principal;
                $file_doc->file_generado  = $archivo->file_generado;
                $file_doc->id_documento   = $docu->getIdString();
                $file_doc->save();
            } elseif (!$archivo->file_mostrar && $has_id) {
                Storage::disk('tramite')->delete($archivo->file_url);
                $file_doc->delete();

            } elseif (!$archivo->file_mostrar) {
                Storage::disk('tramite')->delete($archivo->file_url);

            } elseif ($has_id && $archivo->file_size == null) {
                $size = Storage::disk('tramite')->size($archivo->file_url);
                $file_doc->file_size = $size;
                $file_doc->save();
            }
        }
    }

    public function buscarDocumento(Request $request)
    {
        $documento = Documento::select(
            [
                'iddocumento',
                'docu_idexma as expediente',
                'docu_origen',
                'tdo.tdoc_descripcion',
                'docu_numero_doc',
                'docu_siglas_doc',
                'docu_fecha_doc',
                'docu_folios',
                'docu_asunto',
                'td.depe_nombre as unidad',
                'td2.depe_nombre as dependencia',
                'docu_firma',
                'docu_cargo',
                'docu_proyectado',
                'docu_emailorigen',
                'docu_telef',
            ])
            ->join('tram_tipodocumento as tdo', 'docu_idtipodocumento', '=', 'tdo.idtdoc')
            ->join('admin as a', 'docu_idusuario', '=', 'a.id')
            ->join('tram_dependencia as td', 'docu_iddependencia', '=', 'td.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td.depe_depende', '=', 'td2.iddependencia')
            ->where('iddocumento', $request->iddocumento)
            ->first();
        if ($request->only_document)
            return $documento;
        $relacionados = Documento::select(
            [
                'iddocumento',
                'tdo.tdoc_descripcion',
                'docu_numero_doc',
                'docu_siglas_doc',
                'docu_asunto',
                'docu_archivo',
            ])
            ->join('tram_tipodocumento as tdo', 'docu_idtipodocumento', '=', 'tdo.idtdoc')
            ->join('tram_operacion', 'oper_iddocumento', '=', 'iddocumento')
            ->where('oper_iddocumento_adj', $request->iddocumento)
            ->get();

        $operaciones = Operacion::select([
            'td2.depe_abreviado as dependencia',
            'tram_operacion.created_at',
            DB::raw('(SELECT op.created_at FROM tram_operacion AS op WHERE op.oper_idprocesado = tram_operacion.idoperacion LIMIT 1) as fecha_procesado'),
            'tram_operacion.oper_idtope',
            'ta.arch_nombre',
            'ta.arch_periodo',
            'tram_operacion.oper_forma',
            'td.depe_nombre as unidad',
            'a.adm_name as nombre',
            'a.adm_lastname as apellido',
            'td3.depe_nombre as depe_destino',
            'a2.adm_name as adm_name_destino',
            'a2.adm_lastname as adm_lastname_destino',
            'tram_operacion.oper_detalledestino',
            'tram_operacion.oper_acciones',
            'tram_operacion.oper_iddocumento_adj',
            'tram_operacion.idoperacion',
            'tram_operacion.oper_procesado',
            'tram_operacion.oper_idprocesado',
        ])
            ->join('admin as a', 'tram_operacion.oper_idusuario', '=', 'a.id')
            ->join('tram_dependencia as td', 'tram_operacion.oper_iddependencia', '=', 'td.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td.depe_depende', '=', 'td2.iddependencia')
            ->leftJoin('tram_dependencia as td3', 'tram_operacion.oper_depeid_d', '=', 'td3.iddependencia')
            ->leftJoin('admin as a2', 'tram_operacion.oper_usuid_d', '=', 'a2.id')
            ->leftJoin('tram_archivador as ta', 'tram_operacion.oper_idarchivador', '=', 'ta.idarch')
            ->where('tram_operacion.oper_iddocumento', $request->iddocumento)
            ->orderBy('idoperacion', 'asc')
            ->get();
        $digitales   = File::select('id', 'file_url', 'file_name', 'file_tipo', 'file_size', 'file_mostrar', 'file_principal', 'id_documento','created_at')
            ->where('id_documento', '=', $request->iddocumento)
            ->get();

        return json_encode((Object)[
            "documento"    => $documento,
            "operaciones"  => $operaciones,
            'relacionados' => $relacionados,
            'digitales'    => $digitales,
        ]);
    }

    public function bloqueoDocumentos()
    {
        $fechaActual = Carbon::now();

        $diasMaximo = Dependencia::find(Auth::user()->depe_id);
        $temp       = Carbon::now();
        $temp->subDays($diasMaximo->depe_diasmaxenproceso);

        $where  = [
            ['oper_procesado', '=', 0],
            ['oper_iddependencia', '=', Auth::user()->depe_id],
            ['tram_operacion.created_at', '<', $temp->toDateTimeString()],
        ];
        $return = [];

        $bloqueoDoc = Operacion::select([
            'oper_iddocumento',
            'idoperacion',
            'tram_operacion.created_at',
            'a.adm_name',
            'a.adm_lastname',
            'tdep.depe_nombre as oficina_destino',
            'ud.adm_name as usuario_destino_name',
            'ud.adm_lastname as usuario_destino_lastname',
            'dep.depe_nombre',
            'tdoc.tdoc_descripcion',
            'td.docu_numero_doc',
            'td.docu_siglas_doc',
        ])
            ->join('admin as a', 'oper_idusuario', '=', 'a.id')
            ->leftJoin('tram_dependencia as tdep', 'oper_depeid_d', '=', 'tdep.iddependencia')
            ->leftJoin('admin as ud', 'ud.id', '=', 'oper_usuid_d')
            ->join('tram_documento as td', 'td.iddocumento', '=', 'oper_iddocumento')
            ->join('tram_dependencia as dep', 'td.docu_iddependencia', '=', 'dep.iddependencia')
            ->join('tram_tipodocumento as tdoc', 'td.docu_idtipodocumento', '=', 'tdoc.idtdoc')
            ->where($where)
            //->whereIn('oper_idtope', [1, 2])
            ->where(function ($query) {
                $query->where('oper_idtope', '=', 1)
                    ->orWhere('oper_idtope', '=', 2);
            })
            ->orderBy('tram_operacion.created_at', 'asc')
            ->get();

        foreach ($bloqueoDoc as $op) {
            $return[] = [
                'oper_iddocumento' => str_pad($op->oper_iddocumento, 8, "0", STR_PAD_LEFT),
                'created_at'       => $op->created_at->toDateTimeString(),
                'remite'           => $op->adm_name . " " . $op->adm_lastname,
                'oficina_destino'  => $op->oficina_destino,
                'usuario_destino'  => $op->usuario_destino_name . " " . $op->usuario_destino_lastname,
                'depe_nombre'      => $op->depe_nombre,
                'tdoc_descripcion' => $op->tdoc_descripcion . " " . str_pad($op->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "-" . $op->docu_siglas_doc,
                'dias'             => $op->created_at->diffInDays($fechaActual),
            ];
        }
        if (count($return) > 0)
            return json_encode((Object)['tipo' => 1, 'status' => false, 'data' => $return]);
        $return = $this->bloquedoDocumentoRecibir();
        if (count($return) > 0)
            return json_encode((Object)['tipo' => 2, 'status' => false, 'data' => $return]);
        return json_encode((Object)['status' => true, 'data' => []]);
    }

    public function bloquedoDocumentoRecibirLiberar(Request $request)
    {
        $return = $this->bloquedoDocumentoRecibir(false, $request->docu_idexma);
        return json_encode((Object)['tipo' => 2, 'status' => false, 'data' => $return]);

    }

    public function bloquedoDocumentoRecibir($depe = true, $exp = null)
    {
        $fechaActual = Carbon::now();

        $temp  = Carbon::now();
        $temp1 = Carbon::now();
        $temp->subDays(env("BLOQUEO_DIASRECIBIR"));
        $temp1->subDays(30);

        $where = [
            ['oper_procesado', '=', 0],
            ['oper_idtope', '=', 2],
            ['td.idtdoc', '<>', env("TIPO_DOC_PAPELETA")],
        ];

        if ($depe) {
            $where[] = ['oper_depeid_d', '=', Auth::user()->depe_id];
            $where[] = ['tram_operacion.created_at', '<', $temp->toDateTimeString()];
        } else {
            $where[] = ['oper_depeid_d', '=', 185];
            $where[] = ['d.docu_idexma', '=', $exp];
            $where[] = ['tram_operacion.created_at', '<', $temp1->toDateTimeString()];
        }
        $return = [];

        /*if($request->idadmin !=null){
            $where[]=['oper_usuid_d', '=', $request->idadmin];
        }*/

        $bloqueoDoc = Operacion::select([
            'idoperacion',
            'oper_iddocumento',
            'd.docu_idexma',
            'tram_operacion.created_at',
            'oper_forma',
            'td.tdoc_descripcion',
            'd.docu_numero_doc',
            'd.docu_siglas_doc',
            'ddoc.depe_nombre as depe_nombre_destino',
            'ddest.depe_nombre as depe_nombre_origen',
            'u.adm_name as name_usuario',
            'u.adm_lastname as lastname_usuario',
            'u1.adm_name as name_usuario_destino',
            'u1.adm_lastname as lastname_usuario_destino',
        ])
            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
            ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
            ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia')
            ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
            ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
            ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
            ->where($where)
            ->orderBy('tram_operacion.created_at', 'asc')
            ->get();

        foreach ($bloqueoDoc as $op) {
            $return[] = [
                'oper_iddocumento' => str_pad($op->oper_iddocumento, 8, "0", STR_PAD_LEFT),
                'docu_idexma'      => str_pad($op->docu_idexma, 8, "0", STR_PAD_LEFT),
                'created_at'       => $op->created_at->toDateTimeString(),
                'remite'           => $op->name_usuario . " " . $op->lastname_usuario,
                'oficina_destino'  => $op->depe_nombre_destino,
                'usuario_destino'  => $op->name_usuario_destino . " " . $op->lastname_usuario_destino,
                'depe_nombre'      => $op->depe_nombre_origen,
                'tdoc_descripcion' => $op->tdoc_descripcion . " " . str_pad($op->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "-" . $op->docu_siglas_doc,
                'dias'             => $op->created_at->diffInDays($fechaActual),
            ];
        }
        return $return;
    }

    public function liberarDocCas(Request $request)
    {

        $liberar     = (Object)$request->liberarCas;
        $fechaActual = Carbon::now();

        $fechaActual->subDays(30);

        $where = [
            ['oper_procesado', '=', 0],
            ['oper_idtope', '=', 2],
            ['oper_depeid_d', '=', 185],
            ['tram_operacion.created_at', '<', $fechaActual->toDateTimeString()],
            ['d.docu_idexma', '=', $liberar->docu_idexma],
        ];

        $liberarCas = Operacion::select([
            'idoperacion',
            'oper_iddocumento',
        ])
            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
            ->where($where)
            ->orderBy('idoperacion', 'asc')
            ->get();
        $count      = $liberarCas;
        $arr        = [];
        foreach ($liberarCas as $id => $lib) {
            $arr[] = $lib->idoperacion;
        }
        DB::table('tram_operacion')->whereIn('idoperacion', $arr)->delete();

        return $count;
    }

    public function show($id)
    {
        return Documento::find($id)->getForDocumento();
    }

    public function listarAnexos($password, $iddocumento)
    {
        $documento = Documento::find($iddocumento);
        if ($documento->docu_contrasenia == $password) {
            $documento->load('anexos', 'tipoDocumento');
            //return $documento->numero_documento;
            return view('tramite.documentos.listadoAnexos', ['doc' => $documento]);
        } else
            abort(403, 'No autorizado.');
    }

    public function printPdf(Request $request)
    {

        $data = ($request->tipo == 1) ? $request->id_documento : $request->id_documento_externo;

        return File::getPdf($request->id, $data, $request->tipo);
    }

    public function printPdf2($idFile, $password, $idDocumento)
    {
        $exp       = explode('.', $idDocumento);
        $documento = Documento::find($exp[0]);
        if ($documento == null)
            abort(404);
        else if ($documento->docu_contrasenia == $password)
            return File::getPdf($idFile, $exp[0], 1);
        else
            abort(403, 'No autorizado.');
    }

    public function printPdfR($idFile, $idDocumento)
    {
        $exp = explode('.', $idDocumento);
        return File::getPdf($idFile, $exp[0], 1);
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

    public function buscarRegistroDocumento(Request $request)
    {
        $doc = Documento::select([
            'iddocumento',
            'docu_fecha_doc',
            'docu_numero_doc',
            'docu_siglas_doc',
            'de.depe_nombre',
        ])
            ->leftJoin('tram_dependencia as de', 'docu_iddependencia', '=', 'de.iddependencia')
            ->where('iddocumento', '=', $request->registro)
            ->get();

        if (count($doc) > 0)
            return json_encode((Object)['status' => true, 'data' => $doc]);
        else
            return json_encode((Object)['status' => false, 'data' => $doc]);
    }


    public function nuevoDocExterno(Request $request)
    {

        $recaptcha_url      = env('RECAPTCHA_URL');
        $recaptcha_secret   = env('RECAPTCHA_SECRET');
        $recaptcha_response = $request->token;
        $recaptcha          = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha          = json_decode($recaptcha);

        if ($recaptcha->success) {
            try {
                if ($request->id == null) {
                    $rules = [
                        'docu_iddependencia'    => 'required',
                        'id_dependencia'        => 'required',
                        'docu_firma'            => 'required'
                    ];
                    $this->validate($request, $rules);

                    $documento = new DocumentoExterno();
                    $documento->fill($request->only($documento->getFillable()));
                    $documento->docu_estado = 0;
                    $documento->docu_token  = Str::random(50);
                    $documento->save();
                    if (count($request->docu_archivo) > 0) {
                        $anio = substr($documento->docu_fecha_doc, 0, 4);
                        $path = '\\mesa_virtual\\' . $anio . '\\' . $documento->id_dependencia . '\\' . $documento->docu_idtipodocumento;
                        $path .= ($documento->docu_tipo) ? '\\' . $documento->docu_idusuario : '';
                        $this->fileSave($request->docu_archivo, $documento->getIdString(), $path);
                    }
                    //\MultiMail::to($documento->docu_emailorigen)->from(array_rand (config('multimail.emails')))->queue(new SolicitudTramite($documento));
                    return response()->json(['status' => true, 'documento'=> $documento], 200);
                } else {
                    $documento                       = DocumentoExterno::find($request->id);
                    $documento->docu_idtipodocumento = $request->docu_idtipodocumento;
                    $documento->docu_numero_doc      = $request->docu_numero_doc;
                    $documento->docu_siglas_doc      = $request->docu_siglas_doc;
                    $documento->docu_folios          = $request->docu_folios;
                    $documento->docu_asunto          = $request->docu_asunto;
                    $documento->docu_estado          = 3;
                    $documento->save();
                    if (count($request->docu_archivo) > 0) {
                        $anio = substr($documento->docu_fecha_doc, 0, 4);
                        $path = '\\mesa_virtual\\' . $anio . '\\' . $documento->id_dependencia . '\\' . $documento->docu_idtipodocumento;
                        $path .= ($documento->docu_tipo) ? '\\' . $documento->docu_idusuario : '';
                        $this->fileSave($request->docu_archivo, $documento->getIdString(), $path);
                    }
                    return response()->json(['status' => true, 'documento'=> $documento], 200);
                }
            }
            catch(\Exception $e) {
                return response()->json(['status' => false], 200);
            }

        }
    }

    public function fileSave(Array $docu_archivo, $id, $path)
    {
        foreach ($docu_archivo as $archivo) {
            $archivo  = (Object)$archivo;
            $file_doc = ($archivo->id == null || $archivo->id == 'null') ? new File() : File::find($archivo->id);
            if ($archivo->file_url != null && $archivo->file_mostrar && $archivo->id == null) {
                $porcion = explode("/", $archivo->file_url)[1];
                $file    = $path . '\\' . $id . '-' . $porcion;
                if (strpos($archivo->file_tipo, 'image') === 0) {

                    $maxiAncho      = 1500;
                    $maxiAlto       = 1500;
                    $archivosImagen = Storage::disk('tramite')->get($archivo->file_url);
                    $imagen         = Image::make($archivosImagen);

                    $anchura       = $imagen->width();
                    $altura        = $imagen->height();
                    $relacionAncho = $anchura / $maxiAncho;
                    $relacionAlto  = $altura / $maxiAlto;
                    if ($relacionAlto > $relacionAncho && $relacionAlto > 1)
                        // resize the image to a height of 200 and constrain aspect ratio (auto width)
                        $imagen->resize(null, $maxiAlto, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    else if ($relacionAncho > 1)
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $imagen->resize($maxiAncho, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    Storage::disk('tramite')->put($file, $imagen->encode('jpg', 80));
                    Storage::disk('tramite')->delete($archivo->file_url);
                } else {
                    Storage::disk('tramite')->move($archivo->file_url, $file);
                }
                $file_doc->file_url             = $file;
                $file_doc->file_name            = $archivo->file_name;
                $file_doc->file_tipo            = $archivo->file_tipo;
                $file_doc->file_size            = $archivo->file_size;
                $file_doc->file_mostrar         = $archivo->file_mostrar;
                $file_doc->file_principal       = $archivo->file_principal;
                $file_doc->id_documento_externo = $id;
                $file_doc->save();
            } elseif (!$archivo->file_mostrar && $archivo->id != null) {
                Storage::disk('tramite')->delete($archivo->file_url);
                $file_doc->delete();

            } elseif (!$archivo->file_mostrar) {

                Storage::disk('tramite')->delete($archivo->file_url);
            }
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            //get filename with extension
            $extencion       = $request->file('file')->getClientOriginalExtension();
            $filenametostore = 'temp/' . Str::random(15) . '.' . $extencion;
            Storage::disk('tramite')->put($filenametostore, fopen($request->file('file'), 'r+'));
            //Store $filenametostore in the database
            if (isset($filenametostore)) {
                return response()->json(['status' => true, 'data' => $filenametostore], 200);
            } else {
                return response()->json(['status' => false, 'data' => ''], 200);
            }
        }
    }

    public function entidadByCategoria($id)
    {
        $respuesta = file_get_contents(str_replace('%s', $id, env('ENTIDAD_CATEGORIA')));
        $respuesta = (array)json_decode($respuesta);
        if (isset($respuesta)) {
            return response()->json(['status' => true, 'data' => $respuesta], 200);
        } else {
            return response()->json(['status' => false, 'data' => []], 200);
        }
    }

    public function cuo()
    {
        $respuesta = file_get_contents(env('CUO'));
        $respuesta = json_decode($respuesta);
        if (isset($respuesta)) {
            return response()->json(['status' => true, 'data' => $respuesta], 200);
        } else {
            return response()->json(['status' => false, 'data' => NULL], 200);
        }
    }

    public function remplaceFile(Request $request)
    {
       
        if ($request->hasFile('file')) {
            $status = Storage::disk('tramite')->put($request->url, fopen($request->file('file'), 'r+'));
            $size = Storage::disk('tramite')->size($request->url);
            $file_doc = File::find($request->id);
            $file_doc->file_size      = $size;
            $file_doc->save();
            return response()->json(['status' => $status]);
        } else {
            return response()->json(['status' => false]);
        }
       
    }
}
