<?php
define('BD_HOST', 'srv820.hstgr.io');
define('BD_USER', 'u798029657_agenda');
define('BD_PASSWORD', 'Colvatel$2023*');
define('BD_NAME', 'u798029657_agenda');

$conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);
mysqli_query($conexion,"SET SESSION collation_connection ='utf8_unicode_ci'");

if ($conexion ->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $conexion ->connect_errno . ") " . $conexion ->connect_error;
    exit(); // detener el script en caso de falla en la conexión
}
// retornar la conexión para su uso en otras partes del código
return $conexion ;

?>