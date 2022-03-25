<?php

namespace App\_clases\proyectos\analitico;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\analitico\Componente
 *
 * @property int $componente_id
 * @property string|null $comp_nombre_corto
 * @property string|null $comp_nombre
 * @property string|null $comp_oficina
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Componente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Componente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Componente query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Componente whereCompNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Componente whereCompNombreCorto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Componente whereCompOficina($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\analitico\Componente whereComponenteId($value)
 * @mixin \Eloquent
 */
class Componente extends Model
{

    protected $table='proy_siaf_componente';

    protected $primaryKey='componente_id';

    public $timestamps=false;
    public static function getComponentesToSelect(){
        $componentes = [];
        $comp = Componente::select(['componente_id', 'comp_nombre_corto', 'comp_nombre']);
        foreach ($comp->get() as $data){
            $componentes[$data->componente_id]=$data->comp_nombre;
        }
        return $componentes;
    }
}
