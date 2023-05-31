<?php

require_once '../conexion.php';

class UserModel
{

  // Función para valir si usuario existe

  public function usernameExists($username, $email, $nombre)
  {
      $conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);
      $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE nombre_usuario = ? OR correo = ? OR nombre = ?");
      $stmt->bind_param("sss", $username, $email, $nombre);
      $stmt->execute();
      $result = $stmt->get_result();
      return $result->num_rows > 0;
  }
  


   // Función para crear un usuario
   public static function createUser($nombre, $email, $telefono, $clave, $username, $zona, $rol)
  {
    // Conexión a la base de datos
    $conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);

    // Comprobamos si se ha podido conectar a la base de datos
    if (!$conexion) {
      die("Error de conexión: " . mysqli_connect_error());
    }

    // Preparamos la consulta para insertar el usuario en la tabla "usuarios"
    $query = "INSERT INTO usuarios (nombre, correo, telefono, clave, nombre_usuario, id_zona, id_rol) VALUES ('$nombre', '$email', '$telefono', '$clave', '$username', '$zona', '$rol')";

    // Ejecutamos la consulta
    $result = mysqli_query($conexion, $query);

    // Comprobamos si la consulta se ha ejecutado correctamente
    if ($result) {
      $user_id = mysqli_insert_id($conexion);
      mysqli_close($conexion);
      return $user_id;
    } else {
      mysqli_close($conexion);
      return false;
    }
  }
}
