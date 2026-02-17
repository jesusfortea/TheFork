// =============================================
//  MODAL RESERVAS Y RESEÑAS — AJAX
// =============================================

const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;
const modalRestaurante = document.getElementById('modal-restaurante-detail');
let restauranteActualId = null;

// ── Abrir modal ─────────────────────────────
function abrirModalRestaurante(id, titulo) {
    restauranteActualId = id;
    document.getElementById('modal-rest-titulo').textContent = titulo;
    document.getElementById('modal-rest-id').value = id;
    
    // Reset forms
    document.getElementById('form-reserva').reset();
    document.getElementById('form-resena').reset();
    document.getElementById('error-reserva').classList.add('hidden');
    document.getElementById('error-resena').classList.add('hidden');
    
    // Reset borders
    const inputs = document.querySelectorAll('#modal-restaurante-detail input, #modal-restaurante-detail textarea');
    inputs.forEach(input => {
        input.classList.remove('border-red-500', 'border-yellow-500');
    });
    
    // Cargar reseñas
    cargarResenas(id);
    
    // Mostrar tab de reserva por defecto
    cambiarTab('reserva');
    
    // Inicializar validaciones en tiempo real
    inicializarValidacionesRealTime();
    
    modalRestaurante.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

// ── Cerrar modal ────────────────────────────
function cerrarModalRestaurante() {
    modalRestaurante.classList.add('hidden');
    document.body.style.overflow = '';
    restauranteActualId = null;
}

document.getElementById('btn-cerrar-modal-rest').onclick = cerrarModalRestaurante;

modalRestaurante.onclick = function (e) {
    if (e.target === modalRestaurante) cerrarModalRestaurante();
};

// ── Cambiar tabs ────────────────────────────
function cambiarTab(tab) {
    // Tabs
    const tabReserva = document.getElementById('tab-reserva');
    const tabResena  = document.getElementById('tab-resena');
    // Contenidos
    const contentReserva = document.getElementById('content-reserva');
    const contentResena  = document.getElementById('content-resena');
    
    if (tab === 'reserva') {
        tabReserva.classList.add('border-teal-700', 'text-teal-900', 'font-bold');
        tabReserva.classList.remove('border-transparent', 'text-gray-500');
        tabResena.classList.add('border-transparent', 'text-gray-500');
        tabResena.classList.remove('border-teal-700', 'text-teal-900', 'font-bold');
        
        contentReserva.classList.remove('hidden');
        contentResena.classList.add('hidden');
    } else {
        tabResena.classList.add('border-teal-700', 'text-teal-900', 'font-bold');
        tabResena.classList.remove('border-transparent', 'text-gray-500');
        tabReserva.classList.add('border-transparent', 'text-gray-500');
        tabReserva.classList.remove('border-teal-700', 'text-teal-900', 'font-bold');
        
        contentResena.classList.remove('hidden');
        contentReserva.classList.add('hidden');
    }
}

document.getElementById('tab-reserva').onclick = () => cambiarTab('reserva');
document.getElementById('tab-resena').onclick  = () => cambiarTab('resena');

// ── Crear reserva (AJAX) ────────────────────
document.getElementById('form-reserva').onsubmit = async function (e) {
    e.preventDefault();
    
    const fechaHora = document.getElementById('reserva-fecha-hora').value;
    const btnReservar = document.getElementById('btn-reservar');
    
    // Validación cliente
    if (!fechaHora || fechaHora.trim() === '') {
        mostrarError('error-reserva', 'Por favor selecciona una fecha y hora');
        return;
    }
    
    const fechaSeleccionada = new Date(fechaHora);
    const ahora = new Date();
    
    if (fechaSeleccionada <= ahora) {
        mostrarError('error-reserva', 'La fecha debe ser futura');
        return;
    }
    
    btnReservar.disabled = true;
    btnReservar.textContent = 'Reservando...';
    
    try {
        const res = await fetch('/reservas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                fecha_hora: fechaHora,
                id_restaurante: restauranteActualId,
            }),
        });
        
        const data = await res.json();
        
        if (res.ok) {
            mostrarToast('¡Reserva creada correctamente!', 'success');
            document.getElementById('form-reserva').reset();
        } else {
            mostrarError('error-reserva', data.message || 'Error al crear la reserva');
        }
    } catch {
        mostrarError('error-reserva', 'Error de conexión');
    } finally {
        btnReservar.disabled = false;
        btnReservar.textContent = 'Reservar ahora';
    }
};

