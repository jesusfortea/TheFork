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
        // Buscar el rol de Administrador (debe existir en la tabla rols)
        $rolAdmin = \App\Models\Rol::where('nombre', 'Administrador')->first();

        $user = new User();
        $user->name = 'Administrador';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('qweQWE123');
        $user->rol_id = $rolAdmin->id; // Asignar el ID del rol
        $user->save();
    }
}
