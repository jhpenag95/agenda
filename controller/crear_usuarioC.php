<?php
session_start();

include_once '../models/crear_usuarioM.php';

// Comprobamos si se ha enviado el formulario
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['mane_user']) && isset($_POST['clave']) && isset($_POST['rol'])) {

  // Obtenemos los datos del formulario
  $nombre = $_POST['name'];
  $email = $_POST['email'];
  $telefono = $_POST['tel'];
  $clave = mysqli_real_escape_string($conexion, $_POST['clave']);
  $hashedPass = password_hash($clave, PASSWORD_DEFAULT);
  $username = $_POST['mane_user'];
  $rol = $_POST['rol'];

  // Verificamos si se ha enviado el valor de zona
  if (isset($_POST['zona'])) {
    $zona = $_POST['zona'];
  } else {
    $zona = 'N/A'; // O un valor predeterminado si es necesario
  }

  //validar correo
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email'])) {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Ha ocurrido un error al crear el usuario
        $_SESSION['error'] = "Formato de correo electrónico no válido";
        header("Location: ../views/crearUsuario.php");
        exit();
      }
    }
  }

  $userModel = new UserModel();
  if ($userModel->usernameExists($username, $email, $nombre)) {
    // Ha ocurrido un error al crear el usuario
    $_SESSION['error'] = "El usuario ya se encuentra creado";
    header("Location: ../views/crearUsuario.php");
    exit();
  }

  // Creamos el usuario
  $user_id = UserModel::createUser($nombre, $email, $telefono, $hashedPass, $username, $zona, $rol);

  if ($user_id) {
    // El usuario se ha creado correctamente
    $_SESSION['success'] = "Usuario creado correctamente";
    header("Location: ../views/crearUsuario.php");
  } else {
    // Ha ocurrido un error al crear el usuario
    $_SESSION['error'] = "Ha ocurrido un error al crear el usuario";
    header("Location: ../views/crearUsuario.php");
    exit();
  }
} else {
  // Si no se ha enviado el formulario, redirigimos a la página de crear usuario
  header("Location: ../views/crearUsuario.php");
}
