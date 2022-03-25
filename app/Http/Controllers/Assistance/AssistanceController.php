<?php

namespace App\Http\Controllers\Assistance;

use Carbon\Carbon;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assistance\Assistance;
use App\Models\Assistance\IpsRecognized;
use App\Models\Assistance\AssingSchedule;
use App\Models\Assistance\Ballot;

class AssistanceController extends Controller
{

    public function index(Request $request)
    {
        $where = [];

        switch ($request->tipo) {

            case '1': {
                    $carbon = new Carbon($request->currentDate);
                    $carbon->addDay();
                    $where[] = ['user_id', auth()->user()->id];
                    break;
                }
            case '2': {
                    $fecha = explode('-', $request->currentDate);
                    $newFecha = $fecha[0] . '-' . $request->month_id . '-01';
                    $carbon = new Carbon($newFecha);

                    $carbon->addMonth();
                    $where[] = ['user_id', auth()->user()->id];

                    return Assistance::query()
                        ->where($where)
                        ->whereBetween('entry', [$newFecha, $carbon->toDateString()])
                        ->with('usuario')
                        ->paginate(15);
                    break;
                }
            case '3': {
                    $carbon = new Carbon($request->currentDate);
                    $carbon->addDay();

                    if ($request->iddependencia != null)
                        $where[] = ['dependencia_id', $request->iddependencia];
                    if ($request->user_id != null)
                        $where[] = ['user_id', $request->user_id];

                    if ($request->type == 1) {

                        $ballots = Ballot::query()->where($where)
                            ->whereBetween('created_at', [$request->currentDate, $carbon->toDateString()])
                            ->get();

                        $where[] = ['td2.iddependencia', $request->depe_depende];

                        $assistance = Assistance::select([
                            'id',
                            'user_id',
                            'dependencia_id',
                            'entry',
                            'exit',
                            'validate',
                            'entry_time'
                        ])
                            ->where($where)
                            ->whereBetween('entry', [$request->currentDate, $carbon->toDateString()])
                            //->with(['usuario', 'dependencia'])
                            ->with('usuario')
                            ->join('tram_dependencia as td1', 'dependencia_id', '=', 'td1.iddependencia')
                            ->leftJoin('tram_dependencia as td2', 'td1.depe_depende', '=', 'td2.iddependencia')
                            ->get();

                        return response()->json(['data' => $assistance, 'ballots' => $ballots], 200);
                    }

                    if ($request->type == 2) {

                        $assistance = Assistance::query()
                            ->where($where)
                            ->whereBetween('entry', [$request->currentDate, $carbon->toDateString()])
                            ->get();
                        $ballots = Ballot::query()->where($where)
                            ->whereBetween('created_at', [$request->currentDate, $carbon->toDateString()])
                            ->get();
                        return response()->json([
                            'data' =>  $assistance,
                            'ballots' => $ballots
                        ], 200);
                    }
                    break;
                }
        }
        return Assistance::select([
            'id',
            'user_id',
            'dependencia_id',
            'entry',
            'exit',
            'validate',
            'entry_time'
        ])
            ->where($where)
            ->whereBetween('entry', [$request->currentDate, $carbon->toDateString()])
            //->with(['usuario', 'dependencia'])
            ->with('usuario')
            ->join('tram_dependencia as td1', 'dependencia_id', '=', 'td1.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td1.depe_depende', '=', 'td2.iddependencia')
            ->paginate(15);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $schedules = AssingSchedule::where('dependencia_id', auth()->user()->dependencia->depe_depende)
            ->where('status', 1)
            ->where('type', 0)
            ->orderBy('entry_time', 'asc')
            ->get();

        $ingreso = new Carbon();

        if (count($schedules) == 0 && auth()->user()->dependencia->depe_depende) {
            $horarioIngreso = null;
            $horarioSalida = null;
        } elseif (count($schedules) == 1) {
            $horarioIngreso = $schedules[0]->entry_time;
            $horarioSalida = $schedules[0]->output_time;
        } elseif (count($schedules) > 1) {
            $salida = new Carbon($schedules[0]->output_time);
            $i = $salida->diffInMinutes($ingreso->isoFormat('HH:mm:ss'), false) > 0 ? 1 : 0;
            $horarioIngreso = $schedules[$i]->entry_time;
            $horarioSalida = $schedules[$i]->output_time;
        }

        $controls = [
            'entry'          => now(),
            'user_id'        => auth()->user()->id,
            'dependencia_id' => auth()->user()->depe_id,
            'created_ip'     => $request->ip,
            'entry_time'     => $horarioIngreso,
            'output_time'    => $horarioSalida,
            'created_by'     => auth()->user()->id,
            'updated_by'     => auth()->user()->id,
        ];
        $assistance = Assistance::create($controls);

        return response()->json(['id' => $assistance->id, 'entry' => $assistance->entry, 'entry_time' => $assistance->entry_time, 'output_time' => $assistance->output_time], 200);
    }

    public function getUserIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function activa()
    {
        $carbon = now();
        $carbon->addDay();
        $user = User::select(['adm_name', 'adm_lastname', 'depe_id', 'adm_dni'])->with('dependencia')->where('id', auth()->user()->id)->first();
        $ips = IpsRecognized::where('dependencia_id', auth()->user()->dependencia->depe_depende)->get();
        $schedules = AssingSchedule::where('dependencia_id', auth()->user()->dependencia->depe_depende)
            ->where('type', 0)
            ->where('status', 1)
            ->get();
        $assistances = Assistance::select(['id', 'entry', 'exit', 'entry_time', 'output_time'])
            ->where('user_id', auth()->user()->id)
            ->whereBetween('entry', [date("Y-m-d"), $carbon->toDateString()])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json(['user' => $user, 'assistances' => $assistances, 'ips' => $ips, 'schedules' => $schedules], 200);
    }

