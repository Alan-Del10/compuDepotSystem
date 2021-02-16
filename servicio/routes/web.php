<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Sucursal;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    }else{
        return view('auth.login');
    }
});

Route::get('/usuarios/registrar', function(){
    $sucursales = Sucursal::get();
    $tipo_usuarios = DB::table('tipo_usuario')->get();
    return view('auth.register', compact('sucursales', 'tipo_usuarios'));
})->middleware('auth:root,admin')->name('registrarUsuario');

//Auth routes
Auth::routes();

//Ruta de la vista home
Route::group(['guard' => 'admin'], function () {
    Route::get('/home/hola', function(){
        $name = Auth::user();
        return "Hola {$name}";
    })->middleware('auth:vendedor');
});
Route::get('/home','InicioController@index')->name('home')->middleware('auth');

//Ruta de la vista de dashboard
Route::get('/dashboard','InicioController@dashboard')->name('dashboard')->middleware('auth');

//Servicio routes
Route::resource('Servicio', ServicioController::class)->middleware('auth');
Route::get('/servicio/datos','ServicioController@indexDatos')->name('indexDatos')->middleware('auth');
Route::get('/servicio/datos/agregarMarca','ServicioController@agregarMarca')->name('agregarMarca')->middleware('auth');
Route::get('/servicio/datos/agregarModelo','ServicioController@agregarModelo')->name('agregarModelo')->middleware('auth');
Route::get('/servicio/datos/agregarTipo','ServicioController@agregarTipo')->name('agregarTipo')->middleware('auth');
Route::get('/servicio/datos/agregarConcepto','ServicioController@agregarConcepto')->name('agregarConcepto')->middleware('auth');
Route::get('/servicio/datos/agregarEstatus','ServicioController@agregarEstatus')->name('agregarEstatus')->middleware('auth');
Route::get('/servicio/datos/agregarColor','ServicioController@agregarColor')->name('agregarColor')->middleware('auth');
Route::get('/servicio/datos/agregarCompania','ServicioController@agregarCompania')->name('agregarCompania')->middleware('auth');
Route::get('/servicio/datos/desactivarDatos/{id}/{tabla}','ServicioController@desactivarDatos')->name('desactivarDatos')->middleware('auth');
Route::get('/servicio/datos/activarDatos/{id}/{tabla}','ServicioController@activarDatos')->name('activarDatos')->middleware('auth');
Route::post('/servicio/agregarServicio','ServicioController@agregarServicio')->name('agregarServicio')->middleware('auth');
Route::post('/servicio/modificarServicio','ServicioController@modificarServicio')->name('modificarServicio')->middleware('auth');
Route::get('/servicio/{id}/estatus','ServicioController@estatusServicio')->name('estatusServicio')->middleware('auth');
Route::get('/servicio/{id_servicio}/reciboServicio','ServicioController@reciboServicio')->name('reciboServicio')->middleware('auth');

//Usuario routes
Route::resource('Usuario', UsuarioController::class)->middleware('auth:root,admin');
Route::get('/usuario/perfil', 'UsuarioController@showPerfil')->name('perfilUsuario')->middleware('auth:root,admin');
Route::put('/usuario/perfil/update/{id}', 'UsuarioController@updatePerfil')->name('updatePerfil')->middleware('auth:root,admin');

//Cliente routes
Route::resource('Cliente', ClienteController::class)->middleware('auth:root,servicio_cliente,admin,sub_admin');

//Sucursal routes
Route::resource('Sucursal', SucursalController::class)->middleware('auth:root,admin,sub_admin');

//Articulo routes
Route::resource('Articulo', ArticuloController::class)->middleware('auth');

//Tipo Inventario routes
Route::resource('TipoInventario', TipoInventarioController::class)->middleware('auth:root,admin,sub_admin,servicio_cliente,vendedor');

//Inventario routes
Route::resource('Inventario', InventarioController::class)->middleware('auth:root,admin,sub_admin,vendedor,servicio_clinte');
Route::get('/inventario/verificarUPC', 'InventarioController@verificarUPC')->name('verificarUPC')->middleware('auth');
Route::get('/inventario/agregarCapacidad','InventarioController@agregarCapacidad')->name('agregarCapacidad')->middleware('auth');


//Capacidad routes
Route::resource('Capacidad', CapacidadController::class)->middleware('auth');

//Categoria routes
Route::resource('Categoria', CategoriaController::class)->middleware('auth');

//Sucursal routes
Route::resource('Sucursal', SucursalController::class)->middleware('auth');
//Route::get('/home', 'HomeController@index')->name('home');

//Venta routes
Route::resource('Venta', VentaController::class)->middleware('auth:root,admin,sub,admin,vendedor,servicio_cliente');

//Permisos routes
Route::resource('Permisos', PermisosController::class)->middleware('auth');
Route::get('/permisos/listado', 'PermisosController@index')->middleware('auth');

//Configuracion routes
Route::resource('Configuracion', ConfiguracionController::class)->middleware('auth:root,admin');
Route::post('/configuracionNombre','ConfiguracionController@cambiarNombreAplicacion')->name('cambiarNombreAplicacion')->middleware('auth:root,admin');
Route::post('/configuracionLogo','ConfiguracionController@cambiarLogoAplicacion')->name('cambiarLogoAplicacion')->middleware('auth:root,admin');
Route::post('/configuracionCorreo','ConfiguracionController@cambiarSMTPAplicacion')->name('cambiarSMTPAplicacion')->middleware('auth:root,admin');

//Platillas routes
Route::get('/plantilla/general', function(){
    return view('Plantillas.plantillaGeneral');
})->middleware('auth')->name('plantillaGeneral');
Route::get('/plantilla/agregarEditarConDetalle', function(){
    return view('Plantillas.agregarEditarConDetalle');
})->middleware('auth')->name('agregarEditarConDetalle');
Route::get('/plantilla/agregarEditarSinDetalle', function(){
    return view('Plantillas.agregarEditarSinDetalle');
})->middleware('auth')->name('agregarEditarSinDetalle');


$routeList = Route::getRoutes();

    //dd($routeList);
