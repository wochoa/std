<?php

namespace App\_clases\proyectos;

use Illuminate\Database\Eloquent\Model;

/**
 * App\_clases\proyectos\Tags
 *
 * @property int $id
 * @property string|null $tag_name
 * @property string|null $tag_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Tags newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Tags newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Tags query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Tags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Tags whereTagDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\_clases\proyectos\Tags whereTagName($value)
 * @mixin \Eloquent
 */
class Tags extends Model
{
    protected $table='proy_proy_tags';

    public $timestamps=false;

    public static function getToSelect(){
        $tags = [];
        $var = Componente::select(['id', 'tag_name', 'tag_description']);
        foreach ($var->get() as $tag){
            $tags[$tag->id]=$tag->comp_nombre;
        }
        return $tags;
    }
    public static function getToTypeHead(){
        $tags = [];
        $var = Tags::select(['id', 'tag_name', 'tag_description']);
        foreach ($var->get() as $tag){
            $tags[]=['id'=>$tag->id,'tag_name'=>$tag->tag_name,'tag_description'=>$tag->tag_description];
        }
        return $tags;
    }
}
