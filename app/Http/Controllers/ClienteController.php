<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::orderBy('id_cliente', 'asc')->get();
        return view('Cliente.cliente',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Cliente.agregarCliente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $data = json_decode ($request->array,true);

            $res = Cliente::insert(
                [
                    'nombre_completo' => strtoupper($request->nombre),
                    'telefono' => $request->telefono,
                    'whatsapp' => $request->whatsapp,
                    'correo' => $request->correo,
                    'id_tipo_cliente' => $request->tipo_cliente
                ]
            );
            if ($res){
                if($request->ajax()){
                    $id = DB::getPdo()->lastInsertId();
                    $cliente = DB::table('cliente')->where('id_cliente', $id)->get();
                    return $cliente;
                }else{
                    return redirect()->back()->with('message', 'El cliente se agregó correctamente!');
                }
            }else{
                return ['res'=>'error', 'message'=>'Hubo un error al intentar agregar al cliente. Verifíca que el cliente no exista ya en el sistema!'];
            }
        } catch (\Throwable $th) {
            return error_log($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
