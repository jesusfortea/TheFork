<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Restaurante;
use App\Models\Reserva;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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




    /**
    * Filtrar usuarios con AJAX * 
    * Este método procesa los filtros enviados desde el frontend y retorna
    * los usuarios que coinciden con los criterios de búsqueda
    */
    public function filtrarUsuarios(Request $request)
    {
        // Iniciar query
        $query = \App\Models\User::with('rol');

        // ────────────────────────────────────────────
        // FILTRO: Buscar por nombre
        // ────────────────────────────────────────────
        if ($request->filled('nombre')) {
            $query->where('name', 'LIKE', '%' . $request->nombre . '%');
        }

        // ────────────────────────────────────────────
        // FILTRO: Buscar por email
        // ────────────────────────────────────────────
        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%' . $request->email . '%');
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por rol
        // ────────────────────────────────────────────
        if ($request->filled('rol')) {
            $query->where('rol_id', $request->rol);
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por fecha de registro
        // ────────────────────────────────────────────
        if ($request->filled('fecha')) {
            $now = now();
            
            switch ($request->fecha) {
                case 'hoy':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                    
                case 'ultima_semana':
                    $query->where('created_at', '>=', $now->subWeek());
                    break;
                    
                case 'ultimo_mes':
                    $query->where('created_at', '>=', $now->subMonth());
                    break;
                    
                case 'ultimo_trimestre':
                    $query->where('created_at', '>=', $now->subMonths(3));
                    break;
                    
                case 'ultimo_año':
                    $query->where('created_at', '>=', $now->subYear());
                    break;
            }
        }

        // Ejecutar query y obtener usuarios
        $usuarios = $query->orderBy('created_at', 'desc')->get();

        // Retornar JSON
        return response()->json([
            'success'  => true,
            'usuarios' => $usuarios,
            'total'    => $usuarios->count()
        ]);
    }




    /**
    * Filtrar restaurantes con AJAX
    * 
    * Este método procesa los filtros enviados desde el frontend y retorna
    * los restaurantes que coinciden con los criterios de búsqueda
    */
    public function filtrarRestaurantes(Request $request)
    {
        // Iniciar query
        $query = \App\Models\Restaurante::with('tipo');

        // ────────────────────────────────────────────
        // FILTRO: Buscar por título
        // ────────────────────────────────────────────
        if ($request->filled('titulo')) {
            $query->where('titulo', 'LIKE', '%' . $request->titulo . '%');
        }

        // ────────────────────────────────────────────
        // FILTRO: Buscar por chef
        // ────────────────────────────────────────────
        if ($request->filled('chef')) {
            $query->where('cheff', 'LIKE', '%' . $request->chef . '%');
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por tipo de cocina
        // ────────────────────────────────────────────
        if ($request->filled('tipo')) {
            $query->where('id_tipo', $request->tipo);
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por estado
        // ────────────────────────────────────────────
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado == '1');
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por rango de precio
        // ────────────────────────────────────────────
        if ($request->filled('precio')) {
            $rangos = explode('-', $request->precio);
            if (count($rangos) === 2) {
                $min = (int) $rangos[0];
                $max = (int) $rangos[1];
                $query->whereBetween('precio', [$min, $max]);
            }
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por fecha de registro
        // ────────────────────────────────────────────
        if ($request->filled('fecha')) {
            $now = now();
            
            switch ($request->fecha) {
                case 'hoy':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                    
                case 'ultima_semana':
                    $query->where('created_at', '>=', $now->subWeek());
                    break;
                    
                case 'ultimo_mes':
                    $query->where('created_at', '>=', $now->subMonth());
                    break;
                    
                case 'ultimo_trimestre':
                    $query->where('created_at', '>=', $now->subMonths(3));
                    break;
                    
                case 'ultimo_año':
                    $query->where('created_at', '>=', $now->subYear());
                    break;
            }
        }

        // Ejecutar query y obtener restaurantes
        $restaurantes = $query->orderBy('created_at', 'desc')->get();

        // Retornar JSON
        return response()->json([
            'success'       => true,
            'restaurantes'  => $restaurantes,
            'total'         => $restaurantes->count()
        ]);
    }




    /**
    * Filtrar reservas con AJAX
    * 
    * Este método procesa los filtros enviados desde el frontend y retorna
    * las reservas que coinciden con los criterios de búsqueda
    */
    
    public function filtrarReservas(Request $request)
    {
        // Iniciar query
        $query = \App\Models\Reserva::with(['usuario', 'restaurante']);

        // ────────────────────────────────────────────
        // FILTRO: Buscar por nombre de usuario
        // ────────────────────────────────────────────
        if ($request->filled('usuario')) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->usuario . '%');
            });
        }

        // ────────────────────────────────────────────
        // FILTRO: Buscar por email
        // ────────────────────────────────────────────
        if ($request->filled('email')) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('email', 'LIKE', '%' . $request->email . '%');
            });
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por restaurante
        // ────────────────────────────────────────────
        if ($request->filled('restaurante')) {
            $query->where('id_restaurante', $request->restaurante);
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por fecha de reserva
        // ────────────────────────────────────────────
        if ($request->filled('fecha_reserva')) {
            $now = now();
            
            switch ($request->fecha_reserva) {
                case 'hoy':
                    $query->whereDate('fecha_hora', $now->toDateString());
                    break;
                    
                case 'esta_semana':
                    $startOfWeek = $now->copy()->startOfWeek();
                    $endOfWeek   = $now->copy()->endOfWeek();
                    $query->whereBetween('fecha_hora', [$startOfWeek, $endOfWeek]);
                    break;
                    
                case 'este_mes':
                    $query->whereYear('fecha_hora', $now->year)
                        ->whereMonth('fecha_hora', $now->month);
                    break;
                    
                case 'pasadas':
                    $query->where('fecha_hora', '<', $now);
                    break;
                    
                case 'futuras':
                    $query->where('fecha_hora', '>=', $now);
                    break;
            }
        }

        // ────────────────────────────────────────────
        // FILTRO: Filtrar por fecha de registro
        // ────────────────────────────────────────────
        if ($request->filled('fecha_registro')) {
            $now = now();
            
            switch ($request->fecha_registro) {
                case 'hoy':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                    
                case 'ultima_semana':
                    $query->where('created_at', '>=', $now->subWeek());
                    break;
                    
                case 'ultimo_mes':
                    $query->where('created_at', '>=', $now->subMonth());
                    break;
                    
                case 'ultimo_trimestre':
                    $query->where('created_at', '>=', $now->subMonths(3));
                    break;
            }
        }

        // Ejecutar query y obtener reservas
        $reservas = $query->orderBy('fecha_hora', 'desc')->get();

        // Retornar JSON
        return response()->json([
            'success'  => true,
            'reservas' => $reservas,
            'total'    => $reservas->count()
        ]);
    }
}
