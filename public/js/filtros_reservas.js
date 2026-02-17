// =============================================
//  FILTROS DE RESERVAS — AJAX (INDEPENDIENTE)
// =============================================

const CSRF_FILTROS_RESERVAS = document.querySelector('meta[name="csrf-token"]')?.content;
let timeoutFiltroReservas   = null; // Para debounce en inputs de texto

// ══════════════════════════════════════════════
//  FUNCIONES AUXILIARES PROPIAS
// ══════════════════════════════════════════════

function actualizarContadorReservasAbsoluto(valor) {
    const el = document.getElementById('contador-reservas');
    if (el) el.textContent = valor;
}

function mostrarToastFiltrosReservas(mensaje, tipo) {
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
function asignarEventosEditarReservasFiltros() {
    document.querySelectorAll('[data-btn-editar-reserva]').forEach(btn => {
        btn.onclick = function () {
            // Llama a la función global del crud_reservas.js
            abrirModalEditarReserva(this.dataset.id);
        };
    });
}

function asignarEventosEliminarReservasFiltros() {
    document.querySelectorAll('[data-btn-eliminar-reserva]').forEach(btn => {
        btn.onclick = function () {
            // Llama a la función global del crud_reservas.js
            eliminarReservaAjax(this.dataset.id);
        };
    });
}

// ══════════════════════════════════════════════
//  OBTENER VALORES DE FILTROS
// ══════════════════════════════════════════════

function obtenerFiltrosReservas() {
    return {
        usuario:         document.getElementById('filtro-usuario').value.trim(),
        email:           document.getElementById('filtro-email-reserva').value.trim(),
        restaurante:     document.getElementById('filtro-restaurante').value,
        fecha_reserva:   document.getElementById('filtro-fecha-reserva').value,
    };
}

// ══════════════════════════════════════════════
//  APLICAR FILTROS CON AJAX
// ══════════════════════════════════════════════

async function aplicarFiltrosReservas() {
    const filtros   = obtenerFiltrosReservas();
    const indicador = document.getElementById('indicador-carga-reservas');
    const tbody     = document.getElementById('tabla-reservas-body');

    // Mostrar indicador de carga
    indicador.classList.remove('hidden');

    try {
        const params = new URLSearchParams(filtros);
        const res    = await fetch(`/admin/reservas/filtrar?${params}`, {
            headers: {
                'X-CSRF-TOKEN': CSRF_FILTROS_RESERVAS,
                'Accept':       'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            renderizarTablaReservas(data.reservas);
            actualizarContadorReservasAbsoluto(data.reservas.length);
        } else {
            mostrarToastFiltrosReservas('Error al filtrar reservas', 'error');
        }
    } catch (error) {
        console.error('Error al filtrar:', error);
        mostrarToastFiltrosReservas('Error de conexión al filtrar', 'error');
    } finally {
        indicador.classList.add('hidden');
    }
}

// ══════════════════════════════════════════════
//  RENDERIZAR TABLA CON RESULTADOS
// ══════════════════════════════════════════════

function renderizarTablaReservas(reservas) {
    const tbody = document.getElementById('tabla-reservas-body');
    
    if (reservas.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                    😔 No se encontraron reservas con los filtros aplicados
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    
    reservas.forEach(reserva => {
        const fechaHoraFormatted = formatearFechaHora(reserva.fecha_hora, reserva.created_at);
        const fechaHoraInput     = formatearFechaHoraInput(reserva.fecha_hora);
        
        html += `
            <tr id="fila-reserva-${reserva.id}" class="hover:bg-gray-50 transition">
                
                <input type="hidden" data-id-user value="${reserva.id_user || ''}">
                <input type="hidden" data-id-restaurante value="${reserva.id_restaurante || ''}">
                <input type="hidden" data-fecha-hora value="${fechaHoraInput}">

                <td class="px-6 py-4 text-gray-400 font-mono">#${reserva.id}</td>
                <td class="px-6 py-4 font-semibold text-gray-900" data-usuario-nombre>
                    ${reserva.usuario?.name || 'Usuario eliminado'}
                </td>
                <td class="px-6 py-4 text-gray-500">
                    ${reserva.usuario?.email || 'N/A'}
                </td>
                <td class="px-6 py-4 font-semibold text-teal-900" data-restaurante-nombre>
                    ${reserva.restaurante?.titulo || 'Restaurante eliminado'}
                </td>
                <td class="px-6 py-4 text-gray-600" data-fecha-display>
                    ${fechaHoraFormatted}
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <button
                            data-btn-editar-reserva
                            data-id="${reserva.id}"
                            class="bg-teal-700 hover:bg-teal-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                            ✏️ Editar
                        </button>
                        <button
                            data-btn-eliminar-reserva
                            data-id="${reserva.id}"
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
    asignarEventosEditarReservasFiltros();
    asignarEventosEliminarReservasFiltros();
}

// ══════════════════════════════════════════════
//  HELPERS
// ══════════════════════════════════════════════

function formatearFechaHora(fechaHora, createdAt) {
    const fecha = fechaHora || createdAt;
    if (!fecha) return 'N/A';
    
    const date = new Date(fecha);
    const dia  = String(date.getDate()).padStart(2, '0');
    const mes  = String(date.getMonth() + 1).padStart(2, '0');
    const año  = date.getFullYear();
    const hora = String(date.getHours()).padStart(2, '0');
    const min  = String(date.getMinutes()).padStart(2, '0');
    
    return `${dia}/${mes}/${año} ${hora}:${min}`;
}

function formatearFechaHoraInput(fechaHora) {
    if (!fechaHora) return '';
    
    const date = new Date(fechaHora);
    const año  = date.getFullYear();
    const mes  = String(date.getMonth() + 1).padStart(2, '0');
    const dia  = String(date.getDate()).padStart(2, '0');
    const hora = String(date.getHours()).padStart(2, '0');
    const min  = String(date.getMinutes()).padStart(2, '0');
    
    return `${año}-${mes}-${dia}T${hora}:${min}`;
}

// ══════════════════════════════════════════════
//  LIMPIAR FILTROS
// ══════════════════════════════════════════════

document.getElementById('btn-limpiar-filtros-reservas').onclick = function() {
    document.getElementById('filtro-usuario').value         = '';
    document.getElementById('filtro-email-reserva').value   = '';
    document.getElementById('filtro-restaurante').value     = '';
    document.getElementById('filtro-fecha-reserva').value   = '';    
    aplicarFiltrosReservas();
    mostrarToastFiltrosReservas('Filtros limpiados', 'info');
};

// ══════════════════════════════════════════════
//  EVENTOS PARA FILTROS
// ══════════════════════════════════════════════

// Inputs de texto con debounce (espera 500ms después de que el usuario deje de escribir)
document.getElementById('filtro-usuario').oninput = function() {
    clearTimeout(timeoutFiltroReservas);
    timeoutFiltroReservas = setTimeout(() => aplicarFiltrosReservas(), 500);
};

document.getElementById('filtro-email-reserva').oninput = function() {
    clearTimeout(timeoutFiltroReservas);
    timeoutFiltroReservas = setTimeout(() => aplicarFiltrosReservas(), 500);
};

// Selects con aplicación inmediata
document.getElementById('filtro-restaurante').onchange      = aplicarFiltrosReservas;
document.getElementById('filtro-fecha-reserva').onchange    = aplicarFiltrosReservas;