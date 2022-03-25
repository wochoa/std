<?php

namespace App\Http\Controllers\Tramite;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\RoleUser;
use App\Dependencia;
use Auth;
use DB;
use Carbon\Carbon;
use Hash;
use Validator;

class UsuarioController extends Controller
{

    public function index(Request $request)
    {
        $with = $request->with ? $request->with : [];
        $select = $request->select ? $request->select : ['*'];
        if ($request->modeljs) {
            //un filtro segun la session
            $query = User::select($select)->with($with)
                ->where(function ($query) use ($request) {
                    //utilizamos filtrago dinamico de acuerdo a los parametro recibidos por el $request
                    User::filter($request, $query);
                });
            $query = User::joinWhere($request, $query);
            return $query->get();
        }
        $dependencias = Dependencia::find(Auth::user()->depe_id);

        $where = [];
        if ($request->id != null)
            $where[] = ['admin.id', '=', "$request->id"];
        if ($request->adm_dni != null)
            $where[] = ['adm_dni', '=', "$request->adm_dni"];
        if ($request->adm_email != null)
            $where[] = ['adm_email', '=', "$request->adm_email"];
        if ($request->adm_name != null)
            $where[] = ['adm_name', 'LIKE', "%$request->adm_name%"];
        if ($request->adm_lastname != null)
            $where[] = ['adm_lastname', 'LIKE', "%$request->adm_lastname%"];
        if ($request->adm_estado != null)
            $where[] = ['adm_estado', '=', "$request->adm_estado"];
        if ($request->depe_nombre != null)
            $where[] = ['td1.iddependencia', '=', "$request->depe_nombre"];
        if ($request->tipo == 1)
            $where[] = ['td2.iddependencia', '=', $dependencias->depe_depende];
        if ($request->tipo == 1)
            $where[] = ['adm_email', '<>', 'ADMIN'];

        if ($request->adm_tipo != null) {

            $roles = RoleUser::select('role_user.id', 'role_id', 'user_id')
                ->where('role_user.role_id', '=', $request->adm_tipo)
                ->get();

            $arr = [];
            foreach ($roles as $id => $rol) {
                $arr[] = $rol->user_id;
            }
            return User::select([
                'admin.id',
                'adm_name',
                'adm_lastname',
                'adm_cargo',
                'adm_email',
                'adm_correo',
                'td1.depe_nombre as oficina',
                'td2.depe_nombre as dependencia',
                'adm_estado',
                'adm_dni',
                'admin.created_at',
            ])
                ->join('tram_dependencia as td1', 'depe_id', '=', 'td1.iddependencia')
                ->leftJoin('tram_dependencia as td2', 'td1.depe_depende', '=', 'td2.iddependencia')
                ->where('id', '<>', 1)
                ->whereIn('admin.id', $arr)
                ->where($where)
                ->orderBy('id', 'asc')
                ->paginate(15);
        } else {
            return User::select([
                'admin.id',
                'adm_name',
                'adm_lastname',
                'adm_cargo',
                'adm_email',
                'adm_correo',
                'td1.depe_nombre as oficina',
                'td2.depe_nombre as dependencia',
                'adm_estado',
                'adm_dni',
                'admin.created_at',
            ])
                ->join('tram_dependencia as td1', 'depe_id', '=', 'td1.iddependencia')
                ->leftJoin('tram_dependencia as td2', 'td1.depe_depende', '=', 'td2.iddependencia')
                ->where('id', '<>', 1)
                ->where($where)
                ->orderBy('id', 'asc')
                ->paginate(15);
        }

    }
    public function usersforDerivar(Request $request)
    {
        return User::select('id', DB::raw('concat(adm_name, " ",adm_lastname) as nombre'), 'adm_cargo', 'adm_inicial')
            ->where('depe_id', '=', $request->depe_id)
            ->where('adm_estado', '=', '1')
            ->get();
    }

    public function checkUsuario(Request $request)
    {
        $u = User::where('adm_email', '=', $request->adm_email)->where('id', '<>', $request->id)->get();

        if (count($u))
            return response()->json([
                'valid' => false,
                'data'  => [
                    'message' => 'Usuario ya existe!',
                ],
            ], 200);
        else
            return response()->json([
                'valid' => true,
                'data'  => [
                    'message' => 'Usuario disponible!',
                ],
            ], 200);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = (Object)$request->user;
        //creamos el usuario o obtenemos el usuario dependiendo si existe o no
        $user = User::select(['id', 'adm_email'])
            ->where('adm_email', '=', $users->adm_email)
            ->get();

        if (count($user) > 0 && $user[0]->id != $users->id) {
            return $user;
        } else {

            $usuario = ($users->id == null) ? new User() : User::find($users->id);
            $usuario->adm_name = $users->adm_name;
            $usuario->adm_lastname = $users->adm_lastname;
            $usuario->adm_inicial = $users->adm_inicial;
            $usuario->adm_email = $users->adm_email;
            if ($users->adm_password != null) {
                $usuario->adm_password = bcrypt($users->adm_password);
            }
            $usuario->adm_estado = $users->adm_estado;
            $usuario->adm_cargo = $users->adm_cargo;
            $usuario->adm_correo = $users->adm_correo;
            $usuario->adm_telefono = $users->adm_telefono;
            $usuario->adm_dni = $users->adm_dni;
            $usuario->adm_direccion = $users->adm_direccion;
            $usuario->adm_con_especialidad = $users->adm_con_especialidad;
            $usuario->depe_id = $users->depe_id;
            $usuario->adm_vigencia = $users->adm_vigencia;
            $usuario->adm_observacion = $users->adm_observacion;
            $usuario->adm_primer_logeo = $users->adm_primer_logeo;
            $usuario->save();

            $usuario->roles()->sync($request->valueRol);
        }

    }

    public function show($id)
    {
        return User::find($id)->getForUpdate();
    }

    public function cambiarContrasenia(Request $request)
    {
        $usuario = User::find($request->id);

        $usuario->adm_password = bcrypt($request->adm_password);
        if ($request->reset == 1) {
            $usuario->adm_primer_logeo = null;
        } else {
            $usuario->adm_primer_logeo = 1;
            $usuario->adm_name = $request->adm_name;
            $usuario->adm_lastname = $request->adm_lastname;
            $usuario->adm_dni = $request->adm_dni;
            $usuario->adm_correo = $request->adm_correo;
            $usuario->adm_telefono = $request->adm_telefono;
        }
        $usuario->save();
        return json_encode((Object)['status' => true]);
    }

    public function obtenerUserDependenciaActivo(Request $request)
    {
        switch ($request->tipo) {

            case '4' :
                {
                    $where = [
                        ['depe_id', '=', $request->depe_id],
                        ['adm_email', '<>', 'ADMIN'],
                    ];
                    return User::select([
                        'id',
                        DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                        'adm_cargo',
                        'adm_inicial',
                    ])
                        ->where($where)
                        ->orderBy('adm_name', 'ASC')
                        ->get();
                }
                break;
            case '5' :
                {
                    $where = [
                        ['depe_id', '=', $request->depe_id],
                        ['adm_email', '<>', 'ADMIN'],
                        ['adm_estado', 1],
                    ];
                    return User::select([
                        'id',
                        DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                        'adm_cargo',
                        'adm_inicial',
                    ])
                        ->where($where)
                        ->orderBy('adm_name', 'ASC')
                        ->get();
                }
                break;

            case '6' :
                {
                    $where = [
                        ['id', Auth::user()->id],
                    ];
                    return User::select(['id',
                        'adm_name',
                        'adm_lastname'])
                        ->where($where)
                        ->first();
                }
                break;
            case '7' :
                    {
                        $where = [
                            ['td1.depe_depende', '=', $request->depe_depende],
                            ['adm_email', '<>', 'ADMIN'],
                            ['adm_estado', 1],
                        ];
                        if ($request->iddependencia != null) {
                            $where[] = ['depe_id', $request->iddependencia];
                        }
                        return User::select([
                            'id',
                            DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                            'adm_dni',
                            'td1.depe_nombre as depe_nombre',
                        ])
                            ->join('tram_dependencia as td1', 'depe_id', '=', 'td1.iddependencia')
                            ->where($where)
                            ->orderBy('td1.depe_nombre', 'asc')
                            ->orderBy('adm_name','asc')
                            ->paginate(20);
                    }
                    break;
            default :
            {
                $user = User::select([
                    'id',
                    DB::raw("CONCAT(adm_name,' ',adm_lastname) as adm_name"),
                    'adm_cargo',
                    'adm_inicial',
                    'adm_estado',
                ])
                    ->where('depe_id', '=', Auth::user()->depe_id)
                    ->where('adm_email', '<>', 'ADMIN')
                    ->orderBy('adm_name', 'ASC')
                    ->get();
                $us = [];
                foreach ($user as $u) {
                    $us[] = (Object)[$u->id, $u->adm_name, $u->adm_cargo, $u->adm_inicial, $u->adm_estado];
                }
                return $us;

            }
        }

    }

    public function generarRolUser()
    {
        //rol=3, adm_tipo=1, 5 y null /tramite/usuarios/generarRolUser
        /*$user=User::select('id')
                    //->where('adm_tipo', '=', 1)
                    //->orWhereNull('adm_tipo')
                    ->get();

        foreach($user as $id=>$usuario){
            $rolUser            = new RoleUser();
            $rolUser->role_id   =3;
            $rolUser->user_id   =$usuario->id;
            $rolUser->save();
        }
        echo('terminado');*/
        //rol=2, adm_tipo=5 los administradores de las dependencias
        /*$user=User::select('id')
                        ->where('adm_tipo', '=', 5)
                        ->where('adm_estado','=',1)
                        //->where('adm_vigencia','>','2019-05-30')
                        ->get();

        foreach($user as $id=>$usuario){
        $rolUser            = new RoleUser();
        $rolUser->role_id   =2;
        $rolUser->user_id   =$usuario->id;
        $rolUser->save();
        }
        echo('terminado');*/
        //rol=4 Recepcionista de documentos externos adm_caseta=1
        /*$user=User::select('id')
                        ->where('adm_caseta', '=', 1)
                        ->where('adm_estado','=',1)
                        ->where('adm_vigencia','>','2019-05-30')
                        ->get();
        dd($user);
        foreach($user as $id=>$usuario){
        $rolUser            = new RoleUser();
        $rolUser->role_id   =4;
        $rolUser->user_id   =$usuario->id;
        $rolUser->save();
        }
        echo('terminado');*/


    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
