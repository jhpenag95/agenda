<?php
require_once('../conexion.php');

if (isset($_POST['id']) && isset($_POST['new_password']) && isset($_POST['confirm-password'])) {
    $encryptedId = $_POST['id'];
    $id = base64_decode($encryptedId); // Desencriptar el ID
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm-password'];

    if ($new_password != $confirm_password) {
        header("location: ../index.php?message=error");
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE usuarios SET clave = ? WHERE id_usuario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("si", $hashed_password, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("location: ../index.php?message=ok");
        } else {
            header("location: ../index.php?message=error");
        }
    }
} else {
    header("location: ../index.php?message=invalidemail");
    exit();
}
?>

