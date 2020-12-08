<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        return view('layouts.app');
  
    }

    public function dashboard()
    {
        return view('Inicio.dashboard');
  
    }
}
