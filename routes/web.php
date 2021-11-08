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


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','MailController@getMail');

Route::get('enviarCorreo', 'MailController@enviarCorreo');
//--------------------------------
//Rutas  del modulo de inventario
//--------------------------------

Route::resource('proveedor', 'proveedoresController');
Route::resource('producto', 'MateriaController');

Route::get('MaterialeFitro', 'MateriaController@filtroMaterial');
Route::get('MaterialFitroNombre/{nombre}', 'MateriaController@filtroMaterialNombre');
Route::get('MaterialFitroInteligente/{nombre}/{marca}', 'MateriaController@filtroMaterialEconomico');





Route::resource('estados/proyecto', 'estadoProyectoController');









Route::resource('proyectos', 'proyectoController');




//-------------------------------
//inventario inmueble
//-------------------------------


Route::get('sendbasicemail','MailController@basic_email');
Route::get('sendhtmlemail','MailController@html_email');
Route::get('attachment_email','MailController@attachment_email');


Route::resource('inmueble', 'InmuebleController');
Route::resource('tipo_inmueble', 'tipo_inmuebleController');
Route::post('filtroInmueble/{id}', 'InmuebleController@filtroInmuebles');
Route::post('filtroInmueblesTipo/{id}','InmuebleController@filtroInmueblesTipo');

Route::resource('torre', 'TorreController');

Route::post('inmueblesDisponibles/{id}','InmuebleController@inmueblesDisponibles');

//--------------------------------------------------------------------

//Rutas  del modulo de oportunidad de venta
//--------------------------------------------------------------------


// Rutas del controlador de oportunidad de venta

Route::resource('oportunidad_venta', 'Oportunidad_ventaController');
Route::resource('estado/oportunidad', 'Estado_OpController');



// Rutas del controlador de cliente
Route::resource('cliente', 'ClientesController');

Route::post('mostrarInformacion','Oportunidad_ventaController@mostrarInformacion');

// rutas del controlador de tareas
Route::resource('tareas', 'TareasController');
Route::resource('estado/tarea', 'Estado_tareaController');


// Rutas del controlador nivel de estudios

Route::resource('nivelEstudios', 'nivelEstudiosController');


//--------------------------------------------------------------------
//Rutas  del modulo de cotizaciones
//--------------------------------------------------------------------


//--------------------------------------------------------------------
//Rutas  del controlador de ordenes de compra
//--------------------------------------------------------------------


Route::resource('ordenesCompra', 'ordenesCompraController');
Route::post('replicarData', 'ordenesCompraController@replicarData');

Route::get('generateReferencia', 'ordenesCompraController@generateReference');
Route::get('FiltroGerencia', 'ordenesCompraController@FiltroGerente');
Route::put('revisarGerente/{id}', 'ordenesCompraController@revisionGerente');




//--------------------------------------------------------------------
//Rutas  del de cotizaciones
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

// Ciudades



Route::resource('ciudades', 'ciudad_departamentoController');

Route::get('filtroCiudad/{id}','ciudad_departamentoController@filtroCiudad');
Route::post('FiltroDisponibles','Oportunidad_ventaController@FiltroDisponibles');
Route::post('filterProyectoId/{id}','TorreController@filterProyectoId');
