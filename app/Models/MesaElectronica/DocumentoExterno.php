<?php

namespace App\Models\MesaElectronica;

use App\File;
use App\Operacion;
use App\Dependencia;
use App\TipoDocumento;
use Illuminate\Database\Eloquent\Model;

class DocumentoExterno extends Model
{
    protected $table = 'tram_documento_externo';
    protected $fillable = [
        "docu_digital",
        "docu_iddependencia",
        'id_dependencia',
        "docu_ruc",
        "docu_detalle",
        "docu_firma",
        "docu_cargo",
        "docu_idtipodocumento",
        "docu_fecha_doc",
        "docu_numero_doc",
        "docu_siglas_doc",
        "docu_folios",
        "docu_asunto",
        "docu_emailorigen",
        "docu_estado",
        "docu_idtdoc",
        "docu_numtdoc",
        "docu_idexma",
        "docu_domic",
        "docu_dni",
        "docu_telef",
        "docu_firma_electronica",
    ];
    protected $hidden = [
        'updated_at',
        'docu_archivo'
    ];
    protected $with = ['dependencia'];

    public function getIdString()
    {
        return str_pad($this->id, 8, "0", STR_PAD_LEFT);
    }
    public function docuArchivo()
    {
        return $this->hasMany(File::class, 'id_documento_externo', 'id');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'id_dependencia', 'iddependencia')->select('iddependencia','depe_nombre');
    }

    public function operacion()
    {
        return $this->hasMany(Operacion::class, 'oper_iddocumento', 'iddocumento')->with('dependenciaDestino')->where('oper_idtope', 2)->orderBy('idoperacion','asc');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'docu_idtipodocumento', 'idtdoc');
    }

}
