<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Archivador
 *
 * @property int $idarch
 * @property int $arch_iddependencia
 * @property int|null $arch_idusuario
 * @property string $arch_nombre
 * @property int|null $arch_periodo
 * @property int|null $arch_idusuarioa
 * @property int|null $arch_papeleta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereArchIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereArchIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereArchIdusuarioa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereArchNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereArchPapeleta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereArchPeriodo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereIdarch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Archivador whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Archivador extends Model
{
   protected $table='tram_archivador';
   protected $primaryKey='idarch';
    
   //public $timestamps=true;
   protected $fillable=[
       'arch_iddependencia',
       'arch_idusuario',
       'arch_nombre',
       'arch_periodo',
       'arch_idusuarioa'
   ];
    
    protected $guarded=[
        
    ];

    public function getForUpdate(){

        return json_encode((Object)[
            'idarch'=>$this->idarch,
            'arch_iddependencia'=>$this->arch_iddependencia,
            'arch_idusuario'=>$this->arch_idusuario,
            'arch_nombre'=>$this->arch_nombre,
            'arch_periodo'=>$this->arch_periodo,
            'arch_idusuarioa'=>(bool)$this->arch_idusuarioa
        ]);
    }
    
}
