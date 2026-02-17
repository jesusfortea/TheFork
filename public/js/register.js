/**
 * ============================================
 * SCRIPT DE VALIDACIÓN Y AJAX PARA REGISTRO
 * ============================================
 * 
 * Este archivo maneja:
 * 1. Validaciones en tiempo real del formulario de registro
 * 2. Verificación de coincidencia de contraseñas
 * 3. Indicador de fortaleza de contraseña
 * 4. Envío del formulario mediante AJAX
 * 5. Notificaciones con SweetAlert2
 * 
 * NOTA: Usa eventos inline (onblur, oninput, onsubmit) en lugar de addEventListener
 */

// ========================================
// 1. FUNCIONES DE VALIDACIÓN
// ========================================

/**
 * Valida si el nombre es válido (mínimo 3 caracteres)
 * @param {string} name - El nombre a validar
 * @returns {boolean} - true si es válido, false si no
 */
function validarNombre(name) {
    return name.trim().length >= 3;
}

/**
 * Valida si el email tiene un formato correcto
 * @param {string} email - El email a validar
 * @returns {boolean} - true si es válido, false si no
 */
function validarEmailRegistro(email) {
    // Expresión regular para validar el formato de email
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

/**
 * Valida si la contraseña cumple con los requisitos (mínimo 8 caracteres)
 * @param {string} password - La contraseña a validar
 * @returns {boolean} - true si es válida, false si no
 */
function validarPasswordRegistro(password) {
    return password.length >= 8;
}

/**
 * Valida si las dos contraseñas coinciden
 * @param {string} password - La contraseña original
 * @param {string} confirmation - La confirmación de contraseña
 * @returns {boolean} - true si coinciden, false si no
 */
function validarPasswordMatch(password, confirmation) {
    return password === confirmation && password !== '';
}

// ========================================
// 2. FUNCIONES PARA MOSTRAR/QUITAR ERRORES
// ========================================

/**
 * Muestra un error debajo de un campo
 * @param {HTMLElement} input - El campo de input
 * @param {string} mensaje - El mensaje de error a mostrar
 */
function mostrarErrorRegistro(input, mensaje) {
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
function quitarErrorRegistro(input) {
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
 * Valida el campo de nombre cuando el usuario sale del campo
 * Esta función se llama desde el HTML con onblur="validarCampoNombre()"
 */
function validarCampoNombre() {
    const nameInput = document.getElementById('name');
    const name = nameInput.value.trim();

    if (name === '') {
        mostrarErrorRegistro(nameInput, 'El nombre es obligatorio');
    } else if (!validarNombre(name)) {
        mostrarErrorRegistro(nameInput, 'El nombre debe tener al menos 3 caracteres');
    } else {
        quitarErrorRegistro(nameInput);
    }
}

/**
 * Valida el campo de email cuando el usuario sale del campo
 * Esta función se llama desde el HTML con onblur="validarCampoEmailRegistro()"
 */
function validarCampoEmailRegistro() {
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();

    if (email === '') {
        mostrarErrorRegistro(emailInput, 'El correo electrónico es obligatorio');
    } else if (!validarEmailRegistro(email)) {
        mostrarErrorRegistro(emailInput, 'Por favor, ingresa un correo electrónico válido');
    } else {
        quitarErrorRegistro(emailInput);
    }
}

/**
 * Valida el campo de contraseña cuando el usuario sale del campo
 * Esta función se llama desde el HTML con onblur="validarCampoPasswordRegistro()"
 */
function validarCampoPasswordRegistro() {
    const passwordInput = document.getElementById('password');
    const password = passwordInput.value;

    if (password === '') {
        mostrarErrorRegistro(passwordInput, 'La contraseña es obligatoria');
    } else if (!validarPasswordRegistro(password)) {
        mostrarErrorRegistro(passwordInput, 'La contraseña debe tener al menos 8 caracteres');
    } else {
        quitarErrorRegistro(passwordInput);

        // Si ya se escribió la confirmación, validarla también
        const passwordConfirmInput = document.getElementById('password_confirmation');
        if (passwordConfirmInput.value !== '') {
            validarCampoPasswordConfirm();
        }
    }
}

/**
 * Valida el campo de confirmación de contraseña
 * Esta función se llama desde el HTML con onblur="validarCampoPasswordConfirm()"
 */
function validarCampoPasswordConfirm() {
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const password = passwordInput.value;
    const confirmation = passwordConfirmInput.value;

    if (confirmation === '') {
        mostrarErrorRegistro(passwordConfirmInput, 'Debes confirmar tu contraseña');
    } else if (!validarPasswordMatch(password, confirmation)) {
        mostrarErrorRegistro(passwordConfirmInput, 'Las contraseñas no coinciden');
    } else {
        quitarErrorRegistro(passwordConfirmInput);
    }
}

// ========================================
// 4. INDICADOR DE FORTALEZA DE CONTRASEÑA
// ========================================

/**
 * Muestra indicador visual de fortaleza mientras el usuario escribe
 * Esta función se llama desde el HTML con oninput="mostrarFortalezaPassword()"
 */
function mostrarFortalezaPassword() {
    const passwordInput = document.getElementById('password');
    const password = passwordInput.value;
    let strength = '';
    let color = '';

    // Evaluar la fortaleza según la longitud
    if (password.length === 0) {
        strength = '';
    } else if (password.length < 6) {
        strength = 'Débil';
        color = 'text-red-500';
    } else if (password.length < 10) {
        strength = 'Media';
        color = 'text-yellow-500';
    } else {
        strength = 'Fuerte';
        color = 'text-green-500';
    }

    // Buscar o crear el indicador de fortaleza
    let strengthElement = passwordInput.parentElement.querySelector('.password-strength');

    if (strength !== '') {
        if (!strengthElement) {
            strengthElement = document.createElement('p');
            strengthElement.className = 'password-strength text-xs mt-1';
            // Insertarlo después del texto "Mínimo 8 caracteres"
            const helpText = passwordInput.parentElement.querySelector('.text-gray-500');
            if (helpText) {
                helpText.after(strengthElement);
            }
        }
        strengthElement.textContent = 'Fortaleza: ' + strength;
        strengthElement.className = 'password-strength text-xs mt-1 ' + color;
    } else if (strengthElement) {
        strengthElement.remove();
    }
}

// ========================================
// 5. FUNCIÓN DE ENVÍO DEL FORMULARIO
// ========================================

/**
 * Procesa el envío del formulario de registro con AJAX
 * Esta función se llama desde el HTML con onsubmit="return procesarRegistro(event)"
 * @param {Event} event - El evento de submit del formulario
 * @returns {boolean} - false para prevenir el envío normal del formulario
 */
function procesarRegistro(event) {
    // Prevenir el envío normal del formulario
    event.preventDefault();

    // Obtener los campos del formulario
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('terms');
    const submitButton = document.getElementById('register');

    // Obtener los valores de los campos
    const name = nameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value;
    const passwordConfirm = passwordConfirmInput.value;
    const termsAccepted = termsCheckbox.checked;

    // Variable para controlar si hay errores
    let hayErrores = false;

    // ========================================
    // VALIDAR TODOS LOS CAMPOS
    // ========================================

    // Validar nombre
    if (name === '') {
        mostrarErrorRegistro(nameInput, 'El nombre es obligatorio');
        hayErrores = true;
    } else if (!validarNombre(name)) {
        mostrarErrorRegistro(nameInput, 'El nombre debe tener al menos 3 caracteres');
        hayErrores = true;
    } else {
        quitarErrorRegistro(nameInput);
    }

    // Validar email
    if (email === '') {
        mostrarErrorRegistro(emailInput, 'El correo electrónico es obligatorio');
        hayErrores = true;
    } else if (!validarEmailRegistro(email)) {
        mostrarErrorRegistro(emailInput, 'Por favor, ingresa un correo electrónico válido');
        hayErrores = true;
    } else {
        quitarErrorRegistro(emailInput);
    }

    // Validar contraseña
    if (password === '') {
        mostrarErrorRegistro(passwordInput, 'La contraseña es obligatoria');
        hayErrores = true;
    } else if (!validarPasswordRegistro(password)) {
        mostrarErrorRegistro(passwordInput, 'La contraseña debe tener al menos 8 caracteres');
        hayErrores = true;
    } else {
        quitarErrorRegistro(passwordInput);
    }

    // Validar confirmación de contraseña
    if (passwordConfirm === '') {
        mostrarErrorRegistro(passwordConfirmInput, 'Debes confirmar tu contraseña');
        hayErrores = true;
    } else if (!validarPasswordMatch(password, passwordConfirm)) {
        mostrarErrorRegistro(passwordConfirmInput, 'Las contraseñas no coinciden');
        hayErrores = true;
    } else {
        quitarErrorRegistro(passwordConfirmInput);
    }

    // Validar términos y condiciones
    if (!termsAccepted) {
        Swal.fire({
            icon: 'warning',
            title: 'Términos y condiciones',
            text: 'Debes aceptar los términos y condiciones para continuar',
            confirmButtonColor: '#0f766e'
        });
        hayErrores = true;
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
    submitButton.textContent = 'CREANDO CUENTA...';

    // Obtener el token CSRF de Laravel (necesario para seguridad)
    const csrfToken = document.querySelector('input[name="_token"]').value;

    // Preparar los datos para enviar
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('password_confirmation', passwordConfirm);
    formData.append('terms', termsAccepted ? '1' : '0');
    formData.append('_token', csrfToken);

    // ========================================
    // HACER LA PETICIÓN AJAX CON FETCH
    // ========================================

    // Hacer la petición AJAX al servidor
    fetch('/register', {
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

            // Si el registro fue exitoso (código 200 o 201)
            if ((result.status === 200 || result.status === 201) && result.data.success) {
                // Mostrar SweetAlert de éxito
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "¡Cuenta creada con éxito!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    // Redirigir a la página correspondiente
                    window.location.href = result.data.redirect;
                });
            }
            // Si hubo errores de validación
            else {
                // Mostrar SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error en el registro',
                    text: result.data.message || 'Por favor, verifica los datos ingresados',
                    confirmButtonColor: '#0f766e'
                });

                // Si hay errores específicos de campos, mostrarlos
                if (result.data.errors) {
                    // Recorrer cada error y mostrarlo en el campo correspondiente
                    for (let field in result.data.errors) {
                        const input = document.getElementById(field);
                        if (input) {
                            mostrarErrorRegistro(input, result.data.errors[field][0]);
                        }
                    }
                }

                // Reactivar el botón de envío
                submitButton.disabled = false;
                submitButton.textContent = 'CREAR CUENTA';
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
            submitButton.textContent = 'CREAR CUENTA';
        });

    // Retornar false para prevenir el envío tradicional del formulario
    return false;
}
