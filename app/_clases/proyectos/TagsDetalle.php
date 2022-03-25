<?php

namespace App\_clases\proyectos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\_clases\proyectos\TagsDetalle
 *
 * @property int $id
 * @property int|null $tag_anio
 * @property int|null $proyecto_id
 * @property int|null $tag_id
 * @property int|null $tag_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\TagsDetalle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\TagsDetalle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\TagsDetalle query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\TagsDetalle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\TagsDetalle whereProyectoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\TagsDetalle whereTagAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\TagsDetalle whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\TagsDetalle whereTagUser($value)
 * @mixin \Eloquent
 */
class TagsDetalle extends Model
{
    protected $table='proy_proy_tags_det';

    public $timestamps=false;

    public static function getToSelectedTypeHead($anio, $proy){
        $tags = [];
        $var = DB::table('proy_proy_tags_det AS t_d')
            ->select(['t.id', 't.tag_name', 't.tag_description'])
            ->join('proy_proy_tags AS t', 't.id', '=', 't_d.tag_id')
            ->where('t_d.proyecto_id', '=', $proy)
            ->where('t_d.tag_anio', '=', $anio)
            ->orderBy('t.tag_name', 'ASC');
        foreach ($var->get() as $tag){
            $tags[]=['id'=>$tag->id,'tag_name'=>$tag->tag_name,'tag_description'=>$tag->tag_description];
        }
        return $tags;
    }
}
