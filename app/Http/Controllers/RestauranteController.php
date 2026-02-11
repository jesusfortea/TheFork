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
        $restaurante->img = $request->img;
        $restaurante->titulo = $request->titulo;
        $restaurante->desc = $request->desc;
        $restaurante->tipo = $request->tipo;
        $restaurante->ubi = $request->ubi;
        $restaurante->cheff = $request->cheff;
        $restaurante->precio = $request->precio;

        $restaurante->save();

    }



}
