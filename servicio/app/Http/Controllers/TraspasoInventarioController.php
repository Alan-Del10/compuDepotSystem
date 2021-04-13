<?php

namespace App\Http\Controllers;

use App\Sucursal;
use App\TraspasoInventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Facades\Validator;


class TraspasoInventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $traspasos = TraspasoInventario::orderBy('id_traspaso_inventario', 'DESC')
                ->select('traspaso_inventario.*', 'usuario.name', 'sucursal.sucursal as sucursal_salida', 'sucursal_2.sucursal as sucursal_entrada')
                ->leftJoin('sucursal', 'sucursal.id_sucursal', 'traspaso_inventario.id_sucursal_salida')
                ->leftJoin('sucursal as sucursal_2', 'sucursal_2.id_sucursal', 'traspaso_inventario.id_sucursal_entrada')
                ->leftJoin('usuario', 'usuario.id', 'traspaso_inventario.id_usuario')
                ->paginate(10);
        } else {
            $traspasos = TraspasoInventario::orderBy('id_traspaso_inventario', 'DESC')
                ->select('traspaso_inventario.*', 'usuario.name', 'sucursal.sucursal as sucursal_salida', 'sucursal_2.sucursal as sucursal_entrada')
                ->leftJoin('sucursal', 'sucursal.id_sucursal', 'traspaso_inventario.id_sucursal_salida')
                ->leftJoin('sucursal as sucursal_2', 'sucursal_2.id_sucursal', 'traspaso_inventario.id_sucursal_entrada')
                ->leftJoin('usuario', 'usuario.id', 'traspaso_inventario.id_usuario')
                ->where('sucursal.id_sucursal', Auth::user()->id_sucursal)
                ->orWhere('sucursal_2.id_sucursal', Auth::user()->id_sucursal)
                ->paginate(10);
        }

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
        $incompletos = array();
        //Validamos los campos de la base de datos, para no aceptar información erronea
        $validator = Validator::make($request->all(), [
            'traspasos' => 'required'
        ]);

        //Si encuentra datos erroneos los regresa con un mensaje de error
        if ($validator->fails()) {
            $request->flush();
            return $validator;
        } else {
            $fecha_traspaso = new DateTime();
            $usuario = Auth::user();
            //dd($request->all());
            foreach ($request->traspasos as $key => $value) {
                DB::beginTransaction();
                try {
                    $json_agregar = [
                        'id_usuario' => $usuario->id,
                        'id_sucursal_salida' => $value['sucursal_salida'],
                        'id_sucursal_entrada' => $value['sucursal_entrada'],
                        'total_productos' => $value['cantidad'],
                        'razon' => $value['razon'],
                        'fecha_traspaso' => date_format($fecha_traspaso, 'Y-m-d H:i:s'),
                        'estatus' => 0
                    ];
                    if (Sucursal::where('id_sucursal', $value['sucursal_entrada'])->doesntExist() || Sucursal::where('id_sucursal', $value['sucursal_salida'])->doesntExist()) {
                        array_push($value, [
                            'error' => 'Una sucursal no existe!',
                            'index' => $key
                        ]);
                        array_push($incompletos, $value);
                        DB::rollBack();
                    } else {
                        if (TraspasoInventario::insert($json_agregar)) {
                            $id = DB::getPdo()->lastInsertId();
                            foreach ($value['inventario'] as $key_2 => $value_2) {
                                $inventario = DB::table('inventario')
                                    ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
                                    ->select('inventario.id_inventario', 'detalle_inventario.stock', 'detalle_inventario.id_detalle_inventario')
                                    ->where('upc', $value_2['upc'])
                                    ->where('detalle_inventario.id_sucursal', $value['sucursal_salida'])->get();
                                $json_detalle = [
                                    'id_traspaso_inventario' => $id,
                                    'id_inventario' => $inventario[0]->id_inventario,
                                    'cantidad' => $value_2['cantidad'],
                                    'cantidad_comprobada' => 0,
                                    'autorizado' => 0
                                ];
                                if (!DB::table('detalle_traspaso_inventario')->insert($json_detalle)) {
                                    //Aquí iba el proceso de movimiento del stock
                                    //se cambió para mejor autorizar desde la vista de traspasoss desde la sucursal de entrada
                                    array_push($value, [
                                        'error' => 'No se puedo insertar el detalle del traspaso!',
                                        'index' => $key
                                    ]);
                                    array_push($incompletos, $value);
                                    DB::rollBack();
                                }
                            }
                        } else {
                            array_push($value, [
                                'error' => 'No se puedo insertar el traspaso #' . ($key + 1),
                                'index' => $key
                            ]);
                            array_push($incompletos, $value);
                            DB::rollBack();
                        }
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    array_push($incompletos, $value);
                    DB::rollback();
                    throw $e;
                } catch (\Throwable $e) {
                    array_push($incompletos, $value);
                    DB::rollback();
                    throw $e;
                }
                /*DB::transaction(function () use($value, $usuario, $fecha_traspaso, $incompletos){
                    $json_agregar = [
                        'id_usuario' => $usuario->id,
                        'id_sucursal_salida' => $value['sucursal_salida'],
                        'id_sucursal_entrada' => $value['sucursal_entrada'],
                        'total_productos' => $value['cantidad'],
                        'razon' => $value['razon'],
                        'fecha_traspaso' => date_format($fecha_traspaso, 'Y-m-d H:i:s')
                    ];
                    if(Sucursal::where('id_sucursal', $value['sucursal_entrada'])->doesntExist() || Sucursal::where('id_sucursal', $value['sucursal_salida'])->doesntExist()){
                        return array_push($incompletos, $value);
                    }else{
                        if(TraspasoInventario::insert($json_agregar)){
                            $id = DB::getPdo()->lastInsertId();
                        }
                    }
                });*/
            }
            if (count($incompletos) > 0) {
                $request->flush();
                return [
                    ['response' => 'error', 'message' => 'Algo pasó al intenar realizar el traspaso!'],
                    ['traspaso_invalido' => $incompletos]
                ];
            } else {
                return [
                    ['response' => 'success', 'message' => 'Listo, se ha hecho la propuesta de traspaso a las sucursales correspondientes!']
                ];
            }
        }
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
    public function edit($traspasoInventario)
    {
        $traspaso = TraspasoInventario::where('id_traspaso_inventario', $traspasoInventario)
            ->select('traspaso_inventario.*', 'sucursal.sucursal as sucursal_salida', 'sucursal_2.sucursal as sucursal_entrada')
            ->leftJoin('sucursal', 'sucursal.id_sucursal', 'traspaso_inventario.id_sucursal_salida')
            ->leftJoin('sucursal as sucursal_2', 'sucursal_2.id_sucursal', 'traspaso_inventario.id_sucursal_entrada')
            ->get();
        $sucursales = DB::table('sucursal')->get();
        if ($traspaso[0]->estatus == 1) {
            return redirect()->back()->withErrors('error', 'Este traspaso no se puede editar!');
        } else {
            $detalle_traspaso = DB::table('detalle_traspaso_inventario')
                ->where('id_traspaso_inventario', $traspasoInventario)
                ->where('detalle_inventario.id_sucursal', $traspaso[0]->id_sucursal_salida)
                ->leftJoin('inventario', 'inventario.id_inventario', 'detalle_traspaso_inventario.id_inventario')
                ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
                ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
                ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
                ->leftJoin('color', 'color.id_color', 'inventario.id_color')->get();
            return view('TraspasoInventario.editarTraspasoInventario', compact('traspaso', 'detalle_traspaso', 'sucursales'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TraspasoInventario  $traspasoInventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'traspasos' => 'required'
            ]);

            $traspaso = $request->traspasos;
            $json_modificar = [
                'id_sucursal_salida' => $traspaso['sucursal_salida'],
                'id_sucursal_entrada' => $traspaso['sucursal_entrada'],
                'total_productos' => $traspaso['cantidad'],
                'razon' => $traspaso['razon']
            ];
            if (Sucursal::where('id_sucursal', $traspaso['sucursal_entrada'])->doesntExist() || Sucursal::where('id_sucursal', $traspaso['sucursal_salida'])->doesntExist()) {
                array_push($traspaso, [
                    'error' => 'Una sucursal no existe!'
                ]);
                array_push($incompletos, $traspaso);
                DB::rollBack();
            } else {
                $traspaso_inventario = TraspasoInventario::find($id);
                if ($traspaso_inventario->update($json_modificar)) {
                    if (DB::table('detalle_traspaso_inventario')->where('id_traspaso_inventario', $id)->delete()) {
                        foreach ($traspaso['inventario'] as $key_2 => $value_2) {
                            $inventario = DB::table('inventario')
                                ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
                                ->select('inventario.id_inventario', 'detalle_inventario.stock', 'detalle_inventario.id_detalle_inventario')
                                ->where('upc', $value_2['upc'])
                                ->where('detalle_inventario.id_sucursal', $traspaso['sucursal_salida'])->get();
                            $json_detalle = [
                                'id_traspaso_inventario' => $id,
                                'id_inventario' => $inventario[0]->id_inventario,
                                'cantidad' => $value_2['cantidad'],
                                'cantidad_comprobada' => 0,
                                'autorizado' => 0
                            ];
                            if (!DB::table('detalle_traspaso_inventario')->insert($json_detalle)) {
                                //Aquí iba el proceso de movimiento del stock
                                //se cambió para mejor autorizar desde la vista de traspasoss desde la sucursal de entrada
                                array_push($value, [
                                    'error' => 'No se puedo insertar el detalle del traspaso!',
                                    'index' => $key_2
                                ]);
                                array_push($incompletos, $value);
                                DB::rollBack();
                            }
                        }
                    }
                    DB::commit();
                    return [
                        ['response' => 'success', 'message' => 'Se modificó correctamente el traspaso!']
                    ];
                } else {
                    array_push($value, [
                        'error' => 'No se puedo insertar el traspaso'
                    ]);
                    array_push($incompletos, $value);
                    DB::rollBack();
                }
            }
        } catch (\Throwable $th) {
            $request->flush();
            return [
                ['response' => 'error', 'message' => 'Algo pasó al intenar modificar el traspaso!']
            ];
        }
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

    /**
     * Busca el artículo en inventario por sucursal
     * @param $UPC/EAN
     * @return Response
     */
    public function buscarInventarioSucursal(Request $request)
    {

        try {
            $pos = strpos($request->sucursal, " ", 0);
            $id = substr($request->sucursal, 0, $pos);
            $articulo = DB::table('inventario')->select('inventario.*', 'modelo.*', 'marca.*', 'categoria.*', 'color.*', 'capacidad.*', 'detalle_inventario.id_detalle_inventario', 'detalle_inventario.stock')
                ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
                ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
                ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
                ->leftJoin('color', 'color.id_color', 'inventario.id_color')
                ->leftJoin('capacidad', 'capacidad.id_capacidad', 'inventario.id_capacidad')
                ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
                ->where('detalle_inventario.id_sucursal', $id)
                ->where('upc', $request->upc)
                ->where('stock', '>', 0)->get();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checklistAutorizarTraspaso(Request $request)
    {
        $traspaso = TraspasoInventario::where('id_traspaso_inventario', $request->id_traspaso_inventario)
            ->select('traspaso_inventario.*', 'usuario.name', 'sucursal.sucursal as sucursal_salida', 'sucursal_2.sucursal as sucursal_entrada')
            ->leftJoin('sucursal', 'sucursal.id_sucursal', 'traspaso_inventario.id_sucursal_salida')
            ->leftJoin('sucursal as sucursal_2', 'sucursal_2.id_sucursal', 'traspaso_inventario.id_sucursal_entrada')
            ->leftJoin('usuario', 'usuario.id', 'traspaso_inventario.id_usuario')->get();
        if ($traspaso[0]->estatus == 1) {
            return redirect()->back()->withErrors('error', 'Este traspaso no se puede autorizar, ya ha sido autorizado!');
        } else {
            $detalle_traspaso = DB::table('detalle_traspaso_inventario')
                ->leftJoin('inventario', 'inventario.id_inventario', 'detalle_traspaso_inventario.id_inventario')
                ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
                ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
                ->leftJoin('color', 'color.id_color', 'inventario.id_color')
                ->leftJoin('categoria', 'categoria.id_categoria',  'inventario.id_categoria')
                ->where('id_traspaso_inventario', $request->id_traspaso_inventario)->get();
            return view('TraspasoInventario.autorizarTraspasoInventario', compact('traspaso', 'detalle_traspaso'));
        }
    }

    /**
     * Autoriza el traspaso entre sucursales
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autorizarTraspasoSucursal(Request $request)
    {
        $fecha_aprobacion = new DateTime();
        if ($request->estatus == 1) {
            $incompletos = array();
            //Cambiamos el estatus de traspaso a aprovar y hacemos los respectivos movimientos de inventario
            $traspaso = TraspasoInventario::where('id_traspaso_inventario', $request->traspaso[0]['id_traspaso_inventario'])->get();
            if ($traspaso[0]['estatus'] != 1) {
                //$detalle_traspaso = DB::table('detalle_traspaso_inventario')->where('id_traspaso_inventario',  $request->traspaso[0]['id_traspaso_inventario'])->get();
                foreach ($request->detalle_traspaso as $key => $value_2) {
                    DB::beginTransaction();;
                    try {
                        $inventario = DB::table('inventario')
                            ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
                            ->select('inventario.id_inventario', 'detalle_inventario.stock', 'detalle_inventario.id_detalle_inventario', 'inventario.upc')
                            ->where('inventario.id_inventario', $value_2['id_inventario'])
                            ->where('detalle_inventario.id_sucursal', $traspaso[0]['id_sucursal_salida'])->get();

                        $json_update = [
                            'stock' => $inventario[0]->stock - $value_2['cantidad_comprobada']
                        ];
                        if ($value_2['cantidad_comprobada'] > 0 && $json_update['stock'] > 0 && DB::table('detalle_inventario')->groupBy('stock')->havingRaw('? >= 0', [($inventario[0]->stock - $value_2['cantidad_comprobada'])])->where('id_detalle_inventario', $inventario[0]->id_detalle_inventario)->update($json_update)) {
                            $consulta = DB::table('detalle_inventario')->where('id_sucursal', $traspaso[0]['id_sucursal_entrada'])->where('id_inventario', $inventario[0]->id_inventario)->get();
                            if ($consulta->isNotEmpty()) {
                                if (!DB::table('detalle_inventario')->where('id_detalle_inventario', $consulta[0]->id_detalle_inventario)->update(['stock' => $consulta[0]->stock + $value_2['cantidad_comprobada']])) {
                                    array_push($value_2, [
                                        'error' => 'No se pudo agregar stock del siguente UPC/EAN  ' . $inventario[0]->upc . ' a la sucursal de destino!',
                                        'index' => $key
                                    ]);
                                    array_push($incompletos, $value_2);
                                    DB::rollBack();
                                }
                            } else {

                                $json_detalle_inventario = [
                                    'id_inventario' => $inventario[0]->id_inventario,
                                    'id_sucursal' => $traspaso[0]['id_sucursal_entrada'],
                                    'stock' => $value_2['cantidad_comprobada']
                                ];
                                if (!DB::table('detalle_inventario')->insert($json_detalle_inventario)) {
                                    array_push($value_2, [
                                        'error' => 'No se pudo agregar stock del siguente UPC/EAN  ' . $inventario[0]->upc . ' a la sucursal de destino!',
                                        'index' => $key
                                    ]);
                                    array_push($incompletos, $value_2);
                                    DB::rollBack();
                                }
                            }
                        } else {
                            array_push($value_2, [
                                'error' => 'No se tiene stock suficiente del siguente UPC/EAN  ' . $inventario[0]->upc . ' o no se traspaso este artículo!',
                                'index' => $key
                            ]);
                            array_push($incompletos, $value_2);

                            DB::rollBack();
                        }
                    } catch (\Exception $e) {
                        array_push($incompletos, $value_2);
                        DB::rollback();
                        throw $e;
                    } catch (\Throwable $e) {
                        array_push($incompletos, $value_2);
                        DB::rollback();
                        throw $e;
                    }
                    DB::commit();
                }

                if (count($incompletos) > 0) {
                    $request->flush();
                    TraspasoInventario::find($request->traspaso[0]['id_traspaso_inventario'])->update(['estatus' => 1, 'fecha_aprobacion' => date_format($fecha_aprobacion, 'Y-m-d H:i:s')]);
                    return [
                        ['response' => 'error', 'message' => 'Se han realizado los movimientos de inventario del traspaso posibles, pero algunos artículos no pudieron ser traspasados!'],
                        $incompletos
                    ];
                } else {
                    TraspasoInventario::find($request->traspaso[0]['id_traspaso_inventario'])->update(['estatus' => 1, 'fecha_aprobacion' => date_format($fecha_aprobacion, 'Y-m-d H:i:s')]);
                    return [
                        ['response' => 'success', 'message' => 'Se han realizado los movimientos de inventario del traspaso!']
                    ];
                }
            }
        } elseif ($request->estatus == 2) {
            //Cambiamos el estatus de traspaso a rechazado
            DB::beginTransaction();
            try {
                TraspasoInventario::find($request->traspaso[0]['id_traspaso_inventario'])->update(['estatus' => 2, 'fecha_aprobacion' => date_format($fecha_aprobacion, 'Y-m-d H:i:s')]);
                DB::commit();
                if (!$request->ajax())
                    return redirect()->back()->with('success', 'Se modifico el estatus del traspaso a Rechazado');
                else
                    return [
                        ['response' => 'success', 'message' => 'Se han rechazado los movimientos de inventario del traspaso con exito!']
                    ];
            } catch (\Throwable $th) {
                DB::rollback();
                if (!$request->ajax())
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar rechazar el traspaso!');
                else
                    return [
                        ['response' => 'error', 'message' => 'Algo pasó al intenar rechazar el traspaso!']
                    ];
            }
        }
    }

    /**
     * Muestra el detalle del traspaso seleccionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detalleTraspasoSucursal(Request $request)
    {
        $traspaso = TraspasoInventario::where('id_traspaso_inventario', $request->id_traspaso_inventario)
            ->select('traspaso_inventario.*', 'usuario.name', 'sucursal.sucursal as sucursal_salida', 'sucursal_2.sucursal as sucursal_entrada')
            ->leftJoin('sucursal', 'sucursal.id_sucursal', 'traspaso_inventario.id_sucursal_salida')
            ->leftJoin('sucursal as sucursal_2', 'sucursal_2.id_sucursal', 'traspaso_inventario.id_sucursal_entrada')
            ->leftJoin('usuario', 'usuario.id', 'traspaso_inventario.id_usuario')->get();
        $detalle_traspaso = DB::table('detalle_traspaso_inventario')
            ->leftJoin('inventario', 'inventario.id_inventario', 'detalle_traspaso_inventario.id_inventario')
            ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
            ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
            ->leftJoin('color', 'color.id_color', 'inventario.id_color')
            ->leftJoin('categoria', 'categoria.id_categoria',  'inventario.id_categoria')
            ->where('id_traspaso_inventario', $request->id_traspaso_inventario)->get();
        return view('TraspasoInventario.detalleTraspasoInventario', compact('traspaso', 'detalle_traspaso'));
    }
}
