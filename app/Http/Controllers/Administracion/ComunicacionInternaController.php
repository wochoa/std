<?php

namespace App\Http\Controllers\Administracion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ComunicacionInterna;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Auth;

class ComunicacionInternaController extends Controller
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
        return ComunicacionInterna::select('id',
                                            'id_solicitante',
                                            'sustento',
                                            'imagen',
                                            'fecha_inicio',
                                            'fecha_fin',
                                            'estado')
                                        ->orderBy('id','desc')
                                        ->paginate(10);
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
       
            $publicacion                  =($request->id==null||$request->id=='null')?new ComunicacionInterna():ComunicacionInterna::find($request->id);
            $publicacion->sustento          = $request->sustento;
            $publicacion->id_solicitante    = $request->id_solicitante;
            $publicacion->fecha_inicio      = $request->fecha_inicio;
            $publicacion->fecha_fin         = $request->fecha_fin;
            $publicacion->estado            = $request->estado;
            $publicacion->save();
            if ($request->hasFile('imagen')){
                //$filenametostore        = $request->file('imagen')->getClientOriginalName();
                $extension              = $request->file('imagen')->getClientOriginalExtension();
                //$size                   = $request->file('imagen')->getSize();
                $anio                   =    substr($request->fecha_inicio,0, 4);
                $mes                    =    substr($request->fecha_inicio,5,2);

                $file_name =  '\\'.$anio.'\\'.$mes.'\\'.$publicacion->getIdString().'.'.$extension;
                $maxiAncho          = 720;
                $maxiAlto           = 482;
                $imagen     = Image::make($request->file('imagen'));
                $anchura    = $imagen->width();
                $altura     = $imagen->height();
                $relacionAncho  =   $anchura/$maxiAncho;
                $relacionAlto   =   $altura/$maxiAlto;
                if($relacionAlto>$relacionAncho&&$relacionAlto>1)
                    // resize the image to a height of 200 and constrain aspect ratio (auto width)
                    $imagen->resize(null, $maxiAlto, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                else if($relacionAncho>1)
                    // resize the image to a width of 300 and constrain aspect ratio (auto height)
                    $imagen->resize($maxiAncho, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                Storage::disk('imagenes')->put($file_name, $imagen->encode('jpg',80));
                //$imagen->save(Storage::disk('imagenes'), $file_name);
                $publicacion->imagen = $file_name;               
            }
            $publicacion->save();
            return $publicacion; 
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ComunicacionInterna::find($id)->getForComunicacionInterna();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function printImagenes($id)
    {
        
        return ComunicacionInterna::find($id)->getImagen();
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
