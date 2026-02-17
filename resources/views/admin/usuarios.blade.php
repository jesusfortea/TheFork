@extends('components.home')

@section('title', 'TheFork | Gestión de Usuarios')
@section('contenido')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="min-h-screen bg-gradient-to-br from-teal-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Cabecera --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
            <h2 class="text-3xl font-bold text-teal-900 mb-1">👥 Gestión de Usuarios</h2>
            <p class="text-gray-500 text-sm">Administra todos los usuarios del sistema</p>
        </div>

        {{-- ══════════════ BARRA DE FILTROS ══════════════ --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-teal-900">🔍 Filtros de Búsqueda</h3>
                <button id="btn-limpiar-filtros" 
                        class="text-sm text-teal-700 hover:text-teal-900 font-semibold hover:underline transition">
                    🔄 Limpiar filtros
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                
                {{-- Buscar por nombre --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Buscar por nombre
                    </label>
                    <input 
                        type="text" 
                        id="filtro-nombre" 
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
                        id="filtro-email" 
                        placeholder="Ej: usuario@ejemplo.com"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition">
                </div>

                {{-- Filtrar por rol --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Filtrar por rol
                    </label>
                    <select 
                        id="filtro-rol"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                        <option value="">— Todos los roles —</option>
                        @foreach(\App\Models\Rol::all() as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtrar por fecha de registro --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                        Fecha de registro
                    </label>
                    <select 
                        id="filtro-fecha"
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
            <div id="indicador-carga" class="hidden mt-4 text-center">
                <div class="inline-flex items-center gap-2 text-teal-700">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold">Filtrando usuarios...</span>
                </div>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="bg-teal-900 text-white px-6 py-4">
                <h3 class="text-base font-bold">
                    Lista de Usuarios
                    (<span id="contador-usuarios">{{ $usuarios->count() }}</span>)
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">Nombre</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Rol</th>
                            <th class="px-6 py-3 text-left">Registro</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-usuarios-body" class="divide-y divide-gray-100 text-sm">
                        @forelse($usuarios as $usuario)
                        <tr id="fila-usuario-{{ $usuario->id }}" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-400 font-mono">#{{ $usuario->id }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900" data-nombre>{{ $usuario->name }}</td>
                            <td class="px-6 py-4 text-gray-500" data-email>{{ $usuario->email }}</td>
                            <td class="px-6 py-4">
                                {{-- Campo oculto para guardar el rol_id actual --}}
                                <input type="hidden" data-rol-id value="{{ $usuario->rol_id }}">
                                <span data-rol class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    @if($usuario->rol?->nombre === 'Administrador') bg-purple-100 text-purple-700
                                    @elseif($usuario->rol?->nombre === 'Restaurante') bg-blue-100 text-blue-700
                                    @else bg-emerald-100 text-emerald-700
                                    @endif">
                                    {{ $usuario->rol?->nombre ?? 'Sin rol' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ $usuario->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">

                                    {{-- Botón Editar --}}
                                    <button
                                        data-btn-editar
                                        data-id="{{ $usuario->id }}"
                                        class="bg-teal-700 hover:bg-teal-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        ✏️ Editar
                                    </button>

                                    {{-- Botón Eliminar --}}
                                    @if($usuario->id !== Auth::id())
                                        <button
                                            data-btn-eliminar
                                            data-id="{{ $usuario->id }}"
                                            data-nombre="{{ $usuario->name }}"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                            🗑️ Eliminar
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-xs italic px-3 py-1.5">Tú mismo</span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">No hay usuarios registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- ══════════════ MODAL EDITAR ══════════════ --}}
<div id="modal-editar"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">

        {{-- Header --}}
        <div class="bg-teal-900 px-6 py-5 flex items-center justify-between">
            <div>
                <h3 class="text-white font-bold text-lg">✏️ Editar Usuario</h3>
                <p class="text-teal-300 text-xs mt-0.5">Los cambios se aplican al instante</p>
            </div>
            <button id="btn-cerrar-modal"
                    class="text-teal-300 hover:text-white transition text-2xl leading-none">&times;</button>
        </div>

        {{-- Cuerpo --}}
        <form id="form-editar-usuario" class="p-6 space-y-5" novalidate>
            <input type="hidden" id="modal-usuario-id">

            <div id="modal-error"
                 class="hidden bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-lg">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Nombre</label>
                <input id="modal-nombre" type="text"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition"
                       required>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                <input id="modal-email" type="email"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition"
                       required>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Rol</label>
                <select id="modal-rol"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition bg-white">
                    <option value="">— Selecciona un rol —</option>
                    @foreach(\App\Models\Rol::all() as $rol)
                        <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Nueva contraseña
                    <span class="text-gray-400 font-normal normal-case">(dejar vacío para no cambiar)</span>
                </label>
                <input id="modal-password" type="password"
                       class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-700 transition"
                       placeholder="••••••••">
            </div>

            <div class="flex gap-3 pt-2">
                <button id="btn-guardar" type="submit"
                        class="flex-1 bg-teal-900 hover:bg-teal-800 text-white font-bold py-2.5 rounded-lg text-sm transition">
                    Guardar cambios
                </button>
                <button id="btn-cancelar-modal" type="button"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 rounded-lg text-sm transition">
                    Cancelar
                </button>
            </div>
        </form>

    </div>
</div>

{{-- Scripts JS --}}
<script>
    // Variable global para que filtros_usuarios.js pueda identificar al usuario actual
    window.USUARIO_ACTUAL_ID = {{ Auth::id() }};
</script>
<script src="{{ asset('js/crud_usuarios.js') }}"></script>
<script src="{{ asset('js/filtros_usuarios.js') }}"></script>

@endsection