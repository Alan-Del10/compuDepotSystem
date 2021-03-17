<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Es la función que ejecuta el logueo y valida los tipos de usuario para dar permisos al usuario
     * @param Request
     * @return Response
     */
    public function login(Request $request)
    {
        $this->validator($request);
        if(Auth::attempt($request->only('email','password'))){
            $guard = DB::table('usuario')->leftJoin('tipo_usuario', 'tipo_usuario.id_tipo_usuario', 'usuario.id_tipo_usuario')->where('email',$request->email)->get();
            if(Auth::guard($guard[0]->guard)->attempt($request->only('email','password'), $request->filled('remember'))){
                return redirect()->intended('/dashboard')->with('status','Has iniciado sesión como '.$guard[0]->puesto);
            }
            //Fallo de autenticación...
            return $this->loginFailed();
        }
        //Fallo de autenticació...
        return $this->loginFailed();
    }

    /**
     * Valida los datos dados por el login
     * @param Request
     * @return Response
     */
    private function validator(Request $request)
    {
        //Validamos los datos
        Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ])->validate();
    }

    /**
     * Ejecuta la acción que debe de proceder si falla la autenticación
     * @return Response
     */
    private function loginFailed(){
        return redirect()
            ->back()
            ->withInput()
            ->with('error','Login failed, please try again!');
    }

    /*protected function guard()
    {
        return Auth::guard('admin');
    }*/
}
