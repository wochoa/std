<?php

namespace App\_clases\proyectos\plan\cadena_funcional;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional
 *
 * @property string|null $ANO_EJE
 * @property string|null $SUB_PROGRA
 * @property string|null $NOMBRE
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional whereNOMBRE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\GrupoFuncional whereSUBPROGRA($value)
 * @mixin \Eloquent
 */
class GrupoFuncional extends Model
{
    protected $table='siaf_sub_programa_nombre';

    //protected $primaryKey='componente_id';

    public $timestamps=false;
    public static function getComponentesToSelect(){
        $componentes = [];
        $mytime =  Carbon::now();
        $comp = GrupoFuncional::select(['sub_programa', 'nombre'])->where('ano_eje', '=', $mytime->year);
        foreach ($comp->get() as $data){
            $componentes[$data->sub_programa]=$data->sub_programa.' - '.$data->nombre;
        }
        return $componentes;
    }

    public static function getGrupoFuncional()
    {
        return GrupoFuncional::select(['sub_programa', 'nombre'])
            ->where('ano_eje', '=',  Carbon::now()->year)
            ->orderBy('sub_programa','asc')
            ->get();
    }
}
