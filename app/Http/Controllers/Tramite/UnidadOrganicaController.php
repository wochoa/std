<?php

namespace App\Http\Controllers\Tramite;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dependencia;
use DB;
use Auth;
use PhpParser\Node\Expr\Cast\Object_;

class UnidadOrganicaController extends Controller
{
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => ['obtenerUnidadOrganica']]);
    }
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {

        $dependencias=Dependencia::find(Auth::user()->depe_id);

        $where              =[];
        if ($request->depe_representante!=null)
            $where[]        =['tram_dependencia.depe_representante','LIKE',"%$request->depe_representante%"];
        if ($request->depe_nombre!=null)
            $where[]        =['tram_dependencia.depe_nombre','LIKE',"%$request->depe_nombre%"];
        if ($request->depe_depende!=null && $request->tipo==1)
            $where[]        =['tram_dependencia.depe_depende','=',$request->depe_depende];
        if ($request->depe_depende!=null && $request->tipo==2)
            $where[]        =['tram_dependencia.depe_depende','=',$dependencias->depe_depende];
        if ($request->iddependencia!=null)
            $where[]        =['tram_dependencia.iddependencia','=',$request->iddependencia];

        return Dependencia::select('tram_dependencia.iddependencia',
                                    'tram_dependencia.depe_nombre',
                                    'tram_dependencia.depe_abreviado',
                                    'tram_dependencia.depe_sigla',
                                    'tram_dependencia.depe_representante',
                                    'td2.depe_nombre AS nombre')
                            ->join('tram_dependencia AS td2', 'tram_dependencia.depe_depende', '=', 'td2.iddependencia')
                            ->where($where)
                            ->orderBy('tram_dependencia.iddependencia', 'asc')
                            ->paginate(15);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $uni=(Object)$request->unidad;
            $unidad                             =(!isset($uni->iddependencia)||$uni->iddependencia==null)?new Dependencia():Dependencia::find($uni->iddependencia);
            if($request->tipo==1){
                $unidad->depe_depende               =$uni->depe_depende;
                $unidad->depe_superior              =$uni->depe_superior;
                $unidad->depe_nombre                =$uni->depe_nombre;
                $unidad->depe_abreviado             =$uni->depe_abreviado;
                $unidad->depe_sigla                 =$uni->depe_sigla;
                $unidad->depe_representante         =$uni->depe_representante;
                $unidad->depe_cargo                 =$uni->depe_cargo;
                $unidad->depe_dni                   =$uni->depe_dni;
                $unidad->depe_tipo                  =1;
                $unidad->depe_proyectado            =1;
                $unidad->depe_diasmaxenproceso      =$uni->depe_diasmaxenproceso;
                $unidad->depe_estado                =$uni->depe_estado;
                $unidad->depe_observaciones         =$uni->depe_observaciones;
                $unidad->depe_rrhh                  =$uni->depe_rrhh;
                $unidad->depe_recibetramite         =$uni->depe_recibetramite;
            }else{
                $unidad->depe_superior              =$uni->depe_superior;
                $unidad->depe_representante         =$uni->depe_representante;
                $unidad->depe_cargo                 = $uni->depe_cargo;
                $unidad->depe_recibetramite         =$uni->depe_recibetramite;
            }
            $unidad->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        return Dependencia::select('iddependencia',
                                    'depe_depende',
                                    'depe_superior',
                                    'depe_nombre',
                                    'depe_abreviado',
                                    'depe_sigla',
                                    'depe_representante',
                                    'depe_cargo',
                                    'depe_dni',
                                    'depe_tipo',
                                    'depe_diasmaxenproceso',
                                    'depe_estado',
                                    'depe_observaciones',
                                    'depe_rrhh',
                                    'depe_recibetramite')
                                ->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function obtenerMiUnidadOrganica()
    {
        return Dependencia::select('iddependencia',
            'depe_nombre',
            'depe_depende',
            'depe_representante',
            'depe_cargo',
            'depe_sigla')
            ->where('iddependencia',Auth::user()->depe_id)
            ->orderBy('depe_nombre','ASC')
            ->first();
    }
    public function obtenerUnidadOrganica(Request $request)
    {
        //\Debugbar::disable();

        switch ($request->tipo){
            case '5' :{
                //obtener datos de una unidad Organia en especifico OJO datos completos
                return $this->obtenerMiUnidadOrganica();
            }break;
            default :{
                //obtener datos de una unidad Organia en especifico OJO datos completos
                $d = Dependencia::select('iddependencia',
                    'depe_nombre',
                    'depe_depende',
                    'depe_tipo',
                    'depe_recibetramite')
                    ->orderBy('depe_nombre','ASC')
                    ->get();
                $r=[];
                foreach ($d as $f){
                    $r[]=(Object)[$f->iddependencia,$f->depe_nombre,$f->depe_depende,$f->depe_tipo,$f->depe_recibetramite];
                }
                return $r;
            }break;
        }

    }

    public function edit($id)
    {

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


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
