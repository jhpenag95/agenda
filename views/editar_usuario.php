<!-- Inicio del script PHP -->
<?php
session_start(); // Iniciar sesión de PHP

include_once '../conexion.php'; // Incluir el archivo de conexión a la base de datos

$iduser = base64_decode($_REQUEST['id']); // Decodificar y obtener el ID del usuario


// Consulta SQL para obtener los datos del usuario
$query = "SELECT u.id_usuario, u.nombre, u.correo, u.telefono, u.nombre_usuario, u.estado, u.id_rol, r.id_rol,
                 r.nombre_rol, u.id_zona,  z.id_zona, z.nombre_zona, u.id_estado, et.id_estado_tarea, et.Nombre_estado
                FROM usuarios u 
                INNER JOIN roles r ON u.id_rol = r.id_rol 
                INNER JOIN zonas z ON u.id_zona = z.id_zona
                INNER JOIN estado_tarea et ON u.id_estado = et.id_estado_tarea
                WHERE u.id_usuario = ? AND u.estado = 1";

$stmt = $conexion->prepare($query); // Preparar la consulta SQL
$stmt->bind_param("i", $iduser); // Asociar el ID del usuario como parámetro a la consulta preparada
$stmt->execute(); // Ejecutar la consulta
$resultado = $stmt->get_result(); // Obtener el resultado de la consulta
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Editar usuarios</title>
    
    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>
    <link rel="stylesheet" href="../style/editar_usuario/editar_usuario.css">
    <link rel="stylesheet" href="../style/editar_usuario/validarCampos.css">
    <link rel="stylesheet" href="../style/global.css">


</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php"; ?>
    <!--Fin barra de gavegación-->

    <main>
        <div class="d-flex justify-content-center align-items-center vh-100">

            <section class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="titulo_user">Editar usuario</h1>
                        <?php

                        while ($datos = $resultado->fetch_object()) { ?>
                            <form action="../controller/editar_usuarioC.php" method="post" id="formulario">
                                <input type="hidden" name="id" value="<?= $datos->id_usuario; ?>">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label>
                                            <em>Nombre:</em>
                                            <input class="form-control" type="text" placeholder="Ingrese nombre completo" name="name" id="name" value="<?= $datos->nombre; ?>" required>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            <em>Correo :</em>
                                            <input class="form-control" type="email" placeholder="Ingrese correo del usuario" name="email" id="email" value="<?= $datos->correo; ?>">
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            <em>Teléfono :</em>
                                            <input class="form-control" type="text" placeholder="Ingrese teléfono" name="tel" id="tel" value="<?= $datos->telefono; ?>" required>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            <em>Usuario:</em>
                                            <input class="form-control" type="text" placeholder="Ingrese nombre del usuario" name="mane_user" id="mane_user" value="<?= $datos->nombre_usuario; ?>" required>
                                            <div class="text-danger small">¡Importante! Si se modifica el usuario, se debe ingresar al sistema con este usuario.</div>
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <!-- ====================Selecionar Zona y Selecionar Rol==================== -->

                                <div class="row g-3 mb-2">
                                    <div class="col-md-6">
                                        <label>
                                            <em>Zona:</em>
                                            <select name="id_zona" id="id_zona" class="form-select">
                                                <option value="">Seleccione la zona</option>
                                                <?php
                                                $zonasQuery = mysqli_query($conexion, "SELECT id_zona, nombre_zona FROM zonas");
                                                while ($zona = mysqli_fetch_assoc($zonasQuery)) {
                                                    $id_zona = $zona['id_zona'];
                                                    $nombre_zona = $zona['nombre_zona'];
                                                    $selected = ($id_zona == $datos->id_zona) ? "selected" : "";
                                                    echo "<option value=\"$id_zona\" $selected>$nombre_zona</option>";
                                                }
                                                ?>
                                            </select>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            <em>Rol:</em>
                                            <select name="id_rol" id="id_rol" class="form-select" required>
                                                <option value="">Seleccione el Rol</option>
                                                <?php
                                                $rolesQuery = mysqli_query($conexion, "SELECT id_rol, nombre_rol FROM roles");
                                                while ($rol = mysqli_fetch_assoc($rolesQuery)) {
                                                    $id_rol = $rol['id_rol'];
                                                    $nombre_rol = $rol['nombre_rol'];
                                                    $selected = ($id_rol == $datos->id_rol) ? "selected" : "";
                                                    echo "<option value=\"$id_rol\" $selected>$nombre_rol</option>";
                                                }
                                                ?>
                                            </select>
                                            <span></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label>
                                            <em>Estado:</em>
                                            <select name="id_estado" id="id_estado" class="form-select" required>
                                                <option value="">Seleccione el estado</option>
                                                <?php
                                                $estadosQuery = mysqli_query($conexion, "SELECT id_estado_tarea, Nombre_estado FROM estado_tarea");
                                                while ($estado = mysqli_fetch_assoc($estadosQuery)) {
                                                    $id_estado = $estado['id_estado_tarea'];
                                                    $nombre_estado = $estado['Nombre_estado'];
                                                    $selected = ($id_estado == $datos->id_estado) ? "selected" : ""; // Verifica si el estado coincide con el estado actual del usuario
                                                    echo "<option value=\"$id_estado\" $selected>$nombre_estado</option>";
                                                }
                                                ?>
                                            </select>
                                            <span></span>
                                        </label>
                                    </div>

                                </div>
                                <div class="row g-3">
                                    <div class="col-md-12 text-center"> <!-- Agrega la clase text-center para centrar el botón -->
                                        <button type="submit" class="contenedor_usuario--btn">Actualizar</button>
                                    </div>
                                    <div class="col-md-12 text-center"> <!-- Agrega la clase text-center para centrar el botón -->
                                        <a class="btn btn-warning" href="../views/listadeUsuarios.php" role="button">Volver</a>
                                    </div>
                                </div>

                            </form>
                        <?php }
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="../script/editar_usuario/validarCampos.js"></script>

</body>

</html>