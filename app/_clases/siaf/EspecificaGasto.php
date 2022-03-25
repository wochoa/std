<?php

namespace App\_clases\siaf;

use DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EspecificaGasto extends Model
{
    protected $table = 'siaf_especifica';

    public $timestamps = false;

    public static function getEspecificaGasto()
    {
        $especificas = [];
        $esp = EspecificaGasto::select([
            DB::RAW("CONCAT(tipo_transaccion,'.',generica,'.',subgenerica,'.',subgenerica_det,'.',especifica) as clasifi"),
            'descripcion',
        ])
            ->where('ano_eje', '=', Carbon::now()->year)
            ->where('tipo_transaccion', '<>', 0)
            ->orderBy('descripcion','asc');
        foreach ($esp->get() as $data) {
            $especificas[$data->clasifi] = $data->descripcion;
        }
        return $especificas;
    }
}
