<?php

namespace App\Http\Controllers\Tramite;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Dependencia;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Storage;
use App\Models\MesaElectronica\Holiday;
use App\Models\Assistance\IpsRecognized;
use App\Models\Assistance\AssingSchedule;

class DependenciaController extends Controller
{

    public function index(Request $request)
    {

        $where = [
            ['depe_tipo', '=', 0],
        ];
        if ($request->iddependencia != null)
            $where[] = ['iddependencia', '=', $request->iddependencia];
        if ($request->depe_nombre != null)
            $where[] = ['depe_nombre', 'LIKE', "%$request->depe_nombre%"];

        return Dependencia::select(
            [
                'a.adm_name',
                'a.adm_lastname',
                'iddependencia',
                'depe_nombre',
                'depe_abreviado',
                'depe_ciudad',
                'depe_agente',
                'a1.adm_name as reclamo',
                'a1.adm_lastname as reclamo1',
                'a.id',
                'depe_idusuarioreclamo',
            ])
            ->leftJoin('admin as a', 'a.id', '=', 'tram_dependencia.depe_idusuariotransp')
            ->leftJoin('admin as a1', 'a1.id', '=', 'tram_dependencia.depe_idusuarioreclamo')
            ->with(['ips', 'schedules'])
            ->where($where)
            ->orderBy('iddependencia', 'asc')
            ->paginate(15);

    }

    public function buscar(Request $request)
    {

        switch ($request->tipo) {
            case "externo":
                {
                    return Dependencia::select('iddependencia', 'depe_nombre')
                        ->where('depe_tipo', '=', '2')
                        ->orderBy('depe_nombre', 'asc')
                        ->get();
                }
                break;
            case "interno":
            {
                return Dependencia::select('iddependencia', 'depe_nombre')
                    ->where('depe_tipo', '=', '1')
                    ->orderBy('depe_nombre', 'asc')
                    ->get();
            }
        }

    }

    public function create()
    {

    }


    public function store(Request $request)
    {
        $depe = (Object)$request->dependencia;
        $dependencia = ($depe->iddependencia == null || $depe->iddependencia == 'null') ? new Dependencia() : Dependencia::find($depe->iddependencia);
        if ($request->tipo == 1) {
            $dependencia->depe_nombre = $depe->depe_nombre;
            $dependencia->depe_abreviado = $depe->depe_abreviado;
            $dependencia->depe_estado = $depe->depe_estado;
            $dependencia->depe_agente = ($depe->depe_agente) ? 1 : 0;
            $dependencia->depe_tipo = 0;
            $dependencia->depe_sigla = $depe->depe_sigla;
            $dependencia->depe_representante = $depe->depe_representante;
            $dependencia->depe_cargo = $depe->depe_cargo;
            $dependencia->depe_proyectado = ($depe->depe_proyectado) ? 1 : 0;
            $dependencia->depe_idusuariotransp = $depe->depe_idusuariotransp;
            $dependencia->depe_idusuarioreclamo = $depe->depe_idusuarioreclamo;
        }
        $dependencia->depe_ciudad = $depe->depe_ciudad;
        $dependencia->depe_minuto_tolerancia = $depe->depe_minuto_tolerancia;
        $anio = Carbon::now()->year;
        if ($request->imagen_header != null) {
            $porcion = explode("/", $request->imagen_header)[1];
            $file_name_header = '\\' . 'logos' . '\\' . $anio . '\\' . 'header-' . $dependencia->iddependencia . '-' . $porcion;
            Storage::disk('imagenes')->move($request->imagen_header, $file_name_header);
            Storage::disk('imagenes')->delete($dependencia->depe_imagen_header);
            $dependencia->depe_imagen_header = $file_name_header;
        }
        if ($request->imagen_footer != null) {

            $porcion = explode("/", $request->imagen_footer)[1];
            $file_name_footer = '\\' . 'logos' . '\\' . $anio . '\\' . 'footer-' . $dependencia->iddependencia . '-' . $porcion;
            Storage::disk('imagenes')->move($request->imagen_footer, $file_name_footer);
            Storage::disk('imagenes')->delete($dependencia->depe_imagen_footer);
            $dependencia->depe_imagen_footer = $file_name_footer;
        }
        $dependencia->save();
        $dependencia->syncIps($depe->ips);
        $dependencia->syncSchedules($depe->schedules);

    }

    public function show($id)
    {
        return Dependencia::find($id)->getForUpdate();
    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

    }

    public function print(Request $request)
    {
        return Dependencia::find($request->iddependencia)->getImagen($request->tipo);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            //get filename with extension
            $filenametostore = $request->file('file')->getClientOriginalName();
            $extencion = explode('.', $filenametostore)[1];
            $filenametostore = 'temp/' . Str::random(15) . '.' . $extencion;
            Storage::disk('imagenes')->put($filenametostore, fopen($request->file('file'), 'r+'));
            return $filenametostore;
        }
    }

    public function dependenciaMesaPartesVirtual()
    {
        return Dependencia::select('tram_dependencia.iddependencia', 'tram_dependencia.depe_nombre')
            ->where('tram_dependencia.depe_tipo', '=', 0)
            ->where('td2.depe_mesa_virtual', '=', 1)
            ->join('tram_dependencia AS td2', 'tram_dependencia.iddependencia', '=', 'td2.depe_depende')
            ->orderBy('depe_nombre', 'asc')
            ->groupBy('tram_dependencia.iddependencia')
            ->groupBy('tram_dependencia.depe_nombre')
            ->get();
    }

    public function schedules(Request $request)
    {
        $schedules = AssingSchedule::where('dependencia_id',$request->id)->where('type', 1)->get();
        $holidays = Holiday::select(['holiday','status'])
            ->where('status',1)
            ->groupBy('holiday')
            ->groupBy('status')
            ->orderBy('holiday','desc')
            ->get();
        return response()->json(['schedules'=>$schedules, 'holidays' => $holidays], 200);
    }
}
