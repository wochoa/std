<?php

namespace App\Http\Controllers\Proy\tools;

use App\_clases\proyectos\plan\Componente;
use App\_clases\proyectos\tools\modificar\Modificatoria;
use App\_clases\proyectos\tools\modificar\ModificatoriaDetalle;
use App\_clases\siaf\Especifica;
use App\_clases\siaf\FuenteFinanciamiento;
use App\_clases\utilitarios\Money;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Yajra\Datatables\Facades\Datatables;
use Response;
use App\_clases\proyectos\ProyectosPDFF;

class ModificatoriaDetalleC extends Controller
{

    public function index(Request $request)
    {
        $anio   = $request->anio;
        $modif  = $request->modif;
        $fft    = $request->fft;
        $opt    = $request->opt;

        // if(!isset($request->option)) {

        //     $mdet=Modificatoria::find($modif);
        //     return view('proyectos.herramientas.modificar.detalle.index',[
        //         'anio'=>$anio,
        //         'modif_nombre'=>$mdet->modif_titulo,
        //         'modif_fecha'=>$mdet->modif_fecha_aprovacion,
        //         'modif'=>$modif,
        //         'fft'=>$fft,
        //         'opt'=> $opt,
        //         'fuenteFinanciamiento'=>FuenteFinanciamiento::getFuenteFinanciamientoToSelect(),
        //         'especificas'=>Especifica::getEspecificasToSelect2()
        //     ]);
        // }
        // else
            switch ($request->option){
                case 'listar':{
                    $detalle=[];
                    $detalle=$this->modificacionesToArray($anio, $modif, $fft, $opt, $detalle);

                    $json_data = array(
                        'proyectos'  =>$detalle['proyectos'],
                        'total'     =>$detalle['total']
                    );

                    return json_encode($json_data);

                    // return view('proyectos.herramientas.modificar.detalle.listar',
                    //     ['anio'=>$anio,'modif'=>$modif,'detalles'=>$detalle['detalle'],'total'=>$detalle['total'], 'opt'=> $opt]);
                    break;
                }
                case 'imprimir':{
                    $modificaciones = $this->modificacionesToArrayForPPrint($anio, $modif, $fft, $opt);
                    $priorizacion = $this->priorizacionToArray($anio, $modif, $fft, $opt);
                    $fecha = Carbon::now();
                    $modificatoria = Modificatoria::find($modif);
                    $fuente=FuenteFinanciamiento::getFuenteFinanciamiento($anio,$fft);
                    //dd($modificaciones);
                    return view('proyectos.herramientas.modificar.detalle.imprimir', [
                        'modificaciones'=>$modificaciones['modificaciones'],
                        'priorizaciones'=>$priorizacion,
                        'fecha'=>$fecha,
                        'modificatoria'=>$modificatoria,
                        'fuenteFinanciamiento'=>$fuente
                    ]);
                    //aqui se imprime el pdf

                    /*$headers = ['Content-Type' => 'application/pdf'];
                    $pdf = new ProyectosPDFF();
                    $fecha = Carbon::now();

                    //establecemos los parametros para el header y footer del documento
                    $pdf->SetHeader('',utf8_decode('Impresión generada a las '.$fecha->toTimeString().' del '.$fecha->toDateString()));
                    $pdf->SetFooter('img/selloGerente.PNG','');

                    $pdf->AddPage('L', 'A4');

                    $w = $pdf->GetPageWidth();

                    $pdf->SetFont('Arial', 'B', 12);
                    $pdf->Ln();
                    $pdf->Cell($w*0.9, 7, utf8_decode($modificatoria->modif_titulo),0,0,'C');

                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Ln();
                    $pdf->Cell($w*0.2, 7, utf8_decode('PLIEGO'),0,0,'L');
                    $pdf->Cell($w*0.2, 7, utf8_decode(': 448 GOBIERNO REGIONAL HUANUCO'),0,0,'L');
                    $pdf->Ln();
                    $pdf->Cell($w*0.2, 7, utf8_decode('FTE. DE FTO.'),0,0,'L');
                    $pdf->Cell($w*0.2, 7, utf8_decode(': '.$fuente),0,0,'L');
                    $pdf->Ln();

                    $w = array($w*0.06,$w*0.06,$w*0.05,$w*0.06,$w*0.06,$w*0.09,$w*0.05,$w*0.05,$w*0.05,$w*0.1,$w*0.1,$w*0.15);
                    $pdf->SetFont('Arial', '', 6);
                    $titulo  = array('programa','PRODUCTO PROYECTO', 'ACT / AL / OBRA', 'SEC. FUNCIONAL', 'finalidad', 'LOCALIZACION', 'ESP. GASTOS', 'PIM', 'MODIFICACIONES', 'MODIFICACIONES', 'PIM', 'JUSTIFICACION');
                    $data = array();

                    $pdf->FancyTable($titulo,$data, $w);
                    foreach ($modificaciones['modificaciones'] as $value) {
                        $w1 = array($w*0.06,$w*0.06,$w*0.05,$w*0.06,$w*0.06,$w*0.045,$w*0.045,$w*0.05,$w*0.05,$w*0.05,$w*0.1,$w*0.1,$w*0.15);
                        $pdf->SetFont('Arial', '', 6);
                        $titulo1  = array('PIM', 'MODIFICACIONES', 'MODIFICACIONES', 'PIM', 'JUSTIFICACION');
                        $data1 = array();
                        dd($value);
                    }



                    return Response::make($pdf->Output(),200,$headers);*/
                    break;
                }
                case 'imprimir_proyectos':{
                    $modificaciones = $this->modificacionesToArrayForPPrint($anio, $modif, $fft, $opt);
                    $priorizacion = $this->priorizacionToArray($anio, $modif, $fft, $opt);
                    $fecha = Carbon::now();
                    $modificatoria = Modificatoria::find($modif);
                    $fuente=FuenteFinanciamiento::getFuenteFinanciamiento($anio,$fft);
                    $arr=[ 'APnoP'=>'ASIGNACIONES PRESUPUESTARIAS QUE NO RESULTAN EN PRODUCTOS', 'PP'=>'PROGRAMAS PRESUPUESTALES', 'all'=>'TODOS'];
                    //dd($modificaciones);
                    return view('proyectos.herramientas.modificar.detalle.imprimir_proyectos', [
                        'modificaciones'=>$modificaciones['modificaciones'],
                        'total'=>$modificaciones['total'],
                        'priorizaciones'=>$priorizacion,
                        'fecha'=>$fecha,
                        'modificatoria'=>$modificatoria,
                        'fuenteFinanciamiento'=>$fuente,
                        'tipo'=>$arr[$opt]
                    ]);
                    break;
                }
                case 'imprimir_general':{
                    $modificaciones = $this->modificacionesToArrayForPPrint($anio, $modif, $fft, $opt);
                    $priorizacion = $this->priorizacionToArray($anio, $modif, $fft, $opt);
                    $fecha = Carbon::now();
                    $modificatoria = Modificatoria::find($modif);
                    $fuente=FuenteFinanciamiento::getFuenteFinanciamiento($anio,$fft);
                    $arr=[ 'APnoP'=>'ASIGNACIONES PRESUPUESTARIAS QUE NO RESULTAN EN PRODUCTOS', 'PP'=>'PROGRAMAS PRESUPUESTALES', 'all'=>'TODOS'];
                    //dd($modificaciones);
                    return view('proyectos.herramientas.modificar.detalle.imprimir_general', [
                        'modificaciones'=>$modificaciones['modificaciones'],
                        'total'=>$modificaciones['total'],
                        'priorizaciones'=>$priorizacion,
                        'fecha'=>$fecha,
                        'modificatoria'=>$modificatoria,
                        'fuenteFinanciamiento'=>$fuente,
                        'tipo'=>$arr[$opt]
                    ]);
                    break;
                }
                default:{return response(['ok' => 0, 'msg' => 'Opcion no especificada']);break;}
            }
    }

