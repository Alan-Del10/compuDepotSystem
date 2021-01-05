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
        $inventarios = Inventario::orderby('id_inventario','asc')
        ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
        ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
        ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')->get();
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
        $subcategorias = DB::table('sub_categoria')->get();
        return view('Inventario.agregarInventario',  compact('modelos', 'marcas', 'capacidades', 'colores', 'categorias', 'subcategorias'));
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
                'categoria' => 'required',
                'modelo' => 'required',
                'color' => 'required',
                'titulo' => 'nullable|max:50',
                'descripcion' => 'nullable|max:200',
                'peso' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'capacidad' => 'nullable',
                'costo' => 'nullable|numeric',
                'stock' => 'required|numeric',
                'stockMin' => 'nullable|numeric',
                'publico' => 'required|numeric',
                'mayoreo' => 'nullable|numeric',
                'precioMin' => 'nullable|numeric',
                'precioMax' => 'nullable|numeric'
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
                    if($request->checkOnline == "on"){
                        $online = true;
                    }else{
                        $online = false;
                    }
                    Inventario::insert([
                        'upc' => $request->upc,
                        'id_categoria' => $request->categoria,
                        'id_modelo' => $request->modelo,
                        'titulo_inventario' => $request->titulo,
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
                        'precio_mayoreo' => $request->mayoreo,
                        'precio_min' => $request->precioMin,
                        'precio_max' => $request->precioMax,
                        'id_color' => $request->color,
                        'venta_online' => $online
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
                'categoria' => 'required',
                'modelo' => 'required',
                'color' => 'required',
                'titulo' => 'nullable|max:50',
                'descripcion' => 'nullable|max:200',
                'peso' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'capacidad' => 'nullable',
                'costo' => 'nullable|numeric',
                'stock' => 'required|numeric',
                'stockMin' => 'nullable|numeric',
                'publico' => 'required|numeric',
                'mayoreo' => 'nullable|numeric',
                'precioMin' => 'nullable|numeric',
                'precioMax' => 'nullable|numeric'
            ]);
            $inventario = Inventario::find($id);
            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                $fecha_modificacion = new DateTime();
                if($request->checkOnline == "on"){
                    $online = true;
                }else{
                    $online = false;
                }
                $categoria = DB::table('categoria')->where('categoria', $request->categoria)->get();
                if(count($categoria) > 0){
                    $categoria = $this->convertToJSON($categoria);
                }else{
                    $request->flash();
                    return redirect()->to('Inventario.create')->withErrors('error', 'Algo pasó al intenar modificar los datos!');
                }
                $modelo = DB::table('modelo')->where('modelo', $request->modelo)->get();
                $modelo = $this->convertToJSON($modelo);
                $marca = DB::table('marca')->where('marca', $request->marca)->get();
                $marca = $this->convertToJSON($marca);
                $color = DB::table('color')->where('color', $request->color)->get();
                $color = $this->convertToJSON($color);
                $capacidad = DB::table('capacidad')->where('tipo', $request->capacidad)->get();
                $capacidad = $this->convertToJSON($capacidad);
                //Validamos que se haya modificado la información y regresamos un mensaje sobre el estado
                $json_actualizar = [
                    'upc' => $request->upc,
                    'id_categoria' => $categoria[0]->id_categoria,
                    'id_modelo' => $modelo[0]->id_modelo,
                    'titulo_inventario' => $request->titulo,
                    'descripcion_inventario' => $request->descripcion,
                    'peso' => $request->peso,
                    'costo' => $request->costo,
                    'largo' => $request->largo,
                    'alto' => $request->alto,
                    'ancho' => $request->ancho,
                    'fecha_modificacion' => date_format($fecha_modificacion, 'Y-m-d H:i:s'),
                    'id_capacidad' => $capacidad[0]->id_capacidad,
                    'costo' => $request->costo,
                    'stock' => $request->stock,
                    'stock_min' => $request->stockMin,
                    'precio_publico' => $request->publico,
                    'precio_mayoreo' => $request->mayoreo,
                    'precio_min' => $request->precioMin,
                    'precio_max' => $request->precioMax,
                    'id_color' => $color[0]->id_color,
                    'venta_online' => $online
                ];
                if($inventario->update($json_actualizar)){
                    return redirect()->back()->with('message', 'Se modificó correctamente el inventario.');
                }else{
                    $request->flash();
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar modificar los datos!');
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
            $articulo = Inventario::leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')->
            leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->
            leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')->
            leftJoin('color', 'color.id_color', 'inventario.id_color')->
            leftJoin('capacidad', 'capacidad.id_capacidad', 'inventario.id_capacidad')->where('upc', $request->upc)->get();
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

    /**
     * Convertir datos de los get de las consultas
     */
    public function convertToJSON($resultado){
        return json_decode(json_encode($resultado));
    }
}
