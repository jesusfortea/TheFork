const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const BASE = document.querySelector('meta[name="base-roles-url"]').getAttribute('content');

// ── Helpers ────────────────────────────────────────────────────────────────

function headers() {
    return {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
    };
}

function construirFila(rol) {
    const fecha = new Date(rol.created_at).toLocaleDateString('es-ES');
    return `
        <tr id="fila-${rol.id}" class="hover:bg-teal-50 transition">
            <td class="px-6 py-4 text-gray-400 font-mono">${rol.id}</td>
            <td class="px-6 py-4 font-semibold text-gray-800" id="nombre-${rol.id}">${rol.nombre}</td>
            <td class="px-6 py-4 text-gray-500">${fecha}</td>
            <td class="px-6 py-4 text-center space-x-2">
                <button onclick="abrirModalEditar(${rol.id}, '${rol.nombre.replace(/'/g, "\\'")}')"
                    class="inline-flex items-center bg-teal-100 hover:bg-teal-200 text-teal-900 font-semibold py-1.5 px-3 rounded-lg transition text-xs">
                    ✏️ Editar
                </button>
                <button onclick="confirmarEliminar(${rol.id}, '${rol.nombre.replace(/'/g, "\\'")}')"
                    class="inline-flex items-center bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-1.5 px-3 rounded-lg transition text-xs">
                    🗑️ Eliminar
                </button>
            </td>
        </tr>`;
}

// ── Modales ────────────────────────────────────────────────────────────────

document.getElementById('btn-abrir-crear').onclick = function() {
    document.getElementById('modal-crear').classList.remove('hidden');
};

document.getElementById('btn-cancelar-crear').onclick = function() {
    document.getElementById('modal-crear').classList.add('hidden');
    document.getElementById('nombre_crear').value = '';
};

document.getElementById('btn-cancelar-editar').onclick = function() {
    document.getElementById('modal-editar').classList.add('hidden');
};

// ── CRUD ───────────────────────────────────────────────────────────────────

document.getElementById('btn-guardar-crear').onclick = async function() {
    const nombre = document.getElementById('nombre_crear').value.trim();
    if (!nombre) return;

    try {
        const res  = await fetch(BASE, {
            method: 'POST',
            headers: headers(),
            body: JSON.stringify({ nombre }),
        });
        const data = await res.json();

        if (!res.ok) {
            Swal.fire({ icon: 'warning', title: 'Atención', text: data.message ?? Object.values(data.errors)[0][0], confirmButtonColor: '#134e4a' });
            return;
        }

        document.getElementById('fila-vacia')?.remove();
        document.getElementById('tabla-roles').insertAdjacentHTML('beforeend', construirFila(data.rol));
        document.getElementById('modal-crear').classList.add('hidden');
        document.getElementById('nombre_crear').value = '';

        Swal.fire({ icon: 'success', title: '¡Hecho!', text: data.message, confirmButtonColor: '#134e4a', timer: 2500, timerProgressBar: true });

    } catch {
        Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo conectar con el servidor.', confirmButtonColor: '#134e4a' });
    }
};

function abrirModalEditar(id, nombre) {
    document.getElementById('editar_id').value     = id;
    document.getElementById('nombre_editar').value = nombre;
    document.getElementById('modal-editar').classList.remove('hidden');
}

document.getElementById('btn-guardar-editar').onclick = async function() {
    const id     = document.getElementById('editar_id').value;
    const nombre = document.getElementById('nombre_editar').value.trim();
    if (!nombre) return;

    try {
        const res  = await fetch(`${BASE}/${id}`, {
            method: 'PUT',
            headers: headers(),
            body: JSON.stringify({ nombre }),
        });
        const data = await res.json();

        if (!res.ok) {
            Swal.fire({ icon: 'warning', title: 'Atención', text: data.message ?? Object.values(data.errors)[0][0], confirmButtonColor: '#134e4a' });
            return;
        }

        document.getElementById(`nombre-${id}`).textContent = nombre;

        const btnEditar = document.querySelector(`#fila-${id} button:first-child`);
        if (btnEditar) btnEditar.setAttribute('onclick', `abrirModalEditar(${id}, '${nombre.replace(/'/g, "\\'")}')`);

        document.getElementById('modal-editar').classList.add('hidden');

        Swal.fire({ icon: 'success', title: '¡Hecho!', text: data.message, confirmButtonColor: '#134e4a', timer: 2500, timerProgressBar: true });

    } catch {
        Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo conectar con el servidor.', confirmButtonColor: '#134e4a' });
    }
};

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
    }).then(async (result) => {
        if (!result.isConfirmed) return;

        try {
            const res  = await fetch(`${BASE}/${id}`, {
                method: 'DELETE',
                headers: headers(),
            });
            const data = await res.json();

            if (!res.ok) {
                Swal.fire({ icon: 'error', title: 'No se puede eliminar', text: data.message, confirmButtonColor: '#134e4a' });
                return;
            }

            document.getElementById(`fila-${id}`)?.remove();

            if (!document.querySelector('#tabla-roles tr')) {
                document.getElementById('tabla-roles').innerHTML = `
                    <tr id="fila-vacia">
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                            No hay roles registrados todavía.
                        </td>
                    </tr>`;
            }

            Swal.fire({ icon: 'success', title: '¡Eliminado!', text: data.message, confirmButtonColor: '#134e4a', timer: 2500, timerProgressBar: true });

        } catch {
            Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo conectar con el servidor.', confirmButtonColor: '#134e4a' });
        }
    });
}