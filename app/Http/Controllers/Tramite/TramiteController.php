<?php

namespace App\Http\Controllers\Tramite;
use App\ComunicacionInterna;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Dependencia;
use App\TipoDocumento;
use App\TipoDocumentoCorrel;
use App\Archivador;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Auth;
use DB;

class TramiteController extends Controller
{
    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth', ['except' => ['buscarExpedienteModal','buscarModal','buscarDigital','buscarDocExterno']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/tramite/inicio');
    }

    public function usuario(Request $request)
    {

         return view('tramite.administracion.usuarios');
    }

    public function printJsonVuex()
    {
        $vidaEnMinutos = 15;
        $return = [
            'dependencias'      => (new UnidadOrganicaController())->obtenerUnidadOrganica(new Request()),
            'tiposDocumentos'   => (new TipoDocumentoController())->getTipos(new Request()),
            'dependenciaUser'   => (new UnidadOrganicaController())->obtenerMiUnidadOrganica(),
            'usersOfDependencia'=> (new UsuarioController())->obtenerUserDependenciaActivo(new Request()),
            'imagenes'          =>  ComunicacionInterna::select('id')
                ->where('fecha_inicio', '<=' ,\Carbon\Carbon::today())
                ->where('fecha_fin', '>=' ,\Carbon\Carbon::today())
                ->where('estado', '=' ,1)->get()
        ];

        $response = new \Illuminate\Http\Response($return, 200, array(
            'Cache-Control' => 'max-age='.($vidaEnMinutos*60).', public',
        ));

        $response->setLastModified(new \DateTime('now'));
        $response->setExpires(\Carbon\Carbon::now()->addMinutes($vidaEnMinutos));
        return $response;
    }

    public function printJsonVuexAdministrador()
    {
        $vidaEnMinutos = 30;
        $return = [
            'dependencias'      => (new UnidadOrganicaController())->obtenerUnidadOrganica(new Request()),
            'permisos'          => Permission::select('id',
                                                        'name',
                                                        'description')
                                                ->orderBy('id','asc')
                                                ->get()
                 ];

        $response = new \Illuminate\Http\Response($return, 200, array(
            'Cache-Control' => 'max-age='.($vidaEnMinutos*60).', public',
        ));

        $response->setLastModified(new \DateTime('now'));
        $response->setExpires(\Carbon\Carbon::now()->addMinutes($vidaEnMinutos));
        return $response;
    }

    public function entidades()
    {
        return view('tramite.administracion.entidades-externas');
    }

    public function unidades()
    {
        return view('tramite.administracion.unidadesOrganicas');
    }

    public function unidadesSedes()
    {
        return view('tramite.administracion.unidadesOrganicasSedes');
    }

    public function dependencias()
    {
        return view('tramite.administracion.dependencias');
    }

    public function editDependenciasSedes()
    {
        $dependencias=Dependencia::find(Auth::user()->depe_id);

        return view('tramite.administracion.dependenciasSedes',['dependencia'=>$dependencias->depe_depende]);
    }

    public function correlativos()
    {

        return view('tramite.administracion.correlativos');
    }

    public function correlativosDependencia()
    {

        return view('tramite.administracion.correlativosDependencia');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function buscador()
    {

        return view('tramite.buscar.documentos');
    }

    public function buscarModal($id)
    {

        return view('tramite.buscar.verDocumentoModal',['iddocumento'=>$id]);
    }

    public function buscarExpedienteModal($id)
    {
        return view('tramite.buscar.verExpedienteModal', ['iddocumento'=>$id]);
    }

    public function buscarDigital()
    {
        return view('tramite.buscar.buscarDigital');
    }

    public function buscarDocExterno()
    {
        return view('tramite.buscar.buscarDocExterno');
    }

    public function recepcionDocumento()
    {

        return view('tramite.tramiteVarios.recepcionDocumento');
    }

    public function liberarDocCas()
    {
        return view('tramite.tramiteVarios.liberarDocCas');
    }

    public function solicitarPapeleta()
    {

        return view('tramite.tramiteVarios.solicitarPapeleta');
    }

    public function obtenerDependenciaRecursosHumanos()
    {
        $dependencias=Dependencia::find(Auth::user()->depe_id);

        $recursos = Dependencia::select('td2.iddependencia',
                                        'td2.depe_nombre')
                                        ->join('tram_dependencia AS td2', 'td2.depe_depende', '=', 'tram_dependencia.iddependencia')
                                        ->where('td2.depe_depende','=',$dependencias->depe_depende)
                                        ->where('td2.depe_rrhh','=',1)
                                        ->orderBy('iddependencia','asc');
            if($recursos = $recursos->first()){
                return json_encode((Object)["recursos"=>$recursos,"status"=>true]);
            }else{
                return json_encode((Object)["recursos"=>[],"status"=>false]);
            }

    }

    public function papeletaPendiente()
    {

        return view('tramite.tramiteVarios.autorizarPapeleta');
    }

    public function papeletasAutorizadas(Request $request)
    {
        return $this->papeletaPendiente($request);
    }

    public function papeletasSolicitadas()
    {
        return view('tramite.tramiteVarios.supervisarPapeleta');
    }

    public function papeletasUsadas(Request $request)
    {
        return $this->papeletasSolicitadas($request);
    }

    public function cambiarContrasenia()
    {

        $user=User::select('id',
                            'adm_name',
                            'adm_lastname',
                            'adm_cargo',
                            'adm_inicial',
                            'adm_email',
                            'adm_dni',
                            'adm_correo',
                            'adm_telefono')
                    ->where('id','=',Auth::user()->id)
                    ->first();

        return view('tramite.tramiteVarios.cambiarContrasenia',['user'=>$user]);
    }

    public function primerLogeo()
    {
        $user=User::select('id',
                            'adm_name',
                            'adm_lastname',
                            'adm_cargo',
                            'adm_inicial',
                            'adm_email',
                            'adm_dni',
                            'adm_correo',
                            'adm_telefono')
                    ->where('id','=',Auth::user()->id)
                    ->first();

        return view('tramite.primerLogeo',['user'=>$user]);
    }

    public function create(Request $request)
    {
        return $this->usuario($request);
    }

    public function createEntidad(Request $request)
    {
        return $this->entidades($request);
    }

    public function createUnidades(Request $request)
    {
        return $this->unidades($request);
    }

    public function createDependencias(Request $request)
    {
        return $this->dependencias($request);
    }

    public function createPapeleta(Request $request)
    {
        return $this->solicitarPapeleta($request);
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
    public function edit(Request $request, $id)
    {
        if(Dependencia::find(Auth::user()->depe_id)->depe_depende==Dependencia::find(User::find($id)->depe_id)->depe_depende)
            return $this->usuario($request);
        else
            return redirect()->route('tramite.administrador.usuario');
    }

    public function editEntidad(Request $request, $id)
    {
        return $this->entidades($request);
    }

    public function editUnidades(Request $request)
    {
        return $this->unidades($request);
    }

    public function editUnidadesSedes(Request $request, $id)
    {
        if(Dependencia::find(Auth::user()->depe_id)->depe_depende==Dependencia::find(Dependencia::find($id)->iddependencia)->depe_depende)
            return $this->unidadesSedes($request);
        else
            return redirect()->route('tramite.administrador.unidadesSedes');
    }

    public function editDependencias(Request $request, $id)
    {
        return $this->dependencias($request);
    }

    public function editPapeleta(Request $request, $id)
    {
        return $this->solicitarPapeleta($request);
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
