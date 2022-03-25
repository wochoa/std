<?php

namespace App\Http\Controllers\Proy;

use App\Dependencia;
use App\_clases\proyectos\ObraEstado;
use App\_clases\proyectos\plan\cadena_funcional\Componente;
use App\_clases\proyectos\Proyecto;
use App\_clases\siaf\Especifica;
use App\_clases\siaf\reportes\Certificado;
use App\_clases\siaf\reportes\Compromiso;
use App\_clases\siaf\reportes\Gasto;
use App\_clases\siaf\reportes\Presupuesto;
use App\_clases\utilitarios\Cadena;
use Carbon\Carbon;
use DataTables;
use Excel;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Fpdf;
use Money;
use Response;

use App\_clases\proyectos\ProyectosPDFF;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use phpDocumentor\Reflection\Types\Object_;
use Validator;
use App\Exports\GastosProjectExport;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $anioActual = '';

    public function __construct()
    {

        $this->anioActual = Carbon::now()->year;
    }

    public function index(Request $request)
    {
        // if (!isset($request->option)) {
        //     return view('proyectos');
        // } else
        //     switch ($request->option) {
        //         case 'analitico':
        //         {
        //             return view('proyectos.analitico.analitico');
        //             //,['versiones'=>\App\_clases\proyectos\analitico\Version::getVersionesToSelect($proyecto->proy_cod_siaf, $anio)]
        //             break;
        //         }
        //         case 'datatable':
        //         {
        //             $where = [];
        //             if ($request->proy_cod_siaf != null)
        //                 $where[] = ['proy_cod_siaf', '=', $request->proy_cod_siaf];
        //             if ($request->proy_nombre != null)
        //                 $where[] = ['proy_nombre', 'LIKE', "%$request->proy_nombre%"];
        //
        //             return Proyecto::select('idproy_proyecto', 'proy_nombre', 'proy_cod_siaf', 'proy_cod_snip')
        //                 ->where($where)->paginate(15);
        //             break;
        //         }
        //         case 'reporte':
        //         {
        //             if (isset($request->anio))
        //                 $anio = $request->anio;
        //             else
        //                 $anio = Carbon::now()->year;
        //
        //             $listado        = Proyecto::getListado($request->rep, $anio);
        //             $totalFuncion   = Proyecto::groupFuncionForReporte($listado);
        //             $totalProvincia = Proyecto::groupProvinciaForReporte($listado);
        //             $total          = Proyecto::groupTotalForReporte($listado);
        //             $anios          = [];
        //             for ($i = 2015; $i <= Carbon::now()->year; $i++) {
        //                 $anios[$i] = $i;
        //             }
        //             //dd($totalFuncion);
        //             //dd($listado);
        //             return view('proyectos.proyecto.reporte', [
        //                 'listado'        => $listado,
        //                 'totalFuncion'   => $totalFuncion,
        //                 'totalProvincia' => $totalProvincia,
        //                 'total'          => $total,
        //                 'anios'          => $anios,
        //                 'anio'           => $anio,
        //                 'rep'            => (isset($request->rep)) ? $request->rep : 'terminado',
        //             ]);
        //             break;
        //         }
        //         default:
        //         {
        //             return response(['ok' => 0, 'msg' => 'Opcion no especificada']);
        //             break;
        //         }
        //     }
    }

    public function ReporteSiaf(Request $request)
    {
        if (!isset($request->anio)) {
            return redirect()->route('proyectos.reporte.siaf', ['anio' => 2018]);
        }
        $anio = $request->anio;
        if (!isset($request->option)) {
            return view('proyectos.reporteSiaf.index', [
                'anio'    => $anio,
                'anios'   => [2017, 2018],
                'resumen' => [
                    'pim'  => ['class' => 'panel-primary', 'titulo' => 'P.I.M.'],
                    'cert' => ['class' => 'panel-green', 'titulo' => 'Cert.', 'color' => 'success'],
                    'comp' => ['class' => 'panel-yellow', 'titulo' => 'Comp..', 'color' => 'warning'],
                    'dev'  => ['class' => 'panel-red', 'titulo' => 'Dev.', 'color' => 'danger'],
                ],
            ]);
        } else
            switch ($request->option) {
                case 'seguimiento_dias':
                {
                    return json_encode($this->informacionDiaria($anio));
                    break;
                }
                case 'prog_vs_ejecutado':
                {
                    $oficina = $request->oficina;
                    $obras   = $request->obras;
                    if (isset($request->diario) && $request->diario == 'true')
                        $reporteDiario = $this->ejecutadoVsProgramadoDiario($anio, $oficina, $obras);
                    else
                        $reporteDiario = $this->ejecutadoVsProgramadoMensual($anio, $oficina, $obras);
                    $fecha['reporte'] = $reporteDiario;
                    return response($reporteDiario);
                    break;
                }
                case 'listado':
                {

                    //$anio=$request->anio;
                    $oficina   = $request->oficina;
                    $oficinas  = [
                        0 => 'GRI%',
                        1 => 'GRI/OBRAS',
                        2 => 'GRI/ESTUDIO',
                        3 => 'GRI/LIQUIDACION',
                    ];
                    $proyectos = (new Proyecto)->select(
                        [
                            'proy_proyecto.proy_nombre',
                            'proy_cod_siaf',
                        ])
                        ->join('proy_proyecto_asignacion AS g', 'g.asig_act_proy', '=', 'proy_proyecto.proy_cod_siaf')
                        ->where('g.asig_anio', '=', $anio)
                        ->where('g.asig_oficina', 'LIKE', $oficinas[$oficina]);

                    return DataTables::of($proyectos)
                        ->addColumn('action', function ($proyecto) {
                            return sprintf('<a href="#" class="btn btn-xs btn-primary return" data-data="%  s"><i class="glyphicon glyphicon-record"></i> Seleccionar</a>',
                                e(json_encode($proyecto)));;
                        })
                        ->editColumn('proy_nombre', function ($cadena) {
                            return sprintf('<div>%s - %s</div>',
                                $cadena->proy_cod_siaf, $cadena->proy_nombre);
                        })
                        ->make(true);
                    break;
                }
                case 'alternar':
                {

                    //$anio=$request->anio;
                    $oficina   = $request->oficina;
                    $oficinas  = [
                        0 => 'GRI%',
                        1 => 'GRI/OBRAS',
                        2 => 'GRI/ESTUDIO',
                        3 => 'GRI/LIQUIDACION',
                    ];
                    $proyectos = (new Proyecto)->select(
                        [
                            'proy_proyecto.proy_nombre',
                            'proy_cod_siaf',
                        ])
                        ->join('proy_proyecto_asignacion AS g', 'g.asig_act_proy', '=', 'proy_proyecto.proy_cod_siaf')
                        ->where('g.asig_anio', '=', $anio)
                        ->where('g.asig_oficina', 'LIKE', $oficinas[$oficina]);

                    return json_encode($proyectos);
                    break;
                }
                case 'general':
                {
                    $fechas        = $this->getFechasReporte();
                    $oficina       = $request->oficina;
                    $obra          = $request->obras;
                    $reporteDiario = $this->informacionDiaria($anio, $oficina, $obra, $fechas);
                    foreach ($fechas as $idFecha => $fecha) {
                        foreach ($this->getPresupuesto($anio, $oficina, $obra) as $pres) {
                            $fechas[$idFecha]['presupuesto'] += $pres->pim;
                        }
                        $fechas[$idFecha]['presupuesto'] = round($fechas[$idFecha]['presupuesto'], 2);
                        foreach ($this->getCertificado($anio, $oficina, $obra) as $pres) {
                            if ($pres->FECHA <= $fecha['date'])
                                $fechas[$idFecha]['certificado'] += $pres->MONTO;
                        }
                        $fechas[$idFecha]['certificado'] = round($fechas[$idFecha]['certificado'], 2);
                        foreach ($this->getComprometido($anio, $oficina, $obra) as $pres) {
                            if ($pres->FECHA_DOC <= $fecha['date'])
                                $fechas[$idFecha]['comprometido'] += $pres->MONTO;
                        }
                        $fechas[$idFecha]['comprometido'] = round($fechas[$idFecha]['comprometido'], 2);
                        foreach ($this->getDevengado($anio, $oficina, $obra) as $pres) {
                            if ($pres->MEJOR_FECH <= $fecha['date'])
                                $fechas[$idFecha]['devengado'] += $pres->MONTO;
                        }
                        $fechas[$idFecha]['devengado'] = round($fechas[$idFecha]['devengado'], 2);
                    }
                    $fechas['reportediario'] = $reporteDiario;
                    return response($fechas);
                    break;
                }
            }
    }

    public function create()
    {
        return view('proyectos');
    }

    public function obtenerProyectos()
    {
        return Proyecto::getProyectos();
    }

    public static function ProyectosHash()
    {
        return md5(utf8_decode(json_encode(Proyecto::getProyectos(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function ubigeo()
    {
        return DB::table('ubigeo')->get();
    }

    public static function ubigeoHash()
    {
        return Cadena::getHash(DB::table('ubigeo')->get());
    }

    public function estados()
    {
        return ObraEstado::select(['id', 'descripcion'])->orderBy('id','asc')->get();
    }

    public static function estadosHash()
    {
        return md5(utf8_decode(json_encode(ObraEstado::select(['id', 'descripcion'])->orderBy('id','asc')->get(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function oficinas()
    {
        return Dependencia::getOficinas();
    }

    public static function oficinasHash()
    {
        return md5(utf8_decode(json_encode(Dependencia::getOficinas(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)));
    }

    public function usuarios()
    {
        return DB::table('admin')->select([
            'id as id_admin',
            DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
        ])->get();
    }

    public function getUser()
    {
        $user        = Auth::user();
        $permissions = DB::table('role_user')
            ->select(['permissions.slug'])
            ->join('permission_role', 'permission_role.role_id', '=','role_user.role_id')
            ->join('permissions', 'permission_role.permission_id', '=','permissions.id')
            ->where('role_user.user_id', '=', $user->id)
            ->groupBy('slug')
            ->get();
        return json_encode([
            'id'          => $user->id,
            'depe_id'     => $user->depe_id,
            'permissions' => $permissions,
            'roles'       => $user->roles,
        ]);
    }

    public function inviertepe(Request $request)
    {

        $codigo    = $request->codigo;
        $json_file = file_get_contents('http://ofi5.mef.gob.pe/ssi/wsSosem.asmx/ListarInfoSnip?flagSnip=false&codigo=' . $codigo);
        $xml       = simplexml_load_string($json_file);

        return $xml;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function checkCodSnip(Request $request)
    {
        $where = [];
        if ($request->value != null && $request->atributo != null)
            $where[] = ($request->atributo == 'proy_cod_snip') ? [
                'proy_cod_snip',
                '=',
                $request->value,
            ] : ['proy_cod_siaf', '=', $request->value];

        $codSnip = Proyecto::where($where)->where('idproy_proyecto', '<>', $request->idproy_proyecto)->get();
        if (count($codSnip))
            return response()->json([
                'valid' => false,
                'data'  => [
                    'message' => 'Codigo SNIP ya existe!',
                ],
            ], 200);
        else
            return response()->json([
                'valid' => true,
                'data'  => [
                    'message' => 'Codigo SNIP disponible!',
                ],
            ], 200);
    }

    public function store(Request $request)
    {

        $proyecto                                     = ($request->idproy_proyecto == null) ? new Proyecto() : Proyecto::find($request->idproy_proyecto);
        $proyecto->proy_nombre                        = $request->proy_nombre;
        $proyecto->proy_cod_snip                      = $request->proy_cod_snip;
        $proyecto->proy_cod_siaf                      = $request->proy_cod_siaf;
        $proyecto->funcion_id                         = $request->funcion_id;
        $proyecto->proy_fte_fto                       = $request->proy_fte_fto;
        $proyecto->proy_beneficiarios                 = $request->proy_beneficiarios;
        $proyecto->ubigeo_id                          = $request->ubigeo_id;
        $proyecto->proy_localidad                     = $request->proy_localidad;
        $proyecto->proy_perfil_viable                 = $request->proy_perfil_viable;
        $proyecto->proy_snip15                        = $request->proy_snip15;
        $proyecto->proy_snip16                        = $request->proy_snip16;
        $proyecto->proy_verificacion_viabilidad       = $request->proy_verificacion_viabilidad;
        $proyecto->proy_modificaciones_sin_evaluacion = $request->proy_modificaciones_sin_evaluacion;
        $proyecto->proy_fech_registro_perfil          = $request->proy_fech_registro_perfil;
        $proyecto->proy_estado                        = $request->proy_estado;
        $proyecto->proy_pip_actualizado               = $request->proy_pip_actualizado;
        $proyecto->save();
        return json_encode([
            'idproy_proyecto' => $proyecto->idproy_proyecto,
            'proy_nombre'     => $proyecto->proy_nombre,
            'proy_cod_siaf'   => $proyecto->proy_cod_siaf,
            'proy_cod_snip'   => $proyecto->proy_cod_snip,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return Proyecto::find($request->id)->getForProyecto();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (!isset($request->option)) {
            $proyecto = Proyecto::find($id);
            return view('proyectos.proyecto.edit', [
                'proyecto'    => $proyecto,
                'oficinas'    => $this->oficinas,
                'espeficicas' => Especifica::getEspecificasToSelectforObra(),
                'componentes' => Componente::getComponentesForObras(),
                'versiones'   => \App\_clases\proyectos\analitico\Version::getVersionesToSelect2($proyecto->proy_cod_siaf),
            ]);
        } else {
            switch ($request->option) {
                case 'analitico':
                {
                    $proyecto = Proyecto::find($id);
                    return view('proyectos.analitico.analitico2', [
                        'proyecto'    => $proyecto,
                        'espeficicas' => Especifica::getEspecificasToSelectforObra(),
                        'componentes' => Componente::getComponentesForObras(),
                        'versiones'   => \App\_clases\proyectos\analitico\Version::getVersionesToSelect2($proyecto->proy_cod_siaf),
                    ]);
                    break;
                }
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $proyecto = Proyecto::where('idproy_proyecto','=',$id)->first();
        // $proyecto->proy_nombre                          = $request->proy_nombre         ;
        // $proyecto->proy_cod_snip                        = $request->proy_cod_snip       ;
        // $proyecto->proy_cod_siaf                        = $request->proy_cod_siaf       ;
        // $proyecto->funcion_id                           = $request->funcion_id          ;
        // $proyecto->proy_fte_fto                         = $request->proy_fte_fto        ;
        // $proyecto->proy_beneficiarios                   = $request->proy_beneficiarios  ;
        // $proyecto->ubigeo_id                  = $request->ubigeo_id ;
        // $proyecto->proy_localidad                       = $request->proy_localidad      ;
        // $proyecto->proy_perfil_viable                   = $request->proy_perfil_viable  ;
        // $proyecto->proy_snip15                          = $request->proy_snip15         ;
        // $proyecto->proy_snip16                          = $request->proy_snip16         ;
        // $proyecto->proy_perfil_viable                   = $request->proy_perfil_viable  ;
        // $proyecto->proy_verificacion_viabilidad         = $request->proy_verificacion_viabilidad;
        // $proyecto->proy_modificaciones_sin_evaluacion   = $request->proy_modificaciones_sin_evaluacion;
        // $proyecto->proy_fech_registro_perfil            = $request->proy_fech_registro_perfil;
        // $proyecto->proy_estado                          = $request->proy_estado         ;
        // $proyecto->proy_oficina                         = $request->proy_oficina        ;
        // $proyecto->proy_pip_actualizado                 = $request->proy_pip_actualizado;
        // $proyecto->save();
        // return redirect('proyectos/'.$id.'/edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cliente::destroy($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $proy
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function moduloGastos(Request $request)
    {

        $user = DB::table('admin')->find($request->user_id);

        $where = [
            ['sec_ejec', '=', config('proyectos.unidad_ejecutora')],
        ];

        if ($request->act_proy != null || $request->act_proy != '')
            $where[] = ['act_proy', '=', $request->act_proy];
        if ($request->sec_func != null || $request->sec_func != '')
            $where[] = ['sec_func', '=', $request->sec_func];

        if ($request->ano_eje != 'all')
            $where[] = ['ano_eje', '=', $request->ano_eje];

        $presupuesto = Presupuesto::select([
            'ano_eje',
            'sec_func',
            'fuente_financ',
            'componente',
            'pia',
            'pim',
            'id_clasificador',
            DB::Raw('null as cert'),
            DB::Raw('null as compromiso'),
            DB::Raw('null as expediente_siaf'),
            'monto_cert',
            'monto_comp',
            'monto_dev',
            'g_1',
            'g_2',
            'g_3',
            'g_4',
            'g_5',
            'g_6',
            'g_7',
            'g_8',
            'g_9',
            'g_10',
            'g_11',
            'g_12',
        ]);
        if ($request->user_id != null || $request->user_id != '') {
            $presupuesto->join("proy_presupuesto", function ($join) use ($user) {
                $join->on("sec_func", "=", "proy_presupuesto.proy_siaf_sec_func")
                    ->where("proy_presupuesto.proy_tram_dependencia", "=", $user->depe_id);
            });
        }
        $presupuesto->where($where)
            ->orderBy('ano_eje', 'DESC')
            ->orderBy('sec_func', 'ASC');
        return $presupuesto->get();
    }

    public function Gastos($id, $formato, Request $request)
    {
        $now      = Carbon::now();
        $proyecto = Proyecto::find($id);
        if ($formato == 'excel') {
            $d = Presupuesto::getPresupuestoForProyAll($proyecto->proy_cod_siaf, $formato);
            $data = ['proyecto' => $proyecto, 'presupuesto' => $d, 'formato' => $formato];
            return Excel::download(new GastosProjectExport($data), 'gastos.xlsx');
        } elseif ($formato == 'excelall') {
            $d = Presupuesto::getPresupuestoForProyAll($proyecto->proy_cod_siaf, $formato);
            $d = Certificado::getCertificadosForProyAll($d, $proyecto->proy_cod_siaf, $formato);
            $d = Compromiso::getCompromisosForProyAll($d, $proyecto->proy_cod_siaf, $formato);
            $d = Gasto::getGastosForProyAll($d, $proyecto->proy_cod_siaf, $formato);

            $data = ['proyecto' => $proyecto, 'presupuesto' => $d, 'formato' => $formato];

            return Excel::download(new GastosProjectExport($data, true), 'gastos.xlsx');
        } elseif (isset($request->option)) {
            switch ($request->option) {
                case 'gastos_lvl':
                {
                    return view('proyectos.proyecto.gastos.linealvl' . $request->lvl, [
                        'gastos' => $this->getGastosLvl($formato, $request->class, $request->lvl),
                        'nivel'  => $request->lvl,
                        'class'  => $request->class,
                        'hoy'    => $now,
                    ]);
                    break;
                }
                default:
                    {
                        dd("pagina no encontrada");
                    }
                    break;
            }
        } else {
            $formato = ($formato >= 1) ? $formato : 1;
            for ($i = Carbon::now()->year; $i >= 2000; $i--) {
                $anio[$i] = $i;
            }
            $presupuesto = Presupuesto::getPresupuestoForProyAll($proyecto->proy_cod_siaf, $formato, isset($request->anio) ? $request->anio : null);
            return ($presupuesto);
            return view('proyectos.proyecto.gastos', [
                'id'          => $id,
                'proyecto'    => $proyecto,
                'presupuesto' => $presupuesto,
                'formato'     => $formato,
                'hoy'         => $now,
                'anios'       => $anio,
                'anio'        => (isset($request->anio)) ? $request->anio : null,
                'iframe'      => (isset($request->iframe) && $request->iframe == 'true'),
            ]);
        }

    }

    // public function exportExcel($id, $formato, Request $request)
    // {
    //     return Excel::download(new GastosProjectExport($id, $formato), 'gastos.xlsx');
    // }

    public function getPresupuestoExcel($data)
    {
        return Excel::download($data['proyecto']->proy_cod_siaf . ' - Gastos de proyecto', function ($excel) use ($data) {
            $excel
                ->setTitle('Reporte de Gastos')
                ->setCreator('Gerencia Regional de Infraestructura')
                ->setCompany('Gobierno Regional Huanuco')
                ->setLastModifiedBy('Gerencia Regional de Infraestructura')
                ->setSubject('Reporte de Gastos de Proyecto de Inversion')
                ->setKeywords('GRI')
                ->setcategory('Reporte')
                ->setManager('Walther Aguirre Tello')
                ->setDescription('Reporte de Gastos de Proyecto de Inversion');
            $excel->sheet('Gastos', function ($sheet) use ($data) {
                $start_table = 5;
                /*FORMATO DE HOJA*/
                $sheet
                    ->setHeight([
                        2 => 50,
                    ])
                    ->setOrientation('landscape')
                    ->setFitToHeight(0)
                    ->setFitToPage(true);
                $sheet->getStyle('A2')->getAlignment()->setWrapText(true);
                $sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd($start_table, $start_table + 1);
                $sheet->getHeaderFooter()->setOddHeader('&LGobierno Regional Huánuco&RGerencia Regional de Infraestructura');
                $sheet->getHeaderFooter()->setOddFooter('&L Reporte de Gastos de Proyecto de Inversion' . Carbon::now('America/Lima')->toW3cString() . ' &RPagina &P de &N');
                /*FIN FORMATO DE HOJA*/
                $sheet->cells('A' . $start_table . ':N' . ($start_table + 1), function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBackground('#d9edf7');
                });

                $sheet->row(2, [
                    $data['proyecto']->proy_cod_siaf . ' - ' . $data['proyecto']->proy_nombre,
                ]);
                $sheet->row($start_table, [
                    'Año',
                    'Fto',
                    'Meta',
                    'Especifica',
                    'PIM',
                    'CERTIFICADO',
                    null,
                    null,
                    'COMPROMISO',
                    null,
                    null,
                    'DEVENGADO',
                ]);
                $sheet->row($start_table + 1, [
                    null,
                    null,
                    null,
                    null,
                    null,
                    'MONTO',
                    'SALDO',
                    '%',
                    'MONTO',
                    'SALDO',
                    '%',
                    'MONTO',
                    'SALDO',
                    '%',
                ]);
                $row = $start_table + 2;
                foreach ($data['presupuesto'] as $id1 => $d1) {
                    if ($id1 != 't') {
                        $lv1 = $id1;
                        $d   = $d1['t'];
                        $sheet->cells('A' . $row . ':N' . $row, function ($cells) {
                            $cells->setBackground('#a9a9a9');
                        });
                        $sheet->row($row++, [
                            $id1,
                            null,
                            null,
                            null,
                            $d->monto_pim,
                            $d->monto_cert,
                            $d->monto_pim - $d->monto_cert,
                            $d->monto_cert / $d->monto_pim,
                            $d->monto_comp,
                            $d->monto_pim - $d->monto_comp,
                            $d->monto_comp / $d->monto_pim,
                            $d->monto_dev,
                            $d->monto_pim - $d->monto_dev,
                            $d->monto_dev / $d->monto_pim,
                        ]);
                        foreach ($d1 as $id2 => $d2) {
                            if ($id2 != 't') {
                                $d   = $d2['t'];
                                $lv2 = $lv1 . "-" . $id2;
                                $sheet->cells('A' . $row . ':N' . $row, function ($cells) {
                                    $cells->setBackground('#c1c1c1');
                                });
                                $sheet->row($row++, [
                                    null,
                                    $d->desc1,
                                    null,
                                    null,
                                    $d->monto_pim,
                                    $d->monto_cert,
                                    $d->monto_pim - $d->monto_cert,
                                    $d->monto_cert / $d->monto_pim,
                                    $d->monto_comp,
                                    $d->monto_pim - $d->monto_comp,
                                    $d->monto_comp / $d->monto_pim,
                                    $d->monto_dev,
                                    $d->monto_pim - $d->monto_dev,
                                    $d->monto_dev / $d->monto_pim,
                                ]);
                                foreach ($d2 as $id3 => $d3) {
                                    if ($id3 != 't') {
                                        $lv3 = $lv2 . "-" . $id3;
                                        $d   = $d3['t'];
                                        $sheet->cells('A' . $row . ':N' . $row, function ($cells) {
                                            $cells->setBackground('#d6d6d6');
                                        });
                                        $sheet->row($row++, [
                                            null,
                                            null,
                                            $d->desc1,
                                            null,
                                            $d->monto_pim,
                                            $d->monto_cert,
                                            $d->monto_pim - $d->monto_cert,
                                            $d->monto_cert / $d->monto_pim,
                                            $d->monto_comp,
                                            $d->monto_pim - $d->monto_comp,
                                            $d->monto_comp / $d->monto_pim,
                                            $d->monto_dev,
                                            $d->monto_pim - $d->monto_dev,
                                            $d->monto_dev / $d->monto_pim,
                                        ]);

                                        //@include('proyectos.proyecto.gastos.linea')
                                        foreach ($d3 as $id4 => $d4) {
                                            if ($id4 != 't') {
                                                $d = $d4['t'];
                                                $sheet->cells('A' . $row . ':N' . $row, function ($cells) {
                                                    $cells->setBackground('#e6e6e6');
                                                });
                                                $sheet->row($row++, [
                                                    null,
                                                    null,
                                                    null,
                                                    $d->desc1,
                                                    $d->monto_pim,
                                                    $d->monto_cert,
                                                    $d->monto_pim - $d->monto_cert,
                                                    $d->monto_cert / $d->monto_pim,
                                                    $d->monto_comp,
                                                    $d->monto_pim - $d->monto_comp,
                                                    $d->monto_comp / $d->monto_pim,
                                                    $d->monto_dev,
                                                    $d->monto_pim - $d->monto_dev,
                                                    $d->monto_dev / $d->monto_pim,
                                                ]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $first = false;
                    }
                }
                $sheet->setBorder('A' . $start_table . ':N' . $row, 'thin');

            });
        }, 'gastos.xls');
    }

    public function getPresupuestoExcelCompleto($data)
    {
        return Excel::download($data['proyecto']->proy_cod_siaf . ' - Gastos de proyecto completo', function ($excel) use ($data) {
            $excel
                ->setTitle('Reporte de Gastos')
                ->setCreator('Gerencia Regional de Infraestructura')
                ->setCompany('Gobierno Regional Huanuco')
                ->setLastModifiedBy('Gerencia Regional de Infraestructura')
                ->setSubject('Reporte de Gastos de Proyecto de Inversion')
                ->setKeywords('GRI')
                ->setcategory('Reporte')
                ->setManager('Walther Aguirre Tello')
                ->setDescription('Reporte de Gastos de Proyecto de Inversion');
            $excel->sheet('Gastos', function ($sheet) use ($data) {
                $start_table = 5;
                /*FORMATO DE HOJA*/
                $sheet
                    ->mergeCells('A2:N2')
                    ->mergeCells('I' . $start_table . ':K' . $start_table)
                    ->mergeCells('L' . $start_table . ':N' . $start_table)
                    ->mergeCells('O' . $start_table . ':Q' . $start_table)
                    ->setMergeColumn([
                        'columns' => ['A', 'B', 'C', 'D', 'E', 'F', 'G'],
                        'rows'    => [[$start_table, $start_table + 1],],
                    ])
                    ->setWidth([
                        'A' => 10,
                        'B' => 10,
                        'C' => 10,
                        'D' => 55,
                        'E' => 15,
                        'F' => 15,
                        'G' => 15,
                        'H' => 15,
                        'I' => 15,
                        'J' => 15,
                        'K' => 15,
                        'L' => 15,
                        'M' => 15,
                        'N' => 15,
                        'O' => 15,
                        'P' => 15,
                        'Q' => 15,
                    ])
                    ->setHeight([
                        2 => 50,
                    ])
                    ->setColumnFormat([
                        'E' => '#,##0.00',
                        'F' => '#,##0.00',
                        'G' => '#,##0.00',
                        'H' => '#,##0.00',
                        'I' => '#,##0.00',
                        'J' => '#,##0.00',
                        'K' => '0.00%',
                        'L' => '#,##0.00',
                        'M' => '#,##0.00',
                        'N' => '0.00%',
                        'O' => '#,##0.00',
                        'P' => '#,##0.00',
                        'Q' => '0.00%',
                    ])
                    ->setOrientation('landscape')
                    ->setFitToHeight(0)
                    ->setFitToPage(true)
                    ->cells('A2', function ($cell) {
                        $cell->setFontSize(20);
                        $cell->setAlignment('center');
                        $cell->setValignment('center');
                    });
                $sheet->getStyle('A2')->getAlignment()->setWrapText(true);

                $sheet->getHeaderFooter()->setOddHeader('&LGobierno Regional Huánuco&RGerencia Regional de Infraestructura');
                $sheet->getHeaderFooter()->setOddFooter('&L Reporte de Gastos de Proyecto de Inversion' . Carbon::now('America/Lima')->toW3cString() . ' &RPagina &P de &N');
                /*FIN FORMATO DE HOJA*/
                $sheet->cells('A' . $start_table . ':Q' . ($start_table + 1), function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBackground('#d9edf7');
                });
                $sheet->rows([
                    [11, 12, 13],
                    [14, 15, 16],
                ]);

                $sheet->row(2, [
                    $data['proyecto']->proy_cod_siaf . ' - ' . $data['proyecto']->proy_nombre,
                ]);

                $row = $start_table + 2;
                foreach ($data['presupuesto'] as $id1 => $d1) {
                    if ($id1 != 't') {
                        $lv1 = $id1;
                        $d   = $d1['t'];
                        $sheet->cells('A' . $row . ':Q' . $row, function ($cells) {
                            $cells->setBackground('#a9a9a9');
                        });
                        //$sheet->getRowDimension($row)->setOutlineLevel(1);
                        $sheet->row($row++, [
                            $id1,
                            null,
                            null,
                            null,
                            null,
                            null,
                            null,
                            $d->monto_pim,
                            $d->monto_cert,
                            $d->monto_pim - $d->monto_cert,
                            $d->monto_cert / $d->monto_pim,
                            $d->monto_comp,
                            $d->monto_pim - $d->monto_comp,
                            $d->monto_comp / $d->monto_pim,
                            $d->monto_dev,
                            $d->monto_pim - $d->monto_dev,
                            $d->monto_dev / $d->monto_pim,
                        ]);
                        foreach ($d1 as $id2 => $d2) {
                            if ($id2 != 't') {
                                $d   = $d2['t'];
                                $lv2 = $lv1 . "-" . $id2;
                                $sheet->cells('A' . $row . ':Q' . $row, function ($cells) {
                                    $cells->setBackground('#c1c1c1');
                                });
                                //$sheet->getRowDimension($row)->setOutlineLevel(2);
                                $sheet->row($row++, [
                                    null,
                                    $d->desc1,
                                    null,
                                    null,
                                    null,
                                    null,
                                    null,
                                    $d->monto_pim,
                                    $d->monto_cert,
                                    $d->monto_pim - $d->monto_cert,
                                    $d->monto_cert / $d->monto_pim,
                                    $d->monto_comp,
                                    $d->monto_pim - $d->monto_comp,
                                    $d->monto_comp / $d->monto_pim,
                                    $d->monto_dev,
                                    $d->monto_pim - $d->monto_dev,
                                    $d->monto_dev / $d->monto_pim,
                                ]);
                                foreach ($d2 as $id3 => $d3) {
                                    if ($id3 != 't') {
                                        $lv3 = $lv2 . "-" . $id3;
                                        $d   = $d3['t'];
                                        $sheet->cells('A' . $row . ':Q' . $row, function ($cells) {
                                            $cells->setBackground('#d6d6d6');
                                        });
                                        //$sheet->getRowDimension($row)->setOutlineLevel(3);
                                        $sheet->row($row++, [
                                            null,
                                            null,
                                            $d->desc1,
                                            null,
                                            null,
                                            null,
                                            null,
                                            $d->monto_pim,
                                            $d->monto_cert,
                                            $d->monto_pim - $d->monto_cert,
                                            $d->monto_cert / $d->monto_pim,
                                            $d->monto_comp,
                                            $d->monto_pim - $d->monto_comp,
                                            $d->monto_comp / $d->monto_pim,
                                            $d->monto_dev,
                                            $d->monto_pim - $d->monto_dev,
                                            $d->monto_dev / $d->monto_pim,
                                        ]);

                                        foreach ($d3 as $id4 => $d4) {
                                            if ($id4 != 't') {
                                                $d = $d4['t'];
                                                $sheet->cells('A' . $row . ':Q' . $row, function ($cells) {
                                                    $cells->setBackground('#e6e6e6');
                                                });
                                                //$sheet->getRowDimension($row)->setOutlineLevel(4);
                                                $sheet->row($row++, [
                                                    null,
                                                    null,
                                                    null,
                                                    $d->desc1,
                                                    null,
                                                    null,
                                                    null,
                                                    $d->monto_pim,
                                                    $d->monto_cert,
                                                    $d->monto_pim - $d->monto_cert,
                                                    $d->monto_cert / $d->monto_pim,
                                                    $d->monto_comp,
                                                    $d->monto_pim - $d->monto_comp,
                                                    $d->monto_comp / $d->monto_pim,
                                                    $d->monto_dev,
                                                    $d->monto_pim - $d->monto_dev,
                                                    $d->monto_dev / $d->monto_pim,
                                                ]);
                                                foreach ($d4 as $id5 => $d5) {
                                                    if ($id5 != 't') {
                                                        $d = $d5['t'];
                                                        $sheet->cells('A' . $row . ':Q' . $row, function ($cells) {
                                                            $cells->setBackground('#efefef');
                                                        });
                                                        $sheet->mergeCells('E' . $row . ':J' . $row)
                                                            ->setHeight([
                                                                $row => 60,
                                                            ]);
                                                        //$sheet->getRowDimension($row)->setOutlineLevel(5);
                                                        //$sheet->getRowDimension($row)->setVisible(false);
                                                        $sheet->row($row, [
                                                            null,
                                                            null,
                                                            null,
                                                            null,
                                                            null,
                                                            null,
                                                            null,

                                                            null,
                                                            null,
                                                            null,
                                                            null,
                                                            $d->monto_comp,
                                                            ($d->monto_cert > 0) ? $d->monto_cert - $d->monto_comp : '',
                                                            ($d->monto_cert > 0) ? $d->monto_comp / $d->monto_cert : '',
                                                            $d->monto_dev,
                                                            ($d->monto_cert > 0) ? $d->monto_cert - $d->monto_dev : '',
                                                            ($d->monto_cert > 0) ? $d->monto_dev / $d->monto_cert : '',
                                                        ]);
                                                        $sheet->getCell('E' . $row)->setValue("CERTIFICADO: " . $d->certificado . "\nMONTO: " . $d->monto_cert . "\nCONCEPTO: " . $d->concepto);
                                                        $sheet->getStyle('E' . $row++)->getAlignment()->setWrapText(true);
                                                        foreach ($d5 as $id6 => $d6) {
                                                            if ($id6 != 't') {
                                                                $d = $d6['t'];
                                                                $sheet->cells('A' . $row . ':Q' . $row, function ($cells) {
                                                                    //$cells->setBackground('#efefef');
                                                                });
                                                                $sheet->mergeCells('F' . $row . ':M' . $row)
                                                                    ->setHeight([
                                                                        $row => 60,
                                                                    ]);
                                                                //$sheet->getRowDimension($row)->setOutlineLevel(5);
                                                                //$sheet->getRowDimension($row)->setVisible(false);
                                                                $sheet->row($row, [
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    null,
                                                                    $d->monto_dev,
                                                                    ($d->monto_comp > 0) ? $d->monto_comp - $d->monto_dev : '',
                                                                    ($d->monto_comp > 0) ? $d->monto_dev / $d->monto_comp : '',
                                                                ]);
                                                                $sheet->getCell('F' . $row)->setValue("COMPROMISO: " . $d->compromiso . "\nMONTO: " . $d->monto_comp . "\nCONCEPTO: " . $d->concepto);
                                                                $sheet->getStyle('F' . $row++)->getAlignment()->setWrapText(true);

                                                                foreach ($d6 as $id7 => $d7) {
                                                                    if ($id7 != 't') {
                                                                        $d = $d7['t'];
                                                                        $sheet->cells('A' . $row . ':Q' . $row, function ($cells) {
                                                                            //$cells->setBackground('#efefef');
                                                                        });
                                                                        $sheet->cells('G' . $row, function ($cell) {
                                                                            $cell->setValignment('top');
                                                                        });
                                                                        $sheet->mergeCells('G' . $row . ':Q' . $row)
                                                                            ->setHeight([
                                                                                $row => 200,
                                                                            ]);
                                                                        //$sheet->getRowDimension($row)->setOutlineLevel(5);
                                                                        //$sheet->getRowDimension($row)->setVisible(false);
                                                                        $sheet->row($row, [
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                            null,
                                                                        ]);
                                                                        $sheet->getCell('G' . $row)->setValue(sprintf("Expediente SIAF: %s \nFecha: %s\nMonto: %s\nProveedor: %s \nCp's:  %s\nConcepto:  %s \n\nNotas del Devengado - %s\n\nNotas del Girado - %s", $d->expediente, $d->fecha, Money::toMoney($d->monto_dev), $d->proveedor, $d->cps, $d->nota_c, $d->nota_d, $d->nota_g));
                                                                        $sheet->getStyle('G' . $row++)->getAlignment()->setWrapText(true);

                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $first = false;
                    }
                }
                $sheet->setBorder('A' . $start_table . ':Q' . $row, 'thin');
            });

        })->download('xls');
    }

    function getGastosLvl(Request $request)
    {
        switch ($request->lvl) {
            case 3:
                {
                    $certificados = Certificado::getCertificadosForGastos($request->ano_eje, $request->fuente_financ, $request->sec_func, $request->id_clasificador);
                    $certificados = Compromiso::getCompromisosForCertificado($certificados, $request->ano_eje, $request->fuente_financ, $request->sec_func, $request->id_clasificador);
                    return $gastos = Gasto::getGastosForCertificado($certificados, $request->ano_eje, $request->fuente_financ, $request->sec_func, $request->id_clasificador);
                }
                break;
            case 4:
                {
                    $cert = explode("_", $request->cert);
                    $comp = Compromiso::getCompromisosForGastos($request->ano_eje, $request->fuente_financ, $request->sec_func, $request->id_clasificador, $cert[0], $cert[1]);

                    return Gasto::getGastosForCompromiso($comp, $request->ano_eje, $request->fuente_financ, $request->sec_func, $request->id_clasificador, $cert[0], $cert[1]);
                }
                break;
            case 5:
                {
                    $cert = explode("_", $request->cert);
                    return Gasto::getCompromisosForGastos($request->ano_eje, $request->fuente_financ, $request->sec_func, $request->id_clasificador, $cert[0], $cert[1], $request->secuencia_c);
                }
                break;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function imprimirPdf(Request $id)
    {
        $headers        = ['Content-Type' => 'application/pdf'];
        $anio           = Carbon::now()->year;
        $listado        = Proyecto::getListado('ejecucion', $anio);
        $totalFuncion   = Proyecto::groupFuncionForPDF($listado);
        $totalProvincia = Proyecto::groupProvinciaForPDF($listado);
        $total          = Proyecto::groupTotalForPDF($listado);

        $pdf = new ProyectosPDFF();

        $pdf->AliasNbPages();
        $pdf->SetTopMargin(20);
        $pdf->SetAutoPageBreak(true, 23);
        //$pdf->AddPage();
        //$pdf->SetFont('Arial', 'B', 14);
        //$pdf->Cell(180, 7, utf8_decode('REPORTE GENERAL DE PROYECTOS'),0,0,'C');
        /*$pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 7, utf8_decode('POR FUNCIÓN'));
        $pdf->Ln();
        $titulo1  = array('FUNCION','NRO OBRAS', 'MONTO INVERSION', 'BENEFICIARIOS');
        $data = json_decode(json_encode($totalFuncion), true);
        //$data = $pdf->LoadData('lista.txt');
        //$pdf->FancyTable($titulo1,$data);
        $pdf->Ln();
        $pdf->Ln();
       //    dd($data);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 7, utf8_decode('POR PROVINCIA'));
        $pdf->Ln();


        $titulo2  = array('PROVINCIA','NRO OBRAS', 'MONTO INVERSION', 'BENEFICIARIOS');
        $data1 = json_decode(json_encode($totalProvincia), true);

        //$pdf->FancyTable($titulo2,$data1);*/
        $pdf->SetHeader(2);
        $pdf->AddPage('L', 'A4', 0);
        //$pdf->SetFooter('','hola');
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 7, utf8_decode('LISTADO'));
        $pdf->Ln();

        $w = [22, 100, 27, 27, 25, 25, 27, 20];
        $pdf->SetFont('Arial', '', 9);
        $titulo3 = [
            'FUNCION',
            'DENOMINACION',
            'LOCALIZACION',
            'MODALIDAD',
            'FECHA',
            'MONTO',
            'BENEFICIARIOS',
            'AVANCE',
        ];
        $data2   = json_decode(json_encode($total), true);
        //dd($data2);

        //$pdf->FancyTable($titulo3, $data2, $w);


        //dd($data2);
        //$pdf->SetWidths(array(30,50,30,40,30,50,30,40,30,50,30,40));
        /*if($data2) {
            //dd($value);
            $pdf->Row($data2);
        }*/


        return Response::make($pdf->Output(), 200, $headers);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $anio
     * @return array
     */
    private function informacionDiaria($anio, $oficina = 0, $obras = 'all', $fechas = [])
    {
        $oficinas    = [
            0 => 'GRI%',
            1 => 'GRI/OBRAS',
            2 => 'GRI/ESTUDIO',
            3 => 'GRI/LIQUIDACION',
        ];
        $seguimiento = DB::table('SEGUIMIENTO_EJECUCION_GRI')
            ->where('ANO_EJE', '=', $anio)
            ->where('OFICINA', 'LIKE', $oficinas[$oficina]);

        if ($obras != 'all')
            $seguimiento->whereIn('ACT_PROY', explode(',', $obras));
        $arreglo = [];
        foreach ($seguimiento->get() as $seg) {
            $index = $seg->dia - 1;
            if (!isset($arreglo[$seg->mes])) {
                $arreglo[$seg->mes] = [];
            }
            if (!isset($arreglo[$seg->mes][$seg->dia])) {
                $arreglo[$seg->mes][$seg->dia] = $seg->MONTO;
            } else
                $arreglo[$seg->mes][$seg->dia] += $seg->MONTO;
            $arreglo[$seg->mes][$seg->dia] = round($arreglo[$seg->mes][$seg->dia], 2);
        }
        return $arreglo;
    }

    private function ejecutadoVsProgramadoDiario($anio, $oficina = 0, $obras = 'all')
    {
        $oficinas = [
            0 => 'GRI%',
            1 => 'GRI/OBRAS',
            2 => 'GRI/ESTUDIO',
            3 => 'GRI/LIQUIDACION',
        ];
        $where    = [];
        $where[]  = ['ANO_EJE', '=', $anio];
        $where[]  = ['OFICINA', 'LIKE', $oficinas[$oficina]];
        if ($obras != 'all')
            $where[] = ['ACT_PROY', 'LIKE', $obras];
        $ejecutado = DB::table('SEGUIMIENTO_EJECUCION_GRI')
            ->select([
                DB::raw('Sum(MONTO) AS monto'),
                DB::raw('MEJOR_FECH as fecha'),
            ])
            ->where($where)
            ->groupBy('MEJOR_FECH')
            ->orderBy('MEJOR_FECH', 'ASC')
            ->get();
        $dias      = [];
        foreach ($ejecutado as $seg) {
            $dias[$seg->fecha] = $seg->monto;
        }
        $where   = [];
        $where[] = ['proy_plan_anio', '=', $anio];
        $where[] = ['g.asig_oficina', 'LIKE', $oficinas[$oficina]];
        if ($obras != 'all')
            $where[] = ['g.asig_act_proy', 'LIKE', $obras];

        $programado = DB::table('proy_plan_mes')
            ->join('proy_proyecto_asignacion AS g', function (JoinClause $join) {
                return $join
                    ->on('g.asig_act_proy', '=', 'proy_plan_mes.proy_plan_proyecto')
                    ->on('g.asig_anio', '=', 'proy_plan_mes.proy_plan_anio')
                    ->on('proy_plan_mes.proy_plan_monto', '>', DB::raw(0))
                    ->on('proy_plan_mes.version_id', '=', DB::raw('(SELECT
				Max(v.id)
				FROM
				proy_plan_version AS v
				WHERE
				v.vers_proyecto = proy_plan_mes.proy_plan_proyecto AND
				v.vers_anio = proy_plan_mes.`proy_plan_anio`)'));
            })
            ->select([
                DB::raw('Sum(proy_plan_mes.proy_plan_monto) AS monto'),
                DB::raw('((proy_plan_mes.proy_plan_mes-1)%12)+1 as mes'),
            ])
            ->where($where)
            ->groupBy('proy_plan_anio')
            ->groupBy(DB::raw('proy_plan_mes % 12'));
        $dias_p     = [[$anio . '-01-01' => 0]];
        foreach ($programado->get() as $prg) {
            $f           = Carbon::create($anio, $prg->mes, 1, 0, 0, 0);
            $daysInMonth = $f->daysInMonth;
            $lastOfMonth = $f->copy()->lastOfMonth();
            $monto       = $prg->monto / $daysInMonth;
            do {
                $dias_p[$f->format('Y-m-d')] = round($monto, 2);
                $f->addDay();
            } while ($f <= $lastOfMonth);
        }
        $arreglo = [];
        $fecha   = Carbon::create($anio, 1, 1, 0, 0, 0);
        $now     = (Carbon::now() > $fecha->copy()->lastOfYear()) ? $fecha->copy()->lastOfYear() : Carbon::now();

        $lastOfYear = $now->copy()->lastOfYear();
        $acarreo_e  = 0;
        $acarreo_p  = 0;
        do {
            $acarreo_e += isset($dias[$fecha->format('Y-m-d')]) ? $dias[$fecha->format('Y-m-d')] : 0;
            $acarreo_p += isset($dias_p[$fecha->format('Y-m-d')]) ? $dias_p[$fecha->format('Y-m-d')] : 0;
            $arreglo[] = [
                'dia'        => $fecha->format('Y-m-d'),
                'ejecutado'  => ($fecha <= $now) ? $acarreo_e : null,
                'programado' => $acarreo_p,
            ];
            $fecha->addDay();

        } while ($fecha <= $lastOfYear);
        return $arreglo;
    }


    private function ejecutadoVsProgramadoMensual($anio, $oficina = 0, $obras = 'all')
    {
        $oficinas = [0 => 'GRI%', 1 => 'GRI/OBRAS', 2 => 'GRI/ESTUDIO', 3 => 'GRI/LIQUIDACION'];
        $where    = [['ANO_EJE', '=', $anio], ['OFICINA', 'LIKE', $oficinas[$oficina]]];
        if ($obras != 'all')
            $where[] = ['ACT_PROY', 'LIKE', $obras];
        $ejecutado = DB::table('SEGUIMIENTO_EJECUCION_GRI')
            ->select([DB::raw('Sum(MONTO) AS monto'), DB::raw('MONTH(MEJOR_FECH) as fecha')])
            ->where($where)
            ->groupBy(DB::raw('MONTH(MEJOR_FECH)'))
            ->groupBy('MEJOR_FECH')
            ->orderBy('MEJOR_FECH', 'ASC')
            ->get();
        $dias      = [];
        foreach ($ejecutado as $seg) {
            $dias[$seg->fecha] = $seg->monto;
        }
        $where = [['proy_plan_anio', '=', $anio], ['g.asig_oficina', 'LIKE', $oficinas[$oficina]]];
        if ($obras != 'all')
            $where[] = ['g.asig_act_proy', 'LIKE', $obras];

        $programado = DB::table('proy_plan_mes')
            ->join('proy_proyecto_asignacion AS g', function (JoinClause $join) {
                return $join
                    ->on('g.asig_act_proy', '=', 'proy_plan_mes.proy_plan_proyecto')
                    ->on('g.asig_anio', '=', 'proy_plan_mes.proy_plan_anio')
                    ->on('proy_plan_mes.proy_plan_monto', '>', DB::raw(0))
                    ->on('proy_plan_mes.version_id', '=', DB::raw('(SELECT Max(v.id)
				FROM proy_plan_version AS v
				WHERE v.vers_proyecto = proy_plan_mes.proy_plan_proyecto AND v.vers_anio = proy_plan_mes.`proy_plan_anio`)'));
            })
            ->select([
                DB::raw('Sum(proy_plan_mes.proy_plan_monto) AS monto'),
                DB::raw('((proy_plan_mes.proy_plan_mes-1)%12)+1 as mes'),
            ])
            ->where($where)
            ->groupBy('proy_plan_anio')
            ->groupBy(DB::raw('proy_plan_mes % 12'))
            ->groupBy('mes')
            ->orderBy('mes');
        $dias_p     = [];
        foreach ($programado->get() as $prg) {
            $dias_p[$prg->mes] = $prg->monto;
        }
        $arreglo   = [];
        $acarreo_e = 0;
        $acarreo_p = 0;
        for ($i = 1; $i <= 12; $i++) {
            //foreach($dias_p as $id =>$programado){
            $acarreo_e += (isset($dias[$i])) ? $dias[$i] : null;
            $acarreo_p += (isset($dias_p[$i])) ? $dias_p[$i] : null;
            $fecha     = Carbon::create($anio, $i, 1, 0, 0, 0);
            $arreglo[] = [
                'dia'        => $fecha->format('Y-m'),
                'ejecutado'  => (isset($dias[$i])) ? $acarreo_e : null,
                'programado' => (isset($dias_p[$i])) ? $acarreo_p : null,
            ];
            $fecha->addMonth();

        }
        return $arreglo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $anio
     * @return array
     */
    private function getPresupuesto($anio, $oficina = 1, $obra = 'all')
    {
        $oficinas = [
            0 => 'GRI%',
            1 => 'GRI/OBRAS',
            2 => 'GRI/ESTUDIO',
            3 => 'GRI/LIQUIDACION',
        ];
        $where    = [
            ['p.SEC_EJEC', '=', config('proyectos.unidad_ejecutora')],
            ['g.asig_oficina', 'LIKE', $oficinas[$oficina]],
            ['p.ANO_EJE', '=', $anio],
        ];

        $reporte = DB::table('siaf_wpresupuesto as p')
            ->select([
                'p.FUENTE_FIN',
                'p.ESPECIFICA',
                'p.DESCRIPCIO',
                'p.COMPONENTE',
                'p.COMPONENTE_NOMBRE',
                'p.pia',
                'p.pim',
                'p.ACT_PROY',
                'g.asig_oficina',
            ])
            ->join('siaf_meta AS m', function (JoinClause $join) {
                return $join
                    ->on('m.ANO_EJE', '=', 'p.ANO_EJE')
                    ->on('m.SEC_EJEC', '=', 'p.SEC_EJEC')
                    ->on('m.SEC_FUNC', '=', 'p.SEC_FUNC');
            })
            ->join('proy_proyecto_asignacion AS g', function (JoinClause $join) {
                return $join
                    ->on('g.asig_anio', '=', 'p.ANO_EJE')
                    ->on('g.asig_act_proy', '=', 'p.ACT_PROY');
            })
            ->where($where);
        if ($obra != 'all')
            $reporte->whereIn('p.ACT_PROY', explode(',', $obra));

        return $reporte->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $anio
     * @param int $oficina
     * @return array
     */
    private function getCertificado($anio, $oficina = 0, $obra = 'all')
    {
        $oficinas = [
            0 => 'GRI%',
            1 => 'GRI/OBRAS',
            2 => 'GRI/ESTUDIO',
            3 => 'GRI/LIQUIDACION',
        ];
        $reporte  = DB::table('siaf_wcert AS c')
            ->select([
                'c.FUENTE_FIN',
                'c.ESPECIFICA',
                'c.ESPECIFICA_DET',
                'c.MONTO',
                'c.FECHA',
            ])
            ->join('siaf_meta AS m', function (JoinClause $join) {
                return $join
                    ->on('m.ANO_EJE', '=', 'c.ANO_EJE')
                    ->on('m.SEC_EJEC', '=', 'c.SEC_EJEC')
                    ->on('m.SEC_FUNC', '=', 'c.SEC_FUNC');
            })
            ->join('proy_proyecto_asignacion AS g', function (JoinClause $join) {
                return $join
                    ->on('g.asig_anio', '=', 'c.ANO_EJE')
                    ->on('g.asig_act_proy', '=', 'c.ACT_PROY');
            })
            ->where('c.SEC_EJEC', '=', config('proyectos.unidad_ejecutora'))
            ->where('g.asig_oficina', 'LIKE', $oficinas[$oficina])
            ->where('c.ANO_EJE', '=', $anio);
        if ($obra != 'all')
            $reporte->whereIn('c.ACT_PROY', explode(',', $obra));
        return $reporte->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $anio
     * @param int $oficina
     * @return array
     */
    private function getComprometido($anio, $oficina = 0, $obra = 'all')
    {
        $oficinas = [
            0 => 'GRI%',
            1 => 'GRI/OBRAS',
            2 => 'GRI/ESTUDIO',
            3 => 'GRI/LIQUIDACION',
        ];
        $reporte  = DB::table('proy_siaf_comp AS c')
            ->select([
                'c.FUENTE_FIN',
                'c.MONTO',
                'c.FECHA_DOC',
            ])
            ->join('siaf_meta AS m', function (JoinClause $join) {
                return $join
                    ->on('m.ANO_EJE', '=', 'c.ANO_EJE')
                    ->on('m.SEC_EJEC', '=', 'c.SEC_EJEC')
                    ->on('m.SEC_FUNC', '=', 'c.SEC_FUNC');
            })
            ->join('proy_proyecto_asignacion AS g', function (JoinClause $join) {
                return $join
                    ->on('g.asig_anio', '=', 'c.ANO_EJE')
                    ->on('g.asig_act_proy', '=', 'c.ACT_PROY');
            })
            ->where('c.SEC_EJEC', '=', config('proyectos.unidad_ejecutora'))
            ->where('g.asig_oficina', 'LIKE', $oficinas[$oficina])
            ->where('c.ANO_EJE', '=', $anio);
        if ($obra != 'all')
            $reporte->whereIn('c.ACT_PROY', explode(',', $obra));
        return $reporte->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $anio
     * @param int $oficina
     * @return array
     */
    private function getDevengado($anio, $oficina = 0, $obra = 'all')
    {
        $oficinas = [
            0 => 'GRI%',
            1 => 'GRI/OBRAS',
            2 => 'GRI/ESTUDIO',
            3 => 'GRI/LIQUIDACION',
        ];
        $reporte  = DB::table('siaf_wgastos AS ga')
            ->select([
                'ga.FUENTE_FIN',
                'ga.MONTO',
                'ga.MEJOR_FECH',
            ])
            ->join('siaf_meta AS m', function (JoinClause $join) {
                return $join
                    ->on('m.ANO_EJE', '=', 'ga.ANO_EJE')
                    ->on('m.SEC_EJEC', '=', 'ga.SEC_EJEC')
                    ->on('m.SEC_FUNC', '=', 'ga.SEC_FUNC');
            })
            ->join('proy_proyecto_asignacion AS g', function (JoinClause $join) {
                return $join
                    ->on('g.asig_anio', '=', 'ga.ANO_EJE')
                    ->on('g.asig_act_proy', '=', 'ga.ACT_PROY');
            })
            ->where('ga.SEC_EJEC', '=', config('proyectos.unidad_ejecutora'))
            ->where('g.asig_oficina', 'LIKE', $oficinas[$oficina])
            ->where('ga.ANO_EJE', '=', $anio);
        if ($obra != 'all')
            $reporte->whereIn('ga.ACT_PROY', explode(',', $obra));
        return $reporte->get();
    }

    private function getFechasReporte()
    {
        $hoy           = Carbon::today();
        $mes           = $hoy->month;
        $mesAnterior   = Carbon::today()->firstOfMonth();
        $diaDeSemana   = $hoy->dayOfWeek;
        $ultimoViernes = Carbon::today()->subDays(($diaDeSemana + 2) % 7);
        if ($diaDeSemana == 5 || $diaDeSemana == 6 || $diaDeSemana == 0)
            $ultimoViernes->subWeek();
        $ayer    = Carbon::yesterday();
        $acarreo = [];
        if ($mes > 1)
            $acarreo[] = [
                'name'         => 'Mes Anterior',
                'date'         => $mesAnterior->subDay()->toDateString(),
                'presupuesto'  => 0,
                'certificado'  => 0,
                'comprometido' => 0,
                'devengado'    => 0,
            ];
        if ($mes == $ultimoViernes->month)
            $acarreo[] = [
                'name'         => 'Semana Anterior',
                'date'         => $ultimoViernes->toDateString(),
                'presupuesto'  => 0,
                'certificado'  => 0,
                'comprometido' => 0,
                'devengado'    => 0,
            ];
        if ($mes == $ayer->month)
            $acarreo[] = [
                'name'         => 'Ayer',
                'date'         => $ayer->toDateString(),
                'presupuesto'  => 0,
                'certificado'  => 0,
                'comprometido' => 0,
                'devengado'    => 0,
            ];
        $acarreo[] = [
            'name'         => 'Hoy',
            'date'         => $hoy->toDateString(),
            'presupuesto'  => 0,
            'certificado'  => 0,
            'comprometido' => 0,
            'devengado'    => 0,
        ];
        return $acarreo;
    }

    public function contratos($id)
    {
        return view('proyectos.proyecto.contratos', ['proyecto' => (Object)['idproy_proyecto' => $id]]);
    }

    public function actividadObra($proy, $id)
    {

        return view('proyectos.proyecto.actividad.actividad',
            [
                'idproyecto' => $proy,
                'idcontrato' => $id,
            ]);
    }

    public function informes($id)
    {
        return view('proyectos.informes.informes', ['proyecto' => (Object)['idproy_proyecto' => $id]]);
    }
}
