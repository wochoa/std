<?php

namespace App\_clases\proyectos\plan;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//use App\_clases\proyectos\plan\cadena_funcional\Componente;

/**
 * App\_clases\proyectos\plan\Componente
 *
 * @property int $id
 * @property int $comp_programa
 * @property int $comp_prod_proy
 * @property int $comp_act_al_obra
 * @property int $comp_funcion
 * @property int $comp_division_funcional
 * @property int $comp_grupo_funcional
 * @property int $comp_meta
 * @property int $comp_finalidad
 * @property string $comp_nombre
 * @property float|null $comp_monto
 * @property float|null $comp_acumulado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\_clases\proyectos\plan\Insumo[] $insumos
 * @property-read int|null $insumos_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompActAlObra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompAcumulado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompDivisionFuncional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompFinalidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompFuncion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompGrupoFuncional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompProdProy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereCompPrograma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\Componente whereId($value)
 * @mixin \Eloquent
 */
class Componente extends Model
{

    protected $table='proy_plan_componente';
    public $timestamps=false;

    protected $casts = [
        'id'                            =>'integer',
        'comp_prod_proy'                =>'integer',
        'comp_act_al_obra'              =>'integer',
        'comp_meta'                     =>'integer',
        'comp_finalidad'                =>'integer',
        'comp_monto'                    =>'double'
    ];

    public static function getComponentesToSelect($proy){
        $componentes = [];
        $comp = Componente::where('comp_prod_proy', '=', $proy);
        foreach ($comp->get() as $data){
            $componentes[$data->id]=$data->comp_nombre;
        }
        return $componentes;
    }
    public function getCF(){
        return $this->getPrograma().".".
            $this->getProd_proy().".".
            $this->getAct_al_obra().".".
            $this->getFuncion().".".
            $this->getDivision_funcional().".".
            $this->getGrupo_funcional().".".
            $this->getMeta().".".
            $this->getFinalidad();
    }
    public function getPrograma(){
        return sprintf("%04s",$this->comp_programa);
    }
    public function getProd_proy(){
        return sprintf("%07s",$this->comp_prod_proy);
    }
    public function getAct_al_obra(){
        return sprintf("%07s",$this->comp_act_al_obra);
    }
    public function getFuncion(){
        return sprintf("%04s",$this->comp_funcion);
    }
    public function getDivision_funcional(){
        return sprintf("%03s",$this->comp_division_funcional);
    }
    public function getGrupo_funcional(){
        return sprintf("%04s",$this->comp_grupo_funcional);
    }
    public function getMeta(){
        return sprintf("%05s",$this->comp_meta);
    }
    public function getFinalidad(){
        return sprintf("%07s",$this->comp_finalidad);
    }
    public function insumos()
    {
        return $this->hasMany('App\_clases\proyectos\plan\Insumo');
    }
    public static function getComponentesForShow(){
        /*$cmp = new Componente();
        $componentes = [];
        $mytime =  Carbon::now();
        $comp = $cmp::select(['COMPONENTE', 'NOMBRE'])->where('ANO_EJE', '=', $mytime->year)->whereIn('TIPO_COMPO', [ 4, 6]);
        foreach ($comp->get() as $data){
            $componentes[$data->COMPONENTE]=$data->NOMBRE;
        }
        return $componentes;*/
    }
}
