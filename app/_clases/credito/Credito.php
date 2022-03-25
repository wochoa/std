<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Cliente
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Cliente query()
 * @mixin \Eloquent
 */
class Cliente extends Model
{
    protected $table = 'cred_cliente';
    
    public $primaryKey = 'id_cliente';
    
    public $timestamps = false;
}