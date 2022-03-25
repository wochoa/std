<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;

class routerController extends Controller
{
    //

    public function show(Request $request)
    {
        $ruta = \Route::getRoutes()->getByName($request->route);
        if ($ruta==null) return ['error'=>'la ruta no existe'];
        $uri = $ruta->uri;
        $max_parameters = substr_count($uri, '{');
        $parameters = [];
        for( $i = 1; $i<=$max_parameters; $i++)
            $parameters[]='%'.chr(114+$i);
        return ['name'=>$request->route,'route'=>(Object)['route'=>route($request->route,$parameters), 'can'=>Auth::user()->can('getRoute')]];
    }
}
