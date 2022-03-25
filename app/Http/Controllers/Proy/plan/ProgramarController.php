<?php

namespace App\Http\Controllers\Proy\plan;

use App\_clases\proyectos\analitico\Analitico;
use App\_clases\proyectos\plan\cadena_funcional\Componente;
use App\_clases\proyectos\plan\Plan;
use App\_clases\proyectos\plan\Programar;
use App\_clases\proyectos\plan\Version;
use App\_clases\proyectos\Proyecto;
use App\_clases\proyectos\TablaPDFF;
use App\_clases\siaf\Especifica;
use App\_clases\siaf\FuenteFinanciamiento;
use App\_clases\siaf\reportes\Presupuesto;
use App\_clases\siaf\SiafMeta;
use App\_clases\siaf\SiafUnidadDeMedida;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Query\JoinClause;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ProgramarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return  Plan::where('plan_proyecto', '=', $request->act_proy)
                        ->where('plan_anio', '=', $request->anio )
                        ->where('version_id', '=', $request->version)
                        ->get();
/*
        $anio=$request->anio;
        $proy=$request->proy;
        $version=$request->version;
        $fftt=$request->fftt;

        $proyecto = Proyecto::find($proy);
        //$anios = [2017, 2018, 2019];
        for ($i=2017;$i<=Carbon::now()->year+2;$i++)
        {
            $anios[]=$i;
        }
        if ($anio == 'null') {
            $anio=Carbon::now()->year;
            if (!in_array ($anio,$anios))
                $anio=last($anios);
        }
        $show_all=(isset($request->show_all)&&$request->show_all=='true')?true:false;
        $show_all=(!isset($request->show_all))?true:$show_all;
        if (!isset($request->option)) {
            return  Plan::where('plan_proyecto', '=', $request->act_proy)->where('plan_anio', '=', $request->anio )->where('version_id', '=', $request->version)->get();
        } else {
            switch ($request->option) {
                case 'iframe': {
                    return view('proyectos.plan.programar.index', [
                        'anio' => $anio,
                        'proyecto' => $proyecto,
                        'componentes' => Componente::getComponentesToSelect($proyecto->proy_cod_siaf),
                        'espeficicas' => Especifica::getEspecificasToSelectforObra(),
                        'versiones'=>Version::getVersionesToSelect($proyecto->proy_cod_siaf, $anio),
                        'fuentes'=>Proyecto::GetFuentesFinanciamientoEnAnio($proyecto->proy_cod_siaf, $anio),
                        'selectedAnio' => $anio,
                        'anios' => $anios,
                        'curr_version' => $version,
                        'curr_fftt' => $fftt,
                        'iframe'=>true,
                        'show_all'=>$show_all
                    ]);

                    break;
                }
                case 'print': {

                    //dd($anio);
                    $v_analitico= (new \App\_clases\proyectos\analitico\Version)->select(DB::raw('Max(id) as version'))->where('vers_proyecto', '=', $proyecto->proy_cod_siaf)->get()[0];
                    list($ejecucion, $analitico) = Proyecto::GetEjecucionAcumuladaAnio($proyecto->proy_cod_siaf, $anio, $v_analitico->version);
                    $especifias=Especifica::getEspecificasToSelect();
                    $componentes=Componente::getComponentesForShow();
                    $presupuesto = ($fftt=='all')?Presupuesto::getPresupuestoForProy($anio, $proyecto->proy_cod_siaf):Presupuesto::getPresupuestoForProyFftt($anio, $proyecto->proy_cod_siaf,$fftt);
                    $fuente=FuenteFinanciamiento::getFuenteFinanciamientoToSelect($anio);
                    $fuente = isset($fuente[$fftt])?$fuente[$fftt]:null;
                    $vers= (new \App\_clases\proyectos\plan\Version)->find($version);
                    $where=[['proy_plan_proyecto', '=', $proyecto->proy_cod_siaf],['proy_plan_anio', '=', $anio],['version_id', '=', $version]];
                    if ($fftt!='all')
                        $where[]=['proy_plan_fftt','=',$fftt];
                    $temp = (new \App\_clases\proyectos\plan\Programar)->select('proy_plan_compl_id as comp', 'proy_plan_insu_id as insu', 'proy_plan_monto as monto', 'proy_plan_mes.proy_plan_mes as mes')
                        ->where($where);
                    $prg=['d'=>0];
                    foreach ($temp->get() as $prog){

                        if (!isset($prg[$prog->comp]))
                            $prg[$prog->comp] = ['d' => 0];
                        if (!isset($prg[$prog->comp][$prog->insu]))
                            $prg[$prog->comp][$prog->insu] = ['d' => 0];
                        if (!isset($prg[$prog->comp][$prog->insu][($prog->mes - 1) % 12]))
                            $prg[$prog->comp][$prog->insu][($prog->mes - 1) % 12]=0;
                        if ($prog->insu!='fisico') {
                            $prg['d'] += $prog->monto;
                            $prg[$prog->comp]['d'] += $prog->monto;
                            $prg[$prog->comp][$prog->insu]['d'] += $prog->monto;
                        }
                        $prg[$prog->comp][$prog->insu][($prog->mes - 1) % 12] += $prog->monto;
                    }

                    $headers = ['Content-Type' => 'application/pdf'];

                    $pdf = new tablaPDFF('L','mm','A3');
                    if ($vers->id==1)
                        $pdf->SetTitle('Linea de tiempo BORRADOR');
                    else
                        $pdf->SetTitle('Linea de tiempo version '.$vers->vers_version.' '.$vers->vers_fecha);
                    $pdf->setHeader( $proyecto, $vers, User::find($vers->vers_responzable),$fuente );
                    $pdf->SetMargins((2*$pdf->cm),50,(2.5*$pdf->cm));
                    $pdf->SetAutoPageBreak(false);
                    $pdf->AddPage();
                    // Títulos de las columnas
                    $header = array("\nCOMPONENTE\n", "\nESPECIFICA\n", "\nCOSTO\n", "\nACUM\n", "\nPIM\n", "\nENE\n", "\nFEB\n", "\nMAR\n", "\nABR\n", "\nMAY\n",
                        "\nJUN\n", "\nJUL\n", "\nAGO\n", "\nSET\n", "\nOCT\n", "\nNOV\n", "\nDIC\n", "\nSALDO\nPIP", "\nTOTAL\n2018", "\nREQUERIDO\n2018");


                    $pdf->LineaDeTiempo($header,$prg, $especifias,
                        $componentes,$ejecucion, $analitico,
                        $presupuesto);


                    return Response::make($pdf->Output(),200,$headers);
                    break;
                }

                case 'print_modif': {

                    //dd($anio);
                    $v_analitico= (new \App\_clases\proyectos\analitico\Version)->select(DB::raw('IFNULL(Max(id),1) as version'))->where('vers_proyecto', '=', $proyecto->proy_cod_siaf)->get()[0];
                    //dd($v_analitico->version);
                    list($ejecucion, $analitico) = Proyecto::GetEjecucionAcumuladaAnio($proyecto->proy_cod_siaf, $anio, $v_analitico->version);
                    $especifias=Especifica::getEspecificasToSelect();
                    $componentes=Componente::getComponentesForShow();
                    $presupuesto = ($fftt=='all')?Presupuesto::getPresupuestoForProy($anio, $proyecto->proy_cod_siaf):Presupuesto::getPresupuestoForProyFftt($anio, $proyecto->proy_cod_siaf,$fftt);
                    $fuente=FuenteFinanciamiento::getFuenteFinanciamientoToSelect($anio);
                    $fuente = isset($fuente[$fftt])?$fuente[$fftt]:null;
                    $vers= (new \App\_clases\proyectos\plan\Version)->find($version);
                    $where=[['proy_plan_proyecto', '=', $proyecto->proy_cod_siaf],['proy_plan_anio', '=', $anio],['version_id', '=', $version]];
                    if ($fftt!='all')
                        $where[]=['proy_plan_fftt','=',$fftt];
                    $temp = (new \App\_clases\proyectos\plan\Programar)->select('proy_plan_compl_id as comp', 'proy_plan_insu_id as insu', 'proy_plan_monto as monto', 'proy_plan_mes.proy_plan_mes as mes')
                        ->where($where);
                    $prg=['d'=>0];
                    foreach ($temp->get() as $prog){

                        if (!isset($prg[$prog->comp]))
                            $prg[$prog->comp] = ['d' => 0];
                        if (!isset($prg[$prog->comp][$prog->insu]))
                            $prg[$prog->comp][$prog->insu] = ['d' => 0];
                        if (!isset($prg[$prog->comp][$prog->insu][($prog->mes - 1) % 12]))
                            $prg[$prog->comp][$prog->insu][($prog->mes - 1) % 12]=0;
                        if ($prog->insu!='fisico') {
                            $prg['d'] += $prog->monto;
                            $prg[$prog->comp]['d'] += $prog->monto;
                            $prg[$prog->comp][$prog->insu]['d'] += $prog->monto;
                        }
                        $prg[$prog->comp][$prog->insu][($prog->mes - 1) % 12] += $prog->monto;
                    }

                    $headers = ['Content-Type' => 'application/pdf'];

                    $pdf = new tablaPDFF('L','mm','A3');
                    if ($vers->id==1)
                        $pdf->SetTitle('Linea de tiempo BORRADOR');
                    else
                        $pdf->SetTitle('Linea de tiempo version '.$vers->vers_version.' '.$vers->vers_fecha);
                    $pdf->setHeader( $proyecto, $vers, User::find($vers->vers_responzable),$fuente, 'MD' );
                    $pdf->SetMargins((2*$pdf->cm),50,(2.5*$pdf->cm));
                    $pdf->SetAutoPageBreak(false);
                    $pdf->AddPage();
                    // Títulos de las columnas
                    $header = array("\nCOMPONENTE\n", "\nESPECIFICA\n", "\nCOSTO\n", "\nACUM\n", "\nPIM\n",
                        "\nDE\n", "\nA\n", "\nNUEVO\nPIM", "\nJUSTIFICACIÓN\n");


                    $pdf->Modificatoria($header,$prg, $especifias,
                        $componentes,$ejecucion, $analitico,
                        $presupuesto);

                    return Response::make($pdf->Output(),200,$headers);
                    break;
                }
            }
        }*/
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

    }

    public function savePlan(Request $request)
    {
        $program = ($request->id != -1)?Plan::find($request->id):new Plan();
        if ($request->id == -1){
            $program->plan_comp_id      = $request->plan_comp_id;
            $program->plan_fftt         = $request->plan_fftt;
            $program->plan_id_clasifi   = $request->plan_id_clasifi;
            $program->plan_anio         = $request->plan_anio;
            $program->version_id        = $request->version_id;
            $program->plan_proyecto     = $request->plan_proyecto;
        }
        $program->plan_m1 = $request->plan_m1;
        $program->plan_m2 = $request->plan_m2;
        $program->plan_m3 = $request->plan_m3;
        $program->plan_m4 = $request->plan_m4;
        $program->plan_m5 = $request->plan_m5;
        $program->plan_m6 = $request->plan_m6;
        $program->plan_m7 = $request->plan_m7;
        $program->plan_m8 = $request->plan_m8;
        $program->plan_m9 = $request->plan_m9;
        $program->plan_m10 = $request->plan_m10;
        $program->plan_m11 = $request->plan_m11;
        $program->plan_m12 = $request->plan_m12;
        $program->save();
        return $program;

    }
    
    public function saveVersion(Request $request)
    {
        
            $max_version = Version::select(DB::raw('max(vers_version) as version'))
                ->where('vers_proyecto', '=', $request->vers_proyecto)
                ->Where('vers_anio', '=', $request->vers_anio)
                ->get()[0];

            $version                            = new Version();
            $version->vers_proyecto             = $request->vers_proyecto;
            $version->vers_version              = (($max_version->version>0)?$max_version->version:0)+1;
            $version->vers_anio                 = $request->vers_anio;
            $version->vers_responzable          = \Auth::id();
            $version->vers_cargo                = $request->vers_cargo;
            $version->vers_observacion          = $request->vers_observacion;
            $version->save();
            $this->newPlan($request->vers_proyecto, $request->vers_anio, $version->id);
            return $version;
    }

    public function newPlan($proy, $anio, $id_version)
    {
        $pro = Plan::select('plan_comp_id',
                                    'plan_fftt',
                                    'plan_id_clasifi',
                                    'plan_anio',
                                    'plan_proyecto',
                                    'plan_m1',
                                    'plan_m2',
                                    'plan_m3',
                                    'plan_m4',
                                    'plan_m5',
                                    'plan_m6',
                                    'plan_m7',
                                    'plan_m8',
                                    'plan_m9',
                                    'plan_m10',
                                    'plan_m11',
                                    'plan_m12')
                            ->where('plan_proyecto','=',$proy)
                            ->where('plan_anio','=',$anio)
                            ->where('version_id','=',1)
                            ->get();
        foreach($pro as $po){
            $newPlan                        = new Plan();
            $newPlan->plan_comp_id          = $po->plan_comp_id;
            $newPlan->plan_fftt             = $po->plan_fftt;
            $newPlan->plan_id_clasifi       = $po->plan_id_clasifi;
            $newPlan->plan_anio             = $po->plan_anio;
            $newPlan->version_id            = $id_version;
            $newPlan->plan_proyecto         = $po->plan_proyecto;
            $newPlan->plan_m1               = $po->plan_m1;
            $newPlan->plan_m2               = $po->plan_m2;
            $newPlan->plan_m3               = $po->plan_m3;
            $newPlan->plan_m4               = $po->plan_m4;
            $newPlan->plan_m5               = $po->plan_m5;
            $newPlan->plan_m6               = $po->plan_m6;
            $newPlan->plan_m7               = $po->plan_m7;
            $newPlan->plan_m8               = $po->plan_m8;
            $newPlan->plan_m9               = $po->plan_m9;
            $newPlan->plan_m10              = $po->plan_m10;
            $newPlan->plan_m11              = $po->plan_m11;
            $newPlan->plan_m12              = $po->plan_m12;
            $newPlan->save();
        }
    }

    public function SaveProgramarFisico(Request $request)
    {
        for ($i=0; $i < count($request->id); $i++) {
            $program = Programar::find($request->id[$i]);
            $program->proy_plan_monto = $request->monto[$i];
            $program->proy_plan_saldo = $request->saldo[$i];
            $program->save();
        }
        return ['ok'=>'true'];
    }
    

    public function listarVersiones(Request $request)
    {
        return Version::where('vers_proyecto', '=', $request->act_proy)
                        ->where('vers_anio', '=', $request->anio)
                        ->get();

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
