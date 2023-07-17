<?php
require_once '../conexion.php';

class UserModel
{

  // Función para validar si el usuario existe
  public function usernameExists($username, $email, $nombre)
  {
    $conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);

    // Comprobamos si se ha podido conectar a la base de datos
    if (!$conexion) {
      die("Error de conexión: " . mysqli_connect_error());
    }

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE (nombre_usuario = ? OR correo = ? OR nombre = ?) AND estado = 1");
    $stmt->bind_param("sss", $username, $email, $nombre);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    mysqli_close($conexion);

    return $result->num_rows > 0;
  }

  // Función para crear un usuario
  public static function createUser($nombre, $email, $telefono, $hashedPass, $username, $zona, $rol)
  {
    $conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);

    // Comprobamos si se ha podido conectar a la base de datos
    if (!$conexion) {
      die("Error de conexión: " . mysqli_connect_error());
    }

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, correo, telefono, clave, nombre_usuario, id_zona, id_rol) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nombre, $email, $telefono, $hashedPass, $username, $zona, $rol);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
      $user_id = $stmt->insert_id;
      $stmt->close();
      mysqli_close($conexion);
      return $user_id;
    } else {
      $stmt->close();
      mysqli_close($conexion);
      return false;
    }
  }
}
