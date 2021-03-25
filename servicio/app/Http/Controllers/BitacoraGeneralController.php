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
        ->leftJoin('sucursal', 'sucursal.id_sucursal', 'bitacora_general.id_sucursal')->orderBy('fecha_log_general','DESC')->paginate(10);
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
    public function registrarBitacora($fecha, $descripcion, $usuario, $sucursal){
        BitacoraGeneral::insert([
            'fecha_log_general' => $fecha,
            'descripcion_log_general' => $descripcion,
            'id_usuario' => $usuario,
            'id_sucursal' => $sucursal
        ]);
    }

    public function pruebas(){
        $activity = Telegram::getUpdates();
        dd($activity);

    }

    public function mensajeTelegram($name,$sucursal,$direccion,$fecha_modificacion,$num_ticket=null,$upc=null,$titulo=null,$ticket_impreso=null)
    {

        if(gettype($fecha_modificacion) != "string"){
         $date = date_format($fecha_modificacion, 'Y-m-d H:i:s');
        } else {
            $date = $fecha_modificacion;
        }

        if(!is_null($upc)){
            $text = "El usuario "
            . "<b>". $name. "</b> "
            ."ha modificado los atributos del artículo con el"
            . "<b> UPC/EAN ". $upc. "</b> "
            . "con el título"
            . "<b> ". $titulo. "</b> "
            . " desde la sucursal"
            . "<b> ". $sucursal." ". $direccion ."</b> "
            . "a la fecha"
            . "<b> ". $date . "</b> ";

            Telegram::sendMessage([
                'chat_id' => env('TELEGRAM_CHANNEL_ID_BITACORA'),
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
        }

        if(!is_null($num_ticket)){
            $text = "El usuario "
            . "<b>". $name. "</b> "
            ."ha realizado la venta del ticket no."
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

        if(!is_null($ticket_impreso)){
            /* descripcion = 'El usuario '.$usuario.' ha reimpreso el ticket de la venta no. '.$request->id_venta.' desde la sucursal '.$sucursal[0]->sucursal. ' a la fecha '.date_format($fecha, 'Y-m-d H:i:s'); */
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

        //dd(gettype($usuario_nombre),gettype($upc),gettype($titulo),gettype($sucursal),gettype($fecha_modificacion));


    }


}
