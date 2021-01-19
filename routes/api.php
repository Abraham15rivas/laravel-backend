<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    // CRUD - Clientes (Huéspedes)
    Route::group(['prefix' => 'guests'], function () {
        Route::get('/', 'GuestController@index');
        Route::post('/store', 'GuestController@store');
        Route::get('/{id?}', 'GuestController@show');
        Route::put('/update/{id?}', 'GuestController@update');
        Route::delete('/{id?}', 'GuestController@destroy');
    });
    // Rutas de reservaciones de habitaciones (Admin)
    Route::group(['prefix' => 'reservations'], function () {
        Route::get('/', 'ReservationController@index');
        Route::post('/store', 'ReservationController@store');
        Route::get('/{id?}', 'ReservationController@show');
        Route::put('/update/{id?}', 'ReservationController@update');
        Route::delete('/{id?}', 'ReservationController@destroy');
    });
});
// Rutas del cliente o huésped
Route::group([
    'prefix' => 'client',
    'namespace' => 'Guest',
    'middleware' => ['auth:api', 'guest_client']
], function () {
    // CRUD - Clientes (Huéspedes)
    Route::group(['prefix' => 'guests'], function () {
        Route::post('/store', 'GuestController@store');
        Route::get('/{id?}', 'GuestController@show');
        Route::put('/update/{id?}', 'GuestController@update');
    });
    // Rutas de reservaciones de habitaciones (Client)
    Route::group(['prefix' => 'reservations'], function () {
        Route::get('/', 'ReservationController@index');
        Route::post('/store', 'ReservationController@store');
        Route::get('/{id?}', 'ReservationController@show');
        Route::put('/update/{id?}', 'ReservationController@update');
        Route::delete('/{id?}', 'ReservationController@destroy');
    });
    // Habitaciones disponibles
    Route::group(['prefix' => 'rooms'], function () {
        Route::get('/', 'RoomController@index');
    });
});