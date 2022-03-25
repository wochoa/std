<?php

namespace App\_clases\proyectos\plan\cadena_funcional;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\plan\cadena_funcional\Finalidad
 *
 * @property string|null $ANO_EJE
 * @property string|null $FINALIDAD
 * @property string|null $NOMBRE
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Finalidad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Finalidad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Finalidad query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Finalidad whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Finalidad whereFINALIDAD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Finalidad whereNOMBRE($value)
 * @mixin \Eloquent
 */
class Finalidad extends Model
{
    protected $table='siaf_finalidad';

    //protected $primaryKey='componente_id';

    public $timestamps=false;
    public static function getComponentesToSelect(){
        $componentes = [];
        $mytime =  Carbon::now();
        $comp = Finalidad::select(['finalidad', 'nombre'])->where('ano_eje', '=', $mytime->year);
        foreach ($comp->get() as $data){
            $componentes[$data->finalidad]=$data->finalidad.' - '.$data->nombre;
        }
        return $componentes;
    }
}
