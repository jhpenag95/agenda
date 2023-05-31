<?php
session_start(); // Iniciar sesión de PHP

include_once '../conexion.php'; // Incluir el archivo de conexión a la base de datos

$idzona = base64_decode($_REQUEST['id']); // Decodificar y obtener el ID del usuario

// Consulta SQL para obtener los datos del usuario con el ID especificado
$query = "SELECT * FROM zonas WHERE id_zona = ? AND estado = 1";

$stmt = $conexion->prepare($query); // Preparar la consulta SQL
$stmt->bind_param("i", $idzona); // Asociar el ID de la zona como parámetro a la consulta preparada
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
                    <div class="col-12 ">
                        <h1 class="titulo_user">Editar usuario</h1>
                        <?php while ($datos = $resultado->fetch_object()) { ?>
                            <form action="../controller/editar_ZonasC.php" method="post" id="formulario">
                                <input type="hidden" name="id" value="<?= $datos->id_zona; ?>">
                                <div class="container">
                                    <div class="row g-6 d-flex justify-content-cente align-items-center flex-column">
                                        <div class="col-md-6">
                                            <label>
                                                <em>Nombre:</em>
                                                <input class="form-control" type="text" placeholder="Ingrese nombre completo" name="name" id="name" value="<?= $datos->nombre_zona; ?>" required>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="contenedor_usuario--btn">Actualizar</button>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <a class="btn btn-warning" href="../views/lista_zonas.php" role="button">Volver</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
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