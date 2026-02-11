@extends('components.home')

@section('title', 'TheFork | Crear Cuenta')
@section('contenido')
    
    {{-- ¡PÁGINA DE REGISTRO! --}}

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-teal-50 to-white p-5">

        <div class="w-full max-w-md">
            
            {{-- Título principal --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-teal-900 mb-2">Únete a TheFork</h1>
                <p class="text-gray-600">Crea tu cuenta y descubre los mejores restaurantes</p>
            </div>

            {{-- Formulario de registro --}}
            <form class="bg-white shadow-xl rounded-lg p-8 border border-gray-100" action="" method="post">

                {{-- Nombre completo --}}
                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                        Nombre Completo
                    </label>
                    <input 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-900 focus:border-transparent transition" 
                        type="text" 
                        name="name" 
                        id="name" 
                        placeholder="Juan Pérez"
                        required
                    >
                </div>

                {{-- Email --}}
                <div class="mb-6">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        Correo Electrónico
                    </label>
                    <input 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-900 focus:border-transparent transition" 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="tu@email.com"
                        required
                    >
                </div>

                {{-- Contraseña --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                        Contraseña
                    </label>
                    <input 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-900 focus:border-transparent transition" 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="••••••••"
                        required
                    >
                    <p class="text-xs text-gray-500 mt-1">Mínimo 8 caracteres</p>
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">
                        Confirmar Contraseña
                    </label>
                    <input 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-900 focus:border-transparent transition" 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        placeholder="••••••••"
                        required
                    >
                </div>

                {{-- Términos y condiciones --}}
                <div class="flex items-start mb-6">
                    <input 
                        type="checkbox" 
                        name="terms" 
                        id="terms" 
                        class="w-4 h-4 mt-1 text-teal-900 border-gray-300 rounded focus:ring-teal-900"
                        required
                    >
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        Acepto los 
                        <a href="#" class="text-teal-900 font-bold hover:underline">Términos de Servicio</a> 
                        y la 
                        <a href="#" class="text-teal-900 font-bold hover:underline">Política de Privacidad</a>
                    </label>
                </div>

                {{-- Botón de registro --}}
                <button 
                    class="w-full bg-teal-900 text-white font-bold py-3 px-4 rounded-lg hover:bg-teal-800 transition duration-200 shadow-md hover:shadow-lg" 
                    type="submit" 
                    name="register" 
                    id="register"
                >
                    CREAR CUENTA
                </button>

                {{-- Separador --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">o regístrate con</span>
                    </div>
                </div>

                {{-- Botones de redes sociales --}}
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <button 
                        type="button" 
                        class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                    >
                        <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5 mr-2">
                        <span class="text-sm font-semibold text-gray-700">Google</span>
                    </button>

                    <button 
                        type="button" 
                        class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition"
                    >
                        <img src="https://www.facebook.com/favicon.ico" alt="Facebook" class="w-5 h-5 mr-2">
                        <span class="text-sm font-semibold text-gray-700">Facebook</span>
                    </button>
                </div>

                {{-- Link de inicio de sesión --}}
                <p class="text-center text-sm text-gray-600">
                    ¿Ya tienes una cuenta? 
                    <a href="{{ route('login') }}" class="text-teal-900 font-bold hover:underline">Inicia sesión aquí</a>
                </p>

            </form>

        </div>

    </div>

@endsection
