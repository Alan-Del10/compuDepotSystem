<?php

namespace App\Http\Controllers;

use App\Compra;
use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DateTime;
use NumberFormatter;
use Printing;
use Rawilk\Printing\Contracts\Printer;
use Rawilk\Printing\Receipts\ReceiptPrinter;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Compra.compra');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = DB::table('proveedor')->get();
        $marcas = DB::table('marca')->where('estatus', 1)->get();
        $modelos = DB::table('modelo')->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')->where('modelo.estatus', 1)->get();
        $colores = DB::table('color')->where('estatus', 1)->get();
        $categorias = DB::table('categoria')->where('estatus', 1)->get();
        return view('Compra.agregarCompra', compact('proveedores', 'marcas', 'modelos', 'colores',  'categorias'));
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
                'compra' => 'required',
                'proveedor' => 'required',
                'total' => 'required',
                'productos' => 'required'
            ]);
            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                $request->flash();
                return redirect()->back()->withErrors($validator);
            }else{
                $productos_id = [];

                $fecha_entrada = new DateTime();
                $proveedor = DB::table('proveedor')->where('proveedor', $request->proveedor)->get();
                $json_agregar = [
                    'id_proveedor' => $proveedor[0]->id_proveedor,
                    'id_usuario' => Auth::user()->id,
                    'no_compra' => $request->compra,
                    'fecha_entrada' => date_format($fecha_entrada, 'Y-m-d H:i:s'),
                    'total' => $request->total
                ];
                if(Compra::insert($json_agregar)){

                    $id_compra = DB::getPdo()->lastInsertId();
                    foreach ($request->productos as $producto) {
                        $consulta = Inventario::where('upc', $producto['upc'])->get();
                        if(!isset($consulta[0])){
                            $categoria = DB::table('categoria')->where('categoria', $producto['categoria'])->get();
                            $modelo = DB::table('modelo')->where('modelo', $producto['modelo'])->get();
                            $marca = DB::table('marca')->where('marca', $producto['marca'])->get();
                            $color = DB::table('color')->where('color', $producto['color'])->get();
                            $json_inventario = [
                                'upc' => $producto['upc'],
                                'id_categoria' => $categoria[0]->id_categoria,
                                'id_modelo' => $modelo[0]->id_modelo,
                                'id_proveedor' => $proveedor[0]->id_proveedor,
                                'titulo_inventario' => $producto['categoria']." ".$producto['marca']." ".$producto['modelo']." ".$producto['color'],
                                'costo' => $producto['costo'],
                                'fecha_alta' => date_format($fecha_entrada, 'Y-m-d H:i:s'),
                                'stock_min' => 1,
                                'precio_min' => $producto['costo'] * 1.10,
                                'id_color' => $color[0]->id_color
                            ];
                            if(Inventario::insert($json_inventario)){
                                $id_inventario = DB::getPdo()->lastInsertId();
                                if(!DB::table('detalle_compra')->insert(['id_compra'=>$id_compra, 'id_inventario'=>$id_inventario, 'cantidad'=>$producto['piezas'], 'costo'=>$producto['costo']])){
                                    DB::rollBack();
                                    return ['response'=>'error', 'message'=>'Algo pasó al intenar los nuevos produtos en dentro del detalle de la compra con los nuevos productos!'];
                                }
                            }else{
                                DB::rollBack();
                                return ['response'=>'error', 'message'=>'Algo pasó al intenar los nuevos produtos en inventario!'];
                            }
                        }else{

                            $json_inventario = [
                                'upc' => $producto['upc'],
                                'id_proveedor' => $proveedor[0]->id_proveedor,
                                'costo' => $producto['costo'],
                                'fecha_modificacion' => date_format($fecha_entrada, 'Y-m-d H:i:s'),
                                'stock_min' => 1,
                                'precio_min' => $producto['costo'] * 1.10,
                            ];

                            if(Inventario::where('upc', $producto['upc'])->update($json_inventario)){

                                $id_inventario = Inventario::where('upc', $producto['upc'])->get();

                                if(!DB::table('detalle_compra')->insert(['id_compra'=>$id_compra, 'id_inventario'=>$id_inventario[0]->id_inventario, 'cantidad'=>$producto['piezas'], 'costo'=>$producto['costo']])){

                                    DB::rollBack();
                                    return ['response'=>'error', 'message'=>'Algo pasó al intenar los nuevos produtos en dentro del detalle de la compra de productos ya existentes en el inventario!'];
                                }
                            }else{
                                DB::rollBack();
                                return ['response'=>'error', 'message'=>'Algo pasó al intenar actualizar los datos de los productos en el inventario!'];
                            }
                        }
                    }
                    $this->imprimirTicketCompra($id_compra);
                    DB::commit();
                    return ['response'=>'success', 'message'=>'Se ha registrado la compra con éxito!'];
                }else{
                    DB::rollBack();
                    return ['response'=>'error', 'message'=>'Algo pasó al intenar realizar el registro de la compra!'];
                }

            }
        } catch (\Throwable $th) {
            $request->flash();
            DB::rollBack();
            return ['response'=>'error', 'message'=>'Algo pasó al intenar realizar el registro de la compra!'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        //
    }

    /**
     * Comprobar consulta
     */
    public function comprobarConsultaDB($data){
        if(count($data) > 0){
            return $this->convertToJSON($data);
        }
    }

    public function imprimirTicketCompra($id_compra){

        $compra = DB::table('compra')->select('compra.*', 'sucursal.tickets as tickets', 'proveedor.*', 'usuario.*')
        ->where('id_compra', $id_compra)
        ->leftJoin('usuario', 'usuario.id', 'compra.id_usuario')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'usuario.id_sucursal')
        ->leftJoin('proveedor', 'proveedor.id_proveedor', 'compra.id_proveedor')->get();
        //
        $detalle_compra = DB::table('detalle_compra')->where('id_compra', $id_compra)
        ->leftJoin('inventario', 'inventario.id_inventario', 'detalle_compra.id_inventario')->get();
        $productos = "";
        $totalArticulos = 0;
        foreach($detalle_compra as $detalle){
            $productos .= $detalle->upc." ".$detalle->titulo_inventario."\n"
                            ."            ".$detalle->cantidad."X          $".$detalle->costo."           $".($detalle->costo * $detalle->cantidad."\n");
            $totalArticulos += $detalle->cantidad;
        }
        $totalTexto = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $receipt = (string) (new ReceiptPrinter)
            ->setTextSize(1,2)
            ->text("Datos Del Proveedor y Paquete")
            ->setTextSize(1,1)
            ->text($compra[0]->proveedor)
            ->text('No. Compra Proveedor: '.$compra[0]->no_compra)
            ->line()
            ->leftAlign()
            ->setTextSize(1,1)
            ->text("C. barras       Producto")
            ->text("        Cant. P.        Precio U.       Importe")
            ->text($productos)
            ->centerAlign()
            ->line()
            ->leftAlign()
            ->text("  TOTAL($)                             $".$compra[0]->total)
            ->text("  Total Articulos                    ".$totalArticulos." pza(s).")
            ->text("  *".$totalTexto->format($compra[0]->total)." M.N.")
            ->centerAlign()
            ->line()
            ->leftAlign()
            ->text("Registrado@ por: ".$compra[0]->name)
            ->text("Fecha: ".$compra[0]->fecha_entrada)
            ->text("No. Compra Interno: ".$compra[0]->id_compra)
            ->feed(3)
            ->rightAlign()
            ->text("Powered By Gesdra")
            ->feed(2)
            ->cut();

        Printing::newPrintTask()
            ->printer($compra[0]->tickets)
            ->content($receipt)
            ->copies(1)
            ->send();
    }
}
