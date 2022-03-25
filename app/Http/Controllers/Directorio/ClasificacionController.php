<?php

namespace App\Http\Controllers\Directorio;
use App\Http\Controllers\Controller;
use App\_clases\directorio\Clasificacion;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use DB;

class ClasificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){            
            $mensaje=trim($request->get('mensaje'));
			$query=trim($request->get('searchText'));
            $query1=trim($request->get('searchText1'));     
            $dependencias= DB::table('tram_dependencia as td')
                ->join('admin as a','a.idsisguedo','=','td.depe_idusuariotransp')
                ->join('admin as a1','a1.idsisguedo','=','td.depe_idusuarioreclamo')
                ->select('a.adm_name','a.adm_lastname','td.iddependencia','td.depe_nombre','td.depe_abreviado','td.depe_agente','a1.adm_name as reclamo','a1.adm_lastname as reclamo1','a.idsisguedo','td.depe_idusuarioreclamo')
                ->where('depe_tipo','=','0')
                ->where('iddependencia','LIKE','%'.$query.'%')
                ->where('depe_nombre','LIKE','%'.$query1.'%')
                ->orderBy('iddependencia','desc')
                ->groupBy('iddependencia')
                ->paginate(15); 
                                
            /*$usuarios= DB::table('admin as a')           
                ->join('tram_dependencia as td','td.depe_idusuariotransp','=','a.idsisguedo')
                ->select('a.adm_name')
                ->orderBy('adm_name','asc')
                ->groupBy('idsisgedo')                */
			
			$clasificaciones= DB::table('dir_clasificacion')
                ->orderBy('cla_id','asc')
                ->paginate(10);
                     
            return view('directorio.clasificacion',["mensaje"=>$mensaje,"dependencias"=>$dependencias, "searchText"=>$query,"searchText1"=>$query1,'request'=>$request->all(),"clasificaciones"=>$clasificaciones]);
        }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		/*$fecha_actual = Carbon::now();
		
		$ubigeo = DB::table('ubigeo')
             ->where('ubi_nombre_dep','HUANUCO')
			 ->select('ubi_nombre_dep', 'ubi_idubigeo',DB::raw('CONCAT(ubi_nombre_dep, " - ", ubi_nombre_prov, " - ", ubi_nombre_dist ) AS lugar') )
             ->orderBy('ubi_nombre_dep','ASC')
			 ->orderBy('ubi_nombre_prov','ASC')
			 ->orderBy('ubi_nombre_dist','ASC')
             ->pluck('lugar','ubi_idubigeo');*/
			 //dd($ubigeo);
       return view('directorio.clasificacion.nuevo-clasificacion');
    }
	
	public function autocomplete(){
		
	}
	
	public function store(Request $request)
    {
		$cla_descripcion = strtoupper($request->input('cla_descripcion'));
		$resultado_mensaje = "";
		
		if( Clasificacion::existe('cla_descripcion', $cla_descripcion ) ){
			$resultado_mensaje = "Ya existe esta clasificación";
		}
		else if( trim($cla_descripcion)=="" ){
			$resultado_mensaje = "Ingrese un valor.";
		}
		else{
			try{
				DB::table('dir_clasificacion')
				->insert([
					'cla_descripcion'=>$cla_descripcion
				]);
				$resultado_mensaje = "Se agregó la clasificación";
			}
			catch(Exception $e){
				echo $resultado_mensaje = 'Error: ' .$e->getMessage();
			}
		}
		
		//return view('directorio.clasificacion',["mensaje"=>$resultado_mensaje]);
		return redirect()->action('Directorio\ClasificacionController@index',["mensaje"=>$resultado_mensaje]);
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function show($id)
    {
        //
    }/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //$clasificaciones_edit=\DB::table('dir_clasificacion')->where('cla_id',$id)->first();
	   $clasificaciones_edit=Clasificacion::findOrFail($id);
       return view('directorio.clasificacion.editar-clasificacion',['clasificaciones_edit'=>$clasificaciones_edit]);
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
		$clasificacion_update = Clasificacion::findOrFail($id);
		$clasificacion_update->fill($request->all());
		$clasificacion_update->save();
		return redirect()->action('Directorio\ClasificacionController@index',["mensaje"=>"Se actualizaron los datos|"]);
		
        /*
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
        return Redirect('unidadorganica');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy($id)
    {
       \DB::table('tram_dependencia')->where('iddependencia',$id)->delete();
        return Redirect('unidadorganica');
    }*/
}
