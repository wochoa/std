<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Response;
use Storage;

/**
 * App\Documento
 *
 * @property int $iddocumento
 * @property int|null $docu_origen
 * @property int|null $docu_tipo
 * @property int $docu_digital
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
 * @property array|null $docu_archivo
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
 * @property int|null $docu_referencias
 * @property string|null $docu_contrasenia
 * @property string|null $docu_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuArchivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuAsunto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuClastupa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuContrasenia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuDetalle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuDiasatencion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuDocGenerado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuDomic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuEmailorigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuFechaDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuFirma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuFirmaElectronica($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuFolios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIdexma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIdprioridad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIdrecepcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIdtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIdtipodocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIdtupa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuIdusuariodependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuNumeroDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuNumtdoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuOrigen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuProyectado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuRelacionado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuRuc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuSiglasDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuTelef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereDocuToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereIddocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Documento whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Documento extends Model
{
    protected $table = 'tram_documento';
    protected $primaryKey = 'iddocumento';

    protected $fillable = [
        'docu_origen',
        'docu_tipo',
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
        'docu_estado',
        'docu_clastupa',
        'docu_diasatencion',
        'docu_idtdoc',
        'docu_idtupa',
        'docu_idexma',
        'docu_dni',
        'docu_fecharegistro',
        'docu_digital',
        'docu_emailorigen',
        'docu_referencias',
        'docu_telef',
        'docu_domic',
    ];

    protected $casts = [
        'iddocumento'               => 'integer',
        'docu_idprioridad'          => 'integer',
        'docu_iddependencia'        => 'integer',
        'docu_idtipodocumento'      => 'integer',
        'docu_numero_doc'           => 'integer',
        'docu_idrecepcion'          => 'integer',
        'docu_folios'               => 'integer',
        'docu_relacionado'          => 'integer',
        'docu_idusuario'            => 'integer',
        'docu_idusuariodependencia' => 'integer',
        'docu_estado'               => 'integer',
        'docu_diasatencion'         => 'integer',
        'docu_idtupa'               => 'integer',
        'docu_idexma'               => 'integer',
        'docu_origen'               => 'integer',
        'docu_doc_generado'         => 'integer',
        'docu_referencias'          => 'array',
        'docu_digital'              => 'boolean',
    ];
    protected $guarded = [

    ];

    public function getForDocumento()
    {

        $this->load(['docuArchivo', 'operaciones']);
        $op       = collect($this->operaciones);
        $countOp  = $op->count();
        $first    = $op->first();
            if ($first != null){
                // $ops = $op->where('oper_idprocesado', '=', $id_first)->mapWithKeys(function($value, $key){
                //     return [$key-1=> $value];
                // })->all();
                $ops = Operacion::where('oper_idprocesado', '=', $first->idoperacion)->orderBy('idoperacion', 'asc')->get();
            }else {
                $ops = [];
            }
        $opUltimo = $op->last();

        return [
            'iddocumento'               => (isset($this->iddocumento))?$this->iddocumento:null,
            'docu_origen'               => $this->docu_origen,
            'docu_tipo'                 => $this->docu_tipo,
            'docu_digital'              => $this->docu_digital,
            'docu_idprioridad'          => $this->docu_idprioridad,
            'docu_forma'                => $this->docu_forma,
            'docu_iddependencia'        => $this->docu_iddependencia,
            'docu_detalle'              => $this->docu_detalle,
            'docu_firma'                => $this->docu_firma,
            'docu_cargo'                => $this->docu_cargo,
            'docu_idtipodocumento'      => $this->docu_idtipodocumento,
            'docu_fecha_doc'            => $this->docu_fecha_doc,
            'docu_numero_doc'           => $this->docu_numero_doc,
            'docu_siglas_doc'           => $this->docu_siglas_doc,
            'docu_proyectado'           => $this->docu_proyectado,
            'docu_idrecepcion'          => $this->docu_idrecepcion,
            'docu_folios'               => $this->docu_folios,
            'docu_asunto'               => $this->docu_asunto,
            'docu_idusuario'            => $this->docu_idusuario,
            'docu_idusuariodependencia' => $this->docu_idusuariodependencia,
            'docu_emailorigen'          => $this->docu_emailorigen,
            'docu_archivo'              => $this->docuArchivo,
            'docu_clastupa'             => $this->docu_clastupa,
            'docu_diasatencion'         => $this->docu_diasatencion,
            'docu_idtdoc'               => $this->docu_idtdoc,
            'docu_numtdoc'              => $this->docu_numtdoc,
            'docu_idtupa'               => $this->docu_idtupa,
            'docu_idexma'               => $this->docu_idexma,
            'docu_dni'                  => $this->docu_dni,
            'docu_telef'                => $this->docu_telef,
            'docu_domic'                => $this->docu_domic,
            'docu_contrasenia'          => $this->docu_contrasenia,
            'docu_referencias'          => $this->docu_referencias,
            'count_operaciones'         => $countOp,
            'operaciones'               => $ops,
            'operacionUltimo'           => $opUltimo,
        ];
    }

    public function getDocuReferenciasAttribute($value)
    {
        if ($value == null)
            return [];
        else
            return json_decode($value, true);;
    }

    public function getForPapeleta()
    {
        $porciones = explode("/", $this->docu_asunto);

        return json_encode((Object)[
            'iddocumento'               => $this->iddocumento,
            'docu_origen'               => $this->docu_origen,
            'docu_tipo'                 => $this->docu_tipo,
            'docu_idprioridad'          => $this->docu_idprioridad,
            'docu_forma'                => $this->docu_forma,
            'docu_iddependencia'        => $this->docu_iddependencia,
            'docu_detalle'              => $this->docu_detalle,
            'docu_firma'                => $this->docu_firma,
            'docu_cargo'                => $this->docu_cargo,
            'docu_idtipodocumento'      => $this->docu_idtipodocumento,
            'docu_fecha_doc'            => $this->docu_fecha_doc,
            'docu_numero_doc'           => $this->docu_numero_doc,
            'docu_siglas_doc'           => $this->docu_siglas_doc,
            'docu_proyectado'           => $this->docu_proyectado,
            'docu_idrecepcion'          => $this->docu_idrecepcion,
            'docu_folios'               => $this->docu_folios,
            'docu_asunto'               => $porciones[1],
            'docu_justificacion'        => $porciones[0],
            'docu_idusuario'            => $this->docu_idusuario,
            'docu_idusuariodependencia' => $this->docu_idusuariodependencia,
            'docu_clastupa'             => $this->docu_clastupa,
            'docu_diasatencion'         => $this->docu_diasatencion,
            'docu_idtdoc'               => $this->docu_idtdoc,
            'docu_numtdoc'              => $this->docu_numtdoc,
            'docu_idtupa'               => $this->docu_idtupa,
            'docu_idexma'               => $this->docu_idexma,
            'docu_dni'                  => $this->docu_dni,
            'docu_telef'                => $this->docu_telef,
            'docu_domic'                => $this->docu_domic,
        ]);
    }

    public function getIdString()
    {
        return str_pad($this->iddocumento, 8, "0", STR_PAD_LEFT);
    }
    public function getExpedienteString()
    {
        return str_pad($this->docu_idexma, 8, "0", STR_PAD_LEFT);
    }


    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'docu_idtipodocumento', 'idtdoc');
    }

    public function getNumeroDocumentoAttribute()
    {
        return "{$this->tipoDocumento->tdoc_descripcion} {$this->docu_numero_doc}-{$this->docu_siglas_doc}";

    }

    public function archivos()
    {
        return $this->hasMany(File::class, 'id_documento', 'iddocumento');
    }
    public function docuArchivo()
    {
        return $this->hasMany(File::class, 'id_documento', 'iddocumento');
    }

    public function archivoPrincipal()
    {
        return $this->hasOne(File::class, 'id_documento', 'iddocumento')->where('file_principal', '=', 1);
    }

    public function anexos()
    {
        return $this->archivos()->where('file_principal', '=', 0);
    }
    public function derivar($operacion, $derivaciones)
    {
        $retorno = true;
        $user    = \Auth::user();
        if ($operacion->oper_idtope == 2)
            $operacion = Operacion::find($operacion->oper_idprocesado);
        foreach ($derivaciones as $id => $derivacion) {
            $derivacion                = (Object)$derivacion;
            $data                      = new Operacion();
            $data                      = $data->fill((Array)$derivacion);
            $data->oper_iddependencia  = $user->depe_id;
            $data->oper_idusuario      = $user->id;
            $data->oper_procesado      = isset($derivacion->oper_manual)?$derivacion->oper_manual:false;//coincide con oper_manual, por que si es manual se toma como procesado
            $data->oper_idarchivador   = null;
            $data->oper_idtope         = 2;//default para derivacion
            $data->oper_idprocesado    = $operacion->idoperacion;
            $data->oper_detalledestino = mb_strtoupper($derivacion->oper_detalledestino);
            $data->oper_acciones       = mb_strtoupper($derivacion->oper_acciones);
            if (!$this->operaciones()->save($data)) {
                $retorno = false;
            }
            if ($data->oper_forma == $operacion->oper_forma && !$data->oper_procesado) {
                //esta condicional solo permite que se cambie a procesado si se deriva como original cuando la operacion anterior fue en original, y lo mismo en copia
                $operacion->oper_procesado = true;
            }
        }
        $operacion->save();
        return $retorno;
    }
    public function operaciones()
    {
        return $this->hasMany(Operacion::class, 'oper_iddocumento', 'iddocumento')->orderBy('idoperacion', 'asc');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'docu_idusuariodependencia', 'iddependencia');
    }

}
