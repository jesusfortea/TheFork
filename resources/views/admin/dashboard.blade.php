@extends('components.home')

@section('title', 'TheFork | Panel de Administración')
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
                    
                    <a href="{{ route('home') }}" class="text-teal-900 hover:text-teal-700 transition text-sm font-semibold">
                        Ir al sitio →
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
        
        {{-- Mensaje de bienvenida --}}
        <div class="bg-white rounded-lg shadow-xl p-8 mb-8 border border-gray-100">
            <h2 class="text-3xl font-bold text-teal-900 mb-3">
                Panel de Administración
            </h2>
            <p class="text-gray-600">
                Gestiona todos los aspectos de TheFork: usuarios, restaurantes, reservas y más.
            </p>
        </div>

        {{-- Estadísticas rápidas --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
            {{-- Card: Total Usuarios --}}
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold mb-2">Total Usuarios</p>
                        <p class="text-4xl font-bold text-teal-900">
                            {{ $totalUsuarios }}
                        </p>
                    </div>
                    <div class="text-5xl">
                        👥
                    </div>
                </div>
            </div>

            {{-- Card: Total Restaurantes --}}
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold mb-2">Restaurantes</p>
                        <p class="text-4xl font-bold text-teal-900">
                            {{ $totalRestaurantes }}
                        </p>
                    </div>
                    <div class="text-5xl">
                        🍽️
                    </div>
                </div>
            </div>

            {{-- Card: Total Reservas --}}
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold mb-2">Reservas</p>
                        <p class="text-4xl font-bold text-teal-900">
                            {{ $totalReservas }}
                        </p>
                    </div>
                    <div class="text-5xl">
                        📅
                    </div>
                </div>
            </div>


        </div>

        {{-- Secciones de administración --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            {{-- Gestión de Usuarios --}}
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border border-gray-100">
                <div class="text-4xl mb-4">👥</div>
                <h3 class="text-xl font-bold text-teal-900 mb-2">Gestión de Usuarios</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    Ver, editar, bloquear o eliminar usuarios del sistema
                </p>
                <a href="{{ route('admin.usuarios') }}" class="inline-block bg-teal-900 hover:bg-teal-800 text-white font-semibold py-2 px-4 rounded-lg transition shadow-md hover:shadow-lg">
                    Gestionar →
                </a>
            </div>

            {{-- Gestión de Restaurantes --}}
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border border-gray-100">
                <div class="text-4xl mb-4">🍽️</div>
                <h3 class="text-xl font-bold text-teal-900 mb-2">Gestión de Restaurantes</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    Aprobar, editar o eliminar restaurantes registrados
                </p>
                <a href="{{ route('admin.restaurantes') }}" class="inline-block bg-teal-900 hover:bg-teal-800 text-white font-semibold py-2 px-4 rounded-lg transition shadow-md hover:shadow-lg">
                    Gestionar →
                </a>
            </div>

            {{-- Gestión de Reservas --}}
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border border-gray-100">
                <div class="text-4xl mb-4">📅</div>
                <h3 class="text-xl font-bold text-teal-900 mb-2">Gestión de Reservas</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    Ver y gestionar todas las reservas del sistema
                </p>
                <a href="{{ route('admin.reservas') }}" class="inline-block bg-teal-900 hover:bg-teal-800 text-white font-semibold py-2 px-4 rounded-lg transition shadow-md hover:shadow-lg">
                    Gestionar →
                </a>
            </div>

            {{-- Roles y Permisos --}}
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition border border-gray-100">
                <div class="text-4xl mb-4">🔐</div>
                <h3 class="text-xl font-bold text-teal-900 mb-2">Roles y Permisos</h3>
                <p class="text-gray-600 mb-4 text-sm">
                    Gestionar roles de usuarios y permisos
                </p>
                <a href="{{ route('admin.roles') }}" class="inline-block bg-teal-900 hover:bg-teal-800 text-white font-semibold py-2 px-4 rounded-lg transition shadow-md hover:shadow-lg">
                    Gestionar →
                </a>
            </div>


        </div>

    </div>

</div>

@endsection
