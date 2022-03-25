<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Archivador;
use Illuminate\Support\Facades\Log;

/**
 * App\Operacion
 *
 * @property int $idoperacion
 * @property int $oper_iddocumento
 * @property int $oper_iddependencia
 * @property int $oper_idusuario
 * @property int|null $oper_idarchivador
 * @property int|null $oper_idtope
 * @property int|null $oper_es_destino
 * @property int $oper_forma
 * @property int|null $oper_depeid_d
 * @property int|null $oper_usuid_d
 * @property string|null $oper_detalledestino
 * @property string|null $oper_persona
 * @property string|null $oper_cargo
 * @property string|null $oper_acciones
 * @property int|null $oper_idprocesado
 * @property int|null $oper_iddocumento_adj
 * @property int|null $oper_manual
 * @property string|null $oper_tarchi_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool oper_procesado
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereIdoperacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperAcciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperDepeidD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperDetalledestino($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperForma($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperIdarchivador($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperIddocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperIddocumentoAdj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperIdprocesado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperIdtope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperProcesado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperTarchiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereOperUsuidD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Operacion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Operacion extends Model
{
    protected $table = 'tram_operacion';
    protected $primaryKey = 'idoperacion';

    protected $fillable = [
        //'oper_iddocumento',
        'oper_iddependencia',
        'oper_idusuario',
        'oper_idarchivador',
        'oper_idtope',
        'oper_es_destino',
        'oper_forma',
        'oper_depeid_d',
        'oper_usuid_d',
        'oper_detalledestino',
        'oper_acciones',
        'oper_idprocesado',
        'oper_manual',
        'oper_persona',
        'oper_cargo',
        'oper_expeid_adj',
        'oper_procesado',
        'oper_tarchi_id',
    ];
    protected $casts = [
        'oper_idtope' => 'integer',
        'oper_manual' => 'boolean',
    ];

    protected $guarded = [

    ];

    //
    public function paginateArchivador($where, $perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $total = $this->getCountForPagination($columns);

        $results = Operacion::leftJoin('tram_archivador as ta', 'oper_idarchivador', '=', 'ta.idarch')
            ->where($where)
            ->whereIn('oper_idtope', [3, 4])->count();;

        return $this->paginator($results, $total, $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    public static function enviarSMS()
    {
        $postdata = http_build_query(
            [
                'cel' => '963501222',
                'msn' => 'esta es una prueba',
            ]
        );

        $opts = ['http' =>
                     [
                         'method'  => 'POST',
                         'header'  => 'Content-Type: text/html; charset=UTF-8',
                         'content' => $postdata,
                     ],
        ];

        $context = stream_context_create($opts);

        return $result = file_get_contents('http://app.regionhuanuco.gob.pe/soap/soap_pruebas/datossms.php', false, $context);
    }

    public static function derivar($operacion, $derivaciones)
    {
        $retorno = true;
        $user    = \Auth::user();
        if ($operacion->oper_idtope == 2)
            $operacion = Operacion::find($operacion->oper_idprocesado);
        foreach ($derivaciones as $id => $derivacion) {
            $derivacion                = (Object)$derivacion;
            $data                      = new Operacion();
            $data                      = $data->fill((Array)$derivacion);
            $data->oper_iddocumento    = $operacion->oper_iddocumento;
            $data->oper_iddependencia  = $user->depe_id;
            $data->oper_idusuario      = $user->id;
            $data->oper_procesado      = isset($derivacion->oper_manual)?$derivacion->oper_manual:false;//coincide con oper_manual, por que si es manual se toma como procesado
            $data->oper_idarchivador   = null;
            $data->oper_idtope         = 2;//default para derivacion
            $data->oper_idprocesado    = $operacion->idoperacion;
            $data->oper_detalledestino = mb_strtoupper($derivacion->oper_detalledestino);
            $data->oper_acciones       = mb_strtoupper($derivacion->oper_acciones);
            if (!$data->save()) {
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

    public static function recepcion($recepcionar, $derivaciones, $tipoDoc)
    {

        foreach ($recepcionar as $id => $recepcion) {
            $user = \Auth::user();

            $recp = Operacion::find($recepcion);
            if ($tipoDoc == env("TIPO_DOC_PAPELETA")) {
                $recp->oper_procesado = 1;
                $recp->save();
                $newRegistroOperacion                     = new Operacion();
                $newRegistroOperacion->oper_iddocumento   = $recp->oper_iddocumento;
                $newRegistroOperacion->oper_iddependencia = $user->depe_id;
                $newRegistroOperacion->oper_idusuario     = $user->id;
                $newRegistroOperacion->oper_idtope        = 1;
                $newRegistroOperacion->oper_forma         = $recp->oper_forma;
                $newRegistroOperacion->oper_idprocesado   = $recp->idoperacion;
                $newRegistroOperacion->oper_procesado     = 1;
                $newRegistroOperacion->save();
                return Operacion::derivar($newRegistroOperacion, $derivaciones);

            } elseif (($tipoDoc == null && $recp->oper_usuid_d == $user->id) || ($tipoDoc == null && $recp->oper_usuid_d == null)) {
                $recp->oper_procesado = 1;
                $recp->save();

                $newRegistroOperacion                     = new Operacion();
                $newRegistroOperacion->oper_iddocumento   = $recp->oper_iddocumento;
                $newRegistroOperacion->oper_iddependencia = $user->depe_id;
                $newRegistroOperacion->oper_idusuario     = $user->id;
                $newRegistroOperacion->oper_idtope        = 1;
                $newRegistroOperacion->oper_forma         = $recp->oper_forma;
                $newRegistroOperacion->oper_idprocesado   = $recp->idoperacion;
                $newRegistroOperacion->oper_procesado     = 0;
                $newRegistroOperacion->save();
            } else {
                return null;
            }
        }
    }

    public static function devolverdocProceso($devolver)
    {
        foreach ($devolver as $id => $devol) {
            $user = \Auth::user();

            $operacion = Operacion::find($devol);
            if ($operacion->oper_idtope == 4) {
                $operacionAnterior                 = Operacion::find($operacion->oper_idprocesado);
                $operacionAnterior->oper_procesado = 0;
                $operacionAnterior->save();

                $operacion->delete();
            } else {
                $operacion->oper_procesado = 1;
                $operacion->save();

                $newOpe                     = new Operacion();
                $newOpe->oper_iddocumento   = $operacion->oper_iddocumento;
                $newOpe->oper_iddependencia = $operacion->oper_iddependencia;
                $newOpe->oper_idusuario     = $user->id;
                $newOpe->oper_idtope        = 1;
                $newOpe->oper_forma         = $operacion->oper_forma;
                $newOpe->oper_idprocesado   = $operacion->idoperacion;
                $newOpe->oper_procesado     = 0;
                $newOpe->save();
            }
        }
        return true;

    }

    public static function eliminarDocDerivacion($devolver)
    {
        $return = true;

        foreach ($devolver as $id => $devol) {
            $user = \Auth::user();

            $operacion = Operacion::find($devol);
            $operPadre = Operacion::find($operacion->oper_idprocesado);

            if ($operacion->oper_idtope == 2 && $operacion->oper_idusuario == $user->id && $operacion->oper_procesado == 0) {
                $operacion->delete();
                $operPadre->oper_procesado = ($operPadre->verificarProcesado() == 0) ? false : true;
                $operPadre->save();
            } else
                $return = false;

        }
        return $return;
    }

    public static function liberarDocProceso($liberar, $datoOperacion)
    {

        $datoOperacion = (Object)$datoOperacion;

        foreach ($liberar as $id => $lib) {
            $user   = \Auth::user();
            $libDoc = Operacion::find($lib);

            $libDoc->oper_procesado = 1;
            $libDoc->save();

            $newLiberar                      = new Operacion();
            $newLiberar->oper_iddocumento    = $libDoc->oper_iddocumento;
            $newLiberar->oper_iddependencia  = $libDoc->oper_iddependencia;
            $newLiberar->oper_idusuario      = $user->id;
            $newLiberar->oper_idtope         = 1;
            $newLiberar->oper_forma          = $libDoc->oper_forma;
            $newLiberar->oper_detalledestino = $datoOperacion->oper_detalledestino;
            $newLiberar->oper_acciones       = $datoOperacion->oper_acciones;
            $newLiberar->oper_idprocesado    = $libDoc->idoperacion;
            $newLiberar->oper_procesado      = 0;
            $newLiberar->save();

        }
        return true;
    }

    public static function generarDocObservacion($observacion, $datoOperacion)
    {

        $datoOperacion = (Object)$datoOperacion;

        foreach ($observacion as $id => $obs) {
            $obsDoc                      = Operacion::find($obs);
            $obsDoc->oper_detalledestino = $datoOperacion->oper_detalledestino;
            $obsDoc->save();
        }
        return true;
    }

    public static function docArchivarAdjuntar($operDocumento, $datoDocumento)
    {
        $datoDocumento = (Object)$datoDocumento;

        foreach ($operDocumento as $id => $operDoc) {
            $user = \Auth::user();

            $operacionDoc = Operacion::find($operDoc);
            if ($datoDocumento->tipoDoc == 1) {
                $operacionDoc->oper_iddependencia = $user->depe_id;
                $operacionDoc->oper_idusuario     = $user->id;
                $operacionDoc->oper_idarchivador  = $datoDocumento->idarch;
                $operacionDoc->oper_idtope        = 3;
                $operacionDoc->oper_depeid_d      = null;
                $operacionDoc->oper_acciones      = $datoDocumento->acciones;
                $operacionDoc->oper_procesado     = 0;
                $operacionDoc->oper_tarchi_id     = $datoDocumento->forma;
                $operacionDoc->save();
            } else {
                $operacionDoc->oper_procesado = 1;
                $operacionDoc->save();
            }
            if ($datoDocumento->tipoDoc == null) {

                $newOperacion                     = new Operacion();
                $newOperacion->oper_iddocumento   = $operacionDoc->oper_iddocumento;
                $newOperacion->oper_iddependencia = $user->depe_id;
                $newOperacion->oper_idusuario     = $user->id;
                $newOperacion->oper_forma         = $operacionDoc->oper_forma;
                $newOperacion->oper_acciones      = $datoDocumento->acciones;
                $newOperacion->oper_idprocesado   = $operacionDoc->idoperacion;
                $newOperacion->oper_procesado     = 0;

                if ($datoDocumento->iddocumento == null && $datoDocumento->idarch == null) {
                    Log::info('Error personalizado de Walther : ' . json_encode(['operDocumento' => $operDocumento,
                                                                                 'datoDocumento' => $datoDocumento]));
                    $newArchivador                     = new Archivador();
                    $newArchivador->arch_iddependencia = 3;
                    $newArchivador->arch_idusuario     = 1;
                    $newArchivador->arch_nombre        = 'Archivador documentos enviados por interoperabilidad';
                    $newArchivador->arch_periodo       = $datoDocumento->arch_periodo;
                    $newArchivador->arch_idusuarioa    = 0;
                    $newArchivador->arch_papeleta      = 1;
                    $newArchivador->save();

                    $newOperacion->oper_idarchivador = $newArchivador->idarch;
                }

                if ($datoDocumento->iddocumento == null) {
                    if ($datoDocumento->idarch != null) {
                        $newOperacion->oper_idarchivador = $datoDocumento->idarch;
                    }
                    $newOperacion->oper_idtope    = 3;//
                    $newOperacion->oper_tarchi_id = $datoDocumento->forma;
                } else {
                    $newOperacion->oper_idtope          = 4;
                    $newOperacion->oper_iddocumento_adj = $datoDocumento->iddocumento;
                }
                $newOperacion->save();
            }

        }
    }

    public function verificarProcesado()
    {
        return Operacion::where('oper_idprocesado', '=', $this->idoperacion)->count();
    }

    public function dependenciaDestino()
    {
        return $this->belongsTo(Dependencia::class, 'oper_depeid_d', 'iddependencia');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'oper_iddependencia', 'iddependencia');
    }

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'oper_iddocumento', 'iddocumento');
    }

    public static function adjuntarRespuesta($idresponse, $operDocumento)
    {
        foreach ($operDocumento as $operDoc) {
            $user = \Auth::user();

            $operacionDoc = Operacion::find($operDoc);
            $operacionDoc->oper_procesado = 1;
            $operacionDoc->save();

            $newOperacion                     = new Operacion();
            $newOperacion->oper_iddocumento   = $operacionDoc->oper_iddocumento;
            $newOperacion->oper_iddependencia = $user->depe_id;
            $newOperacion->oper_idusuario     = $user->id;
            $newOperacion->oper_forma         = $operacionDoc->oper_forma;
            $newOperacion->oper_acciones      = 'SU ATENCIÓN';
            $newOperacion->oper_idprocesado   = $operacionDoc->idoperacion;
            $newOperacion->oper_procesado     = 0;
            $newOperacion->oper_idtope          = 4;
            $newOperacion->oper_iddocumento_adj = $idresponse;
            $newOperacion->save();
        }
    }
}
