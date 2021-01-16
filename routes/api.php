<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Autenticación
Route::group([
    'prefix' => 'auth',
    'namespace' => 'API'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');
    // Rutas usuarios logeados
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', function (Request $request) {
            return $request->user();
        });
    });
});
// Rutas del administrador
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth:api', 'admin']
], function () {
    // CRUD - hoteles
    Route::group(['prefix' => 'hotels'], function () {
        Route::get('/', 'HotelController@index');
        Route::post('/store', 'HotelController@store');
        Route::get('/{id?}', 'HotelController@show');
        Route::put('/update/{id?}', 'HotelController@update');
        Route::delete('/{id?}', 'HotelController@destroy');
    });
    // CRUD - tipo de habitaciones
    Route::group(['prefix' => 'room-types'], function () {
        Route::get('/', 'RoomTypeController@index');
        Route::post('/store', 'RoomTypeController@store');
        Route::get('/{id?}', 'RoomTypeController@show');
        Route::put('/update/{id?}', 'RoomTypeController@update');
        Route::delete('/{id?}', 'RoomTypeController@destroy');
    });
    // CRUD - habitaciones
    Route::group(['prefix' => 'rooms'], function () {
        Route::get('/', 'RoomController@index');
        Route::post('/store', 'RoomController@store');
        Route::get('/{id?}', 'RoomController@show');
        Route::put('/update/{id?}', 'RoomController@update');
        Route::delete('/{id?}', 'RoomController@destroy');
    });
});
// Rutas compartidas
Route::group([
    'prefix' => 'general',
    'namespace' => 'General',
    'middleware' => ['auth:api']
], function () {
    // CRUD - Clientes (Huéspedes)
    Route::group(['prefix' => 'guests'], function () {
        Route::get('/', 'GuestController@index');
        Route::post('/store', 'GuestController@store');
        Route::get('/{id?}', 'GuestController@show');
        Route::put('/update/{id?}', 'GuestController@update');
        Route::delete('/{id?}', 'GuestController@destroy');
    });
});
// Rutas del cliente o huésped
Route::group([
    'prefix' => 'guest',
    'namespace' => 'Guest',
    'middleware' => ['auth:api']
], function () {
    // Rutas de reservaciones cliente
    Route::group(['prefix' => 'reservations'], function () {
        Route::get('/', 'ReservationController@index');
        Route::post('/store', 'ReservationController@store');
        Route::get('/{id?}', 'ReservationController@show');
        Route::put('/update/{id?}', 'ReservationController@update');
        Route::delete('/{id?}', 'ReservationController@destroy');
    });
});

