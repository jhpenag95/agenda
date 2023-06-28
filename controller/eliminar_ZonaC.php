<?php
session_start();
include_once "../conexion.php";

// Verificar si se recibió un ID válido en la URL
if (empty($_GET['id'])) {
    $_SESSION['error'] = "ID de la orden no es válido";
    header('Location: ../views/lista_zonas.php');
    exit;
}

$id_encode = $_GET['id'];
$id = base64_decode($id_encode);

$query_delete = "UPDATE zonas SET estado = 0 WHERE id_zona  = ?";
$stmt = $conexion->prepare($query_delete);
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['success'] = "Zona eliminada exitosamente";
} else {
    $_SESSION['error'] = "No se pudo eliminar la zona";
}

$stmt->close();
$conexion->close();

header("Location: ../views/lista_zonas.php");
exit();
?>
