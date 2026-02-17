@extends('components.home')

@section('title', 'TheFork | Gestión de Reservas')
@section('contenido')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-gradient-to-br from-teal-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Cabecera --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
            <h2 class="text-3xl font-bold text-teal-900 mb-1">📅 Gestión de Reservas</h2>
            <p class="text-gray-500 text-sm">Administra todas las reservas del sistema</p>
        </div>

        {{-- ══════════════ BARRA DE FILTROS ══════════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-teal-900">🔍 Filtros de Búsqueda</h3>
                <button id="btn-limpiar-filtros-reservas" 
                        class="text-sm text-teal-700 hover:text-teal-900 font-semibold hover:underline transition">
                    🔄 Limpiar filtros
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                
                {{-- Buscar por usuario --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Buscar por usuario
                    </label>
                    <input 
                        type="text" 
                        id="filtro-usuario" 
                        placeholder="Ej: Juan Pérez"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition">
                </div>

                {{-- Buscar por email --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Buscar por email
                    </label>
                    <input 
                        type="text" 
                        id="filtro-email-reserva" 
                        placeholder="Ej: usuario@ejemplo.com"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition">
                </div>

                {{-- Filtrar por restaurante --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Restaurante
                    </label>
                    <select 
                        id="filtro-restaurante"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                        <option value="">— Todos los restaurantes —</option>
                        @foreach(\App\Models\Restaurante::orderBy('titulo')->get() as $restaurante)
                            <option value="{{ $restaurante->id }}">{{ $restaurante->titulo }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtrar por rango de fechas de reserva --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Fecha de reserva
                    </label>
                    <select 
                        id="filtro-fecha-reserva"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                        <option value="">— Todas las fechas —</option>
                        <option value="hoy">Hoy</option>
                        <option value="esta_semana">Esta semana</option>
                        <option value="este_mes">Este mes</option>
                        <option value="pasadas">Pasadas</option>
                        <option value="futuras">Futuras</option>
                    </select>
                </div>
            </div>

            {{-- Indicador de carga --}}
            <div id="indicador-carga-reservas" class="hidden mt-4 text-center">
                <div class="inline-flex items-center gap-2 text-teal-700">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold">Filtrando reservas...</span>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-teal-900 text-white px-6 py-4">
                <h3 class="text-base font-bold">
                    Lista de Reservas
                    (<span id="contador-reservas">{{ $reservas->count() }}</span>)
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Usuario</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Restaurante</th>
                            <th class="px-6 py-3 text-left">Fecha</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-reservas-body" class="divide-y divide-gray-100 text-sm">
                        @forelse($reservas as $reserva)
                        <tr id="fila-reserva-{{ $reserva->id }}" class="hover:bg-gray-50 transition">

                            {{-- Campos ocultos para el modal --}}
                            <input type="hidden" data-id-user        value="{{ $reserva->id_user }}">
                            <input type="hidden" data-id-restaurante value="{{ $reserva->id_restaurante }}">
                            <input type="hidden" data-fecha-hora     value="{{ $reserva->fecha_hora ? \Carbon\Carbon::parse($reserva->fecha_hora)->format('Y-m-d\TH:i') : '' }}">

                            <td class="px-6 py-4 text-gray-400 font-mono">#{{ $reserva->id }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900" data-usuario-nombre>
                                {{ $reserva->usuario?->name ?? 'Usuario eliminado' }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $reserva->usuario?->email ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-teal-900" data-restaurante-nombre>
                                {{ $reserva->restaurante?->titulo ?? 'Restaurante eliminado' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600" data-fecha-display>
                                @if($reserva->fecha_hora)
                                    {{ \Carbon\Carbon::parse($reserva->fecha_hora)->format('d/m/Y H:i') }}
                                @else
                                    {{ $reserva->created_at->format('d/m/Y H:i') }}
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">

                                    <button
                                        data-btn-editar-reserva
                                        data-id="{{ $reserva->id }}"
                                        class="bg-teal-700 hover:bg-teal-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        ✏️ Editar
                                    </button>

                                    <button
                                        data-btn-eliminar-reserva
                                        data-id="{{ $reserva->id }}"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        🗑️ Eliminar
                                    </button>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">No hay reservas registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- ══════════════ MODAL EDITAR ══════════════ --}}
<div id="modal-reserva"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

        {{-- Header --}}
        <div class="bg-teal-900 px-6 py-5 flex items-center justify-between">
            <div>
                <h3 class="text-white font-bold text-lg">📅 Editar Reserva</h3>
                <p class="text-teal-300 text-xs mt-0.5">Los cambios se aplican al instante</p>
            </div>
            <button id="btn-cerrar-modal-reserva"
                    class="text-teal-300 hover:text-white transition text-2xl leading-none">&times;</button>
        </div>

        {{-- Cuerpo --}}
        <form id="form-editar-reserva" class="p-6 space-y-5" novalidate>
            <input type="hidden" id="modal-reserva-id">

            <div id="modal-reserva-error"
                 class="hidden bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg">
            </div>

            {{-- Usuario --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Usuario</label>
                <select id="modal-id-user"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white"
                        required>
                    <option value="">— Selecciona un usuario —</option>
                    @foreach(\App\Models\User::orderBy('name')->get() as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Restaurante --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Restaurante</label>
                <select id="modal-id-restaurante"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white"
                        required>
                    <option value="">— Selecciona un restaurante —</option>
                    @foreach(\App\Models\Restaurante::orderBy('titulo')->get() as $restaurante)
                        <option value="{{ $restaurante->id }}">{{ $restaurante->titulo }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha y hora --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Fecha y hora</label>
                <input id="modal-fecha-hora" type="datetime-local"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition"
                       required>
            </div>

            {{-- Botones --}}
            <div class="flex gap-3 pt-2">
                <button id="btn-guardar-reserva" type="submit"
                        class="flex-1 bg-teal-900 hover:bg-teal-800 text-white font-bold py-2.5 rounded-lg text-sm transition">
                    Guardar cambios
                </button>
                <button id="btn-cancelar-modal-reserva" type="button"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-lg text-sm transition">
                    Cancelar
                </button>
            </div>
        </form>

    </div>
</div>

{{-- Scripts JS --}}
<script src="{{ asset('js/crud_reservas.js') }}"></script>
<script src="{{ asset('js/filtros_reservas.js') }}"></script>

@endsection