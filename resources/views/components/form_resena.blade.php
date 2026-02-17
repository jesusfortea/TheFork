{{-- 
    Formulario de Reseña para Restaurante
    Este componente está diseñado para ser insertado dentro de un modal/popup
    Uso: Incluir este archivo donde se necesite el formulario
--}}

<div class="bg-white rounded-xl p-6 max-w-2xl mx-auto">
    
    {{-- Encabezado del formulario --}}
    <div class="text-center mb-6">
        <h3 class="text-2xl font-bold text-teal-900 mb-2">
            ✍️ Escribe tu Reseña
        </h3>
        <p class="text-gray-600 text-sm">
            Comparte tu experiencia y ayuda a otros comensales
        </p>
    </div>

    {{-- Formulario --}}
    <form id="form-resena" action="{{ route('resena.store') }}" method="POST" class="space-y-6">
        @csrf
        
        {{-- Campo oculto para ID del restaurante (será rellenado dinámicamente) --}}
        <input type="hidden" name="id_restaurante" id="id_restaurante" value="">

        {{-- Sistema de puntuación con estrellas --}}
        <div class="text-center">
            <label class="block text-sm font-bold text-gray-800 mb-3">
                ⭐ Calificación
            </label>
            
            {{-- Contenedor de estrellas --}}
            <div class="flex justify-center gap-2 mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" 
                            class="estrella text-4xl transition-all duration-200 hover:scale-110 focus:outline-none"
                            data-value="{{ $i }}"
                            onclick="seleccionarPuntuacion({{ $i }})">
                        <span class="estrella-vacia">☆</span>
                        <span class="estrella-llena hidden">★</span>
                    </button>
                @endfor
            </div>
            
            {{-- Input oculto para la puntuación --}}
            <input type="hidden" name="puntuacion" id="puntuacion" value="" required>
            
            {{-- Texto de puntuación seleccionada --}}
            <p id="texto-puntuacion" class="text-sm text-gray-500 mt-2 min-h-[20px]">
                Selecciona una calificación
            </p>
            
            {{-- Mensaje de error de validación --}}
            @error('puntuacion')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Separador --}}
        <div class="border-t border-gray-200"></div>

        {{-- Área de texto para el comentario --}}
        <div>
            <label for="comentario" class="block text-sm font-bold text-gray-800 mb-2">
                💬 Tu Comentario
            </label>
            <textarea 
                id="comentario" 
                name="comentario" 
                rows="5" 
                maxlength="500"
                placeholder="Cuéntanos sobre tu experiencia... ¿Qué tal la comida? ¿Y el servicio? ¿Volverías?"
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition resize-none"
                required></textarea>
            
            {{-- Contador de caracteres --}}
            <div class="flex justify-between items-center mt-2">
                <p class="text-xs text-gray-500">
                    Mínimo 20 caracteres
                </p>
                <p class="text-xs text-gray-500">
                    <span id="contador-caracteres">0</span>/500
                </p>
            </div>
            
            @error('comentario')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Separador --}}
        <div class="border-t border-gray-200"></div>

        {{-- Información adicional --}}
        <div class="bg-teal-50 border border-teal-200 rounded-lg p-4">
            <p class="text-sm text-teal-900">
                <strong>📝 Consejos para una buena reseña:</strong>
            </p>
            <ul class="text-xs text-teal-800 mt-2 space-y-1 ml-4 list-disc">
                <li>Sé específico sobre los platos que probaste</li>
                <li>Menciona el ambiente y el servicio</li>
                <li>Indica si lo recomendarías y por qué</li>
            </ul>
        </div>

        {{-- Botones de acción --}}
        <div class="flex gap-3 pt-2">
            <button 
                type="submit" 
                class="flex-1 bg-teal-900 hover:bg-teal-800 text-white font-bold py-3 px-6 rounded-lg transition shadow-md hover:shadow-lg transform hover:scale-105 duration-200">
                ✅ Publicar Reseña
            </button>
            
            <button 
                type="button" 
                onclick="cerrarModal()"
                class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                ❌ Cancelar
            </button>
        </div>
    </form>

</div>

