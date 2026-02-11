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

        $restaurante = new Restaurante();
        $restaurante->titulo = $request->titulo;
        $restaurante->descripcion = $request->desc;

        // GUARDAR LA IMAGEN EN public/media
        if ($request->hasFile('img')) {
            $imagen = $request->file('img');
            
            // Generar un nombre único para evitar colisiones
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            
            // Mover la imagen a public/media
            $imagen->move(public_path('media'), $nombreImagen);
            
            // Guardar la ruta en la BBDD
            $restaurante->imagen = 'media/' . $nombreImagen;
        }

        $restaurante->ubicacion = $request->ubi;
        $restaurante->precio = $request->precio;
        $restaurante->cheff = $request->cheff;
        $restaurante->menu = $request->menu;
        $restaurante->id_tipo = $request->tipo;

        $restaurante->save();
        
        return redirect()->route('home');

    }

    public function home(){

        $restaurante = Restaurante::all();
        return view('index', ['restaurantes' => $restaurante]);

    }
}