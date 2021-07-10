<?php

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

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\ApiAuthMiddleware;
use GuzzleHttp\Middleware;


Route::get('/', function () {
    return view('welcome');
});







//--------------------------------
//Rutas  del modulo de inventario
//--------------------------------

Route::resource('proveedor', 'proveedoresController');
Route::resource('producto', 'productoController');


Route::resource('estados/proyecto', 'estadoProyectoController');
Route::resource('proyectos', 'proyectoController');

Route::resource('obras', 'ObrasController');




//--------------------------------------------------------------------

//Rutas  del modulo de oportunidad de venta
//--------------------------------------------------------------------


// Rutas del controlador de oportunidad de venta

Route::resource('oportunidad_venta', 'Oportunidad_ventaController');
Route::resource('estado/oportunidad', 'Estado_OpController');

// Rutas del controlador de cliente
Route::resource('cliente', 'ClientesController');

// rutas del controlador de tareas
Route::resource('tareas', 'TareasController');
Route::resource('estado/tarea', 'Estado_tareaController');



//--------------------------------------------------------------------
//Rutas  del modulo de cotizaciones
//--------------------------------------------------------------------



Route::resource('cotizaciones', 'cotizacionesController');
Route::resource('fechaPagos/Cotizaciones', 'fechaPagosCotizacionController');
Route::resource('estados/Cotizacion', 'estadoCotizacionController');





// Route::resource('estados/FechaPago', 'estadoFechaPagosController');

//--------------------------------------------------------------------
// Rutas de las configuraciones del aplicativo
//---------------------------------------------------------------------

Route::resource('medida', 'MedidaController');
Route::resource('category', 'CategoriaController');

Route::resource('dtIdentificacion', 'TidentificacionController');

//Routas de perfiles

Route::post('perfil/agregar', 'PerfilController@addPerfil');
Route::get('perfil/detail/{id}', 'PerfilController@getPerfil');
Route::get('perfil', 'PerfilController@index');

//Routas del controlador de usuario

Route::get('usuarios', 'UserController@index');
Route::post('usuario/registro', 'UserController@register');
Route::post('usuario/login', 'UserController@login');
Route::put('usuario/update/{id}', 'UserController@update');
Route::post('usuario/upload', 'UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('usuario/avatar/{filename}', 'UserController@getImage');
Route::get('usuario/detail/{id}', 'UserController@detail');
Route::delete('users/{id}','UserController@delete');