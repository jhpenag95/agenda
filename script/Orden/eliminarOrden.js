// Función para establecer el ID y nombre del usuario en el modal
function setUsuarioID(id, nombre) {
    document.getElementById('idOrden').value = id;
    document.getElementById('nombreOrden').textContent = nombre;
}

// Función para eliminar el usuario
function eliminarUsuario() {
    var idUsuario = document.getElementById('idOrden').value;
    var url = '../controller/eliminar_OrdenC.php?id=' + idUsuario;
    window.location.href = url;
}