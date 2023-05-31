<?php
session_start();

include_once "../conexion.php";

if (!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['tel']) && !empty($_POST['mane_user']) && !empty($_POST['id_zona']) && !empty($_POST['id_rol'])) {
    $id_usuario = $_POST['id'];
    $nombre = $_POST['name'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $mane_user = $_POST['mane_user'];
    $id_zona = $_POST['id_zona'];
    $id_rol = $_POST['id_rol'];
    $id_estado = $_POST['id_estado'];

    // Verificar que el ID proporcionado en el formulario existe en la base de datos
    $stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        echo '<div class="alert alert-danger mt-4">El ID del usuario no existe</div>';
        exit;
    }

    // Actualizar los datos del usuario en la base de datos
    $stmt = $conexion->prepare("UPDATE usuarios SET nombre = ?, correo = ?, telefono = ?, nombre_usuario = ?, id_zona = ?, id_rol = ?, id_estado = ? WHERE id_usuario = ?");
    $stmt->bind_param("ssisiiii", $nombre, $email, $tel, $mane_user, $id_zona, $id_rol, $id_estado, $id_usuario);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = "Actualización exitosa";
        header("Location: ../views/listadeUsuarios.php");
        exit();
    } else {
        $_SESSION['error'] = "No han ocurrido cambios al actualizar el usuario";
        header("Location: ../views/listadeUsuarios.php");
        exit();
    }
} else {
    $_SESSION['falta'] = "Los datos están vacíos";
    header("Location: ../views/listadeUsuarios.php");
    exit();
}
