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
        $restaurante->imagen = $request->img;
        $restaurante->ubicacion = $request->ubi;
        $restaurante->precio = $request->precio;
        $restaurante->cheff = $request->cheff;
        $restaurante->menu = $request->menu;
        $restaurante->tipo = $request->tipo;

        $restaurante->save();

    }

    public function home(){

        return view('index');

    }
}