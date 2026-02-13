@extends('components.home')

@section('title', 'TheFork | Gestión de Reservas')
@section('contenido')

<div class="min-h-screen bg-gradient-to-br from-teal-50 to-white">
    
    {{-- Navbar superior para Admin --}}
    <nav class="bg-white shadow-md border-b-2 border-teal-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold text-teal-900">TheFork</h1>
                    <span class="text-xs bg-teal-900 text-white px-2 py-1 rounded font-semibold">ADMIN</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 text-sm">Hola, <strong class="text-teal-900">{{ Auth::user()->name }}</strong></span>
                    
                    <a href="{{ route('admin.dashboard') }}" class="text-teal-900 hover:text-teal-700 transition text-sm font-semibold">
                        ← Volver al Dashboard
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded-lg transition shadow-md hover:shadow-lg">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

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
                            <tr class="hover:bg-gray-50 transition">
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
                                    {{ $reserva->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center gap-2">
                                        {{-- Botón Editar --}}
                                        <a href="{{ route('admin.reservas.editar', $reserva->id) }}" 
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg transition shadow-md hover:shadow-lg text-xs font-semibold">
                                            ✏️ Editar
                                        </a>
                                        
                                        {{-- Botón Eliminar --}}
                                        <form action="{{ route('admin.reservas.eliminar', $reserva->id) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta reserva?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg transition shadow-md hover:shadow-lg text-xs font-semibold">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
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

@endsection
