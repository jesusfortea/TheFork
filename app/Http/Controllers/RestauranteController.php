<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\Tipo;
use Illuminate\Http\Request;

class RestauranteController extends Controller
{
    
    public function index(){

        $etiquetas = Etiqueta::all();

        return view('restaurante.create', ['etiquetas' => $etiquetas]);
    }

    public function show(){

        $tipos = Tipo::all();

        return view('components.restaurant', ['tipos' => $tipos]);
    }
}
