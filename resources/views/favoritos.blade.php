@extends('components.home')

@section('title', 'TheFork | Mis Restaurantes Favoritos')

@section('contenido')

{{-- PÁGINA DE FAVORITOS --}}
<div class="container mx-auto px-4 py-12 max-w-7xl">
    
    {{-- ENCABEZADO --}}
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-2">
            Mis Restaurantes Favoritos ❤️
        </h1>
        <p class="text-gray-600 text-lg">
            Aquí están todos los restaurantes que te gustan
        </p>
    </div>

    {{-- VERIFICAR SI HAY RESTAURANTES FAVORITOS --}}
    @if($favoritos->count() > 0)
        
        {{-- GRID DE RESTAURANTES FAVORITOS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            
            @foreach($favoritos as $like)
                {{-- 
                    $like es un objeto Like que tiene:
                    - $like->id: ID del like
                    - $like->restaurante: Objeto del restaurante relacionado (eager loading)
                    - $like->created_at: Fecha en que se dio el like
                --}}
                
                @php
                    $restaurante = $like->restaurante;  // Obtener el restaurante del like
               @endphp
                
                {{-- CARD DEL RESTAURANTE --}}
                <div class="group border border-gray-200 rounded-xl p-2 transition hover:shadow-lg">
                    
                    {{-- IMAGEN DEL RESTAURANTE --}}
                    <div class="relative aspect-[4/3] rounded-lg overflow-hidden mb-3">
                        @if($restaurante->imagen)
                            <img src="{{ asset($restaurante->imagen) }}" 
                                 alt="{{ $restaurante->titulo }}"
                                 class="w-full h-full object-cover">
                        @else
                            {{-- Imagen placeholder si no tiene --}}
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-4xl">🍽️</span>
                            </div>
                        @endif
                        
                        {{-- BOTÓN PARA QUITAR DE FAVORITOS --}}
                        <button 
                            onclick="toggleLike({{ $restaurante->id }}, this)"
                            class="absolute top-2 right-2 bg-white/90 hover:bg-white p-2 rounded-full shadow-lg transition hover:scale-110"
                            title="Quitar de favoritos">
                            <span class="text-2xl">❤️</span>
                        </button>
                    </div>
                    
                    {{-- INFORMACIÓN DEL RESTAURANTE --}}
                    <div class="space-y-2">
                        <h3 class="font-bold text-gray-900 text-lg truncate">
                            {{ $restaurante->titulo }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm line-clamp-2">
                            {{ $restaurante->descripcion }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-[#006252] font-bold">
                                {{ $restaurante->precio }}€
                            </span>
                            
                            <span class="text-xs text-gray-500">
                                {{ $restaurante->tipo->nombre ?? 'Sin tipo' }}
                            </span>
                        </div>
                        
                        {{-- FECHA EN QUE SE AGREGÓ A FAVORITOS --}}
                        <p class="text-xs text-gray-400">
                            ❤️ Desde {{ $like->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    
                </div>
            @endforeach
            
        </div>
        
    @else
        
        {{-- MENSAJE CUANDO NO HAY FAVORITOS --}}
        <div class="text-center py-16">
            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                <span class="text-6xl">🤍</span>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-2">
                Aún no tienes restaurantes favoritos
            </h2>
            
            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                Explora nuestros restaurantes y haz click en el corazón para guardarlos como favoritos
            </p>
            
            <a href="{{ route('home') }}" 
               class="inline-block bg-[#006252] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#00473d] transition">
                Explorar Restaurantes
            </a>
        </div>
        
    @endif
    
</div>

{{-- JAVASCRIPT PARA EL SISTEMA DE LIKES (mismo código que en index) --}}
<script>
    /**
     * FUNCIÓN: Toggle Like (Dar/Quitar Like)
     * 
     * Esta función se usa para quitar restaurantes de favoritos.
     * Cuando se quita un like desde esta página, recargamos para actualizar la lista.
     */
    function toggleLike(restauranteId, button) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/restaurantes/${restauranteId}/toggle-like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cuando se quita un like desde favoritos, recargar la página
                // para actualizar la lista de restaurantes
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error al quitar de favoritos:', error);
            alert('Hubo un error. Por favor intenta de nuevo.');
        });
    }
</script>

@endsection
