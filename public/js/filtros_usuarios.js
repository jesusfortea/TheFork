// =============================================
//  FILTROS DE USUARIOS — AJAX (INDEPENDIENTE)
// =============================================

const CSRF_FILTROS = document.querySelector('meta[name="csrf-token"]')?.content;
let timeoutFiltro  = null; // Para debounce en inputs de texto

// ══════════════════════════════════════════════
//  FUNCIONES AUXILIARES PROPIAS
// ══════════════════════════════════════════════

function actualizarContadorAbsoluto(valor) {
    const el = document.getElementById('contador-usuarios');
    if (el) el.textContent = valor;
}

function mostrarToastFiltros(mensaje, tipo) {
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
function asignarEventosEditarFiltros() {
    document.querySelectorAll('[data-btn-editar]').forEach(btn => {
        btn.onclick = function () {
            // Llama a la función global del crud_usuarios.js
            abrirModalEditar(this.dataset.id);
        };
    });
}

function asignarEventosEliminarFiltros() {
    document.querySelectorAll('[data-btn-eliminar]').forEach(btn => {
        btn.onclick = function () {
            // Llama a la función global del crud_usuarios.js
            eliminarUsuarioAjax(this.dataset.id, this.dataset.nombre);
        };
    });
}

// ══════════════════════════════════════════════
//  OBTENER VALORES DE FILTROS
// ══════════════════════════════════════════════

function obtenerFiltros() {
    return {
        nombre: document.getElementById('filtro-nombre').value.trim(),
        email:  document.getElementById('filtro-email').value.trim(),
        rol:    document.getElementById('filtro-rol').value,
        fecha:  document.getElementById('filtro-fecha').value,
    };
}

// ══════════════════════════════════════════════
//  APLICAR FILTROS CON AJAX
// ══════════════════════════════════════════════

async function aplicarFiltros() {
    const filtros    = obtenerFiltros();
    const indicador  = document.getElementById('indicador-carga');
    const tbody      = document.getElementById('tabla-usuarios-body');

    // Mostrar indicador de carga
    indicador.classList.remove('hidden');

    try {
        const params = new URLSearchParams(filtros);
        const res    = await fetch(`/admin/usuarios/filtrar?${params}`, {
            headers: {
                'X-CSRF-TOKEN': CSRF_FILTROS,
                'Accept':       'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            renderizarTabla(data.usuarios);
            actualizarContadorAbsoluto(data.usuarios.length);
        } else {
            mostrarToastFiltros('Error al filtrar usuarios', 'error');
        }
    } catch (error) {
        console.error('Error al filtrar:', error);
        mostrarToastFiltros('Error de conexión al filtrar', 'error');
    } finally {
        indicador.classList.add('hidden');
    }
}

// ══════════════════════════════════════════════
//  RENDERIZAR TABLA CON RESULTADOS
// ══════════════════════════════════════════════

function renderizarTabla(usuarios) {
    const tbody        = document.getElementById('tabla-usuarios-body');
    // Obtener el ID del usuario actual desde la variable global definida en el Blade
    const usuarioActual = window.USUARIO_ACTUAL_ID || null;
    
    if (usuarios.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                    😔 No se encontraron usuarios con los filtros aplicados
                </td>
            </tr>
        `;
        return;
    }

    let html = '';
    
    usuarios.forEach(usuario => {
        const rolClase        = obtenerClaseRol(usuario.rol?.nombre);
        const esUsuarioActual = usuario.id === usuarioActual;
        
        html += `
            <tr id="fila-usuario-${usuario.id}" class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-gray-400 font-mono">#${usuario.id}</td>
                <td class="px-6 py-4 font-semibold text-gray-900" data-nombre>${usuario.name}</td>
                <td class="px-6 py-4 text-gray-500" data-email>${usuario.email}</td>
                <td class="px-6 py-4">
                    <input type="hidden" data-rol-id value="${usuario.rol_id || ''}">
                    <span data-rol class="px-2.5 py-1 rounded-full text-xs font-semibold ${rolClase}">
                        ${usuario.rol?.nombre || 'Sin rol'}
                    </span>
                </td>
                <td class="px-6 py-4 text-gray-400">${formatearFecha(usuario.created_at)}</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <button
                            data-btn-editar
                            data-id="${usuario.id}"
                            class="bg-teal-700 hover:bg-teal-800 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                            ✏️ Editar
                        </button>
                        ${!esUsuarioActual ? `
                            <button
                                data-btn-eliminar
                                data-id="${usuario.id}"
                                data-nombre="${usuario.name}"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                🗑️ Eliminar
                            </button>
                        ` : `
                            <span class="text-gray-400 text-xs italic px-3 py-1.5">Tú mismo</span>
                        `}
                    </div>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
    
    // Reasignar eventos a los nuevos botones
    asignarEventosEditarFiltros();
    asignarEventosEliminarFiltros();
}

// ══════════════════════════════════════════════
//  HELPERS
// ══════════════════════════════════════════════

function obtenerClaseRol(nombreRol) {
    switch (nombreRol) {
        case 'Administrador':
            return 'bg-purple-100 text-purple-700';
        case 'Restaurante':
            return 'bg-blue-100 text-blue-700';
        default:
            return 'bg-emerald-100 text-emerald-700';
    }
}

function formatearFecha(fecha) {
    const date = new Date(fecha);
    const dia  = String(date.getDate()).padStart(2, '0');
    const mes  = String(date.getMonth() + 1).padStart(2, '0');
    const año  = date.getFullYear();
    const hora = String(date.getHours()).padStart(2, '0');
    const min  = String(date.getMinutes()).padStart(2, '0');
    
    return `${dia}/${mes}/${año} ${hora}:${min}`;
}

// ══════════════════════════════════════════════
//  LIMPIAR FILTROS
// ══════════════════════════════════════════════

document.getElementById('btn-limpiar-filtros').onclick = function() {
    document.getElementById('filtro-nombre').value = '';
    document.getElementById('filtro-email').value  = '';
    document.getElementById('filtro-rol').value    = '';
    document.getElementById('filtro-fecha').value  = '';
    
    aplicarFiltros();
    mostrarToastFiltros('Filtros limpiados', 'info');
};

// ══════════════════════════════════════════════
//  EVENTOS PARA FILTROS
// ══════════════════════════════════════════════

// Inputs de texto con debounce (espera 500ms después de que el usuario deje de escribir)
document.getElementById('filtro-nombre').oninput = function() {
    clearTimeout(timeoutFiltro);
    timeoutFiltro = setTimeout(() => aplicarFiltros(), 500);
};

document.getElementById('filtro-email').oninput = function() {
    clearTimeout(timeoutFiltro);
    timeoutFiltro = setTimeout(() => aplicarFiltros(), 500);
};

// Selects con aplicación inmediata
document.getElementById('filtro-rol').onchange = aplicarFiltros;
document.getElementById('filtro-fecha').onchange = aplicarFiltros;