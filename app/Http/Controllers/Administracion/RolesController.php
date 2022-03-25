<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Caffeinated\Shinobi\Models\Role;
use App\PermissionRole;

class RolesController extends Controller
{

    public function __construct()
    {
        //Aqui se verifica si esta logueado
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
       
     public function index()
    {
       return Role::select('id',
                            'name',
                            'slug',
                            'description',
                            'special')
                    ->orderBy('id','asc')
                    ->get();
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
        $roles              =(Object)$request->rol;
        $rol                = ($roles->id==null)? new Role():Role::find($roles->id);
        $rol->name          =$roles->name;
        $rol->slug          =$roles->slug;
        $rol->description   =$roles->description;
            if($roles->special===null){
                $rol->special       =null;
            }else{
                $rol->special       =($roles->special===1)?'all-access':'no-access';
            }
        $rol->save();
        
        $rol->permissions()->sync($request->idPermiso);

            /*foreach($request->idPermiso as $idPermiso => $permiso){
                if($permiso!=null){
                    $permiso        = (Object)$permiso;
                    if($permiso->value===true&&$permiso->id==null){
                        $rolPermiso                 =New PermissionRole;
                        $rolPermiso->permission_id  =$idPermiso;
                        $rolPermiso->role_id        =$rol->id;
                        $rolPermiso->save();
                    }elseif($permiso->value===false&&$permiso->id!=null){
                        PermissionRole::find($permiso->id)->delete();
                    }
                }
            }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->getForUpdateRol(Role::find($id));
        
    }

    public static function getForUpdateRol($rol)
    {
        $permisos=PermissionRole::select('permission_role.id', 'permission_id','name')
                                    ->join('permissions','permissions.id','=','permission_role.permission_id')
                                    ->where('role_id','=',$rol->id)
                                    ->get();

        return json_encode((Object)[
            'id'=>$rol->id,
            'name'=>$rol->name,
            'slug'=>$rol->slug,
            'description'=>$rol->description,
            'special'=>($rol->special==null)?null:(($rol->special=='all-access')?1:0),
            'permisos'=>$permisos,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function obtenerRoles()
    {
        return Role::select('id','name')
                                    ->orderBy('name','asc')
                                    ->get();
    }

    public function obtenerRolesDepe()
    {
        return Role::select('id','name')
                        ->whereIn('id', [3, 4, 5, 6, 7])
                        ->orderBy('name','asc')
                        ->get();
    }

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
