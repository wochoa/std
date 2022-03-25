<?php

namespace App\_clases\proyectos;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Response;

/**
 * App\_clases\proyectos\ProyectoInforme
 *
 * @property int $id
 * @property int|null $id_proyecto
 * @property string|null $inf_descripcion
 * @property array|null $inf_archivos
 * @property string|null $inf_path
 * @property int|null $id_admin
 * @property string|null $inf_cordenadas
 * @property int|null $inf_estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereIdAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereIdProyecto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereInfArchivos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereInfCordenadas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereInfDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereInfEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereInfPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\ProyectoInforme whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProyectoInforme extends Model
{
    protected $table = 'proy_informe';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // protected $casts = [
    //     'inf_archivos'               =>'array'
    // ];

    public static function getImagen($id, $id_proy_informe, $ancho, $alto)
    {
        $file_select = File::where('id', '=', $id)
            ->where('id_proy_informe', '=', $id_proy_informe)
            ->first();

        $path = explode('.', $file_select->file_url);
        $vidaEnMinutos = 15;
        $tmb = $ancho != null && $alto != null;
        $file = ($tmb) ? $path[0] . 'tmb_' . $ancho . 'x' . $alto . '.' . $path[1] : ($file_select->file_url);

        $exists = Storage::disk('proyectos')->exists($file);
        if (!$exists && $tmb) {
            $imagenOri = Storage::disk('proyectos')->get($file_select->file_url);
            $imagenTumb = Image::make($imagenOri);

            $anchura = $imagenTumb->width();
            $altura = $imagenTumb->height();
            $relacionAncho = $anchura / $ancho;
            $relacionAlto = $altura / $alto;
            if ($relacionAlto > $relacionAncho && $relacionAlto > 1)
                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $imagenTumb->resize(null, $alto, function ($constraint) {
                    $constraint->aspectRatio();
                });
            else if ($relacionAncho > 1)
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $imagenTumb->resize($ancho, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            Storage::disk('proyectos')->put($file, $imagenTumb->encode('jpg', 80));
            $url = Storage::disk('proyectos')->get($file);
        } else {
            $url = Storage::disk('proyectos')->get($file);
        }

        $response = Response::make($url, 200, ['Content-Type'  => Storage::disk('proyectos')->getMimeType($file),
                                               'Cache-Control' => 'max-age=' . ($vidaEnMinutos * 60) . ', public',
        ]);
        $response->setLastModified(new \DateTime('now'));
        $response->setExpires(\Carbon\Carbon::now()->addMinutes($vidaEnMinutos));
        return $response;


    }

}
