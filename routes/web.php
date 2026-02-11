<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;


Route::controller(RestauranteController::class)->group(function(){

    Route::get('/crear-restaurante', 'index')->name('crear.restaurante');
    Route::get('/restaurantes', 'show')->name('show.restaurante');
    Route::post('/solicitud-restaurante', 'solicitud')->name('enviar.solicitud');

});

// Vista del formulario
Route::controller(LoginController::class)->group(function(){

    Route::get('/', 'showLoginForm')->name('login');
    Route::post('/', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');

});