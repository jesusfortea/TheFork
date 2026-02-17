<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TheFork - Restaurante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .btn-filtro-activo { background-color: #00473d !important; color: white !important; border-color: #00473d !important; }
    </style>
    <link rel="icon" type="image/png" href="{{ asset('media/icon.png') }}">
</head>
<body class="bg-white text-gray-800">

    <header class="w-full bg-white border-b sticky top-0 z-[9999] shadow-sm">
        
        <nav class="border-b border-gray-100">
            <ul class="flex justify-end gap-4 px-10 py-2 text-[11px] font-bold text-teal-900 uppercase">
                <li><a href="{{route('crear.restaurante')}}" class="hover:underline flex items-center gap-1">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.25.75a.75.75 0 0 1 .75.75V3h3.75a.75.75 0 0 1 .75.75v18a.75.75 0 0 1-.75.75H2.25a.75.75 0 0 1-.75-.75v-18A.75.75 0 0 1 2.25 3H6V1.5a.75.75 0 0 1 1.5 0V3h9V1.5a.75.75 0 0 1 .75-.75Z"></path></svg>
                    Registrar mi restaurante</a>
                </li>
                <li class="text-gray-200">|</li>
                <li><a href="#" class="hover:underline">Ayuda</a></li>
            </ul>
        </nav>

        <nav class="flex items-center justify-between px-10 py-4 gap-8">

            <a href="{{ route('home') }}">
                <img src="{{ asset('media/logo.png') }}" alt="Logo" class="h-9">
            </a>

            <div class="flex flex-1 items-center border border-gray-300 rounded-lg h-12 bg-white shadow-sm max-w-4xl overflow-hidden group focus-within:ring-1 focus-within:ring-teal-700">
                <div class="flex items-center px-4 gap-2 border-r border-gray-200 min-w-180px">
                    <svg class="text-gray-500" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <input type="text" value="Barcelona" class="outline-none font-bold text-sm w-full text-gray-800 placeholder-gray-400">
                </div>
                <div class="flex items-center px-4 gap-2 flex-1">
                    <svg class="text-gray-400" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="M21 21l-4.35-4.35"></path></svg>
                    {{-- ID para el buscador --}}
                    <input id="input-buscar" type="text" placeholder="Tipo de cocina, nombre del restaurante..." class="outline-none text-sm w-full italic text-gray-500">
                </div>
                <button id="btn-buscar" class="bg-[#006252] text-white font-bold px-8 h-full hover:bg-[#00473d] transition text-sm uppercase tracking-wider">
                    Búsqueda
                </button>
            </div>

            @auth
                <div class="relative">
                    <button
                        onclick="document.getElementById('user-dropdown-2').classList.toggle('hidden')"
                        class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-teal-50 transition">
                        <div class="w-8 h-8 bg-teal-900 text-white rounded-full flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        </div>
                        <span class="text-[12px] font-bold text-teal-900 hidden sm:block">{{ Auth::user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-teal-900" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <div id="user-dropdown-2" class="hidden absolute right-0 mt-2 w-44 bg-white border border-gray-100 rounded-xl shadow-lg z-50 overflow-hidden">
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
                <a href="{{ route('login') }}">
                    <button class="px-4 py-2 bg-teal-900 text-white rounded-lg font-bold text-[12px] hover:bg-teal-800 transition">
                        INICIAR SESIÓN
                    </button>
                </a>
            @endauth
        </nav>

        <div class="flex items-center gap-2 no-scrollbar flex-1 px-10 mb-4 justify-center">
            
            <button class="bg-[#00473d] text-white rounded-full px-5 py-2 text-[12px] font-bold flex items-center gap-2 whitespace-nowrap shadow-sm hover:bg-black transition">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                Todos los filtros
            </button>

            {{-- ID para ofertas especiales --}}
            <button id="btn-ofertas" class="border border-gray-300 rounded-full px-4 py-2 text-[12px] font-bold text-gray-700 flex items-center gap-2 whitespace-nowrap hover:border-gray-800 transition bg-white">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><circle cx="12" cy="12" r="10"></circle><line x1="14.31" y1="8" x2="20.05" y2="17.94"></line><line x1="9.69" y1="8" x2="21.17" y2="8"></line><line x1="7.38" y1="12" x2="13.12" y2="2.06"></line><line x1="9.69" y1="16" x2="3.95" y2="6.06"></line><line x1="14.31" y1="16" x2="2.83" y2="16"></line><line x1="16.62" y1="12" x2="10.88" y2="21.94"></line></svg>
                Ofertas especiales
            </button>

            {{-- Cena hoy: simplemente limpia todos los filtros --}}
            <button id="btn-cena-hoy" class="border border-gray-300 rounded-full px-4 py-2 text-[12px] font-bold text-gray-700 flex items-center gap-2 whitespace-nowrap hover:border-gray-800 transition bg-white">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><circle cx="12" cy="12" r="10"></circle><path d="M12 8v8"></path><path d="M8 12h8"></path></svg>
                Cena hoy
            </button>

            {{-- ID para mejores valorados --}}
            <button id="btn-mejor-valorados" class="border border-gray-300 rounded-full px-4 py-2 text-[12px] font-bold text-gray-700 flex items-center gap-2 whitespace-nowrap hover:border-gray-800 transition bg-white">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                Mejores valorados
            </button>

            {{-- Dropdown tipo de cocina --}}
            <div class="relative dropdown-container">
                <button onclick="toggleDropdown('tipo')" class="border border-gray-300 rounded-full px-4 py-2 text-[12px] font-bold text-gray-700 flex items-center gap-2 whitespace-nowrap hover:border-gray-800 transition bg-white">
                    <svg class="text-gray-400 shrink-0" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="M21 21l-4.35-4.35"></path></svg>
                    <span id="label-tipo">Tipo de cocina</span>
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" class="text-gray-400"><path d="M7 10l5 5 5-5z"/></svg>
                </button>
                
                <div id="drop-tipo" class="hidden absolute top-[130%] left-0 bg-white border border-gray-200 h-64 rounded-xl shadow-2xl p-2 w-[220px] z-[300] overflow-y-auto">
                    <div class="flex flex-col gap-1">
                        <button id="tipo-todos" class="text-left px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-50 rounded-lg transition w-full">
                            Cualquier cocina
                        </button>
                        @foreach($tipos as $tipo)
                            <button class="btn-tipo text-left px-4 py-2 text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-[#006252] rounded-lg transition w-full" data-nombre="{{ $tipo->nombre }}">
                                {{ $tipo->nombre }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Dropdown precio --}}
            <div class="relative dropdown-container">
                <button onclick="toggleDropdown('price')" class="border border-gray-300 rounded-full px-4 py-2 text-[12px] font-bold text-gray-700 flex items-center gap-2 whitespace-nowrap hover:border-gray-800 transition bg-white">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-600"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                    <span id="label-price">Precio</span>
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" class="text-gray-400"><path d="M7 10l5 5 5-5z"/></svg>
                </button>
                
                <div id="drop-price" class="hidden absolute top-[130%] left-0 bg-white border border-gray-200 rounded-xl shadow-2xl p-2 w-[160px] z-[300] overflow-y-auto">
                    <div class="flex flex-col gap-1">
                        <button class="btn-precio text-left px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-50 rounded-lg transition w-full" data-min="" data-max="" data-label="Precio">
                            Cualquier precio
                        </button>
                        <button class="btn-precio text-left px-4 py-2 text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-[#006252] rounded-lg transition w-full" data-min="0" data-max="20" data-label="Menos de 20€">
                            Menos de 20€
                        </button>
                        <button class="btn-precio text-left px-4 py-2 text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-[#006252] rounded-lg transition w-full" data-min="20" data-max="30" data-label="20€ - 30€">
                            20€ - 30€
                        </button>
                        <button class="btn-precio text-left px-4 py-2 text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-[#006252] rounded-lg transition w-full" data-min="30" data-max="40" data-label="30€ - 40€">
                            30€ - 40€
                        </button>
                        <button class="btn-precio text-left px-4 py-2 text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-[#006252] rounded-lg transition w-full" data-min="40" data-max="50" data-label="40€ - 50€">
                            40€ - 50€
                        </button>
                        <button class="btn-precio text-left px-4 py-2 text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-[#006252] rounded-lg transition w-full" data-min="50" data-max="70" data-label="50€ - 70€">
                            50€ - 70€
                        </button>
                        <button class="btn-precio text-left px-4 py-2 text-sm font-medium text-gray-700 hover:bg-teal-50 hover:text-[#006252] rounded-lg transition w-full" data-min="70" data-max="99999" data-label="Más de 70€">
                            Más de 70€
                        </button>
                    </div>
                </div>
            </div>

            {{-- ID para insider --}}
            <button id="btn-insider" class="border border-gray-300 rounded-full px-4 py-2 text-[12px] font-bold text-gray-700 flex items-center gap-2 whitespace-nowrap hover:border-gray-800 transition bg-white">
                <div class="bg-gray-800 text-white text-[8px] font-black px-1 rounded-sm flex items-center justify-center h-4 w-4 tracking-tighter">
                    IN
                </div>
                INSIDER
            </button>
        </div>
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
                        <a href="#"><img src="{{ asset('media/app_store.png') }}" alt="App Store" class="h-10 w-auto mr-2"></a>
                        <div class="text-[9px]">Download on the <br><span class="text-sm font-bold">App Store</span></div>
                    </div>
                </div><br>
                <div class="border border-gray-600 rounded-lg p-2 flex items-center w-40 cursor-pointer">
                    <a href="#"><img src="{{ asset('media/play_store.png') }}" alt="Google Play" class="h-6 w-auto mr-2"></a>
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
                    <a href="#"><img src="{{ asset('media/instagram_logo.png') }}" alt="Instagram" class="w-6 h-6"></a>
                    <a href="#"><img src="{{ asset('media/facebook_logo.png') }}" alt="Facebook" class="w-6 h-6"></a>
                </div>
                <p class="text-[11px] font-bold leading-tight">© 2026 LA FOURCHETTESAS - <br>TODOS LOS DERECHOS RESERVADOS</p>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12 pt-8 border-t border-zinc-800">
            <p class="text-[10px] text-gray-400 text-center leading-relaxed">
                Las ofertas promocionales están sujetas a las condiciones que figuran en la página del restaurante. Las ofertas en bebidas alcohólicas están dirigidas únicamente a adultos. El consumo excesivo de alcohol es perjudicial para la salud. Bebe con moderación.
            </p>
        </div>
    </footer>

    <script>
        // ── Dropdowns (solo tipo y precio) ─────────
        function toggleDropdown(id) {
            const ids = ['price', 'tipo'];
            const target = document.getElementById(`drop-${id}`);
            const isHidden = target.classList.contains('hidden');
            ids.forEach(item => document.getElementById(`drop-${item}`).classList.add('hidden'));
            if (isHidden) target.classList.remove('hidden');
        }

        window.onclick = function(event) {
            if (!event.target.closest('.dropdown-container')) {
                ['price', 'tipo'].forEach(id => {
                    document.getElementById(`drop-${id}`).classList.add('hidden');
                });
            }
        }
    </script>
</body>
</html>