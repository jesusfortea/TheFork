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

        return view('components.restaurant', ['tipos' => $tipos]);
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

        $restaurante = Restaurante::all();
        return view('index', ['restaurantes' => $restaurante]);

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
}