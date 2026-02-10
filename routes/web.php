<?php

use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(RestauranteController::class)->group(function(){

    Route::get('/crear-restaurante', 'index')->name('crear.restaurante');

});

// Vista del formulario
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Procesar el login
Route::post('/login', [LoginController::class, 'login']);
// Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');