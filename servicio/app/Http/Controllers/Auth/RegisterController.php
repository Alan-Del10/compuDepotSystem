<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sucursal;

/*Mandar mensaje a Bitacora del registro */
use App\Http\Controllers\BitacoraGeneralController;
use DateTime;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/Usuario';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:usuario'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tipo_usuario' => ['required', 'string'],
            'sucursal' => ['required', 'string']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $id_tipo_usuario = DB::table('tipo_usuario')->where('puesto', $data['tipo_usuario'])->first();
        $id_sucursal = Sucursal::where('sucursal', $data['sucursal'])->first();
        /*if($id_tipo_usuario->isEmpty() && $id_sucursal->isEmpty()){
            return redirect()->back()->withErrors('error', 'El puesto o sucursal están mal!');
        }*/
        $id_tipo_usuario = $id_tipo_usuario->id_tipo_usuario;
        $id_sucursal = $id_sucursal->id_sucursal;

        dd($data['sucursal']);

        $fecha_login = new DateTime();

        (new BitacoraGeneralController)->mensajeTelegram($data['name'],$data['sucursal'],null,$fecha_login,null,null,null,null,null,$data['tipo_usuario'],$data['email']);


        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_sucursal' => $id_sucursal,
            'id_tipo_usuario' => $id_tipo_usuario
        ]);
    }
}
