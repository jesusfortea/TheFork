<?php

namespace Database\Seeders;

use App\Models\Reserva;
use App\Models\User;
use App\Models\Restaurante;
use Illuminate\Database\Seeder;

class ReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios (excluyendo al admin)
        $usuarios = User::where('email', '!=', 'admin@gmail.com')->get();
        
        // Obtener todos los restaurantes
        $restaurantes = Restaurante::all();

        // Función helper para generar fechas futuras aleatorias
        $generarFechaFutura = function() {
            $diasFuturos = rand(1, 30); // Entre 1 y 30 días en el futuro
            $hora = rand(12, 22); // Entre las 12:00 y las 22:00
            $minutos = rand(0, 3) * 15; // 00, 15, 30 o 45 minutos
            return now()->addDays($diasFuturos)->setTime($hora, $minutos, 0);
        };

        // Crear reservas aleatorias
        // Juan Pérez - 3 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'juan.perez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'juan.perez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'juan.perez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        // María López - 2 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'maria.lopez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'maria.lopez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        // Carlos Rodríguez - 4 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'carlos.rodriguez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'carlos.rodriguez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'carlos.rodriguez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'carlos.rodriguez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        // Ana Fernández - 1 reserva
        Reserva::create([
            'id_user' => $usuarios->where('email', 'ana.fernandez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        // Pedro Martín - 2 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'pedro.martin@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'pedro.martin@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        // Laura García - 3 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'laura.garcia@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'laura.garcia@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'laura.garcia@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        // David Sánchez - 2 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'david.sanchez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'david.sanchez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);

        // Carmen Gómez - 1 reserva
        Reserva::create([
            'id_user' => $usuarios->where('email', 'carmen.gomez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
            'fecha_hora' => $generarFechaFutura(),
        ]);
    }
}
