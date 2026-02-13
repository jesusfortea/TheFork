<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;


Route::controller(RestauranteController::class)->group(function(){

    Route::get('/crear-restaurante', 'index')->name('crear.restaurante');
    Route::get('/restaurantes', 'show')->name('show.restaurante');
    Route::post('/solicitud-restaurante', 'solicitud')->name('enviar.solicitud');
    Route::get('/', 'home')->name('home');

});

// Vista del formulario
Route::controller(LoginController::class)->group(function(){

    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::post('/logout', 'logout')->name('logout');

});

// Rutas de autenticación con AuthController
Route::controller(AuthController::class)->group(function(){
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register')->name('register.post');
});

// Ruta protegida - Dashboard 
// middleware actua como un filtro que verifica si el usuario esta logueado
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Ruta protegida - Dashboard de Administrador
// Solo accesible para usuarios con rol "Administrador"
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware('auth')
    ->name('admin.dashboard');

// Rutas de gestión del admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function() {
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/usuarios/{id}/editar', [AdminController::class, 'editarUsuario'])->name('usuarios.editar');
    Route::put('/usuarios/{id}', [AdminController::class, 'actualizarUsuario'])->name('usuarios.actualizar');
    Route::delete('/usuarios/{id}', [AdminController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
    
    Route::get('/restaurantes', [AdminController::class, 'restaurantes'])->name('restaurantes');
    
    Route::get('/reservas', [AdminController::class, 'reservas'])->name('reservas');
    Route::get('/reservas/{id}/editar', [AdminController::class, 'editarReserva'])->name('reservas.editar');
    Route::put('/reservas/{id}', [AdminController::class, 'actualizarReserva'])->name('reservas.actualizar');
    Route::delete('/reservas/{id}', [AdminController::class, 'eliminarReserva'])->name('reservas.eliminar');
    
    Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
    Route::post('/roles', [AdminController::class, 'rolstore'])->name('roles.store');
    Route::put('/roles/{rol}', [AdminController::class, 'rolupdate'])->name('roles.update');
    Route::delete('/roles/{rol}', [AdminController::class, 'roldestroy'])->name('roles.destroy');
});

