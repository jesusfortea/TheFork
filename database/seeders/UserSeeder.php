<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar los roles
        $rolAdmin = \App\Models\Rol::where('nombre', 'Administrador')->first();
        $rolCliente = \App\Models\Rol::where('nombre', 'Cliente')->first();

        // Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('qweQWE123'),
            'rol_id' => $rolAdmin->id,
        ]);

        // Clientes de prueba
        User::create([
            'name' => 'Juan Pérez García',
            'email' => 'juan.perez@gmail.com',
            'password' => Hash::make('password123'),
            'rol_id' => $rolCliente->id,
        ]);

        User::create([
            'name' => 'María López Martínez',
            'email' => 'maria.lopez@gmail.com',
            'password' => Hash::make('password123'),
            'rol_id' => $rolCliente->id,
        ]);

        User::create([
            'name' => 'Carlos Rodríguez Sánchez',
            'email' => 'carlos.rodriguez@gmail.com',
            'password' => Hash::make('password123'),
            'rol_id' => $rolCliente->id,
        ]);

        User::create([
            'name' => 'Ana Fernández Ruiz',
            'email' => 'ana.fernandez@gmail.com',
            'password' => Hash::make('password123'),
            'rol_id' => $rolCliente->id,
        ]);

        User::create([
            'name' => 'Pedro Martín González',
            'email' => 'pedro.martin@gmail.com',
            'password' => Hash::make('password123'),
            'rol_id' => $rolCliente->id,
        ]);

        User::create([
            'name' => 'Laura García Díaz',
            'email' => 'laura.garcia@gmail.com',
            'password' => Hash::make('password123'),
            'rol_id' => $rolCliente->id,
        ]);

        User::create([
            'name' => 'David Sánchez Torres',
            'email' => 'david.sanchez@gmail.com',
            'password' => Hash::make('password123'),
            'rol_id' => $rolCliente->id,
        ]);

        User::create([
            'name' => 'Carmen Gómez Navarro',
            'email' => 'carmen.gomez@gmail.com',
            'password' => Hash::make('password123'),
            'rol_id' => $rolCliente->id,
        ]);
    }
}
