<?php

namespace App\_clases\proyectos\tools\documento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\tools\documento\AsuntoDoc
 *
 * @property int $id
 * @property string|null $tda_nombre
 * @property string|null $tda_ruta_form
 * @property string|null $tda_datos
 * @property string|null $td_contenido
 * @property string|null $tda_destino
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc whereTdContenido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc whereTdaDatos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc whereTdaDestino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc whereTdaNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\AsuntoDoc whereTdaRutaForm($value)
 * @mixin \Eloquent
 */
class AsuntoDoc extends Model
{

    protected $table='tools_doc_asunto';

    public $timestamps=false;
}
