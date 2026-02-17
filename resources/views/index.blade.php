@extends('components.home')

@section('title', 'TheFork | Restaurantes')
@section('contenido')
    
    {{-- ¡EMPEZAR CODIGO DESDE AQUI! ---}}

    {{-- SECCIÓN HERO - Optimizada para todos los dispositivos --}}
    <div class="relative w-full h-[200px] sm:h-[250px] md:h-[320px] lg:h-[380px] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1500&q=80');">
        <div class="absolute inset-0 bg-black/40 flex flex-col justify-center items-center text-center px-4">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-white mb-3 md:mb-4 tracking-tight drop-shadow-md">
                ¿Qué te apetece hoy?
            </h1>
            <p class="text-white text-base md:text-lg lg:text-xl font-medium drop-shadow-md">Descubre y reserva el mejor restaurante</p>
        </div>
    </div>

{{-- SECCIÓN: EXPLORA POR TIPO DE COCINA --}}
    <div class="max-w-[1300px] mx-auto px-3 sm:px-4 md:px-6 -mt-8 sm:-mt-10 relative z-20">
        
        <div class="bg-white rounded-xl shadow-lg border p-4 sm:p-6">
            
            <div class="flex overflow-x-auto gap-12 pb-4 no-scrollbar scroll-smooth">
                
                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Italiano</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Japonés</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1544124499-58912cbddaad?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Mediterráneo</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Burgers</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Mexicano</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1564671165093-20688ff1fffa?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Español</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1525755662778-989d0524087e?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Chino</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Arroces</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Indio</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=200" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Americano</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Saludable</span>
                </div>

                <div class="flex flex-col items-center min-w-[100px] cursor-pointer group">
                    <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?w=150" class="w-16 h-16 rounded-full object-cover border-2 border-transparent group-hover:border-[#006252] transition shadow-sm">
                    <span class="text-xs font-bold mt-2 text-gray-700 uppercase">Postres</span>
                </div>

            </div>

            <div class="text-center mt-4 border-t pt-2">
                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] animate-pulse">Desliza para explorar</span>
            </div>

        </div>
    </div>

