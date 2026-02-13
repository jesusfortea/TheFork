@extends('components.home')

@section('title', 'TheFork | Gestión de Reservas')
@section('contenido')

{{-- Meta tag para CSRF (necesario para AJAX) --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-gradient-to-br from-teal-50 to-white">

    {{-- Contenido principal --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Título de la página --}}
        <div class="bg-white rounded-lg shadow-xl p-8 mb-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-teal-900 mb-3">
                📅 Gestión de Reservas
            </h2>
            <p class="text-gray-600">
                Administra todas las reservas del sistema
            </p>
        </div>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-md">
                <strong class="font-bold">✓ Éxito:</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-md">
                <strong class="font-bold">✗ Error:</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Tabla de reservas --}}
        <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
            
            {{-- Header de la tabla --}}
            <div class="bg-teal-900 text-white px-6 py-4">
                <h3 class="text-lg font-bold">Lista de Reservas ({{ $reservas->count() }})</h3>
            </div>

            {{-- Contenido de la tabla --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Restaurante</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Fecha de Reserva</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reservas as $reserva)
                            {{-- ID único para AJAX --}}
                            <tr id="fila-reserva-{{ $reserva->id }}" class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $reserva->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ $reserva->usuario ? $reserva->usuario->name : 'Usuario eliminado' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600">
                                        {{ $reserva->usuario ? $reserva->usuario->email : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-teal-900">
                                        {{ $reserva->restaurante ? $reserva->restaurante->titulo : 'Restaurante eliminado' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($reserva->fecha_hora)
                                        <div class="font-semibold text-teal-900">{{ \Carbon\Carbon::parse($reserva->fecha_hora)->format('d/m/Y H:i') }}</div>
                                        <div class="text-xs text-gray-500">Fecha reserva</div>
                                    @else
                                        <div>{{ $reserva->created_at->format('d/m/Y H:i') }}</div>
                                        <div class="text-xs text-gray-500">Fecha creación</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        {{-- Botón Editar --}}
                                        <a href="{{ route('admin.reservas.editar', $reserva->id) }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg transition shadow-md hover:shadow-lg text-xs font-semibold">
                                            ✏️ Editar
                                        </a>
                                        
                                        {{-- Botón Eliminar con AJAX --}}
                                        <button 
                                            onclick="eliminarReservaAjax({{ $reserva->id }})"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg transition shadow-md hover:shadow-lg text-xs font-semibold">
                                            🗑️ Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    No hay reservas registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

{{-- Script AJAX para operaciones sin recargar página --}}
<script src="{{ asset('js/crud_ajax.js') }}"></script>

@endsection
