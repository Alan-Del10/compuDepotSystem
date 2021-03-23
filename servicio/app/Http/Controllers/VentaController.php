<?php

namespace App\Http\Controllers;

use App\BitacoraGeneral;
use App\FormaPago;
use App\Servicio;
use App\Venta;
use App\Inventario;
use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
/*use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;*/
use Mike42\Escpos\EscposImage;
use NumberFormatter;
use Printing;
use Rawilk\Printing\Contracts\Printer;
use Rawilk\Printing\Receipts\ReceiptPrinter;
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Venta::orderby('id_venta','desc')
        ->leftJoin('usuario', 'usuario.id', 'venta.id_usuario')
        ->leftJoin('cliente', 'cliente.id_cliente', 'venta.id_cliente')->paginate(10);
        return view('Venta.venta', compact('ventas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $formas_pago = FormaPago::where('estatus', true)->get();
        $clientes = Cliente::get();
        $tipos_clientes = DB::table('tipo_cliente')->where('estatus', true)->get();
        return view('Venta.agregarVenta',compact('formas_pago', 'clientes', 'tipos_clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Venta::create($request->all());
        DB::beginTransaction();
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
                $request->flash();
                return $validator;
            }else{*/
                $fecha_venta = new DateTime();
                $usuario = Auth::user();
                $pos = strpos($request->cliente, " ", 0);
                $id_cliente = substr($request->cliente, 0, $pos);
                $cliente = DB::table('cliente')->where('id_cliente', $id_cliente)->get();
                if(count($cliente) > 0){
                    $cliente = $cliente[0]->id_cliente;
                }

                $json_agregar = [
                    'fecha_venta' => date_format($fecha_venta, 'Y-m-d H:i:s'),
                    'subtotal' => $request->totales['subtotal'],
                    'iva' => $request->totales['iva'],
                    'total' => $request->totales['total'],
                    'id_cliente' => $cliente,
                    'id_sucursal' => $usuario->id_sucursal,
                    'id_usuario' => $usuario->id,
                    'estatus' => true
                ];

                if(Venta::insert($json_agregar)){
                    $id = DB::getPdo()->lastInsertId();
                    //dd($request->ticket);
                    foreach($request->ticket as $detalle){

                        $inventario = DB::table('inventario')->where('upc', $detalle['upc'])->get();

                        if(count($inventario) > 0){
                            $id_inventario = $inventario[0]->id_inventario;
                            $precio = $inventario[0]->precio_max;
                        }
                        $detalle_inventario = DB::table('detalle_inventario')->where('id_inventario', $id_inventario)->where('id_sucursal', $usuario->id_sucursal)->get();
                        $json_detalle = [
                            'id_venta' => $id,
                            'id_inventario' => $id_inventario,
                            'cantidad' => $detalle['piezas'],
                            'precio_momento' => $detalle['precio']
                        ];
                        $json_update = [
                            'stock' => $detalle_inventario[0]->stock - $detalle['piezas']
                        ];
                        if(!DB::table('detalle_inventario')->groupBy('stock')->havingRaw('? >= 0', [($detalle_inventario[0]->stock - $detalle['piezas'])])->where('id_detalle_inventario', $detalle_inventario[0]->id_detalle_inventario)->update($json_update)){
                            $request->flash();
                            DB::rollBack();
                            return ['response'=>'error', 'message'=>'Algo pasó al intenar realizar la venta, no tienes stock suficiente!'];
                        }
                        if(!DB::table('detalle_venta')->insert($json_detalle)){
                            $request->flash();
                            DB::rollBack();
                            return ['response'=>'error', 'message'=>'Algo pasó al intenar realizar la venta, tu ticket tiene algo mal!'];
                        }
                    }

                    foreach($request->formas_pago as $forma){
                        $forma_pago = DB::table('forma_de_pago')->where('forma_pago', $forma['forma'])->get();
                        if(count($forma_pago) > 0){
                            $id_forma_pago = $forma_pago[0]->id_forma_de_pago;
                        }
                        $json_pago = [
                            'id_venta' => $id,
                            'id_forma_de_pago' => $id_forma_pago,
                            'monto' => $forma['pago']
                        ];
                        //dd($json_pago);
                        if(!DB::table('venta_pago')->insert($json_pago)){
                            $request->flash();
                            DB::rollBack();
                            return ['response'=>'error', 'message'=>'Algo pasó al intenar realizar la venta, tus formas de pago pueden estar mal!'];
                        }
                    }

                    $this->imprimirTicketVentaV2($id);
                    $usuario_nombre = Auth::user()->name;
                    $usuario_id = Auth::user()->id;
                    $sucursal_id = Auth::user()->id_sucursal;
                    $sucursal = DB::table('sucursal')->where('id_sucursal', $sucursal_id)->get();
                    $descripcion = 'El usuario '.$usuario_nombre.' ha realizado la venta del ticket no. '.$id.' desde la sucursal '.$sucursal[0]->sucursal. ' a la fecha '.date_format($fecha_venta, 'Y-m-d H:i:s');
                    $this->registrarBitacora($fecha_venta, $descripcion, $usuario_id, $sucursal_id);
                    DB::commit();
                    return ['response'=>'success', 'message'=>'Se realizó correctamente la venta!.'];
                }else{
                    $request->flash();
                    DB::rollBack();
                    return ['response'=>'error', 'message'=>'Algo pasó al intenar realizar la venta, no pudimos crear la venta!'];
                }

            //}
        } catch (\Exception $e) {
            $request->flash();
            DB::rollBack();
            return ['response'=>'error', 'message'=>'Algo pasó al intenar realizar la venta!'];
        }
        DB::commit();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }

    /**
     * Busca el artículo en inventario
     * @param $UPC/EAN
     * @return Response
     */
    public function verificarUPCVenta(Request $request){

        try {
            $articulo = DB::table('inventario')->select('inventario.*', 'modelo.*', 'marca.*', 'categoria.*', 'color.*', 'capacidad.*', 'detalle_inventario.id_detalle_inventario', 'detalle_inventario.stock')
            ->leftJoin('modelo', 'modelo.id_modelo', 'inventario.id_modelo')
            ->leftJoin('marca', 'marca.id_marca', 'modelo.id_marca')
            ->leftJoin('categoria', 'categoria.id_categoria', 'inventario.id_categoria')
            ->leftJoin('color', 'color.id_color', 'inventario.id_color')
            ->leftJoin('capacidad', 'capacidad.id_capacidad', 'inventario.id_capacidad')
            ->leftJoin('detalle_inventario', 'detalle_inventario.id_inventario', 'inventario.id_inventario')
            ->leftJoin('sucursal', 'sucursal.id_sucursal', 'detalle_inventario.id_sucursal')->where('upc', $request->upc)->where('detalle_inventario.id_sucursal', Auth::user()->id_sucursal)
            ->where('stock', '>', 0)->get();
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
    public function imprimirTicketVenta($id_venta){

        $venta = DB::table('venta')->select('venta.*', 'sucursal.direccion as direccion_sucursal', 'sucursal.sucursal as sucursal', 'sucursal.logo as logo', 'cliente.*', 'usuario.*')
        ->where('id_venta', $id_venta)
        ->leftJoin('usuario', 'usuario.id', 'venta.id_usuario')
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'venta.id_sucursal')
        ->leftJoin('cliente', 'cliente.id_cliente', 'venta.id_cliente')->get();
        $detalle_venta = DB::table('detalle_venta')->where('id_venta', $id_venta)
        ->leftJoin('inventario', 'inventario.id_inventario', 'detalle_venta.id_inventario')->get();
        $pago_venta = DB::table('venta_pago')->where('id_venta', $id_venta)
        ->leftJoin('forma_de_pago', 'forma_de_pago.id_forma_de_pago', 'venta_pago.id_forma_de_pago')->get();
        $profile = CapabilityProfile::load("SP2000");
        $ruta = "smb://".gethostname()."/Tickets3";
        $img = EscposImage::load("../public/storage/sucursales/".$venta[0]->logo, false);
        //$img = EscposImage::load("../public/storage/img/logo.png", false);
        $connector = new WindowsPrintConnector($ruta);
        $impresora = new Printer($connector,$profile);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);

        $impresora->bitImage($img, Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);
        $impresora->text("\n");
        $impresora->setTextSize(2, 2);
        $impresora->text($venta[0]->sucursal."\n");
        $impresora->setTextSize(1, 1);
        $impresora->text($venta[0]->direccion_sucursal."\n");
        $impresora->text("_______________________\n");
        $impresora->setTextSize(1, 2);
        $impresora->text("Datos Del Cliente\n");
        $impresora->setTextSize(1, 1);
        $impresora->text($venta[0]->nombre_completo."\n");
        $impresora->text("Dirección: ".$venta[0]->direccion."\n");
        $impresora->text("Tel: ".$venta[0]->telefono."\n");
        $impresora->text("Email: ".$venta[0]->correo."\n");
        $impresora->text("_______________________\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->setTextSize(1, 1);
        $impresora->text("Producto                  Prec.\n");
        foreach($detalle_venta as $detalle){
            $impresora->text($detalle->cantidad." ".$detalle->titulo_inventario." ".$detalle->precio_momento."\n");
        }
        $impresora->setTextSize(1, 1);
        $impresora->text("  SUBTOTAL                ".$venta[0]->subtotal."\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->text("________\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("  IVA(%16)               ".$venta[0]->iva."\n");
        $impresora->text("  TOTAL $               ".$venta[0]->total."\n");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("_______________________\n");
        $impresora->setJustification(Printer::JUSTIFY_LEFT);
        $impresora->text("Atendid@ por: ".$venta[0]->name."\n");
        $impresora->text("Fecha: ".$venta[0]->fecha_venta."\n");
        $impresora->text("Ticket No. ".$venta[0]->id_venta."\n");
        $impresora->feed(4);
        $impresora->close();
    }

    public function imprimirTicketVentaV2($id_venta){

        $venta = DB::table('venta')->select('venta.*', 'sucursal.direccion as direccion_sucursal', 'sucursal.sucursal as sucursal', 'sucursal.logo as logo', 'sucursal.politicas as politicas', 'sucursal.tickets as tickets', 'cliente.*', 'usuario.*')
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
        $totalArticulos = 0;
        foreach($detalle_venta as $detalle){
            $productos .= $detalle->upc." ".$detalle->titulo_inventario."\n"
                            ."            ".$detalle->cantidad."X          $".$detalle->precio_momento."           $".($detalle->precio_momento * $detalle->cantidad."\n");
            $totalArticulos += $detalle->cantidad;
        }
        $formas = "";
        foreach($pago_venta as $pago){
            $formas .= $pago->forma_pago."  $".$pago->monto."\n";
        }
        $iconoRegistrado = chr(169);
        $str = sprintf("Powered By Geesdra %c", 169);
        $totalTexto = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $receipt = (string) (new ReceiptPrinter)
            ->centerAlign()
            ->bitImage($img)
            ->feed(1)
            ->setTextSize(2, 2)
            ->text($venta[0]->sucursal)
            ->setTextSize(1,1)
            ->text($venta[0]->direccion_sucursal)
            ->line()
            ->setTextSize(1,2)
            ->text("Datos Del Cliente")
            ->setTextSize(1,1)
            ->text($venta[0]->nombre_completo)
            ->text("Direccion: ".$venta[0]->direccion)
            ->text("Tel: ".$venta[0]->telefono)
            ->text("Email: ".$venta[0]->correo)
            ->line()
            ->leftAlign()
            ->setTextSize(1,1)
            ->text("C. barras       Producto")
            ->text("        Cant. P.        Precio U.       Importe")
            ->text($productos)
            ->text("  SUBTOTAL                              $".$venta[0]->subtotal)
            ->centerAlign()
            ->line()
            ->leftAlign()
            ->text("  IVA(%16)                             $".$venta[0]->iva)
            ->text("  TOTAL($)                             $".$venta[0]->total)
            ->text("  Total Articulos                    ".$totalArticulos." pza(s).")
            ->text("  *".$totalTexto->format($venta[0]->total)." M.N.")
            ->centerAlign()
            ->line()
            ->setTextSize(1,2)
            ->text("Formas de Pago")
            ->setTextSize(1,1)
            ->text($formas)
            ->centerAlign()
            ->line()
            ->leftAlign()
            ->text("Atendid@ por: ".$venta[0]->name)
            ->text("Fecha: ".$venta[0]->fecha_venta)
            ->text("Ticket No. ".$venta[0]->id_venta)
            ->centerAlign()
            ->line()
            ->setTextSize(1,2)
            ->text("Politicas")
            ->setTextSize(1,1)
            ->leftAlign()
            ->text($venta[0]->politicas)
            ->centerAlign()
            ->feed(3)
            ->text("_________________________")
            ->text("Firma")
            ->feed(2)
            ->barcode(strval($venta[0]->id_venta))
            ->feed(3)
            ->rightAlign()
            ->text("Powered By Gesdra")
            ->feed(2)
            ->cut();

        Printing::newPrintTask()
            ->printer($venta[0]->tickets)
            ->content($receipt)
            ->copies(2)
            ->send();
    }

    public function reimprimirTicket(Request $request){
        $this->imprimirTicketVentaV2($request->id_venta);
        $fecha = new DateTime();
        $usuario = Auth::user()->name;
        $usuario_id = Auth::user()->id;
        $sucursal_id = Auth::user()->id_sucursal;
        $sucursal = DB::table('sucursal')->where('id_sucursal', $sucursal_id)->get();
        $descripcion = 'El usuario '.$usuario.' ha reimpreso el ticket de la venta no. '.$request->id_venta.' desde la sucursal '.$sucursal[0]->sucursal. ' a la fecha '.date_format($fecha, 'Y-m-d H:i:s');
        $this->registrarBitacora($fecha, $descripcion, $usuario_id, $sucursal_id);

    }

    public function registrarBitacora($fecha, $descripcion, $usuario, $sucursal){
        BitacoraGeneral::insert([
            'fecha_log_general' => date_format($fecha, 'Y-m-d H:i:s'),
            'descripcion_log_general' => $descripcion,
            'id_usuario' => $usuario,
            'id_sucursal' => $sucursal
        ]);
    }
}
