<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//RUTA PARA INDEX
Route::get('/', function () {
    return view('inicio');
});

//RUTA PARA LOGIN
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
//RUTA PARA REGISTRO
Route::get('registro','Auth\AuthController@getRegister');
Route::post('registro','Auth\AuthController@postRegister');

//RUTA PARA ACCEDER AL ADMIN
Route::get('admin', ['middleware' => ['auth','is_admin'], 'uses' => 'AdminController@index']);
Route::get('admin/usuarios','AdminController@listado');


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::auth();

Route::get('/home', 'HomeController@index');


Route::get('logueado',function(){
   return view('login/logueado');
});


//API USUARIOS
Route::get('api/usuarios','UsuarioController@index');
Route::get('api/usuarios/{id}','UsuarioController@show');
Route::post('api/usuarios','UsuarioController@store');
Route::put('api/usuarios/{id}','UsuarioController@update');
Route::delete('api/usuarios/{id}','UsuarioController@destroy');
Route::options('api/usuarios','UsuarioController@options');

//RESERVAS
Route::get('reservas',['middleware' => 'auth', 'uses' => 'ReservasController@verReservas']);

//API RESERVAS
Route::resource('api/reservas','ReservasController');
Route::get('api/reservas/usuario/{idUsuario}','ReservasController@reserva_users');