    public function closed(Request $request, Assistance $assistance)
    {
        $assistance->exit = now();
        $assistance->updated_ip = $request->ip;
        $assistance->save();
        return response()->json(['status' => true], 200);
    }

    public function validated(Assistance $assistance)
    {
        $assistance->validate = true;
        $assistance->save();
        return response()->json(['status' => true, 'id' => $assistance->id], 200);
    }

    public function excel(Request $request)
    {


        $where[] = ['td2.iddependencia', $request->depe_depende];
        $whereUser = [];

        if ($request->iddependencia != null) {
            $where[] = ['dependencia_id', $request->iddependencia];
            $whereUser[] = ['depe_id', $request->iddependencia];
        }
        if ($request->user_id != null) {
            $where[] = ['user_id', $request->user_id];
            $whereUser[] = ['id', $request->user_id];
        }
        if ($request->adm_estado != null) {
            $whereUser[] = ['adm_estado', $request->adm_estado];
        }

        switch ($request->tipo) {

            case '1': {
                    $carbon = new Carbon($request->currentDateEnd);
                    $carbon->addDay();

                    break;
                }
            case '2': {
                    $fecha = explode('-', $request->currentDate);
                    $newFecha = $fecha[0] . '-' . $request->month_id . '-01';
                    $carbon = new Carbon($newFecha);
                    $carbon->addMonth();

                    $where[] = ['user_id', auth()->user()->id];

                    $assistance = Assistance::query()
                        ->where($where)
                        ->whereBetween('entry', [$newFecha, $carbon->toDateString()])
                        ->with(['usuario', 'dependencia'])
                        ->join('tram_dependencia as td1', 'dependencia_id', '=', 'td1.iddependencia')
                        ->leftJoin('tram_dependencia as td2', 'td1.depe_depende', '=', 'td2.iddependencia')
                        ->get();

                    return $assistance->map(function ($item) {
                        return [
                            'Unidad Organica' => $item->dependencia['depe_nombre'],
                            'Usuario'         => $item->usuario['adm_name'] . " " . $item->usuario['adm_lastname'],
                            'DNI'             => $item->usuario['adm_dni'],
                            'Fecha'           => explode(" ", $item->entry)[0],
                            'Hora entrada'    => explode(" ", $item->entry)[1],
                            'Hora salida'     => $item->exit != null ? explode(" ", $item->exit)[1] : '',
                            'Estado'          => $item->status === null ? '' : ($item->status ? 'dentro de la tolerancia' : 'fuera de la tolerancia'),
                        ];
                    });
                    break;
                }
        }


        $users = User::select(['id', 'adm_name', 'adm_lastname', 'adm_dni', 'depe_id', 'td1.depe_nombre'])
            ->where('td2.iddependencia', $request->depe_depende)
            ->where($whereUser)
            ->join('tram_dependencia as td1', 'depe_id', '=', 'td1.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td1.depe_depende', '=', 'td2.iddependencia')
            ->orderBy('td1.iddependencia', 'asc')
            ->get(); //todos los usuarios (activos o inactivos),que pertenezcan a a dependencia

        $asistencias = Assistance::query()
            ->where($where)
            ->whereBetween('entry', [$request->currentDate, $carbon->toDateString()])
            ->join('tram_dependencia as td1', 'dependencia_id', '=', 'td1.iddependencia')
            ->leftJoin('tram_dependencia as td2', 'td1.depe_depende', '=', 'td2.iddependencia')
            ->orderBy('entry', 'asc')
            ->get(); //todas las asistencias del periodo de la dependencia

        $return = [];

        $diaHasta = new Carbon($request->currentDateEnd);
        $diaInicio = new Carbon($request->currentDate);


        foreach ($users as $id => $user) {
            $as = collect($asistencias)->where('user_id', $user->id);
            $tempInicio = $diaInicio->copy();
            $temHasta = $diaHasta->copy();
            do {
                $assistances=$as->filter(function ($item) use ($tempInicio) {
                    return $item->entry->greaterThanOrEqualTo($tempInicio) && $item->entry->lessThanOrEqualTo($tempInicio->copy()->endOfDay());
                }); 
                foreach ($assistances as $assistance) {
                    $return[] = [
                        'Unidad Organica' => $user->depe_nombre,
                        'Usuario'         => $user->adm_name . " " . $user->adm_lastname,
                        'DNI'             => $user->adm_dni,
                        'Fecha'           => $tempInicio->toDateString(),
                        'Hora entrada'    => ($assistance != null) ? (explode(" ", $assistance->entry)[1]) : '',
                        'Hora salida'     => $assistance != null && $assistance->exit != null ? explode(" ", $assistance->exit)[1] : '',
                        'Estado'          => $assistance != null ? ($assistance->status === null ? '' : ($assistance->status ? 'dentro de la tolerancia' : 'fuera de la tolerancia')) : 'No marco',
                    ];
                }
                if(!count($assistances)>0){
                    $return[] = [
                        'Unidad Organica' => $user->depe_nombre,
                        'Usuario'         => $user->adm_name . " " . $user->adm_lastname,
                        'DNI'             => $user->adm_dni,
                        'Fecha'           => $tempInicio->toDateString(),
                        'Hora entrada'    =>  '',
                        'Hora salida'     =>  '',
                        'Estado'          =>  'No marco',
                    ];
                }
                $tempInicio->addDay();
            } while ($temHasta->diffInDays($tempInicio, false) <= 0);
        }
        return $return;
    }

    public function invalidated(Assistance $assistance)
    {
        $assistance->validate = false;
        $assistance->save();
        return response()->json(['status' => true, 'id' => $assistance->id], 200);
    }
}
