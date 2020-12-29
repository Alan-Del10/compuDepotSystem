<?php

namespace App\Http\Controllers;

use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DateTime;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventarios = Inventario::orderby('id_inventario','asc')->get();
        return view('Inventario.inventario', compact('inventarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response}
     */
    public function create()
    {
        $modelos = DB::table('modelo')->get();
        $marcas = DB::table('marca')->get();
        $capacidades = DB::table('capacidad')->get();
        $colores = DB::table('color')->get();
        $categorias =  DB::table('categoria')->get();
        return view('Inventario.agregarInventario',  compact('modelos', 'marcas', 'capacidades', 'colores', 'categorias'));
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
                'upc' => 'required|numeric',
                'categoria' => 'required|numeric',
                'modelo' => 'required|numeric',
                'color' => 'required|numeric',
                'titulo' => 'nullable|max:50',
                'descripcion' => 'nullable|max:200',
                'peso' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'capacidad' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'stock' => 'required|numeric',
                'stockMin' => 'nullable|numeric',
                'publico' => 'required|numeric'

            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }else{
                $articulo = Inventario::where('upc', $request->upc)->get();
                if(count($articulo) == 1){
                    foreach($articulo as $art){
                        $id_inventario = $art->id_inventario;
                    }
                    $this->update($request, $id_inventario);
                }else{
                    $fecha_alta = new DateTime();
                    Inventario::insert([
                        'upc' => $request->upc,
                        'id_categoria' => $request->categoria,
                        'id_modelo' => $request->modelo,
                        'titulo' => $request->titulo,
                        'descripcion_inventario' => $request->descripcion,
                        'peso' => $request->peso,
                        'costo' => $request->costo,
                        'largo' => $request->largo,
                        'alto' => $request->alto,
                        'ancho' => $request->ancho,
                        'fecha_alta' => date_format($fecha_alta, 'Y-m-d H:i:s'),
                        'id_capacidad' => $request->capacidad,
                        'costo' => $request->costo,
                        'stock' => $request->stock,
                        'stock_min' => $request->stockMin,
                        'precio_publico' => $request->publico,
                        'id_color' => $request->color
                    ]);
                    return redirect()->back()->with('success', 'Se agregó correctamente el artículo.');
                }
            }

        } catch (\Throwable $th) {
            $request->flash();
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventario = Inventario::find($id);
        $modelos = DB::table('modelo')->get();
        $marcas = DB::table('marca')->get();
        return view('Inventario.modificarInventario', compact('inventario', 'modelos', 'marcas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $data = $request->except('_method','_token');
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'upc' => 'required|numeric',
                'categoria' => 'required|numeric',
                'modelo' => 'required|numeric',
                'color' => 'required|numeric',
                'titulo' => 'nullable|max:50',
                'descripcion' => 'nullable|max:200',
                'peso' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'capacidad' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'stock' => 'required|numeric',
                'stockMin' => 'nullable|numeric',
                'publico' => 'required|numeric'

            ]);
            $inventario = Inventario::find($id);
            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                //Validamos que se haya modificado la información y regresamos un mensaje sobre el estado
                if($inventario->update($data)){
                    return redirect()->back()->with('message', 'Se modificó correctamente el inventario.');
                }else{
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar modificar los datos!');
                }

            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventario $inventario)
    {
        //
    }

    /**
     * Verifica el UPC enviao desde las vistas para comprobar que exista en nuestro sistema el artículo del inventario
     *
     */
    public function verificarUPC(Request $request){
        try {
            $articulo = Inventario::leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')->where('upc', $request->upc)->get();
            if(count($articulo) > 0){
                return $articulo;
            }else{
                return ['res'=>false];
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Agrega a la base de datos las capacidades de almacenamiento
     */
    public function agregarCapacidad(Request $request)
    {
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'capacidadDescripcion' => 'required|numeric'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                DB::table('capacidad')->insert(
                    ['tipo' => $request->capacidadDescripcion]
                );
                if($request->ajax()){
                    $id = DB::getPdo()->lastInsertId();
                    $capacidadNueva = DB::table('capacidad')->where('id_capacidad', $id)->get();
                    return $capacidadNueva;
                }else{
                    return redirect()->back()->with('success', 'Se agregó correctamente la capacidad.');
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }

    }
}
