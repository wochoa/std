<?php

namespace App\Models\Assistance;

use Illuminate\Database\Eloquent\Model;

class AssingSchedule extends Model
{
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status'    => 'boolean',
        'type'      => 'integer'
    ];

    protected $fillable = [
        'status',
        'entry_time',
        'output_time',
        'type'
    ];
}
