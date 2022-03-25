<?php

namespace App\Http\Controllers\Tramite;

use App\Mail\MesaElectronica\validarCorreo;
use App\Models\Tramite\PersonaCorreo;
use App\Persona;
use App\PersonaJuridica;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Mail;
use DB;

class personaController extends Controller
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
        $persona = Persona::find($request->dni);
        if ($persona == null) {
            $persona = new Persona();
        }
        $persona->fill($request->only($persona->getFillable()));
        $persona->id = $request->dni;
        $persona->save();
        $persona->load('correos');
        return $persona;
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


    public function dni($id)
    {
        $persona = Persona::find($id);
        if ($persona === null) {
            $retorno = file_get_contents(str_replace('%s', $id, env('DNI_WEBSERVICE')));
            $persona = new Persona();
            $retorno = json_decode($retorno);
            if (isset($retorno->apPrimer)) {
                $persona->id  = $id;
                $persona->dni = $id;
                $persona->setData($retorno);
                $persona->save();
            } else
                return ['error' => 'No Existe en el registro'];
        }
        $persona->load('correos');
        return $persona;
    }

    public function ruc($id)
    {
        $persona = PersonaJuridica::where('ddp_numruc', '=', $id)->first();
        if ($persona === null) {
            $retorno = file_get_contents(str_replace('%s', $id, env('RUC_WEBSERVICE')));
            $persona                = new PersonaJuridica();
            $retorno                = (array)json_decode($retorno);
            $retorno['ddp_nombre']  = trim($retorno['ddp_nombre']);
            $retorno['desc_ciiu']   = trim($retorno['desc_ciiu']);
            $retorno['desc_dist']   = trim($retorno['desc_dist']);
            $retorno['desc_estado'] = trim($retorno['desc_estado']);
            $retorno['desc_flag22'] = trim($retorno['desc_flag22']);
            if (isset($retorno['ddp_numruc']) && $retorno['ddp_numruc'] !="") {
                $persona->fill($retorno);
                $persona->save();
            } else
                return ['error' => 'No Existe en el registro'];
        }
        $persona->load('correos');
        return $persona;
    }

    public function registrarCorreo(Request $request, $dni)
    {
        return DB::transaction(function () use ($request, $dni) {
            $digits = 5;
            if ($request->tipo == 1)
                $persona = Persona::find($dni);
            else
                $persona = PersonaJuridica::where('ddp_numruc', '=', $dni)->first();

            try{
                $rules = [
                    'correo' => 'required|email'
                ];
        
                $this->validate($request, $rules);
    
                $correo = new PersonaCorreo([
                    'correo' => $request->correo,
                    'codigo' => rand(pow(10, $digits - 1), pow(10, $digits) - 1),
                    'estado' => 0,
                ]);

                if (count($persona->correos->where('correo', $request->correo)) == 0) {
                    $persona->correos()->save($correo);
                    \MultiMail::to($correo->correo)->from(array_rand (config('multimail.emails')))->queue(new validarCorreo($persona, $correo));
                    $persona->load('correos');
                    return response()->json(['status' => true, 'correo' => $persona->correos, 'error' => null], 200);
                } else
                    return response()->json(['status' => true, 'error' => "el correo ya se encuentra registrado"], 200);
            }
            catch(\Exception $e){
                return response()->json(['status' => false], 200);
            }
          
        });       
    }

    public function validarCorreo(Request $request, $dni)
    {
        if ($request->tipo == 1)
            $persona = Persona::find($dni);
        else
            $persona = PersonaJuridica::where('ddp_numruc', '=', $dni)->first();
        $correo = $persona->correos
            ->where('correo', $request->correo)
            ->where('estado', 0)
            ->where('codigo', $request->codigo);

        if (count($correo) == 1) {
            $correo->first()->estado = 1;
            $correo->first()->save();

            $persona->load('correos');
            return response()->json(['status' => true, 'correos' => $persona->correos], 200);
        } else {
            return response()->json(['status' => false, 'correos' => []], 200);
        }

    }

    public function eliminarCorreo(Request $request, $dni, $correo)
    {
        if ($request->tipo == 1)
            $persona = Persona::find($dni);
        else
            $persona = PersonaJuridica::where('ddp_numruc', '=', $dni)->first();
        PersonaCorreo::destroy($correo);
        $persona->load('correos');
        return $persona->correos;
    }

    public function correos(Request $request)
    {
        $where = function ($query) use ($request) {

            if ($request->dni != null)
                $query->where('persona_dni', 'LIKE', "%$request->dni%")
                    ->orWhere('correo', 'LIKE', "%$request->dni%");
        };
        return PersonaCorreo::query()->with(['persona', 'ruc'])->where($where)->paginate(15);
    }

    public function storeCorreo(Request $request)
    {
        $persona         = PersonaCorreo::find($request->id);
        $persona->correo = $request->correo;
        $persona->save();

    }
}
