<?php

require_once '../conexion.php';

class createZona
{
    // Función para valir si zona existe

    public function zonaExists($zona)
    {
        $conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);
        $stmt = $conexion->prepare("SELECT * FROM zonas WHERE nombre_zona = ?");
        $stmt->bind_param("s", $zona);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public static  function crearZona($zona)
    {
        // Conexión a la base de datos
        $conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);

        // Comprobamos si se ha podido conectar a la base de datos
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Preparamos la consulta para insertar el usuario en la tabla "usuarios"
        $query = "INSERT INTO zonas (nombre_zona) VALUES ('$zona')";

        // Ejecutamos la consulta
        $result = mysqli_query($conexion, $query);

        // Comprobamos si la consulta se ha ejecutado correctamente
        if ($result) {
            $zona_id = mysqli_insert_id($conexion);
            mysqli_close($conexion);
            return $zona_id;
        } else {
            mysqli_close($conexion);
            return false;
        }
    }
}
