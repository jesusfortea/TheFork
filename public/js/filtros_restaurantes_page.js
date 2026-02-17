// =============================================
//  FILTROS AJAX RESTAURANTES
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
    const lista = document.getElementById('restaurantList');
    lista.innerHTML = '<div class="text-center py-20"><p class="text-gray-400 text-lg">Cargando...</p></div>';

    const params = new URLSearchParams();
    if (filtrosActivos.buscar) params.append('buscar', filtrosActivos.buscar);
    if (filtrosActivos.tipo) params.append('tipo', filtrosActivos.tipo);
    if (filtrosActivos.precio_min !== null) params.append('precio_min', filtrosActivos.precio_min);
    if (filtrosActivos.precio_max !== null) params.append('precio_max', filtrosActivos.precio_max);
    if (filtrosActivos.ofertas_especiales) params.append('ofertas_especiales', 'true');
    if (filtrosActivos.insider) params.append('insider', 'true');
    if (filtrosActivos.mejor_valorados) params.append('mejor_valorados', 'true');

    try {
        const res = await fetch(`/restaurantes/filtrar?${params.toString()}`, {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        if (!data.success) {
            lista.innerHTML = `<div class="bg-red-50 p-8 text-center rounded-2xl border border-red-200"><p class="text-red-600 font-bold">${data.message}</p></div>`;
            return;
        }

        if (data.restaurantes.length > 0) {
            lista.innerHTML = data.restaurantes.map(rest => tarjeta(rest)).join('');
            reinicializarEventos();
        } else {
            lista.innerHTML = `
                <div class="bg-white p-16 text-center rounded-2xl border-2 border-dashed border-gray-300">
                    <p class="text-gray-400 text-lg mb-2">No se encontraron restaurantes</p>
                    <p class="text-gray-500 text-sm">Prueba con otros filtros</p>
                </div>
            `;
        }
    } catch (err) {
        console.error(err);
        lista.innerHTML = `<div class="bg-red-50 p-8 text-center rounded-2xl"><p class="text-red-600 font-bold">Error de conexión</p></div>`;
    }
}

// ── Reinicializar eventos tras renderizar ────
function reinicializarEventos() {
    // Botones de reservar
    document.querySelectorAll('[data-btn-reservar]').forEach(btn => {
        btn.onclick = function() {
            abrirModalRestaurante(this.dataset.id, this.dataset.titulo);
        };
    });

    // Menú expandible
    if (typeof inicializarMenuExpandible === 'function') {
        inicializarMenuExpandible();
    }
}

// ── Toggle visual de botones de filtro ───────
function toggleBtnFiltro(btn, activo) {
    if (activo) {
        btn.classList.add('btn-filtro-activo');
    } else {
        btn.classList.remove('btn-filtro-activo');
    }
}

// ── Generar HTML de tarjeta ──────────────────
function tarjeta(rest) {
    const img = rest.imagen.startsWith('http') ? rest.imagen : '/' + rest.imagen;
    const rating = rest.resenas_avg_puntuacion ? parseFloat(rest.resenas_avg_puntuacion).toFixed(1) : '9.' + Math.floor(Math.random() * 9);
    const reviews = rest.resenas ? rest.resenas.length : Math.floor(Math.random() * 450 + 50);
    const stars = Array(5).fill(`<svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>`).join('');
    const verMas = rest.menu.length > 100 ? `
        <button class="toggle-menu mt-2 text-xs font-bold text-[#006252] hover:text-[#004d40] transition flex items-center gap-1" data-menu-id="menu-${rest.id}">
            <span class="toggle-text">Ver más</span>
            <svg class="w-3 h-3 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>` : '';

    return `
        <div class="restaurant-card bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden flex flex-col md:flex-row hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
            <div class="md:w-2/5 relative overflow-hidden">
                <img src="${img}" alt="${rest.titulo}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                <div class="absolute top-4 left-4">
                    <span class="bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-black text-[#006252] shadow-lg uppercase flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Destacado
                    </span>
                </div>
                <div class="absolute bottom-4 right-4">
                    <span class="bg-red-500 text-white px-3 py-1.5 rounded-full text-xs font-black shadow-lg">-30% OFF</span>
                </div>
            </div>

            <div class="md:w-3/5 p-6 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex-1">
                            <h3 class="text-2xl font-black text-gray-900 leading-tight hover:text-[#006252] transition">${rest.titulo}</h3>
                            <div class="flex items-center gap-2 mt-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <p class="text-sm text-gray-500 font-medium">${rest.ubicacion}</p>
                            </div>
                            <div class="flex items-center gap-4 mt-3">
                                <span class="text-xs text-gray-500">Chef: <span class="font-bold text-gray-700">${rest.cheff}</span></span>
                                <span class="text-xs text-gray-500">Precio medio: <span class="font-black text-[#006252] text-base">${rest.precio}€</span></span>
                            </div>
                        </div>

                        <div class="text-center bg-gradient-to-br from-[#006252] to-[#004d40] px-4 py-3 rounded-2xl shadow-lg shrink-0">
                            <span class="text-white text-2xl font-black block">${rating}</span>
                            <div class="flex gap-0.5 mt-1">${stars}</div>
                            <span class="text-[10px] text-white/80 font-semibold uppercase mt-1 block">${reviews} reviews</span>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-[#e6f6f4] to-[#d0f0ed] text-[#006252] px-3 py-1.5 rounded-lg text-xs font-black shadow-sm">-30% en carta</span>
                        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold">Disponible hoy</span>
                    </div>

                    <div class="mt-4 bg-gray-50 rounded-xl p-3 border-l-4 border-[#006252]">
                        <p class="text-sm italic text-gray-600 font-medium leading-relaxed line-clamp-2" id="menu-${rest.id}">"${rest.menu}"</p>
                        ${verMas}
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between gap-3">
                    <button data-btn-reservar data-id="${rest.id}" data-titulo="${rest.titulo}"
                        class="flex-1 bg-gradient-to-r from-[#006252] to-[#004d40] text-white px-6 py-3 rounded-xl font-black text-sm hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Reservar Mesa
                    </button>
                    <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    `;
}

// ── Inicializar todos los eventos ─────────────
document.addEventListener('DOMContentLoaded', function () {

    // 1. BUSCADOR - busca al escribir (debounce 500ms) y al pulsar el botón
    const inputBuscar = document.getElementById('input-buscar');
    const btnBuscar = document.getElementById('btn-buscar');
    let timeoutBuscar;

    if (inputBuscar) {
        inputBuscar.oninput = function () {
            clearTimeout(timeoutBuscar);
            timeoutBuscar = setTimeout(() => {
                filtrosActivos.buscar = this.value.trim() || null;
                aplicarFiltros();
            }, 500);
        };
    }

    if (btnBuscar) {
        btnBuscar.onclick = function () {
            filtrosActivos.buscar = inputBuscar?.value.trim() || null;
            aplicarFiltros();
        };
    }

    // 2. OFERTAS ESPECIALES
    const btnOfertas = document.getElementById('btn-ofertas');
    if (btnOfertas) {
        btnOfertas.onclick = function () {
            filtrosActivos.ofertas_especiales = !filtrosActivos.ofertas_especiales;
            toggleBtnFiltro(this, filtrosActivos.ofertas_especiales);
            aplicarFiltros();
        };
    }

    // 3. CENA HOY - resetea todos los filtros
    const btnCenaHoy = document.getElementById('btn-cena-hoy');
    if (btnCenaHoy) {
        btnCenaHoy.onclick = function () {
            filtrosActivos = { buscar: null, tipo: null, precio_min: null, precio_max: null, ofertas_especiales: false, insider: false, mejor_valorados: false };
            if (inputBuscar) inputBuscar.value = '';
            document.getElementById('label-tipo').textContent = 'Tipo de cocina';
            document.getElementById('label-price').textContent = 'Precio';
            document.querySelectorAll('.btn-filtro-activo').forEach(b => b.classList.remove('btn-filtro-activo'));
            aplicarFiltros();
        };
    }

    // 4. MEJORES VALORADOS
    const btnMejorValorados = document.getElementById('btn-mejor-valorados');
    if (btnMejorValorados) {
        btnMejorValorados.onclick = function () {
            filtrosActivos.mejor_valorados = !filtrosActivos.mejor_valorados;
            toggleBtnFiltro(this, filtrosActivos.mejor_valorados);
            aplicarFiltros();
        };
    }

    // 5. TIPO DE COCINA
    document.getElementById('tipo-todos')?.addEventListener('click', function () {
        filtrosActivos.tipo = null;
        document.getElementById('label-tipo').textContent = 'Tipo de cocina';
        document.getElementById('drop-tipo').classList.add('hidden');
        aplicarFiltros();
    });

    document.querySelectorAll('.btn-tipo').forEach(btn => {
        btn.onclick = function () {
            filtrosActivos.tipo = this.dataset.nombre;
            document.getElementById('label-tipo').textContent = this.dataset.nombre;
            document.getElementById('drop-tipo').classList.add('hidden');
            aplicarFiltros();
        };
    });

    // 6. PRECIO
    document.querySelectorAll('.btn-precio').forEach(btn => {
        btn.onclick = function () {
            const min = this.dataset.min;
            const max = this.dataset.max;
            filtrosActivos.precio_min = min !== '' ? parseInt(min) : null;
            filtrosActivos.precio_max = max !== '' ? parseInt(max) : null;
            document.getElementById('label-price').textContent = this.dataset.label;
            document.getElementById('drop-price').classList.add('hidden');
            aplicarFiltros();
        };
    });

    // 7. INSIDER
    const btnInsider = document.getElementById('btn-insider');
    if (btnInsider) {
        btnInsider.onclick = function () {
            filtrosActivos.insider = !filtrosActivos.insider;
            toggleBtnFiltro(this, filtrosActivos.insider);
            aplicarFiltros();
        };
    }
});