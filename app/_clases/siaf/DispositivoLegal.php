<?php

namespace App\_clases\siaf;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DispositivoLegal extends Model
{
    protected $table = 'siaf_dispositivos_legales';

    public $timestamps = false;

    public static function getDispositivoLegal()
    {
        return DispositivoLegal::select(['dispositivo_legal', 'nombre'])
            ->where('ano_eje','=',Carbon::now()->year)
            ->orderBy('dispositivo_legal','asc')
            ->get();
    }
}
