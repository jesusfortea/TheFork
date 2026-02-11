@extends('components.home')

@section('title', 'TheFork | Iniciar Sesión')
@section('contenido')
    
    {{-- ¡PÁGINA DE INICIO DE SESIÓN! --}}

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-teal-50 to-white p-5">

        <div class="w-full max-w-md">
            
            {{-- Título principal --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-teal-900 mb-2">Bienvenido de nuevo</h1>
                <p class="text-gray-600">Inicia sesión para acceder a tu cuenta</p>
            </div>

            {{-- Formulario de inicio de sesión --}}
            <form class="bg-white shadow-xl rounded-lg p-8 border border-gray-100" action="{{ route('login.post') }}" method="POST">
                @csrf

                {{-- Mostrar errores generales --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Email --}}
                <div class="mb-6">
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                        Correo Electrónico
                    </label>
                    <input 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-900 focus:border-transparent transition @error('email') border-red-500 @enderror" 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="tu@email.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                        Contraseña
                    </label>
                    <input 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-900 focus:border-transparent transition @error('password') border-red-500 @enderror" 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Recordarme y Olvidé contraseña --}}
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            id="remember" 
                            class="w-4 h-4 text-teal-900 border-gray-300 rounded focus:ring-teal-900"
                        >
                        <span class="ml-2 text-sm text-gray-700">Recordarme</span>
                    </label>

                    <a href="#" class="text-sm text-teal-900 font-bold hover:underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                {{-- Botón de iniciar sesión --}}
                <button 
                    class="w-full bg-teal-900 text-white font-bold py-3 px-4 rounded-lg hover:bg-teal-800 transition duration-200 shadow-md hover:shadow-lg" 
                    type="submit" 
                    name="login" 
                    id="login"
                >
                    INICIAR SESIÓN
                </button>

                {{-- Separador --}}
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">o continúa con</span>
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

                {{-- Link de registro --}}
                <p class="text-center text-sm text-gray-600">
                    ¿No tienes una cuenta? 
                    <a href="{{ route('register') }}" class="text-teal-900 font-bold hover:underline">Regístrate aquí</a>
                </p>

            </form>

            {{-- Información adicional --}}
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    Al iniciar sesión, aceptas nuestros 
                    <a href="#" class="text-teal-900 underline">Términos de Servicio</a> y 
                    <a href="#" class="text-teal-900 underline">Política de Privacidad</a>
                </p>
            </div>

        </div>

    </div>

@endsection
