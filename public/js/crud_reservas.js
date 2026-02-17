// =============================================
//  CRUD RESERVAS — AJAX
// =============================================

const CSRF         = document.querySelector('meta[name="csrf-token"]')?.content;
const modalReserva = document.getElementById('modal-reserva');

// ── Cerrar modal ────────────────────────────
function cerrarModalReserva() {
    modalReserva.classList.add('hidden');
    document.body.style.overflow = '';
}

document.getElementById('btn-cerrar-modal-reserva').onclick  = cerrarModalReserva;
document.getElementById('btn-cancelar-modal-reserva').onclick = cerrarModalReserva;

modalReserva.onclick = function (e) {
    if (e.target === modalReserva) cerrarModalReserva();
};

// ── Abrir modal de edición ──────────────────
function abrirModalReserva(id) {
    const fila = document.getElementById(`fila-reserva-${id}`);

    document.getElementById('modal-reserva-id').value          = id;
    document.getElementById('modal-id-user').value             = fila.querySelector('[data-id-user]').value;
    document.getElementById('modal-id-restaurante').value      = fila.querySelector('[data-id-restaurante]').value;
    document.getElementById('modal-fecha-hora').value          = fila.querySelector('[data-fecha-hora]').value;
    document.getElementById('modal-reserva-error').classList.add('hidden');

    modalReserva.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// ── Asignar onclick a botones de Editar ──────
document.querySelectorAll('[data-btn-editar-reserva]').forEach(btn => {
    btn.onclick = function () {
        abrirModalReserva(this.dataset.id);
    };
});

// ── Asignar onclick a botones de Eliminar ────
document.querySelectorAll('[data-btn-eliminar-reserva]').forEach(btn => {
    btn.onclick = function () {
        eliminarReservaAjax(this.dataset.id);
    };
});

// ── Guardar cambios (PUT) ───────────────────
document.getElementById('form-editar-reserva').onsubmit = async function (e) {
    e.preventDefault();

    const id            = document.getElementById('modal-reserva-id').value;
    const idUser        = document.getElementById('modal-id-user').value;
    const idRestaurante = document.getElementById('modal-id-restaurante').value;
    const fechaHora     = document.getElementById('modal-fecha-hora').value;
    const btnGuardar    = document.getElementById('btn-guardar-reserva');

    btnGuardar.disabled    = true;
    btnGuardar.textContent = 'Guardando...';

    try {
        const res = await fetch(`/admin/reservas/${id}`, {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify({
                _method:        'PUT',
                id_user:        idUser,
                id_restaurante: idRestaurante,
                fecha_hora:     fechaHora,
            }),
        });

        const data = await res.json();

        if (res.ok) {
            const fila = document.getElementById(`fila-reserva-${id}`);
            if (fila) {
                const usuarioNombre     = document.getElementById('modal-id-user').selectedOptions[0].text;
                const restauranteNombre = document.getElementById('modal-id-restaurante').selectedOptions[0].text;
                const fechaFormateada   = new Date(fechaHora).toLocaleString('es-ES', {
                    day: '2-digit', month: '2-digit', year: 'numeric',
                    hour: '2-digit', minute: '2-digit'
                });

                fila.querySelector('[data-usuario-nombre]').textContent     = usuarioNombre;
                fila.querySelector('[data-restaurante-nombre]').textContent = restauranteNombre;
                fila.querySelector('[data-fecha-display]').textContent      = fechaFormateada;

                // Actualizar los hidden inputs con los nuevos valores
                fila.querySelector('[data-id-user]').value        = idUser;
                fila.querySelector('[data-id-restaurante]').value = idRestaurante;
                fila.querySelector('[data-fecha-hora]').value     = fechaHora;
            }

            cerrarModalReserva();
            mostrarToast('Reserva actualizada correctamente', 'success');
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

// ── Eliminar reserva (DELETE) ───────────────
async function eliminarReservaAjax(id) {
    const result = await Swal.fire({
        title:              '¿Eliminar esta reserva?',
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
        const res  = await fetch(`/admin/reservas/${id}`, {
            method:  'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            document.getElementById(`fila-reserva-${id}`)?.remove();
            actualizarContador(-1);
            mostrarToast('Reserva eliminada correctamente', 'success');
        } else {
            mostrarToast(data.message || 'No se pudo eliminar.', 'error');
        }
    } catch {
        mostrarToast('Error de conexión.', 'error');
    }
}

// ── Helpers ─────────────────────────────────
function mostrarErrorModal(msg) {
    const el = document.getElementById('modal-reserva-error');
    el.textContent = msg;
    el.classList.remove('hidden');
}

function actualizarContador(delta) {
    const el = document.getElementById('contador-reservas');
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