<?php

namespace App\Http\Controllers\Credito;
use App\Http\Controllers\Controller;
use App\_clases\credito\Cliente;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use DB;

class CreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            
            $clientes= DB::table('cred_cliente as cli')
                ->join('ubigeo as ubi', 'cli.ubigeo', '=', 'ubi.ubi_idubigeo')
                ->select('cli.id_cliente as codigo', 'cli.cli_nombres as nombres', 'cli.cli_apellidos as apellidos', 'cli.cli_dni as dni', 'ubi.ubi_nombre_dep as dep', 'ubi.ubi_nombre_prov as prov', 'ubi.ubi_nombre_dist as dist', 'cli.cli_fono as telefono')
                ->orderBy('id_cliente', 'asc')
                ->all();
            
            return view('credito.credito.credito.buscarCliente', ['clientes'=>$clientes, 'request'=>$request->all()]);
        }
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fecha_actual = Carbon::now();
        
		$ubigeos= DB::table('ubigeo')
            ->select('ubi_idubigeo as id', 'ubi_nombre_dep as dep', 'ubi_nombre_prov as prov', 'ubi_nombre_dist as dist')
            ->where('ubi_id_dep', '9')
            ->orderBy('ubi_nombre_dep','ASC')
			->orderBy('ubi_nombre_prov','ASC')
			->orderBy('ubi_nombre_dist','ASC')
            ->get();       
        
        $clientes= DB::table('cred_cliente as cli')
                ->join('ubigeo as ubi', 'cli.ubigeo', '=', 'ubi.ubi_idubigeo')
                ->select('cli.id_cliente as codigo', 'cli.cli_nombres as nombres', 'cli.cli_apellidos as apellidos', 'cli.cli_dni as dni', 'ubi.ubi_nombre_dep as dep', 'ubi.ubi_nombre_prov as prov', 'ubi.ubi_nombre_dist as dist', 'cli.cli_fono as telefono')
                ->orderBy('id_cliente', 'asc')
                ->paginate(15);
        return view('credito.credito.credito.nuevoCredito',["ubigeos"=>$ubigeos, "anio"=>$fecha_actual->format('Y'), "clientes"=>$clientes, "fecha_actual"=>$fecha_actual]);   
		/*
       return view('credito.credito.nuevo-credito',["ubigeo"=>$ubigeo, "anio"=>$fecha_actual->format('Y'), "fecha"=>$fecha_actual]);*/
    }
    
	public function cliente($id)
    {       
        $clientes_buscados= DB::table('cred_cliente as cli')
            ->select('cli.cli_nombres as nombres', 'cli.cli_apellidos as apellidos', 'cli.cli_dni as dni', 'cli.cli_fono as telefono')
            ->where('id_cliente', '=', $id)
            ->orderBy('id_cliente', 'asc')
            ->get();   
        
        return response()->json(array('clientes_buscados'=> $clientes_buscados), 200);
    }
    
	public function autocomplete(){
		
	}
	
	public function store(Request $request)
    {
		$date = Carbon::now();      
        
		$pres_anio = $request->input('pres_anio');
        $cliente = DB::table('cred_cliente')->where('cli_dni', '=', $request->input('cliente'))->first();
        $cliente = $cliente->id_cliente;
		$pres_tipo = $request->input('pres_tipo');
		$pres_monto = $request->input('pres_monto');
		$pres_cuotas = $request->input('pres_cuotas');
		$pres_tasa_interes = $request->input('pres_tasa_interes');
		$pres_fecha = $request->input('pres_fecha');
        $pres_fecha_sistema=$date->toDateTimeString();
        
        //----------------------------------------GUARDAR AVAL O AVALES----------------------------------------
        //dd($pres_tipo);
        if($pres_tipo == 1){
            $aval_nombres = $request->input('aval_nombres_1');
            $aval_apellidos = $request->input('aval_apellidos_1');
            $aval_dni = $request->input('aval_dni_1');
            $aval_fono = $request->input('aval_fono_1');
            $aval_fecha_sistema = $date->toDateTimeString();

            $idaval_1 = DB::table('cred_aval')
                ->insertGetId(['aval_nombres'=>$aval_nombres, 'aval_apellidos'=>$aval_apellidos, 'aval_dni'=>$aval_dni, 'aval_fono'=>$aval_fono, 'aval_fecha_sistema'=>$aval_fecha_sistema]);
            $idaval_2 = '';
            $idaval_3 = '';
        }
        else{
            //AVAL NUMERO 1
            $aval = DB::table('cred_aval')->where('aval_dni', '=', $request->input('aval_dni_1'))->first();
            if($aval){
                $idaval_1 = $aval->id_aval;
            }else{
                $aval_nombres = $request->input('aval_nombres_1');
                $aval_apellidos = $request->input('aval_apellidos_1');
                $aval_dni = $request->input('aval_dni_1');
                $aval_fono = $request->input('aval_fono_1');
                $aval_fecha_sistema = $date->toDateTimeString();

                $idaval_1 = DB::table('cred_aval')
                    ->insertGetId(['aval_nombres'=>$aval_nombres, 'aval_apellidos'=>$aval_apellidos, 'aval_dni'=>$aval_dni, 'aval_fono'=>$aval_fono, 'aval_fecha_sistema'=>$aval_fecha_sistema]);
            }
            
            //AVAL NUMERO 2
            if($request->input('aval_dni_2') != ""){
                
                $aval = DB::table('cred_aval')->where('aval_dni', '=', $request->input('aval_dni_2'))->first();
                if($aval){
                    $idaval_2 = $aval->id_aval;
                }else{
                    $aval_nombres = $request->input('aval_nombres_2');
                    $aval_apellidos = $request->input('aval_apellidos_2');
                    $aval_dni = $request->input('aval_dni_2');
                    $aval_fono = $request->input('aval_fono_2');
                    $aval_fecha_sistema = $date->toDateTimeString();

                    $idaval_2 = DB::table('cred_aval')
                        ->insertGetId(['aval_nombres'=>$aval_nombres, 'aval_apellidos'=>$aval_apellidos, 'aval_dni'=>$aval_dni, 'aval_fono'=>$aval_fono, 'aval_fecha_sistema'=>$aval_fecha_sistema]);
                }
            }else{
                $idaval_2 = null;
            }
            
            //AVAL NUMERO 3
            if($request->input('aval_dni_3') != ""){
                $aval = DB::table('cred_aval')->where('aval_dni', '=', $request->input('aval_dni_3'))->first();
                if($aval){
                    $idaval_3 = $aval->id_aval;
                }else{
                    $aval_nombres = $request->input('aval_nombres_3');
                    $aval_apellidos = $request->input('aval_apellidos_3');
                    $aval_dni = $request->input('aval_dni_3');
                    $aval_fono = $request->input('aval_fono_3');
                    $aval_fecha_sistema = $date->toDateTimeString();

                    $idaval_3 = DB::table('cred_aval')
                        ->insertGetId(['aval_nombres'=>$aval_nombres, 'aval_apellidos'=>$aval_apellidos, 'aval_dni'=>$aval_dni, 'aval_fono'=>$aval_fono, 'aval_fecha_sistema'=>$aval_fecha_sistema]);
                }
            }else{
                $idaval_3 = null;
            }
        }
        //----------------------------------------GUARDAR AVAL O AVALES----------------------------------------
        
        $idprestamo = DB::table('cred_prestamo')
            ->insertGetId(['pres_anio'=>$pres_anio, 'cliente'=>$cliente, 'pres_tipo'=>$pres_tipo, 'pres_monto'=>$pres_monto, 'pres_cuotas'=>$pres_cuotas, 'pres_tasa_interes'=>$pres_tasa_interes, 'pres_fecha'=>$pres_fecha, 'pres_fecha_sistema'=>$pres_fecha_sistema, 'pres_aval_1'=>($idaval_1)?$idaval_1:null, 'pres_aval_2'=>($idaval_2)?$idaval_2:null, 'pres_aval_3'=>($idaval_3)?$idaval_3:null]);
        
        return Redirect('credito/'.$idprestamo.'/Reporte'); 
	}

    public function reporte($id)        
    {
        
        $credito = DB::table('cred_prestamo as cre')
            ->join('cred_cliente as cli', 'cre.cliente', '=', 'cli.id_cliente')
            ->select('cre.nro_prestamo as prestamo', 'cre.cliente as codigo', 'cre.pres_monto as monto', 'cre.pres_cuotas as cuotas', 'cre.pres_tasa_interes as interes', 'cre.pres_fecha as fecha','cre.pres_fecha as fecha', DB::raw('day(cre.pres_fecha) AS dia'), DB::raw('month(cre.pres_fecha) AS mes'), DB::raw('year(cre.pres_fecha) AS anio'), 'cli.cli_nombres as nombres', 'cli.cli_apellidos as apellidos', 'cli.cli_dni as dni', 'cli.cli_ruc as ruc')
            ->where('cre.nro_prestamo', '=', $id)
            ->first();
        return view('credito.credito.credito.reporteCredito', ['credito'=>$credito]);
    }

    public function show($id)        
    {
        //
    }
    
    public function buscarDni(Request $request){
        $cliente = DB::table('cred_cliente')->where('cli_dni', '=', $request->dni)->first();

        if($cliente){
            return ['nombres'=>$cliente->cli_nombres, 'apellidos'=>$cliente->cli_apellidos];
        }else{
            return ['nombres'=>'NO SE ENCONTRÓ', 'apellidos'=>'NO SE ENCONTRÓ'];
        }
    }
    
    public function buscarAval(Request $request){
        
        $aval = DB::table('cred_aval')->where('aval_dni', '=', $request->dni)->first();

        if($aval){
            return ['nombres'=>$aval->aval_nombres, 'apellidos'=>$aval->aval_apellidos, 'fono'=>$aval->aval_fono, 'resultado'=>'ok'];
        }else{
            return ['nombres'=>'', 'apellidos'=>'', 'fono'=>'', 'resultado'=>'error'];
        }
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
