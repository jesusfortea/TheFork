<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }


    public function login(Request $request) {
        // 1. Validaciones de Backend 
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Intento de login con Eloquent/Auth
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Obtener el usuario autenticado
            $user = Auth::user();

            // Determinar la URL de redirección según el rol del usuario
            if ($user->rol && $user->rol->nombre === 'Administrador') {
                $redirectUrl = '/admin/dashboard';
            } else {
                // Usuario normal (Cliente)
                $redirectUrl = route('home');
            }

            // Si la petición es AJAX, devolver JSON
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => '¡Bienvenido! Has iniciado sesión correctamente',
                    'redirect' => $redirectUrl
                ], 200);
            }

            // Si no es AJAX, redirigir normalmente
            return redirect()->intended($redirectUrl);
        }

        // Si falla, preparar mensaje de error
        $errorMessage = 'Las credenciales no coinciden con nuestros registros.';

        // Si la petición es AJAX, devolver JSON con error
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 401);
        }

        // Si no es AJAX, volver con errores
        return back()->withErrors([
            'email' => $errorMessage,
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}