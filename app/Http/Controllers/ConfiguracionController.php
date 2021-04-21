<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Configuracion.configuracion');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Cambia el nombre de la aplicación.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $path = base_path('.env');
        file_put_contents($path, str_replace(
            'APP_NAME='.env('APP_NAME'), 'APP_NAME='.$request->nombreAplicacion, file_get_contents($path)
        ));
        return view('Configuracion.configuracion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Cambia el nombre de la aplicación
     * @param  \Illuminate\Http\Request  $request
     */
    public function cambiarNombreAplicacion(Request $request){
        $path = base_path('.env');

        file_put_contents($path, str_replace(
            'APP_NAME="'.env('APP_NAME').'"', 'APP_NAME="'.$request->nombreAplicacion.'"', file_get_contents($path)
        ));
        $request->session()->flush();
        return redirect()->back();
    }

    /**
     * Cambia el logo de la aplicación
     * @param  \Illuminate\Http\Request  $request
     */
    public function cambiarLogoAplicacion(Request $request){
        if ($request->has('logoAplicacion')) {
            $image      = $request->file('logoAplicacion');
            $fileName   = 'logo.' . $image->getClientOriginalExtension();

            $image->move(public_path("storage/img"),$fileName);

            /* $img = Image::make($image->getRealPath()); */
            /* $img->resize(120, 120, function ($constraint) {
                $constraint->aspectRatio();
            }); */

           /*  $img->stream(); */ // <-- Key point

           /*  if(Storage::disk('local')->exists('public/img/logo.png')) {
                Storage::disk('local')->delete('public/img/logo.png');
            } */
            /* Storage::disk('local')->put('public/img'.'/'.$fileName, $img, 'public'); */
        }
        return redirect()->back();
    }

    /**
     * Cambia servidor SMTP de la aplicación
     * @param  \Illuminate\Http\Request  $request
     */
    public function cambiarSMTPAplicacion(Request $request){
        $path = base_path('.env');
        //cambiamos el host
        file_put_contents($path, str_replace(
            'MAIL_HOST='.env('MAIL_HOST'), 'MAIL_HOST='.$request->host, file_get_contents($path)
        ));
        //cambiamos el puerto
        file_put_contents($path, str_replace(
            'MAIL_PORT='.env('MAIL_PORT'), 'MAIL_PORT='.$request->puerto, file_get_contents($path)
        ));
        //cambiamos el usuario
        file_put_contents($path, str_replace(
            'MAIL_USERNAME='.env('MAIL_USERNAME'), 'MAIL_USERNAME='.$request->usuario, file_get_contents($path)
        ));
        //cambiamos el password
        file_put_contents($path, str_replace(
            'MAIL_PASSWORD='.env('MAIL_PASSWORD'), 'MAIL_PASSWORD='.$request->password, file_get_contents($path)
        ));

        return redirect()->back();
    }
}
