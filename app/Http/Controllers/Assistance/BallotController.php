<?php

namespace App\Http\Controllers\Assistance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Assistance\Ballot;
use DB;
use Carbon\Carbon;

class BallotController extends Controller
{
   
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {  
            try{
        
                $rules = [
                    'departure_reason'  => 'required',
                    'destination'       => 'required',
                    'justification'     => 'required'
                ];
                $this->validate($request, $rules);
        
                $ballot = new Ballot([
                    'user_id'           => auth()->user()->id,
                    'dependencia_id'    => auth()->user()->depe_id,
                    'departure_reason'  => $request->departure_reason,
                    'destination'       => $request->destination,
                    'justification'     => $request->justification,
                    'updated_by'        => auth()->user()->id,
                ]);
                $ballot->save();
        
                return response()->json(['status' => true], 200);
            }
            catch(\Exception $e) {
                return response()->json(['status' => false], 200);
            }
         });   
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

    public function autorizar(Ballot $ballot)
    {
        $ballot->authorized = true;
        $ballot->authorized_user_id = auth()->user()->id;
        $ballot->authorized_updated_at = now();
        $ballot->save();
        return response()->json(['status' => true, 'id' => $ballot->id], 200);
    }

    public function aperturar(Ballot $ballot)
    {
        $ballot->exit = now();
        $ballot->updated_by = auth()->user()->id;
        $ballot->save();
        return response()->json(['status' => true, 'id' => $ballot->id, 'exit' => $ballot->exit->toDateTimeString()], 200);
    }

    public function cerrar(Ballot $ballot)
    {
        $ballot->return = now();
        $ballot->save();
        return response()->json(['status' => true, 'id' => $ballot->id, 'return' => $ballot->return->toDateTimeString()], 200);
    }

    public function excel(Request $request)
    {
        
        $where[] = ['td2.iddependencia', $request->depe_depende];

        if ($request->iddependencia != null){
            $where[] = ['dependencia_id', $request->iddependencia];
        }
        if ($request->user_id != null) {
            $where[] = ['user_id', $request->user_id];
        }
        $carbon = new Carbon($request->currentDateEnd);
        $carbon->addDay();

        $ballot = Ballot::select([
            'id',
            'user_id',
            'dependencia_id',
            'departure_reason',
            'destination',
            'justification',
            'exit',
            'return',
            'authorized',
            'ballots.created_at as fecha'
            ])
        ->where($where)
        ->whereBetween('ballots.created_at', [$request->currentDate, $carbon->toDateString()])
        ->with(['usuario','dependencia'])
        ->join('tram_dependencia as td1', 'dependencia_id', '=', 'td1.iddependencia')
        ->leftJoin('tram_dependencia as td2', 'td1.depe_depende', '=', 'td2.iddependencia')
        ->get();

        return $ballot->map(function ($item) {
            return [
                'Unidad Organica' => $item->dependencia['depe_nombre'],
                'Usuario'         => $item->usuario['adm_name'] . " " . $item->usuario['adm_lastname'],
                'DNI'             => $item->usuario['adm_dni'],
                'Fecha'           => explode(" ", $item->fecha)[0],
                'Hora salida'     => $item->exit != null ? explode(" ", $item->exit)[1]:'',
                'Hora retorno'    => $item->return != null ? explode(" ", $item->return)[1]:'',
                'Estado'          => $item->authorized?'Autorizado':'Sin autorizar',
                'Destino'         => $item->destination,
                'Justificación'   => $item->justification,
            ];
        });
    }
}
