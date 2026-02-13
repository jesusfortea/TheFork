// --- Modal editar ---
function abrirModalEditar(id, nombre) {
    const baseUrl = "{{ url('admin/roles') }}";
    document.getElementById('form-editar').action = baseUrl + '/' + id;
    document.getElementById('nombre_editar').value = nombre;
    document.getElementById('modal-editar').classList.remove('hidden');
}

// --- Confirmación eliminar con SweetAlert ---
function confirmarEliminar(id, nombre) {
    Swal.fire({
        title: '¿Eliminar rol?',
        text: `Vas a eliminar el rol "${nombre}". Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#134e4a',
        cancelButtonColor: '#d1d5db',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-destroy-' + id).submit();
        }
    });
}

// --- Alertas de sesión al cargar la página ---
document.addEventListener('DOMContentLoaded', () => {
    const success    = document.getElementById('swal-success');
    const error      = document.getElementById('swal-error');
    const validation = document.getElementById('swal-validation');

    if (success) {
        Swal.fire({
            icon: 'success',
            title: '¡Hecho!',
            text: success.dataset.msg,
            confirmButtonColor: '#134e4a',
            timer: 3000,
            timerProgressBar: true,
        });
    }

    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'No se puede eliminar',
            text: error.dataset.msg,
            confirmButtonColor: '#134e4a',
        });
    }

    if (validation) {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: validation.dataset.msg,
            confirmButtonColor: '#134e4a',
        });
    }
});