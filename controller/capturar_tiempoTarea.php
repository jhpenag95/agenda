<?php
require '../conexion.php';

// Recuperar los datos enviados por AJAX
$idUsuario = $_POST['idUsuario2'];
$lastTime = $_POST['tiempoFormatted2'];
$nombreDeLaClave = $_POST['nombreDeLaClave2'];

// Convertir el tiempo a formato HH:MM:SS
$tiempoFormatted = date('H:i:s', strtotime($lastTime));


date_default_timezone_set('America/Bogota');
$fechaactual = date('Y-m-d h:i:s');

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "INSERT INTO tiempos_tarea(tiempo_tarea, id_user, fecha, id_orden) VALUES (?, ?, ?, ?)";
$sql2 = "UPDATE ordenes SET estado_orden = 3 WHERE id_orden = ?";
$sql3 = "UPDATE usuarios SET id_estado = 1 WHERE id_usuario = ?";

// Preparar la sentencia SQL
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssss", $tiempoFormatted, $idUsuario,$fechaactual, $nombreDeLaClave);

// Ejecutar la inserción en la tabla tiempos_tarea
if ($stmt->execute()) {
    // Ejecutar las actualizaciones en las otras tablas
    $stmt2 = $conexion->prepare($sql2);
    $stmt2->bind_param("s", $nombreDeLaClave);
    $stmt2->execute();

    $stmt3 = $conexion->prepare($sql3);
    $stmt3->bind_param("s", $idUsuario);
    $stmt3->execute();

    // Obtener el resultado de la consulta
    $resultado = $conexion->query("SELECT message FROM actualizacion_resultado");
    
    if ($resultado->num_rows > 0) {
        // Mostrar el mensaje de éxito
        $row = $resultado->fetch_assoc();
        echo $row['message'];
    }
} else {
    // Mostrar mensaje de error
    echo "Error al ejecutar la inserción: " . $stmt->error;
}

// Cerrar la conexión a la base de datos
$stmt->close();
$stmt2->close();
$stmt3->close();
$conexion->close();
?>
