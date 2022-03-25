<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController  extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'password2' => hash('sha384', $data['password']),
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        //dd("hola");
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();
            $adm_vigencia = new Carbon($user->adm_vigencia);
            $now = Carbon::today();
            $activo = $adm_vigencia->greaterThanOrEqualTo($now);//funcion compara y erifica si se encuentra activo
            if ($user->adm_estado==1 &&$activo && $this->attemptLogin($request)) {
                if ($request->modal)
                    return json_encode((Object)['status' => 'logued']);
                else
                    return $this->sendLoginResponse($request);
            }
            elseif($user->adm_estado!=1) {

                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([$this->username() => 'su cuenta se encuentra desactivada.']);
            }
            elseif(!$activo) {

                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([$this->username() => 'Su cuenta no se encuentra vigente.']);
            }

        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
        //return view("welcome");
    }
    public function username(){
        return property_exists($this, 'username') ? $this->username : 'adm_email';
    }

    public function authenticated(Request $request, $user)
    {
        
    }

}
