<?php

namespace App\_clases\proyectos\tools\certificar;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\tools\certificar\Documento
 *
 * @property int $id
 * @property string|null $doc_documento
 * @property string|null $doc_fecha
 * @property string|null $doc_oficina
 * @property int|null $doc_reg_sisgedo
 * @property int|null $doc_exp_sisgedo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento whereDocDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento whereDocExpSisgedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento whereDocFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento whereDocOficina($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento whereDocRegSisgedo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\certificar\Documento whereId($value)
 * @mixin \Eloquent
 */
class Documento extends Model
{

    protected $table='proy_tools_certificacion_documento';

    public $timestamps=false;
}
