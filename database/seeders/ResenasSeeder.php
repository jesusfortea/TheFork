<?php

namespace Database\Seeders;

use App\Models\Resena;
use App\Models\Restaurante;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResenasSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener usuarios (excepto admin)
        $usuarios = User::where('email', '!=', 'admin@gmail.com')->pluck('id')->toArray();
        
        if (empty($usuarios)) {
            $this->command->warn('No hay usuarios disponibles para asignar a las reseñas');
            return;
        }

        $resenas = [
            'Moments - Hotel Mandarin Oriental' => [
                ['comentario' => 'Una experiencia gastronómica sublime. La cocina de Ruscalleda es pura poesía en el plato.', 'puntuacion' => 10],
                ['comentario' => 'Servicio impecable y sabores que no olvidarás. Merece cada una de sus estrellas Michelin.', 'puntuacion' => 9],
                ['comentario' => 'Increíble menú degustación. El foie gras estaba en otro nivel. Precio elevado pero justificado.', 'puntuacion' => 9],
                ['comentario' => 'Alta cocina en su máxima expresión. El ambiente del Mandarin le añade un plus especial.', 'puntuacion' => 10],
            ],
            'Disfrutar' => [
                ['comentario' => 'Sin duda el restaurante más creativo que he visitado. Cada plato es una sorpresa.', 'puntuacion' => 10],
                ['comentario' => 'Digno sucesor del espíritu de elBulli. Los panchinos son una obra maestra.', 'puntuacion' => 10],
                ['comentario' => 'Experiencia única, aunque el ritmo del servicio podría ser algo más ágil.', 'puntuacion' => 8],
                ['comentario' => 'La gamba roja era perfecta. Un menú que desafía todos los sentidos.', 'puntuacion' => 9],
            ],
            'Koy Shunka' => [
                ['comentario' => 'El mejor japonés de Barcelona sin ninguna duda. El omakase es una experiencia única.', 'puntuacion' => 10],
                ['comentario' => 'Producto fresco y técnica impecable. Hideki es un maestro del sushi.', 'puntuacion' => 9],
                ['comentario' => 'Muy bueno, pero el espacio es algo pequeño y las mesas están muy juntas.', 'puntuacion' => 8],
                ['comentario' => 'El sashimi de atún se deshacía en la boca. Volveré siempre que pueda.', 'puntuacion' => 10],
            ],
            'Cinc Sentits' => [
                ['comentario' => 'Cocina catalana honesta y deliciosa. El bacalao negro era extraordinario.', 'puntuacion' => 9],
                ['comentario' => 'Trato cercano y profesional. Un restaurante que cuida cada detalle.', 'puntuacion' => 9],
                ['comentario' => 'Las texturas de chocolate del postre son lo mejor que he comido en mucho tiempo.', 'puntuacion' => 10],
                ['comentario' => 'Excelente relación calidad-precio para el nivel de cocina que ofrecen.', 'puntuacion' => 8],
            ],
            'Alkimia' => [
                ['comentario' => 'Jordi Vilà consigue que la tradición catalana suene a futuro. Memorable.', 'puntuacion' => 9],
                ['comentario' => 'Las espardenyes estaban en su punto exacto. Cocina técnica sin perder la esencia.', 'puntuacion' => 9],
                ['comentario' => 'Muy buen nivel, aunque la sala es algo fría en decoración.', 'puntuacion' => 7],
                ['comentario' => 'El pichón era una delicia. Servicio atento y muy bien informado.', 'puntuacion' => 10],
            ],
            'Lasarte' => [
                ['comentario' => 'Tres estrellas muy bien merecidas. La mejor comida de mi vida, sin exagerar.', 'puntuacion' => 10],
                ['comentario' => 'Berasategui al máximo nivel. Las ostras y la lubina salvaje eran perfectas.', 'puntuacion' => 10],
                ['comentario' => 'Experiencia de lujo en todos los sentidos. El maridaje de vinos es excepcional.', 'puntuacion' => 9],
                ['comentario' => 'Para ocasiones muy especiales. El precio es alto pero la experiencia no tiene precio.', 'puntuacion' => 9],
            ],
            'Cervecería Catalana' => [
                ['comentario' => 'Las mejores croquetas de Barcelona. Siempre lleno pero siempre vale la pena esperar.', 'puntuacion' => 9],
                ['comentario' => 'Tapas de calidad a buen precio. El pulpo a la gallega estaba genial.', 'puntuacion' => 8],
                ['comentario' => 'La espera puede ser larga, pero el producto lo justifica. Imprescindible en Barcelona.', 'puntuacion' => 8],
                ['comentario' => 'Clásico que nunca falla. Las patatas bravas son adictivas.', 'puntuacion' => 9],
            ],
            'El Nacional' => [
                ['comentario' => 'El espacio es espectacular. Cuatro propuestas distintas bajo un techo modernista increíble.', 'puntuacion' => 8],
                ['comentario' => 'La paella estaba muy bien. Perfecto para grupos grandes con gustos variados.', 'puntuacion' => 7],
                ['comentario' => 'Buen ambiente, aunque en hora punta el servicio se resiente un poco.', 'puntuacion' => 7],
                ['comentario' => 'Los mariscos son de primera. El ambiente lo convierte en una experiencia completa.', 'puntuacion' => 8],
            ],
            'Restaurante 7 Portes' => [
                ['comentario' => 'Un clásico de Barcelona desde 1836. El arroz negro es de los mejores que he probado.', 'puntuacion' => 9],
                ['comentario' => 'Historia y sabor en cada plato. La crema catalana casera es imprescindible.', 'puntuacion' => 9],
                ['comentario' => 'Ambiente elegante y cocina tradicional honesta. Un imprescindible de la ciudad.', 'puntuacion' => 8],
                ['comentario' => 'La paella era correcta pero esperaba algo más especial dado su fama histórica.', 'puntuacion' => 7],
            ],
            'Tickets Bar' => [
                ['comentario' => 'Las aceitunas esféricas siguen siendo mágicas. Albert Adrià es un genio de las tapas.', 'puntuacion' => 10],
                ['comentario' => 'Difícil conseguir reserva pero totalmente justificado. Cada bocado es una experiencia.', 'puntuacion' => 9],
                ['comentario' => 'El air baguette es sencillamente increíble. Cocina lúdica en su máxima expresión.', 'puntuacion' => 10],
                ['comentario' => 'Muy divertido y delicioso. El ambiente informal encaja perfectamente con la propuesta.', 'puntuacion' => 8],
            ],
            'La Paradeta' => [
                ['comentario' => 'Concepto brillante. Eliges tu marisco fresco y te lo hacen al momento. Impecable.', 'puntuacion' => 9],
                ['comentario' => 'Las gambas estaban buenísimas y a un precio muy razonable para la calidad.', 'puntuacion' => 8],
                ['comentario' => 'Puede haber cola en fines de semana pero merece la pena. Producto muy fresco.', 'puntuacion' => 8],
                ['comentario' => 'Lugar diferente y honesto. Los mejillones eran de primera. Repetiré seguro.', 'puntuacion' => 9],
            ],
            'Cal Pep' => [
                ['comentario' => 'Una institución en el Born. Los chipirones y las gambas al ajillo son espectaculares.', 'puntuacion' => 10],
                ['comentario' => 'Pep es un anfitrión único. Cocina de mercado sencilla pero perfectamente ejecutada.', 'puntuacion' => 9],
                ['comentario' => 'La tortilla de patatas es de las mejores que he comido. Un clásico imperdible.', 'puntuacion' => 9],
                ['comentario' => 'Siempre lleno y con razón. Producto fresco y trato inmejorable.', 'puntuacion' => 8],
            ],
            'Dos Palillos' => [
                ['comentario' => 'La fusión asiática más interesante de Barcelona. Las gyozas son perfectas.', 'puntuacion' => 9],
                ['comentario' => 'Raurich tiene una visión única de la cocina asiática. El ramen creativo sorprende.', 'puntuacion' => 9],
                ['comentario' => 'Muy buen nivel técnico. Los bao buns estaban increíbles. Espacio algo pequeño.', 'puntuacion' => 8],
                ['comentario' => 'Estrella Michelin muy merecida. Una propuesta valiente y deliciosa.', 'puntuacion' => 10],
            ],
            'Pakta' => [
                ['comentario' => 'La fusión nikkei mejor ejecutada que he probado fuera de Lima. El ceviche es sublime.', 'puntuacion' => 10],
                ['comentario' => 'Los tiraditos son increíbles. Albert Adrià y Jorge Muñoz forman un equipo brillante.', 'puntuacion' => 9],
                ['comentario' => 'Propuesta muy original. Los anticuchos estaban en su punto exacto.', 'puntuacion' => 9],
                ['comentario' => 'Los sushi rolls peruanos son una maravilla. Experiencia diferente y muy recomendable.', 'puntuacion' => 8],
            ],
            'Gresca' => [
                ['comentario' => 'El bistró moderno que Barcelona necesitaba. El risotto era cremoso y perfecto.', 'puntuacion' => 9],
                ['comentario' => 'Rafa Peña cocina con producto local de temporada de manera magistral.', 'puntuacion' => 9],
                ['comentario' => 'La tarta de queso es de las mejores que he probado. Ambiente muy acogedor.', 'puntuacion' => 8],
                ['comentario' => 'Menú de mercado cambiante y siempre sorprendente. Una joya del Eixample.', 'puntuacion' => 9],
            ],
        ];

        foreach ($resenas as $tituloRestaurante => $comentarios) {
            $restaurante = Restaurante::where('titulo', $tituloRestaurante)->first();

            if (!$restaurante) continue;

            foreach ($comentarios as $resena) {
                Resena::create([
                    'comentario'      => $resena['comentario'],
                    'puntuacion'      => $resena['puntuacion'],
                    'id_restaurante'  => $restaurante->id,
                    'id_user'         => $usuarios[array_rand($usuarios)], // Usuario aleatorio
                ]);
            }
        }
    }
}