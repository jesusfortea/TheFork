<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearRestaurante;
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


    public function solicitud(CrearRestaurante $request){

        $restaurante = new Restaurante();
        $restaurante->titulo = $request->titulo;
        $restaurante->save();

    }



}
