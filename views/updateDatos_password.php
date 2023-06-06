<?php

session_start();
include '../conexion.php';

if (isset($_POST['id']) && isset($_POST['password']) && isset($_POST['newPass']) && isset($_POST['confirmPass'])) {
    $id = $_POST['id'];

    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    $newPass = mysqli_real_escape_string($conexion, $_POST['newPass']);
    $confirmPass = mysqli_real_escape_string($conexion, $_POST['confirmPass']);

    // Verificar que la contraseña nueva y la confirmación sean iguales
    if ($newPass === $confirmPass) {
        // Consulta SQL para verificar la contraseña actual del usuario
        $query = "SELECT clave FROM usuarios WHERE id_usuario = '$id'";
        $result = mysqli_query($conexion, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $currentPassword = $row['clave'];

            // Verificar si la contraseña actual ingresada coincide con la contraseña almacenada en la base de datos
            if (password_verify($password, $currentPassword)) {
                // Consulta SQL para actualizar la contraseña del usuario
                $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE usuarios SET clave = '$hashedPass' WHERE id_usuario = '$id'";
                $updateResult = mysqli_query($conexion, $updateQuery);

                if ($updateResult) {
                    $_SESSION['success'] = "¡Contraseña actualizada correctamente!";
                    header("Location: dashboard.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Error al actualizar la contraseña. Por favor, intenta nuevamente.";
                    header("Location: dashboard.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "La contraseña actual ingresada no coincide, verifica e intenta nuevamente.";
                header("Location: dashboard.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Error al consultar la contraseña actual. Por favor, intenta nuevamente.";
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "La contraseña nueva y la confirmación no coinciden, verifica e intenta nuevamente.";
        header("Location: dashboard.php");
        exit();
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
