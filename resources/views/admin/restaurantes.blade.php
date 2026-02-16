@extends('components.home')

@section('title', 'TheFork | Gestión de Restaurantes')
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
                🍽️ Gestión de Restaurantes
            </h2>
            <p class="text-gray-600">
                Administra todos los restaurantes del sistema
            </p>
        </div>

        {{-- Mensajes de éxito o error --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabla de restaurantes --}}
        <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
            
            @if($restaurantes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-teal-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Imagen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Precio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Chef</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($restaurantes as $restaurante)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $restaurante->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($restaurante->imagen)
                                            <img src="{{ asset($restaurante->imagen) }}" alt="{{ $restaurante->titulo }}" class="h-12 w-12 rounded object-cover">
                                        @else
                                            <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                                <span class="text-xs">Sin img</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $restaurante->titulo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $restaurante->tipo->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $restaurante->precio }}€
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($restaurante->estado)
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Aprobado
                                            </span>
                                        @else
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pendiente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ Str::limit($restaurante->cheff, 20) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{-- 
                                            BOTONES DE ACCIÓN
                                            - Botón Editar: redirige al formulario de edición
                                            - Botón Eliminar: elimina el restaurante con confirmación
                                        --}}
                                        <div class="flex gap-2">
                                            {{-- 
                                                BOTÓN EDITAR
                                                onclick: evento inline que redirige a la página de edición
                                                window.location.href: cambia la URL del navegador
                                                route('restaurantes.edit', $restaurante->id): genera la URL /restaurantes/{id}/editar
                                            --}}
                                            <button 
                                                type="button" 
                                                onclick="window.location.href='{{ route('restaurantes.edit', $restaurante->id) }}'" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow hover:shadow-lg">
                                                ✏️ Editar
                                            </button>

                                            {{-- 
                                                BOTÓN ELIMINAR
                                                - Formulario con método DELETE
                                                - onsubmit: evento inline que muestra confirmación antes de enviar
                                                - return confirmarEliminacion(): ejecuta la función y retorna false para prevenir submit automático
                                            --}}
                                            <form action="{{ route('restaurantes.destroy', $restaurante->id) }}" method="POST" class="inline" onsubmit="return confirmarEliminacion(event, '{{ $restaurante->titulo }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition shadow hover:shadow-lg">
                                                    🗑️ Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <p class="text-gray-500 text-lg">No hay restaurantes registrados en el sistema.</p>
                    <a href="{{ route('crear.restaurante') }}" class="mt-4 inline-block bg-teal-900 hover:bg-teal-800 text-white font-bold py-2 px-6 rounded-lg transition">
                        Crear primer restaurante
                    </a>
                </div>
            @endif

        </div>

    </div>

</div>

{{-- Script para confirmar eliminación con SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarEliminacion(event, nombreRestaurante) {
        event.preventDefault();
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Vas a eliminar el restaurante "${nombreRestaurante}". Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#0f766e',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
        
        return false;
    }
</script>

@endsection

