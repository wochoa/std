<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Response;   

/**
 * App\ComunicacionInterna
 *
 * @property int $id
 * @property int|null $id_solicitante
 * @property string|null $sustento
 * @property string|null $imagen
 * @property string|null $fecha_inicio
 * @property string|null $fecha_fin
 * @property int|null $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereFechaFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereFechaInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereIdSolicitante($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereImagen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereSustento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ComunicacionInterna whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ComunicacionInterna extends Model
{
    protected $table='comunicacion_interna';

    protected $primaryKey='id';

    public function getIdString()
    {
        return str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function getForComunicacionInterna()
    {
        return json_encode((Object)[
            'id'=>$this->id,
            'id_solicitante'=>$this->id_solicitante,
            'sustento'=>$this->sustento,
            'imagen'=>$this->imagen,
            'fecha_inicio'=>$this->fecha_inicio,
            'fecha_fin'=>$this->fecha_fin,
            'estado'=>$this->estado
        ]);
    }

    public function getImagen(){
        $vidaEnMinutos = 15;
        $url = Storage::disk('imagenes')->get($this->imagen);
        $response = Response::make($url,200,['Content-Type' => Storage::disk('imagenes')->getMimeType($this->imagen), 'Cache-Control' => 'max-age='.($vidaEnMinutos*60).', public']);

        $response->setLastModified(new \DateTime('now'));
        $response->setExpires(\Carbon\Carbon::now()->addMinutes($vidaEnMinutos));
        return $response;

    }
}
