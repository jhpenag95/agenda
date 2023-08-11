<?php
require '../conexion.php';

// Obtener el id_orden desde la solicitud POST
$id_orden = $_POST['id_orden'];

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para actualizar el estado a 2
$sqlEstado = "UPDATE ordenes SET estado_orden = 2 WHERE estado_orden = 1 AND id_orden = ?";

// Preparar la consulta
$stmt = $conexion->prepare($sqlEstado);

// Verificar si la preparación fue exitosa
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

// Vincular parámetros
$stmt->bind_param("i", $id_orden);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Estado actualizado correctamente";
} else {
    echo "Error al actualizar el estado: " . $stmt->error;
}

// Cerrar la declaración y la conexión
$stmt->close();
$conexion->close();
?>
