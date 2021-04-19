<?php

namespace App\Http\Controllers;

use App\CorteCaja;
use App\Sucursal;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Image;
use Illuminate\Support\Facades\Storage;
use Printing;
use Rawilk\Printing\Contracts\Printer;
use Rawilk\Printing\PrintTask;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class CorteCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cortes = CorteCaja::orderby('id_corte_caja','asc')
        ->leftJoin('usuario', 'usuario.id', 'corte_caja.id_usuario')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'corte_caja.id_sucursal')->paginate(10);
        $sucursales = Sucursal::get();
        return view('CorteCaja.corteCaja', compact('cortes', 'sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::get();
        return view('CorteCaja.agregarCorte', compact('sucursales'));
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
            //dd($request->totales['subtotal']);
            /*$validator = Validator::make($request->all(), [
                'totales["subtotal"]' => 'required|numeric',
                'totales["iva"]' => 'required|numeric',
                'totales["total"]' => 'required|numeric',
                'totales["cliente"]' => 'required'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return $validator;
            }else{*/
                $fecha_corte = new DateTime();
                $usuario = Auth::user();
                $json_agregar = [
                    'fecha_corte' => date_format($fecha_corte, 'Y-m-d H:i:s'),
                    'id_sucursal' => $request->sucursal,
                    'id_usuario' => $usuario->id,
                    'monto' => $request->monto,
                    'tipo_corte' => $request->tipo_corte
                ];
                if(CorteCaja::insert($json_agregar)){
                    $id = DB::getPdo()->lastInsertId();
                    //$this->imprimirCorte($id);
                    return ['response'=>'success', 'message'=>'Se realizó correctamente el corte!.'];
                }else{
                    $request->flash();
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar realizar el corte!');
                }
            //}
        } catch (\Throwable $th) {
            $request->flash();
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CorteCaja  $corteCaja
     * @return \Illuminate\Http\Response
     */
    public function show(CorteCaja $corteCaja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CorteCaja  $corteCaja
     * @return \Illuminate\Http\Response
     */
    public function edit(CorteCaja $corteCaja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CorteCaja  $corteCaja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CorteCaja $corteCaja)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CorteCaja  $corteCaja
     * @return \Illuminate\Http\Response
     */
    public function destroy(CorteCaja $corteCaja)
    {
        //
    }

    public function imprimirCorte($id_corte){

        $venta = DB::table('venta')->select('venta.*', 'sucursal.direccion as direccion_sucursal', 'sucursal.sucursal as sucursal', 'sucursal.logo as logo', 'cliente.*', 'usuario.*')
        ->where('id_venta', $id_venta)
        ->leftJoin('usuario', 'usuario.id', 'venta.id_usuario')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'venta.id_sucursal')
        ->leftJoin('cliente', 'cliente.id_cliente', 'venta.id_cliente')->get();
        $img = EscposImage::load("../public/storage/sucursales/".$venta[0]->logo, false);
        $detalle_venta = DB::table('detalle_venta')->where('id_venta', $id_venta)
        ->leftJoin('inventario', 'inventario.id_inventario', 'detalle_venta.id_inventario')->get();
        $pago_venta = DB::table('venta_pago')->where('id_venta', $id_venta)
        ->leftJoin('forma_de_pago', 'forma_de_pago.id_forma_de_pago', 'venta_pago.id_forma_de_pago')->get();
        $productos = "";
        foreach($detalle_venta as $detalle){
            $productos .= $detalle->cantidad." ".substr($detalle->titulo_inventario,0, 37)." $".$detalle->precio_momento."\n";
        }
        $receipt = (string) (new ReceiptPrinter)
            ->centerAlign()
            ->bitImage($img)
            ->feed(1)
            ->setTextSize(2, 2)
            ->text($venta[0]->sucursal)
            ->setTextSize(1,1)
            ->text($venta[0]->direccion_sucursal)
            ->setTextSize(1,2)
            ->text("_____________________________________________")
            ->text("Datos Del Cliente")
            ->setTextSize(1,1)
            ->text($venta[0]->nombre_completo)
            ->text("Dirección: ".$venta[0]->direccion)
            ->text("Tel: ".$venta[0]->telefono)
            ->text("Email: ".$venta[0]->correo)
            ->text("_____________________________________________")
            ->leftAlign()
            ->setTextSize(1,1)
            ->text("Producto                                Prec.")
            ->text($productos)
            ->text("  SUBTOTAL                              $".$venta[0]->subtotal)
            ->rightAlign()
            ->line()
            ->leftAlign()
            ->text("  IVA(%16)                                  $".$venta[0]->iva)
            ->text("  TOTAL($)                              $".$venta[0]->total)
            ->centerAlign()
            ->text("_____________________________________________")
            ->leftAlign()
            ->text("Atendid@ por: ".$venta[0]->name)
            ->text("Fecha: ".$venta[0]->fecha_venta)
            ->text("Ticket No. ".$venta[0]->id_venta)
            ->feed(4)
            ->cut();

        Printing::newPrintTask()
            ->printer(70134223)
            ->content($receipt)
            ->send();
    }
}
