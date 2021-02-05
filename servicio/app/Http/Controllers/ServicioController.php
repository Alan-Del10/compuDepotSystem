<?php

namespace App\Http\Controllers;

use App\Servicio;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = DB::table('servicio')->leftJoin('cliente', 'cliente.id_cliente', 'servicio.id_cliente')->orderby('id_servicio','asc')->get();

        return view('Servicio.servicio',compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companias = DB::table('compania')->orderby('descripcion','asc')->where('estatus',1)->get();
        $colores = DB::table('color')->orderby('descripcion','asc')->where('estatus',1)->get();
        $tipos = DB::table('tipo_servicio')->orderby('descripcion','asc')->where('estatus',1)->get();
        $conceptos = DB::table('concepto_servicio')->orderby('descripcion','asc')->where('estatus',1)->get();
        $estatus = DB::table('estatus')->orderby('descripcion','asc')->where('estatus',1)->get();
        $marcas = DB::table('marca')->orderby('descripcion','asc')->where('estatus',1)->get();
        $modelos = DB::table('modelo')->orderby('descripcion','asc')->where('estatus',1)->get();
        $formasPagos = DB::table('forma_de_pago')->orderby('id_forma_de_pago','asc')->where('estatus',1)->get();
        $clientes = DB::table('cliente')->get();
        return view('Servicio.agregarServicio',compact('companias','colores','tipos','conceptos','estatus','marcas','modelos','formasPagos','clientes'));
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
        return view('Servicio.detalleDeServicio');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $servicio = DB::table('servicio')->where('id_servicio',$id)->get();
        $companias = DB::table('compania')->orderby('descripcion','asc')->where('estatus',1)->get();
        $colores = DB::table('color')->orderby('descripcion','asc')->where('estatus',1)->get();
        $tipos = DB::table('tipo_servicio')->orderby('descripcion','asc')->where('estatus',1)->get();
        $conceptos = DB::table('concepto_servicio')->orderby('descripcion','asc')->where('estatus',1)->get();
        $estatus = DB::table('estatus')->orderby('descripcion','asc')->where('estatus',1)->get();
        $marcas = DB::table('marca')->orderby('descripcion','asc')->where('estatus',1)->get();
        $modelos = DB::table('modelo')->orderby('descripcion','asc')->where('estatus',1)->get();
        $formasPagos = DB::table('forma_de_pago')->orderby('id_forma_de_pago','asc')->where('estatus',1)->get();
        $pagos = DB::table('servicio_pago')->where('id_servicio',$id)->get();
        return view('Servicio.modificarServicio',compact('companias','servicio','colores','tipos','conceptos','estatus','marcas','modelos','formasPagos' ,'pagos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function indexDatos()
    {
        $companias = DB::table('compania')->orderby('descripcion','asc')->get();
        $colores = DB::table('color')->orderby('color','asc')->get();
        $tipos = DB::table('tipo_servicio')->orderby('descripcion','asc')->get();
        $conceptos = DB::table('concepto_servicio')->orderby('descripcion','asc')->get();
        $estatus = DB::table('estatus')->orderby('descripcion','asc')->get();
        $marcas = DB::table('marca')->orderby('marca','asc')->get();
        $modelos = DB::table('modelo')->orderby('modelo','asc')->get();
        $formasPagos = DB::table('forma_de_pago')->orderby('id_forma_de_pago','asc')->get();
        return view('Servicio.datosServicio',compact('companias','colores','tipos','conceptos','estatus','marcas','modelos','formasPagos'));
    }

    public function agregarMarca(Request $request)
    {
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'marcaDescripcion' => 'required|max:50',
                'categoriaOption' => 'required'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                $categoria = DB::table('categoria')->where('categoria', $request->categoriaOption)->get();
                if(count($categoria) == 0){
                    return redirect()->back()->withErrors('error', 'No su pudo agregar la marca!');
                }

                DB::table('marca')->insert(
                    ['marca' => strtoupper($request->marcaDescripcion),
                    'id_categoria' => $categoria[0]->id_categoria]
                );

                if($request->ajax()){
                    $id = DB::getPdo()->lastInsertId();
                    $marca = DB::table('marca')->where('id_marca', $id)->get();
                    return $marca;
                }else{
                    return redirect()->back()->with('success', 'Se agregó correctamente la marca.');
                }
            }

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }

    }

    public function agregarModelo(Request $request)
    {

        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'modeloDescripcion' => 'required|max:50',
                'marcaOption' => 'required'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                $marca = DB::table('marca')->where('marca', $request->marcaOption)->get();
                if(count($marca) == 0){
                    return redirect()->back()->withErrors('error', 'No su pudo agregar el modelo!');
                }
                DB::table('modelo')->insert(
                    ['modelo' => strtoupper($request->modeloDescripcion),'id_marca' => $marca[0]->marca, 'estatus' => true]
                );

                if($request->ajax()){
                    $id = DB::getPdo()->lastInsertId();
                    $modelo = DB::table('modelo')->where('id_modelo', $id)->get();
                    return $modelo;
                }else{
                    return redirect()->back()->with('success', 'Se agregó correctamente el modelo.');
                }
            }

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }

    }

    public function agregarColor(Request $request)
    {
        try {
            //Validamos los campos de la base de datos, para no aceptar información erronea
            $validator = Validator::make($request->all(), [
                'colorDescripcion' => 'required|max:50'
            ]);

            //Si encuentra datos erroneos los regresa con un mensaje de error
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }else{
                DB::table('color')->insert(
                    ['color' => strtoupper($request->colorDescripcion),
                    'estatus' => true]
                );
                if($request->ajax()){
                    $id = DB::getPdo()->lastInsertId();
                    $color = DB::table('color')->where('id_color', $id)->get();
                    return $color;
                }else{
                    return redirect()->back()->with('success', 'Se agregó correctamente el color.');
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }

    }

    public function agregarCompania(Request $request)
    {
        $select = DB::table('compania')->select('descripcion')->where('descripcion',strtoupper($request->companiaDescripcion))->get();
        if(count($select) > 0){
            return 2;
        }else{
            $res = DB::table('compania')->insert(
                ['descripcion' => strtoupper($request->companiaDescripcion)]
            );

            if($res == 1){
                return 1;
            }else{
                return $res;
            }

        }

    }

    public function agregarEstatus(Request $request)
    {
        $select = DB::table('estatus')->select('descripcion')->where('descripcion',strtoupper($request->estatusDescripcion))->get();
        if(count($select) > 0){
            return 2;
        }else{
            $res = DB::table('estatus')->insert(
                ['descripcion' => strtoupper($request->estatusDescripcion)]
            );

            if($res == 1){
                return 1;
            }else{
                return $res;
            }

        }

    }

    public function agregarConcepto(Request $request)
    {
        $select = DB::table('concepto_servicio')->select('descripcion')->where('descripcion',strtoupper($request->conceptoDescripcion))->get();
        if(count($select) > 0){
            return 2;
        }else{
            $res = DB::table('concepto_servicio')->insert(
                ['descripcion' => strtoupper($request->conceptoDescripcion)]
            );

            if($res == 1){
                return 1;
            }else{
                return $res;
            }

        }

    }

    public function agregarTipo(Request $request)
    {
        $select = DB::table('tipo_servicio')->select('descripcion')->where('descripcion',strtoupper($request->tipoDescripcion))->get();
        if(count($select) > 0){
            return 2;
        }else{
            $res = DB::table('tipo_servicio')->insert(
                ['descripcion' => strtoupper($request->tipoDescripcion)]
            );

            if($res == 1){
                return 1;
            }else{
                return $res;
            }

        }

    }

    public function desactivarDatos($id,$tabla)
    {

        $res = DB::table($tabla)
            ->where('id_'.$tabla,'=',$id)
            ->update(['estatus' => 0]);

        return Redirect::back();


    }

    public function activarDatos($id,$tabla)
    {

        $res = DB::table($tabla)
            ->where('id_'.$tabla,'=',$id)
            ->update(['estatus' => 1]);

        return Redirect::back();


    }




    public function agregarServicio(Request $request)
    {
        $data = json_decode ($request->array,true);

        $maximo = DB::select('select max(substr(id_servicio,2,6)) as max from servicio');

        $idServicio = $maximo[0]->max;

        if($maximo[0]->max == null){
            $idServicio = '000001';
        }else{
            $numeroServicio = (int)$idServicio + 1;
            $idServicio =  self::llenarCero($numeroServicio, 6);
        }



        $res = DB::table('servicio')->insert(
            [
                'id_servicio' => 'C'.$idServicio,
                'id_cliente' => $data[0]['cliente'],
                'id_estatus' => strtoupper($data[0]['estatus']),
                'lugar' => strtoupper($data[0]['lugar']),
                'fecha_servicio' => date('Y-m-d'),
                'id_concepto_servicio' => strtoupper($data[0]['concepto']),
                'id_tipo_servicio' => strtoupper($data[0]['tipo']),
                'clase' => strtoupper($data[0]['clase']),
                'id_color' => strtoupper($data[0]['color']),
                'id_compania' => strtoupper($data[0]['compania']),
                'codigo_acceso' => strtoupper($data[0]['codigoAcceso']),
                'mojado' => strtoupper($data[0]['mojado']),
                'riesgo' => strtoupper($data[0]['riesgo']),
                'respaldo' => strtoupper($data[0]['respaldo']),
                'notas_tecnicas' => strtoupper($data[0]['notasTecnicas']),
                'id_marca' => strtoupper($data[0]['marca']),
                'id_modelo' => strtoupper($data[0]['modelo']),
                'modelo_tecnico' => strtoupper($data[0]['modeloTecnico']),
                'monto' => strtoupper($data[0]['monto']),
                'no_serie' => strtoupper($data[0]['serie']),
                'IMEI' => strtoupper($data[0]['IMEI']),
                'notas_extra' => strtoupper($data[0]['notas'])
            ]
        );


        for($i = 0; $i < count($data[1]); $i++){

            $res2 = DB::table('servicio_pago')->insert(
                [
                    'cantidad' => $data[1][$i]['cantidad'],
                    'nota' => strtoupper($data[1][$i]['nota']),
                    'fecha' => date('Y-m-d H:i:s'),
                    'id_servicio' => 'C'.$idServicio,
                    'id_forma_de_pago' => strtoupper($data[1][$i]['formaPago'])
                ]
            );

        }
        /*$res3 = DB::table('cliente')->insert(
            [
                'nombre_completo' => strtoupper($data[0]['nombreCompleto']),
                'telefono' => strtoupper($data[0]['telefono']),
                'whatsapp' => strtoupper($data[0]['whatsapp'])
            ]
        );*/

        $servicio = Servicio::where('id_servicio', 'C'.$idServicio)
        ->select(DB::raw('CONVERT(servicio.id_servicio, CHAR) as id_servicio, estatus.descripcion as estatus, servicio.fecha_servicio,
        cliente.nombre_completo, cliente.telefono, tipo_servicio.descripcion as tipo_servicio, marca.descripcion as marca, servicio.modelo_tecnico as modelo,
        servicio.reparacion_anterior, servicio.codigo_acceso, servicio.monto, concepto_servicio.descripcion as concepto_servicio,
        servicio.notas_extra, servicio.respaldo, servicio.no_serie, cliente.correo'))
        ->leftJoin('estatus', 'estatus.id_estatus', '=', 'servicio.id_estatus')
        ->leftJoin('tipo_servicio', 'tipo_servicio.id_tipo_servicio', '=', 'servicio.id_tipo_servicio')
        ->leftJoin('marca', 'marca.id_marca', '=', 'servicio.id_marca')
        ->leftJoin('modelo', 'modelo.id_modelo', '=', 'servicio.id_modelo')
        ->leftJoin('concepto_servicio', 'concepto_servicio.id_concepto_servicio', '=', 'servicio.id_concepto_servicio')
        ->leftJoin('cliente', 'cliente.id_cliente', '=', 'servicio.id_cliente')->get();

        $dataTicket = [
            'barcode' => 'C'.$idServicio,
            'barcode_2' => $servicio[0]['no_serie'],
            'cliente' => $servicio[0]['nombre_completo'],
            'telefono' => $servicio[0]['telefono'],
            'fecha' => $servicio[0]['fecha_servicio'],
            'marca' => $servicio[0]['marca'],
            'modelo' => $servicio[0]['modelo'],
            'estatus' => $servicio[0]['estatus'],
            'tipo_servicio' => $servicio[0]['tipo_servicio'],
            'respaldo'=> $servicio[0]['respaldo'],
            'reparacion' => $servicio[0]['reparacion_anterior'],
            'codigo_acceso' => $servicio[0]['codigo_acceso'],
            'correo' => $servicio[0]['correo'],
            'monto' => $servicio[0]['monto'],
            'concepto_servicio' => $servicio[0]['concepto_servicio'],
            'notas' => $servicio[0]['notas_extra']
        ];

        if($res == 1){
            $ticket = PDF::loadView('Servicio.Recibo.reciboServicioPDF', $dataTicket)->setPaper('b8', 'portrait')->setWarnings(false)->save(storage_path('app\\public\\ticket\\servicio\\').'ticketServicio_C'.$idServicio.'.pdf');
            return json_encode(['respuesta'=>1, 'id_servicio'=> 'C'.$idServicio, 'ticket'=>'ticketServicio_C'.$idServicio.'.pdf']);
        }else{
            return $res;
        }


        //return Redirect::back();


    }

    public function llenarCero ($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }


    public function modificarServicio(Request $request)
    {
        $data = json_decode ($request->array,true);


        $res = DB::table('servicio')->where('id_servicio','=',$data[0]['idServicio'])->update(
            [
                'telefono' => strtoupper($data[0]['telefono']),
                'whatsapp' => strtoupper($data[0]['whatsapp']),
                'id_estatus' => strtoupper($data[0]['estatus']),
                'lugar' => strtoupper($data[0]['lugar']),
                'id_concepto_servicio' => strtoupper($data[0]['concepto']),
                'id_tipo_servicio' => strtoupper($data[0]['tipo']),
                'clase' => strtoupper($data[0]['clase']),
                'codigo_acceso' => strtoupper($data[0]['codigoAcceso']),
                'mojado' => strtoupper($data[0]['mojado']),
                'riesgo' => strtoupper($data[0]['riesgo']),
                'notas_tecnicas' => strtoupper($data[0]['notasTecnicas']),
                'monto' => strtoupper($data[0]['monto']),
                'notas_extra' => strtoupper($data[0]['notas'])
            ]
        );


        for($i = 0; $i < count($data[1]); $i++){

            $res2 = DB::table('servicio_pago')->insert(
                [
                    'cantidad' => $data[1][$i]['cantidad'],
                    'nota' => strtoupper($data[1][$i]['nota']),
                    'fecha' => date('Y-m-d H:i:s'),
                    'id_servicio' => 'C'.$idServicio,
                    'id_forma_de_pago' => strtoupper($data[1][$i]['formaPago'])
                ]
            );

        }

        if($res == 1){
            return 1;
        }else{
            return $res;
        }


        //return Redirect::back();


    }

    public function estatusServicio(Request $request)
    {
        $data = json_decode ($request->array,true);
        $id = $request->id;
        $servicios = Servicio::where('id_servicio', $request->id)
        ->select(DB::raw('CONVERT(servicio.id_servicio, CHAR) as id_servicio, estatus.descripcion as estatus, servicio.fecha_servicio, cliente.nombre_completo, cliente.telefono, tipo_servicio.descripcion as tipo_servicio, marca.descripcion as marca, modelo.descripcion as modelo'))
        ->leftJoin('estatus', 'estatus.id_estatus', '=', 'servicio.id_estatus')
        ->leftJoin('tipo_servicio', 'tipo_servicio.id_tipo_servicio', '=', 'servicio.id_tipo_servicio')
        ->leftJoin('marca', 'marca.id_marca', '=', 'servicio.id_marca')
        ->leftJoin('modelo', 'modelo.id_modelo', '=', 'servicio.id_modelo')
        ->leftJoin('cliente', 'cliente.id_cliente', '=', 'servicio.id_cliente')->get();
        $seguimientos = DB::table('bitacora_servicio')->where('id_servicio', $request->id)->get();
        //dd($servicios);
        return view('Servicio.estatusServicio',compact('servicios', 'seguimientos', 'id'));
    }

    public function reciboServicio(Request $request){

        $servicio = Servicio::where('id_servicio', $request->id_servicio)
        ->select(DB::raw('CONVERT(servicio.id_servicio, CHAR) as id_servicio, estatus.descripcion as estatus, servicio.fecha_servicio,
        servicio.nombre_completo, servicio.telefono, tipo_servicio.descripcion as tipo_servicio, marca.descripcion as marca, modelo.descripcion as modelo,
        servicio.reparacion_anterior, servicio.codigo_acceso, servicio.monto, concepto_servicio.descripcion as concepto_servicio,
        servicio.notas_extra'))
        ->leftJoin('estatus', 'estatus.id_estatus', '=', 'servicio.id_estatus')
        ->leftJoin('tipo_servicio', 'tipo_servicio.id_tipo_servicio', '=', 'servicio.id_tipo_servicio')
        ->leftJoin('marca', 'marca.id_marca', '=', 'servicio.id_marca')
        ->leftJoin('modelo', 'modelo.id_modelo', '=', 'servicio.id_modelo')
        ->leftJoin('concepto_servicio', 'concepto_servicio.id_concepto_servicio', '=', 'servicio.id_concepto_servicio')->get();
        $data = [
            'barcode' => $request->id_servicio,
            'barcode_2' => 'GTPS110E',
            'cliente' => $servicio[0]['nombre_completo'],
            'telefono' => $servicio[0]['telefono'],
            'fecha' => $servicio[0]['fecha_servicio'],
            'marca' => $servicio[0]['marca'],
            'modelo' => $servicio[0]['modelo'],
            'estatus' => $servicio[0]['estatus'],
            'tipo_servicio' => $servicio[0]['tipo_servicio'],
            'respaldo'=> $servicio[0]['respaldo'],
            'reparacion' => $servicio[0]['reparacion_anterior'],
            'codigo_acceso' => $servicio[0]['codigo_acceso'],
            'correo' => 'ejemplo',
            'monto' => $servicio[0]['monto'],
            'concepto_servicio' => $servicio[0]['concepto_servicio'],
            'notas' => $servicio[0]['notas_extra']
        ];

    }

}
