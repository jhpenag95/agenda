<?php
// Inicia la sesión si no está iniciada
session_start();

// Incluye el archivo de conexión a la base de datos
include '../conexion.php';

// Verifica si la solicitud es de tipo POST y si están presentes los parámetros 'orden_id' y 'tiempo'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orden_id'], $_POST['tiempo'])) {
    $ordenId = $_POST['orden_id'];
    $tiempo = $_POST['tiempo'];

    // Obtener el tiempo de inicio actual o guardar uno nuevo si no existe
    $query = "SELECT tiempo_inicio_proce FROM ordenes WHERE id_orden = ?";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $ordenId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $tiempoInicio);
        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);

        if (!$tiempoInicio) {
            $tiempoInicio = time(); // Guardar el tiempo de inicio en segundos
            $query = "UPDATE ordenes SET tiempo_inicio_proce = ? WHERE id_orden = ?";
            $stmt = mysqli_prepare($conexion, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ii", $tiempoInicio, $ordenId);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }

    // Actualizar el tiempo transcurrido
    $updateQuery = "UPDATE ordenes SET tiempo_transcurrido_proce = ? WHERE id_orden = ?";

    // Crear una declaración preparada
    $stmt = mysqli_prepare($conexion, $updateQuery);

    if ($stmt) {
        // Asociar los parámetros
        mysqli_stmt_bind_param($stmt, "ii", $tiempo, $ordenId);

        // Ejecutar la consulta preparada
        if (mysqli_stmt_execute($stmt)) {
            // Si la actualización fue exitosa, devuelve una respuesta JSON de éxito
            echo json_encode(['status' => 'success']);
        } else {
            // Si hubo un error en la actualización, devuelve una respuesta JSON de error
            echo json_encode(['status' => 'error']);
        }

        // Cerrar la declaración preparada
        mysqli_stmt_close($stmt);
    } else {
        // Si hubo un error en la preparación de la consulta, devuelve una respuesta JSON de error
        echo json_encode(['status' => 'error']);
    }
} else {
    // Si la solicitud no es de tipo POST o faltan parámetros, devuelve una respuesta JSON de error
    echo json_encode(['status' => 'error']);
}
?>
