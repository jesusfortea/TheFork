// =============================================
//  CRUD USUARIOS — AJAX
// =============================================

const CSRF       = document.querySelector('meta[name="csrf-token"]')?.content;
const modalEditar = document.getElementById('modal-editar');

// ── Cerrar modal ────────────────────────────
function cerrarModalEditar() {
    modalEditar.classList.add('hidden');
    document.body.style.overflow = '';
}

document.getElementById('btn-cerrar-modal').onclick  = cerrarModalEditar;
document.getElementById('btn-cancelar-modal').onclick = cerrarModalEditar;

modalEditar.onclick = function (e) {
    if (e.target === modalEditar) cerrarModalEditar();
};

// ── Abrir modal de edición ──────────────────
function abrirModalEditar(id) {
    const fila = document.getElementById(`fila-usuario-${id}`);

    document.getElementById('modal-usuario-id').value = id;
    document.getElementById('modal-nombre').value     = fila.querySelector('[data-nombre]').textContent.trim();
    document.getElementById('modal-email').value      = fila.querySelector('[data-email]').textContent.trim();
    document.getElementById('modal-rol').value        = fila.querySelector('[data-rol-id]').value;
    document.getElementById('modal-password').value   = '';
    document.getElementById('modal-error').classList.add('hidden');

    modalEditar.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// ── Asignar onclick a cada botón de Editar ──
document.querySelectorAll('[data-btn-editar]').forEach(btn => {
    btn.onclick = function () {
        abrirModalEditar(this.dataset.id);
    };
});

// ── Asignar onclick a cada botón de Eliminar ─
document.querySelectorAll('[data-btn-eliminar]').forEach(btn => {
    btn.onclick = function () {
        eliminarUsuarioAjax(this.dataset.id, this.dataset.nombre);
    };
});

// ── Guardar cambios (PUT) ───────────────────
document.getElementById('form-editar-usuario').onsubmit = async function (e) {
    e.preventDefault();

    const id         = document.getElementById('modal-usuario-id').value;
    const nombre     = document.getElementById('modal-nombre').value.trim();
    const email      = document.getElementById('modal-email').value.trim();
    const rolId      = document.getElementById('modal-rol').value;
    const password   = document.getElementById('modal-password').value;
    const btnGuardar = document.getElementById('btn-guardar');

    btnGuardar.disabled    = true;
    btnGuardar.textContent = 'Guardando...';

    const body = { _method: 'PUT', name: nombre, email, rol_id: rolId };
    if (password) body.password = password;

    try {
        const res  = await fetch(`/admin/usuarios/${id}`, {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
            body: JSON.stringify(body),
        });

        const data = await res.json();

        if (res.ok) {
            const fila = document.getElementById(`fila-usuario-${id}`);
            if (fila) {
                fila.querySelector('[data-nombre]').textContent = nombre;
                fila.querySelector('[data-email]').textContent  = email;
                fila.querySelector('[data-rol]').textContent    = document.getElementById('modal-rol').selectedOptions[0].text;
                fila.querySelector('[data-rol-id]').value       = rolId;
            }

            cerrarModalEditar();
            mostrarToast('Usuario actualizado correctamente', 'success');
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

// ── Eliminar usuario (DELETE) ───────────────
async function eliminarUsuarioAjax(id, nombre) {
    const result = await Swal.fire({
        title:              `¿Eliminar a ${nombre}?`,
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
        const res  = await fetch(`/admin/usuarios/${id}`, {
            method:  'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF,
                'Accept':       'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            document.getElementById(`fila-usuario-${id}`)?.remove();
            actualizarContador(-1);
            mostrarToast('Usuario eliminado correctamente', 'success');
        } else {
            mostrarToast(data.message || 'No se pudo eliminar.', 'error');
        }
    } catch {
        mostrarToast('Error de conexión.', 'error');
    }
}

// ── Helpers ─────────────────────────────────
function mostrarErrorModal(msg) {
    const el = document.getElementById('modal-error');
    el.textContent = msg;
    el.classList.remove('hidden');
}

function actualizarContador(delta) {
    const el = document.getElementById('contador-usuarios');
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