<?php

namespace App\_clases\proyectos\tools\documento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\tools\documento\Documento
 *
 * @property int $id
 * @property int|null $td_asunto
 * @property string|null $td_asunto_txt
 * @property string|null $td_destinoN
 * @property string|null $td_destinoO
 * @property string|null $td_remitente
 * @property string|null $td_fecha
 * @property string|null $td_referencia
 * @property string|null $td_cc
 * @property string|null $td_contenido
 * @property string|null $td_expeSISGEDO
 * @property string|null $td_docSISGEDO
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdAsunto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdAsuntoTxt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdContenido($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdDestinoN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdDestinoO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdDocSISGEDO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdExpeSISGEDO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereTdRemitente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\tools\documento\Documento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Documento extends Model
{

    protected $table='tools_document';

}
