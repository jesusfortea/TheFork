@extends('components.home')

@section('title', 'TheFork | Editar Reserva')
@section('contenido')


<div class="min-h-screen bg-gradient-to-br from-teal-50 to-white">

    {{-- Contenido principal --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        {{-- Título de la página --}}
        <div class="bg-white rounded-lg shadow-xl p-8 mb-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-teal-900 mb-3">
                ✏️ Editar Reserva
            </h2>
            <p class="text-gray-600">
                Modificar información de la reserva <strong>#{{ $reserva->id }}</strong>
            </p>
        </div>

        {{-- Información actual de la reserva --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-blue-900 mb-3">📌 Información Actual</h3>
            <div class="space-y-2 text-sm">
                <p><strong>Usuario:</strong> {{ $reserva->usuario ? $reserva->usuario->name : 'N/A' }} ({{ $reserva->usuario ? $reserva->usuario->email : 'N/A' }})</p>
                <p><strong>Restaurante:</strong> {{ $reserva->restaurante ? $reserva->restaurante->titulo : 'N/A' }}</p>
                <p><strong>Fecha de creación:</strong> {{ $reserva->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        {{-- Formulario de edición --}}
        <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-100">
            <form action="{{ route('admin.reservas.actualizar', $reserva->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Seleccionar Usuario --}}
                <div class="mb-6">
                    <label for="id_user" class="block text-sm font-bold text-gray-700 mb-2">
                        👤 Seleccionar Usuario
                    </label>
                    <select id="id_user" 
                            name="id_user"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-900 focus:border-transparent transition"
                            required>
                        <option value="">-- Selecciona un usuario --</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" 
                                    {{ old('id_user', $reserva->id_user) == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }} ({{ $usuario->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_user')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Seleccionar Restaurante --}}
                <div class="mb-6">
                    <label for="id_restaurante" class="block text-sm font-bold text-gray-700 mb-2">
                        🍽️ Seleccionar Restaurante
                    </label>
                    <select id="id_restaurante" 
                            name="id_restaurante"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-900 focus:border-transparent transition"
                            required>
                        <option value="">-- Selecciona un restaurante --</option>
                        @foreach($restaurantes as $restaurante)
                            <option value="{{ $restaurante->id }}" 
                                    {{ old('id_restaurante', $reserva->id_restaurante) == $restaurante->id ? 'selected' : '' }}>
                                {{ $restaurante->titulo }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_restaurante')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha y Hora de la Reserva --}}
                <div class="mb-6">
                    <label for="fecha_hora" class="block text-sm font-bold text-gray-700 mb-2">
                        📅 Fecha y Hora de la Reserva
                    </label>
                    <input type="datetime-local" 
                           id="fecha_hora" 
                           name="fecha_hora" 
                           value="{{ old('fecha_hora', $reserva->fecha_hora ? \Carbon\Carbon::parse($reserva->fecha_hora)->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-900 focus:border-transparent transition"
                           required>
                    @error('fecha_hora')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-2">* Selecciona la fecha y hora en la que el cliente desea reservar</p>
                </div>

                {{-- Botones de acción --}}
                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-3 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        💾 Guardar Cambios
                    </button>
                    
                    <a href="{{ route('admin.reservas') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg transition shadow-md hover:shadow-lg">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>

    </div>

</div>

@endsection
