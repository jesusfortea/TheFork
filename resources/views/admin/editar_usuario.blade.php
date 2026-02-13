@extends('components.home')

@section('title', 'TheFork | Editar Usuario')
@section('contenido')


<div class="min-h-screen bg-gradient-to-br from-teal-50 to-white">

    {{-- Contenido principal --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Título de la página --}}
        <div class="bg-white rounded-lg shadow-xl p-8 mb-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-teal-900 mb-3">
                ✏️ Editar Usuario
            </h2>
            <p class="text-gray-600">
                Modificar información de: <strong>{{ $usuario->name }}</strong>
            </p>
        </div>

        {{-- Formulario de edición --}}
        <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-100">
            <form action="{{ route('admin.usuarios.actualizar', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                        Nombre completo
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $usuario->name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-900 focus:border-transparent transition"
                           required>
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-6">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $usuario->email) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-900 focus:border-transparent transition"
                           required>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Rol --}}
                <div class="mb-6">
                    <label for="rol_id" class="block text-sm font-bold text-gray-700 mb-2">
                        Rol
                    </label>
                    <select id="rol_id" 
                            name="rol_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-900 focus:border-transparent transition"
                            required>
                        <option value="">Seleccionar un rol</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}" {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>
                                {{ $rol->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('rol_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nueva contraseña (opcional) --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                        Nueva Contraseña (opcional)
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Dejar en blanco para mantener la contraseña actual"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-900 focus:border-transparent transition">
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">
                        Solo completa este campo si deseas cambiar la contraseña del usuario
                    </p>
                </div>

                {{-- Botones de acción --}}
                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-3 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        💾 Guardar Cambios
                    </button>
                    
                    <a href="{{ route('admin.usuarios') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>

    </div>

</div>

@endsection
