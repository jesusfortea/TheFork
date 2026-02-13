@extends('components.home')

@section('title', 'TheFork | Gestión de Roles y Permisos')
@section('contenido')

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="base-roles-url" content="{{ url('admin/roles') }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        {{-- Título --}}
        <div class="bg-white rounded-lg shadow-xl p-8 mb-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-teal-900 mb-3">🔐 Gestión de Roles y Permisos</h2>
            <p class="text-gray-600">Administra los roles de usuario y sus permisos</p>
        </div>

        {{-- Tabla de roles --}}
        <div class="bg-white rounded-lg shadow-lg border border-gray-100">

            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-teal-900">Roles registrados</h3>
                <button
                    id="btn-abrir-crear"
                    class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded-lg transition shadow-md hover:shadow-lg text-sm">
                    + Añadir Rol
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-teal-50 text-teal-900 uppercase text-xs font-semibold tracking-wider">
                        <tr>
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Nombre del Rol</th>
                            <th class="px-6 py-3">Creado</th>
                            <th class="px-6 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-roles" class="divide-y divide-gray-100">
                        @forelse($roles as $rol)
                            <tr id="fila-{{ $rol->id }}" class="hover:bg-teal-50 transition">
                                <td class="px-6 py-4 text-gray-400 font-mono">{{ $rol->id }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800" id="nombre-{{ $rol->id }}">{{ $rol->nombre }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $rol->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <button
                                        onclick="abrirModalEditar({{ $rol->id }}, '{{ addslashes($rol->nombre) }}')"
                                        class="inline-flex items-center bg-teal-100 hover:bg-teal-200 text-teal-900 font-semibold py-1.5 px-3 rounded-lg transition text-xs">
                                        ✏️ Editar
                                    </button>
                                    <button
                                        onclick="confirmarEliminar({{ $rol->id }}, '{{ addslashes($rol->nombre) }}')"
                                        class="inline-flex items-center bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-1.5 px-3 rounded-lg transition text-xs">
                                        🗑️ Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="fila-vacia">
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                    No hay roles registrados todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div id="modal-crear" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 p-8 border border-gray-100">
        <h3 class="text-xl font-bold text-teal-900 mb-6">➕ Nuevo Rol</h3>
        <div class="mb-6">
            <label for="nombre_crear" class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Rol</label>
            <input type="text" id="nombre_crear" placeholder="Ej: Administrador, Editor..."
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
        </div>
        <div class="flex justify-end space-x-3">
            <button id="btn-cancelar-crear"
                class="py-2 px-4 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition">
                Cancelar
            </button>
            <button id="btn-guardar-crear"
                class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded-lg transition shadow-md text-sm">
                Guardar
            </button>
        </div>
    </div>
</div>

{{-- MODAL EDITAR --}}
<div id="modal-editar" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 p-8 border border-gray-100">
        <h3 class="text-xl font-bold text-teal-900 mb-6">✏️ Editar Rol</h3>
        <input type="hidden" id="editar_id">
        <div class="mb-6">
            <label for="nombre_editar" class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Rol</label>
            <input type="text" id="nombre_editar"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
        </div>
        <div class="flex justify-end space-x-3">
            <button id="btn-cancelar-editar"
                class="py-2 px-4 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition">
                Cancelar
            </button>
            <button id="btn-guardar-editar"
                class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded-lg transition shadow-md text-sm">
                Actualizar
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/sweet_roles.js') }}"></script>

@endsection