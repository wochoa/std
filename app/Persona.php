<?php

namespace App;

use App\Models\Tramite\PersonaCorreo;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Persona
 *
 * @property int $id
 * @property string|null $apPrimer
 * @property string|null $apSegundo
 * @property string|null $direccion
 * @property string|null $estadoCivil
 * @property string|null $foto
 * @property string|null $prenombres
 * @property string|null $restriccion
 * @property string|null $ubigeo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereApPrimer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereApSegundo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereEstadoCivil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona wherePrenombres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereRestriccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereUbigeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Persona whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Persona extends Model
{
    //
    protected $table='tram_persona';
    protected $fillable=[
        'apPrimer',
        'apPrimer',
        'direccion',
        'dni',
        'foto',
        'prenombres',
        'restriccion',
        'ubigeo'
    ];
    protected $hidden = ['id','foto','created_at','updated_at'];
    protected $guarded=[

    ];
    public function setData($data){
        $this->apPrimer     = $data->apPrimer;
        $this->apSegundo    = $data->apSegundo;
        $this->direccion    = $data->direccion;
        $this->estadoCivil  = $data->estadoCivil;
        $this->foto         = $data->foto;
        $this->prenombres   = $data->prenombres;
       /* $this->restriccion  = $data->restriccion;
        $this->ubigeo       = $data->ubigeo;*/
    }

    public function correos(){
        return $this->hasMany(PersonaCorreo::class, 'persona_dni', 'dni');
    }
    public function correosValidados(){
        return $this->hasMany(PersonaCorreo::class, 'persona_dni', 'dni')->where('estado', '=', 1);
    }
}
