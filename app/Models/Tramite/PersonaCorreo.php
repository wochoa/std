<?php

namespace App\Models\Tramite;

use App\Persona;
use App\PersonaJuridica;
use Illuminate\Database\Eloquent\Model;

class PersonaCorreo extends Model
{
    protected $table='tram_persona_correo';
    protected $fillable=[
        'persona_dni',
        'persona_ruc',
        'correo',
        'codigo',
        'estado',
    ];
    protected $hidden = [
        'codigo',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'estado' => 'integer'
    ];
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_dni', 'dni')->select(['dni','prenombres','apPrimer','apSegundo'])->withDefault();
    }
    public function ruc()
    {
        return $this->belongsTo(PersonaJuridica::class, 'persona_ruc', 'ddp_numruc')->select(['ddp_numruc','ddp_nombre'])->withDefault();
    }
}
