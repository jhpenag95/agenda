<?php
session_start();
include_once "../conexion.php";

// Verificar si se recibió un ID válido en la URL
if (empty($_GET['id'])) {
    $_SESSION['not'] = "ID de la orden no es válido";
    header('Location: ../views/crearOrden.php');
    exit;
}

$id = $_GET['id'];

$query_delete = "UPDATE ordenes SET estado_orden = 0 WHERE id_orden  = ?";
$stmt = $conexion->prepare($query_delete);
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $_SESSION['okOrden'] = "Orden eliminada exitosamente";
} else {
    $_SESSION['notOrden'] = "No se pudo eliminar la orden";
}

$stmt->close();
$conexion->close();

header("Location: ../views/crearOrden.php");
exit();
?>
