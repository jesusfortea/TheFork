// =============================================
//  FILTROS DE RESTAURANTES — AJAX (INDEPENDIENTE)
// =============================================

const CSRF_FILTROS_REST = document.querySelector('meta[name="csrf-token"]')?.content;
let timeoutFiltroRest   = null; // Para debounce en inputs de texto

// ══════════════════════════════════════════════
//  FUNCIONES AUXILIARES PROPIAS
// ══════════════════════════════════════════════

function actualizarContadorRestaurantesAbsoluto(valor) {
    const el = document.getElementById('contador-restaurantes');
    if (el) el.textContent = valor;
}

function mostrarToastFiltrosRest(mensaje, tipo) {
    Swal.fire({
        toast:             true,
        position:          'bottom-end',
        icon:              tipo,
        title:             mensaje,
        showConfirmButton: false,
        timer:             2500,
        timerProgressBar:  true,
    });
}

// Estas funciones reasignan eventos a los botones después de renderizar la tabla
function asignarEventosEditarRestaurantesFiltros() {
    document.querySelectorAll('[data-btn-editar-restaurante]').forEach(btn => {
        btn.onclick = function () {
            // Llama a la función global del crud_restaurantes.js
            abrirModalEditarRestaurante(this.dataset.id);
        };
    });
}

function asignarEventosEliminarRestaurantesFiltros() {
    document.querySelectorAll('[data-btn-eliminar-restaurante]').forEach(btn => {
        btn.onclick = function () {
            // Llama a la función global del crud_restaurantes.js
            eliminarRestauranteAjax(this.dataset.id, this.dataset.titulo);
        };
    });
}

// ══════════════════════════════════════════════
//  OBTENER VALORES DE FILTROS
// ══════════════════════════════════════════════

function obtenerFiltrosRestaurantes() {
    return {
        titulo: document.getElementById('filtro-titulo').value.trim(),
        chef:   document.getElementById('filtro-chef').value.trim(),
        tipo:   document.getElementById('filtro-tipo').value,
        estado: document.getElementById('filtro-estado').value,
        precio: document.getElementById('filtro-precio').value,
        fecha:  document.getElementById('filtro-fecha-restaurante').value,
    };
}

// ══════════════════════════════════════════════
//  APLICAR FILTROS CON AJAX
// ══════════════════════════════════════════════

