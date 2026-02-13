<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurante;
use App\Models\Reserva;
use App\Models\Rol;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Verificar permisos de administrador
     */
    private function verificarAdmin()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión');
        }
        
        if (!auth()->user()->rol || auth()->user()->rol->nombre !== 'Administrador') {
            abort(403, 'No tienes permiso para acceder a esta página');
        }
        
        return null;
    }

    /**
     * Mostrar el dashboard de administración
     */
    public function dashboard()
    {
        $this->verificarAdmin();
        
        // Obtener datos para las estadísticas de manera segura
        try {
            $totalUsuarios = User::count();
            $totalRestaurantes = Restaurante::count();
            $totalReservas = Reserva::count();
        } catch (\Exception $e) {
            // Si hay algún error, usar valores por defecto
            $totalUsuarios = 0;
            $totalRestaurantes = 0;
            $totalReservas = 0;
        }
        
        // Pasar los datos a la vista
        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalRestaurantes',
            'totalReservas'
        ));
    }

    /**
     * Gestión de Usuarios
     */
    public function usuarios()
    {
        $this->verificarAdmin();
        return view('admin.usuarios');
    }

    /**
     * Gestión de Restaurantes
     */
    public function restaurantes()
    {
        $this->verificarAdmin();
        
        // Obtener todos los restaurantes con su tipo de cocina
        $restaurantes = Restaurante::with('tipo')->get();
        
        return view('admin.restaurantes', compact('restaurantes'));
    }

    /**
     * Gestión de Reservas
     */
    public function reservas()
    {
        $this->verificarAdmin();
        return view('admin.reservas');
    }

    public function roles()
    {
        $this->verificarAdmin();
        $roles = Rol::all();
        return view('admin.roles', ['roles' => $roles]);
    }

    public function rolstore(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:255|unique:rols']);

        $rol = Rol::create(['nombre' => $request->nombre]);

        return response()->json([
            'success' => true,
            'message' => 'Rol creado correctamente.',
            'rol'     => $rol,
        ]);
    }

    public function rolupdate(Request $request, Rol $rol)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:rols,nombre,' . $rol->id,
        ]);

        $rol->update(['nombre' => $request->nombre]);

        return response()->json([
            'success' => true,
            'message' => 'Rol actualizado correctamente.',
            'rol'     => $rol,
        ]);
    }

    public function roldestroy(Rol $rol)
    {
        if ($rol->users()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes eliminar un rol que tiene usuarios asignados.',
            ], 422);
        }

        $rol->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rol eliminado correctamente.',
        ]);
    }
}
