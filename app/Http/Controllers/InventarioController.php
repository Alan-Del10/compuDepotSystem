<?php

namespace App\Http\Controllers;

use App\Inventario;
use App\BitacoraGeneral;
use App\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Mike42\Escpos\EscposImage;
use Image;
use Illuminate\Support\Facades\Storage;
use Rawilk\Printing\PrintTask;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use Rawilk\Printing\Contracts\Printer;
use Rawilk\Printing\Facades\Printing;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\BitacoraGeneralController;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*if(Auth::guard('admin')->check() || Auth::guard('sub_admin')->check() || Auth::guard('root')->check()){
            $inventarios = Inventario::select(DB::raw('inventario.upc, inventario.id_inventario, modelo.modelo, marca.marca, categoria.categoria, color.color, inventario.precio_min, inventario.precio_max,
            inventario.precio_mayoreo, inventario.imagen, inventario.titulo_inventario, inventario.costo, SUM(detalle_inventario.stock) as stock'))
            ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
            ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
            ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
            ->leftJoin('color', 'color.id_color', 'inventario.id_color')
            ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
            ->groupBy('inventario.id_inventario')->orderby('inventario.id_inventario','asc')->paginate(10);
        }else{*/
        $inventarios = Inventario::orderby('id_inventario', 'asc')->select('inventario.*', 'detalle_inventario.stock as stock', 'color.*', 'categoria.*',  'marca.*', 'modelo.*')
            ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
            ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
            ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
            ->leftJoin('color', 'color.id_color', 'inventario.id_color')
            ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
            ->where('detalle_inventario.id_sucursal', Auth::user()->id_sucursal)->paginate(10);
        //}
        $categorias =  DB::table('categoria')->where('estatus', 1)->get();
        $compatibilidades = DB::table('compatibilidad')->leftJoin('inventario', 'inventario.id_inventario', 'compatibilidad.id_inventario')
            ->leftJoin('modelo', 'modelo.id_modelo', 'compatibilidad.id_modelo')
            ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->get();
        $sucursales = Sucursal::get();
        $sucursal = Sucursal::where('id_sucursal', Auth::user()->id_sucursal)->get();
        return view('Inventario.inventario', compact('inventarios', 'categorias', 'compatibilidades', 'sucursales', 'sucursal'));
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
        $sucursales = Sucursal::get();
        return view('Inventario.agregarInventario',  compact('sucursales', 'modelos', 'marcas', 'capacidades', 'colores', 'categorias', 'subcategorias', 'proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'upc' => 'required|numeric|digits_between:12,14',
                'categoria' => 'required',
                'modelo' => 'required',
                'color' => 'required',
                'proveedor' => 'required',
                'titulo' => 'required|max:100',
                'descripcion' => 'nullable|max:200',
                'peso' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'costo' => 'required|numeric',
                'stockMin' => 'required|numeric',
                'mayoreo' => 'required|numeric',
                'precioMin' => 'required|numeric',
                'precioMax' => 'required|numeric'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if ($validator->fails()) {
                $request->flash();
                return redirect()->back()->withErrors($validator);
            } else {
                $articulo = Inventario::where('upc', $request->upc)->get();
                $id_inventario = "";
                if (count($articulo) == 1) {
                    foreach ($articulo as $art) {
                        $id_inventario = $art->id_inventario;
                    }
                    return redirect()->back()->with('success', 'Este artículo ya existe!');
                    //$this->update($request, $id_inventario);
                } else {
                    $fecha_alta = new DateTime();
                    if ($request->checkOnline == "on") {
                        $online = true;
                    } else {
                        $online = false;
                    }
                    $fileName = "";
                    if ($request->has('imagenProducto')) {
                        $image      = $request->file('imagenProducto');
                        $fileName   = $request->upc . '.' . $image->getClientOriginalExtension();
                        $img = Image::make($image->getRealPath());
                        $extension = $image->getClientOriginalExtension();
                        //dd($img);
                        $img->resize(120, 120, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img->stream(); // <-- Key point

                        if (Storage::disk('local')->exists('public/inventario/' . $request->upc . '.' . $extension)) {
                            Storage::disk('local')->delete('public/inventario/' . $request->upc . '.' . $extension);
                        }
                        Storage::disk('local')->put('public/inventario' . '/' . $fileName, $img, 'public');
                    } else {
                        $verificarImagen = DB::table('inventario')->where('upc', $request->upc)->where('imagen', '!=', null)->get();
                        if (count($verificarImagen) > 0) {
                            $fileName = $verificarImagen[0]->imagen;
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
                        'stock_min' => $request->stockMin,
                        'precio_mayoreo' => $request->mayoreo,
                        'precio_min' => $request->precioMin,
                        'precio_max' => $request->precioMax,
                        'id_color' => $color[0]->id_color,
                        'venta_online' => $online,
                        'imagen' => $fileName
                    ];
                    //dd(Inventario::insert($json_agregar));
                    if (Inventario::insert($json_agregar)) {
                        $id = DB::getPdo()->lastInsertId();
                        if ($request->compatibilidad != null && count($request->compatibilidad) != 0) {
                            $compatibilidad = $request->compatibilidad;
                            foreach ($compatibilidad as $compa) {
                                $modelo2 = DB::table('modelo')->where('modelo', $compa['modelo'])->get();
                                $modelo2 = $this->comprobarConsultaDB($modelo2);
                                $insertarCompatibilidad = DB::table('compatibilidad')->insert([
                                    'id_inventario' => $id,
                                    'id_modelo' => $modelo2[0]->id_modelo
                                ]);
                                if (!$insertarCompatibilidad) {
                                    $request->flash();
                                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                }
                            }
                        }
                        $usuario_nombre = Auth::user()->name;
                        $usuario_id = Auth::user()->id;
                        if ($request->detalleInventario != null && count($request->detalleInventario) != 0) {
                            $detalleInventario = $request->detalleInventario;
                            foreach ($detalleInventario as $detalle) {
                                $sucursal = DB::table('sucursal')->where('sucursal', $detalle['sucursal'])->get();
                                $sucursal = $this->comprobarConsultaDB($sucursal);
                                $json_detalle = [
                                    'id_inventario' => $id,
                                    'id_sucursal' => $sucursal[0]->id_sucursal,
                                    'stock' => $detalle['stock']
                                ];
                                if (!DB::table('detalle_inventario')->insert($json_detalle)) {
                                    $request->flash();
                                    DB::rollBack();
                                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                                }
                                $this->imprimirEtiqueta($id, $detalle['etiquetas'], $sucursal[0]->id_sucursal);
                                $descripcion = 'El usuario ' . $usuario_nombre . ' ha agregado al inventario el artículo con el UPC/EAN ' . $request->upc . ' con el título ' . $request->titulo . ' desde la sucursal ' . $sucursal[0]->sucursal . ' con stock ' . $detalle['stock'] . 'pza(s). a la fecha ' . date_format($fecha_alta, 'Y-m-d H:i:s');
                                //$this->registrarBitacora($fecha_alta, $descripcion, $usuario_id, $sucursal[0]->id_sucursal);
                                (new BitacoraGeneralController)->registrarBitacora($fecha_alta, $descripcion, $usuario_id, $sucursal[0]->id_sucursal);
                                (new BitacoraGeneralController)->mensajeTelegram($usuario_nombre, $sucursal[0]->sucursal, $sucursal[0]->direccion, $fecha_alta, null, $request->upc, $request->titulo, null, $detalle['stock']);
                            }
                        }
                        DB::commit();
                        return redirect()->back()->with('success', 'Se agregó correctamente el artículo.');
                    } else {
                        $request->flash();
                        DB::rollBack();
                        return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                    }
                }
            }
        } catch (\Throwable $th) {
            $request->flash();
            DB::rollBack();
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
        $inventario = Inventario::where('inventario.id_inventario', $id)
            ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
            ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
            ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
            ->leftJoin('color', 'color.id_color', 'inventario.id_color')
            ->leftJoin('capacidad', 'capacidad.id_capacidad', 'inventario.id_capacidad')
            ->leftJoin('proveedor', 'proveedor.id_proveedor', 'inventario.id_proveedor')->get();
        $detalle_inventario = DB::table('detalle_inventario')->select('detalle_inventario.*', 'sucursal.sucursal as sucursal')
            ->leftJoin('inventario', 'inventario.id_inventario', 'detalle_inventario.id_inventario')
            ->leftJoin('sucursal', 'sucursal.id_sucursal', 'detalle_inventario.id_sucursal')->where('detalle_inventario.id_inventario', $id)->get();
        $compatibilidad = DB::table('compatibilidad')->where('id_inventario', $id)->leftJoin('modelo', 'modelo.id_modelo', 'compatibilidad.id_modelo')->get();
        //dd($detalle_inventario);
        $modelos = DB::table('modelo')->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->where('modelo.estatus', 1)->get();
        $marcas = DB::table('marca')->where('estatus', 1)->get();
        $capacidades = DB::table('capacidad')->get();
        $colores = DB::table('color')->where('estatus', 1)->get();
        $categorias =  DB::table('categoria')->where('estatus', 1)->get();
        $subcategorias = DB::table('sub_categoria')->where('estatus', 1)->get();
        $proveedores = DB::table('proveedor')->get();
        $sucursales = Sucursal::get();
        return view('Inventario.modificarInventario', compact('sucursales', 'inventario', 'detalle_inventario', 'modelos', 'marcas', 'capacidades', 'colores', 'categorias', 'subcategorias', 'proveedores', 'compatibilidad'));
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
        DB::beginTransaction();
        try {

            $data = $request->except('_method', '_token');
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'upc' => 'required|numeric|digits_between:12,14',
                'categoria' => 'required',
                'modelo' => 'required',
                'marca' => 'required',
                'color' => 'required',
                'proveedor' => 'required',
                'titulo' => 'required|max:100',
                'descripcion' => 'nullable|max:200',
                'peso' => 'nullable|numeric',
                'costo' => 'nullable|numeric',
                'largo' => 'nullable|numeric',
                'alto' => 'nullable|numeric',
                'ancho' => 'nullable|numeric',
                'costo' => 'required|numeric',
                'stockMin' => 'required|numeric',
                'mayoreo' => 'required|numeric',
                'precioMin' => 'required|numeric',
                'precioMax' => 'required|numeric'
            ]);
            $inventario = Inventario::find($id);
            //Si encuentra datos erroneos los regresa con un mensaje de error
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                $fecha_modificacion = new DateTime();
                if ($request->checkOnline == "on") {
                    $online = true;
                } else {
                    $online = false;
                }
                $fileName = "";

                if ($request->has('imagenProducto')) {
                    $image      = $request->file('imagenProducto');
                    $fileName   = $request->upc . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path("storage/inventario"),$fileName);
                    /*$img = Image::make($image->getRealPath());
                    $extension = $image->getClientOriginalExtension();
                    //dd($img);
                    $img->resize(120, 120, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->stream(); // <-- Key point*/

                    /*if (Storage::disk('local')->exists('public/inventario/' . $request->upc . '.' . $extension)) {
                        Storage::disk('local')->delete('public/inventario/' . $request->upc . '.' . $extension);
                    }*/
                    //Storage::disk('local')->put('public/inventario' . '/' . $fileName, $img, 'public');

                } else {
                    $verificarImagen = DB::table('inventario')->where('upc', $request->upc)->where('imagen', '!=', null)->get();
                    if (count($verificarImagen) > 0) {
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
                    'id_marca'  => $marca[0]->id_marca,
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
                    'stock_min' => $request->stockMin,
                    'precio_mayoreo' => $request->mayoreo,
                    'precio_min' => $request->precioMin,
                    'precio_max' => $request->precioMax,
                    'id_color' => $color[0]->id_color,
                    'venta_online' => $online,
                    'imagen' => $fileName
                ];

                //Verificar que se cambio
                $changed = null;
                //Si cambio el UPC
                if (DB::table('inventario')->where('id_inventario', $id)->where('upc', $request->upc)->doesntExist()) {
                    $upc_anterior = DB::table('inventario')->where('id_inventario', $id)->get('upc');

                    $changed .= ' el UPC de ' . $upc_anterior[0]->upc . ' a ' . $request->upc;
                }
                //Si cambio el Proveedor
                if (DB::table('inventario')->where('id_inventario', $id)->where('id_proveedor', $proveedor[0]->id_proveedor)->doesntExist()) {
                    $prov_anterior = DB::table('proveedor')->where('id_proveedor', $proveedor[0]->id_proveedor)->get('proveedor');



                    $changed .= ' el proveedor de $' . $prov_anterior . ' a ' . $request->proveedor;
                }
                //Si cambio la categoria
                if (DB::table('inventario')->where('id_inventario', $id)->where('id_categoria', $categoria[0]->id_categoria)->doesntExist()) {

                    $cat_anterior = DB::table('inventario')
                        ->where('id_inventario', '=', $id)
                        ->leftJoin('categoria', 'categoria.id_categoria', '=', 'inventario.id_categoria')
                        ->get('categoria.categoria');


                    $changed .= ' la categoria cambio de ' . $cat_anterior[0]->categoria . ' a ' . $request->categoria;
                }
                //Si cambio el modelo
                if (DB::table('inventario')->where('id_inventario', $id)->where('id_modelo', $modelo[0]->id_modelo)->doesntExist()) {
                    $mod_anterior = DB::table('inventario')
                        ->where('id_inventario', '=', $id)
                        ->leftJoin('modelo', 'modelo.id_modelo', '=', 'inventario.id_modelo')
                        ->get('modelo.modelo');


                    $changed .= ' el modelo de ' . $mod_anterior[0]->modelo . ' cambio a ' . $request->modelo;
                }
                //Si cambio el costo
                if (DB::table('inventario')->where('id_inventario', $id)->where('costo', $request->costo)->doesntExist()) {
                    $costo_anterior = DB::table('inventario')->where('id_inventario', $id)->get('costo');

                    $changed .= ' el costo de $' . $costo_anterior[0]->costo . ' cambio a $' . $request->costo;
                }
                //Si cambio el precio minímo
                if (DB::table('inventario')->where('id_inventario', $id)->where('precio_min', $request->precioMin)->doesntExist()) {
                    $precio_min_anterior = DB::table('inventario')->where('id_inventario', $id)->get('precio_min');

                    $changed .= ' el precio minímo de $' . $precio_min_anterior[0]->precio_min . ' cambio a $' . $request->precioMin;
                }
                //Si cambio el precio máximo
                if (DB::table('inventario')->where('id_inventario', $id)->where('precio_max', $request->precioMax)->doesntExist()) {
                    $precio_max_anterior = DB::table('inventario')->where('id_inventario', $id)->get('precio_max');

                    $changed .= ' el precio máximo de $' . $precio_max_anterior[0]->precio_max . ' cambio a $' . $request->precioMax;
                }

                //Si cambio el largo
                if (DB::table('inventario')->where('id_inventario', $id)->where('largo', $request->largo)->doesntExist()) {
                    $largo_anterior = DB::table('inventario')->where('id_inventario', $id)->get('largo');

                    $changed .= ' el largo de ' . $largo_anterior[0]->largo . 'm cambio a ' . $request->largo . 'm';

                    //dd($changed);

                }
                //Si cambio el alto
                if (DB::table('inventario')->where('id_inventario', $id)->where('alto', $request->alto)->doesntExist()) {
                    $alto_anterior = DB::table('inventario')->where('id_inventario', $id)->get('alto');

                    $changed .= ' el alto de ' . $alto_anterior[0]->alto . 'm cambio a ' . $request->alto . 'm';

                    //dd($changed);

                }
                //Si cambio el ancho
                if (DB::table('inventario')->where('id_inventario', $id)->where('ancho', $request->ancho)->doesntExist()) {
                    $ancho_anterior = DB::table('inventario')->where('id_inventario', $id)->get('ancho');

                    $changed .= ' el ancho de ' . $ancho_anterior[0]->ancho . 'm cambio a ' . $request->ancho . 'm';

                    //dd($changed);

                }

                if ($inventario->update($json_actualizar)) {
                    if ($request->compatibilidad != null && count($request->compatibilidad) != 0) {
                        $compatibilidad = $request->compatibilidad;
                        DB::table('compatibilidad')->where('id_inventario', $id)->delete();
                        foreach ($compatibilidad as $compa) {
                            $modelo2 = DB::table('modelo')->where('modelo', $compa['modelo'])->get();
                            $modelo2 = $this->comprobarConsultaDB($modelo2);

                            $insertarCompatibilidad = DB::table('compatibilidad')->insert([
                                'id_inventario' => $id,
                                'id_modelo' => $modelo2[0]->id_modelo
                            ]);
                            if (!$insertarCompatibilidad) {
                                $request->flash();
                                DB::rollback();
                                return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                            }
                        }
                    }

                    $usuario_nombre = Auth::user()->name;
                    $usuario_id = Auth::user()->id;
                    if ($request->detalleInventario != null && count($request->detalleInventario) != 0) {
                        $bitacora = new BitacoraGeneralController;
                        $detalleInventario = $request->detalleInventario;
                        //Sacar el stock actual
                        $stock_actual = DB::table('detalle_inventario')->where('id_inventario', $id)->get('stock');
                        DB::table('detalle_inventario')->where('id_inventario', $id)->delete();
                        foreach ($detalleInventario as $detalle) {
                            $sucursal = DB::table('sucursal')->where('sucursal', $detalle['sucursal'])->get();
                            $sucursal = $this->comprobarConsultaDB($sucursal);
                            if (isset($atock_actual) && $stock_actual[0]->stock != $detalle['stock']) {
                                $changed .= ' el stock de ' . $stock_actual[0]->stock . ' pza(s) cambio a ' . $detalle['stock'] . ' pza(s)';
                            }
                            $json_detalle = [
                                'id_inventario' => $id,
                                'id_sucursal' => $sucursal[0]->id_sucursal,
                                'stock' => $detalle['stock']
                            ];

                            if (!DB::table('detalle_inventario')->insert($json_detalle)) {
                                $request->flash();
                                DB::rollBack();
                                return redirect()->back()->withErrors('error', 'Algo pasó al intenar agregar los datos!');
                            }
                            $fecha = date_format($fecha_modificacion, 'Y-m-d H:i:s');
                            $descripcion = 'El usuario ' . $usuario_nombre . ' ha modificado los atributos del artículo con el UPC/EAN ' . $request->upc . ' con el título ' . $request->titulo . ' desde la sucursal ' . $sucursal[0]->sucursal . ' con stock ' . $detalle['stock'] . 'pza(s). a la fecha ' . date_format($fecha_modificacion, 'Y-m-d H:i:s');
                            if ($detalle['etiquetas'] > 0) {
                                $error_etiqueta = $this->imprimirEtiqueta($id, $detalle['etiquetas'], $sucursal[0]->id_sucursal);
                                //Marcar errores según lo que falte.
                                switch ($error_etiqueta) {
                                    case 1:
                                        $request->flash();
                                        DB::rollback();
                                        //dd($error_etiqueta);
                                        return redirect()->back()->with('error', 'No tienes una imagen para el logo. Asigna una e intenta después.');
                                    case 2:
                                        $request->flash();
                                        DB::rollback();
                                        //dd($error_etiqueta);
                                        return redirect()->back()->with('error', 'No se encontro el archivo o directorio del pdf.');
                                    case 3:
                                        $request->flash();
                                        DB::rollback();
                                        //dd($error_etiqueta);
                                        return redirect()->back()->with('error', 'No se encontro una impresora conectada o configurada.');
                                }
                            }
                            //$this->registrarBitacora($fecha_modificacion, $descripcion, $usuario_id, $sucursal[0]->id_sucursal);
                            $bitacora->registrarBitacora($fecha_modificacion, $descripcion, $usuario_id, $sucursal[0]->id_sucursal);
                            $bitacora->mensajeTelegram($usuario_nombre, $sucursal[0]->sucursal, $sucursal[0]->direccion, $fecha, null, $request->upc, $request->titulo, null, $detalle['stock'], null, null, null, null, null, null, null, $changed);
                        }
                    } elseif (DB::table('detalle_inventario')->where('id_inventario', $id)->get()) {
                        DB::table('detalle_inventario')->where('id_inventario', $id)->delete();
                    }
                    DB::commit();
                    return redirect()->back()->with('success', 'Se modificó correctamente el inventario.');
                } else {
                    $request->flash();
                    DB::rollback();
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar modificar los datos!');
                }
            }
        } catch (\Throwable $th) {
            $request->flash();
            DB::rollback();
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
    public function verificarUPC(Request $request)
    {
        try {
            $articulo = DB::table('inventario')->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')->leftJoin('color', 'color.id_color', 'inventario.id_color')->leftJoin('capacidad', 'capacidad.id_capacidad', 'inventario.id_capacidad')->where('upc', $request->upc)->get();
            if (count($articulo) > 0) {
                foreach ($articulo as $art) {
                    $id_inventario = $art->id_inventario;
                }
                $detalle = DB::table('detalle_inventario')->where('id_inventario', $id_inventario)->get();
                return [$articulo, $detalle];
            } else {
                return ['res' => false];
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
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                DB::table('capacidad')->insert(
                    ['tipo' => $request->capacidadDescripcion]
                );
                if ($request->ajax()) {
                    $id = DB::getPdo()->lastInsertId();
                    $capacidadNueva = DB::table('capacidad')->where('id_capacidad', $id)->get();
                    return $capacidadNueva;
                } else {
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
    public function convertToJSON($resultado)
    {
        return json_decode(json_encode($resultado));
    }

    /**
     * Comprobar consulta
     */
    public function comprobarConsultaDB($data)
    {
        if (count($data) > 0) {
            return $this->convertToJSON($data);
        } else {
            $data->flash();
            return redirect()->route('Inventario.create')->withErrors('error', 'Algo pasó al intenar insertar los datos!');
        }
    }
    /**
     * Registra proveedores
     */
    public function agregarProveedor(Request $request)
    {
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'proveedorDescripcion' => 'required|max:50'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            } else {
                DB::table('proveedor')->insert(
                    ['proveedor' => strtoupper($request->proveedorDescripcion)]
                );
                if ($request->ajax()) {
                    $id = DB::getPdo()->lastInsertId();
                    $proveedor = DB::table('proveedor')->where('id_proveedor', $id)->get();
                    return $proveedor;
                } else {
                    return redirect()->back()->with('success', 'Se agregó correctamente el proveedor.');
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Función que imprime las etiquetas de los productos para colocarlos en sus estantes
     */
    public function imprimirEtiqueta($id_inventario, $etiquetas, $id_sucursal)
    {
        $inventario = DB::table('inventario')->where('id_inventario', $id_inventario)
            ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
            ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
            ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
            ->leftJoin('color', 'color.id_color', 'inventario.id_color')->get();
        $sucursal = DB::table('sucursal')->where('id_sucursal', $id_sucursal)->get();
        $compatibilidad = DB::table('compatibilidad')->where('id_inventario', $id_inventario)
            ->leftJoin('modelo', 'modelo.id_modelo', 'compatibilidad.id_modelo')->get();
        $compatibilidadCadena = "";
        if (sizeof($compatibilidad) > 0) {
            $compatibilidadCadena = "";
            foreach ($compatibilidad as $compa) {
                $compatibilidadCadena .= $compa->modelo . '/';
            }
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
        /*if (Storage::disk('public')->exists('inventario/etiqueta/' . $inventario[0]->upc . '-2.pdf')) {
            Storage::disk('public')->delete('inventario/etiqueta/' . $inventario[0]->upc . '-2.pdf');
        }*/
        try {
            $imagen = base64_encode(public_path("storage/sucursales/" . $sucursal[0]->logo));
        } catch (\Throwable $th) {
            //dd($th);
            return 1;
        }
        $datos = [
            'codigo' => $inventario[0]->upc,
            'precio_min' => $inventario[0]->precio_min,
            'precio_max' => $inventario[0]->precio_max,
            'categoria' => $inventario[0]->categoria,
            'marca' => $inventario[0]->marca,
            'modelo' => $inventario[0]->modelo,
            'color' => $inventario[0]->color,
            'compatibilidad' => $compatibilidadCadena,
            'total' => $etiquetas,
            'logo' => $imagen,
            'imagen' => $sucursal[0]->logo
        ];
        $documento = "";
        try {
            $documento = PDF::loadView('Inventario.etiquetav2', $datos)->setPaper('b8', 'landscape')->setWarnings(false)->output();
            Storage::disk('public')->put('/inventario/etiqueta'.'/'.$inventario[0]->upc . '-2.pdf', $documento, 'public');
        } catch (\Throwable $th) {
            return 2;
        }

        //$etiqueta = chunk_split(base64_encode($documento));
        //dd(url('storage/inventario/etiqueta/'));
        try {
            if (Storage::disk('public')->exists('inventario/etiqueta/' . $inventario[0]->upc . '-2.pdf')) {
                $data = public_path("/storage/inventario/etiqueta/". $inventario[0]->upc . '-2.pdf');
            }
            Printing::newPrintTask()
                ->printer($sucursal[0]->etiquetas)
                ->file($data)
                ->send();
        } catch (\Throwable $th) {
            return 3;
        }
    }

    /**
     * Función de prueba para calcular UPC
     */
    public function calculoUPC()
    {
        $upc = str_split('84279707275');
        $par = 0;
        $impar = 0;
        for ($i = 0; $i < count($upc); $i++) {
            if (($i + 1) % 2 == 0) {
                $par += $upc[$i];
            } else {
                $impar += $upc[$i];
            }
        }
        $impar = $impar * 3;
        $total = $impar + $par;
        $mod = $total % 10;
        $x12 = 0;
        if ($mod != 0) {
            $x12 = 10 - $mod;
        }
        $upc = implode($upc);
        $upc .= $x12;
        echo $upc;
    }

    /**
     * Función para buscar stock de sucursales especificas desde la vista de inventario
     */
    public function inventarioPorSucursal(Request $request)
    {
        $inventarios = Inventario::orderby('id_inventario', 'asc')->select('inventario.*', 'detalle_inventario.stock as stock', 'color.*', 'sucursal.*', 'categoria.*',  'marca.*', 'modelo.*')
            ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
            ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
            ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
            ->leftJoin('color', 'color.id_color', 'inventario.id_color')
            ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
            ->leftJoin('sucursal', 'sucursal.id_sucursal', 'detalle_inventario.id_sucursal')
            ->where('detalle_inventario.sucursal', $request->sucursal)->paginate(10);
        if ($request->ajax()) {
            return $inventarios;
        }
    }
}
