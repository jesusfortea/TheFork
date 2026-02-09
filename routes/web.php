<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Vista del formulario
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Procesar el login
Route::post('/login', [LoginController::class, 'login']);
// Cerrar sesión
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');