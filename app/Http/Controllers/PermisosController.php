<?php

namespace App\Http\Controllers;

use App\Permisos;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo_usuario = DB::table('tipo_usuario')->get();
        //dd($tipo_usuario);
        return view('Permisos.permisos', compact('tipo_usuario'));
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
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function show(Permisos $permisos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function edit(Permisos $permisos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permisos $permisos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permisos  $permisos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permisos $permisos)
    {
        //
    }
}
