<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Carbon\Carbon;

/**
 * App\PorRecibir
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuAsunto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuClastupa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuContrasenia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuDetalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuDiasatencion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuDocGenerado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuDomic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuEmailorigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuFechaDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuFirma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuFirmaElectronica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuFolios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIdexma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIdprioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIdrecepcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIdtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIdtipodocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIdtupa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuIdusuariodependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuNumeroDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuNumtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuProyectado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuRelacionado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuRuc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuSiglasDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuTelef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereDocuToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereIddocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PorRecibir whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PorRecibir extends Model
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
        
        
    public static function recepcionar($iddoc,$operacion, $request){
                
        $retorno=true;
        $date = Carbon::now();
        
        $tabla_baseRegistrado[] = [
            "oper_iddocumento"=>$iddoc,
            "oper_iddependencia"=>$request->input('oper_iddependencia'),
            "oper_idusuario"=>$request->input('oper_idusuario'),
            "oper_fecha"=>date('Y-m-d'),
            "oper_hora"=>$date->toTimeString(),
            "oper_idtope"=>1,
            "oper_forma"=>$request->input('oper_forma'),
            //requeridos
            "oper_idprocesado"=>$operacion->idoperacion,
            "oper_procesado"=>'f',
            "created_at"=>$date->toDateTimeString()]; 
        
        foreach($tabla_baseRegistrado  as $clave => $valor){
            $data = new Operacion();
            $data->oper_iddocumento=$valor['oper_iddocumento'];
            $data->oper_iddependencia=$valor['oper_iddependencia'];
            $data->oper_idusuario=$valor['oper_idusuario'];
            $data->oper_fecha=$valor['oper_fecha'];
            $data->oper_hora=$valor['oper_hora'];
            $data->oper_idtope=$valor['oper_idtope'];
            $data->oper_forma=$valor['oper_forma'];
            $data->oper_idprocesado=$valor['oper_idprocesado'];
            $data->oper_procesado=$valor['oper_procesado'];
            if(!$data->save()) {
                 $retorno=false;
            }
            $operacion->oper_procesado='t';
        }
        $operacion->save();
        return $retorno;             
    }    
    
}
