<?php

namespace App\_clases\proyectos\plan\cadena_funcional;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\plan\cadena_funcional\Meta
 *
 * @property int $componente_id
 * @property string|null $comp_nombre_corto
 * @property string|null $comp_nombre
 * @property string|null $comp_oficina
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Meta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Meta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Meta query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Meta whereCompNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Meta whereCompNombreCorto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Meta whereCompOficina($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\plan\cadena_funcional\Meta whereComponenteId($value)
 * @mixin \Eloquent
 */
class Meta extends Model
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
