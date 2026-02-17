// =============================================
//  FILTROS AJAX RESTAURANTES - COMPLETO
// =============================================

let filtrosActivos = {
    buscar: null,
    tipo: null,
    precio_min: null,
    precio_max: null,
    ofertas_especiales: false,
    insider: false,
    mejor_valorados: false,
};

// ── Aplicar filtros ──────────────────────────
async function aplicarFiltros() {
    console.log('Aplicando filtros:', filtrosActivos);
    
    const lista = document.getElementById('restaurantList');
    lista.innerHTML = '<div class="text-center py-20"><p class="text-gray-400 text-lg">Cargando restaurantes...</p></div>';
    
    try {
        const params = new URLSearchParams();
        
        if (filtrosActivos.buscar) params.append('buscar', filtrosActivos.buscar);
        if (filtrosActivos.tipo) params.append('tipo', filtrosActivos.tipo);
        if (filtrosActivos.precio_min) params.append('precio_min', filtrosActivos.precio_min);
        if (filtrosActivos.precio_max) params.append('precio_max', filtrosActivos.precio_max);
        if (filtrosActivos.ofertas_especiales) params.append('ofertas_especiales', 'true');
        if (filtrosActivos.insider) params.append('insider', 'true');
        if (filtrosActivos.mejor_valorados) params.append('mejor_valorados', 'true');
        
        console.log('URL:', `/restaurantes/filtrar?${params.toString()}`);
        
        const res = await fetch(`/restaurantes/filtrar?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
            }
        });
        
        const data = await res.json();
        console.log('Respuesta:', data);
        
        if (data.restaurantes && data.restaurantes.length > 0) {
            lista.innerHTML = data.restaurantes.map(rest => generarTarjetaRestaurante(rest)).join('');
            
            // Reinicializar botones de reserva
            document.querySelectorAll('[data-btn-reservar]').forEach(btn => {
                btn.onclick = function (e) {
                    e.preventDefault();
                    abrirModalRestaurante(this.dataset.id, this.dataset.titulo);
                };
            });
            
            // Reinicializar menú expandible
            if (typeof inicializarMenuExpandible === 'function') {
                inicializarMenuExpandible();
            }
        } else {
            lista.innerHTML = `
                <div class="bg-white p-16 text-center rounded-2xl border-2 border-dashed border-gray-300">
                    <p class="text-gray-400 text-lg mb-2">No se encontraron restaurantes</p>
                    <p class="text-gray-500 text-sm">Prueba con otros filtros</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error al filtrar:', error);
        lista.innerHTML = `
            <div class="bg-red-50 p-8 text-center rounded-2xl border border-red-200">
                <p class="text-red-600 font-bold">Error: ${error.message}</p>
            </div>
        `;
    }
}

// ── Generar HTML de tarjeta (SIN CAMBIOS) ──
function generarTarjetaRestaurante(rest) {
    const rating = rest.resenas_avg_puntuacion ? rest.resenas_avg_puntuacion.toFixed(1) : (Math.random() * 1 + 9).toFixed(1);
    const reviews = rest.resenas ? rest.resenas.length : Math.floor(Math.random() * 450 + 50);
    
    return `
        <div class="restaurant-card bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden flex flex-col md:flex-row h-auto hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
            
            <div class="md:w-2/5 relative overflow-hidden">
                <img src="${rest.imagen.startsWith('http') ? rest.imagen : '/' + rest.imagen}" alt="${rest.titulo}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                
                <div class="absolute top-4 left-4">
                    <span class="bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-black text-[#006252] shadow-lg uppercase flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Destacado
                    </span>
                </div>

                <div class="absolute bottom-4 right-4">
                    <span class="bg-red-500 text-white px-3 py-1.5 rounded-full text-xs font-black shadow-lg">
                        -30% OFF
                    </span>
                </div>
            </div>

            <div class="md:w-3/5 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-2xl font-black text-gray-900 leading-tight hover:text-[#006252] transition">
                                ${rest.titulo}
                            </h3>
                            <div class="flex items-center gap-2 mt-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-sm text-gray-500 font-medium">${rest.ubicacion}</p>
                            </div>
                            
                            <div class="flex items-center gap-4 mt-3">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-xs text-gray-500">Chef: <span class="font-bold text-gray-700">${rest.cheff}</span></span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-xs text-gray-500">Precio medio: <span class="font-black text-[#006252] text-base">${rest.precio}€</span></span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center bg-gradient-to-br from-[#006252] to-[#004d40] px-4 py-3 rounded-2xl shadow-lg">
                            <span class="text-white text-2xl font-black block">${rating}</span>
                            <div class="flex gap-0.5 mt-1">
                                ${Array(5).fill('<svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>').join('')}
                            </div>
                            <span class="text-[10px] text-white/80 font-semibold uppercase mt-1 block">${reviews} reviews</span>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-[#e6f6f4] to-[#d0f0ed] text-[#006252] px-3 py-1.5 rounded-lg text-xs font-black shadow-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/>
                            </svg>
                            -30% en carta
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                            </svg>
                            Disponible hoy
                        </span>
                    </div>
                    
                    <div class="mt-4 bg-gray-50 rounded-xl p-3 border-l-4 border-[#006252]">
                        <p class="text-sm italic text-gray-600 font-medium leading-relaxed line-clamp-2" id="menu-${rest.id}">
                            "${rest.menu}"
                        </p>
                        ${rest.menu.length > 100 ? `
                        <button class="toggle-menu mt-2 text-xs font-bold text-[#006252] hover:text-[#004d40] transition flex items-center gap-1" data-menu-id="menu-${rest.id}">
                            <span class="toggle-text">Ver más</span>
                            <svg class="w-3 h-3 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        ` : ''}
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between gap-3">
                    <button 
                        data-btn-reservar
                        data-id="${rest.id}"
                        data-titulo="${rest.titulo}"
                        class="flex-1 bg-gradient-to-r from-[#006252] to-[#004d40] text-white px-6 py-3 rounded-xl font-black text-sm hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Reservar Mesa
                    </button>
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;
}

// ── Inicializar filtros al cargar ──
document.addEventListener('DOMContentLoaded', function() {
    console.log('Filtros inicializados');
    
    // 1. BUSCADOR
    const inputBuscar = document.querySelector('input[placeholder*="Tipo de cocina"]');
    if (inputBuscar) {
        let timeoutBuscar;
        inputBuscar.oninput = function() {
            clearTimeout(timeoutBuscar);
            timeoutBuscar = setTimeout(() => {
                filtrosActivos.buscar = this.value.trim() || null;
                aplicarFiltros();
            }, 500); // Espera 500ms después de dejar de escribir
        };
    }
    
    // 2. BOTONES DE FILTRO
    // Ofertas especiales
    const btnOfertas = document.querySelector('button:has(svg) + button:has(svg)'); // Segundo botón con SVG
    if (btnOfertas && btnOfertas.textContent.includes('Ofertas especiales')) {
        btnOfertas.onclick = function() {
            filtrosActivos.ofertas_especiales = !filtrosActivos.ofertas_especiales;
            this.classList.toggle('bg-[#00473d]');
            this.classList.toggle('text-white');
            aplicarFiltros();
        };
    }
    
    // Cena hoy (ya muestra todos, no hace falta filtrar)
    
    // Mejor valorados
    const btnMejorValorados = Array.from(document.querySelectorAll('button')).find(el => 
        el.textContent.includes('Mejores valorados')
    );
    if (btnMejorValorados) {
        btnMejorValorados.onclick = function() {
            filtrosActivos.mejor_valorados = !filtrosActivos.mejor_valorados;
            this.classList.toggle('bg-[#00473d]');
            this.classList.toggle('text-white');
            aplicarFiltros();
        };
    }
    
    // Insider
    const btnInsider = Array.from(document.querySelectorAll('button')).find(el => 
        el.textContent.includes('INSIDER')
    );
    if (btnInsider) {
        btnInsider.onclick = function() {
            filtrosActivos.insider = !filtrosActivos.insider;
            this.classList.toggle('bg-[#00473d]');
            this.classList.toggle('text-white');
            aplicarFiltros();
        };
    }
    
    // 3. TIPO DE COCINA (interceptar clics)
    document.querySelectorAll('#drop-tipo button').forEach(btn => {
        const clickOriginal = btn.onclick;
        btn.onclick = function() {
            const texto = this.textContent.trim();
            if (texto === 'Cualquier cocina') {
                filtrosActivos.tipo = null;
            } else {
                filtrosActivos.tipo = texto;
            }
            if (clickOriginal) clickOriginal.call(this);
            setTimeout(() => aplicarFiltros(), 100);
        };
    });
    
    // 4. PRECIO (interceptar clics)
    document.querySelectorAll('#drop-price button').forEach(btn => {
        const clickOriginal = btn.onclick;
        btn.onclick = function() {
            const texto = this.textContent.trim();
            if (texto === 'Precio') {
                filtrosActivos.precio_min = null;
                filtrosActivos.precio_max = null;
            } else {
                if (texto.includes('Menos de')) {
                    filtrosActivos.precio_min = 0;
                    filtrosActivos.precio_max = parseInt(texto.match(/\d+/)[0]);
                } else if (texto.includes('Más de')) {
                    filtrosActivos.precio_min = parseInt(texto.match(/\d+/)[0]);
                    filtrosActivos.precio_max = 99999;
                } else {
                    const nums = texto.match(/\d+/g);
                    if (nums && nums.length >= 2) {
                        filtrosActivos.precio_min = parseInt(nums[0]);
                        filtrosActivos.precio_max = parseInt(nums[1]);
                    }
                }
            }
            if (clickOriginal) clickOriginal.call(this);
            setTimeout(() => aplicarFiltros(), 100);
        };
    });
});