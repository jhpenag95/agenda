const nombreFile = document.querySelector("[name=name]");
const emailFile = document.querySelector("[name=email]");
const telFile = document.querySelector("[name=tel]");
const claveFile = document.querySelector("[name=clave]");
const mane_userFile = document.querySelector("[name=mane_user]");
const zonaFile = document.querySelector("[name=zona]");
const rolFile = document.querySelector("[name=rol]");

// Funciones para errores
const setError = (message, field, esError = true) => {
    if (esError) {
        field.classList.add("invalid");
        field.nextElementSibling.classList.add("error");
        field.nextElementSibling.innerText = message;
    } else {
        field.classList.remove("invalid");
        field.nextElementSibling.classList.remove("error");
        field.nextElementSibling.innerText = "";
    }
}

// Validando que existan datos
const validateEmptyField = (message, e) => {
    const field = e.target;
    const fieldValue = e.target.value;

    if (fieldValue.trim().length === 0) {
        setError(message, field);
    } else {
        setError("", field, false);
    }
}

// Validando formato para Email
const validateEmailFormat = e => {
    const field = e.target;
    const fieldValue = e.target.value;
    const regex = new RegExp(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/);
    regex.test(field.value);

    if (fieldValue.trim().length > 5 && !regex.test(fieldValue)) {
        setError("Por favor, ingresa un correo válido", field);
    } else {
        setError("", field, false);
    }
}

// Se imprimen los mensajes
nombreFile.addEventListener("blur", (e) => validateEmptyField("Ingresa por favor el nombre", e));
emailFile.addEventListener("blur", (e) => validateEmptyField("Ingresa por favor el correo", e));
telFile.addEventListener("blur", (e) => validateEmptyField("Ingresa por favor el teléfono", e));
claveFile.addEventListener("blur", (e) => validateEmptyField("Ingresa por favor la clave", e));
mane_userFile.addEventListener("blur", (e) => validateEmptyField("Ingresa por favor el usuario para ingresar", e));
zonaFile.addEventListener("blur", (e) => validateEmptyField("Por favor, seleccione la zona", e));
rolFile.addEventListener("blur", (e) => validateEmptyField("Por favor, seleccione el rol", e));

// Cada vez que se escribe algo en el campo de correo, se valida el formato
emailFile.addEventListener("input", validateEmailFormat);
claveFile.addEventListener("input", validarContrasena);
