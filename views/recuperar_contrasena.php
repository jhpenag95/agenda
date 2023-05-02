<?php
  require_once('../conexion.php');

  $id = $_POST['id_usuario'];
  $new_password = $_POST['new_password'];
  
  $query = "UPDATE usuarios set clave = '$new_password' WHERE id_usuario = $id";
  $result = $conexion->query($query);
  $row = $result->fetch_assoc();  
?>