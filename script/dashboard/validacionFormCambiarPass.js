// Obtener los elementos de los campos de contraseña
var passwordInput = document.getElementById("password");
var newPassInput = document.getElementById("newPass");
var confirmPassInput = document.getElementById("confirmPass");

// Agregar eventos de escucha a los campos de contraseña
passwordInput.addEventListener("input", validatePassword);
newPassInput.addEventListener("input", validateNewPassword);
confirmPassInput.addEventListener("input", validateConfirmPassword);

// Función para validar la contraseña actual
function validatePassword() {
    var password = passwordInput.value;

    // Restablecer el estado de validación del campo
    passwordInput.classList.remove("is-invalid");
    document.getElementById("passwordError").innerText = "";

    // Validar la contraseña actual
    // ...

    // Puedes realizar la validación aquí o llamar a una función separada
}

// Función para validar la nueva contraseña
function validateNewPassword() {
    var newPass = newPassInput.value;

    // Restablecer el estado de validación del campo
    newPassInput.classList.remove("is-invalid");
    document.getElementById("newPassError").innerText = "";

    // Validar la nueva contraseña
    var passwordPattern = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
    if (!passwordPattern.test(newPass)) {
        newPassInput.classList.add("is-invalid");
        document.getElementById("newPassError").innerText = "La contraseña debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula y un número";
    }
}

// Función para validar la confirmación de contraseña
function validateConfirmPassword() {
    var confirmPass = confirmPassInput.value;

    // Restablecer el estado de validación del campo
    confirmPassInput.classList.remove("is-invalid");
    document.getElementById("confirmPassError").innerText = "";

    // Validar la confirmación de contraseña
    var newPass = newPassInput.value;
    if (newPass !== confirmPass) {
        confirmPassInput.classList.add("is-invalid");
        document.getElementById("confirmPassError").innerText = "Las contraseñas no coinciden";
    }
}

// Función para validar el formulario completo
function validateForm() {
    // Llamar a las funciones de validación individuales
    validatePassword();
    validateNewPassword();
    validateConfirmPassword();

    // Verificar si hay errores de validación en alguno de los campos
    var errorElements = document.getElementsByClassName("is-invalid");
    if (errorElements.length > 0) {
        return false; // Devolver false para evitar el envío del formulario
    }

    return true; // Devolver true para permitir el envío del formulario
}
