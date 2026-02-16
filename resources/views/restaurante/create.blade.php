@extends('components.home')

@section('title', 'TheFork | Crear restaurante')
@section('contenido')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

    .page-wrap { font-family: 'DM Sans', sans-serif; }
    .display-font { font-family: 'Playfair Display', serif; }

    .hero-bg {
        background: linear-gradient(160deg, #003d33 0%, #006252 60%, #00876e 100%);
    }

    .form-input {
        width: 100%;
        background: #f8faf9;
        border: 1.5px solid #d1e8e3;
        border-radius: 10px;
        padding: 0.65rem 1rem;
        font-size: 0.925rem;
        color: #1a2e2a;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: 'DM Sans', sans-serif;
        outline: none;
    }
    .form-input:focus {
        border-color: #006252;
        box-shadow: 0 0 0 3px rgba(0,98,82,0.12);
    }
    .form-input::placeholder { color: #9ab5af; }

    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #3a5c55;
        margin-bottom: 0.4rem;
    }

    .upload-zone {
        border: 2px dashed #a8d5cc;
        border-radius: 12px;
        background: #f0f9f7;
        padding: 2.5rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .upload-zone:hover { background: #e4f4f1; border-color: #006252; }

    .check-grid label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f0f9f7;
        border: 1.5px solid #d1e8e3;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.85rem;
        color: #1a2e2a;
        cursor: pointer;
        transition: all 0.15s;
    }
    .check-grid label:hover { background: #d9f0eb; border-color: #006252; }
    .check-grid input[type="checkbox"] { accent-color: #006252; width: 15px; height: 15px; }

    .submit-btn {
        width: 100%;
        background: #006252;
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        font-size: 1rem;
        padding: 0.9rem;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        letter-spacing: 0.02em;
    }
    .submit-btn:hover { background: #004d41; transform: translateY(-1px); }
    .submit-btn:active { transform: translateY(0); }

    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 999px;
        padding: 0.4rem 1rem;
        font-size: 0.82rem;
        color: #c8ede7;
        backdrop-filter: blur(4px);
    }

    .benefit-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.1rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .benefit-item:last-child { border-bottom: none; }
    .benefit-icon {
        width: 38px;
        height: 38px;
        background: rgba(255,255,255,0.12);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .section-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.5rem 0 1rem;
    }
    .section-divider span {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #006252;
        white-space: nowrap;
    }
    .section-divider::before, .section-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #d1e8e3;
    }
</style>

<div class="page-wrap min-h-screen bg-gray-50">

    <div class="flex min-h-screen">

        {{-- Panel izquierdo --}}
        <div class="hero-bg hidden lg:flex flex-col justify-between w-[42%] p-12 sticky top-0 h-screen">

            <div>
                <span class="text-[#7dd9c8] text-sm font-medium tracking-widest uppercase">Para restaurantes</span>
            </div>

            <div>
                <h1 class="display-font text-white text-5xl leading-tight mb-6">
                    Llena tus mesas.<br>
                    <span class="text-[#7dd9c8]">Cada noche.</span>
                </h1>

                <p class="text-[#a8ddd4] text-base leading-relaxed mb-8 font-light">
                    Accede a millones de comensales y haz crecer tu restaurante con la plataforma de reservas número 1.
                </p>

                <div class="flex flex-wrap gap-2 mb-10">
                    <span class="stat-pill">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        +60.000 restaurantes
                    </span>
                    <span class="stat-pill">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1z"/></svg>
                        Millones de comensales
                    </span>
                    <span class="stat-pill">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012-2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                        Nº1 en reservas online
                    </span>
                </div>

                <div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg class="w-5 h-5 text-[#7dd9c8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium mb-0.5">Reservas en tiempo real</p>
                            <p class="text-[#8ecfc6] text-xs font-light">TheFork, TripAdvisor, tu web, Instagram y más</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg class="w-5 h-5 text-[#7dd9c8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium mb-0.5">Marketing inteligente</p>
                            <p class="text-[#8ecfc6] text-xs font-light">Herramientas para atraer y fidelizar comensales</p>
                        </div>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <svg class="w-5 h-5 text-[#7dd9c8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium mb-0.5">Estadísticas detalladas</p>
                            <p class="text-[#8ecfc6] text-xs font-light">Conoce a tus clientes y optimiza tu negocio</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <img src="{{ asset('media/imgTFM.webp') }}" alt="Restaurante" class="w-full rounded-2xl object-cover max-h-44 opacity-80">
            </div>

        </div>

        {{-- Panel derecho: Formulario --}}
        <div class="flex-1 overflow-y-auto">
            <div class="max-w-2xl mx-auto px-8 py-12">

                <div class="mb-8">
                    <h2 class="display-font text-3xl text-gray-900 mb-1">Registra tu restaurante</h2>
                    <p class="text-gray-500 text-sm">Completa el formulario y revisaremos tu solicitud en menos de 48h.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                        <p class="font-semibold mb-1">Revisa los siguientes errores:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('enviar.solicitud') }}" method="post" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- Imagen --}}
                    <div>
                        <label class="form-label">Imagen del restaurante</label>
                        <div class="upload-zone" onclick="document.getElementById('img').click()">
                            <svg class="w-8 h-8 text-[#006252] mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-[#3a5c55] font-medium">Haz clic para subir una foto</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — máx. 5MB</p>
                            <input type="file" name="img" id="img" accept="image/*" class="hidden">
                        </div>
                    </div>

                    {{-- Título --}}
                    <div>
                        <label for="titulo" class="form-label">Nombre del restaurante</label>
                        <input class="form-input" type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" placeholder="Ej: Restaurante La Pepita">
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="desc" class="form-label">Descripción</label>
                        <textarea class="form-input" name="desc" id="desc" rows="4" placeholder="Describe tu restaurante, su propuesta gastronómica...">{{ old('desc') }}</textarea>
                    </div>

                    {{-- Tipo + Ubicación en dos columnas --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="tipo" class="form-label">Tipo de cocina</label>
                            <select class="form-input" name="tipo" id="tipo">
                                <option value="">— Selecciona —</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}" {{ old('tipo') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="ubi" class="form-label">Localización</label>
                            <input class="form-input" type="text" name="ubi" id="ubi" value="{{ old('ubi') }}" placeholder="Ej: Barcelona, España">
                        </div>
                    </div>

                    {{-- Chef + Precio en dos columnas --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="cheff" class="form-label">Chef</label>
                            <input class="form-input" type="text" name="cheff" id="cheff" value="{{ old('cheff') }}" placeholder="Nombre del chef">
                        </div>
                        <div>
                            <label for="precio" class="form-label">Precio medio (€)</label>
                            <input class="form-input" type="text" name="precio" id="precio" value="{{ old('precio') }}" placeholder="Ej: 35">
                        </div>
                    </div>

                    {{-- Menú --}}
                    <div>
                        <label for="menu" class="form-label">Menú destacado</label>
                        <textarea class="form-input" name="menu" id="menu" rows="3" placeholder="Ej: Paella valenciana, Croquetas de jamón...">{{ old('menu') }}</textarea>
                    </div>

                    {{-- Etiquetas Insignia --}}
                    <div>
                        <div class="section-divider"><span>Etiquetas Insignia</span></div>
                        <div class="check-grid grid grid-cols-3 gap-2">
                            @foreach ($etiquetas as $etiqueta)
                                @if ($etiqueta->tipo == "Insignia")
                                    <label>
                                        <input type="checkbox" name="etiqueta_insignia[]" value="{{ $etiqueta->id }}">
                                        <span>{{ $etiqueta->nombre }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Etiquetas Descriptivas --}}
                    <div>
                        <div class="section-divider"><span>Etiquetas Descriptivas</span></div>
                        <div class="check-grid grid grid-cols-3 gap-2">
                            @foreach ($etiquetas as $etiqueta)
                                @if ($etiqueta->tipo == "Descriptivo")
                                    <label>
                                        <input type="checkbox" name="etiqueta[]" value="{{ $etiqueta->id }}">
                                        <span>{{ $etiqueta->nombre }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-2">
                        <button type="submit" class="submit-btn">
                            Enviar solicitud →
                        </button>
                        <p class="text-xs text-center text-gray-400 mt-3">Tu solicitud será revisada por nuestro equipo en menos de 48h.</p>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection