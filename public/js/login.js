/**
 * ============================================
 * SCRIPT DE VALIDACIÓN Y AJAX PARA LOGIN
 * ============================================
 * 
 * Este archivo maneja:
 * 1. Validaciones en tiempo real del formulario de login
 * 2. Envío del formulario mediante AJAX
 * 3. Notificaciones con SweetAlert2
 * 
 * NOTA: Usa eventos inline (onblur, onsubmit) en lugar de addEventListener
 */

// ========================================
// 1. FUNCIONES DE VALIDACIÓN
// ========================================

/**
 * Valida si el email tiene un formato correcto
 * @param {string} email - El email a validar
 * @returns {boolean} - true si es válido, false si no
 */
function validarEmail(email) {
    // Expresión regular para validar el formato de email
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

/**
 * Valida si la contraseña es válida (mínimo 6 caracteres)
 * @param {string} password - La contraseña a validar
 * @returns {boolean} - true si es válida, false si no
 */
function validarPassword(password) {
    return password.length >= 6;
}

// ========================================
// 2. FUNCIONES PARA MOSTRAR/QUITAR ERRORES
// ========================================

/**
 * Muestra un error debajo de un campo
 * @param {HTMLElement} input - El campo de input
 * @param {string} mensaje - El mensaje de error a mostrar
 */
function mostrarError(input, mensaje) {
    // Buscar si ya existe un mensaje de error
    let errorElement = input.parentElement.querySelector('.error-message');

    // Si no existe, crearlo
    if (!errorElement) {
        errorElement = document.createElement('p');
        errorElement.className = 'error-message text-red-500 text-xs mt-1';
        input.parentElement.appendChild(errorElement);
    }

    // Establecer el mensaje de error
    errorElement.textContent = mensaje;
    // Añadir borde rojo al input
    input.classList.add('border-red-500');
    input.classList.remove('border-gray-300');
}

/**
 * Quita el mensaje de error de un campo
 * @param {HTMLElement} input - El campo de input
 */
function quitarError(input) {
    // Buscar el mensaje de error
    const errorElement = input.parentElement.querySelector('.error-message');

    // Si existe, eliminarlo
    if (errorElement) {
        errorElement.remove();
    }

    // Quitar borde rojo y poner el normal
    input.classList.remove('border-red-500');
    input.classList.add('border-gray-300');
}

// ========================================
// 3. FUNCIONES DE VALIDACIÓN POR CAMPO
// ========================================

/**
 * Valida el campo de email cuando el usuario sale del campo
 * Esta función se llama desde el HTML con onblur="validarCampoEmail()"
 */
function validarCampoEmail() {
    // Obtener el campo de email
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();

    // Si el campo está vacío
    if (email === '') {
        mostrarError(emailInput, 'El correo electrónico es obligatorio');
    }
    // Si el formato no es válido
    else if (!validarEmail(email)) {
        mostrarError(emailInput, 'Por favor, ingresa un correo electrónico válido');
    }
    // Si todo está bien, quitar errores
    else {
        quitarError(emailInput);
    }
}

/**
 * Valida el campo de contraseña cuando el usuario sale del campo
 * Esta función se llama desde el HTML con onblur="validarCampoPassword()"
 */
function validarCampoPassword() {
    // Obtener el campo de contraseña
    const passwordInput = document.getElementById('password');
    const password = passwordInput.value;

    // Si el campo está vacío
    if (password === '') {
        mostrarError(passwordInput, 'La contraseña es obligatoria');
    }
    // Si es muy corta
    else if (!validarPassword(password)) {
        mostrarError(passwordInput, 'La contraseña debe tener al menos 6 caracteres');
    }
    // Si todo está bien, quitar errores
    else {
        quitarError(passwordInput);
    }
}

// ========================================
// 4. FUNCIÓN DE ENVÍO DEL FORMULARIO
// ========================================

/**
 * Procesa el envío del formulario de login con AJAX
 * Esta función se llama desde el HTML con onsubmit="return procesarLogin(event)"
 * @param {Event} event - El evento de submit del formulario
 * @returns {boolean} - false para prevenir el envío normal del formulario
 */
function procesarLogin(event) {
    // Prevenir el envío normal del formulario
    event.preventDefault();

    // Obtener los campos del formulario
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const submitButton = document.getElementById('login');

    // Obtener los valores de los campos
    const email = emailInput.value.trim();
    const password = passwordInput.value;

    // Variable para controlar si hay errores
    let hayErrores = false;

    // ========================================
    // VALIDAR TODOS LOS CAMPOS
    // ========================================

    // Validar email
    if (email === '') {
        mostrarError(emailInput, 'El correo electrónico es obligatorio');
        hayErrores = true;
    } else if (!validarEmail(email)) {
        mostrarError(emailInput, 'Por favor, ingresa un correo electrónico válido');
        hayErrores = true;
    } else {
        quitarError(emailInput);
    }

    // Validar contraseña
    if (password === '') {
        mostrarError(passwordInput, 'La contraseña es obligatoria');
        hayErrores = true;
    } else if (!validarPassword(password)) {
        mostrarError(passwordInput, 'La contraseña debe tener al menos 6 caracteres');
        hayErrores = true;
    } else {
        quitarError(passwordInput);
    }

    // Si hay errores, no continuar
    if (hayErrores) {
        return false;
    }

    // ========================================
    // PREPARAR EL ENVÍO AJAX
    // ========================================

    // Deshabilitar el botón de envío para evitar múltiples envíos
    submitButton.disabled = true;
    submitButton.textContent = 'INICIANDO SESIÓN...';

    // Obtener el token CSRF de Laravel (necesario para seguridad)
    const csrfToken = document.querySelector('input[name="_token"]').value;

    // Preparar los datos para enviar
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    formData.append('_token', csrfToken);

    // ========================================
    // HACER LA PETICIÓN AJAX CON FETCH
    // ========================================

    // Hacer la petición AJAX al servidor
    fetch('/login', {
        method: 'POST', // Método HTTP POST
        headers: {
            'Accept': 'application/json', // Indicar que esperamos JSON
            'X-CSRF-TOKEN': csrfToken // Token de seguridad
        },
        body: formData // Los datos del formulario
    })
        .then(function (response) {
            // Convertir la respuesta a JSON
            return response.json().then(function (data) {
                // Retornar tanto los datos como el estado de la respuesta
                return {
                    status: response.status,
                    data: data
                };
            });
        })
        .then(function (result) {
            // ========================================
            // MANEJAR LA RESPUESTA DEL SERVIDOR
            // ========================================

            // Si el login fue exitoso (código 200)
            if (result.status === 200 && result.data.success) {
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Bienvenido!',
                    text: result.data.message || 'Has iniciado sesión correctamente',
                    confirmButtonColor: '#0f766e', // Color teal-900
                    confirmButtonText: 'Continuar'
                }).then(function () {
                    // Redirigir a la página correspondiente
                    window.location.href = result.data.redirect;
                });
            }
            // Si hubo un error de validación o credenciales incorrectas
            else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error al iniciar sesión',
                    text: result.data.message || 'Las credenciales no son correctas',
                    confirmButtonColor: '#0f766e'
                });

                // Reactivar el botón de envío
                submitButton.disabled = false;
                submitButton.textContent = 'INICIAR SESIÓN';
            }
        })
        .catch(function (error) {
            // ========================================
            // MANEJAR ERRORES DE RED O DEL SERVIDOR
            // ========================================

            console.error('Error:', error);

            // Mostrar SweetAlert de error
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'Hubo un problema al conectar con el servidor. Por favor, intenta de nuevo.',
                confirmButtonColor: '#0f766e'
            });

            // Reactivar el botón de envío
            submitButton.disabled = false;
            submitButton.textContent = 'INICIAR SESIÓN';
        });

    // Retornar false para prevenir el envío tradicional del formulario
    return false;
}
