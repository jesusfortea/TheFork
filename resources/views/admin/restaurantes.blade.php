@extends('components.home')

@section('title', 'TheFork | Gestión de Restaurantes')
@section('contenido')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-gradient-to-br from-teal-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Cabecera --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
            <h2 class="text-3xl font-bold text-teal-900 mb-1">🍽️ Gestión de Restaurantes</h2>
            <p class="text-gray-500 text-sm">Administra todos los restaurantes del sistema</p>
        </div>

        {{-- ══════════════ BARRA DE FILTROS ══════════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-teal-900">🔍 Filtros de Búsqueda</h3>
                <button id="btn-limpiar-filtros-restaurantes" 
                        class="text-sm text-teal-700 hover:text-teal-900 font-semibold hover:underline transition">
                    🔄 Limpiar filtros
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                
                {{-- Buscar por título --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Buscar por título
                    </label>
                    <input 
                        type="text" 
                        id="filtro-titulo" 
                        placeholder="Ej: La Tasquita"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition">
                </div>

                {{-- Buscar por Chef --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Buscar por Chef
                    </label>
                    <input 
                        type="text" 
                        id="filtro-chef" 
                        placeholder="Ej: Gordon Ramsay"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition">
                </div>

                {{-- Filtrar por tipo --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Tipo de cocina
                    </label>
                    <select 
                        id="filtro-tipo"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                        <option value="">— Todos los tipos —</option>
                        @foreach(\App\Models\Tipo::orderBy('nombre')->get() as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtrar por estado --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Estado
                    </label>
                    <select 
                        id="filtro-estado"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                        <option value="">— Todos los estados —</option>
                        <option value="1">Aprobado</option>
                        <option value="0">Pendiente</option>
                    </select>
                </div>

                {{-- Filtrar por precio --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Rango de precio
                    </label>
                    <select 
                        id="filtro-precio"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                        <option value="">— Todos los precios —</option>
                        <option value="0-20">Económico (0-20€)</option>
                        <option value="20-40">Moderado (20-40€)</option>
                        <option value="40-60">Alto (40-60€)</option>
                        <option value="60-999">Premium (+60€)</option>
                    </select>
                </div>

                {{-- Filtrar por fecha --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Fecha de registro
                    </label>
                    <select 
                        id="filtro-fecha-restaurante"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                        <option value="">— Todas las fechas —</option>
                        <option value="hoy">Hoy</option>
                        <option value="ultima_semana">Última semana</option>
                        <option value="ultimo_mes">Último mes</option>
                        <option value="ultimo_trimestre">Último trimestre</option>
                        <option value="ultimo_año">Último año</option>
                    </select>
                </div>

            </div>

            {{-- Indicador de carga --}}
            <div id="indicador-carga-restaurantes" class="hidden mt-4 text-center">
                <div class="inline-flex items-center gap-2 text-teal-700">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold">Filtrando restaurantes...</span>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-teal-900 text-white px-6 py-4">
                <h3 class="text-base font-bold">
                    Lista de Restaurantes
                    (<span id="contador-restaurantes">{{ $restaurantes->count() }}</span>)
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Imagen</th>
                            <th class="px-6 py-3 text-left">Título</th>
                            <th class="px-6 py-3 text-left">Tipo</th>
                            <th class="px-6 py-3 text-left">Precio</th>
                            <th class="px-6 py-3 text-left">Estado</th>
                            <th class="px-6 py-3 text-left">Chef</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-restaurantes-body" class="divide-y divide-gray-100 text-sm">
                        @forelse($restaurantes as $restaurante)
                        <tr id="fila-restaurante-{{ $restaurante->id }}" class="hover:bg-gray-50 transition">

                            {{-- Campos ocultos para el modal --}}
                            <input type="hidden" data-ubicacion   value="{{ $restaurante->ubicacion }}">
                            <input type="hidden" data-precio      value="{{ $restaurante->precio }}">
                            <input type="hidden" data-cheff       value="{{ $restaurante->cheff }}">
                            <input type="hidden" data-descripcion value="{{ addslashes($restaurante->descripcion) }}">
                            <input type="hidden" data-menu        value="{{ addslashes($restaurante->menu) }}">
                            <input type="hidden" data-id-tipo     value="{{ $restaurante->id_tipo }}">
                            <input type="hidden" data-estado      value="{{ $restaurante->estado ? '1' : '0' }}">

                            <td class="px-6 py-4 text-gray-400 font-mono">#{{ $restaurante->id }}</td>
                            <td class="px-6 py-4">
                                @if($restaurante->imagen)
                                    <img src="{{ Str::startsWith($restaurante->imagen, 'http') ? $restaurante->imagen : asset($restaurante->imagen) }}"
                                         alt="{{ $restaurante->titulo }}"
                                         class="h-12 w-12 rounded-lg object-cover">
                                @else
                                    <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">Sin img</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900" data-titulo>{{ $restaurante->titulo }}</td>
                            <td class="px-6 py-4 text-gray-500" data-tipo-nombre>{{ $restaurante->tipo?->nombre ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-gray-700 font-medium" data-precio-display>{{ $restaurante->precio }}€</td>
                            <td class="px-6 py-4">
                                <span data-estado-badge class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $restaurante->estado ? 'bg-emerald-100 text-emerald-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $restaurante->estado ? 'Aprobado' : 'Pendiente' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500" data-cheff-display>{{ Str::limit($restaurante->cheff, 20) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button
                                        data-btn-editar-restaurante
                                        data-id="{{ $restaurante->id }}"
                                        class="bg-teal-700 hover:bg-teal-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        ✏️ Editar
                                    </button>
                                    <button
                                        data-btn-eliminar-restaurante
                                        data-id="{{ $restaurante->id }}"
                                        data-titulo="{{ $restaurante->titulo }}"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        🗑️ Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-400">No hay restaurantes registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- ══════════════ MODAL EDITAR ══════════════ --}}
<div id="modal-restaurante"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden max-h-[90vh] flex flex-col">

        {{-- Header --}}
        <div class="bg-teal-900 px-6 py-5 flex items-center justify-between shrink-0">
            <div>
                <h3 class="text-white font-bold text-lg">🍽️ Editar Restaurante</h3>
                <p class="text-teal-300 text-xs mt-0.5">Los cambios se aplican al instante</p>
            </div>
            <button id="btn-cerrar-modal-restaurante"
                    class="text-teal-300 hover:text-white transition text-2xl leading-none">&times;</button>
        </div>

        {{-- Cuerpo con scroll --}}
        <form id="form-editar-restaurante" class="p-6 space-y-4 overflow-y-auto" novalidate>
            <input type="hidden" id="modal-restaurante-id">

            <div id="modal-restaurante-error"
                 class="hidden bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg">
            </div>

            {{-- Título --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Título</label>
                <input id="modal-titulo" type="text"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition"
                       required>
            </div>

            {{-- Tipo + Estado --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Tipo de cocina</label>
                    <select id="modal-id-tipo"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                        <option value="">— Selecciona —</option>
                        @foreach(\App\Models\Tipo::orderBy('nombre')->get() as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Precio medio (€)</label>
                    <input id="modal-precio" type="number"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition">
                </div>
            </div>

            {{-- Ubicación + Chef --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Ubicación</label>
                    <input id="modal-ubicacion" type="text"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Chef</label>
                    <input id="modal-cheff" type="text"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition">
                </div>
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Descripción</label>
                <textarea id="modal-descripcion" rows="3"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition resize-none"></textarea>
            </div>

            {{-- Menú --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Menú</label>
                <textarea id="modal-menu" rows="2"
                          class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition resize-none"></textarea>
            </div>

            {{-- Estado --}}
            <div class="flex items-center gap-3 bg-gray-50 rounded-lg px-4 py-3">
                <input id="modal-estado" type="checkbox"
                       class="w-4 h-4 accent-teal-700 cursor-pointer">
                <label for="modal-estado" class="text-sm font-medium text-gray-700 cursor-pointer">
                    Restaurante aprobado y visible en la plataforma
                </label>
            </div>

            {{-- Botones --}}
            <div class="flex gap-3 pt-2">
                <button id="btn-guardar-restaurante" type="submit"
                        class="flex-1 bg-teal-900 hover:bg-teal-800 text-white font-bold py-2.5 rounded-lg text-sm transition">
                    Guardar cambios
                </button>
                <button id="btn-cancelar-modal-restaurante" type="button"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-lg text-sm transition">
                    Cancelar
                </button>
            </div>
        </form>

    </div>
</div>

{{-- Scripts JS --}}
<script src="{{ asset('js/crud_restaurantes.js') }}"></script>
<script src="{{ asset('js/filtros_restaurantes.js') }}"></script>

@endsection