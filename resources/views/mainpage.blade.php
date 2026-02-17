@extends('components.restaurant')

@section('title', 'TheFork | Restaurantes')

@section('contenido')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
<section class="py-10 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="max-w-[1300px] mx-auto px-4">
        
        {{-- Encabezado --}}
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2">Restaurantes disponibles</h1>
            <p class="text-gray-500 text-base">Explora los mejores lugares para comer según nuestra comunidad.</p>
        </div>

        {{-- Lista de restaurantes --}}
        <div class="max-w-[900px] space-y-6" id="restaurantList">
            
            @foreach($restaurantes as $restaurante)
            <div class="restaurant-card bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden flex flex-col md:flex-row h-auto hover:shadow-xl hover:scale-[1.02] transition-all duration-300"
                 data-titulo="{{ strtolower($restaurante->titulo) }}"
                 data-ubicacion="{{ strtolower($restaurante->ubicacion) }}"
                 data-cheff="{{ strtolower($restaurante->cheff) }}"
                 data-precio="{{ $restaurante->precio }}">
                
                {{-- Imagen --}}
                <div class="md:w-2/5 relative overflow-hidden">
                    <img src="{{ asset($restaurante->imagen) }}" 
                         alt="{{ $restaurante->titulo }}" 
                         class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-black text-[#006252] shadow-lg uppercase flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Destacado
                        </span>
                    </div>

                    {{-- Badge de oferta --}}
                    <div class="absolute bottom-4 right-4">
                        <span class="bg-red-500 text-white px-3 py-1.5 rounded-full text-xs font-black shadow-lg">
                            -30% OFF
                        </span>
                    </div>
                </div>

                {{-- Contenido --}}
                <div class="md:w-3/5 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <h3 class="text-2xl font-black text-gray-900 leading-tight hover:text-[#006252] transition">
                                    {{ $restaurante->titulo }}
                                </h3>
                                <div class="flex items-center gap-2 mt-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 font-medium">
                                        {{ $restaurante->ubicacion }}
                                    </p>
                                </div>
                                
                                <div class="flex items-center gap-4 mt-3">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span class="text-xs text-gray-500">Chef: <span class="font-bold text-gray-700">{{ $restaurante->cheff }}</span></span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-xs text-gray-500">Precio medio: <span class="font-black text-[#006252] text-base">{{ $restaurante->precio }}€</span></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Rating --}}
                            <div class="text-center bg-gradient-to-br from-[#006252] to-[#004d40] px-4 py-3 rounded-2xl shadow-lg">
                                <span class="text-white text-2xl font-black block">9.{{ rand(0, 9) }}</span>
                                <div class="flex gap-0.5 mt-1">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    @endfor
                                </div>
                                <span class="text-[10px] text-white/80 font-semibold uppercase mt-1 block">
                                    {{ rand(50, 500) }} reviews
                                </span>
                            </div>
                        </div>

                        {{-- Tags --}}
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-[#e6f6f4] to-[#d0f0ed] text-[#006252] px-3 py-1.5 rounded-lg text-xs font-black shadow-sm">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                                </svg>
                                -30% en carta
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                </svg>
                                Disponible hoy
                            </span>
                        </div>
                        
                        {{-- Menú destacado con opción de expandir --}}
                        <div class="mt-4 bg-gray-50 rounded-xl p-3 border-l-4 border-[#006252]">
                            <div class="menu-container">
                                {{-- Texto del menú con ID único --}}
                                <p class="menu-text text-sm italic text-gray-600 font-medium leading-relaxed line-clamp-2" id="menu-{{ $restaurante->id }}">
                                    "{{ $restaurante->menu }}"
                                </p>
                                
                                {{-- Botón "Ver más" / "Ver menos" --}}
                                @if(strlen($restaurante->menu) > 100)
                                <button class="toggle-menu mt-2 text-xs font-bold text-[#006252] hover:text-[#004d40] transition flex items-center gap-1" data-menu-id="menu-{{ $restaurante->id }}">
                                    <span class="toggle-text">Ver más</span>
                                    <svg class="w-3 h-3 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Botón de reserva --}}
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <button 
                            data-btn-reservar
                            data-id="{{ $restaurante->id }}"
                            data-titulo="{{ $restaurante->titulo }}"
                            class="flex-1 bg-gradient-to-r from-[#006252] to-[#004d40] text-white px-6 py-3 rounded-xl font-black text-sm hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Reservar Mesa
                        </button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Mensaje si no hay restaurantes --}}
            @if($restaurantes->isEmpty())
                <div class="bg-white p-16 text-center rounded-2xl border-2 border-dashed border-gray-300 shadow-inner">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <p class="text-gray-500 font-bold text-lg mb-3">No hay restaurantes registrados todavía.</p>
                    <a href="{{ route('crear.restaurante') }}" class="inline-block bg-[#006252] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#004d40] transition">
                        ¡Añade el primer restaurante!
                    </a>
                </div>
            @endif

        </div>
    </div>

    {{-- Modal de reserva y reseñas --}}
    <div id="modal-restaurante-detail" class="hidden fixed inset-0 z-[99999] flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col">
            
            <div class="bg-[#006252] px-6 py-4 flex justify-between items-center rounded-t-2xl">
                <h3 id="modal-rest-titulo" class="text-white font-black text-xl"></h3>
                <button id="btn-cerrar-modal-rest" class="text-white text-2xl">&times;</button>
            </div>

            <div class="flex border-b">
                <button id="tab-reserva" class="flex-1 px-4 py-3 text-sm font-bold border-b-2 border-[#006252]">Reservar</button>
                <button id="tab-resena" class="flex-1 px-4 py-3 text-sm border-b-2 border-transparent text-gray-500">Reseña</button>
            </div>

            <div class="overflow-y-auto flex-1">
                <input type="hidden" id="modal-rest-id">

                <div id="content-reserva" class="p-6">
                    <form id="form-reserva" class="space-y-4">
                        <div id="error-reserva" class="hidden bg-red-100 text-red-600 p-3 rounded-lg text-sm"></div>
                        
                        @guest
                        <p class="bg-yellow-100 p-3 rounded-lg text-sm">Debes <a href="{{ route('login') }}" class="underline font-bold">iniciar sesión</a></p>
                        @endguest

                        <div>
                            <label class="block text-sm font-bold mb-2">Nombre</label>
                            <input value="{{ auth()->user()->name ?? '' }}" disabled class="w-full border rounded-lg px-4 py-2 bg-gray-50">
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Fecha y hora</label>
                            <input id="reserva-fecha-hora" type="datetime-local" required class="w-full border rounded-lg px-4 py-2" {{ auth()->guest() ? 'disabled' : '' }}>
                        </div>

                        <button id="btn-reservar" type="submit" class="w-full bg-[#006252] text-white font-bold py-3 rounded-xl" {{ auth()->guest() ? 'disabled' : '' }}>
                            Reservar ahora
                        </button>
                    </form>
                </div>

                <div id="content-resena" class="p-6 hidden">
                    <form id="form-resena" class="space-y-4 mb-6 pb-6 border-b">
                        <div id="error-resena" class="hidden bg-red-100 text-red-600 p-3 rounded-lg text-sm"></div>
                        
                        @guest
                        <p class="bg-yellow-100 p-3 rounded-lg text-sm">Debes <a href="{{ route('login') }}" class="underline font-bold">iniciar sesión</a></p>
                        @endguest

                        <div>
                            <label class="block text-sm font-bold mb-2">Puntuación (0-10)</label>
                            <input id="resena-puntuacion" type="number" min="0" max="10" required class="w-full border rounded-lg px-4 py-2" {{ auth()->guest() ? 'disabled' : '' }}>
                        </div>

                        <div>
                            <label class="block text-sm font-bold mb-2">Comentario</label>
                            <textarea id="resena-comentario" rows="4" required class="w-full border rounded-lg px-4 py-2 resize-none" {{ auth()->guest() ? 'disabled' : '' }}></textarea>
                        </div>

                        <button id="btn-enviar-resena" type="submit" class="w-full bg-[#006252] text-white font-bold py-3 rounded-xl" {{ auth()->guest() ? 'disabled' : '' }}>
                            Publicar reseña
                        </button>
                    </form>

                    <div>
                        <h4 class="text-sm font-bold mb-4">Todas las reseñas</h4>
                        <div id="lista-resenas" class="space-y-4 max-h-64 overflow-y-auto"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>

<script src="{{ asset('js/menu_expandible.js') }}"></script>
<script src="{{ asset('js/restaurante_modal.js') }}"></script>
<script src="{{ asset('js/filtros_restaurantes.js') }}"></script>

@endsection