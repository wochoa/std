<?php

namespace App\_clases\proyectos\plan\cadena_funcional;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\_clases\proyectos\plan\cadena_funcional\Funcion
 *
 * @property string|null $ANO_EJE
 * @property string|null $FUNCION
 * @property string|null $NOMBRE
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Funcion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Funcion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Funcion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Funcion whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Funcion whereFUNCION($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Funcion whereNOMBRE($value)
 * @mixin \Eloquent
 */
class Funcion extends Model
{
    protected $table = 'siaf_funcion';

    //protected $primaryKey='componente_id';

    public $timestamps = false;

    public static function getComponentesToSelect()
    {
        return Funcion::select(['funcion', 'nombre'])
            ->where('ano_eje', '=', Carbon::now()->year)
            ->orderBy('funcion','asc')
            ->get();
    }
}
