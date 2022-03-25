<?php

namespace App\_clases\proyectos\plan\cadena_funcional;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional
 *
 * @property string|null $ANO_EJE
 * @property string|null $PROGRAMA
 * @property string|null $NOMBRE
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional whereNOMBRE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\DivisionFuncional wherePROGRAMA($value)
 * @mixin \Eloquent
 */
class DivisionFuncional extends Model
{
    protected $table='siaf_programa_nombre';

    //protected $primaryKey='componente_id';

    public $timestamps=false;
    public static function getComponentesToSelect(){
        $componentes = [];
        $mytime =  Carbon::now();
        $comp = DivisionFuncional::select(['programa', 'nombre'])->where('ano_eje', '=', $mytime->year);
        foreach ($comp->get() as $data){
            $componentes[$data->programa]=$data->programa.' - '.$data->nombre;
        }
        return $componentes;
    }

    public static function getDivisionFuncional()
    {
        return DivisionFuncional::select(['programa', 'nombre'])
            ->where('ano_eje', '=', Carbon::now()->year)
            ->orderBy('programa','asc')
            ->get();
    }
}