{{-- SECCIÓN: RESTAURANTES POPULARES CON LÓGICA DE BLOQUEO --}}
    <section class="py-12 bg-white">

        <div class="max-w-[1300px] mx-auto px-4 sm:px-6 lg:px-8">
        
            <div class="flex justify-between items-end mb-8">
        
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">Los más buscados en tu zona</h2>
                    <p class="text-gray-500 mt-1">Reserva mesa en los mejores restaurantes</p>
                </div>
        
            </div>

            <div class="relative">
                {{-- Contenedor de las Cards - Responsive Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 @guest blur-md select-none pointer-events-none @endguest">
                    
                    {{-- 
                        CARGA AUTOMÁTICA DE RESTAURANTES DESDE LA BASE DE DATOS
                        El controlador pasa la variable $restaurantes con todos los restaurantes activos
                    --}}
                    @foreach($restaurantes as $restaurante)
                    <div class="group border border-gray-100 rounded-xl p-2 transition hover:shadow-lg">
        
                        <div class="relative aspect-[4/3] rounded-xl overflow-hidden mb-3">
                            {{-- Imagen del restaurante --}}
                            @if($restaurante->imagen)
                                <img src="{{ asset($restaurante->imagen) }}" 
                                     alt="{{ $restaurante->titulo }}"
                                     class="w-full h-full object-cover">
                            @else
                                {{-- Imagen placeholder si no tiene --}}
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-6xl">🍽️</span>
                                </div>
                            @endif
                            
                            {{-- BOTÓN DE LIKE (CORAZÓN) - Solo visible para usuarios autenticados --}}
                            @auth
                                @php
                                    // CARGA AUTOMÁTICA DEL ESTADO DEL LIKE
                                    // Verificar si el usuario autenticado ya dio like a este restaurante
                                    // Buscar en la tabla 'likes' si existe un registro con:
                                    // - id_user = ID del usuario logueado
                                    // - id_restaurante = ID del restaurante actual
                                    $usuarioLike = \App\Models\Like::where('id_user', auth()->id())
                                                                    ->where('id_restaurante', $restaurante->id)
                                                                    ->exists();
                                @endphp
                                <button 
                                    onclick="toggleLike({{ $restaurante->id }}, this)"
                                    class="absolute top-2 right-2 bg-white/90 hover:bg-white p-2 rounded-full shadow-lg transition hover:scale-110"
                                    title="{{ $usuarioLike ? 'Quitar de favoritos' : 'Agregar a favoritos' }}">
                                    <span class="text-2xl">
                                        {{-- Mostrar corazón rojo si ya tiene like, blanco si no --}}
                                        {{ $usuarioLike ? '❤️' : '🤍' }}
                                    </span>
                                </button>
                            @endauth
                        </div>
        
                        <div class="space-y-2">
                            {{-- Título y precio --}}
                            <div class="flex justify-between items-start gap-2">
                                <h3 class="font-bold text-gray-900 text-base line-clamp-1">
                                    {{ $restaurante->titulo }}
                                </h3>
                                <span class="bg-[#006252] text-white px-2 py-0.5 rounded text-sm font-bold whitespace-nowrap">
                                    {{ $restaurante->precio }}€
                                </span>
                            </div>
                            
                            {{-- Descripción --}}
                            <p class="text-gray-600 text-xs line-clamp-2">
                                {{ $restaurante->descripcion }}
                            </p>
                            
                            {{-- Tipo de cocina --}}
                            <p class="text-gray-500 text-xs">
                                <span class="font-semibold">{{ $restaurante->tipo->nombre ?? 'Sin tipo' }}</span>
                            </p>
                        </div>
        
                    </div>
                    @endforeach
        
                </div>

                {{-- Overlay de Contenido Bloqueado (Solo visible para invitados) --}}
                @guest
                <div class="absolute inset-0 z-20 flex items-center justify-center">
                    <div class="bg-white/90 backdrop-blur-sm border border-gray-200 p-8 rounded-2xl shadow-2xl text-center max-w-sm mx-4">
                    
                        <div class="w-16 h-16 bg-teal-100 text-[#006252] rounded-full flex items-center justify-center mx-auto mb-4">
                    
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                    
                        </div>
                    
                        <h3 class="text-xl font-black text-gray-900 mb-2">Contenido bloqueado</h3>
                    
                        <p class="text-gray-600 mb-6">Regístrate o inicia sesión para ver los precios, fotos reales y ofertas exclusivas de estos restaurantes.</p>
                    
                        <div class="space-y-3">
                    
                            <a href="/register" class="block w-full bg-[#006252] text-white font-bold py-3 rounded-lg hover:bg-[#00473d] transition">
                                Crear cuenta gratis
                    
                            </a>
                    
                            <a href="/login" class="block w-full text-[#006252] font-bold py-2 hover:underline transition text-sm">
                                Ya tengo cuenta, iniciar sesión
                    
                            </a>
                    
                        </div>
                    
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </section>


    {{-- SECCIÓN: CTA DE DESCARGA DE APP - Mejorado para mobile --}}
    <section class="pb-8 md:pb-16 mt-8 md:mt-16">
        <div class="max-w-[1300px] mx-auto px-4">
         
            <div class="bg-[#006252] rounded-2xl md:rounded-3xl p-6 sm:p-8 md:p-12 flex flex-col md:flex-row items-center gap-6 md:gap-8">
                
                <div class="md:w-2/3 text-center md:text-left">
         
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-white leading-tight">Come fuera con el 50% de descuento</h2>
                    <p class="text-white/80 text-base md:text-lg mt-3 md:mt-4 mb-6 md:mb-8">Reserva en la app y acumula Yums para canjear por comidas gratis.</p>
                    
                    <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-3 md:gap-4">
                        <button class="bg-black text-white px-6 sm:px-8 py-3 rounded-lg font-bold hover:bg-gray-900 transition w-full sm:w-auto">App Store</button>
                        <button class="bg-black text-white px-6 sm:px-8 py-3 rounded-lg font-bold hover:bg-gray-900 transition w-full sm:w-auto">Google Play</button>
                    </div>
         
                </div>

                <div class="md:w-1/3">
         
                    <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=400" class="w-32 sm:w-40 md:w-48 h-auto rounded-2xl md:rounded-3xl border-4 border-black mx-auto shadow-2xl">
         
                </div>

            </div>
        </div>
    </section>
    
    {{-- SECCIÓN: BENEFICIOS - Mejorado spacing mobile --}}
    <section class="py-10 md:py-16 bg-teal-50">
        <div class="container mx-auto px-4 max-w-6xl">
          
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 md:mb-12 text-center">
                ¿Por qué reservar con TheFork?
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
          
                <!-- Benefit 1 -->
                <div class="text-center">
          
                    <div class="w-20 h-20 bg-teal-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">🏷️</span>
                    </div>
          
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        Ofertas exclusivas
                    </h3>
          
                    <p class="text-gray-600">
                        Disfruta de descuentos de hasta el 50% en miles de restaurantes
                    </p>
          
                </div>

                <!-- Benefit 2 -->
                <div class="text-center">
          
                    <div class="w-20 h-20 bg-teal-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">🎁</span>
                    </div>
          
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        Gana Yums
                    </h3>
          
                    <p class="text-gray-600">
                        Acumula puntos con cada reserva y canjéalos por descuentos
                    </p>
          
                </div>

                <!-- Benefit 3 -->
                <div class="text-center">
          
                    <div class="w-20 h-20 bg-teal-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">📱</span>
                    </div>
          
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        Reserva fácil y rápida
                    </h3>
          
                    <p class="text-gray-600">
                        Confirma tu mesa en segundos desde tu móvil o ordenador
                    </p>
          
                </div>
            </div>
        </div>
    </section>


    <section class="bg-[#00473d] rounded-xl overflow-hidden flex flex-col md:flex-row items-center relative shadow-md">
        <div class="p-10 md:w-1/2 z-10">
        
            <div class="bg-[#f3a002] text-[#00473d] font-black text-xs inline-block px-2 py-1 rounded mb-4">FIDELIDAD</div>
        
            <h2 class="text-3xl font-black text-white mb-4">Programa de puntos Yums</h2>
        
            <p class="text-white/90 mb-6 text-lg">Acumula puntos con cada reserva. 1000 Yums equivalen a 10€ de descuento de fidelidad.</p>
        
            <div class="bg-white text-[#00473d] font-bold py-3 px-6 rounded-lg inline-block w-max text-center">
                Más información
            </div>
        
        </div>
        
        <div class="md:w-1/2 h-48 md:h-80 w-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=800&q=80');">
        
            <div class="w-full h-full bg-[#00473d]/40"></div>
        
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="py-12 bg-white">
       
        <div class="container mx-auto px-4 max-w-6xl">
       
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">
                Lo que dicen nuestros usuarios
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
       
                <!-- Review 1 -->
                <div class="bg-gray-50 rounded-xl p-6">
       
                    <div class="flex mb-4 text-xl">
                        ⭐⭐⭐⭐⭐
                    </div>
       
                    <p class="text-gray-700 mb-4">
                        "Una aplicación increíble. He descubierto restaurantes fantásticos y las ofertas son realmente buenas."
                    </p>
       
                    <div class="flex items-center">
       
                        <div class="w-12 h-12 bg-teal-700 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            MC
                        </div>
       
                        <div>
                            <div class="font-semibold text-gray-800">María Carmen</div>
                            <div class="text-sm text-gray-500">Madrid</div>
                        </div>
       
                    </div>
       
                </div>

                <!-- Review 2 -->
                <div class="bg-gray-50 rounded-xl p-6">
       
                    <div class="flex mb-4 text-xl">
                        ⭐⭐⭐⭐⭐
                    </div>
       
                    <p class="text-gray-700 mb-4">
                        "Reservar nunca había sido tan fácil. Me encanta poder ganar puntos con cada reserva."
                    </p>
       
                    <div class="flex items-center">
       
                        <div class="w-12 h-12 bg-teal-700 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            JL
                        </div>
       
                        <div>
                            <div class="font-semibold text-gray-800">Javier López</div>
                            <div class="text-sm text-gray-500">Barcelona</div>
                        </div>
       
                    </div>
                </div>

                <!-- Review 3 -->
                <div class="bg-gray-50 rounded-xl p-6">
       
                    <div class="flex mb-4 text-xl">
                        ⭐⭐⭐⭐⭐
                    </div>
       
                    <p class="text-gray-700 mb-4">
                        "Los descuentos son geniales y el proceso de reserva es súper rápido. Totalmente recomendable."
                    </p>
       
                    <div class="flex items-center">
       
                        <div class="w-12 h-12 bg-teal-700 rounded-full flex items-center justify-center text-white font-bold mr-3">
                            AG
                        </div>
       
                        <div>
                            <div class="font-semibold text-gray-800">Ana García</div>
                            <div class="text-sm text-gray-500">Valencia</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- JAVASCRIPT PARA EL SISTEMA DE LIKES --}}
    <script>
        /**
         * FUNCIÓN: Toggle Like (Dar/Quitar Like)
         * 
         * Esta función se ejecuta cuando el usuario hace click en el corazón.
         * Envía una petición AJAX al servidor para crear o eliminar el like.
         * 
         * @param {number} restauranteId - ID del restaurante
         * @param {HTMLElement} button - El botón que se clickeó (para cambiar el emoji)
         */
        function toggleLike(restauranteId, button) {
            // PASO 1: Obtener el CSRF token de Laravel (necesario para seguridad)
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // PASO 2: Hacer petición AJAX al servidor
            fetch(`/restaurantes/${restauranteId}/toggle-like`, {
                method: 'POST',  // Método HTTP POST
                headers: {
                    'Content-Type': 'application/json',  // Enviamos JSON
                    'X-CSRF-TOKEN': csrfToken             // Token de seguridad
                },
                body: JSON.stringify({})  // Cuerpo vacío (no necesitamos enviar datos extra)
            })
            .then(response => response.json())  // Convertir respuesta a JSON
            .then(data => {
                // PASO 3: Procesar la respuesta del servidor
                if (data.success) {
                    // ✅ ÉXITO: Cambiar el emoji del corazón según el nuevo estado
                    const heartSpan = button.querySelector('span');
                    
                    if (data.liked) {
                        // Usuario DIO LIKE → Mostrar corazón rojo
                        heartSpan.textContent = '❤️';
                        button.title = 'Quitar de favoritos';
                    } else {
                        // Usuario QUITÓ LIKE → Mostrar corazón blanco
                        heartSpan.textContent = '🤍';
                        button.title = 'Agregar a favoritos';
                    }
                    
                    // Pequeña animación de "pop" al hacer click
                    button.classList.add('scale-125');
                    setTimeout(() => {
                        button.classList.remove('scale-125');
                    }, 200);
                }
            })
            .catch(error => {
                // ❌ ERROR: Mostrar mensaje en consola
                console.error('Error al dar/quitar like:', error);
                alert('Hubo un error. Por favor intenta de nuevo.');
            });
        }
    </script>

@endsection