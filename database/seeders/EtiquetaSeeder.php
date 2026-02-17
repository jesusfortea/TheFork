<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    public function run(): void
    {
        $etiquetas = [
            ['nombre' => 'Ofertas especiales', 'tipo' => 'Insignia'],
            ['nombre' => 'Insider', 'tipo' => 'Insignia'],
            ['nombre' => 'Destacado', 'tipo' => 'Insignia'],
            ['nombre' => '-30% OFF', 'tipo' => 'Descriptivo'],
            ['nombre' => 'Disponible hoy', 'tipo' => 'Descriptivo'],
        ];

        foreach ($etiquetas as $etiqueta) {
            Etiqueta::create($etiqueta);
        }
    }
}