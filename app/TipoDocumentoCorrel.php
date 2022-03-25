<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TipoDocumentoCorrel
 *
 * @property int $id
 * @property int $tdco_idtipodocumento
 * @property int $tdco_iddependencia
 * @property int|null $tdco_idusuario
 * @property int $tdco_periodo
 * @property int $tdco_numero
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel whereTdcoIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel whereTdcoIdtipodocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel whereTdcoIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel whereTdcoNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel whereTdcoPeriodo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TipoDocumentoCorrel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TipoDocumentoCorrel extends Model
{
    
   protected $table='tram_tipodocumento_correl';
   protected $primaryKey='id';
    
    protected $fillable=[
        'tdco_idtipodocumento',
        'tdco_iddependencia',
        'tdco_idusuario',
        'tdco_periodo',
        'tdco_numero'
    ];
    
    protected $guarded=[];
    public static function addCorrelativo(Documento $doc, $idCorrelativo){
        $corr               = ($idCorrelativo==null)?new TipoDocumentoCorrel():TipoDocumentoCorrel::find($idCorrelativo);

        if($idCorrelativo==null)
        {
            $corr->tdco_periodo         = substr($doc->docu_fecha_doc,0,4);
            $corr->tdco_idtipodocumento = $doc->docu_idtipodocumento;
            $corr->tdco_iddependencia   = $doc->docu_iddependencia;
            $corr->tdco_idusuario       = $doc->docu_tipo==1?$doc->docu_idusuario:null;
        }
        $corr->tdco_numero              = $doc->docu_numero_doc+1;
        $corr->save();
    }
}
