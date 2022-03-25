<?php

namespace App\Http\Controllers\Tramite;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Dependencia;
use App\TipoDocumento;
use App\User;
use App\Archivador;
use App\Operacion;
use App\Documento;
use Auth;
use DB;
use DateTime;
use Carbon\Carbon;

class ReporteController extends Controller
{

    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $opciones = (Object)[
            [
                'id'     => 1,
                'data'   => 'DOCUMENTOS GENERADOS POR UNID.ORG.',
                'inputs' => [
                    'docu_fecha_desde',
                    'docu_fecha_hasta',
                    'docu_origen',
                    'depe_depende',
                    'docu_iddependencia',
                    'oper_idusuario',
                    'docu_firma',
                    'docu_tipo',
                    'idtdoc',
                    'oper_depeid_d',
                    'oper_usuid_d',
                    'docu_asunto',
                    'ordenamiento',
                ],
                'pdf'    => true,
                'excel'  => true,
            ],
            [
                'id'     => 2,
                'data'   => 'DOCUMENTOS RECIBIDOS',
                'inputs' => [
                    'docu_fecha_desde',
                    'docu_fecha_hasta',
                    'depe_depende',
                    'docu_iddependencia',
                    'oper_idusuario',
                    'docu_firma',
                    'idtdoc',
                    'oper_depeid_d',
                    'oper_usuid_d',
                    'docu_asunto',
                    'ordenamiento',
                ],
                'pdf'    => true,
                'excel'  => true,
            ],
            [
                'id'     => 3,
                'data'   => 'DOCUMENTOS ARCHIVADOS/PROCESADOS',
                'inputs' => [
                    'docu_fecha_desde',
                    'docu_fecha_hasta',
                    'depe_depende',
                    'docu_iddependencia',
                    'oper_idusuario',
                    'archivador',
                    'idtdoc',
                    'ordenamiento',
                ],
                'pdf'    => true,
                'excel'  => true,
            ],
            [
                'id'     => 4,
                'data'   => 'DOCUMENTOS EN PROCESO',
                'inputs' => [
                    'depe_depende',
                    'docu_iddependencia',
                    'oper_idusuario',
                    'idtdoc',
                    'ordenamiento',
                ],
                'pdf'    => true,
                'excel'  => true,
            ],
            [
                'id'     => 5,
                'data'   => 'DOCUMENTO DERIVADOS',
                'inputs' => [
                    'docu_fecha_desde',
                    'docu_fecha_hasta',
                    'docu_origen',
                    'oper_procesado',
                    'depe_depende',
                    'docu_iddependencia',
                    'oper_idusuario',
                    'docu_firma',
                    'idtdoc',
                    'oper_depeid_d',
                    'oper_usuid_d',
                    'docu_asunto',
                    'ordenamiento',
                ],
                'pdf'    => true,
                'excel'  => true,
            ],
            [
                'id'     => 6,
                'data'   => 'FORMATO DE DOCUMENTO DERIVADOS/RECIBIR',
                'inputs' => [
                    'tipo_formato',
                    'docu_fecha_desde',
                    'docu_desde',
                    'docu_hasta',
                    'depe_depende',
                    'docu_iddependencia',
                    'oper_depeid_d',
                    'oper_usuid_d',
                    'oper_idusuario',
                    'espaciado',
                    'ordenamiento',
                ],
                'pdf'    => true,
                'excel'  => false,
            ],
            [
                'id'     => 7,
                'data'   => 'DOCUMENTOS TRAMITADOS',
                'inputs' => [
                    'docu_fecha_desde',
                    'docu_fecha_hasta',
                    'docu_origen',
                    'depe_depende',
                    'docu_iddependencia',
                    'ordenamiento',
                ],
                'pdf'    => false,
                'excel'  => true,
            ],
            [
                'id'     => 8,
                'data'   => 'ARCHIVADORES',
                'inputs' => [
                    'depe_depende',
                    'docu_iddependencia',
                    'arch_periodo',
                    'ordenamiento',
                ],
                'pdf'    => true,
                'excel'  => true,
            ],
            [
                'id'     => 9,
                'data'   => 'HOJA DE TRAMITE',
                'inputs' => [
                    'iddocumento_inicial',
                    'iddocumento_final',
                ],
                'pdf'    => true,
                'excel'  => false,
            ],
            [
                'id'     => 10,
                'data'   => 'BLOQUEO DOCUMENTOS EN PROCESO',
                'inputs' => [
                    'depe_depende',
                    'docu_iddependencia',
                    'oper_idusuario',
                ],
                'pdf'    => true,
                'excel'  => false,
            ],
            [
                'id'     => 11,
                'data'   => 'BLOQUEO DOCUMENTOS POR RECIBIR',
                'inputs' => [
                    'depe_depende',
                    'docu_iddependencia',
                    'oper_idusuario',
                ],
                'pdf'    => true,
                'excel'  => false,
            ],
            [
                'id'     => 12,
                'data'   => 'ADMINISTRAR USUARIOS',
                'inputs' => ['depe_depende'],
                'pdf'    => true,
                'excel'  => true,
            ],
            [
                'id'     => 13,
                'data'   => 'USUARIOS',
                'inputs' => [
                    'depe_depende',
                    'docu_iddependencia',
                    'ordenamiento',
                ],
                'pdf'    => true,
                'excel'  => true,
            ],
            [
                'id'     => 14,
                'data'   => 'DOCUMENTOS EXTERNO X DEPENDENCIA',
                'inputs' => [
                    'docu_fecha_desde',
                    'docu_fecha_hasta',
                    'depe_depende',
                ],
                'pdf'    => true,
                'excel'  => false,
            ],
        ];

