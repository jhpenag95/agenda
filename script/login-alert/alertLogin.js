// Función para ocultar el elemento después de cierto tiempo
function hideElement(elementId) {
    var element = document.getElementById(elementId);
    if (element) {
        setTimeout(function () {
            element.style.display = "none";
        }, 5000); // Oculta el elemento después de 5000 milisegundos (5 segundos)
    }
}

// Llama a la función para ocultar el mensaje cuando se cargue la página
window.addEventListener("load", function () {
    hideElement("message");
    hideElement("alertMessage");
});