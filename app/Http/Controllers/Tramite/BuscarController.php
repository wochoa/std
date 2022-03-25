<?php

namespace App\Http\Controllers\Tramite;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Documento;
use Auth;
use DB;

class BuscarController extends Controller
{ 
    
    public function index(Request $request)
    {
                               
        $where=[];  
        
        if($request->docu_iddependencia!=null){
                $where[]=['td.iddependencia', '=', $request->docu_iddependencia];
        }
        if($request->docu_idusuario!=null)
                $where[] =['docu_idusuario','=',$request->docu_idusuario];
        if($request->docu_firma!=null){
                $where[]=['docu_firma','LIKE', "%$request->docu_firma%"];
        }  
        if($request->idtdoc!=null){
                $where[]=['tdo.idtdoc','=', $request->idtdoc];
        }
        if($request->docu_numero_doc!=null){
                $where[]=['docu_numero_doc', '=', $request->docu_numero_doc];
        }
        if($request->docu_siglas_doc!=null){
                $where[]=['docu_siglas_doc', 'LIKE', "%$request->docu_siglas_doc%"];
        }
        if($request->docu_asunto!=null){
                $where[]=['docu_asunto', 'LIKE', "%$request->docu_asunto%"];
        }
        
        return Documento::select(['iddocumento', 
                                    'docu_idexma', 
                                    'docu_fecha_doc', 
                                    'tdo.tdoc_descripcion',
                                    'docu_numero_doc',
                                    'docu_siglas_doc',
                                    'td.depe_nombre as dependencia', 
                                    'docu_detalle', 
                                    'docu_firma', 
                                    'docu_cargo', 
                                    'docu_asunto',
                                    'a.adm_email as usuario'])
                            ->join('tram_tipodocumento as tdo', 'docu_idtipodocumento', '=', 'tdo.idtdoc')
                            ->join('tram_dependencia as td', 'docu_iddependencia', '=', 'td.iddependencia')
                            ->join('admin as a', 'docu_idusuario', '=', 'a.id')
                            ->where($where)    
                            ->whereBetween('docu_fecha_doc', [$request->docu_fecha_desde, $request->docu_fecha_hasta])  
                            ->orderBy('iddocumento','asc')
                            ->paginate(15);
              
    }

