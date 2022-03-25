<?php

namespace App\Http\Controllers\Tramite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Operacion;
use App\Archivador;
use App\Documento;
use Auth;
use DB;
use Carbon\Carbon;

class PapeletaController extends Controller
{

    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => []]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

            $where=[
                ['d.docu_idusuariodependencia', '=', Auth::user()->depe_id],
                ['td.idtdoc','=',env("TIPO_DOC_PAPELETA")]
                //['oper_idusuario','=',Auth::user()->idadmin],
            ];
       
        if ($request->idadmin!=null)
            $where[]=['d.docu_idusuario','=',$request->idadmin];
        if ($request->iddocumento!=null)
            $where[]=['d.iddocumento','=',$request->iddocumento];

        return Operacion::select(['idoperacion',
                                'd.iddocumento',
                                'd.docu_idexma',
                                'd.docu_fecha_doc',
                                'oper_forma',
                                'oper_acciones',
                                'd.docu_folios',
                                'td.tdoc_descripcion',
                                'd.docu_numero_doc',
                                'd.docu_siglas_doc',
                                'd.docu_firma',
                                'd.docu_cargo',
                                'd.docu_asunto',
                                'ddoc.depe_nombre as depe_nombre_origen',
                                'oper_idtope',
                                'ddest.depe_nombre as depe_nombre_destino',
                                'u.adm_name as name_usuario_destino',
                                'u.adm_lastname as lastname_usuario_destino',
                                'd.docu_archivo',
                                'd.docu_idusuario',
                                'u.depe_id',
                                'oper_procesado',
                                'oper_depeid_d',
                                'oper_iddependencia'])
                        ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                        ->join('tram_tipodocumento as td','d.docu_idtipodocumento', '=', 'td.idtdoc')
                        ->leftJoin('tram_dependencia AS ddest', 'oper_depeid_d', '=', 'ddest.iddependencia')
                        ->leftJoin('tram_dependencia AS ddoc', 'd.docu_iddependencia', '=', 'ddoc.iddependencia')
                        ->leftJoin('admin AS u', 'oper_usuid_d', '=', 'u.id')
                        ->whereBetween('d.docu_fecha_doc',[$request->docu_fecha_desde, $request->docu_fecha_hasta])
                        ->where(function ($query) {
                            $query->where('oper_idtope', '=', 1)->where('oper_procesado', '=' ,0)
                                ->orWhere('oper_idtope', '=', 2)->where('oper_procesado', '=' ,0)
                                ->orWhere('oper_idtope', '=', 3)->where('oper_procesado', '=' ,0);
                            }) 
                        ->where($where)
                        ->orderBy('idoperacion','asc')
                        ->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function autorizarPapeletas(Request $request)
    {
        //consulta
        $carbon = new Carbon($request->docu_fecha_hasta); 
        $carbon->addDay();

        $where=[                
            ['oper_procesado', '=', 0],
            ['oper_depeid_d', '=', Auth::user()->depe_id],
            //['oper_idusuario', '<>', Auth::user()->id],
            ['td.idtdoc','=',env("TIPO_DOC_PAPELETA")],
            ['oper_idtope', '=', 2],
            //['o.oper_usuid_d', '<>', 0],
        ];
            if($request->iddocumento!=null){
                $where[]=['d.iddocumento', '=', $request->iddocumento];
            }
            if($request->idadmin !=null){
                $where[]=['oper_usuid_d', '=', $request->idadmin];
            }
            if($request->lastname_usuario !=null){
                $where[]=['u.adm_lastname', 'LIKE', "%$request->lastname_usuario%"];
            }
        
            return Operacion::select(['idoperacion',
                                        'd.iddocumento',
                                        'd.docu_idexma',
                                        'd.docu_fecha_doc', 
                                        'oper_forma',
                                        'd.docu_folios',
                                        'td.tdoc_descripcion',
                                        'd.docu_numero_doc',
                                        'd.docu_siglas_doc',
                                        'ddoc.depe_nombre as depe_nombre_destino',
                                        'd.docu_detalle', 
                                        'ddest.depe_nombre as depe_nombre_origen',
                                        'd.docu_firma',
                                        'd.docu_cargo',
                                        'd.docu_asunto',
                                        'u.adm_name as name_usuario',
                                        'u.adm_lastname as lastname_usuario',
                                        'tram_operacion.created_at',
                                        'u1.adm_name as name_usuario_destino',
                                        'u1.adm_lastname as lastname_usuario_destino',
                                        'd.docu_archivo'])
                            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td','d.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia') 
                            ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                            ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
                            ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
                            ->whereBetween('tram_operacion.created_at',[$request->docu_fecha_desde, $carbon->toDateString()]) 
                            ->where($where)
                            ->orderBy('idoperacion','asc')
                            ->paginate(10);

    }

    public function papeletasAutorizadas(Request $request)
    {
        $carbon = new Carbon($request->docu_fecha_hasta); 
        $carbon->addDay();

        $where=[                
           
            ['oper_iddependencia','=', Auth::user()->depe_id],
            //['oper_idusuario','=', Auth::user()->id],
            ['td.idtdoc','=',env("TIPO_DOC_PAPELETA")],
            ['oper_idtope','=', 2],
            ['oper_usuid_d','=',null],
        ];
            if($request->iddocumento!=null){
                $where[]=['d.iddocumento', '=', $request->iddocumento];
            }
            /*if($request->idadmin !=null){
                $where[]=['oper_usuid_d', '=', $request->idadmin];
            }*/
            if($request->lastname_usuario !=null){
                $where[]=['u.adm_lastname', 'LIKE', "%$request->lastname_usuario%"];
            }
        
            return Operacion::select(['idoperacion',
                                        'd.iddocumento',
                                        'd.docu_idexma',
                                        'tram_operacion.created_at', 
                                        'td.tdoc_descripcion',
                                        'd.docu_numero_doc',
                                        'd.docu_siglas_doc',
                                        'ddoc.depe_nombre as depe_nombre_destino',
                                        'd.docu_detalle', 
                                        'ddest.depe_nombre as depe_nombre_origen',
                                        'd.docu_firma',
                                        'd.docu_cargo',
                                        'd.docu_asunto',
                                        'u.adm_name as name_usuario',
                                        'u.adm_lastname as lastname_usuario'])
                            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td','d.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia') 
                            ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                            ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
                            ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
                            ->whereBetween('tram_operacion.created_at',[$request->docu_fecha_desde, $carbon->toDateString()]) 
                            ->where($where)
                            ->orderBy('idoperacion','asc')
                            ->paginate(10);
    }

    public function papeletasSolicitadas(Request $request)
    {
        $depe=Auth::user()->depe_id;
        $carbon = new Carbon($request->docu_fecha_hasta); 
        $carbon->addDay();

        $where=[                
            //['oper_procesado', '=', 0],
            //['oper_depeid_d', '=', Auth::user()->depe_id],
            //['oper_idusuario', '<>', Auth::user()->id],
            ['td.idtdoc','=',env("TIPO_DOC_PAPELETA")],
        ];
            if($request->iddocumento!=null){
                $where[]=['d.iddocumento', '=', $request->iddocumento];
            }
            if($request->lastname_usuario !=null){
                $where[]=['u.adm_lastname', 'LIKE', "%$request->lastname_usuario%"];
            }
        
            return Operacion::select(['idoperacion',
                                        'd.iddocumento',
                                        'd.docu_idexma',
                                        'oper_forma',
                                        'd.docu_folios',
                                        'td.tdoc_descripcion',
                                        'd.docu_numero_doc',
                                        'd.docu_siglas_doc',
                                        'ddoc.depe_nombre as depe_nombre_destino',
                                        'd.docu_detalle', 
                                        'ddest.depe_nombre as depe_nombre_origen',
                                        'd.docu_firma',
                                        'd.docu_cargo',
                                        'd.docu_asunto',
                                        'u.adm_name as name_usuario',
                                        'u.adm_lastname as lastname_usuario',
                                        'tram_operacion.created_at',
                                        'u1.adm_name as name_usuario_destino',
                                        'u1.adm_lastname as lastname_usuario_destino',
                                        'd.docu_archivo',
                                        'oper_idtope'])
                            ->join('tram_documento as d', 'oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td','d.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_dependencia as ddoc', 'oper_depeid_d', '=', 'ddoc.iddependencia') 
                            ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                            ->leftJoin('admin AS u1', 'oper_usuid_d', '=', 'u1.id')
                            ->join('admin AS u', 'oper_idusuario', '=', 'u.id')
                            ->whereBetween('tram_operacion.created_at',[$request->docu_fecha_desde, $carbon->toDateString()])
                            ->where(function ($query) use ($depe) {
                                $query->where('oper_depeid_d', '=' , $depe)->where('oper_procesado', '=' ,0)
                                    ->orWhere('oper_iddependencia', '=', $depe)->where('oper_procesado', '=' ,0);
                                }) 
                            ->where($where)
                            ->whereIn('oper_idtope', [1, 2])
                            ->orderBy('idoperacion','desc')
                            ->paginate(10);
    }

    public function obtenerArchivador(Request $request)
    {
        return Archivador::select('idarch')
                            ->where('arch_periodo','=',$request->arch_periodo)
                            ->where('arch_papeleta','=',1)
                            ->first();
    }

    public function papeletasUsadas(Request $request)
    {
        
        $where=[  
            ['tram_operacion.oper_iddependencia', '=', Auth::user()->depe_id],
            ['td.idtdoc','=',env("TIPO_DOC_PAPELETA")],
            ['tram_operacion.oper_idtope', '=', 3],
        ];
        
        $carbon = new Carbon($request->docu_fecha_hasta); 
        $carbon->addDay();

            if($request->iddocumento!=null){
                $where[]=['d.iddocumento', '=', $request->iddocumento];
            }
            if($request->lastname_usuario !=null){
                $where[]=['d.docu_firma', 'LIKE', "%$request->lastname_usuario%"];
            }
        
            $reporte = Operacion::select(['d.iddocumento',
                                        'd.docu_idexma',
                                        'tram_operacion.updated_at as hora_salida',
                                        'tram_operacion.created_at as hora_retorno',
                                        'td.tdoc_descripcion',
                                        'd.docu_numero_doc',
                                        'd.docu_siglas_doc',
                                        'd.docu_firma',
                                        'd.docu_cargo',
                                        'ddest.depe_nombre as depe_nombre',
                                        'd.docu_asunto',
                                        'd.docu_detalle'])
                            ->join('tram_documento as d', 'tram_operacion.oper_iddocumento', '=', 'd.iddocumento')
                            ->join('tram_tipodocumento as td','d.docu_idtipodocumento', '=', 'td.idtdoc')
                            ->leftJoin('tram_dependencia as ddoc', 'tram_operacion.oper_depeid_d', '=', 'ddoc.iddependencia') 
                            ->leftJoin('tram_dependencia as ddest', 'd.docu_iddependencia', '=', 'ddest.iddependencia')
                            ->whereBetween('tram_operacion.created_at',[$request->docu_fecha_desde, $carbon->toDateString()])
                            ->where($where)
                            ->orderBy('tram_operacion.idoperacion','desc');
                            if($request->esExcel==1){
                                $reporte=$reporte->get();
                            }else{
                                 return $reporte->paginate(10);
                            }

                            if($request->esExcel==1){
                                
                                foreach($reporte as $op){
                                    $return[]=[
                                        'iddocumento'       =>str_pad($op->iddocumento, 8, "0", STR_PAD_LEFT),
                                        'docu_idexma'       =>str_pad($op->docu_idexma, 8, "0", STR_PAD_LEFT),
                                        'hora_salida'       =>$op->hora_salida,
                                        'hora_retorno'      =>$op->hora_retorno,
                                        'tdoc_descripcion'  =>$op->tdoc_descripcion." ".str_pad($op->docu_numero_doc, 6, "0", STR_PAD_LEFT)."-".$op->docu_siglas_doc,
                                        'docu_firma'        =>$op->docu_firma,
                                        'docu_cargo'        =>$op->docu_cargo,
                                        'depe_nombre'       =>$op->depe_nombre,
                                        'docu_asunto'       =>$op->docu_asunto,
                                        'docu_detalle'      =>$op->docu_detalle];
                                }
                                return $return;
                            }
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Documento::find($id)->getForPapeleta();
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
