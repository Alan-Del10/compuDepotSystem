<?php

namespace App\Http\Controllers;

use App\BitacoraGeneral;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        return view('layouts.app');

    }

    public function dashboard()
    {
        $logs = BitacoraGeneral::leftJoin('usuario', 'usuario.id', 'bitacora_general.id_usuario')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'bitacora_general.id_sucursal')->orderBy('fecha_log_general','DESC')->paginate(5);
        return view('Inicio.dashboard', compact('logs'));

    }
}
