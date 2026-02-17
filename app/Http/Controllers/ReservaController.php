<?php

namespace App\Http\Controllers;

use App\Mail\Reserva;
use App\Models\Restaurante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        // Valida y crea la reserva en la DB (basado en tu migración)
        $validated = $request->validate([
            'fecha' => 'required|date',
            'id_user' => 'required|exists:users,id',
            'id_restaurante' => 'required|exists:restaurantes,id',
        ]);

        $reserva = \App\Models\Reserva::create($validated);

        // Obtén datos para el email
        $user = User::find($validated['id_user']);
        $restaurante = Restaurante::find($validated['id_restaurante']);

        // Envía el email
        Mail::to($user->email)->send(new Reserva(
            $user->name,
            $validated['fecha'],
            $restaurante->titulo
        ));

        return redirect()->back()->with('success', 'Reserva creada y email enviado.');
    }
}