async function aplicarFiltrosRestaurantes() {
    const filtros   = obtenerFiltrosRestaurantes();
    const indicador = document.getElementById('indicador-carga-restaurantes');
    const tbody     = document.getElementById('tabla-restaurantes-body');

    // Mostrar indicador de carga
    indicador.classList.remove('hidden');

    try {
        const params = new URLSearchParams(filtros);
        const res    = await fetch(`/admin/restaurantes/filtrar?${params}`, {
            headers: {
                'X-CSRF-TOKEN': CSRF_FILTROS_REST,
                'Accept':       'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            renderizarTablaRestaurantes(data.restaurantes);
            actualizarContadorRestaurantesAbsoluto(data.restaurantes.length);
        } else {
            mostrarToastFiltrosRest('Error al filtrar restaurantes', 'error');
        }
    } catch (error) {
        console.error('Error al filtrar:', error);
        mostrarToastFiltrosRest('Error de conexión al filtrar', 'error');
    } finally {
        indicador.classList.add('hidden');
    }
}

// ══════════════════════════════════════════════
//  RENDERIZAR TABLA CON RESULTADOS
// ══════════════════════════════════════════════

function renderizarTablaRestaurantes(restaurantes) {
    const tbody = document.getElementById('tabla-restaurantes-body');
    
    if (restaurantes.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" class="px-6 py-10 text-center text-gray-400">
                    😔 No se encontraron restaurantes con los filtros aplicados
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    
    restaurantes.forEach(restaurante => {
        const estadoBadge = obtenerBadgeEstado(restaurante.estado);
        const imagenHtml  = obtenerImagenHtml(restaurante.imagen, restaurante.titulo);
        
        html += `
            <tr id="fila-restaurante-${restaurante.id}" class="hover:bg-gray-50 transition">
                
                <input type="hidden" data-ubicacion value="${restaurante.ubicacion || ''}">
                <input type="hidden" data-precio value="${restaurante.precio || 0}">
                <input type="hidden" data-cheff value="${restaurante.cheff || ''}">
                <input type="hidden" data-descripcion value="${escaparHtml(restaurante.descripcion || '')}">
                <input type="hidden" data-menu value="${escaparHtml(restaurante.menu || '')}">
                <input type="hidden" data-id-tipo value="${restaurante.id_tipo || ''}">
                <input type="hidden" data-estado value="${restaurante.estado ? '1' : '0'}">

                <td class="px-6 py-4 text-gray-400 font-mono">#${restaurante.id}</td>
                <td class="px-6 py-4">${imagenHtml}</td>
                <td class="px-6 py-4 font-semibold text-gray-900" data-titulo>${restaurante.titulo}</td>
                <td class="px-6 py-4 text-gray-500" data-tipo-nombre>${restaurante.tipo?.nombre || 'N/A'}</td>
                <td class="px-6 py-4 text-gray-700 font-medium" data-precio-display>${restaurante.precio}€</td>
                <td class="px-6 py-4">
                    <span data-estado-badge class="px-2.5 py-1 rounded-full text-xs font-semibold ${estadoBadge.clase}">
                        ${estadoBadge.texto}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-500" data-cheff-display>${limitarTexto(restaurante.cheff, 20)}</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <button
                            data-btn-editar-restaurante
                            data-id="${restaurante.id}"
                            class="bg-teal-700 hover:bg-teal-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                            ✏️ Editar
                        </button>
                        <button
                            data-btn-eliminar-restaurante
                            data-id="${restaurante.id}"
                            data-titulo="${restaurante.titulo}"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                            🗑️ Eliminar
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
    
    // Reasignar eventos a los nuevos botones
    asignarEventosEditarRestaurantesFiltros();
    asignarEventosEliminarRestaurantesFiltros();
}

// ══════════════════════════════════════════════
//  HELPERS
// ══════════════════════════════════════════════

function obtenerBadgeEstado(estado) {
    if (estado) {
        return {
            clase: 'bg-emerald-100 text-emerald-700',
            texto: 'Aprobado'
        };
    }
    return {
        clase: 'bg-yellow-100 text-yellow-700',
        texto: 'Pendiente'
    };
}

function obtenerImagenHtml(imagen, titulo) {
    if (imagen) {
        const src = imagen.startsWith('http') ? imagen : '/' + imagen;
        return `<img src="${src}" alt="${titulo}" class="h-12 w-12 rounded-lg object-cover">`;
    }
    return `<div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">Sin img</div>`;
}

function limitarTexto(texto, limite) {
    if (!texto) return '';
    if (texto.length <= limite) return texto;
    return texto.substring(0, limite) + '...';
}

function escaparHtml(texto) {
    if (!texto) return '';
    return texto
        .replace(/\\/g, '\\\\')
        .replace(/"/g, '\\"')
        .replace(/'/g, "\\'");
}

// ══════════════════════════════════════════════
//  LIMPIAR FILTROS
// ══════════════════════════════════════════════

document.getElementById('btn-limpiar-filtros-restaurantes').onclick = function() {
    document.getElementById('filtro-titulo').value              = '';
    document.getElementById('filtro-chef').value                = '';
    document.getElementById('filtro-tipo').value                = '';
    document.getElementById('filtro-estado').value              = '';
    document.getElementById('filtro-precio').value              = '';
    document.getElementById('filtro-fecha-restaurante').value   = '';
    
    aplicarFiltrosRestaurantes();
    mostrarToastFiltrosRest('Filtros limpiados', 'info');
};

// ══════════════════════════════════════════════
//  EVENT LISTENERS PARA FILTROS
// ══════════════════════════════════════════════

// Inputs de texto con debounce (espera 500ms después de que el usuario deje de escribir)
document.getElementById('filtro-titulo').addEventListener('input', function() {
    clearTimeout(timeoutFiltroRest);
    timeoutFiltroRest = setTimeout(() => aplicarFiltrosRestaurantes(), 500);
});

document.getElementById('filtro-chef').addEventListener('input', function() {
    clearTimeout(timeoutFiltroRest);
    timeoutFiltroRest = setTimeout(() => aplicarFiltrosRestaurantes(), 500);
});

// Selects con aplicación inmediata
document.getElementById('filtro-tipo').addEventListener('change', aplicarFiltrosRestaurantes);
document.getElementById('filtro-estado').addEventListener('change', aplicarFiltrosRestaurantes);
document.getElementById('filtro-precio').addEventListener('change', aplicarFiltrosRestaurantes);
document.getElementById('filtro-fecha-restaurante').addEventListener('change', aplicarFiltrosRestaurantes);