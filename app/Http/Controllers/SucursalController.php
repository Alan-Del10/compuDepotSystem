<?php

namespace App\Http\Controllers;

use App\Sucursal;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Image;
use Illuminate\Support\Facades\Storage;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales = Sucursal::orderby('id_sucursal','asc')->get();
        return view('Sucursal.sucursal', compact('sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Sucursal.agregarSucursal');
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
                'sucursal' => 'required|max:200',
                'local' => 'nullable|max:45',
                'direccion' => 'nullable|max:200',
                'politicas' => 'nullable|max:9999',
                'tickets' => 'nullable',
                'etiquetas' => 'nullable'
            ]);
            $fileName = "";
            if ($request->has('imagenSucursal')) {
                $image      = $request->file('imagenSucursal');
                $fileName   = $request->sucursal.'.'. $image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $extension = $image->getClientOriginalExtension();
                //dd($img);
                $img->resize(120, 120, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point

                if(Storage::disk('local')->exists('public/sucursales/'.$request->sucursal.'.'.$extension)) {
                    Storage::disk('local')->delete('public/sucursales/'.$request->sucursal.'.'.$extension);
                }
                Storage::disk('local')->put('public/sucursales'.'/'.$fileName, $img, 'public');
            }
            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                Sucursal::insert([
                    'sucursal' => $request->sucursal,
                    'local' => $request->local,
                    'direccion' => $request->direccion,
                    'logo' => $fileName,
                    'politicas' => $request->politicas,
                    'tickets' => $request->tickets,
                    'etiquetas' => $request->etiquetas
                ]);
                return redirect()->back()->with('message', 'Se agregó correctamente la sucursal.');
            }

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function show(Sucursal $sucursal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sucursal = Sucursal::find($id);
        return view('Sucursal.modificarSucursal', compact('sucursal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
        //Si surge un error lo controlamos con el try/catch
        try {
            $data = $request->except('_method','_token');
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($data, [
                'sucursal' => 'required|max:200',
                'local' => 'nullable|max:45',
                'direccion' => 'nullable|max:200',
                'politicas' => 'nullable|max:9999',
                'tickets' => 'nullable',
                'etiquetas' => 'nullable'
            ]);
            $fileName = "";
            if ($request->has('imagenSucursal')) {

                $image      = $request->file('imagenSucursal');
                $fileName   = $request->sucursal.'.'. $image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $extension = $image->getClientOriginalExtension();

                $img->resize(120, 120, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point
                if(Storage::disk('local')->exists('public/sucursales/'.$request->sucursal.'.'.$extension)) {
                    Storage::disk('local')->delete('public/sucursales/'.$request->sucursal.'.'.$extension);
                }
                Storage::disk('local')->put('public/sucursales'.'/'.$fileName, $img, 'public');
            }else{

                $verificarImagen = DB::table('sucursal')->where('sucursal', $request->sucursal)->where('logo', '!=', null)->get();

                if(count($verificarImagen) > 0 || $verificarImagen == "") {
                    $fileName = $verificarImagen[0]->logo;
                }
            }
            $sucursal = Sucursal::find($id);
            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                //Validamos que se haya modificado la información y regresamos un mensaje sobre el estado
                $json_actualizar = [
                    'sucursal' => $request->sucursal,
                    'local' => $request->local,
                    'direccion' => $request->direccion,
                    'logo' => $fileName,
                    'politicas' => $request->politicas,
                    'tickets' => $request->tickets,
                    'etiquetas' => $request->etiquetas
                ];

                if($sucursal->update($json_actualizar)){
                    return redirect()->back()->with('message', 'Se modificó correctamente la sucursal.');
                }else{
                    return redirect()->back()->withErrors('error', 'Algo pasó al intenar modificar los datos');
                }

            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sucursal  $sucursal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sucursal $sucursal)
    {
        //
    }
}
