<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use Carbon\Carbon;

/**
 * App\EnProceso
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuAsunto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuClastupa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuContrasenia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuDetalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuDiasatencion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuDocGenerado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuDomic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuEmailorigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuFechaDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuFirma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuFirmaElectronica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuFolios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIdexma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIdprioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIdrecepcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIdtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIdtipodocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIdtupa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuIdusuariodependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuNumeroDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuNumtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuProyectado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuRelacionado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuRuc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuSiglasDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuTelef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereDocuToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereIddocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\EnProceso whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnProceso extends Model
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
    
    
    public static function derivar($iddoc,$operacion, $request){
        $retorno=true;
        $date = Carbon::now();
        $tabla_baseRegistrado=[];
        for ($i = 1; $i < $request->input('count'); $i++){
            $tabla_baseRegistrado[] = [
                "oper_iddocumento"=>$iddoc,
                "oper_iddependencia"=>$operacion->oper_iddependencia,
                "oper_idusuario"=>$operacion->oper_idusuario,
                "oper_idarchivador"=>$request->input(''),
                "oper_fecha"=>date('Y-m-d'),
                "oper_hora"=>$date->toTimeString(),
                "oper_idtope"=>2,
                //
                "oper_forma"=>$request->input('t_f_'.$i),
                "oper_depeid_d"=>$request->input('t_uni_'.$i),
                "oper_usuid_d"=>$request->input('t_usu_'.$i),
                "oper_detalledestino"=>$request->input('t_det_'.$i),
                "oper_acciones"=>$request->input('t_pro_'.$i),
                //requeridos
                "oper_idprocesado"=>$operacion->idoperacion,
                "oper_expeid_adj"=>$request->input(''),
                "oper_procesado"=>'f',
                "oper_tarchi_id"=>$request->input(''),
                "created_at"=>$date->toDateTimeString()];               
        }
        
        foreach($tabla_baseRegistrado  as $clave => $valor){
            $data = new Operacion;
            $data->oper_iddocumento=$valor['oper_iddocumento'];
            $data->oper_iddependencia=$valor['oper_iddependencia'];
            $data->oper_idusuario=$valor['oper_idusuario'];
            $data->oper_idarchivador=$valor['oper_idarchivador'];
            $data->oper_fecha=$valor['oper_fecha'];
            $data->oper_hora=$valor['oper_hora'];
            $data->oper_idtope=$valor['oper_idtope'];
            $data->oper_forma=$valor['oper_forma'];
            $data->oper_depeid_d=$valor['oper_depeid_d'];
            $data->oper_usuid_d=$valor['oper_usuid_d'];
            $data->oper_detalledestino=$valor['oper_detalledestino'];
            $data->oper_acciones=$valor['oper_acciones'];
            $data->oper_idprocesado=$valor['oper_idprocesado'];
            $data->oper_expeid_adj=$valor['oper_expeid_adj'];
            $data->oper_procesado=$valor['oper_procesado'];
            $data->oper_tarchi_id=$valor['oper_tarchi_id'];
            if(!$data->save()) {
                 $retorno=false;
            }
            $operacion->oper_procesado='t';
        }
        $operacion->save();
        return $retorno;
        
    }
    
    
    public static function archivar($iddoc,$operacion, $request){
                
        $retorno=true;
        $date = Carbon::now();
        
        $tabla_baseRegistrado[] = [
            "oper_iddocumento"=>$iddoc,
            "oper_iddependencia"=>$request->input('oper_iddependencia'),
            "oper_idusuario"=>$request->input('oper_idusuario'),
            "oper_idarchivador"=>$request->input('oper_idarchivador'),
            "oper_fecha"=>date('Y-m-d'),
            "oper_hora"=>$date->toTimeString(),
            "oper_idtope"=>3,
            "oper_forma"=>$request->input('oper_forma'),
            "oper_detalledestino"=>$request->input(''),
            "oper_acciones"=>$request->input('oper_acciones'),
            //requeridos
            "oper_idprocesado"=>$operacion->idoperacion,
            "oper_procesado"=>'f',
            "oper_tarchi_id"=>$request->input('oper_tarchi_id'),
            "created_at"=>$date->toDateTimeString()]; 
        
        foreach($tabla_baseRegistrado  as $clave => $valor){
            $data = new Operacion;
            $data->oper_iddocumento=$valor['oper_iddocumento'];
            $data->oper_iddependencia=$valor['oper_iddependencia'];
            $data->oper_idusuario=$valor['oper_idusuario'];
            $data->oper_idarchivador=$valor['oper_idarchivador'];
            $data->oper_fecha=$valor['oper_fecha'];
            $data->oper_hora=$valor['oper_hora'];
            $data->oper_idtope=$valor['oper_idtope'];
            $data->oper_forma=$valor['oper_forma'];
            $data->oper_detalledestino=$valor['oper_detalledestino'];
            $data->oper_acciones=$valor['oper_acciones'];
            $data->oper_idprocesado=$valor['oper_idprocesado'];
            $data->oper_procesado=$valor['oper_procesado'];
            $data->oper_tarchi_id=$valor['oper_tarchi_id'];
            if(!$data->save()) {
                 $retorno=false;
            }
            $operacion->oper_procesado='t';
        }
        $operacion->save();
        return $retorno;        
    }
    
    
    public static function adjuntar($iddoc,$operacion, $request){
                
        $retorno=true;
        $date = Carbon::now();
        
        $tabla_baseRegistrado[] = [
            "oper_iddocumento"=>$iddoc,
            "oper_iddependencia"=>$request->input('oper_iddependencia'),
            "oper_idusuario"=>$request->input('oper_idusuario'),
            "oper_fecha"=>date('Y-m-d'),
            "oper_hora"=>$date->toTimeString(),
            "oper_idtope"=>4,
            "oper_forma"=>$request->input('oper_forma'),
            "oper_detalledestino"=>$request->input(''),
            "oper_acciones"=>$request->input('oper_acciones'),
            //requeridos
            "oper_idprocesado"=>$operacion->idoperacion,
            "oper_expeid_adj"=>$request->input('oper_expeid_adj'),
            "oper_procesado"=>'f',
            "oper_tarchi_id"=>$request->input(''),
            "created_at"=>$date->toDateTimeString()]; 
        
        foreach($tabla_baseRegistrado  as $clave => $valor){
            $data = new Operacion;
            $data->oper_iddocumento=$valor['oper_iddocumento'];
            $data->oper_iddependencia=$valor['oper_iddependencia'];
            $data->oper_idusuario=$valor['oper_idusuario'];
            $data->oper_fecha=$valor['oper_fecha'];
            $data->oper_hora=$valor['oper_hora'];
            $data->oper_idtope=$valor['oper_idtope'];
            $data->oper_forma=$valor['oper_forma'];
            $data->oper_detalledestino=$valor['oper_detalledestino'];
            $data->oper_acciones=$valor['oper_acciones'];
            $data->oper_idprocesado=$valor['oper_idprocesado'];
            $data->oper_expeid_adj=$valor['oper_expeid_adj'];
            $data->oper_procesado=$valor['oper_procesado'];
            $data->oper_tarchi_id=$valor['oper_tarchi_id'];
            if(!$data->save()) {
                 $retorno=false;
            }
            $operacion->oper_procesado='t';
        }
        $operacion->save();
        return $retorno;        
    }
    
    public static function eliminarDer($operacion){
        $operacion->oper_procesado='f';        
        $operacion->save();        
    }
}
