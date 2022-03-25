<?php

namespace App\Models\Assistance;

use Illuminate\Database\Eloquent\Model;

class IpsRecognized extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    protected $fillable = [
        'id',
        'ip'
    ];
}
