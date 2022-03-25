<?php

namespace App\Models\MesaElectronica;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'status' =>'boolean'
    ];
}
