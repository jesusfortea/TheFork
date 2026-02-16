@extends('components.home')

@section('title', 'TheFork | Editar restaurante')
@section('contenido')
    
    {{-- FORMULARIO DE EDICIÓN DE RESTAURANTE --}}

    <div class="grid grid-cols-2 gap-5 p-5">

        <div>
            <h1 class="text-5xl text-center w-full">Edita la información de tu restaurante</h1>
        
            <br>

            <ul class="p-5">

                <li class="pt-2 pb-2 list-disc">Actualiza los datos de tu restaurante</li>
                <li class="pt-2 pb-2 list-disc">Mantén tu información siempre actualizada</li>
                <li class="pt-2 pb-2 list-disc">Atrae a más comensales con información precisa</li>

            </ul>
        
            <br>
            
            <img src="{{ asset('media/imgTFM.webp') }}" alt="No se ha podido cargar la imagen">
        
        </div>

        {{-- 
            FORMULARIO DE EDICIÓN
            - action: ruta que procesa la actualización (restaurantes.update)
            - method: POST (requerido por los navegadores)
            - @method('PUT'): indica a Laravel que es una petición PUT
            - enctype: permite subir archivos (imágenes)
        --}}
        <form class="bg-[#00665a] p-5 rounded" action="{{ route('restaurantes.update', $restaurante->id) }}" method="POST" enctype="multipart/form-data">

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

            <h1 class="mb-5 mt-5 text-3xl w-full text-white">Editar restaurante</h1>

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
                CAMPO DE IMAGEN
                - Muestra la imagen actual si existe
                - Permite subir una nueva imagen (opcional)
                - Si no se sube nueva imagen, se mantiene la actual
            --}}
            <div class="h-60 border-2 rounded content-center text-center">
                {{-- Mostrar imagen actual si existe --}}
                @if($restaurante->imagen)
                    <div class="mb-3">
                        <p class="text-white text-sm mb-2">Imagen actual:</p>
                        <img src="{{ asset($restaurante->imagen) }}" alt="{{ $restaurante->titulo }}" class="w-32 h-32 object-cover mx-auto rounded">
                    </div>
                @endif
                <label class="text-white text-sm">Cambiar imagen (opcional):</label>
                <input class="text-white" type="file" name="img" id="img" accept="image/*">
            </div>

            <br>

            {{-- 
                CAMPO TÍTULO
                - value: se rellena con el valor actual del restaurante
                - old('titulo'): mantiene el valor si hay error de validación
            --}}
            <label for="titulo" class="text-white">Título</label><br>
            <input class="w-full bg-[#00665a] text-white border-2 rounded p-2" type="text" name="titulo" id="titulo" value="{{ old('titulo', $restaurante->titulo) }}" placeholder="Escribe algo...">

            <br><br>

            {{-- 
                CAMPO DESCRIPCIÓN
                - old('desc', $restaurante->descripcion): prioriza el valor antiguo si hay error,
                  de lo contrario muestra el valor actual de la BD
            --}}
            <label for="desc" class="text-white">Descripción</label><br>
            <textarea class="w-full bg-[#00665a] text-white border-2 rounded p-2" name="desc" id="desc" rows="5" placeholder="Escribe algo...">{{ old('desc', $restaurante->descripcion) }}</textarea>
                
            <br><br>

            {{-- 
                CAMPO TIPO DE COCINA
                - Muestra todos los tipos disponibles
                - Selecciona automáticamente el tipo actual del restaurante
            --}}
            <label for="tipo" class="text-white">Tipo de cocina</label><br>
            <select class="w-full bg-[#00665a] text-white border-2 rounded p-2" name="tipo" id="tipo">

                <option value="">- Selecciona un tipo -</option>

                {{-- 
                    Loop por todos los tipos de cocina
                    selected: marca como seleccionado el tipo actual del restaurante
                --}}
                @foreach($tipos as $tipo)
                    <option value="{{$tipo->id}}" {{ old('tipo', $restaurante->id_tipo) == $tipo->id ? 'selected' : '' }}>
                        {{$tipo->nombre}}
                    </option>
                @endforeach

            </select>
            
            <br><br>

            {{-- CAMPO LOCALIZACIÓN --}}
            <label for="ubi" class="text-white">Localización</label><br>
            <input class="w-full bg-[#00665a] text-white border-2 rounded p-2" type="text" value="{{ old('ubi', $restaurante->ubicacion) }}" name="ubi" id="ubi" placeholder="Escribe algo...">
            
            <br><br>

            {{-- CAMPO CHEF --}}
            <label for="cheff" class="text-white">Chef</label><br>
            <input class="w-full bg-[#00665a] text-white border-2 rounded p-2" type="text" value="{{ old('cheff', $restaurante->cheff) }}" name="cheff" id="cheff" placeholder="Escribe algo...">
            
            <br>
            <br>

            {{-- CAMPO PRECIO --}}
            <label for="precio" class="text-white">Precio</label>
            <input type="text" class="w-full bg-[#00665a] text-white border-2 rounded p-2" value="{{ old('precio', $restaurante->precio) }}" name="precio" id="precio" placeholder="Escribe algo...">

            <br>
            <br>

            {{-- CAMPO MENÚ --}}
            <label for="menu" class="text-white">Menú</label><br>
            <textarea class="w-full bg-[#00665a] text-white border-2 rounded p-2" name="menu" id="menu" rows="5" placeholder="Escribe algo...">{{ old('menu', $restaurante->menu) }}</textarea>
               

            <br>
            <br>

            {{-- 
                BOTONES DE ACCIÓN
                - Botón "Actualizar": envía el formulario (submit)
                - Botón "Cancelar": vuelve a la página anterior usando JavaScript inline
                  onclick: evento inline (sin addEventListener como pidió el usuario)
            --}}
            <div class="flex gap-3">
                <input class="p-3 bg-[#00665a] border-2 cursor-pointer text-white rounded hover:bg-[#007d6f]" type="submit" value="Actualizar restaurante">
                
                {{-- 
                    Botón cancelar con JavaScript inline
                    window.history.back(): método que vuelve a la página anterior
                    return false: previene el comportamiento por defecto del botón
                --}}
                <button type="button" class="p-3 bg-gray-600 border-2 cursor-pointer text-white rounded hover:bg-gray-700" onclick="confirmarCancelar(); return false;">
                    Cancelar
                </button>
            </div>

        </form>

    </div>

    {{-- 
        JAVASCRIPT PARA CONFIRMACIÓN
        - SweetAlert2: librería para alertas bonitas
        - Evento inline (no usa addEventListener)
    --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
                showCancelButton: true,  // Muestra botón de cancelar
                confirmButtonColor: '#dc2626',  // Color rojo para confirmar
                cancelButtonColor: '#0f766e',   // Color verde para cancelar
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Continuar editando'
            }).then((result) => {
                // Si el usuario confirma que quiere salir
                if (result.isConfirmed) {
                    // window.history.back() vuelve a la página anterior
                    window.history.back();
                }
                // Si cancela, no hace nada (se queda en el formulario)
            });
        }
    </script>

@endsection
