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
                    <tbody class="divide-y divide-gray-100 text-sm">
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

<script src="{{ asset('js/crud_reservas.js') }}"></script>

@endsection