<?php

namespace App\Http\Controllers\Tramite;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class BloqueController extends Controller
{
    public function index(Request $request)
    {
        if($request){
                          
            $unidadOrganicas=\DB::table('tram_dependencia')
                ->where('depe_tipo','=','1')
                ->orderBy('depe_nombre','asc')->get();
          
             return view('tramite.administracion.bloques',
                         ["unidadOrganicas"=>$unidadOrganicas]);
        }
    }
        
    public function create(Request $request)
    {
        $dependencias= DB::table('tram_dependencia as td')
                ->join('admin as a','a.depe_id','=','td.iddependencia')
                ->select('a.depe_id','td.iddependencia','a.adm_name')
                ->orderBy('adm_name','asc')
                ->get();
        
        $unidadOrganicas=\DB::table('tram_dependencia as td')
                ->select('td.iddependencia as id', 'td.depe_nombre as nombre', 'td.depe_depende')
                ->where('td.depe_tipo','=','1')
                ->orderBy('td.depe_nombre','asc')
                ->get();  

                $opciones = '<option value>--Selleccione Opción--</option>';
                foreach( $unidadOrganicas as $unidad_or)
                {
                    $opciones.='<option value="'.$unidad_or->id.'">'.$unidad_or->nombre.'</option>';
                } 
        
        $usuarios_buscados=\DB::table('admin')->orderBy('adm_sisgedo','asc')->groupBy('adm_sisgedo')->get();
        
        $query1=(trim($request->get('reportes_hidd'))>0)?trim($request->get('reportes_hidd')):"";
        $query5=(trim($request->get('searchText5'))>0)?trim($request->get('searchText5')):"";
             if($query5 !=''){
             $usuarios_buscados=\DB::table('admin')->orderBy('adm_sisgedo','asc')->where('depe_id','=',$query5)->get();}
        
        
        
        return view('tramite.administracion.bloques.nuevobloque',["unidadOrganicas"=>$unidadOrganicas, 'opciones'=>$opciones, "reportes_hidd"=>$query1, "searchText5"=>$query5, "dependencias"=>$dependencias, "usuarios_buscados"=>$usuarios_buscados]); 
    }
    
    public function store(Request $request)
    {
        $dependencias= DB::table('tram_dependencia as td')
                ->join('admin as a','a.depe_id','=','td.iddependencia')
                ->select('a.depe_id','td.iddependencia','a.adm_name')
                ->orderBy('adm_name','asc')
                ->get();
        $unidadOrganicas=\DB::table('tram_dependencia')
            ->where('depe_tipo','=','1')
            ->orderBy('depe_nombre','asc')
            ->groupBy('depe_nombre')->get();     
        
        $query5=(trim($request->get('searchText5'))>0)?trim($request->get('searchText5')):"";
             if($query5 !=''){
             $usuarios_buscados=\DB::table('admin')->orderBy('adm_sisgedo','asc')->where('depe_id','=',$query5)->get();}
        
        return view('tramite.administracion.bloques.nuevobloque',["unidadOrganicas"=>$unidadOrganicas, "searchText5"=>$query5, 'dependencias'=>$dependencias, 'usuarios_buscados'=>$usuarios_buscados]); 
    }

    public function usuarios($id)
    {
        $usuarios_buscados=\DB::table('admin as a')
            ->select('a.idsisguedo as id', 'a.adm_sisgedo as nombre', 'a.depe_id')
            ->where('a.depe_id', $id)
            ->orderBy('a.adm_name','asc')
            ->groupBy('adm_sisgedo')->get();
        
        return response()->json(array('usuarios_buscados'=> $usuarios_buscados), 200);
    }
    
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
