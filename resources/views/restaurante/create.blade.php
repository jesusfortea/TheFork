@extends('components.home')

@section('title', 'TheFork | Crear restaurante')
@section('contenido')
    
    {{-- ¡EMPEZAR CODIGO DESDE AQUI! --}}

    <div class="grid grid-cols-2 gap-5 p-5">

        <div>
            <h1 class="text-5xl text-center w-full">Accede a millones de comensales y llena tus mesas vacías</h1>
        
            <br>

            <ul class="p-5">

                <li class="pt-2 pb-2 list-disc">Únete a la plataforma de reservas número 1</li>
                <li class="pt-2 pb-2 list-disc">Abre tus reservas al instante en todos los canales: TheFork, TripAdvisor, tu sitio web, Facebook, Instagram y más</li>
                <li class="pt-2 pb-2 list-disc">Atrae a más comensales con herramientas de marketing</li>

            </ul>
        
            <br>
            
            <img src="{{ asset('media/imgTFM.webp') }}" alt="No se ha podido cargar la imagen">
        
        </div>

        {{-- Formulario para crear un restaurante --}}
        <form class="bg-[#00665a] p-5 rounded" action="{{ route('enviar.solicitud') }}" method="post">

            @csrf

            <h1 class="mb-5 mt-5 text-3xl w-full text-white">Registrar mi restaurante</h1>

            @error('message')

                <p>{{ $message }}</p>
                
            @enderror

            <div class=" h-60 border-2 rounded content-center text-center">
                <input class="text-white" type="file" name="img" id="img" value="{{ old('img') }}">
            </div>

            <br>

            <label for="titulo" class="text-white">Título</label><br>
            <input class="w-full bg-[#00665a] text-white border-2 rounded p-2" type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" placeholder="Escribe algo...">

            <br><br>

            <label for="desc" class="text-white">Descripción</label><br>
            <textarea class="w-full bg-[#00665a] text-white border-2 rounded p-2" name="desc" id="desc" rows="5" value="{{ old('desc') }}" placeholder="Escribe algo..."></textarea>
                
            <br><br>

            <label for="tipo" class="text-white">Tipo de cocina</label><br>
            <select class="w-full bg-[#00665a] text-white border-2 rounded p-2" name="tipo" value="{{ old('tipo') }}" id="tipo">

                <option value="" disabled selected>- Selecciona un tipo -</option>

                @foreach($tipos as $tipo)

                    <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>

                @endforeach

            </select>
            
            <br><br>

            <label for="etiqueta" class="text-white">Etiquetas Insignia</label><br>
            <div class="border-2 text-white rounded p-4 grid grid-cols-3 gap-5">
                @foreach ($etiquetas as $etiqueta)
                    @if ($etiqueta->tipo == "Insignia")
                        <label class="block mb-2">
                            <input type="checkbox" name="etiqueta_insignia[]" value="{{ $etiqueta->id }}" class="mr-2">
                            <span class="text-white">{{ $etiqueta->nombre }}</span>
                        </label>
                    @endif
                @endforeach
            </div>

            <br>

            <label for="etiqueta" class="text-white">Etiquetas Descriptivas</label><br>
            <div class="border-2 rounded p-4 grid grid-cols-3 gap-5">
                @foreach ($etiquetas as $etiqueta)
                    @if ($etiqueta->tipo == "Descriptivo")
                        <label class="block mb-2">
                            <input type="checkbox" class="text-white" name="etiqueta[]" value="{{ $etiqueta->id }}" class="mr-2">
                            <span class="text-white">{{ $etiqueta->nombre }}</span>
                        </label>
                    @endif
                @endforeach
            </div>

            <br>

            <label for="ubi" class="text-white">Localización</label><br>
            <input class="w-full bg-[#00665a] text-white border-2 rounded p-2" type="text" value="{{ old('tipo') }}" name="ubi" id="ubi" placeholder="Escribe algo...">
            
            <br><br>

            <label for="cheff" class="text-white">Cheff</label><br>
            <input class="w-full bg-[#00665a] text-white border-2 rounded p-2" type="text" value="{{ old('tipo') }}" name="cheff" id="cheff" placeholder="Escribe algo...">
            
            <br>
            <br>

            <label for="precio" class="text-white">Precio</label>
            <input type="text" class="w-full bg-[#00665a] text-white border-2 rounded p-2" value="{{ old('precio') }}" name="precio" id="precio" placeholder="Escribe algo...">

            <br>
            <br>

            <label for="menu" class="text-white">Menú</label><br>
            <textarea class="w-full bg-[#00665a] text-white border-2 rounded p-2" name="menu" id="menu" rows="5" value="{{ old('menu') }}" placeholder="Escribe algo..."></textarea>
               

            <br>
            <br>

            
            <input class="p-3 bg-[#00665a] border-2 cursor-pointer text-white rounded" type="submit" name="crear" id="crear" value="Enviar solicitud">

        </form>

    </div>



    


@endsection