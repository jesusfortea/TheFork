@extends('components.home')

@section('title', 'TheFork | Gestión de Roles y Permisos')
@section('contenido')

{{-- SweetAlert2 CDN --}}
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

        {{-- Título de la página --}}
        <div class="bg-white rounded-lg shadow-xl p-8 mb-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-teal-900 mb-3">
                🔐 Gestión de Roles y Permisos
            </h2>
            <p class="text-gray-600">
                Administra los roles de usuario y sus permisos
            </p>
        </div>

        {{-- Datos de sesión ocultos para SweetAlert --}}
        @if(session('success'))
            <span id="swal-success" data-msg="{{ session('success') }}" class="hidden"></span>
        @endif
        @if(session('error'))
            <span id="swal-error" data-msg="{{ session('error') }}" class="hidden"></span>
        @endif
        @if($errors->any())
            <span id="swal-validation" data-msg="{{ $errors->first() }}" class="hidden"></span>
        @endif

        {{-- Tabla de roles --}}
        <div class="bg-white rounded-lg shadow-lg border border-gray-100">

            {{-- Cabecera de la tarjeta --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-bold text-teal-900">Roles registrados</h3>
                <button
                    onclick="document.getElementById('modal-crear').classList.remove('hidden')"
                    class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded-lg transition shadow-md hover:shadow-lg text-sm">
                    + Añadir Rol
                </button>
            </div>

            {{-- Tabla --}}
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
                    <tbody class="divide-y divide-gray-100">
                        @forelse($roles as $rol)
                            <tr class="hover:bg-teal-50 transition">
                                <td class="px-6 py-4 text-gray-400 font-mono">{{ $rol->id }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-800">{{ $rol->nombre }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $rol->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center space-x-2">

                                    {{-- Botón Editar --}}
                                    <button
                                        onclick="abrirModalEditar({{ $rol->id }}, '{{ addslashes($rol->nombre) }}')"
                                        class="inline-flex items-center bg-teal-100 hover:bg-teal-200 text-teal-900 font-semibold py-1.5 px-3 rounded-lg transition text-xs">
                                        ✏️ Editar
                                    </button>

                                    {{-- Botón Eliminar --}}
                                    <form id="form-destroy-{{ $rol->id }}"
                                          action="{{ route('admin.roles.destroy', $rol->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmarEliminar({{ $rol->id }}, '{{ addslashes($rol->nombre) }}')"
                                            class="inline-flex items-center bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-1.5 px-3 rounded-lg transition text-xs">
                                            🗑️ Eliminar
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
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

{{-- ===================== MODAL CREAR ROL ===================== --}}
<div id="modal-crear" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 p-8 border border-gray-100">
        <h3 class="text-xl font-bold text-teal-900 mb-6">➕ Nuevo Rol</h3>

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="nombre_crear" class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Rol</label>
                <input
                    type="text"
                    id="nombre_crear"
                    name="nombre"
                    placeholder="Ej: Administrador, Editor..."
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button"
                    onclick="document.getElementById('modal-crear').classList.add('hidden')"
                    class="py-2 px-4 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition">
                    Cancelar
                </button>
                <button type="submit"
                    class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded-lg transition shadow-md text-sm">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===================== MODAL EDITAR ROL ===================== --}}
<div id="modal-editar" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 p-8 border border-gray-100">
        <h3 class="text-xl font-bold text-teal-900 mb-6">✏️ Editar Rol</h3>

        <form id="form-editar" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="nombre_editar" class="block text-sm font-semibold text-gray-700 mb-1">Nombre del Rol</label>
                <input
                    type="text"
                    id="nombre_editar"
                    name="nombre"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition">
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button"
                    onclick="document.getElementById('modal-editar').classList.add('hidden')"
                    class="py-2 px-4 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 font-semibold text-sm transition">
                    Cancelar
                </button>
                <button type="submit"
                    class="bg-teal-900 hover:bg-teal-800 text-white font-bold py-2 px-4 rounded-lg transition shadow-md text-sm">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ===================== SCRIPTS ===================== --}}
<script>
    // --- Modal editar ---
    function abrirModalEditar(id, nombre) {
        const baseUrl = "{{ url('admin/roles') }}";
        document.getElementById('form-editar').action = baseUrl + '/' + id;
        document.getElementById('nombre_editar').value = nombre;
        document.getElementById('modal-editar').classList.remove('hidden');
    }

    // --- Confirmación eliminar con SweetAlert ---
    function confirmarEliminar(id, nombre) {
        Swal.fire({
            title: '¿Eliminar rol?',
            text: `Vas a eliminar el rol "${nombre}". Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#134e4a',
            cancelButtonColor: '#d1d5db',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-destroy-' + id).submit();
            }
        });
    }

    // --- Alertas de sesión al cargar la página ---
    document.addEventListener('DOMContentLoaded', () => {
        const success    = document.getElementById('swal-success');
        const error      = document.getElementById('swal-error');
        const validation = document.getElementById('swal-validation');

        if (success) {
            Swal.fire({
                icon: 'success',
                title: '¡Hecho!',
                text: success.dataset.msg,
                confirmButtonColor: '#134e4a',
                timer: 3000,
                timerProgressBar: true,
            });
        }

        if (error) {
            Swal.fire({
                icon: 'error',
                title: 'No se puede eliminar',
                text: error.dataset.msg,
                confirmButtonColor: '#134e4a',
            });
        }

        if (validation) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: validation.dataset.msg,
                confirmButtonColor: '#134e4a',
            });
        }
    });
</script>

@endsection