{{-- Estilos específicos para las estrellas --}}
<style>
    .estrella {
        color: #d1d5db; /* Gray-300 por defecto */
        cursor: pointer;
    }
    
    .estrella:hover,
    .estrella.activa {
        color: #f59e0b; /* Amarillo/Ámbar */
    }
    
    .estrella .estrella-vacia {
        display: inline;
    }
    
    .estrella .estrella-llena {
        display: none;
        color: #f59e0b;
    }
    
    .estrella.activa .estrella-vacia {
        display: none;
    }
    
    .estrella.activa .estrella-llena {
        display: inline;
    }
</style>

{{-- JavaScript para funcionalidad interactiva --}}
<script>
    // Variable para almacenar la puntuación seleccionada
    let puntuacionSeleccionada = 0;
    
    // Textos descriptivos para cada puntuación
    const textosPuntuacion = {
        1: '⭐ Muy malo - No lo recomendaría',
        2: '⭐⭐ Malo - Necesita mejorar mucho',
        3: '⭐⭐⭐ Regular - Experiencia aceptable',
        4: '⭐⭐⭐⭐ Bueno - Lo recomendaría',
        5: '⭐⭐⭐⭐⭐ Excelente - ¡Increíble experiencia!'
    };
    
    /**
     * Función para seleccionar la puntuación
     */
    function seleccionarPuntuacion(valor) {
        puntuacionSeleccionada = valor;
        document.getElementById('puntuacion').value = valor;
        
        // Actualizar visualización de estrellas
        const estrellas = document.querySelectorAll('.estrella');
        estrellas.forEach((estrella, index) => {
            if (index < valor) {
                estrella.classList.add('activa');
            } else {
                estrella.classList.remove('activa');
            }
        });
        
        // Actualizar texto descriptivo
        document.getElementById('texto-puntuacion').textContent = textosPuntuacion[valor];
    }
    
    /**
     * Hover effect en estrellas
     */
    document.querySelectorAll('.estrella').forEach((estrella, index) => {
        estrella.addEventListener('mouseenter', () => {
            const valor = index + 1;
            document.querySelectorAll('.estrella').forEach((e, i) => {
                if (i < valor && !e.classList.contains('activa')) {
                    e.style.color = '#fbbf24'; // Amarillo claro en hover
                }
            });
        });
        
        estrella.addEventListener('mouseleave', () => {
            document.querySelectorAll('.estrella').forEach((e) => {
                if (!e.classList.contains('activa')) {
                    e.style.color = '#d1d5db'; // Volver a gris
                }
            });
        });
    });
    
    /**
     * Contador de caracteres del comentario
     */
    const comentarioTextarea = document.getElementById('comentario');
    const contadorCaracteres = document.getElementById('contador-caracteres');
    
    if (comentarioTextarea && contadorCaracteres) {
        comentarioTextarea.addEventListener('input', function() {
            const caracteres = this.value.length;
            contadorCaracteres.textContent = caracteres;
            
            // Cambiar color si está cerca del límite
            if (caracteres >= 480) {
                contadorCaracteres.classList.add('text-red-600', 'font-bold');
            } else {
                contadorCaracteres.classList.remove('text-red-600', 'font-bold');
            }
        });
    }
    
    /**
     * Validación antes de enviar el formulario
     */
    document.getElementById('form-resena').addEventListener('submit', function(e) {
        const puntuacion = document.getElementById('puntuacion').value;
        const comentario = document.getElementById('comentario').value;
        
        // Validar puntuación
        if (!puntuacion || puntuacion < 1 || puntuacion > 5) {
            e.preventDefault();
            alert('⭐ Por favor, selecciona una calificación');
            return false;
        }
        
        // Validar longitud mínima del comentario
        if (comentario.trim().length < 20) {
            e.preventDefault();
            alert('💬 El comentario debe tener al menos 20 caracteres');
            return false;
        }
        
        // Si todo está bien, se puede enviar
        return true;
    });
    
    /**
     * Función para cerrar el modal (debe ser implementada por tu compañero)
     */
    function cerrarModal() {
        // Tu compañero debe implementar esta función en su popup
        // Por ejemplo: document.getElementById('modal-resena').classList.add('hidden');
        console.log('Cerrar modal - Implementar por el compañero');
    }
    
    /**
     * Función para establecer el ID del restaurante (llamar desde el popup)
     * Ejemplo de uso: setRestauranteId(5);
     */
    function setRestauranteId(id) {
        document.getElementById('id_restaurante').value = id;
    }
</script>
