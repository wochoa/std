<?php

namespace App\Http\Controllers\Poi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class PoiSeguimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //POI SEGUIMIENTO
        return view('hola');
        
        
        /*if($request){
            //busqueda
            $query1=trim($request->get('searchText1'));
            $query2=trim($request->get('searchText2'));
            $query3=trim($request->get('searchText3'));
            $query4=trim($request->get('searchText4')); 
            //consulta
            $dependencias = DB::table('tram_dependencia')
            ->crossJoin('tram_dependencia as td2', 'td2.depe_depende', '=', 'tram_dependencia.iddependencia')
            ->select('td2.iddependencia as codigo','tram_dependencia.depe_nombre as depende','td2.depe_abreviado as abreviado','td2.depe_siglaxp as sigla','td2.depe_representante as representante','td2.depe_nombre as nombre')
                ->where('td2.iddependencia','LIKE','%'.$query1.'%')
                ->where('tram_dependencia.depe_nombre','LIKE','%'.$query2.'%')
                ->where('td2.depe_nombre','LIKE','%'.$query3.'%')
                ->where('td2.depe_representante','LIKE','%'.$query4.'%')
               // ->where('depe_tipo','=',0)
                ->paginate(10);
            
            //retornar select con tipo ==0 al search
            $dependencias_search=\DB::table('tram_dependencia')->orderBy('depe_nombre')
             ->where('depe_tipo','=',0)
             ->orderBy('depe_nombre','ASC')
             ->get();
			 
			 //retornar select del credito al search
            $credito_search=\DB::table('cred_credito')->orderBy('numero_credito')
             ->orderBy('numero_credito','ASC')
             ->get();
            //retorno
            return view('credito.credito.credito',["dependencias"=>$dependencias,'searchText1'=>$query1,'searchText2'=>$query2,'searchText3'=>$query3,'searchText4'=>$query4,'dependencias_search'=>$dependencias_search,'request'=>$request->all(),'creditos'=>$credito_search]);
        }*/
    
    }

    /*public function create()
    {
         $dependencias=\DB::table('tram_dependencia')->orderBy('depe_nombre')
             ->where('depe_tipo','=',0)
             ->orderBy('depe_nombre','ASC')
             ->get();
       return view('tramite.administracion.unidad-organica.nuevo-unidadorganica',["dependencias"=>$dependencias]);
    }*/

    /*public function store(Request $request)
    {
        $depe_depende=$request->input('depe_depende');
        $depe_nombre=$request->input('depe_nombre');
        $depe_abreviado=$request->input('depe_abreviado');
        $depe_siglaxp=$request->input('depe_siglaxp');
        $depe_representante=$request->input('depe_representante');
        $depe_cargo=$request->input('depe_cargo');
        $depe_proyectado=$request->input('depe_proyectado');
        $depe_recibetramite=$request->input('depe_recibetramite');
        $depe_maxenproceso=$request->input('depe_maxenproceso');
        $depe_diasmaxenproceso=$request->input('depe_diasmaxenproceso');
        //estado actual
        $depe_estado=$request->input('depe_estado');
        $depe_observaciones=$request->input('depe_observaciones');
       
        \DB::table('tram_dependencia')
            ->insert(['depe_depende'=>$depe_depende,'depe_nombre'=>$depe_nombre,'depe_abreviado'=>$depe_abreviado,'depe_siglaxp'=>$depe_siglaxp,'depe_representante'=>$depe_representante,'depe_cargo'=>$depe_cargo,'depe_proyectado'=>($depe_proyectado)?1:0, 'depe_recibetramite'=>($depe_recibetramite)?1:0, 'depe_maxenproceso'=>$depe_maxenproceso,'depe_diasmaxenproceso'=>$depe_diasmaxenproceso,'depe_estado'=>$depe_estado,'depe_observaciones'=>$depe_observaciones]);
        return Redirect('unidadorganica');
        
    }*/

    
    /*public function show($id)
    {
        //
    }/
    
    /*public function edit($id)
    {
      $dependencias=\DB::table('tram_dependencia')->orderBy('depe_nombre')
             ->where('depe_tipo','=','0')
             ->orderBy('depe_nombre','ASC')
             ->get();
       $dependencias_edit=\DB::table('tram_dependencia')->where('iddependencia',$id)->first();
       return view('tramite.administracion.unidad-organica.editar-unidadorganica',["dependencias"=>$dependencias,'dependencias_edit'=>$dependencias_edit]);
    }*/

    
    /*public function update(Request $request, $id)
    {
       $depe_depende=$request->input('depe_depende');
        $depe_nombre=$request->input('depe_nombre');
        $depe_abreviado=$request->input('depe_abreviado');
        $depe_siglaxp=$request->input('depe_siglaxp');
        $depe_representante=$request->input('depe_representante');
        $depe_cargo=$request->input('depe_cargo');
        $depe_proyectado=$request->input('depe_proyectado');
        $depe_recibetramite=$request->input('depe_recibetramite');
        $depe_maxenproceso=$request->input('depe_maxenproceso');
        $depe_diasmaxenproceso=$request->input('depe_diasmaxenproceso');
        //estado actual
        $depe_estado=$request->input('depe_estado');
        $depe_observaciones=$request->input('depe_observaciones');
       
        \DB::table('tram_dependencia')->where('iddependencia',$id)
            ->update(['depe_depende'=>$depe_depende,'depe_nombre'=>$depe_nombre,'depe_abreviado'=>$depe_abreviado,'depe_siglaxp'=>$depe_siglaxp,'depe_representante'=>$depe_representante,'depe_cargo'=>$depe_cargo,'depe_proyectado'=>($depe_proyectado)?1:0, 'depe_recibetramite'=>($depe_recibetramite)?1:0, 'depe_maxenproceso'=>$depe_maxenproceso,'depe_diasmaxenproceso'=>$depe_diasmaxenproceso,'depe_estado'=>$depe_estado,'depe_observaciones'=>$depe_observaciones]);
        return Redirect('unidadorganica');
    }*/

    /*public function destroy($id)
    {
       \DB::table('tram_dependencia')->where('iddependencia',$id)->delete();
        return Redirect('unidadorganica');
    }*/
}
