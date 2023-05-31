<?php
require_once '../conexion.php';

class ordenMolde
{
    // Función para validar si la orden ya existe
    public function ordenExists($nOrden)
    {
        $conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);
        $stmt = $conexion->prepare("SELECT * FROM ordenes WHERE N_orden = ?");
        $stmt->bind_param("s", $nOrden);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Función para crear una orden
    public function createOrden($idUser, $nOrden, $direccion, $descrip, $zona)
    {
        $conexion = mysqli_connect(BD_HOST, BD_USER, BD_PASSWORD, BD_NAME);

        // Comprobamos si se ha podido conectar a la base de datos
        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Obtener todos los usuarios que cumplan con las condiciones
        $query_usuarios = "SELECT u.id_usuario, u.nombre, u.estado, u.id_zona, z.id_zona 
                    FROM usuarios u
                    INNER JOIN zonas z ON u.id_zona = z.id_zona
                    WHERE u.estado = 1 AND u.id_rol = 4 AND u.id_estado = 1 AND z.id_zona = $zona";



        $stmt_usuarios = $conexion->prepare($query_usuarios);
        $stmt_usuarios->execute();
        $resultado_usuarios = $stmt_usuarios->get_result();

        // Seleccionar un usuario al azar de los que cumplan con las condiciones
        $usuarios_disponibles = array();

        while ($usuario = $resultado_usuarios->fetch_assoc()) {
            $usuarios_disponibles[] = $usuario;
        }
        if (count($usuarios_disponibles) == 0) {
            $_SESSION['error'] = "No hay usuarios disponibles para asignar la orden.";
            header("Location: ../views/crearOrden.php");
            exit;
        }

        $usuario_seleccionado = $usuarios_disponibles[array_rand($usuarios_disponibles)];

        // Asignarle la orden al usuario seleccionado
        $query_asignar_orden = "INSERT INTO ordenes (N_orden, direccion, descripcion, id_usuario_cableador, id_usuario_fusionador, id_zona) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_asignar_orden = $conexion->prepare($query_asignar_orden);
        $stmt_asignar_orden->bind_param("sssiii", $nOrden, $direccion, $descrip, $idUser, $usuario_seleccionado['id_usuario'], $zona);

        if ($stmt_asignar_orden->execute()) {
            // Actualizar el estado del usuario
            $estado_asignado = 2;
            $query_actualizar_estado = "UPDATE usuarios SET id_estado = ? WHERE id_usuario = ?";
            $stmt_actualizar_estado = $conexion->prepare($query_actualizar_estado);
            $stmt_actualizar_estado->bind_param("ii", $estado_asignado, $usuario_seleccionado['id_usuario']);
            $stmt_actualizar_estado->execute();

            $_SESSION['success'] = "La orden se ha creado correctamente y se ha asignado al usuario " . $usuario_seleccionado['nombre'] . ".";
            header("Location: ../views/crearOrden.php");
            exit;
        } else {
            $_SESSION['error'] = "Ha ocurrido un error al asignar la orden al usuario.";
            header("Location: ../views/crearOrden.php");
            exit;
        }
    }
}
