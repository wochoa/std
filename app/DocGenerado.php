<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DocGenerado
 *
 * @property int $id
 * @property string|null $dgen_html
 * @property mixed|null $dgen_datos
 * @property int|null $dgen_idadmin
 * @property int|null $dgen_iddependencia
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado whereDgenDatos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado whereDgenHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado whereDgenIdadmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado whereDgenIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocGenerado whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DocGenerado extends Model
{
    protected $table = 'tram_doc_generado';
    //


    protected $casts = [
        'dgen_referencias'  => 'array',
        'dgen_derivaciones' => 'array',
    ];

    public function getDatos()
    {
        return json_decode($this->dgen_datos);
    }

    public function getDocumento()
    {
        $datos = json_decode($this->dgen_datos);
        if (isset($datos->documento->iddocumento) && $datos->documento->iddocumento != null)
            return Documento::find($datos->documento->iddocumento);
        else
            return (new Documento())->fill((array)$datos->documento);
    }
    
    public function getDocumentoForEdit()
    {
        return $this->getDocumento()->getForDocumento();
    }

    public function getForDocGenerado()
    {
        $datos = json_decode($this->dgen_datos);
        $datos->documento = $this->getDocumentoForEdit();
        return json_encode((Object)[
            'id'                 => $this->id,
            'dgen_html'          => $this->dgen_html,
            'dgen_datos'         => $datos,
            'dgen_derivaciones'  => $this->dgen_derivaciones,
            'dgen_referencias'    => $this->dgen_referencias,
            'dgen_idadmin'       => $this->dgen_idadmin,
            'dgen_iddependencia' => $this->dgen_iddependencia,
        ]);
    }


}
