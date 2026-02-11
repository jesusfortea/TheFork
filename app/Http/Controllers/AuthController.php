<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function showLoginForm(){

        return view('auth.login');
    }

    public function showRegisterForm(){

        return view('auth.register');
    }

    public function register(Request $request){
        
        // Validación de datos
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted']
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'terms.accepted' => 'Debes aceptar los términos y condiciones'
        ]);

        // Buscar el rol de Cliente
        $rolCliente = Rol::where('nombre', 'Cliente')->first();

        // Crear el usuario
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol_id' => $rolCliente->id
        ]);

        // Autenticar automáticamente al usuario
        Auth::login($user);

        // Redirigir al home
        return redirect()->route('home')->with('success', '¡Cuenta creada exitosamente! Bienvenido a TheFork.');
    }

}