// ── Crear reseña (AJAX) ─────────────────────
document.getElementById('form-resena').onsubmit = async function (e) {
    e.preventDefault();
    
    const comentario = document.getElementById('resena-comentario').value.trim();
    const puntuacion = document.getElementById('resena-puntuacion').value;
    const btnEnviar = document.getElementById('btn-enviar-resena');
    
    // Validación cliente
    if (!comentario || comentario === '') {
        mostrarError('error-resena', 'El comentario no puede estar vacío');
        return;
    }
    
    if (comentario.length < 10) {
        mostrarError('error-resena', 'El comentario debe tener al menos 10 caracteres');
        return;
    }
    
    if (comentario.length > 1000) {
        mostrarError('error-resena', 'El comentario no puede superar 1000 caracteres');
        return;
    }
    
    if (!puntuacion || puntuacion === '') {
        mostrarError('error-resena', 'Por favor ingresa una puntuación');
        return;
    }
    
    const punt = parseInt(puntuacion);
    if (isNaN(punt) || punt < 0 || punt > 10) {
        mostrarError('error-resena', 'La puntuación debe estar entre 0 y 10');
        return;
    }
    
    btnEnviar.disabled = true;
    btnEnviar.textContent = 'Enviando...';
    
    try {
        const res = await fetch('/resenas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                comentario,
                puntuacion: punt,
                id_restaurante: restauranteActualId,
            }),
        });
        
        const data = await res.json();
        
        if (res.ok) {
            mostrarToast('¡Reseña publicada!', 'success');
            document.getElementById('form-resena').reset();
            cargarResenas(restauranteActualId);
        } else {
            mostrarError('error-resena', data.message || 'Error al publicar la reseña');
        }
    } catch {
        mostrarError('error-resena', 'Error de conexión');
    } finally {
        btnEnviar.disabled = false;
        btnEnviar.textContent = 'Publicar reseña';
    }
};

// ── Cargar reseñas (AJAX) ───────────────────
async function cargarResenas(idRestaurante) {
    const contenedor = document.getElementById('lista-resenas');
    contenedor.innerHTML = '<p class="text-center text-gray-400 py-4">Cargando reseñas...</p>';
    
    try {
        const res = await fetch(`/resenas/${idRestaurante}`);
        const data = await res.json();
        
        if (data.resenas && data.resenas.length > 0) {
            contenedor.innerHTML = data.resenas.map(r => `
                <div class="border-b border-gray-100 pb-4 mb-4 last:border-0">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-teal-700 text-white rounded-full flex items-center justify-center font-bold text-xs">
                            ${r.usuario_nombre.charAt(0).toUpperCase()}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900">${r.usuario_nombre}</p>
                            <p class="text-xs text-gray-400">${r.fecha}</p>
                        </div>
                        <span class="px-2 py-1 bg-teal-100 text-teal-900 rounded-lg text-xs font-bold">
                            ${r.puntuacion}/10
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">${r.comentario}</p>
                </div>
            `).join('');
        } else {
            contenedor.innerHTML = '<p class="text-center text-gray-400 py-8">No hay reseñas todavía. ¡Sé el primero!</p>';
        }
    } catch {
        contenedor.innerHTML = '<p class="text-center text-red-500 py-4">Error al cargar reseñas</p>';
    }
}

// ── Asignar onclick a botones de Reservar ────
document.querySelectorAll('[data-btn-reservar]').forEach(btn => {
    btn.onclick = function (e) {
        e.preventDefault();
        abrirModalRestaurante(this.dataset.id, this.dataset.titulo);
    };
});

// ── Validación en tiempo real ────────────────
function inicializarValidacionesRealTime() {
    
    // Validar fecha en tiempo real
    const inputFecha = document.getElementById('reserva-fecha-hora');
    if (inputFecha) {
        inputFecha.onchange = function() {
            const fechaSeleccionada = new Date(this.value);
            const ahora = new Date();
            
            if (fechaSeleccionada <= ahora) {
                this.classList.add('border-red-500');
                mostrarError('error-reserva', 'La fecha debe ser futura');
            } else {
                this.classList.remove('border-red-500');
                document.getElementById('error-reserva').classList.add('hidden');
            }
        };
    }
    
    // Validar puntuación en tiempo real
    const inputPuntuacion = document.getElementById('resena-puntuacion');
    if (inputPuntuacion) {
        inputPuntuacion.oninput = function() {
            const valor = parseInt(this.value);
            
            if (this.value && (isNaN(valor) || valor < 0 || valor > 10)) {
                this.classList.add('border-red-500');
                mostrarError('error-resena', 'La puntuación debe estar entre 0 y 10');
            } else {
                this.classList.remove('border-red-500');
                document.getElementById('error-resena').classList.add('hidden');
            }
        };
    }
    
    // Validar comentario en tiempo real
    const textareaComentario = document.getElementById('resena-comentario');
    if (textareaComentario) {
        textareaComentario.oninput = function() {
            const longitud = this.value.trim().length;
            
            if (longitud > 0 && longitud < 10) {
                this.classList.add('border-yellow-500');
                this.classList.remove('border-red-500');
                mostrarError('error-resena', 'El comentario debe tener al menos 10 caracteres');
            } else if (longitud > 1000) {
                this.classList.add('border-red-500');
                this.classList.remove('border-yellow-500');
                mostrarError('error-resena', 'El comentario no puede superar 1000 caracteres');
            } else {
                this.classList.remove('border-red-500', 'border-yellow-500');
                document.getElementById('error-resena').classList.add('hidden');
            }
        };
    }
}

// ── Helpers ─────────────────────────────────
function mostrarError(elementId, mensaje) {
    const el = document.getElementById(elementId);
    el.textContent = mensaje;
    el.classList.remove('hidden');
    // No auto-ocultar para permitir validación en tiempo real
}

function mostrarToast(mensaje, tipo) {
    Swal.fire({
        toast: true,
        position: 'bottom-end',
        icon: tipo,
        title: mensaje,
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
    });
}