    public function unidad($id)
    {       
        $unidad_buscados=\DB::table('tram_dependencia as td')
        ->select('td.iddependencia as id', 'td.depe_nombre as nombre')
        ->where('td.depe_tipo','=', $id)
        ->orderBy('td.depe_nombre','asc')
        ->get();         
        //return $unidad_buscados;     
        
      //$vararray = array('id'=>'1','name'=>'Nombre');
      return response()->json(array('unidad_buscados'=> $unidad_buscados), 200);
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
        $documentos= DB::table('tram_documento as d')
            ->crossJoin('tram_tipodocumento as tdo', 'd.docu_idtipodocumento', '=', 'tdo.idtdoc')
            ->join('admin as a', 'd.docu_idusuario', '=', 'a.id')
            ->join('tram_dependencia as td', 'd.docu_iddependencia', '=', 'td.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td.depe_depende', '=', 'td2.iddependencia')
            ->select('d.iddocumento as registro', 'd.docu_idexma as expediente', 'd.docu_fecha_doc as fdocumento', 'd.docu_folios as folios', 'd.docu_asunto as asunto', 'td.depe_nombre as unidad', 'td2.depe_nombre as dependencia', 'd.docu_firma as firma', 'd.docu_cargo as cargo', 'tdo.tdoc_descripcion as tipo', 'd.docu_numero_doc as numero', 'd.docu_siglas_doc as siglas', 'd.docu_proyectado as proyectado')
            ->where('d.iddocumento',$id)->first();
       
        $operacions= DB::table('tram_operacion as to')
            ->join('admin as a', 'to.oper_idusuario', '=', 'a.id')
            ->join('tram_dependencia as td', 'to.oper_iddependencia', '=', 'td.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td.depe_depende', '=', 'td2.iddependencia')
            ->leftJoin('tram_dependencia as td3', 'to.oper_depeid_d', '=', 'td3.iddependencia')
            ->leftJoin('admin as a2', 'to.oper_usuid_d', '=', 'a2.id')
            ->leftJoin('tram_archivador as ta', 'to.oper_idarchivador', '=', 'ta.idarch')
            ->select('td2.depe_abreviado as dependencia', 'to.oper_fecha as fecha', 'to.oper_hora as hora', 'to.oper_idtope as operacion', 'ta.arch_nombre as archivado', 'ta.arch_periodo as periodo', 'to.oper_forma as forma', 'td.depe_nombre as unidad', 'a.adm_name as nombre', 'a.adm_lastname as apellido', 'td3.depe_nombre as depe_destino', 'a2.adm_name as usu_destino', 'a2.adm_lastname as ape_destino', 'to.oper_detalledestino as proveido', 'to.oper_acciones as proveido2', 'to.oper_expeid_adj as adjuntado')
            ->where('to.oper_iddocumento',$id)->get();
        
        $adjuntados = array();
        $adjuntados= DB::table('tram_operacion as to')
            ->select('to.oper_expeid_adj')
            //->join('tram_documento as tdoc', 'to.oper_expeid_adj', '=', 'tdoc.iddocumento') 
            ->where('to.oper_expeid_adj',$id)
            ->get();
        
        $contador = count($adjuntados);
        
        $adjuntados_adj= DB::table('tram_operacion as to')
            //->join('tram_documento as tdoc', 'to.oper_expeid_adj', '=', 'tdoc.iddocumento') 
            ->where('to.oper_expeid_adj',$id)
            ->pluck ('oper_iddocumento');
        
        $documentos_adjs = array();
        $operacions_adjs = array();
        
        foreach($adjuntados_adj as $v){ 
            $documentos_adjs[$v]= DB::table('tram_documento as d')
                ->crossJoin('tram_tipodocumento as tdo', 'd.docu_idtipodocumento', '=', 'tdo.idtdoc')
                ->join('admin as a', 'd.docu_idusuario', '=', 'a.id')
                ->join('tram_dependencia as td', 'd.docu_iddependencia', '=', 'td.iddependencia')
                ->leftJoin('tram_dependencia as td2', 'td.depe_depende', '=', 'td2.iddependencia')
                ->select('d.iddocumento as registro', 'd.docu_idexma as expediente', 'd.docu_fecha_doc as fdocumento', 'd.docu_folios as folios', 'd.docu_asunto as asunto', 'td.depe_nombre as unidad', 'td2.depe_nombre as dependencia', 'd.docu_firma as firma', 'd.docu_cargo as cargo', 'tdo.tdoc_descripcion as tipo', 'd.docu_numero_doc as numero', 'd.docu_siglas_doc as siglas', 'd.docu_proyectado as proyectado')
                ->where('d.iddocumento',$v)->first();

            $operacions_adjs[$v]= DB::table('tram_operacion as to')
                ->join('admin as a', 'to.oper_idusuario', '=', 'a.id')
                ->join('tram_dependencia as td', 'to.oper_iddependencia', '=', 'td.iddependencia')
                ->leftJoin('tram_dependencia as td2', 'td.depe_depende', '=', 'td2.iddependencia')
                ->leftJoin('tram_dependencia as td3', 'to.oper_depeid_d', '=', 'td3.iddependencia')
                ->leftJoin('admin as a2', 'to.oper_usuid_d', '=', 'a2.id')
                ->leftJoin('tram_archivador as ta', 'to.oper_idarchivador', '=', 'ta.idarch')
                ->select('td2.depe_abreviado as dependencia', 'to.oper_fecha as fecha', 'to.oper_hora as hora', 'to.oper_idtope as operacion', 'ta.arch_nombre as archivado', 'ta.arch_periodo as periodo', 'to.oper_forma as forma', 'td.depe_nombre as unidad', 'a.adm_name as nombre', 'a.adm_lastname as apellido', 'td3.depe_nombre as depe_destino', 'a2.adm_name as usu_destino', 'a2.adm_lastname as ape_destino', 'to.oper_detalledestino as proveido', 'to.oper_acciones as proveido2', 'to.oper_expeid_adj as adjuntado')
                ->where('to.oper_iddocumento',$v)->get(); 
        }  
        //dd($operacions_adjs);

        return view('tramite.buscar.verDocumento',array('documentos'=>$documentos,'operacions'=>$operacions,'documentos_adjs'=>$documentos_adjs,'operacions_adjs'=>$operacions_adjs,'adjuntados'=>$adjuntados, 'contador'=>$contador));             
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

