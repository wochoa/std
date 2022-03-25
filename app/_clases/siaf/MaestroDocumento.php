<?php

namespace App\_clases\siaf;

use Illuminate\Database\Eloquent\Model;

class MaestroDocumento extends Model
{
    protected $table = 'siaf_maestro_documento';

    public $timestamps = false;

    public static function getMaestroDocumento()
    {
        return MaestroDocumento::select(['cod_doc', 'nombre'])
            ->get();
    }
}
