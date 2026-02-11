<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestauranteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::controller(RestauranteController::class)->group(function(){

    Route::get('/crear-restaurante', 'index')->name('crear.restaurante');

});


Route::controller(AuthController::class)->group(function(){

    Route::get('/login', 'showLoginForm')->name('login');
    Route::get('/register', 'showRegisterForm')->name('register');

});

