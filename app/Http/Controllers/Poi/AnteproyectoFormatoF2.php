<?php

namespace App\Http\Controllers\Poi;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use App\_clases\poi\PlanDetalle;
use App\_clases\siaf\SiafMeta;

class AnteproyectoFormatoF2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
        //return view("poi.anteproyecto.formatof1");
        return view("poi.anteproyecto.formatof1");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
	
	/**
     * Show the form for creating a new resource.
     *
	 * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_actividad( Request $request )
    {
		$id_poi=$request->input('codigo');
		
		//obtiene los datos para el select C.E.
		$ces_q = DB::table('poi_plan_detalle')
			 ->where( 'plan_id','=','1' )//PDRC
			 ->where( 'plan_det_categoria','=','EE' )//C.E.
			 ->select( 'plan_det_id', DB::raw('CONCAT(plan_det_codigo,". ",plan_det_descripcion) AS descripcion') )
             ->orderBy('plan_det_codigo','ASC')
			 ->pluck('descripcion', 'plan_det_id');
			 
		$ces[""]="Seleccione";
		foreach( $ces_q as $k => $v ){
			$ces[ $k ] = $v;
		}
		//dd($ces);
		//obtiene los datos para el select O.E.I.
		$oeis = DB::table('poi_plan_detalle')
			 ->where( 'plan_id','=','2' )//PEI
			 ->where( 'plan_det_categoria','=','OEI' )//O.E.I.
             ->orderBy('plan_det_codigo','ASC')
             ->get();
		
		//obtiene los datos de los programas presupuestales de un determinado año
		$prog_pres_q = DB::table('siaf_programa_ppto_nombre')
			 ->where( 'ANO_EJE','=','2016' )//Año de ejecución
			 ->whereNotIn( 'PROGRAMA_P',[9001, 9002] )//C.E.
			 ->select( 'PROGRAMA_P', DB::raw('CONCAT(PROGRAMA_P,". ",NOMBRE) AS descripcion') )
             ->orderBy('PROGRAMA_P','ASC')
			 ->pluck('descripcion', 'PROGRAMA_P');
			 
		$prog_pres[""]="Seleccione";
		foreach( $prog_pres_q as $k => $v ){
			$prog_pres[ $k ] = $v;
		}
		
		//meta presupuestaria
		$meta_presupuestaria_q = SiafMeta::obtener_metas_por_anio_select(2017);
		$meta_presupuestaria[""]="Seleccione";
		foreach( $meta_presupuestaria_q as $k => $v ){
			$meta_presupuestaria[ $k ] = $v;
		}
		
        return view("poi.anteproyecto.formatof2",['id_poi'=>$id_poi, 'ces'=>$ces, 'oeis'=>$oeis, 'prog_pres'=>$prog_pres, 'meta_presupuestaria'=>$meta_presupuestaria] );
    }
	
	public function obtener_oets(Request $request, $tipo, $ce){
		
		if($request->ajax()){
			switch($tipo){
			case 1://obtiene todos los oets
				$oets = PlanDetalle::obtener_oets($ce);
				return response()->json($oets);
				break;
			case 2://obtiene los oets de acuerdo al indicador seleccionado
				$oets = PlanDetalle::obtener_oet_por_indicador($ce);
				return response()->json($oets);
				break;
			case 3://obtiene todos los aets
				$aets = PlanDetalle::obtener_aets($ce);
				return response()->json($aets);
				break;
			}
		}
	}
	
	public function obtener_aets(Request $request, $tipo, $padre, $ce){
		
		if($request->ajax()){
			switch($tipo){
			case 1://obtiene los indicadores de la aet seleccionada
				$aets = PlanDetalle::obtener_aet_por_indicador($padre, $ce);
				return response()->json($aets);
				break;
			}
		}
	}
	
	public function obtener_datos_siaf_meta_por_id(Request $request, $id){
		
		if($request->ajax()){
				$meta = SiafMeta::obtener_metas_por_id($id);
				return response()->json($meta);
		}
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
