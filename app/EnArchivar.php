<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Carbon\Carbon;

/**
 * App\EnArchivar
 *
 * @property int $iddocumento
 * @property int|null $docu_origen
 * @property int|null $docu_tipo
 * @property int $docu_idprioridad
 * @property int $docu_forma
 * @property int $docu_iddependencia
 * @property string|null $docu_ruc
 * @property string|null $docu_detalle
 * @property string $docu_firma
 * @property string|null $docu_cargo
 * @property int $docu_idtipodocumento
 * @property string $docu_fecha_doc
 * @property int|null $docu_numero_doc
 * @property string|null $docu_siglas_doc
 * @property string|null $docu_proyectado
 * @property int $docu_idrecepcion
 * @property int|null $docu_folios
 * @property string|null $docu_asunto
 * @property int|null $docu_relacionado
 * @property int $docu_idusuario
 * @property int $docu_idusuariodependencia
 * @property string|null $docu_emailorigen
 * @property string|null $docu_archivo
 * @property string|null $docu_path
 * @property int $docu_estado
 * @property int $docu_clastupa
 * @property int|null $docu_diasatencion
 * @property string|null $docu_idtdoc
 * @property string|null $docu_numtdoc
 * @property int|null $docu_idtupa
 * @property int|null $docu_idexma
 * @property string|null $docu_domic
 * @property string|null $docu_dni
 * @property string|null $docu_telef
 * @property int|null $docu_doc_generado
 * @property int|null $docu_firma_electronica
 * @property string|null $docu_contrasenia
 * @property string|null $docu_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuAsunto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuClastupa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuContrasenia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuDetalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuDiasatencion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuDocGenerado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuDomic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuEmailorigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuFechaDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuFirma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuFirmaElectronica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuFolios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIdexma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIdprioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIdrecepcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIdtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIdtipodocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIdtupa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuIdusuariodependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuNumeroDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuNumtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuProyectado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuRelacionado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuRuc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuSiglasDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuTelef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereDocuToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereIddocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnArchivar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnArchivar extends Model
{
    protected $table='tram_documento'; 
    protected $primaryKey='iddocumento';
    
    protected $fillable=[
        'iddocumento',
        'idexpediente',
        'docu_tipo',
        'docu_fecha',
        'docu_hora',
        'docu_idprioridad',
        'docu_forma',
        'docu_iddependencia',
        'docu_detalle',
        'docu_firma',
        'docu_cargo',
        'docu_idtipodocumento',
        'docu_fecha_doc',
        'docu_numero_doc',
        'docu_siglas_doc',
        'docu_proyectado',
        'docu_idrecepcion',
        'docu_folios',
        'docu_asunto',
        'docu_relacionado',
        'docu_idusuario',
        'docu_idusuariodependencia',
        'docu_emailorigen',
        'docu_archivo',
        'docu_estado',
        'docu_clastupa',
        'docu_diasatencion',
        'docu_idtdoc',
        'docu_numtdoc',
        'docu_idtupa',
        'docu_idexma',
        'docu_domic',
        'docu_dni',
        'docu_telef',
        'docu_fecharegistro'
    ];
    
    protected $guarded=[];
        
        
    public static function archivar($operacion){
                
        $operacion->oper_procesado='f';        
        $operacion->save();            
    }    
    
}
