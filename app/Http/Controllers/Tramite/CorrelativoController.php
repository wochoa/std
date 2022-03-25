<?php

namespace App\Http\Controllers\Tramite;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TipoDocumentoCorrel;
use App\User;
use DB;


class CorrelativoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
            $where              =[];
            if($request->tdco_periodo!=null)
                $where[]        =['tdco_periodo','=',$request->tdco_periodo];
            if($request->iddependencia!=null)
                $where[]        =['td.iddependencia','=',$request->iddependencia];
            if($request->idadmin!=null)
                $where[]        =['ad.id','=',$request->idadmin];
            if($request->idtdoc!=null)
                $where[]        =['tdo.idtdoc','=',$request->idtdoc];
             
             $correlativos= TipoDocumentoCorrel::select(['tram_tipodocumento_correl.id',
                                                        'tdco_periodo',
                                                        'td.depe_nombre', 
                                                        'tdo.tdoc_descripcion',
                                                        DB::raw("CONCAT(ad.adm_name,' ',ad.adm_lastname) as adm_email"),
                                                        'tdco_numero'])    
                                                ->join('tram_dependencia as td', 'tram_tipodocumento_correl.tdco_iddependencia', '=', 'td.iddependencia')                 
                                                ->join('tram_tipodocumento as tdo', 'tram_tipodocumento_correl.tdco_idtipodocumento', '=', 'tdo.idtdoc')
                                                ->leftJoin('admin as ad', 'ad.id','=','tram_tipodocumento_correl.tdco_idusuario')
                                                ->where($where)                 
                                                ->orderBy('tdco_periodo','ASC')
                                                //->orderBy('td.depe_nombre','ASC')
                                                ->orderBy('tdo.tdoc_descripcion', 'asc')
                                                ->orderBy('ad.id', 'asc')                 
                                                ->paginate(15);
            return $correlativos;

    }
    public function buscar(Request $request)
    {
        $where=[
            ['tdco_idtipodocumento',    '=',$request->tdco_idtipodocumento],
            ['tdco_iddependencia',      '=',$request->tdco_iddependencia],
            ['tdco_idusuario',          '=',$request->tdco_idusuario],
            ['tdco_periodo',            '=',$request->tdco_periodo]
        ];
        return TipoDocumentoCorrel::select('id','tdco_numero')->where($where)->first();
    }
    public function usuarios($id)
    {
        $usuarios_buscados=\DB::table('admin as a')
            ->select('a.id as id', 'a.id as nombre', 'a.depe_id')
            ->where('a.depe_id', $id)
            ->orderBy('a.adm_name','asc')
            ->groupBy('id')->get();
        
        return response()->json(array('usuarios_buscados'=> $usuarios_buscados), 200);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        
    }
    public function update(Request $request, $id)
    {
        $correlativo                    =TipoDocumentoCorrel::find($id);
        $correlativo->tdco_numero       =$request->tdco_numero;
        $correlativo->save();
        
        return $correlativo;

    }

    public function destroy($id)
    {
        //
    }
}
