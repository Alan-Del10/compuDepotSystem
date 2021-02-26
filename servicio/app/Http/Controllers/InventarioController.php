<?php

namespace App\Http\Controllers;

use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DateTime;
use Mike42\Escpos\EscposImage;
use Image;
use Illuminate\Support\Facades\Storage;
use Rawilk\Printing\PrintTask;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use Rawilk\Printing\Contracts\Printer;
use Rawilk\Printing\Facades\Printing;
use Barryvdh\DomPDF\Facade as PDF;

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
        ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
        ->leftJoin('color', 'color.id_color', 'inventario.id_color')->paginate(10);
        $categorias =  DB::table('categoria')->where('estatus', 1)->get();
        $compatibilidades = DB::table('compatibilidad')->leftJoin('inventario', 'inventario.id_inventario', 'compatibilidad.id_inventario')
        ->leftJoin('modelo', 'modelo.id_modelo', 'compatibilidad.id_modelo')
        ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->get();
        return view('Inventario.inventario', compact('inventarios', 'categorias', 'compatibilidades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response}
     */
    public function create()
    {
        $modelos = DB::table('modelo')->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->where('modelo.estatus', 1)->get();
        $marcas = DB::table('marca')->where('estatus', 1)->get();
        $capacidades = DB::table('capacidad')->get();
        $colores = DB::table('color')->where('estatus', 1)->get();
        $categorias =  DB::table('categoria')->where('estatus', 1)->get();
        $subcategorias = DB::table('sub_categoria')->where('estatus', 1)->get();
        $proveedores = DB::table('proveedor')->get();
        return view('Inventario.agregarInventario',  compact('modelos', 'marcas', 'capacidades', 'colores', 'categorias', 'subcategorias', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'upc' => 'required|numeric|digits_between:12,14',
                'categoria' => 'required',
                'modelo' => 'required',
                'color' => 'required',
                'proveedor' => 'required',
                'titulo' => 'nullable|max:100',
                'descripcion' => 'nullable|max:200',
                'peso' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'stock' => 'required|numeric',
                'stockMin' => 'nullable|numeric',
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
                $id_inventario = "";
                if(count($articulo) == 1){
                    foreach($articulo as $art){
                        $id_inventario = $art->id_inventario;
                    }
                    return redirect()->back()->with('success', 'Este artículo ya existe!');
                    //$this->update($request, $id_inventario);
                }else{
                    $fecha_alta = new DateTime();
                    if($request->checkOnline == "on"){
                        $online = true;
                    }else{
                        $online = false;
                    }
                    $fileName = "";
                    if ($request->has('imagenProducto')) {
                        $image      = $request->file('imagenProducto');
                        $fileName   = $request->upc.'.'. $image->getClientOriginalExtension();
                        $img = Image::make($image->getRealPath());
                        $extension = $image->getClientOriginalExtension();
                        //dd($img);
                        $img->resize(120, 120, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->stream(); // <-- Key point

                        if(Storage::disk('local')->exists('public/inventario/'.$request->upc.'.'.$extension)) {
                            Storage::disk('local')->delete('public/inventario/'.$request->upc.'.'.$extension);
                        }
                        Storage::disk('local')->put('public/inventario'.'/'.$fileName, $img, 'public');
                    }else{
                        $verificarImagen = DB::table('inventario')->where('upc', $request->upc)->where('imagen', '!=', null)->get();
                        if(count($verificarImagen) > 0) {
                            $img = $this->convertToJSON($verificarImagen);
                            $fileName = $img[0]->imagen;

                        }
                    }
                    $categoria = DB::table('categoria')->where('categoria', $request->categoria)->get();
                    $categoria = $this->comprobarConsultaDB($categoria);
                    $modelo = DB::table('modelo')->where('modelo', $request->modelo)->get();
                    $modelo = $this->comprobarConsultaDB($modelo);
                    $marca = DB::table('marca')->where('marca', $request->marca)->get();
                    $marca = $this->comprobarConsultaDB($marca);
                    $color = DB::table('color')->where('color', $request->color)->get();
                    $color = $this->comprobarConsultaDB($color);
                    /*$capacidad = DB::table('capacidad')->where('tipo', $request->capacidad)->get();
                    $capacidad = $this->comprobarConsultaDB($capacidad);*/
                    $proveedor = DB::table('proveedor')->where('proveedor', $request->proveedor)->get();
                    $proveedor = $this->comprobarConsultaDB($proveedor);
                    $json_agregar = [
                        'upc' => $request->upc,
                        'id_categoria' => $categoria[0]->id_categoria,
                        'id_modelo' => $modelo[0]->id_modelo,
                        'id_proveedor' => $proveedor[0]->id_proveedor,
                        'titulo_inventario' => $request->titulo,
                        'descripcion_inventario' => $request->descripcion,
                        'costo' => $request->costo,
                        'largo' => $request->largo,
                        'alto' => $request->alto,
                        'ancho' => $request->ancho,
                        'peso' => $request->peso,
                        'fecha_alta' => date_format($fecha_alta, 'Y-m-d H:i:s'),
                        'costo' => $request->costo,
                        'stock' => $request->stock,
                        'stock_min' => $request->stockMin,
                        'precio_mayoreo' => $request->mayoreo,
                        'precio_min' => $request->precioMin,
                        'precio_max' => $request->precioMax,
                        'id_color' => $color[0]->id_color,
                        'venta_online' => $online,
                        'imagen' => $fileName
                    ];
                    //dd(Inventario::insert($json_agregar));
                    if(Inventario::insert($json_agregar)){
                        $id = DB::getPdo()->lastInsertId();
                        if(count($request->compatibilidad)!=0){
                            $compatibilidad = $request->compatibilidad;
                            foreach($compatibilidad as $compa){
                                $modelo2 = DB::table('modelo')->where('modelo', $compa['modelo'])->get();
                                $modelo2 = $this->comprobarConsultaDB($modelo2);
                                $insertarCompatibilidad = DB::table('compatibilidad')->insert([
                                    'id_inventario' => $id,
                                    'id_modelo' => $modelo2[0]->id_modelo
                                ]);
                                if(!$insertarCompatibilidad){
                                    $request->flash();
                                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                }
                            }
                        }
                        $this->imprimirEtiqueta($id);
                        return redirect()->back()->with('success', 'Se agregó correctamente el artículo.');
                    }else{
                        $request->flash();
                        return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                    }
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
        $inventario = Inventario::where('inventario.id_inventario',$id)
        ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
        ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
        ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
        ->leftJoin('color', 'color.id_color', 'inventario.id_color')
        ->leftJoin('capacidad', 'capacidad.id_capacidad', 'inventario.id_capacidad')
        ->leftJoin('proveedor', 'proveedor.id_proveedor', 'inventario.id_proveedor')->get();
        $detalle_inventario = DB::table('detalle_inventario')->select('detalle_inventario.*')
        ->leftJoin('inventario', 'inventario.id_inventario', 'detalle_inventario.id_inventario')->where('inventario.id_inventario', $id)->get();
        $compatibilidad = DB::table('compatibilidad')->where('id_inventario', $id)->leftJoin('modelo', 'modelo.id_modelo', 'compatibilidad.id_modelo')->get();
        //dd($detalle_inventario);
        $modelos = DB::table('modelo')->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->where('modelo.estatus', 1)->get();
        $marcas = DB::table('marca')->where('estatus', 1)->get();
        $capacidades = DB::table('capacidad')->get();
        $colores = DB::table('color')->where('estatus', 1)->get();
        $categorias =  DB::table('categoria')->where('estatus', 1)->get();
        $subcategorias = DB::table('sub_categoria')->where('estatus', 1)->get();
        $proveedores = DB::table('proveedor')->get();
        return view('Inventario.modificarInventario', compact('inventario', 'detalle_inventario', 'modelos', 'marcas', 'capacidades', 'colores', 'categorias', 'subcategorias', 'proveedores', 'compatibilidad'));
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
                'upc' => 'required|numeric|digits_between:12,14',
                'categoria' => 'required',
                'modelo' => 'required',
                'color' => 'required',
                'proveedor' => 'required',
                'titulo' => 'nullable|max:100',
                'descripcion' => 'nullable|max:200',
                'peso' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'stock' => 'required|numeric',
                'stockMin' => 'nullable|numeric',
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
                $fileName = "";

                if ($request->has('imagenProducto')) {
                    $image      = $request->file('imagenProducto');
                    $fileName   = $request->upc.'.'. $image->getClientOriginalExtension();
                    $img = Image::make($image->getRealPath());
                    $extension = $image->getClientOriginalExtension();
                    //dd($img);
                    $img->resize(120, 120, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->stream(); // <-- Key point

                    if(Storage::disk('local')->exists('public/inventario/'.$request->upc.'.'.$extension)) {
                        Storage::disk('local')->delete('public/inventario/'.$request->upc.'.'.$extension);
                    }
                    Storage::disk('local')->put('public/inventario'.'/'.$fileName, $img, 'public');
                }else{
                    $verificarImagen = DB::table('inventario')->where('upc', $request->upc)->where('imagen', '!=', null)->get();
                    if(count($verificarImagen) > 0) {
                        $img = $this->convertToJSON($verificarImagen);
                        $fileName = $img[0]->imagen;

                    }
                }
                $categoria = DB::table('categoria')->where('categoria', $request->categoria)->get();
                $categoria = $this->comprobarConsultaDB($categoria);
                $modelo = DB::table('modelo')->where('modelo', $request->modelo)->get();
                $modelo = $this->comprobarConsultaDB($modelo);
                $marca = DB::table('marca')->where('marca', $request->marca)->get();
                $marca = $this->comprobarConsultaDB($marca);
                $color = DB::table('color')->where('color', $request->color)->get();
                $color = $this->comprobarConsultaDB($color);
                $proveedor = DB::table('proveedor')->where('proveedor', $request->proveedor)->get();
                $proveedor = $this->comprobarConsultaDB($proveedor);
                //Validamos que se haya modificado la información y regresamos un mensaje sobre el estado
                $json_actualizar = [
                    'upc' => $request->upc,
                    'id_categoria' => $categoria[0]->id_categoria,
                    'id_modelo' => $modelo[0]->id_modelo,
                    'id_proveedor' => $proveedor[0]->id_proveedor,
                    'titulo_inventario' => $request->titulo,
                    'descripcion_inventario' => $request->descripcion,
                    'peso' => $request->peso,
                    'costo' => $request->costo,
                    'largo' => $request->largo,
                    'alto' => $request->alto,
                    'ancho' => $request->ancho,
                    'fecha_modificacion' => date_format($fecha_modificacion, 'Y-m-d H:i:s'),
                    'costo' => $request->costo,
                    'stock' => $request->stock,
                    'stock_min' => $request->stockMin,
                    'precio_mayoreo' => $request->mayoreo,
                    'precio_min' => $request->precioMin,
                    'precio_max' => $request->precioMax,
                    'id_color' => $color[0]->id_color,
                    'venta_online' => $online,
                    'imagen' => $fileName
                ];
                if($inventario->update($json_actualizar)){
                    if($request->compatibilidad && count($request->compatibilidad)!=0){
                        $compatibilidad = $request->compatibilidad;
                        foreach($compatibilidad as $compa){
                            $modelo2 = DB::table('modelo')->where('modelo', $compa['modelo'])->get();
                            $modelo2 = $this->comprobarConsultaDB($modelo2);
                            DB::table('compatibilidad')->where('id_inventario', $id)->delete();
                            $insertarCompatibilidad = DB::table('compatibilidad')->insert([
                                'id_inventario' => $id,
                                'id_modelo' => $modelo2[0]->id_modelo
                            ]);
                            if(!$insertarCompatibilidad){
                                $request->flash();
                                return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                            }
                        }
                    }
                    $this->imprimirEtiqueta($id);
                    return redirect()->back()->with('success', 'Se modificó correctamente el inventario.');
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
            $articulo = DB::table('inventario')->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')->
            leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->
            leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')->
            leftJoin('color', 'color.id_color', 'inventario.id_color')->
            leftJoin('capacidad', 'capacidad.id_capacidad', 'inventario.id_capacidad')->where('upc', $request->upc)->get();
            if(count($articulo) > 0){
                foreach($articulo as $art){
                    $id_inventario = $art->id_inventario;
                }
                $detalle = DB::table('detalle_inventario')->where('id_inventario', $id_inventario)->get();
                return [$articulo, $detalle];
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

    /**
     * Comprobar consulta
     */
    public function comprobarConsultaDB($data){
        if(count($data) > 0){
            return $this->convertToJSON($data);
        }else{
            $data->flash();
            return redirect()->route('Inventario.create')->withErrors('error', 'Algo pasó al intenar insertar los datos!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDetalle(Request $request)
    {
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'upc' => 'required|numeric|digits_between:12,14',
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
                $id_inventario = "";
                if(count($articulo) == 1){
                    foreach($articulo as $art){
                        $id_inventario = $art->id_inventario;
                    }
                    return redirect()->back()->with('success', 'Este artículo ya existe!');
                    //$this->update($request, $id_inventario);
                }else{
                    $fecha_alta = new DateTime();
                    if($request->checkOnline == "on"){
                        $online = true;
                    }else{
                        $online = false;
                    }
                    $categoria = DB::table('categoria')->where('categoria', $request->categoria)->get();
                    $categoria = $this->comprobarConsultaDB($categoria);
                    $modelo = DB::table('modelo')->where('modelo', $request->modelo)->get();
                    $modelo = $this->comprobarConsultaDB($modelo);
                    $marca = DB::table('marca')->where('marca', $request->marca)->get();
                    $marca = $this->comprobarConsultaDB($marca);
                    $color = DB::table('color')->where('color', $request->color)->get();
                    $color = $this->comprobarConsultaDB($color);
                    $capacidad = DB::table('capacidad')->where('tipo', $request->capacidad)->get();
                    $capacidad = $this->comprobarConsultaDB($capacidad);
                    $json_agregar = [
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
                        'fecha_alta' => date_format($fecha_alta, 'Y-m-d H:i:s'),
                        'id_capacidad' => $capacidad[0]->id_capacidad,
                        'costo' => $request->costo,
                        'stock' => $request->stock,
                        'stock_min' => $request->stockMin,
                        'precio_publico' => $request->publico,
                        'precio_mayoreo' => $request->mayoreo,
                        'precio_min' => $request->precioMin,
                        'precio_max' => $request->precioMax,
                        'id_color' => $color[0]->id_color,
                        'venta_online' => $online,
                        'imagen' => $request->upc.'.png'
                    ];
                    if(Inventario::insert($json_agregar)){
                        $id = DB::getPdo()->lastInsertId();
                        if($request->radiosDetalle == 'imei' && $request->detalle){
                            $detalleFull = $request->detalle;
                            foreach($detalleFull as $detalle){
                                $comprobarImei = DB::table('detalle_inventario')->where('imei', $detalle['imei'])->get();
                                if(count($comprobarImei) > 0){
                                    $request->flash();
                                    return redirect()->back()->withErrors('error', 'Los datos que ingresaste ya se han dado de alta anteriormente!');
                                }else{
                                    $insertarDetalle = DB::table('detalle_inventario')->insert([
                                        'imei' => $detalle['imei'],
                                        'id_inventario' => $id,
                                        'id_estatus' => 2,
                                        'liberado' => $detalle['liberado'],
                                        'fecha_alta' => $fecha_alta
                                    ]);
                                    if(!$insertarDetalle){
                                        $request->flash();
                                        return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                    }
                                }
                            }
                        }elseif($request->radiosDetalle == 'ns' && $request->detalle){
                            $detalleFull = $request->detalle;
                            foreach($detalleFull as $detalle){
                                $comprobarImei = DB::table('detalle_inventario')->where('ns', $detalle['ns'])->get();
                                if(count($comprobarImei) > 0){
                                    $request->flash();
                                    return redirect()->back()->withErrors('error', 'Los datos que ingresaste ya se han dado de alta anteriormente!');
                                }else{
                                    $insertarDetalle = DB::table('detalle_inventario')->insert([
                                        'ns' => $detalle['ns'],
                                        'id_inventario' => $id,
                                        'id_estatus' => 2,
                                        'liberado' => $detalle['liberado'],
                                        'fecha_alta' => $fecha_alta
                                    ]);
                                    if(!$insertarDetalle){
                                        $request->flash();
                                        return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                    }
                                }
                            }
                        }

                        return redirect()->back()->with('success', 'Se agregó correctamente el artículo.');
                    }else{
                        $request->flash();
                        return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                    }
                }
            }
        } catch (\Throwable $th) {
            $request->flash();
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function updateDetalle(Request $request, $id)
    {
        try {

            $data = $request->except('_method','_token');
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'upc' => 'required|numeric|digits_between:12,14',
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
                $fileName = "";
                if ($request->has('imagenProducto')) {
                    $image      = $request->file('imagenProducto');
                    $fileName   = $request->upc.'.'. $image->getClientOriginalExtension();
                    $img = Image::make($image->getRealPath());
                    $extension = $image->getClientOriginalExtension();
                    //dd($img);
                    $img->resize(120, 120, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->stream(); // <-- Key point

                    if(Storage::disk('local')->exists('public/inventario/'.$request->upc.'.'.$extension)) {
                        Storage::disk('local')->delete('public/inventario/'.$request->upc.'.'.$extension);
                    }
                    Storage::disk('local')->put('public/inventario'.'/'.$fileName, $img, 'public');
                }else{
                    $verificarImagen = DB::table('inventario')->where('upc', $request->upc)->where('imagen', '!=', null)->get();
                    if(count($verificarImagen) > 0) {
                        $img = $this->convertToJSON($verificarImagen);
                        $fileName = $img[0]->imagen;

                    }
                }
                $categoria = DB::table('categoria')->where('categoria', $request->categoria)->get();
                $categoria = $this->comprobarConsultaDB($categoria);
                $modelo = DB::table('modelo')->where('modelo', $request->modelo)->get();
                $modelo = $this->comprobarConsultaDB($modelo);
                $marca = DB::table('marca')->where('marca', $request->marca)->get();
                $marca = $this->comprobarConsultaDB($marca);
                $color = DB::table('color')->where('color', $request->color)->get();
                $color = $this->comprobarConsultaDB($color);
                $capacidad = DB::table('capacidad')->where('tipo', $request->capacidad)->get();
                $capacidad = $this->comprobarConsultaDB($capacidad);
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
                    'venta_online' => $online,
                    'imagen' => $fileName
                ];
                if($inventario->update($json_actualizar)){
                    if($request->radiosDetalle == 'imei' && $request->detalle){
                        $detalleFull = $request->detalle;
                        foreach($detalleFull as $detalle){
                            $comprobarImei = DB::table('detalle_inventario')->where('imei', $detalle['imei'])->get();
                            if(count($comprobarImei) > 0){
                                $modificarDetalle = DB::table('detalle_inventario')->update([
                                    'imei' => $detalle['imei'],
                                    'id_inventario' => $id,
                                    'id_estatus' => 2,
                                    'liberado' => $detalle['liberado'],
                                    'fecha_alta' => $fecha_modificacion
                                ]);
                                if(!$modificarDetalle){
                                    $request->flash();
                                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                }
                            }else{
                                $insertarDetalle = DB::table('detalle_inventario')->insert([
                                    'imei' => $detalle['imei'],
                                    'id_inventario' => $id,
                                    'id_estatus' => 2,
                                    'liberado' => $detalle['liberado'],
                                    'fecha_alta' => $fecha_modificacion
                                ]);
                                if(!$insertarDetalle){
                                    $request->flash();
                                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                }
                            }
                        }
                    }elseif($request->radiosDetalle == 'ns' && $request->detalle){
                        $detalleFull = $request->detalle;
                        foreach($detalleFull as $detalle){
                            $comprobarImei = DB::table('detalle_inventario')->where('ns', $detalle['ns'])->get();
                            if(count($comprobarImei) > 0){
                                $modificarDetalle = DB::table('detalle_inventario')->update([
                                    'ns' => $detalle['ns'],
                                    'id_inventario' => $id,
                                    'id_estatus' => 2,
                                    'liberado' => $detalle['liberado'],
                                    'fecha_alta' => $fecha_modificacion
                                ]);
                                if(!$modificarDetalle){
                                    $request->flash();
                                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                }
                            }else{
                                $insertarDetalle = DB::table('detalle_inventario')->insert([
                                    'ns' => $detalle['ns'],
                                    'id_inventario' => $id,
                                    'id_estatus' => 2,
                                    'liberado' => $detalle['liberado'],
                                    'fecha_alta' => $fecha_modificacion
                                ]);
                                if(!$insertarDetalle){
                                    $request->flash();
                                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                }
                            }
                        }
                    }
                    return redirect()->back()->with('success', 'Se modificó correctamente el inventario.');
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

    public function agregarProveedor(Request $request)
    {
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'proveedorDescripcion' => 'required|max:50'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                DB::table('proveedor')->insert(
                    ['proveedor' => strtoupper($request->proveedorDescripcion)]
                );
                if($request->ajax()){
                    $id = DB::getPdo()->lastInsertId();
                    $proveedor = DB::table('proveedor')->where('id_proveedor', $id)->get();
                    return $proveedor;
                }else{
                    return redirect()->back()->with('success', 'Se agregó correctamente el proveedor.');
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    public function imprimirEtiqueta($id_inventario){
        $inventario = DB::table('inventario')->where('id_inventario', $id_inventario)
        ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
        ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
        ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
        ->leftJoin('color', 'color.id_color', 'inventario.id_color')->get();
        $compatibilidad = DB::table('compatibilidad')->where('id_inventario', $id_inventario)
        ->leftJoin('modelo', 'modelo.id_modelo', 'compatibilidad.id_modelo')->get();
        $compatibilidadCadena = "";
        foreach($compatibilidad as $compa){
            $compatibilidadCadena .= $compa->modelo.'/';
        }
        /*if(Storage::disk('local')->exists('public/inventario/etiqueta/'.$inventario[0]->upc.'.pdf')) {
            Storage::disk('local')->delete('public/inventario/etiqueta/'.$inventario[0]->upc.'.pdf');
        }
        $datos = [
            'precio' => $inventario[0]->precio_max,
            'categoria' => $inventario[0]->categoria,
            'marca' => $inventario[0]->marca,
            'modelo' => $inventario[0]->modelo,
            'color' => $inventario[0]->color,
            'compatibilidad' => $compatibilidadCadena
        ];
        PDF::loadView('Inventario.etiqueta', $datos)->setPaper('b8', 'portrait')->setWarnings(false)
        ->save(storage_path('app\\public\\inventario\\etiqueta\\').$inventario[0]->upc.'.pdf');

        Printing::newPrintTask()
        ->printer(70130535)
        ->file(storage_path('app\\public\\inventario\\etiqueta\\').$inventario[0]->upc.'.pdf')
        ->send();*/

        //Etiquetas para cada stock de producto
        if(Storage::disk('local')->exists('public/inventario/etiqueta/'.$inventario[0]->upc.'-2.pdf')) {
            Storage::disk('local')->delete('public/inventario/etiqueta/'.$inventario[0]->upc.'-2.pdf');
        }
        $datos = [
            'precio_min' => $inventario[0]->precio_min,
            'precio_max' => $inventario[0]->precio_max,
            'categoria' => $inventario[0]->categoria,
            'marca' => $inventario[0]->marca,
            'modelo' => $inventario[0]->modelo,
            'color' => $inventario[0]->color,
            'compatibilidad' => $compatibilidadCadena,
            'total' => $inventario[0]->stock
        ];
        PDF::loadView('Inventario.etiquetav2', $datos)->setPaper('b8', 'landscape')->setWarnings(false)
        ->save(storage_path('app\\public\\inventario\\etiqueta\\').$inventario[0]->upc.'-2.pdf');

        Printing::newPrintTask()
        ->printer(70131599)
        ->file(storage_path('app\\public\\inventario\\etiqueta\\').$inventario[0]->upc.'-2.pdf')
        ->send();
    }
}
