<?php

namespace App\_clases\siaf\reportes;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

/**
 * App\_clases\siaf\reportes\Asignacion
 *
 * @property string|null $ANO_EJE
 * @property string|null $SEC_EJEC
 * @property string|null $SEC_NOTA
 * @property string|null $SEC_FUNC
 * @property string|null $FUENTE_FINANC
 * @property string|null $ID_CLASIFI
 * @property float|null $DE
 * @property float|null $A
 * @property string|null $NOTAS
 * @property string|null $FECHA
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereDE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereFECHA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereFUENTEFINANC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereIDCLASIFI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereNOTAS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereSECEJEC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereSECFUNC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\siaf\reportes\Asignacion whereSECNOTA($value)
 * @mixin \Eloquent
 */
class Asignacion extends Model
{
    protected $table = 'siaf_wasignacion';

    public $timestamps = false;

    public static function getAsignacionResumen($anio, $oficina = 0, $act_proy = 'all', $sec_ejec)
    {
        $oficinas = [
        ];
        $reporte  = Asignacion::from('siaf_wasignacion AS a')
            ->select([
                DB::raw('Sum(monto_a-monto_de) AS monto'),
                'mes',
            ])
            ->where('a.sec_ejec', '=', $sec_ejec)
            ->where('a.ano_eje', '=', $anio)
            ->groupBy('mes')
            ->orderBy('mes', 'asc');

        if ($act_proy != 'all') {
            $reporte->join('siaf_meta AS m', function (JoinClause $join) {
                return $join
                    ->on('m.ano_eje', '=', 'a.ano_eje')
                    ->on('m.sec_ejec', '=', 'a.sec_ejec')
                    ->on('m.sec_func', '=', 'a.sec_func');
            })->whereIn('m.act_proy', explode(',', $act_proy));
        }
        if ($oficina != null) {
            $reporte
                ->leftJoin('proy_presupuesto', function ($leftJoin) {
                    $leftJoin->on('a.ano_eje', '=', 'proy_presupuesto.proy_siaf_anio')
                        ->on('a.sec_ejec', '=', 'proy_presupuesto.proy_sec_ejec')
                        ->on('a.sec_func', '=', 'proy_presupuesto.proy_siaf_sec_func');
                })
                ->where('proy_tram_dependencia', '=', $oficina);
        }

        $reporte = $reporte->get();
        $return  = [];
        $now= Carbon::now();
        $max = ($anio==$now->year)?$now->month:12;
        for ($i = 0; $i < $max; $i++) {
            $return[] = (Object)['monto' => $reporte->where('mes', '=', $i + 1)->sum('monto'), 'mes' => $i+1];
        }
        return $return;
    }
}
