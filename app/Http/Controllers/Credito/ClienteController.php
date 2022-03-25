<?php

namespace App\Http\Controllers\Credito;
use App\Http\Controllers\Controller;
use App\_clases\Credito;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use DB;

class ClienteController extends Controller
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
                ->get();
            
            return view('credito.cliente.cliente', ['clientes'=>$clientes, 'request'=>$request->all()]);
        }
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
        return view('credito.cliente.cliente.nuevoCliente', ['fecha_actual'=>$fecha_actual, 'ubigeos'=>$ubigeos]);
    }
	
	public function autocomplete(){
		
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$date = Carbon::now();        
        
        $cli_nombres=$request->input('cli_nombres');
        $cli_apellidos=$request->input('cli_apellidos');
        $cli_dni=$request->input('cli_dni');
        $cli_ruc=$request->input('cli_ruc');
        $ubigeo=$request->input('ubigeo');
        $cli_direccion=$request->input('cli_direccion');
        $cli_domicilio=$request->input('cli_domicilio');
        $cli_fono=$request->input('cli_fono');
        $cli_email=$request->input('cli_email');        
        $cli_fecha_sistema=$date->toDateTimeString();
       
        \DB::table('cred_cliente')
            ->insert(['cli_nombres'=>$cli_nombres, 'cli_apellidos'=>$cli_apellidos, 'cli_dni'=>$cli_dni, 'cli_ruc'=>$cli_ruc, 'ubigeo'=>$ubigeo, 'cli_direccion'=>$cli_direccion, 'cli_domicilio'=>$cli_domicilio, 'cli_fono'=>$cli_fono, 'cli_email'=>($cli_email), 'cli_fecha_sistema'=>$cli_fecha_sistema]);
        
        return Redirect('cliente');        
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
        $ubigeos= DB::table('ubigeo')
            ->select('ubi_idubigeo as id', 'ubi_nombre_dep as dep', 'ubi_nombre_prov as prov', 'ubi_nombre_dist as dist')
            ->where('ubi_id_dep', '9')
            ->orderBy('ubi_nombre_dep','ASC')
			->orderBy('ubi_nombre_prov','ASC')
			->orderBy('ubi_nombre_dist','ASC')
            ->get();
        
       $cliente_edit=\DB::table('cred_cliente')->where('id_cliente',$id)->first();
       return view('credito.cliente.cliente.editCliente',['ubigeos'=>$ubigeos, 'cliente_edit'=>$cliente_edit]);
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
        $date = Carbon::now();        
        
        $cli_nombres = $request->input('cli_nombres');
        $cli_apellidos = $request->input('cli_apellidos');
        $cli_dni = $request->input('cli_dni');
        $cli_ruc = $request->input('cli_ruc');
        $ubigeo = $request->input('ubigeo');
        $cli_direccion = $request->input('cli_direccion');
        $cli_domicilio = $request->input('cli_domicilio');
        $cli_fono = $request->input('cli_fono');
        $cli_email = $request->input('cli_email');        
        $cli_fecha_sistema = $date->toDateTimeString();
        
        \DB::table('cred_cliente')->where('id_cliente', $id)
            ->update(['cli_nombres'=>$cli_nombres, 'cli_apellidos'=>$cli_apellidos, 'cli_dni'=>$cli_dni, 'cli_ruc'=>$cli_ruc, 'ubigeo'=>$ubigeo, 'cli_direccion'=>$cli_direccion, 'cli_domicilio'=>$cli_domicilio, 'cli_fono'=>$cli_fono, 'cli_email'=>$cli_email, 'cli_fecha_sistema'=>$cli_fecha_sistema]);
        
        return Redirect('cliente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       \DB::table('cred_cliente')->where('id_cliente',$id)->delete();
        return Redirect('cliente');
    }
}
