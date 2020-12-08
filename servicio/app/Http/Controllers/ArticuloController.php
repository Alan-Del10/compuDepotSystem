<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DateTime;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articulos = Articulo::orderby('id_articulo','asc')->get();
        return view('Articulo.articulo', compact('articulos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelos = DB::table('modelo')->get();
        $marcas = DB::table('marca')->get();
        $capacidades = DB::table('capacidad')->get();
        return view('Articulo.agregarArticulo',  compact('modelos', 'marcas', 'capacidades'));
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
                'id_marca' => 'required|numeric',
                'id_modelo' => 'required|numeric',
                'descripcion' => 'required|max:200',
                'peso' => 'required|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'capacidad' => 'nullable|numeric'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                $fecha_alta = new DateTime();
                Articulo::insert([
                    'id_marca' => $request->marca,
                    'id_modelo' => $request->modelo,
                    'descripcion' => $request->descripcion,
                    'peso' => $request->peso,
                    'costo_promedio' => $request->costo,
                    'largo' => $request->largo,
                    'alto' => $request->alto,
                    'ancho' => $request->ancho,
                    'fecha_alta' => $fecha_alta,
                    'id_capacidad' => $request->capacidad
                ]);
                return redirect()->back()->with('success', 'Se agregó correctamente el artículo.');
            }

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articulo = Articulo::find($id);
        $modelos = DB::table('modelo')->get();
        $marcas = DB::table('marca')->get();
        return view('Articulo.modificarArticulo', compact('articulo', 'modelos', 'marcas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $articulo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo)
    {
        //
    }
}
