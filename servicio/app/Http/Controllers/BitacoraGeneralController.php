<?php

namespace App\Http\Controllers;

use App\BitacoraGeneral;
use Illuminate\Http\Request;

class BitacoraGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = BitacoraGeneral::leftJoin('usuario', 'usuario.id', 'bitacora_general.id_usuario')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'bitacora_general.id_sucursal')->orderBy('fecha_log_general','DESC')->paginate(10);
        return view('Bitacora.bitacoraGeneral', compact('logs'));
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
        try {

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BitacoraGeneral  $bitacoraGeneral
     * @return \Illuminate\Http\Response
     */
    public function show(BitacoraGeneral $bitacoraGeneral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BitacoraGeneral  $bitacoraGeneral
     * @return \Illuminate\Http\Response
     */
    public function edit(BitacoraGeneral $bitacoraGeneral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BitacoraGeneral  $bitacoraGeneral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BitacoraGeneral $bitacoraGeneral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BitacoraGeneral  $bitacoraGeneral
     * @return \Illuminate\Http\Response
     */
    public function destroy(BitacoraGeneral $bitacoraGeneral)
    {
        //
    }
}
