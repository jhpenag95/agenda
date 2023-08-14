<?php
define('BD_HOST', 'localhost');
define('BD_USER', 'root');
define('BD_PASSWORD', '');
define('BD_NAME', 'cableadores');

$conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);
mysqli_query($conexion,"SET SESSION collation_connection ='utf8_unicode_ci'");

if ($conexion ->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $conexion ->connect_errno . ") " . $conexion ->connect_error;
    exit(); // detener el script en caso de falla en la conexión
}
// retornar la conexión para su uso en otras partes del cdigo
return $conexion ;

?>