<?php

namespace App\_clases\siaf;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class ActProyNombre extends Model
{
    protected $table = 'siaf_act_proy_nombre';

    public $timestamps = false;

    public static function getActProyNombre($anio)
    {
        return ActProyNombre::select(['siaf_act_proy_nombre.ano_eje','siaf_act_proy_nombre.act_proy', 'siaf_act_proy_nombre.nombre'])
            ->join('siaf_wpresupuesto AS p',function (JoinClause $join) {
                return $join
                    ->on('siaf_act_proy_nombre.ano_eje',     '=','p.ano_eje')
                    ->on('siaf_act_proy_nombre.act_proy',  '=','p.act_proy');
            })
            ->where('p.ano_eje','=', $anio)
            ->groupBy('siaf_act_proy_nombre.act_proy')
            ->groupBy('siaf_act_proy_nombre.nombre')
            ->groupBy('siaf_act_proy_nombre.ano_eje')
            ->orderBy('siaf_act_proy_nombre.act_proy','asc')
            ->get();
    }
    public static function getTotalAnio()
    {
        // $anio = ActProyNombre::select(['siaf_act_proy_nombre.ano_eje',
        //     \DB::raw("COUNT(siaf_act_proy_nombre.act_proy) as act_proy")])
        //     ->join('siaf_wpresupuesto AS p',function (JoinClause $join) {
        //         return $join
        //             ->on('siaf_act_proy_nombre.ano_eje',     '=','p.ano_eje')
        //             ->on('siaf_act_proy_nombre.act_proy',  '=','p.act_proy');
        //     })
        //     //->where('p.ano_eje','=', '2019')
        //     //->groupBy('siaf_act_proy_nombre.act_proy')
        //     ->groupBy('siaf_act_proy_nombre.ano_eje')
        //     //->orderBy('siaf_act_proy_nombre.act_proy','asc')
        //     ->get();
        $anio = ActProyNombre::select(['siaf_act_proy_nombre.ano_eje','siaf_act_proy_nombre.act_proy'])
            ->join('siaf_wpresupuesto AS p',function (JoinClause $join) {
                return $join
                    ->on('siaf_act_proy_nombre.ano_eje',     '=','p.ano_eje')
                    ->on('siaf_act_proy_nombre.act_proy',  '=','p.act_proy');
            })
            ->groupBy('siaf_act_proy_nombre.act_proy')
            //->groupBy('siaf_act_proy_nombre.nombre')
            ->groupBy('siaf_act_proy_nombre.ano_eje')
            ->get();

        // $anio = $anio->groupBy(function ($item, $key) {
        //     return $item['act_proy'];
        // });
         $anio = $anio->groupBy(function ($item, $key) {
             return $item['ano_eje'];
         });

        //return $anio;

        $groupCount = $anio->map(function ($item, $key) {
            return collect($item)->count();
        });

        return $groupCount;
    }
}
