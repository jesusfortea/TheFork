@extends('components.home')

@section('title', 'TheFork | Editar restaurante')
@section('contenido')
    
    {{-- FORMULARIO DE EDICIÓN DE RESTAURANTE CON DISEÑO PROFESIONAL --}}

    {{-- 
        CONTENEDOR PRINCIPAL CON RESPONSIVE
        - Desktop: 2 columnas (grid-cols-2)
        - Tablet: 1 columna (md:grid-cols-1)
        - Mobile: 1 columna por defecto
    --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8 p-5 md:p-8 lg:p-10">

        {{-- COLUMNA IZQUIERDA - INFORMACIÓN --}}
        <div class="order-2 md:order-1">
            <h1 class="text-3xl md:text-4xl lg:text-5xl text-center md:text-left w-full font-bold text-gray-800 mb-6">
                Edita la información de tu restaurante
            </h1>

            <ul class="p-5 space-y-3">
                <li class="pt-2 pb-2 list-disc text-gray-700 text-base md:text-lg">
                    Actualiza los datos de tu restaurante
                </li>
                <li class="pt-2 pb-2 list-disc text-gray-700 text-base md:text-lg">
                    Mantén tu información siempre actualizada
                </li>
                <li class="pt-2 pb-2 list-disc text-gray-700 text-base md:text-lg">
                    Atrae a más comensales con información precisa
                </li>
            </ul>
            
            <img src="{{ asset('media/imgTFM.webp') }}" alt="TheFork" class="w-full max-w-md mx-auto md:mx-0 mt-6 rounded-lg shadow-lg hidden md:block">
        </div>

        {{-- 
            COLUMNA DERECHA - FORMULARIO
            order-1: Se muestra primero en mobile
            order-2: Se muestra segundo en desktop
        --}}
        <div class="order-1 md:order-2">
            {{-- 
                FORMULARIO DE EDICIÓN
                - action: ruta que procesa la actualización (restaurantes.update)
                - method: POST (requerido por los navegadores)
                - @method('PUT'): indica a Laravel que es una petición PUT
                - enctype: permite subir archivos (imágenes)
            --}}
            <form class="bg-[#00665a] p-6 md:p-8 rounded-lg shadow-xl" action="{{ route('restaurantes.update', $restaurante->id) }}" method="POST" enctype="multipart/form-data">

                {{-- 
                    @csrf: Token de seguridad obligatorio en Laravel para formularios
                    Protege contra ataques CSRF (Cross-Site Request Forgery)
                --}}
                @csrf
                
                {{-- 
                    @method('PUT'): Especifica que este formulario usa el método HTTP PUT
                    Los navegadores solo soportan GET y POST, esto simula PUT
                --}}
                @method('PUT')

                <h1 class="mb-6 text-2xl md:text-3xl w-full text-white font-bold">
                    ✏️ Editar restaurante
                </h1>

                {{-- Mostrar errores de validación si existen --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- 
                    CAMPO DE IMAGEN PERSONALIZADO
                    - Input file oculto
                    - Botón personalizado que activa el input
                    - Preview de la imagen actual
                --}}
                <div class="mb-6">
                    <label class="block text-white font-semibold mb-2">Imagen del restaurante</label>
                    
                    {{-- Contenedor de preview de imagen --}}
                    <div class="border-2 border-white border-dashed rounded-lg p-6 text-center bg-[#005a4d] hover:bg-[#004d42] transition">
                        
                        {{-- Mostrar imagen actual si existe --}}
                        <div id="preview-container" class="mb-4">
                            @if($restaurante->imagen)
                                <img src="{{ asset($restaurante->imagen) }}" 
                                     alt="{{ $restaurante->titulo }}" 
                                     id="image-preview"
                                     class="w-40 h-40 object-cover mx-auto rounded-lg shadow-md">
                                <p class="text-white text-xs mt-2">Imagen actual</p>
                            @else
                                <div class="w-40 h-40 bg-gray-700 mx-auto rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-4xl">📷</span>
                                </div>
                            @endif
                        </div>

                        {{-- Input file oculto --}}
                        <input type="file" 
                               name="img" 
                               id="img" 
                               accept="image/*" 
                               class="hidden"
                               onchange="previewImage(event)">
                        
                        {{-- Botón personalizado para seleccionar archivo --}}
                        <label for="img" class="inline-block bg-white text-[#00665a] font-bold py-3 px-6 rounded-lg cursor-pointer hover:bg-gray-100 transition shadow-md">
                            📁 Seleccionar nueva imagen
                        </label>
                        
                        <p class="text-white text-xs mt-3 opacity-80">
                            JPG, PNG o WEBP (opcional - mantiene la actual si no se cambia)
                        </p>
                    </div>
                </div>

                {{-- CAMPO TÍTULO --}}
                <div class="mb-5">
                    <label for="titulo" class="block text-white font-semibold mb-2">Título *</label>
                    <input class="w-full bg-[#005a4d] text-white border-2 border-white focus:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-300 rounded-lg p-3 transition placeholder-gray-300" 
                           type="text" 
                           name="titulo" 
                           id="titulo" 
                           value="{{ old('titulo', $restaurante->titulo) }}" 
                           placeholder="Nombre del restaurante..."
                           required>
                </div>

                {{-- CAMPO DESCRIPCIÓN --}}
                <div class="mb-5">
                    <label for="desc" class="block text-white font-semibold mb-2">Descripción *</label>
                    <textarea class="w-full bg-[#005a4d] text-white border-2 border-white focus:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-300 rounded-lg p-3 transition placeholder-gray-300 resize-none" 
                              name="desc" 
                              id="desc" 
                              rows="5" 
                              placeholder="Describe tu restaurante..."
                              required>{{ old('desc', $restaurante->descripcion) }}</textarea>
                </div>

                {{-- 
                    CAMPO TIPO DE COCINA PERSONALIZADO
                    - Select con estilos personalizados
                    - Flecha personalizada
                --}}
                <div class="mb-5">
                    <label for="tipo" class="block text-white font-semibold mb-2">Tipo de cocina *</label>
                    <div class="relative">
                        <select class="w-full bg-[#005a4d] text-white border-2 border-white focus:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-300 rounded-lg p-3 pr-10 appearance-none cursor-pointer transition" 
                                name="tipo" 
                                id="tipo"
                                required>
                            <option value="">- Selecciona un tipo -</option>
                            @foreach($tipos as $tipo)
                                <option value="{{$tipo->id}}" {{ old('tipo', $restaurante->id_tipo) == $tipo->id ? 'selected' : '' }}>
                                    {{$tipo->nombre}}
                                </option>
                            @endforeach
                        </select>
                        {{-- Flecha personalizada para el select --}}
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-white">
                            <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- CAMPO LOCALIZACIÓN --}}
                <div class="mb-5">
                    <label for="ubi" class="block text-white font-semibold mb-2">Localización *</label>
                    <input class="w-full bg-[#005a4d] text-white border-2 border-white focus:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-300 rounded-lg p-3 transition placeholder-gray-300" 
                           type="text" 
                           value="{{ old('ubi', $restaurante->ubicacion) }}" 
                           name="ubi" 
                           id="ubi" 
                           placeholder="Dirección completa..."
                           required>
                </div>

                {{-- CAMPO CHEF --}}
                <div class="mb-5">
                    <label for="cheff" class="block text-white font-semibold mb-2">Chef *</label>
                    <input class="w-full bg-[#005a4d] text-white border-2 border-white focus:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-300 rounded-lg p-3 transition placeholder-gray-300" 
                           type="text" 
                           value="{{ old('cheff', $restaurante->cheff) }}" 
                           name="cheff" 
                           id="cheff" 
                           placeholder="Nombre del chef..."
                           required>
                </div>

                {{-- CAMPO PRECIO --}}
                <div class="mb-5">
                    <label for="precio" class="block text-white font-semibold mb-2">Precio medio (€) *</label>
                    <input type="number" 
                           class="w-full bg-[#005a4d] text-white border-2 border-white focus:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-300 rounded-lg p-3 transition placeholder-gray-300" 
                           value="{{ old('precio', $restaurante->precio) }}" 
                           name="precio" 
                           id="precio" 
                           placeholder="Precio por persona..."
                           min="1"
                           required>
                </div>

                {{-- CAMPO MENÚ --}}
                <div class="mb-6">
                    <label for="menu" class="block text-white font-semibold mb-2">Menú *</label>
                    <textarea class="w-full bg-[#005a4d] text-white border-2 border-white focus:border-yellow-300 focus:outline-none focus:ring-2 focus:ring-yellow-300 rounded-lg p-3 transition placeholder-gray-300 resize-none" 
                              name="menu" 
                              id="menu" 
                              rows="5" 
                              placeholder="Platos principales del menú..."
                              required>{{ old('menu', $restaurante->menu) }}</textarea>
                </div>

                {{-- 
                    BOTONES DE ACCIÓN
                    - Responsive: stack vertical en mobile, horizontal en tablet+
                --}}
                <div class="flex flex-col sm:flex-row gap-3 mt-6">
                    <button type="submit" 
                            class="flex-1 p-4 bg-white text-[#00665a] font-bold rounded-lg cursor-pointer hover:bg-yellow-300 hover:shadow-lg transition transform hover:scale-105 text-center">
                        ✅ Actualizar restaurante
                    </button>
                    
                    <button type="button" 
                            class="flex-1 p-4 bg-gray-600 text-white font-bold rounded-lg cursor-pointer hover:bg-gray-700 hover:shadow-lg transition text-center" 
                            onclick="confirmarCancelar(); return false;">
                        ❌ Cancelar
                    </button>
                </div>

            </form>
        </div>

    </div>

    {{-- 
        ESTILOS CSS ADICIONALES PARA PERSONALIZACIÓN
        - Mejoras visuales para inputs
        - Animaciones suaves
    --}}
    <style>
        /* Personalización adicional del select para diferentes navegadores */
        select option {
            background-color: #00665a;
            color: white;
            padding: 10px;
        }

        select option:hover {
            background-color: #007d6f;
        }

        /* Animación de focus para todos los inputs */
        input:focus, textarea:focus, select:focus {
            transform: scale(1.01);
        }

        /* Estilo para el placeholder */
        ::placeholder {
            opacity: 0.7;
        }

        /* Responsive: ocultar imagen decorativa en móviles para ahorrar espacio */
        @media (max-width: 768px) {
            .order-2 img {
                display: none;
            }
        }
    </style>

    {{-- JAVASCRIPT PARA PREVIEW DE IMAGEN Y CONFIRMACIÓN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        /**
         * Función para mostrar preview de la imagen seleccionada
         * Se ejecuta cuando el usuario selecciona un archivo
         * @param {Event} event - Evento del input file
         */
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('image-preview');
            const container = document.getElementById('preview-container');
            
            // Verificar si se seleccionó un archivo
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                // Cuando la imagen se carga, actualizar el preview
                reader.onload = function(e) {
                    // Si ya existe una imagen, actualizarla
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        // Si no existe, crear el elemento img
                        container.innerHTML = `
                            <img src="${e.target.result}" 
                                 id="image-preview"
                                 class="w-40 h-40 object-cover mx-auto rounded-lg shadow-md">
                            <p class="text-white text-xs mt-2">Nueva imagen seleccionada</p>
                        `;
                    }
                };
                
                // Leer el archivo como URL de datos
                reader.readAsDataURL(input.files[0]);
            }
        }

        /**
         * Función para confirmar si el usuario quiere cancelar la edición
         * Se ejecuta cuando se hace click en el botón "Cancelar"
         * Muestra una alerta de confirmación antes de salir
         */
        function confirmarCancelar() {
            // Swal.fire: función de SweetAlert2 para mostrar alertas personalizadas
            Swal.fire({
                title: '¿Cancelar edición?',
                text: 'Los cambios no guardados se perderán',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#0f766e',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Continuar editando'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        }
    </script>

@endsection
