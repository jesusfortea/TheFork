<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearRestauranteRequest;
use App\Models\Etiqueta;
use App\Models\Restaurante;
use App\Models\Tipo;
use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    
    public function index(){

        $etiquetas = Etiqueta::all();
        $tipos = Tipo::all();

        return view('restaurante.create', ['etiquetas' => $etiquetas, 'tipos' => $tipos]);
    }

    public function show(){

        $tipos = Tipo::all();
        $restaurantes = Restaurante::all();

        return view('mainpage', ['tipos' => $tipos, 'restaurantes' => $restaurantes]);
    }


    public function solicitud(CrearRestauranteRequest $request){

        // GUARDAR LA IMAGEN PRIMERO
        $rutaImagen = null;
        if ($request->hasFile('img')) {
            $imagen = $request->file('img');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('media'), $nombreImagen);
            $rutaImagen = 'media/' . $nombreImagen;
        }

        $restaurante = new Restaurante();
        $restaurante->titulo = $request->titulo;
        $restaurante->descripcion = $request->desc;
        $restaurante->imagen = $rutaImagen;
        $restaurante->ubicacion = $request->ubi;
        $restaurante->precio = $request->precio;
        $restaurante->cheff = $request->cheff;
        $restaurante->menu = $request->menu;
        $restaurante->id_tipo = $request->tipo;
        $restaurante->estado = false;
        
        $restaurante->save();
        
        return redirect()->route('home');

    }

    public function home(){
        $restaurantes = Restaurante::all();
        $restaurantes_destacados = Restaurante::where('estado', true)
            ->withAvg('resenas', 'puntuacion')
            ->take(4)
            ->get();

        return view('index', [
            'restaurantes' => $restaurantes,
            'restaurantes_destacados' => $restaurantes_destacados
        ]);
    }

    /**
     * Elimina un restaurante de la base de datos
     * @param int $id - ID del restaurante a eliminar
     */
    public function destroy($id){
        
        // Buscar el restaurante por ID
        $restaurante = Restaurante::findOrFail($id);
        
        // Eliminar la imagen del servidor si existe
        if ($restaurante->imagen && file_exists(public_path($restaurante->imagen))) {
            unlink(public_path($restaurante->imagen));
        }
        
        // Eliminar el restaurante de la base de datos
        $restaurante->delete();
        
        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Restaurante eliminado correctamente');
    }

    /**
     * Muestra el formulario de edición de un restaurante
     * @param int $id - ID del restaurante a editar
     */
    public function edit($id){
        
        // Buscar el restaurante que queremos editar por su ID
        // findOrFail() lanza un error 404 si no lo encuentra
        $restaurante = Restaurante::findOrFail($id);
        
        // Obtener todas las etiquetas disponibles para mostrarlas en el formulario
        $etiquetas = Etiqueta::all();
        
        // Obtener todos los tipos de cocina disponibles para el select
        $tipos = Tipo::all();
        
        // Retornar la vista de edición pasándole los datos necesarios
        // - $restaurante: los datos actuales del restaurante a editar
        // - $etiquetas: todas las etiquetas disponibles
        // - $tipos: todos los tipos de cocina disponibles
        return view('restaurante.edit', [
            'restaurante' => $restaurante,
            'etiquetas' => $etiquetas,
            'tipos' => $tipos
        ]);
    }

    /**
     * Actualiza un restaurante existente en la base de datos
     * @param CrearRestauranteRequest $request - Datos validados del formulario
     * @param int $id - ID del restaurante a actualizar
     */
    public function update(CrearRestauranteRequest $request, $id){
        
        // Buscar el restaurante que vamos a actualizar
        $restaurante = Restaurante::findOrFail($id);
        
        // GESTIÓN DE LA IMAGEN
        // Verificar si se subió una nueva imagen
        if ($request->hasFile('img')) {
            
            // Si existe una imagen antigua, eliminarla del servidor
            if ($restaurante->imagen && file_exists(public_path($restaurante->imagen))) {
                unlink(public_path($restaurante->imagen));
            }
            
            // Procesar la nueva imagen
            $imagen = $request->file('img');
            // Crear un nombre único usando timestamp + nombre original
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            // Mover la imagen a la carpeta public/media
            $imagen->move(public_path('media'), $nombreImagen);
            // Actualizar la ruta de la imagen en el objeto restaurante
            $restaurante->imagen = 'media/' . $nombreImagen;
        }
        // Si no se subió nueva imagen, mantener la imagen actual (no hacer nada)
        
        // ACTUALIZAR LOS DATOS DEL RESTAURANTE
        // Asignar cada campo del formulario al modelo
        $restaurante->titulo = $request->titulo;
        $restaurante->descripcion = $request->desc;
        $restaurante->ubicacion = $request->ubi;
        $restaurante->precio = $request->precio;
        $restaurante->cheff = $request->cheff;
        $restaurante->menu = $request->menu;
        $restaurante->id_tipo = $request->tipo;
        // Nota: el campo 'estado' no se actualiza aquí, se mantiene el valor actual
        
        // Guardar los cambios en la base de datos
        // save() actualiza el registro existente
        $restaurante->save();
        
        // Redirigir a la página de gestión con un mensaje de éxito
        return redirect()->route('admin.restaurantes')->with('success', 'Restaurante actualizado correctamente');
    }

    /**
    * Guardar reserva via AJAX
    */
    public function guardarReserva(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión para hacer una reserva',
            ], 401);
        }

        try {
            $request->validate([
                'fecha_hora'      => 'required|date|after:now',
                'id_restaurante'  => 'required|exists:restaurantes,id',
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errores = $e->validator->errors()->all();
            return response()->json([
                'success' => false,
                'message' => implode(', ', $errores),
            ], 422);
        }

        try {
            $reserva = \App\Models\Reserva::create([
                'fecha_hora'      => $request->fecha_hora,
                'id_user'         => auth()->id(),
                'id_restaurante'  => $request->id_restaurante,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reserva creada correctamente',
                'reserva' => $reserva,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la reserva: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Guardar reseña via AJAX
     */
    public function guardarResena(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes iniciar sesión para dejar una reseña',
            ], 401);
        }

        try {
            $request->validate([
                'comentario'      => 'required|string|min:10|max:1000',
                'puntuacion'      => 'required|integer|min:0|max:10',
                'id_restaurante'  => 'required|exists:restaurantes,id',
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capturar errores de validación y devolverlos
            $errores = $e->validator->errors()->all();
            return response()->json([
                'success' => false,
                'message' => implode(', ', $errores),
            ], 422);
        }

        try {
            $resena = \App\Models\Resena::create([
                'comentario'      => $request->comentario,
                'puntuacion'      => $request->puntuacion,
                'id_user'         => auth()->id(),
                'id_restaurante'  => $request->id_restaurante,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reseña publicada correctamente',
                'resena'  => $resena,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al publicar la reseña: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Obtener reseñas de un restaurante
     */
    public function obtenerResenas($idRestaurante)
    {
        $resenas = \App\Models\Resena::where('id_restaurante', $idRestaurante)
            ->with('usuario')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($resena) {
                return [
                    'id'              => $resena->id,
                    'comentario'      => $resena->comentario,
                    'puntuacion'      => $resena->puntuacion,
                    'usuario_nombre'  => $resena->usuario?->name ?? 'Usuario eliminado',
                    'fecha'           => $resena->created_at->format('d/m/Y'),
                ];
            });

        return response()->json([
            'success' => true,
            'resenas' => $resenas,
        ]);
    }


    /**
     * Filtrar restaurantes via AJAX
     */
    public function filtrar(Request $request)
    {
        try {
            $query = Restaurante::where('estado', true)
                ->with(['tipo', 'etiquetas', 'resenas']);
            
            // 1. Búsqueda por título
            if ($request->has('buscar') && $request->buscar != null) {
                $query->where('titulo', 'LIKE', '%' . $request->buscar . '%');
            }
            
            // 2. Filtrar por tipo de cocina
            if ($request->has('tipo') && $request->tipo != null) {
                $query->whereHas('tipo', function($q) use ($request) {
                    $q->where('nombre', $request->tipo);
                });
            }
            
            // 3. Filtrar por rango de precio
            if ($request->has('precio_min') && $request->precio_min != null) {
                $query->where('precio', '>=', $request->precio_min);
            }
            
            if ($request->has('precio_max') && $request->precio_max != null) {
                $query->where('precio', '<=', $request->precio_max);
            }
            
            // 4. Filtrar por etiqueta "Ofertas especiales"
            if ($request->has('ofertas_especiales') && $request->ofertas_especiales == 'true') {
                $query->whereHas('etiquetas', function($q) {
                    $q->where('nombre', 'Ofertas especiales');
                });
            }
            
            // 5. Filtrar por etiqueta "Insider"
            if ($request->has('insider') && $request->insider == 'true') {
                $query->whereHas('etiquetas', function($q) {
                    $q->where('nombre', 'Insider');
                });
            }
            
            // 6. Ordenar por mejor valorados
            if ($request->has('mejor_valorados') && $request->mejor_valorados == 'true') {
                $query->withAvg('resenas', 'puntuacion')
                    ->orderByDesc('resenas_avg_puntuacion');
            }
            
            $restaurantes = $query->get();
            
            // Añadir promedio de reseñas si no se ha añadido aún
            if (!$request->has('mejor_valorados')) {
                $restaurantes = $restaurantes->map(function($rest) {
                    $rest->resenas_avg_puntuacion = $rest->resenas->avg('puntuacion');
                    return $rest;
                });
            }
            
            return response()->json([
                'success' => true,
                'restaurantes' => $restaurantes,
                'total' => $restaurantes->count(),
                'filtros_aplicados' => $request->all()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'restaurantes' => [],
                'total' => 0,
            ], 500);
        }
    }
}