        return view('tramite.reportes.reporte', ['opciones' => $opciones]);

    }

    public function obtenerOpciones()
    {

    }

    public function obtenerReporte(Request $request)
    {

        if (isset($request->opcion)) {
            $opcion = json_decode($request->opcion[0]);

            $carbon = new Carbon($request->docu_fecha_hasta);
            $carbon->addDay();

            switch ($opcion->id) {
                case '1':
                    {

                        $where = function ($query) use ($request) {
                            $query->where('tram_operacion.oper_idtope', '=', 1)
                                ->where('tram_operacion.oper_idprocesado', '=', null);
                            if ($request->docu_origen != null)
                                $query->where('docu_origen', '=', $request->docu_origen);
                            if ($request->docu_iddependencia != null)
                                $query->where('tram_operacion.oper_iddependencia', '=', $request->docu_iddependencia);
                            if ($request->oper_idusuario != null)
                                $query->where('tram_operacion.oper_idusuario', '=', $request->oper_idusuario);
                            if ($request->docu_tipo != null)
                                $query->where('d.docu_tipo', '=', $request->docu_tipo);
                            if ($request->idtdoc != null)
                                $query->where('td.idtdoc', '=', $request->idtdoc);
                            if ($request->docu_firma != null)
                                $query->where('d.docu_firma', 'LIKE', "%" . str_replace(" ", "%", $request->docu_firma) . "%");
                            if ($request->docu_asunto != null)
                                $query->where('d.docu_asunto', 'like', "%$request->docu_asunto%");
                            if ($request->oper_depeid_d != null)
                                $query->WhereRaw("(SELECT count(*) from tram_operacion as o WHERE o.oper_idprocesado = tram_operacion.idoperacion AND o.oper_depeid_d = $request->oper_depeid_d) > 0 ");

                        };
                        $reporte = Operacion::select([
                            'iddocumento',
                            'd.docu_idexma',
                            'd.docu_fecha_doc',
                            'td.tdoc_descripcion',
                            'd.docu_numero_doc',
                            'd.docu_siglas_doc',
                            'd.docu_folios',
                            'd.docu_asunto',
                            'tde.depe_nombre',
                            'tde1.depe_nombre as depe_destino',
                        ])
                            ->join('tram_documento as d', 'tram_operacion.oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_dependencia as tde', 'd.docu_iddependencia', '=', 'tde.iddependencia')
                            ->leftJoin('tram_operacion as op', 'op.oper_idprocesado', '=', 'tram_operacion.idoperacion')
                            ->leftJoin('tram_dependencia as tde1', 'op.oper_depeid_d', '=', 'tde1.iddependencia')
                            ->whereBetween('d.docu_fecha_doc', [$request->docu_fecha_desde, $request->docu_fecha_hasta])
                            ->where($where)
                            ->orderBy('d.created_at', $request->ordenamiento)
                            ->take(10000)
                            ->get();
                        $return = [];
                        foreach ($reporte as $op) {
                            $return[] = [
                                'iddocumento'      => str_pad($op->iddocumento, 8, "0", STR_PAD_LEFT),
                                'docu_idexma'      => str_pad($op->docu_idexma, 8, "0", STR_PAD_LEFT),
                                'docu_fecha_doc'   => $op->docu_fecha_doc,
                                'tdoc_descripcion' => $op->tdoc_descripcion . " " . str_pad($op->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "-" . explode("-", $op->docu_fecha_doc)[0] . "-" . $op->docu_siglas_doc,
                                'docu_folios'      => $op->docu_folios,
                                'docu_asunto'      => $op->docu_asunto,
                                'depe_nombre'      => $op->depe_nombre,
                                'depe_destino'     => $op->depe_destino,
                            ];
                        }
                        return $return;
                        break;

                        /*$r=$reporte;
                        foreach($reporte as $id=>$re)
                        {
                            $r[]=$re;
                        }
                        foreach($reporte as $id=> $re)
                        {
                            $r[]=$re;
                        }
                        foreach($reporte as $id=>$re)
                        {
                            $r[]=$re;
                        }*/
                        //return $r;
                    }
                case '2':
                    {

                        $where = [
                            ['oper_idtope', '=', 1],
                            ['oper_idprocesado', '>', 0],
                        ];

                        if ($request->docu_iddependencia != null)
                            $where[] = ['oper_iddependencia', '=', $request->docu_iddependencia];
                        if ($request->oper_idusuario != null)
                            $where[] = ['oper_idusuario', '=', $request->oper_idusuario];
                        if ($request->idtdoc != null)
                            $where[] = ['td.idtdoc', '=', $request->idtdoc];
                        if ($request->docu_firma != null)
                            $where[] = ['d.docu_firma', '=', $request->docu_firma];
                        if ($request->docu_asunto != null)
                            $where[] = ['docu_asunto', 'LIKE', "%$request->docu_asunto%"];

                        $reporte = Operacion::select([
                            'iddocumento',
                            'tram_operacion.created_at',
                            'td.tdoc_descripcion',
                            'd.docu_origen',
                            'd.docu_numero_doc',
                            'd.docu_siglas_doc',
                            'd.docu_fecha_doc',
                            'd.docu_folios',
                            'tde.depe_nombre',
                            'd.docu_detalle',
                            'd.docu_firma',
                            'd.docu_cargo',
                            'd.docu_asunto',
                        ])
                            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_dependencia as tde', 'd.docu_iddependencia', '=', 'tde.iddependencia')
                            ->where($where)
                            ->whereBetween('tram_operacion.created_at', [
                                $request->docu_fecha_desde,
                                $carbon->toDateString(),
                            ])
                            ->orderBy('oper_iddocumento', $request->ordenamiento)
                            ->take(10000)
                            ->get();

                        if ($reporte->count() == 0) {
                            return $reporte;
                            break;
                        } else {
                            foreach ($reporte as $op) {
                                $return[] = [
                                    'iddocumento'      => str_pad($op->iddocumento, 8, "0", STR_PAD_LEFT),
                                    'created_at'       => $op->created_at->toDateTimeString(),
                                    'tdoc_descripcion' => $op->tdoc_descripcion . " " . str_pad($op->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($op->docu_origen == 1) ? ("-" . explode("-", $op->docu_fecha_doc)[0]) : '') . "-" . $op->docu_siglas_doc,
                                    'docu_fecha_doc'   => $op->docu_fecha_doc,
                                    'docu_folios'      => $op->docu_folios,
                                    'depe_nombre'      => $op->depe_nombre,
                                    'docu_detalle'     => $op->docu_detalle,
                                    'docu_firma'       => $op->docu_firma,
                                    'docu_cargo'       => $op->docu_cargo,
                                    'docu_asunto'      => $op->docu_asunto,
                                ];
                            }
                            return $return;
                            break;
                        }

                    };
                case '3':
                    {
                        $where = [];
                        if ($request->docu_iddependencia != null)
                            $where[] = ['oper_iddependencia', '=', $request->docu_iddependencia];
                        if ($request->oper_idusuario != null)
                            $where[] = ['oper_idusuario', '=', $request->oper_idusuario];
                        if ($request->archivador != null)
                            $where[] = ['oper_idarchivador', '=', $request->archivador];
                        if ($request->idtdoc != null)
                            $where[] = ['td.idtdoc', '=', $request->idtdoc];

                        $reporte = Operacion::select([
                            'oper_iddocumento',
                            'tram_operacion.created_at',
                            'td.tdoc_descripcion',
                            'd.docu_origen',
                            'd.docu_numero_doc',
                            'd.docu_siglas_doc',
                            'd.docu_fecha_doc',
                            'd.docu_folios',
                            'tde.depe_nombre',
                            'd.docu_detalle',
                            'd.docu_firma',
                            'd.docu_cargo',
                            'd.docu_asunto',
                            'oper_tarchi_id',
                            'oper_iddocumento_adj',
                            'oper_acciones',
                        ])
                            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_dependencia as tde', 'd.docu_iddependencia', '=', 'tde.iddependencia')
                            ->whereBetween('tram_operacion.created_at', [
                                $request->docu_fecha_desde,
                                $carbon->toDateString(),
                            ])
                            ->where($where)
                            ->whereIn('oper_idtope', [3, 4])
                            ->orderBy('oper_iddocumento', $request->ordenamiento)
                            ->take(10000)
                            ->get();
                        if ($reporte->count() == 0) {
                            return $reporte;
                            break;
                        } else {
                            foreach ($reporte as $re) {
                                $return[] = [
                                    'oper_iddocumento' => str_pad($re->oper_iddocumento, 8, "0", STR_PAD_LEFT),
                                    'created_at'       => $re->created_at->toDateTimeString(),
                                    'tdoc_descripcion' => $re->tdoc_descripcion . " " . str_pad($re->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($re->docu_origen == 1) ? ("-" . explode("-", $re->docu_fecha_doc)[0]) : '') . "-" . $re->docu_siglas_doc,
                                    'docu_fecha_doc'   => $re->docu_fecha_doc,
                                    'docu_folios'      => $re->docu_folios,
                                    'depe_nombre'      => $re->depe_nombre,
                                    'docu_detalle'     => $re->docu_detalle,
                                    'docu_firma'       => $re->docu_firma,
                                    'docu_cargo'       => $re->docu_cargo,
                                    'docu_asunto'      => $re->docu_asunto,
                                    'oper_tarchi_id'   => ($re->oper_tarchi_id != null) ? ($re->oper_tarchi_id == 1) ? 'Definitivo' : 'Temporal' : "Adjuntado" . $re->oper_iddocumento_adj,
                                    'oper_acciones'    => $re->oper_acciones,
                                ];
                            }
                            return $return;
                            break;
                        }

                    }
                case '4':
                    {

                        $fechaActual = Carbon::now();

                        $where = [
                            ['oper_procesado', '=', 0],
                        ];

                        if ($request->docu_iddependencia != null)
                            $where[] = ['oper_iddependencia', '=', $request->docu_iddependencia];
                        if ($request->oper_idusuario != null)
                            $where[] = ['oper_idusuario', '=', $request->oper_idusuario];
                        if ($request->idtdoc != null)
                            $where[] = ['td.idtdoc', '=', $request->idtdoc];

                        $reporte = Operacion::select([
                            'd.iddocumento',
                            'tram_operacion.created_at',
                            'oper_forma',
                            'td.tdoc_descripcion',
                            'd.docu_origen',
                            'd.docu_numero_doc',
                            'd.docu_siglas_doc',
                            'd.docu_fecha_doc',
                            'd.docu_folios',
                            'tde.depe_nombre',
                            'd.docu_detalle',
                            'd.docu_firma',
                            'd.docu_cargo',
                            'd.docu_asunto',
                        ])
                            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_dependencia as tde', 'd.docu_iddependencia', '=', 'tde.iddependencia')
                            ->where($where)
                            ->whereIn('oper_idtope', [1, 2])
                            ->orderBy('idoperacion', $request->ordenamiento)
                            ->take(10000)
                            ->get();
                        if ($reporte->count() == 0) {
                            return $reporte;
                            break;
                        } else {
                            foreach ($reporte as $re) {
                                $return[] = [
                                    'iddocumento'      => str_pad($re->iddocumento, 8, "0", STR_PAD_LEFT),
                                    'created_at'       => $re->created_at->toDateTimeString(),
                                    'oper_forma'       => ($re->oper_forma == 0) ? 'ORIGINAL' : 'COPIA',
                                    'tdoc_descripcion' => $re->tdoc_descripcion . " " . str_pad($re->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($re->docu_origen == 1) ? ("-" . explode("-", $re->docu_fecha_doc)[0]) : '') . "-" . $re->docu_siglas_doc,
                                    'docu_fecha_doc'   => $re->docu_fecha_doc,
                                    'docu_folios'      => $re->docu_folios,
                                    'depe_nombre'      => $re->depe_nombre,
                                    'docu_detalle'     => $re->docu_detalle,
                                    'docu_firma'       => $re->docu_firma,
                                    'docu_cargo'       => $re->docu_cargo,
                                    'docu_asunto'      => $re->docu_asunto,
                                    'dias'             => $re->created_at->diffIndays($fechaActual),
                                ];
                            }
                            return $return;
                            break;
                        }
                    }
                case '5':
                case '6':
                    {

                        $fechaActual = Carbon::now();
                        $carbon1 = new Carbon($request->docu_fecha_hasta);
                        $carbon1->addDay();

                        $where = [];

                        if ($request->tipo_formato == 2) {
                            $where[] = ['tram_operacion.oper_idtope', '=', 2];
                        } else {
                            $where[] = ['tram_operacion.oper_idtope', '=', 1];
                        }
                        if ($request->docu_origen != null)
                            $where[] = ['d.docu_origen', '=', $request->docu_origen];
                        if ($request->docu_iddependencia != null)
                            $where[] = ['tram_operacion.oper_iddependencia', '=', $request->docu_iddependencia];
                        if ($request->oper_idusuario != null)
                            $where[] = ['tram_operacion.oper_idusuario', '=', $request->oper_idusuario];
                        if ($request->oper_depeid_d != null)
                            $where[] = ['tram_operacion.oper_depeid_d', '=', $request->oper_depeid_d];
                        if ($request->oper_usuid_d != null)
                            $where[] = ['tram_operacion.oper_usuid_d', '=', $request->oper_usuid_d];
                        if ($request->idtdoc != null)
                            $where[] = ['td.idtdoc', '=', $request->idtdoc];
                        if ($request->docu_firma != null)
                            $where[] = ['d.docu_firma', '=', $request->docu_firma];
                        if ($request->docu_asunto != null)
                            $where[] = ['docu_asunto', 'LIKE', "%$request->docu_asunto%"];
                        if ($request->oper_procesado != null)
                            $where[] = ['tram_operacion.oper_procesado', '=', $request->oper_procesado];

                        $reporte = Operacion::select([
                            'd.iddocumento',
                            //DB::raw('(SELECT MAX(op.idoperacion) FROM tram_operacion AS op WHERE op.oper_iddocumento = d.iddocumento LIMIT 1) as maxi'),
                            'd.docu_origen',
                            'd.docu_fecha_doc',
                            'td.tdoc_descripcion',
                            'd.docu_numero_doc',
                            'd.docu_siglas_doc',
                            'tde.depe_nombre',
                            'd.docu_asunto',
                            'd.docu_folios',
                            'tram_operacion.oper_acciones',
                            'tde1.iddependencia as iddependencia_destino',
                            'tde1.depe_nombre as depe_nombre_destino',
                            'u.adm_email',
                            'd.docu_firma as name_origen',
                            'u.adm_name',
                            'u.adm_lastname',
                            'u1.adm_name as name_derivador',
                            'u1.adm_lastname as lastname_derivador',
                            'tram_operacion.oper_detalledestino',
                            'tram_operacion.oper_procesado',
                            'u2.adm_name as name_receptor',
                            'u2.adm_lastname as lastname_receptor',
                            'tram_operacion.updated_at',
                        ])
                            ->join('tram_documento as d', 'tram_operacion.oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_operacion as op', 'tram_operacion.idoperacion', '=', 'op.oper_idprocesado')
                            ->leftJoin('tram_dependencia as tde', 'd.docu_iddependencia', '=', 'tde.iddependencia')
                            ->leftJoin('tram_dependencia as tde1', 'tram_operacion.oper_depeid_d', '=', 'tde1.iddependencia')
                            ->leftJoin('admin as u', function ($join) {
                                $join->on('tram_operacion.oper_usuid_d', '=', 'u.id')
                                    ->where('tram_operacion.oper_usuid_d', '<>', 0);
                            })
                            ->leftJoin('admin as u1', 'tram_operacion.oper_idusuario', '=', 'u1.id')
                            ->leftJoin('admin as u2', 'op.oper_idusuario', '=', 'u2.id')
                            ->whereBetween('tram_operacion.created_at', [
                                $request->docu_fecha_desde,
                                $carbon1->toDateString(),
                            ])
                            ->where($where)
                            ->offset($request->docu_desde - 1)
                            ->take($request->docu_hasta - $request->docu_desde + 1);
                        if ($opcion->id == 5) {
                            $reporte->orderBy('tde1.depe_nombre', 'ASC');
                            $reporte->orderBy('d.docu_fecha_doc', $request->ordenamiento);
                            $reporte->orderBy('d.iddocumento', $request->ordenamiento);
                        } else {
                            $reporte->orderBy('tram_operacion.idoperacion', $request->ordenamiento);
                        }
                        $reporte = $reporte->get();

                        if ($reporte->count() == 0) {
                            return $reporte;
                            break;
                        } elseif ($opcion->id == 5) {
                            foreach ($reporte as $re) {
                                $reci = ($re->oper_procesado == 1) ? "Recibido " . $re->updated_at : $re->updated_at->diffIndays($fechaActual) . " dias pendiente";
                                $return[] = [
                                    'iddocumento'         => str_pad($re->iddocumento, 8, "0", STR_PAD_LEFT),
                                    'created_at'          => $re->docu_fecha_doc,
                                    'tdoc_descripcion'    => $re->tdoc_descripcion . " " . str_pad($re->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($re->docu_origen == 1) ? ("-" . explode("-", $re->docu_fecha_doc)[0]) : '') . "-" . $re->docu_siglas_doc,
                                    'depe_nombre'         => $re->depe_nombre . "\n" . $re->name_derivador . " " . $re->lastname_derivador,
                                    'docu_asunto'         => $re->docu_asunto,
                                    'oper_acciones'       => $re->oper_acciones,
                                    'depe_nombre_destino' => $re->depe_nombre_destino,
                                    'estado_derivacion'   => $reci . "\n" . $re->name_receptor . " " . $re->lastname_receptor,
                                ];
                            }
                            return $return;
                            break;
                        } else {
                            foreach ($reporte as $id => $re) {
                                $reci = ($re->oper_procesado == 1) ? "Recibido " . $re->updated_at : "";
                                $return[] = [
                                    'id'      => $id + $request->docu_desde,
                                    'doc'     => "-REGISTRO: " . str_pad($re->iddocumento, 8, "0", STR_PAD_LEFT) . "\n-DOCUMENTO: " . $re->tdoc_descripcion . " " . str_pad($re->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($re->docu_origen == 1) ? ("-" . explode("-", $re->docu_fecha_doc)[0]) : '') . "-" . $re->docu_siglas_doc . "\n-FOLIOS: " . $re->docu_folios . "\n-REMITENTE: " . $re->depe_nombre . " / " . $re->name_origen . "\n-ASUNTO: " . $re->docu_asunto,
                                    'destino' => "-DESTINO: " . $re->depe_nombre_destino . " / " . $re->adm_name . " " . $re->adm_lastname . "\n-PROVEIDO: " . $re->oper_acciones,
                                    'firma'   => $reci,
                                ];
                            }
                            return $return;
                            break;
                        }
                    }
                case '7':
                {
                    $where = [
                        ['tram_operacion.oper_idtope', '=', 1],
                    ];

                    if ($request->docu_origen != null)
                        $where[] = ['d.docu_origen', '=', $request->docu_origen];
                    if ($request->docu_iddependencia != null)
                        $where[] = ['tram_operacion.oper_iddependencia', '=', $request->docu_iddependencia];

                    $reporte = Operacion::select([
                        'd.iddocumento',
                        'd.docu_idexma',
                        'tram_operacion.created_at as fecha_ingreso',
                        'derivado.created_at as fecha_deriv_archiv',
                        'recibido.created_at as fecha_recibido',
                        'tdc.tdoc_abreviado',
                        'd.docu_origen',
                        'd.docu_fecha_doc',
                        'd.docu_numero_doc',
                        'd.docu_siglas_doc',
                        'd.docu_folios',
                        'firma.depe_nombre as depe_origen',
                        'd.docu_firma',
                        'd.docu_cargo',
                        'd.docu_asunto',
                        'derivado.oper_depeid_d as derivado_id_dependencia',
                        'depe_recibe.depe_nombre as derivado_dependencia',
                        DB::raw("(CASE WHEN derivado.idoperacion is NULL THEN 'Pendiente' 
                                                                                WHEN derivado.oper_idtope=3 THEN 'Archivado'
                                                                                WHEN recibido.idoperacion is NULL THEN 'Derivado'
                                                                                WHEN recibido.idoperacion is NOT NULL THEN 'Recibido'
                                                                                ELSE 'Desconocido' END) as estado"),
                        'derivado.oper_idarchivador',
                        'derivado.oper_acciones',
                        DB::raw("(CASE WHEN dep_envio.depe_depende =mi_dependencia.depe_depende THEN 'Recibido de interno' 
                                                                            WHEN tram_operacion.oper_iddependencia = d.docu_iddependencia THEN 'Documento de la oficina'
                                                                            ELSE 'Recibido de externo' END) as tipo"),
                    ])
                        ->join('tram_documento as d', 'tram_operacion.oper_iddocumento', '=', 'd.iddocumento')
                        ->join('tram_tipodocumento as tdc', 'tdc.idtdoc', '=', 'd.docu_idtipodocumento')
                        ->join('tram_dependencia as firma', 'firma.iddependencia', '=', 'd.docu_iddependencia')
                        ->leftJoin('tram_operacion as derivado', 'derivado.oper_idprocesado', '=', 'tram_operacion.idoperacion')
                        ->leftJoin('tram_operacion as recibido', 'recibido.oper_idprocesado', '=', 'derivado.idoperacion')
                        ->leftJoin('tram_dependencia as depe_recibe', 'depe_recibe.iddependencia', '=', 'derivado.oper_depeid_d')
                        ->leftJoin('tram_operacion as op_envio', 'tram_operacion.oper_idprocesado', '=', 'op_envio.idoperacion')
                        ->leftJoin('tram_dependencia as dep_envio', 'op_envio.oper_iddependencia', '=', 'dep_envio.iddependencia')
                        ->join('tram_dependencia as mi_dependencia', 'tram_operacion.oper_iddependencia', '=', 'mi_dependencia.iddependencia')
                        ->where($where)
                        ->whereBetween('tram_operacion.created_at', [
                            $request->docu_fecha_desde,
                            $carbon->toDateString(),
                        ])
                        ->orderBy('tram_operacion.idoperacion', $request->ordenamiento)
                        ->take(10000)
                        ->get();

                    if ($reporte->count() == 0) {
                        return $reporte;
                        break;
                    } else {
                        foreach ($reporte as $re) {
                            $return[] = [
                                'iddocumento'             => str_pad($re->iddocumento, 8, "0", STR_PAD_LEFT),
                                'docu_idexma'             => str_pad($re->docu_idexma, 8, "0", STR_PAD_LEFT),
                                'fecha_ingreso'           => $re->fecha_ingreso,
                                'fecha_deriv_archiv'      => $re->fecha_deriv_archiv,
                                'fecha_recibido'          => $re->fecha_recibido,
                                'tdoc_abreviado'          => $re->tdoc_abreviado . " " . str_pad($re->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($re->docu_origen == 1) ? ("-" . explode("-", $re->docu_fecha_doc)[0]) : '') . "-" . $re->docu_siglas_doc,
                                'docu_folios'             => $re->docu_folios,
                                'depe_origen'             => $re->depe_origen,
                                'docu_firma'              => $re->docu_firma,
                                'docu_cargo'              => $re->docu_cargo,
                                'docu_asunto'             => $re->docu_asunto,
                                'derivado_id_dependencia' => $re->derivado_id_dependencia,
                                'derivado_dependencia'    => $re->derivado_dependencia,
                                'estado'                  => $re->estado,
                                'oper_idarchivador'       => $re->oper_idarchivador,
                                'oper_acciones'           => $re->oper_acciones,
                                'tipo'                    => $re->tipo,
                            ];
                        }
                        return $return;
                        break;
                    }
                }
                case '8':
                {
                    $where = [];

                    if ($request->docu_iddependencia != null)
                        $where[] = ['arch_iddependencia', '=', $request->docu_iddependencia];
                    if ($request->arch_periodo != null)
                        $where[] = ['arch_periodo', '=', $request->arch_periodo];

                    return Archivador::select([
                        'arch_nombre',
                        DB::raw("CONCAT(a.adm_name,' ',a.adm_lastname) as adm_name"),
                        'arch_periodo',
                    ])
                        ->leftJoin('admin as a', 'a.id', '=', 'arch_idusuario')
                        ->where($where)
                        ->orderBy('arch_periodo', $request->ordenamiento)
                        ->get();
                    break;
                }
                case '9':
                {

                    $where = [
                        ['oper_idtope', '=', 2],
                        ['oper_iddocumento', '=', $request->iddocumento],
                        ['dep.iddependencia', '=', Auth::user()->depe_id],
                    ];

                    $reporte = Operacion::select('oper_iddocumento',
                        'td.docu_idexma',
                        'td.docu_origen',
                        'td.docu_fecha_doc',
                        'td.docu_folios',
                        'td.docu_firma',
                        'td.docu_cargo',
                        'tdoc.tdoc_descripcion',
                        'td.docu_numero_doc',
                        'td.docu_siglas_doc',
                        'td.docu_asunto',
                        'oper_acciones',
                        'dep.depe_nombre as oficina_origen',
                        'dep1.depe_nombre as oficina_destino')
                        ->join('tram_documento as td', 'oper_iddocumento', '=', 'td.iddocumento')
                        ->join('tram_tipodocumento as tdoc', 'td.docu_idtipodocumento', '=', 'tdoc.idtdoc')
                        ->leftJoin('tram_dependencia as dep', 'oper_iddependencia', '=', 'dep.iddependencia')
                        ->leftJoin('tram_dependencia as dep1', 'oper_depeid_d', '=', 'dep1.iddependencia')
                        ->whereNotNull('oper_idprocesado')
                        ->where($where)
                        ->orderBy('oper_iddocumento', $request->ordenamiento)
                        ->get();

                    if ($reporte != null) {
                        $return = [];
                        foreach ($reporte as $d) {
                            $return[] = [
                                'oper_iddocumento' => str_pad($d->oper_iddocumento, 8, "0", STR_PAD_LEFT),
                                'docu_idexma'      => str_pad($d->docu_idexma, 8, "0", STR_PAD_LEFT),
                                'docu_fecha_doc'   => $d->docu_fecha_doc,
                                'docu_folios'      => $d->docu_folios,
                                'docu_firma'       => $d->docu_firma,
                                'docu_cargo'       => $d->docu_cargo,
                                'tdoc_descripcion' => $d->tdoc_descripcion . " " . str_pad($d->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($d->docu_origen == 1) ? ("-" . explode("-", $d->docu_fecha_doc)[0]) : '') . "-" . $d->docu_siglas_doc,
                                'docu_asunto'      => $d->docu_asunto,
                                'oper_acciones'    => $d->oper_acciones,
                                'oficina_origen'   => $d->oficina_origen,
                                'oficina_destino'  => $d->oficina_destino,
                            ];
                        }
                        return $return;
                        break;
                    } else {
                        return 0;
                        break;
                    }
                }
                case '10':
                {

                    $fechaActual = Carbon::now();

                    $where = [
                        ['oper_procesado', '=', 0],
                    ];
                    $return = [];

                    if ($request->docu_iddependencia != null)
                        $where[] = ['oper_iddependencia', '=', $request->docu_iddependencia];
                    if ($request->oper_idusuario != null)
                        $where[] = ['oper_idusuario', '=', $request->oper_idusuario];

                    $reporte = Operacion::select('oper_iddocumento',
                        'tram_operacion.created_at',
                        'a.adm_name',
                        'a.adm_lastname',
                        'tdep.depe_nombre as oficina_destino',
                        'ud.adm_name as usuario_destino_name',
                        'ud.adm_lastname as usuario_destino_lastname',
                        'dep.depe_nombre',
                        'tdoc.tdoc_descripcion',
                        'td.docu_origen',
                        'td.docu_numero_doc',
                        'td.docu_siglas_doc',
                        'td.docu_fecha_doc')
                        ->join('admin as a', 'oper_idusuario', '=', 'a.id')
                        ->leftJoin('tram_dependencia as tdep', 'oper_depeid_d', '=', 'tdep.iddependencia')
                        ->leftJoin('admin as ud', 'ud.id', '=', 'oper_usuid_d')
                        ->join('tram_documento as td', 'td.iddocumento', '=', 'oper_iddocumento')
                        ->join('tram_dependencia as dep', 'td.docu_iddependencia', '=', 'dep.iddependencia')
                        ->join('tram_tipodocumento as tdoc', 'td.docu_idtipodocumento', '=', 'tdoc.idtdoc')
                        ->where($where)
                        ->whereIn('oper_idtope', [1, 2])
                        ->orderBy('tram_operacion.created_at', $request->ordenamiento)
                        ->get();
                    if ($reporte->count() == 0) {
                        return $reporte;
                        break;
                    } else {
                        foreach ($reporte as $op) {
                            $return[] = [
                                'oper_iddocumento' => str_pad($op->oper_iddocumento, 8, "0", STR_PAD_LEFT),
                                'created_at'       => $op->created_at->toDateTimeString(),
                                'remite'           => $op->adm_name . " " . $op->adm_lastname,
                                'oficina_destino'  => $op->oficina_destino,
                                'usuario_destino'  => $op->usuario_destino_name . " " . $op->usuario_destino_lastname,
                                'depe_nombre'      => $op->depe_nombre,
                                'tdoc_descripcion' => $op->tdoc_descripcion . " " . str_pad($op->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($op->docu_origen == 1) ? ("-" . explode("-", $op->docu_fecha_doc)[0]) : '') . (($op->docu_siglas_doc != '') ? "-" . $op->docu_siglas_doc : ''),
                                'dias'             => $op->created_at->diffIndays($fechaActual),
                            ];
                        }
                        return $return;
                    }
                    break;
                }
                case '11':
                {

                    $fechaActual = Carbon::now();
                    $where = [
                        ['oper_procesado', '=', 0],
                        ['oper_idtope', '=', 2],
                        ['td.idtdoc', '<>', 219],
                    ];
                    $return = [];

                    if ($request->docu_iddependencia != null)
                        $where[] = ['oper_depeid_d', '=', $request->docu_iddependencia];
                    if ($request->oper_idusuario != null)
                        $where[] = ['oper_idusuario', '=', $request->oper_idusuario];

                    $reporte = Operacion::select('idoperacion', 'oper_iddocumento',
                        'tram_operacion.created_at',
                        'oper_forma',
                        'td.tdoc_descripcion',
                        'd.docu_origen',
                        'd.docu_numero_doc',
                        'd.docu_siglas_doc',
                        'd.docu_fecha_doc',
                        'ddoc.depe_nombre as depe_nombre_destino',
                        'ddest.depe_nombre as depe_nombre_origen',
                        'u.adm_name as name_usuario',
                        'u.adm_lastname as lastname_usuario',
                        'u1.adm_name as name_usuario_destino',
                        'u1.adm_lastname as lastname_usuario_destino')
                        ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                        ->join('tram_tipodocumento as td', 'd.docu_idtipodocumento', '=', 'td.idtdoc')
                        ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia')
                        ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                        ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
                        ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
                        ->where($where)
                        ->orderBy('tram_operacion.created_at', $request->ordenamiento)
                        ->get();
                    if ($reporte->count() == 0) {
                        return $reporte;
                        break;
                    } else {

                        foreach ($reporte as $op) {
                            $return[] = [
                                'oper_iddocumento' => str_pad($op->oper_iddocumento, 8, "0", STR_PAD_LEFT),
                                'created_at'       => $op->created_at->toDateTimeString(),
                                'remite'           => $op->name_usuario . " " . $op->lastname_usuario,
                                'oficina_destino'  => $op->depe_nombre_destino,
                                'usuario_destino'  => $op->name_usuario_destino . " " . $op->lastname_usuario_destino,
                                'depe_nombre'      => $op->depe_nombre_origen,
                                'tdoc_descripcion' => $op->tdoc_descripcion . " " . str_pad($op->docu_numero_doc, 6, "0", STR_PAD_LEFT) . "" . (($op->docu_origen == 1) ? ("-" . explode("-", $op->docu_fecha_doc)[0]) : '') . (($op->docu_siglas_doc != '') ? "-" . $op->docu_siglas_doc : ''),
                                'dias'             => $op->created_at->diffInDays($fechaActual),
                            ];
                        }
                        return $return;
                    }

                    break;
                }
                case '12' :
                {
                    $where = [];

                    if ($request->depe_depende != null)
                        $where[] = ['ds.iddependencia', '=', $request->depe_depende];

                    return Dependencia::select([
                        'ds.depe_nombre as sede',
                        'tram_dependencia.depe_nombre',
                        DB::raw('COUNT(a_general.id) as usuarios'),
                        DB::raw('COUNT(a_vigentes.id) as usuarios_activos_vigentes'),
                        DB::raw('COUNT(role_user.id) as admins_activos_vigentes'),
                    ])
                        ->join('tram_dependencia as ds', 'tram_dependencia.depe_depende', '=', 'ds.iddependencia')
                        ->leftJoin('admin as a_general', 'a_general.depe_id', '=', 'tram_dependencia.iddependencia')
                        ->leftJoin('admin as a_vigentes', function ($leftJoin) {
                            $leftJoin->on('a_vigentes.id', '=', 'a_general.id')
                                ->where('a_vigentes.adm_estado', '=', 1)
                                ->where('a_vigentes.adm_vigencia', '>=', now());
                        })
                        ->leftJoin('role_user', function ($leftJoin) {
                            $leftJoin->on('role_user.user_id', '=', 'a_vigentes.id')
                                ->where('role_user.role_id', '=', 2);
                        })
                        ->where($where)
                        ->groupBy('ds.depe_nombre')
                        ->groupBy('tram_dependencia.iddependencia')
                        ->groupBy('tram_dependencia.depe_nombre')
                        ->orderBy('sede', 'ASC')
                        ->orderBy('tram_dependencia.depe_nombre', 'ASC')
                        ->get();

                    break;
                }
                case '13' :
                {
                    $where = [];

                    if ($request->depe_depende != null)
                        $where[] = ['ds.iddependencia', '=', $request->depe_depende];
                    if ($request->docu_iddependencia != null)
                        $where[] = ['depe_id', '=', $request->docu_iddependencia];


                    return User::select([
                        'ds.depe_nombre as sede',
                        'd.depe_nombre',
                        DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                        'adm_cargo',
                        DB::raw("(CASE WHEN adm_estado =1 THEN 'Activo' 
                                                                                WHEN adm_estado =2 THEN 'Inactivo'
                                                                                ELSE 'Desconocido' END) as adm_estado"),
                    ])
                        ->join('tram_dependencia as d', 'depe_id', '=', 'd.iddependencia')
                        ->leftJoin('tram_dependencia as ds', 'd.depe_depende', '=', 'ds.iddependencia')
                        ->where($where)
                        ->groupBy('ds.depe_nombre')
                        ->groupBy('d.depe_nombre')
                        ->groupBy('adm_name')
                        ->groupBy('adm_lastname')
                        ->groupBy('adm_cargo')
                        ->groupBy('adm_estado')
                        ->orderBy('ds.depe_nombre', 'ASC')
                        ->orderBy('d.depe_nombre', 'ASC')
                        ->get();
                    break;
                }
                case '14' :
                {
                    $fechaActual = Carbon::now();
                    $carbon1 = new Carbon($request->docu_fecha_hasta);
                    $carbon1->addDay();

                    $where = [
                        ['docu_origen', '=', 2],
                        ['o.oper_idtope', '=', 1],
                    ];

                    if ($request->depe_depende != null)
                        $where[] = ['ds.depe_depende', '=', $request->depe_depende];

                    return Documento::select([
                        DB::raw('COUNT(*) as total'),
                        'ds.depe_nombre',
                    ])
                        ->join('tram_operacion as o', 'o.oper_iddocumento', '=', 'iddocumento')
                        ->join('tram_dependencia as ds', 'ds.iddependencia', '=', 'o.oper_iddependencia')
                        ->where($where)
                        ->whereNull('o.oper_idprocesado')
                        ->whereBetween('docu_fecha_doc', [$request->docu_fecha_desde, $carbon1->toDateString()])
                        ->groupBy('ds.depe_nombre')
                        ->orderBy('ds.depe_nombre', 'ASC')
                        ->get();
                }
            }
        }
    }

    public function create(Request $request)
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
