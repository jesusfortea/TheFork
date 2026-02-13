<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('media/icon.png') }}">
</head>
<body class="bg-white text-slate-800">
    
    <header class="border-b">
        <nav class="border-b border-gray-100">
            <ul class="flex justify-end gap-6 px-10 py-2 text-[11px] font-bold text-teal-900 uppercase">
                <li><a href="{{ route('crear.restaurante') }}">🏠 Registrar mi restaurante</a></li>
                <li class="text-gray-300">|</li>
                <li><a href="">Ayuda</a></li>
            </ul>
        </nav>

        <nav class="flex justify-between items-center px-10 py-3">
            <ul class="flex items-center w-full">
                <li>
                    <a href="{{ route('home') }}"><img src="{{ asset('media/logo.png') }}" alt="Logo" class="h-9"></a>
                </li>
                
                <section class="flex ml-auto gap-3 items-center">
                    <li>
                        <button class="px-4 py-2 border rounded font-bold text-[12px]">
                            📱 DESCARGAR LA APLICACIÓN
                        </button>
                    </li>
                    <li>
                        @auth
                            {{-- Usuario autenticado: icono con dropdown --}}
                            <div class="relative" x-data="{ open: false }">
                                <button
                                    id="user-dropdown-btn" onclick="document.getElementById('user-dropdown').classList.toggle('hidden')"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-teal-50 transition">
                                    <div class="w-8 h-8 bg-teal-900 text-white rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                        </svg>
                                    </div>
                                    <span class="text-[12px] font-bold text-teal-900 hidden sm:block">{{ Auth::user()->name }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-teal-900" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>

                                {{-- Dropdown --}}
                                <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-100 rounded-xl shadow-lg z-50 overflow-hidden">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-[11px] text-gray-400 uppercase font-semibold">Conectado como</p>
                                        <p class="text-[13px] font-bold text-teal-900 truncate">{{ Auth::user()->name }}</p>
                                    </div>
                                    <ul class="py-1 text-[13px]">
                                        <li>
                                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-teal-50 font-semibold">
                                                🛠️ Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 font-semibold">
                                                    🚪 Cerrar Sesión
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            {{-- Usuario no autenticado: botón de login --}}
                            <a href="{{ route('login') }}">
                                <button class="px-4 py-2 bg-teal-900 text-white rounded font-bold text-[12px]">
                                    INICIAR SESIÓN
                                </button>
                            </a>
                        @endauth
                    </li>
                </section>
            </ul>
        </nav>
    </header>

    <main>
        @yield('contenido')
    </main>

    <footer class="bg-black text-white py-12 px-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <div>
                <h3 class="font-bold text-lg mb-6">Descargar aplicación</h3>
                <div class="flex flex-col gap-3">
                    <div class="border border-gray-600 rounded-lg p-2 flex items-center w-40 cursor-pointer">
                        <a href="#">
                            <img src="{{ asset('media/app_store.png') }}" alt="App Store" class="h-10 w-auto mr-2">
                        </a>
                        
                        <div class="text-[9px]">Download on the <br><span class="text-sm font-bold">App Store</span></div>
                    </div>
                </div><br>

                    <div class="border border-gray-600 rounded-lg p-2 flex items-center w-40 cursor-pointer">
                        <a href="#">
                            <img src="{{ asset('media/play_store.png') }}" alt="Google Play" class="h-6 w-auto mr-2">
                        </a>
                        <div class="text-[9px]">Get it on <br><span class="text-sm font-bold">Google Play</span></div>
                    </div>
            </div>
        
            <ul class="text-[13px] font-bold space-y-4">
                <li><a href="#">¿Quiénes somos?</a></li>
                <li><a href="#">Información de contacto</a></li>
                <li><a href="#">¿Tienes un restaurante?</a></li>
                <li><a href="#">Preguntas frecuentes</a></li>
                <li><a href="#">Trabaja con nosotros</a></li>
                <li><a href="#">Colaboración Guía MICHELIN</a></li>
                <li><a href="#">Tarjeta Regalo TheFork</a></li>
            </ul>

            <ul class="text-[13px] font-bold space-y-4">
                <li><a href="#">Programa Yums</a></li>
                <li><a href="#">Condiciones de uso</a></li>
                <li><a href="#">Declaración de Privacidad y Cookies</a></li>
                <li><a href="#">Aceptación de cookies</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Restaurante cerca de mí</a></li>
            </ul>

            <div class="flex flex-col gap-6">
                <div class="flex gap-4">
                    <a href="#">
                        <img src="{{ asset('media/instagram_logo.png') }}" alt="Instagram" class="w-6 h-6">
                    </a>
                    
                    <a href="#">
                        <img src="{{ asset('media/facebook_logo.png') }}" alt="Facebook" class="w-6 h-6">
                    </a>
                </div>
                <p class="text-[11px] font-bold leading-tight">
                    © 2026 LA FOURCHETTESAS - <br>
                    TODOS LOS DERECHOS RESERVADOS
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-zinc-800">
            <p class="text-[10px] text-gray-400 text-center leading-relaxed">
                Las ofertas promocionales están sujetas a las condiciones que figuran en la página del restaurante. Las ofertas en bebidas alcohólicas están dirigidas únicamente a adultos. El consumo excesivo de alcohol es perjudicial para la salud. Bebe con moderación.
            </p>
        </div>
    </footer>


    {{-- Scripts de las vistas hijas --}}
    @stack('scripts')
    <script src="{{ asset('js/home.js') }}"></script>

</body>
</html>