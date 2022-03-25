<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Response;
use App\Models\Assistance\IpsRecognized;
use App\Models\Assistance\AssingSchedule;

/**
 * App\Dependencia
 *
 * @property int $iddependencia
 * @property string $depe_nombre
 * @property string|null $depe_abreviado
 * @property string|null $depe_sigla
 * @property string|null $depe_representante
 * @property string|null $depe_cargo
 * @property int|null $depe_depende
 * @property array|null $depe_superior
 * @property int $depe_tipo
 * @property int $depe_proyectado
 * @property string|null $depe_estado
 * @property string|null $depe_observaciones
 * @property int|null $depe_idusuario
 * @property int|null $depe_idusuariotransp
 * @property int|null $depe_recibetramite
 * @property int|null $depe_agente
 * @property int|null $depe_diasmaxenproceso
 * @property int|null $depe_idusuarioreclamo
 * @property int|null $depe_rrhh
 * @property int|null $depe_proyectos
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeAbreviado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeAgente($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeDepende($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeDiasmaxenproceso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeIdusuario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeIdusuarioreclamo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeIdusuariotransp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeProyectado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeProyectos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeRecibetramite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeRepresentante($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeRrhh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeSigla($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeSuperior($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereDepeTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereIddependencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependencia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dependencia extends Model
{
    protected $table = 'tram_dependencia';

    protected $primaryKey = 'iddependencia';

    //public $timestamps=false;
    /*protected $casts = [
        'depe_recibetramite'        =>'boolean',
    ];*/

    /*protected $fillable =[
    	'depe_nombre',
        'depe_abreviado',
        'depe_sigla',
        'depe_representante',
        'depe_cargo',
        'depe_depende',
        'depe_tipo',
        'depe_proyectado',
        'depe_estado',
        'depe_observaciones',
        'depe_idusuariotransp',
        'depe_recibetramite',
        'depe_agente',
        'depe_diasmaxenproceso',
        'depe_idusuarioreclamo'
    ];*/
    protected $casts = [
        'depe_superior' => 'array',
    ];

    public function getForUpdate()
    {

        return json_encode((Object)[
            'iddependencia'         => $this->iddependencia,
            'depe_nombre'           => $this->depe_nombre,
            'depe_abreviado'        => $this->depe_abreviado,
            'depe_estado'           => $this->depe_estado,
            'depe_agente'           => (bool)$this->depe_agente,
            'depe_sigla'            => $this->depe_sigla,
            'depe_representante'    => $this->depe_representante,
            'depe_cargo'            => $this->depe_cargo,
            'depe_proyectado'       => (bool)$this->depe_proyectado,
            'depe_ciudad'           => $this->depe_ciudad,
            'depe_minuto_tolerancia'=> $this->depe_minuto_tolerancia,
            'depe_idusuariotransp'  => $this->depe_idusuariotransp,
            'depe_idusuarioreclamo' => $this->depe_idusuarioreclamo,
            'depe_imagen_header'    => $this->depe_imagen_header,
            'depe_imagen_footer'    => $this->depe_imagen_footer,
            'ips'                   => $this->ips,
            'schedules'             => $this->schedules,
        ]);
    }

    public function getSuperiorName()
    {
        $d = Dependencia::find($this->depe_superior["dependencia"]);
        return ($d != null) ? $d->depe_nombre : null;
    }

    public function getImagen($tipo)
    {
        $imagen = ($tipo == 1) ? $this->depe_imagen_header : $this->depe_imagen_footer;
        $url    = Storage::disk('imagenes')->get($imagen);
        return Response::make($url, 200, ['Content-Type' => Storage::disk('imagenes')->getMimeType($imagen)]);
    }

    public static function getOficinas()
    {
        $dependencias = Dependencia::find(Auth::user()->depe_id);
        return Dependencia::select(['iddependencia', 'depe_nombre'])
            ->where('depe_depende', '=', $dependencias->depe_depende)
            ->orderBy('iddependencia', 'asc')
            ->get();
    }

    public function ips()
    {
        return $this->hasMany(IpsRecognized::class, 'dependencia_id', 'iddependencia');
    }

    public function syncIps(array $ips)
    {
        $children    = $this->ips;
        $ips_items   = collect($ips);
        $deleted_ids = $children->filter(function ($child) use ($ips_items) {
            return empty($ips_items->where('id', $child->id)->first());
        })->map(function ($child) {
            $id = $child->id;
            $child->delete();
            return $id;
        });
        $updates     = $ips_items->filter(function ($ip) {
            return isset($ip['id']);
        })->map(function ($ip) use($children) {
            $children->map(function ($c) use ($ip) {
                $c->updateOrCreate([
                    'id' => $ip['id'],
                ], [
                    'ip' => $ip['ip'],
                ]);
            });
        });
        $attachments = $ips_items->filter(function ($ip) {
            return !isset($ip['id']);
        })->map(function ($ip) use ($deleted_ids) {
            $ip['id'] = $deleted_ids->pop();
            if ($ip['id'] == null)
                unset($ip['id']);
            return $ip;
        })->toArray();
        $this->ips()->createMany($attachments);
    }

    public function sede()
    {
        return $this->belongsTo(Dependencia::class, 'depe_depende', 'iddependencia');
    }

    public function schedules()
    {
        return $this->hasMany(AssingSchedule::class, 'dependencia_id', 'iddependencia');
    }

    public function syncSchedules(array $schedule)
    {
        $children       = $this->schedules;
        $schedule_items = collect($schedule);
        $deleted_ids    = $children->filter(function ($child) use ($schedule_items) {
            return empty($schedule_items->where('id', $child->id)->first());
        })->map(function ($child) {
            $id = $child->id;
            $child->delete();
            return $id;
        });
        $updates        = $schedule_items->filter(function ($schedule) {
            return isset($schedule['id']);
        })->map(function ($schedule) use ($children) {
            $children->map(function ($c) use ($schedule) {
                $c->updateOrCreate([
                    'id' => $schedule['id'],
                ], [
                    'status'      => $schedule['status'],
                    'entry_time'  => $schedule['entry_time'],
                    'output_time' => $schedule['output_time'],
                    'type'        => $schedule['type'],
                ]);
            });
        });
        $attachments    = $schedule_items->filter(function ($schedule) {
            return !isset($schedule['id']);
        })->map(function ($schedule) use ($deleted_ids) {
            $schedule['id'] = $deleted_ids->pop();
            if ($schedule['id'] == null)
                unset($schedule['id']);
            return $schedule;
        })->toArray();
        $this->schedules()->createMany($attachments);
    }
}
