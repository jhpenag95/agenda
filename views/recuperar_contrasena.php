<?php
require_once('../conexion.php');

if (isset($_POST['id']) && isset($_POST['new_password']) && isset($_POST['confirm-password'])) {
    $id = $_POST['id'];
    $new_password = md5($_POST['new_password']); 
    $confirm_password = md5($_POST['confirm-password']); 

    if ($new_password != $confirm_password) {
        header("location: actualizarContrasena.php?message=error");
    } else {
        $query = "UPDATE usuarios SET clave = ? WHERE id_usuario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("si", $new_password, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("location: actualizarContrasena.php?message=ok");
        } else {
            header("location: actualizarContrasena.php?message=error");
        }
    }
} else {
    header("location: actualizarContrasena.php?message=invalidemail");
  exit();
}
?>

