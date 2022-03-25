<?php

namespace App\Http\Controllers\Directorio;
use App\Http\Controllers\Controller;
use App\_clases\directorio\Unidad;
use App\_clases\directorio\Persona;

use App\DataTables\DirectoriosDataTable;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use DB;

class DirectorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DirectoriosDataTable $dataTable)
    {
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
			 
            //retorno
            return view('directorio.directorio',["mensaje"=>"","dependencias"=>$dependencias,'searchText1'=>$query1,'searchText2'=>$query2,'searchText3'=>$query3,'searchText4'=>$query4,'dependencias_search'=>$dependencias_search,'request'=>$request->all()]);*/
			
			//return dd($dataTable->query());
        //}
		return $dataTable->render('directorio.directorio');
    }
	
	public function anyData()
    {
		//$unidades = DB::table('dir_unidad'); 
		$directorio = DB::table('dir_persona')
            ->join('dir_asignacion', 'dir_asignacion.persona_id', '=', 'dir_persona.per_id')
            ->join('dir_unidad', 'dir_asignacion.unidad', '=', 'dir_unidad.uni_id')
			->join('dir_tipo_unidad', 'dir_unidad.tipo_unidad', '=', 'dir_tipo_unidad.tip_uni_id')
            ->select('dir_unidad.uni_denominacion', 'dir_unidad.uni_direccion', 'dir_unidad.uni_fono','dir_persona.per_nombre','dir_persona.per_apellido','dir_asignacion.asi_cargo');
        return Datatables::of($directorio)->make(true);
    }

	
	public function saludo()
    {
		return 'Hello World again';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
		
		$resultado_mensaje = trim($request->get('mensaje'));
		
		$ubigeo = DB::table('ubigeo')
             ->where('ubi_nombre_dep','HUANUCO')
			 ->select('ubi_nombre_dep', 'ubi_idubigeo',DB::raw('CONCAT(ubi_nombre_dep, " - ", ubi_nombre_prov, " - ", ubi_nombre_dist ) AS lugar') )
             ->orderBy('ubi_nombre_dep','ASC')
			 ->orderBy('ubi_nombre_prov','ASC')
			 ->orderBy('ubi_nombre_dist','ASC')
             ->pluck('lugar','ubi_idubigeo');
			 //dd($ubigeo);
		
		$tipo_unidad = DB::table('dir_tipo_unidad')
			->get();
             //->pluck('tip_uni_denominacion','tip_uni_id');
		
		$unidades = DB::table('dir_unidad')
			->get();
            //->pluck('uni_denominacion','uni_id');
		
		
       return view('directorio.directorio.nuevo-directorio',["ubigeo"=>$ubigeo, "tipo_unidad"=>$tipo_unidad, "unidades"=>$unidades,["mensaje"=>$resultado_mensaje]]);
    }
	
	public function autocomplete(){
		
	}
	
	public function store(Request $request)
    {
		$resultado_mensaje = "";
		
		/*Datos de la tabla unidad*/
		$uni_id = '';
		$uni_denominacion = strtoupper($request->input('uni_denominacion'));
		$uni_fono = ($request->input('uni_fono'));
		$uni_direccion = strtoupper($request->input('uni_direccion'));
		$uni_direccion_web = ($request->input('uni_direccion_web'));
		$uni_contactos_varios = ($request->input('uni_contactos_varios'));
		$ubigeo = ($request->input('ubigeo'));
		$superior = ($request->input('superior'));
		$tipo_unidad = ($request->input('tipo_unidad'));
		$uni_colaboradores = strtoupper($request->input('uni_colaboradores'));
		/*Fin datos de la tabla unidad */
		
		/*Datos de la tabla persona*/
		$per_id = '';
		$per_dni = ($request->input('per_dni'));
		$per_nombre = strtoupper($request->input('per_nombre'));
		$per_apellido = strtoupper($request->input('per_apellido'));
		$per_fono = ($request->input('per_fono'));
		$per_direccion = strtoupper($request->input('per_direccion'));
		$per_email = ($request->input('per_email'));
		/*Fin datos de la tabla unidad */
		
		/*Datos de la asignación*/
		$asi_id = "";
		$asi_fecha_inicio = Carbon::now();
		$asi_vigente = 'Sí'; //No se controla si una persona puede representar dos o más entidades o unidades.
		$asi_cargo = strtoupper($request->input('asi_cargo'));
		$asi_tipo = 'Representante';
		/*Fin datos de la asignación*/
		
		/*Verificación de la unidad*/
		if( Unidad::existe('uni_denominacion', $uni_denominacion ) ){
			$resultado_mensaje = "Ya existe esta entidad / unidad";
		}
		else{
			try{
				/*1. Registro de la unidad*/
				$uni_id = DB::table('dir_unidad')
				->insertGetId([
					'uni_denominacion'=>$uni_denominacion,
					'uni_fono'=>$uni_fono,
					'uni_direccion'=>$uni_direccion,
					'uni_direccion_web'=>$uni_direccion_web,
					'uni_contactos_varios'=>$uni_contactos_varios,
					'ubigeo'=>$ubigeo,
					'superior'=>$superior,
					'tipo_unidad'=>$tipo_unidad,
					'uni_colaboradores'=>$uni_colaboradores
				]);
				/*Fin registro de la unidad*/
				
				/*2. Registro de la persona*/
				if( Persona::existe('per_dni', $per_dni ) && !( is_null($per_dni) || $per_dni==''  ) ){
					$per_id = Persona::obtener_id('per_dni', $per_dni );
				}
				else{
					$per_id = DB::table('dir_persona')
					->insertGetId([
						'per_dni'=>$per_dni,
						'per_nombre'=>$per_nombre,
						'per_apellido'=>$per_apellido,
						'per_fono'=>$per_fono,
						'per_direccion'=>$per_direccion,
						'per_email'=>$per_email
					]);
				}
				/*Fin registro de la persona*/
				
				/*3. Registro de la asignación*/
				DB::table('dir_asignacion')
					->where('persona_id',$per_id)
					->where('unidad',$uni_id)
					->update(['asi_vigente' => 'No']);
				
				DB::table('dir_asignacion')
					->insert([
						'persona_id'=>$per_id,
						'unidad'=>$uni_id,
						'asi_fecha_inicio'=>$asi_fecha_inicio,
						'asi_vigente'=>$asi_vigente,
						'asi_cargo'=>$asi_cargo,
						'asi_tipo'=>$asi_tipo
					]);
				/*Fin registro de la asignaión*/
				$resultado_mensaje = "Se agregó al directorio";
			}
			catch(Exception $e){
				echo $resultado_mensaje = 'Error: ' .$e->getMessage();
			}
		}
		
		//return view('directorio.directorio',["mensaje"=>$resultado_mensaje]);
		return redirect()->action('Directorio\DirectorioController@create', ["mensaje"=>$resultado_mensaje]);
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
