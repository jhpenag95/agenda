<?php
$host = "localhost";
$usuario = "root";
$contrasenia = "";
$base_de_datos = "cableadores";

$conexion  = new mysqli ($host, $usuario, $contrasenia, $base_de_datos);

if ($conexion ->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $conexion ->connect_errno . ") " . $conexion ->connect_error;
    exit(); // detener el script en caso de falla en la conexión
}
// retornar la conexión para su uso en otras partes del código
return $conexion ;
?>