    /**
     * Busca canenas funcionales que tengan pim o no
     *
     * @param  int  $anio
     * @param  int  $modif
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buscar($anio, Request $request)
    {
        if($request->listar){
            $cadenas1=Componente::table('proy_plan_componente')
                ->select([
                    'proy_plan_componente.id as componente_id',
                    'proy_plan_componente.comp_programa',
                    'siaf_wpresupuesto.fuente_financ as det_fuente_financiamiento',
                    'proy_proyecto.proy_nombre',
                    'proy_proyecto.proy_cod_siaf',
                    'proy_plan_componente.comp_nombre',
                    'siaf_wpresupuesto.especifica',
                    'siaf_wpresupuesto.descripcion',
                    'siaf_wpresupuesto.id_clasificador as det_id_clasif',
                    //'siaf_wpresupuesto.pia',
                    'siaf_wpresupuesto.pim',
                    'siaf_meta.sec_func'])
                ->leftJoin('proy_proyecto', 'proy_proyecto.proy_cod_siaf', '=', 'proy_plan_componente.comp_prod_proy')
                ->leftJoin('siaf_meta', function (JoinClause $join){
                    return $join
                        ->on('proy_plan_componente.comp_prod_proy',         '=','siaf_meta.act_proy')
                        ->on('proy_plan_componente.comp_act_al_obra',       '=','siaf_meta.componente')
                        ->on('proy_plan_componente.comp_funcion',           '=','siaf_meta.funcion')
                        ->on('proy_plan_componente.comp_meta',              '=','siaf_meta.meta')
                        ->on('proy_plan_componente.comp_division_funcional','=','siaf_meta.programa')
                        ->on('proy_plan_componente.comp_grupo_funcional',   '=','siaf_meta.sub_programa')
                        ->on('proy_plan_componente.comp_programa',          '=','siaf_meta.programa_ppto')
                        ->on('proy_plan_componente.comp_finalidad',          '=','siaf_meta.finalidad')
                        ->where('siaf_meta.ano_eje',                        '=',2018)//CORREGIR PARA QUE RECIBA VARIABLE Y NO CONSTANTE
                        ->where('siaf_meta.sec_ejec',                       '=',config('proyectos.unidad_ejecutora'));
                })
                ->leftJoin('siaf_wpresupuesto', function (JoinClause $join){
                    return $join
                        ->on('siaf_wpresupuesto.ano_eje',        '=','siaf_meta.ano_eje')
                        ->on('siaf_wpresupuesto.sec_ejec',       '=','siaf_meta.sec_ejec')
                        ->on('siaf_wpresupuesto.sec_func',       '=','siaf_meta.sec_func')
                        ->where('siaf_wpresupuesto.pim',         '<>',0);
                });
            //dd($cadenas1->toSql());
            return Datatables::of($cadenas1)
                ->editColumn('proy_nombre', function ($cadena) {
                    return sprintf('%s : %s <br><strong>%s</strong>',
                        $cadena->proy_cod_siaf, $cadena->proy_nombre, $cadena->comp_nombre);
                })
                ->editColumn('especifica', function ($cadena) {
                    return sprintf('%s - %s',
                        $cadena->especifica, $cadena->descripcion);
                })
                ->editColumn('pim', function ($cadena) {
                    return Money::toMoney($cadena->pim,'');
                })
                ->editColumn('comp_programa', function ($cadena) {
                return ($cadena->comp_programa=='9002')?'APnoP':'PP';
                })
                ->editColumn('sec_func', function ($cadena) {
                    return ($cadena->sec_func!='')?sprintf("%04s",$cadena->sec_func):'';
                })
                ->addColumn('action', function ($cadena) {
                    return sprintf('<a href="#" class="btn btn-xs btn-primary return" data-data="%s"><i class="glyphicon glyphicon-list"></i> Seleccionar</a>',e(json_encode($cadena)));
                })
                ->setRowClass(function ($cadena) {
                    $r='';
                    switch($cadena->especifica)
                    {
                        case null : $r='alert-default';break;
                        default: $r='alert-info';break;
                    }
                    return $r;
                })
                ->removeColumn('componente_id')
                ->removeColumn('det_id_clasif')
                ->removeColumn('descripcion')
                ->make(true);
            //return view('proyectos.herramientas.modificar.buscar.index',['anio'=>$anio]);
        }
        else
        {
            return view('proyectos.herramientas.modificar.buscar.index',['anio'=>$anio]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $anio
     * @param  int  $modif
     * @return \Illuminate\Http\Response
     */
    public function create($anio, $modif)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $anio
     * @param  int  $modif
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store($anio, $modif, $fft, $opt, Request $request)
    {
        if(!isset($request->option)) {
            $error  = false;
            foreach($request->det_id_clasif as $det_id_clasif)
            {
                if ($request->id == -1)
                    $detalle = new ModificatoriaDetalle();
                else
                    $detalle = ModificatoriaDetalle::find($request->id);

                $detalle->modificatoria_id = $request->modificatoria_id;
                $detalle->componente_id = $request->componente_id;
                $detalle->det_fuente_financiamiento = $request->det_fuente_financiamiento;
                $detalle->det_id_clasif = $det_id_clasif;
                $detalle->det_acumulado = ($request->det_acumulado > 0) ? $request->det_acumulado : 0;
                $detalle->det_pim = ($request->det_pim > 0) ? $request->det_pim : 0;
                $detalle->det_de = ($request->det_de > 0) ? $request->det_de : 0;
                $detalle->det_a = ($request->det_a > 0) ? $request->det_a : 0;
                $detalle->det_justificacion = $request->det_justificacion;
                $detalle->det_nuevo_pim = $request->det_nuevo_pim;
                try {
                    $componente = Componente::find($detalle->componente_id);
                    if (true) {
                        /*if(isset($request->updatePIM)&&$request->updatePIM){*/
                        $this->updatePim($anio, $fft, $detalle, $componente);
                    }
                    $detalle->save();
                    $option = ($componente->comp_programa == '9002') ? 'APnoP' : 'PP';
                } catch (QueryException $e) {
                    $error = true;
                }
            }
            if (!$error)
                return response(['ok' => 1, 'fft' => $detalle->det_fuente_financiamiento, 'opt' => $option, 'test' => $componente]);
            else
                return response(['ok' => 0, 'msg' => $e->errorInfo[2]]);
        }
        else
            switch ($request->option){
                case 1:{
                    $detalle = ModificatoriaDetalle::find($request->id);
                    $detalle->det_pim=$request->pim;
                    $detalle->det_de = $request->de;
                    $detalle->det_a = $request->a;
                    $detalle->det_nuevo_pim = $detalle->det_pim-$detalle->det_de+$detalle->det_a;
                    $detalle->det_justificacion = $request->justificacion;
                    try {
                        $componente=Componente::find($detalle->componente_id);
                        if(true){
                            /*if(isset($request->updatePIM)&&$request->updatePIM){*/
                            $this->updatePim($anio, $fft, $detalle, $componente);
                        }
                        $detalle->save();
                        return response(['ok' => 1]);
                    } catch (QueryException $e) {
                        return response(['ok' => 0, 'msg' => $e->errorInfo[2]]);
                    }
                    break;}
                default:{return response(['ok' => 0, 'msg' => 'Opcion no especificada']);break;}
            }

            //return response('hola');
    }
    private function updatePim($anio, $fft, $detalle, $componente){
        $where=[
            ['m_actual.sec_ejec', '=', config('proyectos.unidad_ejecutora')],
            ['cmp.id', '=', $detalle->componente_id],
            ['siaf_wpresupuesto.fuente_financ', '=', $fft],
            ['siaf_wpresupuesto.id_clasificador', '=', $detalle->det_id_clasif],
            ['m_actual.ano_eje', '=', $anio],
        ];
        $detalles = \DB::table('proy_plan_componente AS cmp')
            ->select([
                \DB::raw(
                    '(
                                SELECT
                                      Sum(g_acumulado.MONTO)
                                FROM
                                      siaf_meta AS m_acumulado
                                LEFT JOIN siaf_wgastos_resumen AS g_acumulado ON g_acumulado.ano_eje = m_acumulado.ano_eje
                                AND g_acumulado.sec_ejec = m_acumulado.sec_ejec
                                AND g_acumulado.sec_func = m_acumulado.sec_func
                                WHERE
                                cmp.comp_prod_proy = m_acumulado.act_proy
                                AND `m_actual`.`ano_eje` > m_acumulado.ano_eje
                                ) AS acumulado_proy'),
                \DB::raw(
                    '(SELECT
                                    Sum(g_acumulado.MONTO)
                                FROM
                                    siaf_meta AS m_acumulado
                                LEFT JOIN siaf_wgastos_resumen AS g_acumulado ON g_acumulado.ano_eje = m_acumulado.ano_eje
                                AND g_acumulado.sec_ejec = m_acumulado.sec_ejec
                                AND g_acumulado.sec_func = m_acumulado.sec_func
                                WHERE
                                m_acumulado.programa_ppto = cmp.comp_programa
                                AND cmp.comp_prod_proy = m_acumulado.act_proy
                                AND cmp.comp_act_al_obra = m_acumulado.componente
                                AND cmp.comp_funcion = m_acumulado.funcion
                                AND cmp.comp_division_funcional = m_acumulado.programa
                                AND cmp.comp_grupo_funcional = m_acumulado.sub_programa
                                /*AND cmp.comp_finalidad = m_acumulado.finalidad*/
                                AND cmp.comp_meta = m_acumulado.meta
                                AND `m_actual`.`ano_eje` > m_acumulado.ano_eje
                                ) AS acumulado_comp'),
                \DB::raw(
                    '(SELECT
                                    Sum(g_acumulado.MONTO)
                                FROM
                                    siaf_meta AS m_acumulado
                                LEFT JOIN siaf_wgastos_resumen AS g_acumulado ON g_acumulado.ano_eje = m_acumulado.ano_eje
                                AND g_acumulado.sec_ejec = m_acumulado.sec_ejec
                                AND g_acumulado.sec_func = m_acumulado.sec_func
                                WHERE
                                m_acumulado.programa_ppto = cmp.comp_programa
                                AND cmp.comp_prod_proy = m_acumulado.act_proy
                                AND cmp.comp_act_al_obra = m_acumulado.componente
                                AND cmp.comp_funcion = m_acumulado.funcion
                                AND cmp.comp_division_funcional = m_acumulado.programa
                                AND cmp.comp_grupo_funcional = m_acumulado.sub_programa
                                /*AND cmp.comp_finalidad = m_acumulado.finalidad*/
                                AND cmp.comp_meta = m_acumulado.meta
                                AND `m_actual`.`ano_eje` > m_acumulado.ano_eje
                                AND g_acumulado.id_clasificador = siaf_wpresupuesto.id_clasificador
                                ) AS acumulado_esp'),
                'siaf_wpresupuesto.monto_cert',
                'siaf_wpresupuesto.certs',
                \DB::raw('Sum(siaf_wpresupuesto.pim) as pim'),
                \DB::raw(
                    '(SELECT Sum(prs.pim)
                                    FROM siaf_wpresupuesto AS prs
                                    WHERE
                                    prs.ano_eje = `m_actual`.`ano_eje`
                                    AND prs.sec_ejec = `m_actual`.`sec_ejec`
                                    AND prs.sec_func = `m_actual`.`sec_func` ) AS pim_comp'),
                \DB::raw(
                    '(SELECT Sum(prs.pim)
                                FROM siaf_wpresupuesto AS prs
                                WHERE prs.ano_eje = `m_actual`.`ano_eje`
                                AND prs.sec_ejec = m_actual.sec_ejec
                                AND prs.act_proy = `cmp`.`comp_prod_proy` ) AS pim_proy'),
                \DB::raw(
                    '(SELECT Sum(prs.monto_cert)
                                FROM siaf_wpresupuesto AS prs
                                WHERE prs.ano_eje = `m_actual`.`ano_eje`
                                AND prs.sec_ejec = `m_actual`.`sec_ejec`
                                    AND prs.sec_func = `m_actual`.`sec_func` ) AS cert_comp'),
                \DB::raw(
                    '(SELECT Sum(prs.monto_cert) FROM siaf_wpresupuesto AS prs WHERE prs.ano_eje = `m_actual`.`ano_eje` AND prs.sec_ejec = `m_actual`.`sec_ejec` AND prs.act_proy = `cmp`.`comp_prod_proy` ) AS cert_proy')
            ])
            ->join('siaf_meta AS m_actual', function (JoinClause $join){
                return $join
                    ->on('m_actual.programa_ppto',  '=', 'cmp.comp_programa')
                    ->on('m_actual.act_proy',     '=', 'cmp.comp_prod_proy')
                    ->on('m_actual.componente',     '=', 'cmp.comp_act_al_obra')
                    ->on('m_actual.funcion',     '=', 'cmp.comp_funcion')
                    ->on('m_actual.programa',     '=', 'cmp.comp_division_funcional')
                    ->on('m_actual.sub_programa',     '=', 'cmp.comp_grupo_funcional')
                    ->on('m_actual.finalidad',     '=', 'cmp.comp_finalidad')
                    ->on('m_actual.meta',     '=', 'cmp.comp_meta');
            })
            ->join('siaf_wpresupuesto', function (JoinClause $join){
                return $join
                    ->on('siaf_wpresupuesto.ano_eje',  '=',   'm_actual.ano_eje')
                    ->on('siaf_wpresupuesto.sec_ejec', '=',   'm_actual.sec_ejec')
                    ->on('siaf_wpresupuesto.sec_func', '=',   'm_actual.sec_func');
            })
            ->where($where)
            ->get();
        $registro=$detalles[0];
        $detalle->det_pim =                 ($registro->pim>0)?$registro->pim:0;
        $detalle->det_pim_componente=       ($registro->pim_comp>0)?$registro->pim_comp:0;
        $detalle->det_pim_proy=             ($registro->pim_proy>0)?$registro->pim_proy:0;
        $detalle->det_nuevo_pim =           $detalle->det_pim+$detalle->det_a-$detalle->det_de;
        $detalle->det_acumulado=            ($registro->acumulado_esp>0)?$registro->acumulado_esp:0;
        $detalle->det_acumulado_comp=       ($registro->acumulado_comp>0)?$registro->acumulado_comp:0;
        $detalle->det_acumulado_proy=       ($registro->acumulado_proy>0)?$registro->acumulado_proy:0;
        $cadena = 'UPDATE proy_tools_modificatoria_det SET  det_acumulado_comp = '.$detalle->det_acumulado_comp.', det_pim_componente = '.$detalle->det_pim_componente;
        $cadena.= ' WHERE proy_tools_modificatoria_det.modificatoria_id = '.$detalle->modificatoria_id.' AND proy_tools_modificatoria_det.componente_id = '.$detalle->componente_id;
        DB::statement($cadena);
        $cadena = 'UPDATE proy_tools_modificatoria_det INNER JOIN proy_plan_componente ON proy_tools_modificatoria_det.componente_id = proy_plan_componente.id';
        $cadena .= ' SET  det_acumulado_proy = '.$detalle->det_acumulado_proy.', det_pim_proy = '.$detalle->det_pim_proy;
        $cadena.= ' WHERE proy_tools_modificatoria_det.modificatoria_id = '.$detalle->modificatoria_id.' AND proy_plan_componente.comp_prod_proy =  '.$componente->comp_prod_proy;
        DB::statement($cadena);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $anio
     * @param  int  $modif
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($anio, $modif, $fft, $opt, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $anio
     * @param  int  $modif
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($anio, $modif, $fft, $opt, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $anio
     * @param  int  $modif
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($anio, $modif, $fft, $opt, Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $anio
     * @param  int  $modif
     * @param  int  $id
     * @return Response
     */
    public function destroy($anio, $modif, $fft, $opt, $id)
    {
        try {
            ModificatoriaDetalle::destroy($id);
            return response(['ok'=>1]);
        } catch (QueryException $e) {
            return response(['ok' => 0, 'msg' => $e->errorInfo[2]]);
        }
    }
    private  function  modificacionesToArrayForPPrint($anio, $modif, $fft, $opt, $arreglo=[])
    {
        $where=[
            ['m.modif_anio', '=', $anio],
            ['m.id', '=', $modif],
            ['m_d.det_fuente_financiamiento', '=', $fft],
        ];
        if ($opt=='APnoP'){
            $where[]=['cmp.comp_programa', '=', '9002'];
        }
        else if ($opt=='all'){} else
        {
            $where[]=['cmp.comp_programa', '<>', '9002'];
        }
        $modificaciones=DB::table('proy_tools_modificatoria_det AS m_d')
            ->select([
            'cmp.comp_programa',
            'cmp.comp_prod_proy',
            'cmp.comp_act_al_obra',
            'cmp.comp_funcion',
            'cmp.comp_division_funcional',
            'cmp.comp_grupo_funcional',
            'm_actual.sec_func',
            'p.proy_pip_actualizado',
            'cmp.comp_finalidad',
            'p.proy_nombre',
            'p.proy_ejecucion_otras_ejecutoras',
            // 'm_actual.PROVINCIA',
            // 'm_actual.DISTRITO',
            'm_d.det_pim AS pim',
            'm_d.det_de',
            'm_d.det_a',
            'm_d.det_nuevo_pim',
            'm_d.det_justificacion',
            'm_d.det_acumulado_proy AS acumulado',
            DB::raw("(SELECT Sum(prs.pim) FROM siaf_wpresupuesto AS prs WHERE prs.ano_eje = m.modif_anio AND prs.sec_ejec = '".config('proyectos.unidad_ejecutora')."' AND prs.act_proy = cmp.comp_prod_proy ) AS pim_proy"),
            DB::raw("CONCAT(esp.tipo_transaccion,'.',esp.generica,'.',esp.subgenerica,'.',esp.subgenerica_det,'.',esp.especifica,'.',esp.especifica_det) as especifica")
        ])
            ->join('proy_plan_componente AS cmp',   'm_d.componente_id',    '=', 'cmp.id')
            ->join('proy_tools_modificatoria AS m', 'm_d.modificatoria_id', '=', 'm.id')
            ->join('proy_proyecto AS p',            'p.proy_cod_siaf',      '=', 'cmp.comp_prod_proy')
            ->join('siaf_especifica_det AS esp',function (JoinClause $join) {
                return $join
                    ->on('esp.ano_eje',     '=','m.modif_anio')
                    ->on('esp.id_clasificador',  '=','m_d.det_id_clasif');

            })
            ->leftJoin('siaf_meta AS m_actual', function (JoinClause $join){
                return $join
                    ->on('m_actual.ano_eje',        '=','m.modif_anio')
                    ->on('m_actual.programa_ppto',     '=','cmp.comp_programa')
                    ->on('m_actual.act_proy',       '=','cmp.comp_prod_proy')
                    ->on('m_actual.componente',     '=','cmp.comp_act_al_obra')
                    ->on('m_actual.funcion',        '=','cmp.comp_funcion')
                    ->on('m_actual.programa',       '=','cmp.comp_division_funcional')
                    ->on('m_actual.sub_programa',     '=','cmp.comp_grupo_funcional')
                    ->on('m_actual.finalidad',      '=','cmp.comp_finalidad')
                    ->on('m_actual.meta',           '=','cmp.comp_meta')
                    ->where('m_actual.sec_ejec',    '=', config('proyectos.unidad_ejecutora'));
            })
            ->leftJoin('siaf_wpresupuesto AS prs', function (JoinClause $join) {
                return $join
                    ->on('prs.ano_eje',        '=','m_actual.ano_eje')
                    ->on('prs.sec_ejec',       '=','m_actual.sec_ejec')
                    ->on('prs.sec_func',       '=','m_actual.sec_func')
                    ->on('prs.id_clasificador',     '=','m_d.det_id_clasif')
                    ->on('prs.fuente_financ',     '=','m_d.det_fuente_financiamiento');

            })->where($where);
        $i=1;
        $de=0;
        $a=0;
        foreach ($modificaciones->get() as $modificacion){
            $proy=$modificacion->comp_prod_proy;
            $de+=$modificacion->det_de;
            $a+=$modificacion->det_a;
            if(!isset($arreglo[$proy])) {
                $arreglo[$proy] = [];
                $arreglo[$proy]['d']['rows']    =1;
                $arreglo[$proy]['d']['nombre']  =$modificacion->proy_nombre;
                $arreglo[$proy]['d']['pim1']    =$modificacion->pim;
                $arreglo[$proy]['d']['de']      =$modificacion->det_de;
                $arreglo[$proy]['d']['a']       =$modificacion->det_a;
                $arreglo[$proy]['d']['pim']     =$arreglo[$proy]['d']['pim1']+($arreglo[$proy]['d']['a']-$arreglo[$proy]['d']['de']);
                $arreglo[$proy]['modif']        =$modificacion;
                $arreglo[$proy][$i++]=$modificacion;
            }else{
                $arreglo[$proy]['d']['rows']++;
                $arreglo[$proy]['d']['de']      +=$modificacion->det_de;
                $arreglo[$proy]['d']['a']       +=$modificacion->det_a;
                $arreglo[$proy]['d']['pim']     =$arreglo[$proy]['d']['pim1']+($arreglo[$proy]['d']['a']-$arreglo[$proy]['d']['de']);
                $arreglo[$proy][$i++]=$modificacion;
            }
        }
        return ['total'=>['de'=>$de,'a'=>$a], 'modificaciones'=>$arreglo];
    }
    private function modificacionesToArray($anio, $modif, $fft, $opt, $arreglo=[]){
        $total['de']=0;
        $total['a'] =0;
        $total['pim'] =0;
        $total['cert'] =0;
        $where=[
            ['m.modif_anio', '=', $anio],
            ['m.id', '=', $modif],
            ['det_fuente_financiamiento', '=', $fft],
        ];
        if ($opt=='APnoP'){
            $where[]=['cmp.comp_programa', '=', '9002'];
        }
        else if ($opt=='all'){} else
        {
            $where[]=['cmp.comp_programa', '<>', '9002'];
        }
        $detalles = ModificatoriaDetalle::select([
                'p.proy_nombre',
                'p.proy_ejecucion_otras_ejecutoras',
                'cmp.comp_nombre',
                \DB::raw('CONCAT(e_d.tipo_transaccion,\'.\',e_d.generica,\'.\',e_d.subgenerica,\'.\',e_d.subgenerica_det,\'.\',e_d.especifica,\'.\',e_d.especifica_det) AS especifica'),
                \DB::raw('(SELECT e.descripcion FROM siaf_especifica AS e WHERE e.tipo_transaccion = e_d.tipo_transaccion AND e.generica = e_d.generica AND e.subgenerica = e_d.subgenerica AND e.subgenerica_det = e_d.subgenerica_det AND e.especifica = e_d.especifica AND e.ano_eje = e_d.ano_eje) AS ESP'),
                'e_d.descripcion',
                'det_acumulado_proy AS acumulado',
                'det_acumulado_comp AS acumulado_comp',
                'det_acumulado AS acumulado_esp',
                'proy_tools_modificatoria_det.id',
                'm_actual.sec_func',
                'p.proy_pip_actualizado',
                'siaf_wpresupuesto.monto_dev',
                'siaf_wpresupuesto.monto_cert',
                'siaf_wpresupuesto.certs',
                'siaf_wpresupuesto.pim',
                'cmp.id as componente_id',
                'cmp.comp_prod_proy',
                'det_fuente_financiamiento',
                'det_id_clasif',
                'det_pim',
                'det_de',
                'det_a',
                'det_nuevo_pim',
                'det_justificacion',
                'det_pim_componente AS pim_comp',
                'det_pim_proy AS pim_proy',
                \DB::raw('(SELECT Sum(prs.monto_cert) FROM siaf_wpresupuesto AS prs WHERE prs.ano_eje = m_actual.ano_eje AND prs.sec_ejec = m_actual.sec_ejec AND prs.sec_func = m_actual.sec_func ) AS cert_comp'),
                \DB::raw('(SELECT Sum(prs.monto_cert) FROM siaf_wpresupuesto AS prs WHERE prs.ano_eje = m_actual.ano_eje AND prs.sec_ejec = m_actual.sec_ejec AND prs.act_proy = cmp.comp_prod_proy ) AS cert_proy')
            ])
            ->join('proy_tools_modificatoria AS m',     'modificatoria_id', '=', 'm.id')
            ->join('proy_plan_componente AS cmp',       'cmp.id',               '=', 'componente_id')
            ->join('proy_proyecto AS p',                'p.proy_cod_siaf',      '=', 'cmp.comp_prod_proy')
            ->join('siaf_especifica_det AS e_d', function (JoinClause $join){
                return $join
                    ->on('e_d.id_clasificador',  '=', 'det_id_clasif')
                    ->on('e_d.ano_eje',     '=', 'm.modif_anio');
            })
            /*->join('siaf_especifica AS e',function ($join) {
                $join->on('e.tipo_transaccion', '=', 'e_d.tipo_transaccion')
                    ->on('e.generica', '=', 'e_d.generica')
                    ->on('e.subgenerica', '=', 'e_d.subgenerica')
                    ->on('e.subgenerica_det', '=', 'e_d.subgenerica_det')
                    ->on('e.especifica', '=', 'e_d.especifica')
                    ->on('e.ano_eje', '=', 'e_d.ano_eje');
            })*/
            ->leftJoin('siaf_meta AS m_actual', function (JoinClause $join){
                return $join
                    ->on('m_actual.programa_ppto',  '=', 'cmp.comp_programa')
                    ->on('m_actual.act_proy',     '=', 'cmp.comp_prod_proy')
                    ->on('m_actual.componente',     '=', 'cmp.comp_act_al_obra')
                    ->on('m_actual.funcion',     '=', 'cmp.comp_funcion')
                    ->on('m_actual.programa',     '=', 'cmp.comp_division_funcional')
                    ->on('m_actual.sub_programa',     '=', 'cmp.comp_grupo_funcional')
                    ->on('m_actual.ano_eje',     '=', 'm.modif_anio')
                    ->on('m_actual.finalidad',     '=', 'cmp.comp_finalidad')
                    ->on('m_actual.meta',     '=', 'cmp.comp_meta');
            })
            ->leftJoin('siaf_wpresupuesto', function (JoinClause $join){
                return $join
                    ->on('siaf_wpresupuesto.ano_eje',  '=',   'm_actual.ano_eje')
                    ->on('siaf_wpresupuesto.sec_ejec', '=',   'm_actual.sec_ejec')
                    ->on('siaf_wpresupuesto.sec_func', '=',   'm_actual.sec_func')
                    ->on('siaf_wpresupuesto.fuente_financ', '=', 'det_fuente_financiamiento')
                    ->on('siaf_wpresupuesto.id_clasificador', '=', 'det_id_clasif');
            })
            ->where($where)
            ->orderBy('p.proy_nombre','ASC')
            ->orderBy('cmp.comp_nombre','ASC')
            ->orderBy('especifica','ASC');
        //dd($detalles->toSql());
        foreach ($detalles->get() as $detalle){
            $proy=$detalle->comp_prod_proy;
            $comp=$detalle->componente_id.'-';
            $esp=$detalle->det_id_clasif;
            $total['de']+=$detalle->det_de;
            $total['a']+=$detalle->det_a;
            $total['pim']+=$detalle->pim_proy;
            $total['cert']+=$detalle->cert_proy;
            /******SECUENCIA FUNCIONAL***/
            if(!isset($arreglo[$proy])) {
                $arreglo[$proy] = [];
                $arreglo[$proy]['rows']  =2;
                $arreglo[$proy]['nombre']  =$detalle->comp_prod_proy.' - '.$detalle->proy_nombre;
                $arreglo[$proy]['limite']=(float)$detalle->proy_pip_actualizado;
                $arreglo[$proy]['otras_ejecutoras']=(float)$detalle->proy_ejecucion_otras_ejecutoras;
                $arreglo[$proy]['acumulado']=(float)$detalle->acumulado;
                $arreglo[$proy]['certificado']=(float)$detalle->cert_proy;
                $arreglo[$proy]['pim1']    =(float)$detalle->pim_proy;
                $arreglo[$proy]['de']      =$detalle->det_de;
                $arreglo[$proy]['a']       =$detalle->det_a;
                $arreglo[$proy]['pim']     =$arreglo[$proy]['pim1']+($arreglo[$proy]['a']-$arreglo[$proy]['de']);
                $arreglo[$proy]['contenido']=[];
            }else{

                $arreglo[$proy]['rows']++;
                $arreglo[$proy]['de']      +=$detalle->det_de;
                $arreglo[$proy]['a']       +=$detalle->det_a;
                $arreglo[$proy]['pim']     =$arreglo[$proy]['pim1']+($arreglo[$proy]['a']-$arreglo[$proy]['de']);
            }
            /*******especifica****************/
            if(!isset($arreglo[$proy]['contenido'][$comp])){
                $arreglo[$proy]['rows']++;
                $arreglo[$proy]['contenido'][$comp] = [
                    'sec_func'      =>  (($detalle->sec_func>0)?sprintf("%04s",$detalle->sec_func):null),
                    'acumulado'     =>  (float) $detalle->acumulado_comp,
                    'certificado'   =>  (float) $detalle->cert_comp,
                    'pim1'          =>  (float) $detalle->pim_comp,
                    'de'            =>  (float) $detalle->det_de,
                    'a'             =>  (float) $detalle->det_a,
                    'pim'           =>  (float) $detalle->pim_comp+($detalle->det_a-$detalle->det_de),
                    'id'            =>  -1,
                    'componente_id' =>  $detalle->componente_id,
                    'comp_nombre'   =>  $detalle->comp_nombre
                ];
            }else{
                $arreglo[$proy]['contenido'][$comp]['de']   +=$detalle->det_de;
                $arreglo[$proy]['contenido'][$comp]['a']    +=$detalle->det_a;
                $arreglo[$proy]['contenido'][$comp]['pim']  =$arreglo[$proy]['contenido'][$comp]['pim1']+($arreglo[$proy]['contenido'][$comp]['a']-$arreglo[$proy]['contenido'][$comp]['de']);
            }
            /************FUENTE DE FINANCIAMIENTO*********/
            if(!isset($arreglo[$proy]['contenido'][$comp.$esp])){
                $conv = array("COSTO DE CONSTRUCCION POR " => "",);
                $arreglo[$proy]['contenido'][$comp.$esp] = [
                    'id'            =>  $detalle->id,
                    'acumulado'     =>  (float) $detalle->acumulado_esp,
                    'certificado'   =>  (float) $detalle->monto_cert,
                    'certificados'  =>  $detalle->certs,
                    'justificacion' =>  $detalle->det_justificacion,
                    'pim1'          =>  (float) $detalle->det_pim,
                    'pim2'          =>  (float) $detalle->pim,
                    //'alert'         =>  ($detalle->det_pim==$detalle->pim)?(($detalle->det_pim<$detalle->monto_cert)?'danger':'info'):'warning',
                    'de'            =>  (float) $detalle->det_de,
                    'a'             =>  (float) $detalle->det_a,
                    'pim'           =>  (float) $detalle->det_pim+($detalle->det_a-$detalle->det_de)
                ];
            }
        }
        return ['proyectos'=>$arreglo,'total'=>$total];
    }
    private function priorizacionToArray($anio, $modif, $fft, $opt, $arreglo=[]){
        $where=[
            ['m.modif_anio', '=', $anio],
            ['m.id', '=', $modif],
            ['m_d.det_fuente_financiamiento', '=', $fft],
        ];
        if ($opt=='APnoP'){
            $where[]=['cmp.comp_programa', '=', '9002'];
        }
        else if ($opt=='all'){} else
        {
            $where[]=['cmp.comp_programa', '<>', '9002'];
        }
        $detalles = \DB::table('proy_tools_modificatoria_det AS m_d')
            ->select([
                \DB::raw('CONCAT(e_d.tipo_transaccion,\'.\',e_d.generica,\'.\',e_d.subgenerica,\'.\',e_d.subgenerica_det,\'.\',e_d.especifica,\'.\',e_d.especifica_det) AS especifica'),
                \DB::raw('Sum(m_d.det_a) as monto')
            ])
            ->join('proy_tools_modificatoria AS m',     'm_d.modificatoria_id', '=', 'm.id')
            ->join('proy_plan_componente AS cmp',       'cmp.id',               '=', 'm_d.componente_id')
            ->join('siaf_especifica_det AS e_d', function (JoinClause $join){
                return $join
                    ->on('e_d.id_clasificador',  '=', 'm_d.det_id_clasif')
                    ->on('e_d.ano_eje',     '=', 'm.modif_anio');
            })
            ->where($where)
            ->groupBy('e_d.tipo_transaccion')
            ->groupBy('e_d.generica')
            ->groupBy('e_d.subgenerica')
            ->groupBy('e_d.subgenerica_det')
            ->groupBy('e_d.especifica')
            ->groupBy('e_d.especifica_det')
            ->orderBy('e_d.tipo_transaccion','ASC')
            ->orderBy('e_d.generica','ASC')
            ->orderBy('e_d.subgenerica','ASC')
            ->orderBy('e_d.subgenerica_det','ASC')
            ->orderBy('e_d.especifica','ASC')
            ->orderBy('e_d.especifica_det','ASC');
        //dd($detalles->toSql());

        return $detalles->get();
    }
}
