// =============================================
//  CRUD RESTAURANTES — AJAX
// =============================================

const CSRF             = document.querySelector('meta[name="csrf-token"]')?.content;
const modalRestaurante = document.getElementById('modal-restaurante');

// ── Cerrar modal ────────────────────────────
function cerrarModalRestaurante() {
    modalRestaurante.classList.add('hidden');
    document.body.style.overflow = '';
}

document.getElementById('btn-cerrar-modal-restaurante').onclick  = cerrarModalRestaurante;
document.getElementById('btn-cancelar-modal-restaurante').onclick = cerrarModalRestaurante;

modalRestaurante.onclick = function (e) {
    if (e.target === modalRestaurante) cerrarModalRestaurante();
};

// ── Abrir modal de edición ──────────────────
function abrirModalRestaurante(id) {
    const fila = document.getElementById(`fila-restaurante-${id}`);

    document.getElementById('modal-restaurante-id').value    = id;
    document.getElementById('modal-titulo').value            = fila.querySelector('[data-titulo]').textContent.trim();
    document.getElementById('modal-ubicacion').value         = fila.querySelector('[data-ubicacion]').value;
    document.getElementById('modal-precio').value            = fila.querySelector('[data-precio]').value;
    document.getElementById('modal-cheff').value             = fila.querySelector('[data-cheff]').value;
    document.getElementById('modal-descripcion').value       = fila.querySelector('[data-descripcion]').value;
    document.getElementById('modal-menu').value              = fila.querySelector('[data-menu]').value;
    document.getElementById('modal-id-tipo').value           = fila.querySelector('[data-id-tipo]').value;
    document.getElementById('modal-estado').checked          = fila.querySelector('[data-estado]').value === '1';
    document.getElementById('modal-restaurante-error').classList.add('hidden');

    modalRestaurante.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// ── Asignar onclick a botones de Editar ──────
document.querySelectorAll('[data-btn-editar-restaurante]').forEach(btn => {
    btn.onclick = function () {
        abrirModalRestaurante(this.dataset.id);
    };
});

// ── Asignar onclick a botones de Eliminar ────
document.querySelectorAll('[data-btn-eliminar-restaurante]').forEach(btn => {
    btn.onclick = function () {
        eliminarRestauranteAjax(this.dataset.id, this.dataset.titulo);
    };
});

// ── Guardar cambios (PUT) ───────────────────
document.getElementById('form-editar-restaurante').onsubmit = async function (e) {
    e.preventDefault();

    const id          = document.getElementById('modal-restaurante-id').value;
    const titulo      = document.getElementById('modal-titulo').value.trim();
    const ubicacion   = document.getElementById('modal-ubicacion').value.trim();
    const precio      = document.getElementById('modal-precio').value;
    const cheff       = document.getElementById('modal-cheff').value.trim();
    const descripcion = document.getElementById('modal-descripcion').value.trim();
    const menu        = document.getElementById('modal-menu').value.trim();
    const idTipo      = document.getElementById('modal-id-tipo').value;
    const estado      = document.getElementById('modal-estado').checked ? 1 : 0;
    const btnGuardar  = document.getElementById('btn-guardar-restaurante');

    btnGuardar.disabled    = true;
    btnGuardar.textContent = 'Guardando...';

    try {
        const res = await fetch(`/admin/restaurantes/${id}`, {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({
                _method:     'PUT',
                titulo,
                ubicacion,
                precio,
                cheff,
                descripcion,
                menu,
                id_tipo:     idTipo,
                estado,
            }),
        });

        const data = await res.json();

        if (res.ok) {
            const fila = document.getElementById(`fila-restaurante-${id}`);
            if (fila) {
                fila.querySelector('[data-titulo]').textContent     = titulo;
                fila.querySelector('[data-tipo-nombre]').textContent = document.getElementById('modal-id-tipo').selectedOptions[0].text;
                fila.querySelector('[data-precio-display]').textContent = precio + '€';
                fila.querySelector('[data-cheff-display]').textContent  = cheff.substring(0, 20);

                // Actualizar badge de estado
                const badge = fila.querySelector('[data-estado-badge]');
                if (estado) {
                    badge.textContent  = 'Aprobado';
                    badge.className    = 'px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700';
                } else {
                    badge.textContent  = 'Pendiente';
                    badge.className    = 'px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700';
                }

                // Actualizar hidden inputs
                fila.querySelector('[data-ubicacion]').value   = ubicacion;
                fila.querySelector('[data-precio]').value      = precio;
                fila.querySelector('[data-cheff]').value       = cheff;
                fila.querySelector('[data-descripcion]').value = descripcion;
                fila.querySelector('[data-menu]').value        = menu;
                fila.querySelector('[data-id-tipo]').value     = idTipo;
                fila.querySelector('[data-estado]').value      = estado;
            }

            cerrarModalRestaurante();
            mostrarToast('Restaurante actualizado correctamente', 'success');
        } else {
            mostrarErrorModal(data.message || 'Error al actualizar.');
        }
    } catch {
        mostrarErrorModal('Error de conexión. Inténtalo de nuevo.');
    } finally {
        btnGuardar.disabled    = false;
        btnGuardar.textContent = 'Guardar cambios';
    }
};

// ── Eliminar restaurante (DELETE) ───────────
async function eliminarRestauranteAjax(id, titulo) {
    const result = await Swal.fire({
        title:              `¿Eliminar "${titulo}"?`,
        text:               'Esta acción no se puede deshacer.',
        icon:               'warning',
        showCancelButton:   true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor:  '#6b7280',
        confirmButtonText:  'Sí, eliminar',
        cancelButtonText:   'Cancelar',
    });

    if (!result.isConfirmed) return;

    try {
        const res  = await fetch(`/admin/restaurantes/${id}`, {
            method:  'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            document.getElementById(`fila-restaurante-${id}`)?.remove();
            actualizarContador(-1);
            mostrarToast('Restaurante eliminado correctamente', 'success');
        } else {
            mostrarToast(data.message || 'No se pudo eliminar.', 'error');
        }
    } catch {
        mostrarToast('Error de conexión.', 'error');
    }
}

// ── Helpers ─────────────────────────────────
function mostrarErrorModal(msg) {
    const el = document.getElementById('modal-restaurante-error');
    el.textContent = msg;
    el.classList.remove('hidden');
}

function actualizarContador(delta) {
    const el = document.getElementById('contador-restaurantes');
    if (el) el.textContent = parseInt(el.textContent) + delta;
}

function mostrarToast(mensaje, tipo) {
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