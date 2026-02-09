<?php

namespace Database\Seeders;

use App\Models\Etiqueta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etq = new Etiqueta();
        $etq->nombre = 'Insider';
        $etq->tipo = 'Insignia';
        $etq->save();

        $etq2 = new Etiqueta();
        $etq2->nombre = 'Top100';
        $etq2->tipo = 'Insignia';
        $etq2->save();

        $etq3 = new Etiqueta();
        $etq3->nombre = 'TopHost';
        $etq3->tipo = 'Insignia';
        $etq3->save();

        $etq4 = new Etiqueta();
        $etq4->nombre = 'Hasta un 50% de descuento';
        $etq4->tipo = 'Descriptivo';
        $etq4->save();

        $etq5 = new Etiqueta();
        $etq5->nombre = 'Yums x3';
        $etq5->tipo = 'Descriptivo';
        $etq5->save();
    }
}
