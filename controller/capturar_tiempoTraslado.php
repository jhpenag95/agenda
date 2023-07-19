<?php
require '../conexion.php';

if (isset($_POST['idUsuario1']) && isset($_POST['lastTime1'])) {
    // Recuperar los datos enviados por AJAX
    $idUsuario1 = $_POST['idUsuario1'];
    $lastTime1 = $_POST['lastTime1'];
    $nombreDeLaClave1 = $_POST['nombreDeLaClave1'];

    // Convertir el tiempo a formato HH:MM:SS
    $tiempoFormatted = date('H:i:s', strtotime($lastTime1));

    date_default_timezone_set('America/Bogota');
    $fechaactual = date('Y-m-d h:i:s');

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Preparar la llamada al procedimiento almacenado
    $sql = "INSERT INTO tiempos_traslado (tiempo, id_user,fecha, id_orden) VALUES ('$tiempoFormatted', '$idUsuario1','$fechaactual', '$nombreDeLaClave1')";

    // Ejecutar la llamada al procedimiento almacenado
    if ($conexion->query($sql) === TRUE) {
        // Obtener el resultado de la consulta
        $resultado = $conexion->query("SELECT message FROM actualizacion_resultado");

        if ($resultado->num_rows > 0) {
            // Mostrar el mensaje de éxito
            $row = $resultado->fetch_assoc();
            echo $row['message'];
        }
    } else {
        // Mostrar mensaje de error
        echo "Error al ejecutar el procedimiento almacenado: " . $conexion->error;
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
}
?>
