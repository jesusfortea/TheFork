// ========================================
// CRUD RESERVAS - AJAX CON SWEETALERT2
// ========================================

// Token CSRF necesario para las peticiones
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ── Cerrar modal ─────────────────────────
document.getElementById('btn-cerrar-modal-reserva').onclick = function() {
    document.getElementById('modal-reserva').classList.add('hidden');
}

document.getElementById('btn-cancelar-modal-reserva').onclick = function() {
    document.getElementById('modal-reserva').classList.add('hidden');
}

// ── Abrir modal de edición ───────────────
function abrirModalReserva(id) {
    var fila = document.getElementById('fila-reserva-' + id);

    document.getElementById('modal-reserva-id').value     = id;
    document.getElementById('modal-id-user').value        = fila.querySelector('[data-id-user]').value;
    document.getElementById('modal-id-restaurante').value = fila.querySelector('[data-id-restaurante]').value;
    document.getElementById('modal-fecha-hora').value     = fila.querySelector('[data-fecha-hora]').value;

    document.getElementById('modal-reserva').classList.remove('hidden');
}

// ── Botones de editar ────────────────────
document.querySelectorAll('[data-btn-editar-reserva]').forEach(function(btn) {
    btn.onclick = function() {
        abrirModalReserva(this.dataset.id);
    }
});

// ── Botones de eliminar ──────────────────
document.querySelectorAll('[data-btn-eliminar-reserva]').forEach(function(btn) {
    btn.onclick = function() {
        eliminarReservaAjax(this.dataset.id);
    }
});

// ── Guardar cambios ──────────────────────
document.getElementById('form-editar-reserva').onsubmit = function(e) {
    e.preventDefault();

    var id            = document.getElementById('modal-reserva-id').value;
    var idUser        = document.getElementById('modal-id-user').value;
    var idRestaurante = document.getElementById('modal-id-restaurante').value;
    var fechaHora     = document.getElementById('modal-fecha-hora').value;

    fetch('/admin/reservas/' + id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            _method: 'PUT',
            id_user: idUser,
            id_restaurante: idRestaurante,
            fecha_hora: fechaHora,
        }),
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            // Actualizar la fila de la tabla sin recargar
            var fila = document.getElementById('fila-reserva-' + id);
            fila.querySelector('[data-usuario-nombre]').textContent     = document.getElementById('modal-id-user').selectedOptions[0].text;
            fila.querySelector('[data-restaurante-nombre]').textContent = document.getElementById('modal-id-restaurante').selectedOptions[0].text;
            fila.querySelector('[data-fecha-display]').textContent      = new Date(fechaHora).toLocaleString('es-ES');
            fila.querySelector('[data-id-user]').value                  = idUser;
            fila.querySelector('[data-id-restaurante]').value           = idRestaurante;
            fila.querySelector('[data-fecha-hora]').value               = fechaHora;

            document.getElementById('modal-reserva').classList.add('hidden');

            Swal.fire({
                title: '¡Actualizada!',
                text: 'La reserva se ha actualizado correctamente',
                icon: 'success',
                confirmButtonColor: '#134e4a',
                timer: 2000,
                timerProgressBar: true
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: data.message,
                icon: 'error',
                confirmButtonColor: '#134e4a'
            });
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error',
            text: 'Error al actualizar la reserva',
            icon: 'error',
            confirmButtonColor: '#134e4a'
        });
    });
}

// ── Eliminar reserva ─────────────────────
function eliminarReservaAjax(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        html: 'Vas a eliminar esta <strong>reserva</strong>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#134e4a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '✓ Sí, eliminar',
        cancelButtonText: '✗ Cancelar',
        reverseButtons: true,
        focusCancel: true
    }).then(function(result) {
        if (result.isConfirmed) {
            fetch('/admin/reservas/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success) {
                    // Eliminar la fila sin recargar la página
                    document.getElementById('fila-reserva-' + id).remove();

                    Swal.fire({
                        title: '¡Eliminada!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#134e4a',
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#134e4a'
                    });
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al eliminar la reserva',
                    icon: 'error',
                    confirmButtonColor: '#134e4a'
                });
            });
        }
    });
}