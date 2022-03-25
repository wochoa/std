<?php

namespace App;

use App\Models\Tramite\PersonaCorreo;
use Illuminate\Database\Eloquent\Model;

class PersonaJuridica extends Model
{
    protected $table='tram_persona_juridica';
    protected $fillable = [
        'cod_dep',
        'cod_dist',
        'cod_prov',
        'ddp_ciiu',
        'ddp_doble',
        'ddp_estado',
        'ddp_fecact',
        'ddp_fecalt',
        'ddp_fecbaj',
        'ddp_flag22',
        'ddp_identi',
        'ddp_inter1',
        'ddp_lllttt',
        'ddp_mclase',
        'ddp_nombre',
        'ddp_nomvia',
        'ddp_nomzon',
        'ddp_numer1',
        'ddp_numreg',
        'ddp_numruc',
        'ddp_reacti',
        'ddp_refer1',
        'ddp_secuen',
        'ddp_tamano',
        'ddp_tipvia',
        'ddp_tipzon',
        'ddp_tpoemp',
        'ddp_ubigeo',
        'ddp_userna',
        'desc_ciiu',
        'desc_dep',
        'desc_dist',
        'desc_estado',
        'desc_flag22',
        'desc_identi',
        'desc_numreg',
        'desc_prov',
        'desc_tamano',
        'desc_tipvia',
        'desc_tipzon',
        'desc_tpoemp',
        'esActivo',
        'esHabido',
    ];

    public function correos(){
        return $this->hasMany(PersonaCorreo::class, 'persona_ruc', 'ddp_numruc');
    }
    public function correosValidados(){
        return $this->hasMany(PersonaCorreo::class, 'persona_ruc', 'ddp_numruc')->where('estado', '=', 1);
    }
}
