<?php

namespace App\Http\Controllers\Credito;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;

class ControlcredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prestamos = DB::table('cred_prestamo as cp')->join('cred_cliente as cc', 'cp.cliente', '=', 'cc.id_cliente')->select('cp.nro_prestamo as numero', 'cc.cli_nombres as nombres', 'cc.cli_apellidos as apellidos', 'cp.pres_monto as monto', 'cp.pres_fecha as fecha')->get();
        return view('credito.controlprestamos.inicio')->with('prestamos', $prestamos);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pago = DB::table('cred_control_prestamo')->insertGetId([
            'cred_con_voucher'=>$request->cred_con_voucher,
            'cred_con_monto'=>$request->cred_con_monto,
            'cred_con_fecha_pago'=>$request->cred_con_fecha_pago,
            'cred_con_fecha_registro'=>Carbon::now(),
            'cred_con_persona'=>$request->cred_con_persona,
            'prestamo'=>$request->prestamo
            
        ]);
        
        return redirect('control-credito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prestamo = DB::table('cred_prestamo')->where('nro_prestamo', '=', $id)->first();
        $cliente = DB::table('cred_cliente')->where('id_cliente', '=', $prestamo->cliente)->first();
        $aval1 = DB::table('cred_aval')->where('id_aval', '=', $prestamo->pres_aval_1)->first();
        $aval2 = DB::table('cred_aval')->where('id_aval', '=', $prestamo->pres_aval_2)->first();
        $aval3 = DB::table('cred_aval')->where('id_aval', '=', $prestamo->pres_aval_3)->first();
        $pagos = DB::table('cred_control_prestamo')->where('prestamo', '=', $prestamo->nro_prestamo)->get();
        return view('credito.controlprestamos.mostrar')->with('prestamo', $prestamo)->with('cliente', $cliente)->with('aval1', $aval1)->with('aval2', $aval2)->with('aval3', $aval3)->with('pagos', $pagos);
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
