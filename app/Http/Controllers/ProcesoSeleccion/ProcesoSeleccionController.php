<?php

namespace App\Http\Controllers\ProcesoSeleccion;
use App\Http\Controllers\Controller;
use App\_clases\procesoseleccion\ProcesoSeleccion;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use DB;

class ProcesoSeleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
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
        }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {		
		$nro_concurso = DB::table('cas_proceso_seleccion')
			 ->select(DB::raw('MAX(cas_proc_sel_nro_concurso) AS nro_concurso' ) )->get();
       return view('procesoseleccion.nuevo-procesoseleccion',["nro_concurso"=>$nro_concurso]);
    }
	
	public function autocomplete(){
		
	}
	
	public function store(Request $request)
    {
		/*
			Proceso de Ingreso, Proceso y Salida
			* Ingreso:
						--Recepcionar en cada variables del formulario o de una función.
			* Proceso:
						--Verificar si existe o no.
						--Obtener un dato a partir de un índice o valor a buscar.
						--Registrar en base de datos si es necesario
			* Salida:
						--Vista
		*/
		
		/*****Inicio datos del proceso de selección*****/
		//Ingreso
		$id_proc_sel_cas = "";
		$proc_sel_cas_descripcion = strtoupper($request->input('proc_sel_cas_descripcion'));
		$proc_sel_cas_fecha_inicio = $request->input('proc_sel_cas_fecha_inicio');
		$proc_sel_cas_fecha_termino = $request->input('proc_sel_cas_fecha_termino');
		$cas_proc_sel_fecha_fin_inscripcion = $request->input('cas_proc_sel_fecha_fin_inscripcion');
		$cas_proc_sel_fecha_resultados = $request->input('cas_proc_sel_fecha_resultados');
		$cas_proc_sel_estado = 1;
		$cas_proc_sel_nro_concurso = $request->input('cas_proc_sel_nro_concurso');
		$cas_proc_sel_estado_calificacion_etapa1 = 0;
		$cas_proc_sel_estado_calificacion_etapa2 = 0;
		//Fin ingreso
		
		//Proceso. verificación:Si existe el proceso de selección se obtiene su id
		if( ProcesoSeleccion::existe( 'proc_sel_cas_descripcion', $proc_sel_cas_descripcion ) ){
			try{
				$id_proc_sel_cas = ProcesoSeleccion::obtener_id( 'proc_sel_cas_descripcion', $proc_sel_cas_descripcion );
			}
			catch(Exception $e){
				echo 'Mensaje: ' .$e->getMessage();
			}
		}
		else{//Sino, se registra en la tabla cas_proceso_seleccion y se obtiene el id registrado del nuevo proceso de seleccion por ser autonumérico.
			try{
				DB::table('cas_proceso_seleccion')
				->insert([
							'proc_sel_cas_descripcion'=>$proc_sel_cas_descripcion,
							'proc_sel_cas_fecha_inicio'=>$proc_sel_cas_fecha_inicio,
							'proc_sel_cas_fecha_termino'=>$proc_sel_cas_fecha_termino,
							'cas_proc_sel_fecha_fin_inscripcion'=>$cas_proc_sel_fecha_fin_inscripcion,
							'cas_proc_sel_fecha_resultados'=>$cas_proc_sel_fecha_resultados,
							'cas_proc_sel_estado'=>$cas_proc_sel_estado,
							'cas_proc_sel_nro_concurso'=>$cas_proc_sel_nro_concurso,
							'cas_proc_sel_estado_calificacion_etapa1'=>$cas_proc_sel_estado_calificacion_etapa1,
							'cas_proc_sel_estado_calificacion_etapa2'=>$cas_proc_sel_estado_calificacion_etapa2
						]);
			}
			catch(Exception $e){
				echo 'Mensaje: ' .$e->getMessage();
			}
		}
		//Fin proceso.
		//Salida: El id del cliente a registrar
		/*****Fin datos del cliente del préstamo*****/
		
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
    /*public function edit($id)
    {
      $dependencias=\DB::table('tram_dependencia')->orderBy('depe_nombre')
             ->where('depe_tipo','=','0')
             ->orderBy('depe_nombre','ASC')
             ->get();
       $dependencias_edit=\DB::table('tram_dependencia')->where('iddependencia',$id)->first();
       return view('tramite.administracion.unidad-organica.editar-unidadorganica',["dependencias"=>$dependencias,'dependencias_edit'=>$dependencias_edit]);
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
