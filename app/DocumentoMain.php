<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DocumentoMain
 *
 * @property int $iddocumentomain
 * @property int $dmai_idusu
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentoMain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentoMain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentoMain query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentoMain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentoMain whereDmaiIdusu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentoMain whereIddocumentomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DocumentoMain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DocumentoMain extends Model
{
    protected $table='tram_documentomain';
    protected $primaryKey='iddocumentomain';
    public $timestamps=true;
    
    protected $fillable=[
      'dmai_idusu',
      'dmai_fecharegistro'
    ];
    protected $guarded=[
        
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y',
    ];
}
