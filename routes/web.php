<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(RestauranteController::class)->group(function(){

    Route::get('/crear-restaurante', 'index')->name('crear.restaurante');
    Route::get('/restaurantes', 'show')->name('show.restaurante');
    Route::post('/solicitud-restaurante', 'solicitud')->name('enviar.solicitud');

});

// Rutas de autenticación con LoginController
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de autenticación con AuthController
Route::controller(AuthController::class)->group(function(){
    Route::get('/register', 'showRegisterForm')->name('register');
});
