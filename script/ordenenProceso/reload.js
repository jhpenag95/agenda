// Función para recargar la página cada 5 segundos
function reloadPageEvery5Seconds() {
    setInterval(() => {
        location.reload();
    }, 5000); // 5000 milisegundos = 5 segundos
}

// Llamar a la función al cargar la página
window.addEventListener('load', reloadPageEvery5Seconds);
