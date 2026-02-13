/**
 * ========================================
 * CRUD CON AJAX - VERSIÓN CON SWEETALERT2
 * ========================================
 * Este archivo contiene funciones simples para hacer
 * operaciones CRUD con AJAX usando fetch() y SweetAlert2
 */

/**
 * Función para eliminar un USUARIO con AJAX y SweetAlert2
 * 
 * @param {number} id - ID del usuario a eliminar
 * @param {string} nombre - Nombre del usuario (para el mensaje)
 */
function eliminarUsuarioAjax(id, nombre) {
    // 1. Mostrar SweetAlert bonito para confirmar
    Swal.fire({
        title: '¿Estás seguro?',
        html: `Vas a eliminar al usuario <strong>${nombre}</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#134e4a', // Teal-900
        cancelButtonColor: '#6b7280', // Gray-500
        confirmButtonText: '✓ Sí, eliminar',
        cancelButtonText: '✗ Cancelar',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        // Si confirma la eliminación
        if (result.isConfirmed) {
            // 2. Obtener el token CSRF (Laravel lo requiere)
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // 3. Hacer la petición AJAX con fetch
            fetch(`/admin/usuarios/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    // 4. Si todo salió bien
                    if (data.success) {
                        // Eliminar la fila de la tabla SIN recargar la página
                        document.getElementById(`fila-usuario-${id}`).remove();

                        // Mostrar mensaje de éxito con SweetAlert
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#134e4a',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    } else {
                        // Si hubo error
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonColor: '#134e4a'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al eliminar el usuario',
                        icon: 'error',
                        confirmButtonColor: '#134e4a'
                    });
                });
        }
    });
}

/**
 * Función para eliminar una RESERVA con AJAX y SweetAlert2
 * 
 * @param {number} id - ID de la reserva a eliminar
 */
function eliminarReservaAjax(id) {
    // 1. Mostrar SweetAlert bonito para confirmar
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
    }).then((result) => {
        if (result.isConfirmed) {
            // 2. Token CSRF
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // 3. Petición AJAX
            fetch(`/admin/reservas/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    // 4. Procesar respuesta
                    if (data.success) {
                        // Eliminar fila de la tabla
                        document.getElementById(`fila-reserva-${id}`).remove();

                        // Mensaje de éxito
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
                .catch(error => {
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

/**
 * Función helper para mostrar mensajes (LEGACY - Ya no se usa con SweetAlert)
 * Se mantiene por compatibilidad si alguien la llama
 * 
 * @param {string} tipo - 'success' o 'error'
 * @param {string} texto - El mensaje a mostrar
 */
function mostrarMensaje(tipo, texto) {
    // Ahora usamos SweetAlert en lugar de mensajes tradicionales
    Swal.fire({
        title: tipo === 'success' ? '¡Éxito!' : 'Error',
        text: texto,
        icon: tipo === 'success' ? 'success' : 'error',
        confirmButtonColor: '#134e4a',
        timer: tipo === 'success' ? 2000 : undefined,
        timerProgressBar: tipo === 'success'
    });
}
