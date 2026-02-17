<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('media/icon.png') }}">
</head>
<body class="bg-white text-slate-800">
    
    
    <header class="border-b sticky top-0 bg-white z-50 shadow-sm">
        {{-- Navbar Superior - Oculto en mobile --}}
        <nav class="border-b border-gray-100 hidden md:block">
            <ul class="flex justify-end gap-6 px-4 md:px-10 py-2 text-[11px] font-bold text-teal-900 uppercase">
                <li><a href="{{ route('crear.restaurante') }}" class="hover:text-teal-700 transition">🏠 Registrar mi restaurante</a></li>
                <li class="text-gray-300">|</li>
                <li><a href="" class="hover:text-teal-700 transition">Ayuda</a></li>
            </ul>
        </nav>

        {{-- Navbar Principal --}}
        <nav class="flex justify-between items-center px-4 md:px-10 py-3">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('media/logo.png') }}" alt="Logo" class="h-7 md:h-9">
                </a>
            </div>
            
            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-3">
                <button class="px-3 md:px-4 py-2 border rounded font-bold text-[11px] md:text-[12px] hover:bg-gray-50 transition whitespace-nowrap">
                    📱 DESCARGAR LA APLICACIÓN
                </button>
                
                @auth
                    {{-- Usuario autenticado: icono con dropdown --}}
                    <div class="relative">
                        <button
                            id="user-dropdown-btn" 
                            onclick="document.getElementById('user-dropdown').classList.toggle('hidden')"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-teal-50 transition">
                            <div class="w-8 h-8 bg-teal-900 text-white rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                                </svg>
                            </div>
                            <span class="text-[12px] font-bold text-teal-900">{{ Auth::user()->name }}</span>
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
                        <button class="px-4 py-2 bg-teal-900 text-white rounded font-bold text-[12px] hover:bg-teal-800 transition whitespace-nowrap">
                            INICIAR SESIÓN
                        </button>
                    </a>
                @endauth
            </div>

            {{-- Mobile Hamburger Menu --}}
            <button 
                id="mobile-menu-btn"
                onclick="toggleMobileMenu()"
                class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                <svg id="hamburger-icon" class="w-6 h-6 text-teal-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="close-icon" class="w-6 h-6 text-teal-900 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </nav>

        {{-- Mobile Menu (Hidden by default) --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-4 space-y-3">
                {{-- Links del navbar superior en mobile --}}
                <a href="{{ route('crear.restaurante') }}" class="block py-2 px-3 text-sm font-bold text-teal-900 hover:bg-teal-50 rounded-lg transition">
                    🏠 Registrar mi restaurante
                </a>
                <a href="" class="block py-2 px-3 text-sm font-bold text-teal-900 hover:bg-teal-50 rounded-lg transition">
                    ❓ Ayuda
                </a>
                
                <hr class="border-gray-200">
                
                {{-- Botón de app --}}
                <button class="w-full py-3 border border-gray-300 rounded-lg font-bold text-sm hover:bg-gray-50 transition">
                    📱 DESCARGAR LA APLICACIÓN
                </button>
                
                @auth
                    {{-- Usuario autenticado en mobile --}}
                    <div class="space-y-2 pt-2">
                        <div class="px-3 py-2 bg-teal-50 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Conectado como</p>
                            <p class="text-sm font-bold text-teal-900">{{ Auth::user()->name }}</p>
                        </div>
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 rounded-lg transition">
                            🛠️ Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 px-3 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-lg transition">
                                🚪 Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Botón de login en mobile --}}
                    <a href="{{ route('login') }}" class="block">
                        <button class="w-full py-3 bg-teal-900 text-white rounded-lg font-bold text-sm hover:bg-teal-800 transition">
                            INICIAR SESIÓN
                        </button>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <script>
        // Función para toggle del menú mobile
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const hamburger = document.getElementById('hamburger-icon');
            const close = document.getElementById('close-icon');
            
            menu.classList.toggle('hidden');
            hamburger.classList.toggle('hidden');
            close.classList.toggle('hidden');
        }

        // Cerrar menú mobile al hacer click fuera
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const menuBtn = document.getElementById('mobile-menu-btn');
            
            if (!menu.contains(event.target) && !menuBtn.contains(event.target)) {
                if (!menu.classList.contains('hidden')) {
                    toggleMobileMenu();
                }
            }
        });
    </script>


    <main>
        @yield('contenido')
    </main>

    <footer class="bg-black text-white py-8 md:py-12 px-4 md:px-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            
            {{-- Columna 1: Descargar aplicación --}}
            <div>
                <h3 class="font-bold text-base md:text-lg mb-4 md:mb-6">Descargar aplicación</h3>
                <div class="flex flex-col gap-3">
                    <div class="border border-gray-600 rounded-lg p-2 flex items-center w-full sm:w-40 cursor-pointer hover:bg-gray-900 transition">
                        <a href="#" class="flex items-center w-full">
                            <img src="{{ asset('media/app_store.png') }}" alt="App Store" class="h-8 md:h-10 w-auto mr-2">
                            <div class="text-[9px]">Download on the <br><span class="text-xs md:text-sm font-bold">App Store</span></div>
                        </a>
                    </div>

                    <div class="border border-gray-600 rounded-lg p-2 flex items-center w-full sm:w-40 cursor-pointer hover:bg-gray-900 transition">
                        <a href="#" class="flex items-center w-full">
                            <img src="{{ asset('media/play_store.png') }}" alt="Google Play" class="h-5 md:h-6 w-auto mr-2">
                            <div class="text-[9px]">Get it on <br><span class="text-xs md:text-sm font-bold">Google Play</span></div>
                        </a>
                    </div>
                </div>
            </div>
        
            {{-- Columna 2: Enlaces principales --}}
            <ul class="text-xs md:text-[13px] font-bold space-y-3 md:space-y-4">
                <li><a href="#" class="hover:text-gray-300 transition">¿Quiénes somos?</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Información de contacto</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">¿Tienes un restaurante?</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Preguntas frecuentes</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Trabaja con nosotros</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Colaboración Guía MICHELIN</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Tarjeta Regalo TheFork</a></li>
            </ul>

            {{-- Columna 3: Enlaces legales --}}
            <ul class="text-xs md:text-[13px] font-bold space-y-3 md:space-y-4">
                <li><a href="#" class="hover:text-gray-300 transition">Programa Yums</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Condiciones de uso</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Declaración de Privacidad y Cookies</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Aceptación de cookies</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Blog</a></li>
                <li><a href="#" class="hover:text-gray-300 transition">Restaurante cerca de mí</a></li>
            </ul>

            {{-- Columna 4: Redes sociales y copyright --}}
            <div class="flex flex-col gap-4 md:gap-6">
                <div class="flex gap-4">
                    <a href="#" class="hover:opacity-75 transition">
                        <img src="{{ asset('media/instagram_logo.png') }}" alt="Instagram" class="w-6 h-6 md:w-8 md:h-8">
                    </a>
                    
                    <a href="#" class="hover:opacity-75 transition">
                        <img src="{{ asset('media/facebook_logo.png') }}" alt="Facebook" class="w-6 h-6 md:w-8 md:h-8">
                    </a>
                </div>
                <p class="text-[10px] md:text-[11px] font-bold leading-tight">
                    © 2026 LA FOURCHETTESAS - <br>
                    TODOS LOS DERECHOS RESERVADOS
                </p>
            </div>
        </div>

        {{-- Aviso legal inferior --}}
        <div class="max-w-7xl mx-auto mt-8 md:mt-12 pt-6 md:pt-8 border-t border-zinc-800">
            <p class="text-[9px] md:text-[10px] text-gray-400 text-center leading-relaxed px-2">
                Las ofertas promocionales están sujetas a las condiciones que figuran en la página del restaurante. Las ofertas en bebidas alcohólicas están dirigidas únicamente a adultos. El consumo excesivo de alcohol es perjudicial para la salud. Bebe con moderación.
            </p>
        </div>
    </footer>


    {{-- Scripts de las vistas hijas --}}
    @stack('scripts')
    <script src="{{ asset('js/home.js') }}"></script>

</body>
</html>