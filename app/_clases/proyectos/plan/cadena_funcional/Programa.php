<?php

namespace App\_clases\proyectos\plan\cadena_funcional;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{

    protected $table = 'siaf_programa_ppto_nombre';

    public $timestamps = false;

    public static function getProgramasNombre()
    {
        return Programa::select(['programa_ppto', 'nombre'])
            ->where('ano_eje', '=', Carbon::now()->year)
            ->orderBy('programa_ppto', 'asc')
            ->get();
    }
}
