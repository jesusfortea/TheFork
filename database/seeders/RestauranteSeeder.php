<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use Illuminate\Database\Seeder;

class RestauranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos tipos de cocina
        $tipoItaliano = \App\Models\Tipo::where('nombre', 'Italiano')->first();
        $tipoJapones = \App\Models\Tipo::where('nombre', 'Japonés')->first();
        $tipoCatalan = \App\Models\Tipo::where('nombre', 'Catalán')->first();
        $tipoMediterraneo = \App\Models\Tipo::where('nombre', 'Mediterráneo')->first();
        $tipoFrances = \App\Models\Tipo::where('nombre', 'Francés')->first();
        $tipoMexicano = \App\Models\Tipo::where('nombre', 'Mexicano')->first();
        $tipoTailandés = \App\Models\Tipo::where('nombre', 'Tailandés')->first();
        $tipoIndio = \App\Models\Tipo::where('nombre', 'Indio')->first();

        // Rest auranres reales de Barcelona
        Restaurante::create([
            'titulo' => 'Moments - Hotel Mandarin Oriental',
            'descripcion' => 'Restaurante de alta cocina con 2 estrellas Michelin, dirigido por el chef Carme Ruscalleda. Cocina catalana moderna con toques innovadores.',
            'imagen' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800',
            'ubicacion' => 'Passeig de Gràcia, 38-40, Barcelona',
            'precio' => 150,
            'cheff' => 'Carme Ruscalleda',
            'menu' => 'Menú degustación: Foie gras, Lubina a la sal, Cordero lechal, Postres variados',
            'estado' => true,
            'estado' => true,
            'id_tipo' => $tipoCatalan->id,
        ]);

        Restaurante::create([
            'titulo' => 'Disfrutar',
            'descripcion' => 'Restaurante con 2 estrellas Michelin. Cocina de vanguardia creada por discípulos de Ferran Adrià. Experiencia gastronómica única.',
            'imagen' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800',
            'ubicacion' => 'Carrer de Villarroel, 163, Barcelona',
            'precio' => 135,
            'cheff' => 'Mateu Casañas, Oriol Castro, Eduard Xatruch',
            'menu' => 'Menú degustación: Panchino, Gamba roja, Pigeon, Postres de autor',
            'estado' => true,
            'id_tipo' => $tipoMediterraneo->id,
        ]);

        Restaurante::create([
            'titulo' => 'Koy Shunka',
            'descripcion' => 'Auténtica cocina japonesa con 1 estrella Michelin. Sushi y sashimi de máxima calidad en el corazón del Gótico.',
            'imagen' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=800',
            'ubicacion' => 'Carrer de Copons, 7, Barcelona',
            'precio' => 95,
            'cheff' => 'Hideki Matsuhisa',
            'menu' => 'Omakase: Nigiri variado, Sashimi de atún, Tempura, Mochi',
            'estado' => true,
            'id_tipo' => $tipoJapones->id,
        ]);

        Restaurante::create([
            'titulo' => 'Cinc Sentits',
            'descripcion' => 'Restaurante contemporáneo con cocina catalana de temporada. Ambiente elegante y servicio impecable.',
            'imagen' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=800',
            'ubicacion' => 'Carrer d\'Aribau, 58, Barcelona',
            'precio' => 85,
            'cheff' => 'Jordi Artal',
            'menu' => 'Menú de temporada: Alcachofa confitada, Bacalao negro, Cordero, Texturas de chocolate',
            'estado' => true,
            'id_tipo' => $tipoCatalan->id,
        ]);

        Restaurante::create([
            'titulo' => 'Alkimia',
            'descripcion' => 'Restaurante con estrella Michelin que reinterpreta la cocina catalana tradicional con técnicas modernas.',
            'imagen' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=800',
            'ubicacion' => 'Ronda de Sant Antoni, 41, Barcelona',
            'precio' => 90,
            'cheff' => 'Jordi Vilà',
            'menu' => 'Menú degustación: Espardenyes, Rape, Pichón, Pre-postres y postres',
            'estado' => true,
            'id_tipo' => $tipoCatalan->id,
        ]);

        Restaurante::create([
            'titulo' => 'Lasarte',
            'descripcion' => 'Restaurante con 3 estrellas Michelin del chef Martín Berasategui. Máximo exponente de la alta cocina en Barcelona.',
            'imagen' => 'https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=800',
            'ubicacion' => 'Carrer de Mallorca, 259, Barcelona',
            'precio' => 180,
            'cheff' => 'Martín Berasategui',
            'menu' => 'Menú gran: Ostras, Lubina salvaje, Pichón, Petit fours',
            'estado' => true,
            'id_tipo' => $tipoMediterraneo->id,
        ]);

        Restaurante::create([
            'titulo' => 'Cervecería Catalana',
            'descripcion' => 'Emblemática cervecería con las mejores tapas de Barcelona. Siempre llena, siempre deliciosa.',
            'imagen' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800',
            'ubicacion' => 'Carrer de Mallorca, 236, Barcelona',
            'precio' => 25,
            'cheff' => 'Josep María Català',
            'menu' => 'Tapas variadas: Jamón ibérico, Croquetas, Pulpo a la gallega, Patatas bravas',
            'estado' => true,
            'id_tipo' => $tipoCatalan->id,
        ]);

        Restaurante::create([
            'titulo' => 'El Nacional',
            'descripcion' => 'Espacio gastronómico único con 4 restaurantes diferentes bajo un mismo techo. Ambiente modernista espectacular.',
            'imagen' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800',
            'ubicacion' => 'Passeig de Gràcia, 24 bis, Barcelona',
            'precio' => 35,
            'cheff' => 'Equipo El Nacional',
            'menu' => 'Variado: Mariscos, Carnes, Tapas, Paella',
            'estado' => true,
            'id_tipo' => $tipoCatalan->id,
        ]);

        Restaurante::create([
            'titulo' => 'Restaurante 7 Portes',
            'descripcion' => 'Restaurante histórico desde 1836. Cocina tradicional catalana en un ambiente elegante y clásico.',
            'imagen' => 'https://images.unsplash.com/photo-1551632436-cbf8dd35adfa?w=800',
            'ubicacion' => 'Passeig d\'Isabel II, 14, Barcelona',
            'precio' => 45,
            'cheff' => 'Marc Singla',
            'menu' => 'Tradicional: Paella, Arroz negro, Suquet de peix, Crema catalana',
            'estado' => true,
            'id_tipo' => $tipoCatalan->id,
        ]);

        Restaurante::create([
            'titulo' => 'Tickets Bar',
            'descripcion' => 'Tapas creativas de los hermanos Adrià. Cocina divertida y vanguardista en ambiente informal.',
            'imagen' => 'https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=800',
            'ubicacion' => 'Avinguda del Paral·lel, 164, Barcelona',
            'precio' => 55,
            'cheff' => 'Albert Adrià',
            'menu' => 'Tapas de autor: Air baguette, Aceitunas esféricas, Bikini de trufa, Dados de tortilla',
            'estado' => true,
            'id_tipo' => $tipoMediterraneo->id,
        ]);

        Restaurante::create([
            'titulo' => 'La Paradeta',
            'descripcion' => 'Marisquería donde eliges tu pescado fresco y lo preparan al momento. Concepto único y calidad excepcional.',
            'imagen' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?w=800',
            'ubicacion' => 'Carrer Comercial, 7, Barcelona',
            'precio' => 40,
            'cheff' => 'Equipo La Paradeta',
            'menu' => 'Marisco fresco: Gambas, Almejas, Mejillones, Pescado a la plancha',
            'estado' => true,
            'id_tipo' => \App\Models\Tipo::where('nombre', 'Marisquería')->first()->id,
        ]);

        Restaurante::create([
            'titulo' => 'Cal Pep',
            'descripcion' => 'Taberna de tapas legendaria en el Born. Producto fresco y cocina sencilla pero exquisita.',
            'imagen' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=800',
            'ubicacion' => 'Plaça de les Olles, 8, Barcelona',
            'precio' => 35,
            'cheff' => 'Pep Manubens',
            'menu' => 'Tapas de mercado: Chipirones, Gambas al ajillo, Alcachofas, Tortilla de patatas',
            'estado' => true,
            'id_tipo' => $tipoCatalan->id,
        ]);

        Restaurante::create([
            'titulo' => 'Dos Palillos',
            'descripcion' => 'Fusión asiática contemporánea con estrella Michelin. Experiencia gastronómica única en Barcelona.',
            'imagen' => 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=800',
            'ubicacion' => 'Carrer d\'Elisabets, 9, Barcelona',
            'precio' => 75,
            'cheff' => 'Albert Raurich',
            'menu' => 'Menú fusión: Gyozas, Ramen creativo, Bao buns, Mochi',
            'estado' => true,
            'id_tipo' => \App\Models\Tipo::where('nombre', 'De Fusión')->first()->id,
        ]);

        Restaurante::create([
            'titulo' => 'Pakta',
            'descripcion' => 'Fusión nikkei (peruano-japonesa) de Albert Adrià. Combinación perfecta de dos culturas culinarias.',
            'imagen' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800',
            'ubicacion' => 'Carrer de Lleida, 5, Barcelona',
            'precio' => 85,
            'cheff' => 'Albert Adrià y Jorge Muñoz',
            'menu' => 'Nikkei: Ceviche, Tiradito, Anticuchos, Sushi rolls peruanos',
            'estado' => true,
            'id_tipo' => \App\Models\Tipo::where('nombre', 'Peruano')->first()->id,
        ]);

        Restaurante::create([
            'titulo' => 'Gresca',
            'descripcion' => 'Bistró moderno con cocina de mercado. Ambiente acogedor y platos creativos con producto local.',
            'imagen' => 'https://images.unsplash.com/photo-1424847651672-bf20a4b0982b?w=800',
            'ubicacion' => 'Carrer de Provença, 230, Barcelona',
            'precio' => 50,
            'cheff' => 'Rafa Peña',
            'menu' => 'Menú mercado: Carpaccio, Risotto, Lubina, Tarta de queso',
            'estado' => true,
            'id_tipo' => $tipoMediterraneo->id,
        ]);
    }
}
