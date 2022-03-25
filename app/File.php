<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Response;
use Storage;

class File extends Model
{
    protected $table = 'tram_file';
    protected $primaryKey = 'id';

    protected $hidden = [
        'updated_at',
    ];
    protected $casts = [
        'file_mostrar'  => 'boolean',
        'file_generado' => 'boolean',
        'file_principal'=> 'boolean',
        'file_size'     => 'integer',
    ];

    public static function getPdf($id_file, $id, $tipo)
    {
        $where = [
            ['id', $id_file],
        ];
        if ($tipo == 1) {
            $where[] = ['id_documento', $id];
        } else {
            $where[] = ['id_documento_externo', $id];
        }
        $file_select = File::where($where)->first();
        if($file_select!=null) {
            $file = Storage::disk('tramite')->get($file_select->file_url);
            return Response::make($file, 200, ['Content-Type' => Storage::disk('tramite')->getMimeType($file_select->file_url)]);
        } else
            abort(404, 'No encontrado.');
    }
}
