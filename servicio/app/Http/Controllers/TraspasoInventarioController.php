<?php

namespace App\Http\Controllers;

use App\TraspasoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TraspasoInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $traspasos = TraspasoInventario::orderBy('id_traspaso_inventario', 'DESC')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'traspaso_inventario.id_sucursal_salida')
        ->leftJoin('sucursal as sucursal_2', 'sucursal_2.id_sucursal', 'traspaso_inventario.id_sucursal_entrada')
        ->leftJoin('usuario', 'usuario.id', 'traspaso_inventario.id_usuario')
        ->paginate(10);
        return view('TraspasoInventario.traspasoInventario', compact('traspasos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = DB::table('sucursal')->get();
        return view('TraspasoInventario.agregarTraspasoInventario', compact('sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TraspasoInventario  $traspasoInventario
     * @return \Illuminate\Http\Response
     */
    public function show(TraspasoInventario $traspasoInventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TraspasoInventario  $traspasoInventario
     * @return \Illuminate\Http\Response
     */
    public function edit(TraspasoInventario $traspasoInventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TraspasoInventario  $traspasoInventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TraspasoInventario $traspasoInventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TraspasoInventario  $traspasoInventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(TraspasoInventario $traspasoInventario)
    {
        //
    }
}
