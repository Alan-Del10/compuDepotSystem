<?php

namespace App\Http\Controllers;

use App\BitacoraGeneral;
use Illuminate\Http\Request;
use Telegram\Bot\BotsManager as BotBotsManager;
/* Bot Telegram */
use Telegram\Bot\Laravel\Facades\Telegram;

class BitacoraGeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = BitacoraGeneral::leftJoin('usuario', 'usuario.id', 'bitacora_general.id_usuario')
            ->leftJoin('sucursal', 'sucursal.id_sucursal', 'bitacora_general.id_sucursal')->orderBy('fecha_log_general', 'DESC')->paginate(10);
        return view('Bitacora.bitacoraGeneral', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BitacoraGeneral  $bitacoraGeneral
     * @return \Illuminate\Http\Response
     */
    public function show(BitacoraGeneral $bitacoraGeneral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BitacoraGeneral  $bitacoraGeneral
     * @return \Illuminate\Http\Response
     */
    public function edit(BitacoraGeneral $bitacoraGeneral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BitacoraGeneral  $bitacoraGeneral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BitacoraGeneral $bitacoraGeneral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BitacoraGeneral  $bitacoraGeneral
     * @return \Illuminate\Http\Response
     */
    public function destroy(BitacoraGeneral $bitacoraGeneral)
    {
        //
    }

    /**
     * Función que registra en bitacora general los movimientos de ventas e inventario
     */
    public function registrarBitacora($fecha, $descripcion, $usuario, $sucursal)
    {
        BitacoraGeneral::insert([
            'fecha_log_general' => date_format($fecha, 'Y-m-d H:i:s'),
            'descripcion_log_general' => $descripcion,
            'id_usuario' => $usuario,
            'id_sucursal' => $sucursal
        ]);
    }

    public function updatedActivity()
    {
        $activity = Telegram::getUpdates();
        dd($activity);
    }

    public function mensajeTelegram($name,$sucursal=null,$direccion=null,$fecha_modificacion=null,$num_ticket=null,$upc=null,$titulo=null,$ticket_impreso=null,$stock=null,$puesto=null,$correo=null,$ip=null,$tot_articulos=null,$cliente_de = null,$total_venta=null,$productos=null,$se_cambio=null,$reimprimir=false)
    {



        if(gettype($fecha_modificacion) != "string"){
         $date = date_format($fecha_modificacion, 'Y-m-d H:i:s');
        } else {
            $date = $fecha_modificacion;
        }
        try{
        if(!is_null($upc) && !is_null($se_cambio)){

            $text = "El usuario "
            . "<b>". $name. "</b> "
            ."ha modificado"
            ."<b>".$se_cambio."</b>"
            ." del artículo con el"
            . "<b> UPC/EAN ". $upc . "</b> "

            . "con el título"
            . "<b> ". $titulo. "</b> "
            . " desde la sucursal"
            . "<b> ". $sucursal." ". $direccion ."</b> "
            . "con stock "
            ."<b>". $stock ." pza(s) </b> "
            . "a la fecha"
            . "<b> ". $date . "</b> ";

            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_BITACORA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
        }

        if(!is_null($num_ticket) && is_null($ticket_impreso) && !is_null($productos) && !$reimprimir){
            //Para chat de venta
            $text = "El usuario "
            . "<b>". $name. "</b> "
            ."ha realizado la venta del ticket no."
            . "<b> ". $num_ticket. "</b> "
            ."<b>\n\nDatos de la venta</b>"
            ."<b>".$productos."</b>"
            . " \ndesde la sucursal"
            . "<b> ". $sucursal." ". $direccion . "</b> "
            . "a la fecha"
            . "<b> ". $date . "</b> ";
 

             Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_BITACORA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_VENTA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

        }

        if(!is_null($num_ticket) && is_null($ticket_impreso) && !is_null($tot_articulos) && !is_null($cliente_de) && !is_null($total_venta) && !$reimprimir){
            //Para chat de bitacora
            $text = "El usuario "
            . "<b>". $name. "</b> "
            ."ha realizado la venta del ticket no."
            . "<b> ". $num_ticket. "</b> "
            ."<b>\n\nDatos de la venta</b>"
            ."<b>\nTotal de articulos: ".$tot_articulos."</b>"
            ."<b>\nCliente de:".$cliente_de."</b>"
            ."<b>\nTotal($):".$total_venta."</b>"
            . " \ndesde la sucursal"
            . "<b> ". $sucursal." ". $direccion . "</b> "
            . "a la fecha"
            . "<b> ". $date . "</b> ";
            
   

             Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_BITACORA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_VENTA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

        }

        if(!is_null($ticket_impreso) && $reimprimir){

            $text = "El usuario "
            . "<b>". $name. "</b> "
            ."ha reimpreso el ticket de la venta no."
            . "<b> ". $num_ticket. "</b> "
            . " desde la sucursal"
            . "<b> ". $sucursal." ". $direccion . "</b> "
            . "a la fecha"
            . "<b> ". $date . "</b> ";


            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_BITACORA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_VENTA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
           

        }

        if(!is_null($puesto)){

            $text = "El usuario "
            . "<b>". $name. "</b> "
            ."ha ingresado al sistema con un correo electronico"
            . "<b> ". $correo. "</b> "
            . " clasificado como"
            . "<b> ".$puesto . "</b> "
            . "a la fecha"
            . "<b> ". $date . "</b> "
            ." con un IP "
            . "<b> ". $ip . "</b> ";


            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_BITACORA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);

        }


    }catch(\Throwable $th){
        dd($th);
        dd(gettype($name),gettype($sucursal),gettype($direccion),gettype($date),gettype($num_ticket),gettype($upc),gettype($titulo),gettype($ticket_impreso),gettype($stock));
        return redirect()->back()->withErrors($th);
    }


    }

}
