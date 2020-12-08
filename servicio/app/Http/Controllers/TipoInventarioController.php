<?php

namespace App\Http\Controllers;

use App\TipoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TipoInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposInventario = TipoInventario::orderby('id_tipo_inventario','asc')->get();
        return view('TipoInventario.tipoInventario', compact('tiposInventario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('TipoInventario.agregarTipoInventario');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'descripcion' => 'required|max:200'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                TipoInventario::insert([
                    'descripcion' => $request->descripcion
                ]);
                return redirect()->back()->with('message', 'Se agregó correctamente el tipo de inventario.');
            }

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoInventario  $tipoInventario
     * @return \Illuminate\Http\Response
     */
    public function show(TipoInventario $tipoInventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoInventario  $tipoInventario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoInventario = TipoInventario::find($id);
        return view('TipoInventario.modificarTipoInventario', compact('tipoInventario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoInventario  $tipoInventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Si surge un error lo controlamos con el try/catch
        try {
            $data = $request->except('_method','_token');
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($data, [
                'descripcion' => 'required|max:200'
            ]);
            $tipoInventario = TipoInventario::find($id);
            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                //Validamos que se haya modificado la información y regresamos un mensaje sobre el estado
                if($tipoInventario->update($data)){
                    return redirect()->back()->with('message', 'Se modificó correctamente el tipo de inventario.');
                }else{
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar modificar los datos');
                }

            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoInventario  $tipoInventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoInventario $tipoInventario)
    {
        //
    }
}
