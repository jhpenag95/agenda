<?php
session_start();
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['orden_id'])) {
    $ordenId = $_GET['orden_id'];

    // Consulta para obtener el tiempo transcurrido de la base de datos
    $query = "SELECT tiempo_transcurrido_proce FROM ordenes WHERE id_orden = ?";
    $stmt = mysqli_prepare($conexion, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $ordenId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $tiempoTranscurrido);
        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);

        echo json_encode(['tiempo' => $tiempoTranscurrido]);
    } else {
        echo json_encode(['error' => 'No se pudo obtener el tiempo.']);
    }
} else {
    echo json_encode(['error' => 'Parámetros inválidos.']);
}
?>
