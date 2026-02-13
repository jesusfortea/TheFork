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

        // Crear reservas aleatorias
        // Juan Pérez - 3 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'juan.perez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'juan.perez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'juan.perez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        // María López - 2 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'maria.lopez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'maria.lopez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        // Carlos Rodríguez - 4 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'carlos.rodriguez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'carlos.rodriguez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'carlos.rodriguez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'carlos.rodriguez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        // Ana Fernández - 1 reserva
        Reserva::create([
            'id_user' => $usuarios->where('email', 'ana.fernandez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        // Pedro Martín - 2 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'pedro.martin@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'pedro.martin@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        // Laura García - 3 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'laura.garcia@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'laura.garcia@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'laura.garcia@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        // David Sánchez - 2 reservas
        Reserva::create([
            'id_user' => $usuarios->where('email', 'david.sanchez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        Reserva::create([
            'id_user' => $usuarios->where('email', 'david.sanchez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);

        // Carmen Gómez - 1 reserva
        Reserva::create([
            'id_user' => $usuarios->where('email', 'carmen.gomez@gmail.com')->first()->id,
            'id_restaurante' => $restaurantes->random()->id,
        ]);
    }
}
