<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Admin;

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

    public function authenticate(Request $request)
    {
        $this->validator($request);
        if(Auth::attempt($request->only('email','password'))){
            $guard = Admin::select('guard')->leftJoin('tipo_usuario', 'tipo_usuario.id_tipo_usuario', 'usuario.id_tipo_usuario')->where('email',$request->email)->first();
            if(Auth::guard($guard->guard)->attempt($request->only('email','password'))){
                return redirect()->intended('/home');
            }
            //Authentication failed...
            return $this->loginFailed();
        }
        //Authentication failed...
        return $this->loginFailed();
    }

    private function validator(Request $request)
    {
        //Validamos los datos
        Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:usuario',
            'password' => 'required|string|min:8',
        ])->validate();
    }

    /*protected function guard()
    {
        return Auth::guard('admin');
    }*/
}
