<?php

namespace App\Http\Controllers\Proy;

use App\File;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\Object_;
use App\_clases\proyectos\ProyectoInforme;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Storage;

class ProyectoInformeController extends Controller
{
    public function index(Request $request)
    {
        $informe =  ProyectoInforme::select([
            'proy_informe.id',
            'id_proyecto',
            'inf_descripcion',
            'a.id as id_admin',
            'proy_informe.created_at',
        ])
            ->leftJoin('admin as a', 'id_admin', '=', 'a.id')
            ->where('id_proyecto', '=', $request->id_proyecto)
            ->get();
        foreach ($informe as $id => $inf) {
            $digitales = File::select('id','file_url','file_name','file_tipo','file_mostrar','id_proy_informe','fecha')
                ->where('id_proy_informe','=',$inf->id)
                ->get();
            $informe[$id]->inf_archivos = $digitales;
        }
        return $informe;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $informe = ($request->id == null) ? new ProyectoInforme() : ProyectoInforme::find($request->id);

        $informe->inf_descripcion = $request->inf_descripcion;
        $informe->inf_estado = 0;
        $user = \Auth::id();
        $anio = date("Y");
        $path = '\\' . $anio . '\\' . $request->id_proyecto . '\\' . $user . '\\';
        if ($request->id == null && !$request->edit) {
            $informe->inf_cordenadas = $request->inf_cordenadas;
            $informe->id_proyecto = $request->id_proyecto;
            $informe->id_admin = $user;
            $informe->save();
            
            if (count($request->archivos)>0) {
                $this->guardarFile($request->archivos, $informe->id, $request->id_proyecto, $path);
            }

        }
        elseif ($request->id != null && $request->edit) {
            $informe->save();
            if (count($request->archivos)>0) {
                $this->guardarFile($request->archivos, $informe->id, $request->id_proyecto, $path);
            } else {
                $this->guardarFile($request->inf_archivos, $informe->id, $request->id_proyecto, $path);
            }
        }
            $digitales = File::select('id','file_url','file_name','file_tipo','file_mostrar','id_proy_informe','fecha')
                ->where('id_proy_informe','=',$informe->id)
                ->get();
            $informe->inf_archivos = $digitales;
        return $informe;
    }

    public function guardarFile(Array $archivos, $id, $id_proyecto, $path)
    {

        $return = [];
        foreach ($archivos as $archivo) {
            $archivo = (Object)$archivo;

            $fileProy = ($archivo->id == null || $archivo->id == 'null')? new File(): File::find($archivo->id);
            if ($archivo->file_url != null && $archivo->file_mostrar && $archivo->id == null) {
                $porcion = explode("/", $archivo->file_url)[1];

                $file   = $path.'\\'.$id_proyecto.'-'.$porcion;

                if (strpos($archivo->file_tipo, 'image') === 0) {

                    $maxiAncho = 1500;
                    $maxiAlto = 1500;
                    $archivosImagen = Storage::disk('proyectos')->get($archivo->file_url);
                    $imagen = Image::make($archivosImagen);

                    $anchura = $imagen->width();
                    $altura = $imagen->height();
                    $relacionAncho = $anchura / $maxiAncho;
                    $relacionAlto = $altura / $maxiAlto;
                    if ($relacionAlto > $relacionAncho && $relacionAlto > 1)
                        // resize the image to a height of 200 and constrain aspect ratio (auto width)
                        $imagen->resize(null, $maxiAlto, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    else if ($relacionAncho > 1)
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $imagen->resize($maxiAncho, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    Storage::disk('proyectos')->put($file, $imagen->encode('jpg', 80));
                    Storage::disk('proyectos')->delete($archivo->file_url);

                } else {

                    Storage::disk('proyectos')->move($archivo->file_url, $file);
                }

                $fileProy->file_url     = $file;
                $fileProy->file_name    = $archivo->file_name;
                $fileProy->file_tipo    = $archivo->file_tipo;
                $fileProy->file_mostrar = $archivo->file_mostrar;
                $fileProy->id_proy_informe = $id;
                $fileProy->fecha = $archivo->fecha;
                $fileProy->save();

            } elseif (!$archivo->file_mostrar) {
                Storage::disk('proyectos')->delete($archivo->file_url);
            } else {
                $fileProy->file_name    = $archivo->file_name;
                $fileProy->file_mostrar = $archivo->file_mostrar;
                $fileProy->save();
            }
        }
    }

    public function guardarTemporal(Request $request)
    {
        if ($request->hasFile('arch_archivo')) {
            $filenametostore = $request->file('arch_archivo')->getClientOriginalName();
            $extencion = explode('.', $filenametostore)[1];
            $filenametostore = 'temp/' . Str::random(15) . '.' . $extencion;

            Storage::disk('proyectos')->put($filenametostore, fopen($request->file('arch_archivo'), 'r+'));
            return $filenametostore;
        }

    }

    public function show($id)
    {
        //
    }

    public function printImagenesInforme(Request $request)
    {
        return ProyectoInforme::getImagen($request->id, $request->id_proy_informe, $request->tumbAncho, $request->tumbAlto);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
