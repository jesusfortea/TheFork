<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <a href=""><img src="{{ asset('media/logo.png') }}" alt="Logo" class="h-9"></a>
                </li>
                
                <section class="flex ml-auto gap-3">
                    <li>
                        <button class="px-4 py-2 border rounded font-bold text-[12px]">
                            📱 DESCARGAR LA APLICACIÓN
                        </button>
                    </li>
                    <li>
                        <a href="{{ route('login') }}">
                            <button class="px-4 py-2 bg-teal-900 text-white rounded font-bold text-[12px]">
                                INICIAR SESIÓN
                            </button>
                        </a>
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

</body>
</html>