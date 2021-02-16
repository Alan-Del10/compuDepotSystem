<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Sucursal;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = DB::table('usuario')
        ->leftJoin('tipo_usuario', 'tipo_usuario.id_tipo_usuario', 'usuario.id_tipo_usuario')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'usuario.id_sucursal')
        ->orderby('id','asc')->get();
        return view('auth.usuarios',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::where('id',$id)->leftJoin('tipo_usuario', 'tipo_usuario.id_tipo_usuario', 'usuario.id_tipo_usuario')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'usuario.id_sucursal')->get();
        $sucursales = Sucursal::get();
        $tipo_usuarios = DB::table('tipo_usuario')->where('estatus', 1)->get();
        return view('auth.modificarUsuario', compact('usuario', 'sucursales', 'tipo_usuarios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $data = $request->except('_method','_token');
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($data, [
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255',
                'password' => 'nullable|string|min:8|confirmed',
                'tipo_usuario' => 'nullable|string',
                'sucursal' => 'nullable|string'
            ]);
            $usuario = User::find($id);
            $id_tipo_usuario = DB::table('tipo_usuario')->where('puesto', $data['tipo_usuario'])->first();
            $id_sucursal = Sucursal::where('sucursal', $data['sucursal'])->first();
            $id_tipo_usuario = $id_tipo_usuario->id_tipo_usuario;
            $id_sucursal = $id_sucursal->id_sucursal;
            if(!$request->password == true){
                $json = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'id_tipo_usuario' => $id_tipo_usuario,
                    'id_sucursal' => $id_sucursal
                ];
            }else{
                $json = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'id_tipo_usuario' => $id_tipo_usuario,
                    'id_sucursal' => $id_sucursal
                ];
            }

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                //Validamos que se haya modificado la información y regresamos un mensaje sobre el estado
                if($usuario->update($json)){
                    return redirect()->back()->with('message', 'Se modificó correctamente el usuario.');
                }else{
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar modificar los datos');
                }

            }
        } catch (\Throwable $th) {
            $request->flash();
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Abre la vista del perfil del usuario logueado
     *
     * @return \Illuminate\Http\Response
     */
    public function showPerfil(){
        $perfil = Auth::user();
        return view('auth.modificarPerfil', compact('perfil'));
    }

    /**
     * Actualiza el perfil del usuario que está logueado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePerfil(Request $request, $id)
    {
        try{
            $data = $request->except('_method','_token');
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($data, [
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255',
                'password' => 'nullable|string|min:8|confirmed'
            ]);
            $usuario = User::find($id);
            if(!$request->password == true){
                $json = [
                    'name' => $request->name,
                    'email' => $request->email
                ];
            }else{
                $json = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ];
            }

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                //Validamos que se haya modificado la información y regresamos un mensaje sobre el estado
                if($usuario->update($json)){
                    return redirect()->back()->with('message', 'Se modificó correctamente el usuario.');
                }else{
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar modificar los datos');
                }

            }
        } catch (\Throwable $th) {
            $request->flash();
            return redirect()->back()->withErrors($th);
        }
    }
}
