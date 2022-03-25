<?php
namespace App\Http\Controllers\Credito;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class IngresarController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Controlador de la autenticación de usuarios
    |--------------------------------------------------------------------------
    */
	//Muestra el formulario para login.
    
    public function showLogin()
    {
        // Verificamos que el usuario no esté autenticado
        if (Auth::check())
        {
            // Si está autenticado lo mandamos a la raíz donde estara el mensaje de bienvenida.
            return redirect('/');
        }
        // Mostramos la vista login.blade.php
        return View('auth.ingresar');
    }
	
	public function postLogin(Request $request){
        // Validamos los datos y además mandamos como un segundo parámetro la opción de recordar el usuario.
		$usuario = DB::table('cred_usuario')->where('usu_login', '=', $request->usu_login)->first();
		//dd($usuario);
        if(password_verify($request->usu_password, $usuario->usu_password))
        {
            // De ser datos válidos nos mandara a la bienvenida
            return redirect('/');
        }
        // En caso de que la autenticación haya fallado manda un mensaje al formulario de login y también regresamos los valores enviados con withInput().
        return redirect('login')
                    ->with('mensaje_error', 'Tus datos son incorrectos')
                    ->withInput();
	}
}