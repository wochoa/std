<?php

namespace App\_clases\proyectos\plan\cadena_funcional;

use Cache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\plan\cadena_funcional\Componente
 *
 * @property string|null $ANO_EJE
 * @property string|null $COMPONENTE
 * @property string|null $TIPO_COMPO
 * @property string|null $NOMBRE
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Componente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Componente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Componente query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Componente whereANOEJE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Componente whereCOMPONENTE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Componente whereNOMBRE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Componente whereTIPOCOMPO($value)
 * @mixin \Eloquent
 */
class Componente extends Model
{

// esta tabla representa el componente de la cadena funcional
    protected $table='siaf_componente_nombre';

    //protected $primaryKey='componente_id';

    public $timestamps=false;
    protected static $componentesSelect;
    protected static $componentesShow;
    public static function getComponentesToSelectCached(){
        return Componente::$componentesSelect = Cache::remember('componentes_select', 3600, function() {
            return Componente::getComponentesToSelect();
        });
    }
    public static function getComponentesForShowCached(){
        return Componente::$componentesShow = Cache::remember('componentes_show', 3600, function() {
            return Componente::getComponentesForShow();
        });
    }
    public static function getComponentesToSelect(){
        $componentes = [];
        $mytime =  Carbon::now();
        $comp = Componente::select(['componente', 'nombre'])->where('ano_eje', '=', $mytime->year)->where('tipo_componente', '<>', '0');
        //$comp = Componente::select(['componente', 'nombre'])->where('tipo_componente', '<>', '0')->groupBy('componente');
        foreach ($comp->get() as $data){
            $componentes[$data->componente]=$data->componente.' - '.$data->nombre;
        }
        return $componentes;
    }
    public static function getComponentesForObras(){
        $componentes = [];
        $mytime =  Carbon::now();
        $comp = Componente::select(['componente', 'nombre'])->where('ano_eje', '=', $mytime->year)->whereIn('tipo_componente', [ 4, 6]);
        //$comp = Componente::select(['componente', 'nombre'])->whereIn('tipo_componente', [ 2, 4, 5, 6])->groupBy('componente');
        foreach ($comp->get() as $data){
            $componentes[$data->componente]=$data->componente.' - '.$data->nombre;
        }
        return $componentes;
    }
    public static function getComponentesForShow(){
        $componentes = [];
        $mytime =  Carbon::now();
        $comp = Componente::select(['componente', 'nombre'])->where('ano_eje', '=', $mytime->year)->whereIn('tipo_componente', [ 4, 6]);
        //$comp = Componente::select(['componente', 'nombre'])->whereIn('tipo_componente', [ 2, 4, 5, 6])->groupBy('componente');
        //dd($comp->toSql());
        foreach ($comp->get() as $data){
            $componentes[$data->componente]=$data->nombre;
        }
        return $componentes;
    }

    public static function getComponenteNombre()
    {
        return Componente::select(['componente', 'nombre'])
            ->where('ano_eje', '=', Carbon::now()->year)
            ->orderBy('componente','asc')
            ->get();
    }
}
