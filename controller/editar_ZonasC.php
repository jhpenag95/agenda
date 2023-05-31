<?php
session_start();

include_once "../conexion.php";

if (isset($_POST['id'], $_POST['name'])) {
    $idzona = $_POST['id'];
    $nombre = $_POST['name'];

    // Verificar si el ID proporcionado en el formulario existe en la base de datos
    $stmt = $conexion->prepare("SELECT id_zona FROM zonas WHERE id_zona = ?");
    $stmt->bind_param("i", $idzona);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $_SESSION['error'] = "El ID de la zona no existe";
        header("Location: ../views/lista_zona");
        exit();
    }

    // Actualizar los datos de la zona en la base de datos
    $stmt = $conexion->prepare("UPDATE zonas SET nombre_zona = ? WHERE id_zona = ?");
    $stmt->bind_param("si", $nombre, $idzona);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = "Actualización exitosa";
        header("Location: ../views/lista_zonas.php");
        exit();
    } else {
        $_SESSION['error'] = "No se han realizado cambios al actualizar la zona";
        header("Location: ../views/lista_zonas.php");
        exit();
    }
} else {
    $_SESSION['falta'] = "Los datos están vacíos";
    header("Location: ../views/lista_zonas.php");
    exit();
}
