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
        
        // Obtener todos los usuarios con su rol
        $usuarios = User::with('rol')->orderBy('created_at', 'desc')->get();
        
        return view('admin.usuarios', compact('usuarios'));
    }
    
    /**
     * Eliminar un usuario (soporta AJAX y tradicional)
     */
    public function eliminarUsuario($id)
    {
        $this->verificarAdmin();
        
        try {
            $usuario = User::findOrFail($id);
            
            // No permitir que el admin se elimine a sí mismo
            if ($usuario->id === auth()->id()) {
                // Si es AJAX, devolver JSON
                if (request()->wantsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No puedes eliminarte a ti mismo'
                    ], 403);
                }
                return redirect()->route('admin.usuarios')->with('error', 'No puedes eliminarte a ti mismo');
            }
            
            $usuario->delete();
            
            // Si es AJAX, devolver JSON
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario eliminado correctamente'
                ]);
            }
            
            // Si es tradicional, redirect
            return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            // Si es AJAX
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el usuario'
                ], 500);
            }
            return redirect()->route('admin.usuarios')->with('error', 'Error al eliminar el usuario');
        }
    }
    
    /**
     * Mostrar formulario de edición de usuario
     */
    public function editarUsuario($id)
    {
        $this->verificarAdmin();
        
        $usuario = User::with('rol')->findOrFail($id);
        $roles = \App\Models\Rol::all();
        
        return view('admin.editar_usuario', compact('usuario', 'roles'));
    }
    
    /**
     * Actualizar un usuario
     */
    public function actualizarUsuario(Request $request, $id)
    {
        $this->verificarAdmin();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'rol_id'   => 'required|exists:rols,id',
            'password' => 'nullable|string|min:8',
        ]);

        try {
            $usuario          = User::findOrFail($id);
            $usuario->name    = $request->name;
            $usuario->email   = $request->email;
            $usuario->rol_id  = $request->rol_id;

            if ($request->filled('password')) {
                $usuario->password = bcrypt($request->password);
            }

            $usuario->save();

            // Si es AJAX devuelve JSON
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario actualizado correctamente',
                ]);
            }

            return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente');

        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el usuario',
                ], 500);
            }

            return redirect()->route('admin.usuarios')->with('error', 'Error al actualizar el usuario');
        }
    }

    public function restaurantes()
    {
        $this->verificarAdmin();
        $restaurantes = Restaurante::with('tipo')->get();
        return view('admin.restaurantes', compact('restaurantes'));
    }

    // =============================================
    // 2. NUEVO método — actualizarRestaurante()
    // =============================================

    public function actualizarRestaurante(Request $request, $id)
    {
        $this->verificarAdmin();

        $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'ubicacion'   => 'required|string',
            'precio'      => 'required|integer|min:0',
            'cheff'       => 'required|string|max:255',
            'menu'        => 'required|string',
            'id_tipo'     => 'required|exists:tipos,id',
            'estado'      => 'nullable|boolean',
        ]);

        try {
            $restaurante              = Restaurante::findOrFail($id);
            $restaurante->titulo      = $request->titulo;
            $restaurante->descripcion = $request->descripcion;
            $restaurante->ubicacion   = $request->ubicacion;
            $restaurante->precio      = $request->precio;
            $restaurante->cheff       = $request->cheff;
            $restaurante->menu        = $request->menu;
            $restaurante->id_tipo     = $request->id_tipo;
            $restaurante->estado      = $request->estado ? true : false;
            $restaurante->save();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Restaurante actualizado correctamente',
                ]);
            }

            return redirect()->route('admin.restaurantes')->with('success', 'Restaurante actualizado correctamente');

        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el restaurante',
                ], 500);
            }

            return redirect()->route('admin.restaurantes')->with('error', 'Error al actualizar el restaurante');
        }
    }

    // =============================================
    // 3. NUEVO método — eliminarRestaurante() (admin)
    // =============================================

    public function eliminarRestaurante($id)
    {
        $this->verificarAdmin();

        try {
            $restaurante = Restaurante::findOrFail($id);

            // Eliminar imagen del servidor si es local
            if ($restaurante->imagen && !Str::startsWith($restaurante->imagen, 'http') && file_exists(public_path($restaurante->imagen))) {
                unlink(public_path($restaurante->imagen));
            }

            $restaurante->delete();

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Restaurante eliminado correctamente',
                ]);
            }

            return redirect()->route('admin.restaurantes')->with('success', 'Restaurante eliminado correctamente');

        } catch (\Exception $e) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar el restaurante',
                ], 500);
            }

            return redirect()->route('admin.restaurantes')->with('error', 'Error al eliminar el restaurante');
        }
    }

    /**
     * Gestión de Reservas
     */
    public function reservas()
    {
        $this->verificarAdmin();
        
        // Obtener todas las reservas con sus relaciones
        $reservas = Reserva::with(['usuario', 'restaurante'])->orderBy('created_at', 'desc')->get();
        
        return view('admin.reservas', compact('reservas'));
    }
    
    
    /**
     * Eliminar una reserva (soporta AJAX y tradicional)
     */
    public function eliminarReserva($id)
    {
        $this->verificarAdmin();
        
        try {
            $reserva = Reserva::findOrFail($id);
            $reserva->delete();
            
            // Si es AJAX, devolver JSON
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reserva eliminada correctamente'
                ]);
            }
            
            return redirect()->route('admin.reservas')->with('success', 'Reserva eliminada correctamente');
        } catch (\Exception $e) {
            // Si es AJAX
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar la reserva'
                ], 500);
            }
            return redirect()->route('admin.reservas')->with('error', 'Error al eliminar la reserva');
        }
    }
    
    /**
     * Mostrar formulario de edición de reserva
     */
    public function editarReserva($id)
    {
        $this->verificarAdmin();
        
        $reserva = Reserva::with(['usuario', 'restaurante'])->findOrFail($id);
        $usuarios = User::all();
        $restaurantes = Restaurante::all();
        
        return view('admin.editar_reserva', compact('reserva', 'usuarios', 'restaurantes'));
    }
    

    /**
     * Actualizar una reserva (soporta AJAX y tradicional)
     */
    public function actualizarReserva(Request $request, $id)
    {
        $this->verificarAdmin();

        $request->validate([
            'id_user'        => 'required|exists:users,id',
            'id_restaurante' => 'required|exists:restaurantes,id',
            'fecha_hora'     => 'required|date',
        ]);

        try {
            $reserva                 = Reserva::findOrFail($id);
            $reserva->id_user        = $request->id_user;
            $reserva->id_restaurante = $request->id_restaurante;
            $reserva->fecha_hora     = $request->fecha_hora;
            $reserva->save();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reserva actualizada correctamente',
                ]);
            }

            return redirect()->route('admin.reservas')->with('success', 'Reserva actualizada correctamente');

        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar la reserva',
                ], 500);
            }

            return redirect()->route('admin.reservas')->with('error', 'Error al actualizar la reserva');
        }
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
