<?php

namespace App\Models\Assistance;

use App\User;
use App\Dependencia;
use App\Models\Assistance\AssingSchedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    protected $fillable = [
        'entry',
        'user_id',
        'dependencia_id',
        'validate',
        'created_ip',
        'updated_ip',
        'entry_time',
        'output_time',
        'created_by',
        'updated_by',
    ];
    protected $hidden = [
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
    protected $casts = [
      'validate' =>'boolean',
      'entry' => 'datetime'
    ];
    protected $appends = ['status'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id','adm_name','adm_lastname','adm_dni');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_id')->select('iddependencia','depe_nombre','depe_depende');
    }
    public function getStatusAttribute()
    {
        if ($this->entry_time != null) {
            
            $minutes = auth()->user()->dependencia->sede->depe_minuto_tolerancia != null?auth()->user()->dependencia->sede->depe_minuto_tolerancia:10;

            $ingreso = new Carbon($this->entry);
            $horario = new Carbon($this->entry_time);
            
            return $horario->diffInMinutes($ingreso->isoFormat('HH:mm:ss'), false) <= $minutes?true:false;
        } else {
            return null;
        }
    }
}
