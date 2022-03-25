<?php

namespace App\Models\Assistance;

use App\User;
use App\Dependencia;
use Illuminate\Database\Eloquent\Model;

class Ballot extends Model
{
    protected $fillable = [
        'user_id',
        'dependencia_id',
        'departure_reason',
        'destination',
        'justification',
        'authorized',
        'updated_by',
    ];
    protected $hidden = [
        'updated_at'
    ];
    protected $casts = [
      'authorized' =>'boolean'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id','adm_name','adm_lastname','adm_dni');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_id')->select('iddependencia','depe_nombre','depe_depende');
    }
}
