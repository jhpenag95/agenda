<?php
session_start();

include '../conexion.php';


if (isset($_SESSION['rol']) && $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
    header("Location: agendaFusionador.php");
    exit();
}

if ($_SESSION['rol'] == 3) {
    header("Location: crearOrden.php");
    exit();
}

if ($_SESSION['rol'] == 4) {
    header("Location: agendaFusionador.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/iconos/logo.ico" />

    <title>Dashboard | Agenda</title>

    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>
    <link rel="stylesheet" href="../style/dashboard/datosDahsboard.css">
    <link rel="stylesheet" href="../style/global.css">

</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php"; ?>
    <!--Fin barra de gavegación-->
    <main>
        <a href="#" class="newContrasena getUserData" data-bs-toggle="modal" data-bs-target="#exampleModal" data-rol="<?php echo $_SESSION['idUser']; ?>">
            <i class="bi bi-gear-fill"></i>
        </a>


        <!-- =============Modal======= -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="exampleModalLabel">Actualizar contraseña</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="span">
                            <label>Nombre:</label>
                            <span><?php echo $_SESSION['nombre']; ?></span>
                            <label>Correo:</label>
                            <span><?php echo $_SESSION['email']; ?></span>
                            <label>Rol:</label>
                            <span><?php echo $_SESSION['rol_name']; ?></span>
                            <label>Usuario:</label>
                            <span><?php echo $_SESSION['user']; ?></span>
                        </div>


                        <form action="updateDatos_password.php" method="post" onsubmit="return validateForm()">
                            <input type="hidden" name="id" value="<?php echo $_SESSION['idUser']; ?>">
                            <div class="mb-3">
                                <label for="password" class="col-form-label">Contraseña actual</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                                <div class="invalid-feedback" id="passwordError"></div>
                            </div>
                            <div class="mb-3">
                                <label for="newPass" class="col-form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" name="newPass" id="newPass" required>
                                <div class="invalid-feedback" id="newPassError"></div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPass" class="col-form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" name="confirmPass" id="confirmPass" required>
                                <div class="invalid-feedback" id="confirmPassError"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>


                        <!-- Alertas -->
                        <?php if (isset($_SESSION['success'])) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>¡Éxito!</strong> <?php echo $_SESSION['success']; ?>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>¡Error!</strong> <?php echo $_SESSION['error']; ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!--Inicio contenedores datos informativos-->
        <section class="info">
            <?php
            if ($conexion->connect_errno) {
                echo "Error al conectar a la base de datos: " . $conexion->connect_error;
            } else {
                $query_dash = $conexion->query("CALL obtener_estadisticas();");

                if ($query_dash) {
                    $result_dash = $query_dash->num_rows;

                    if ($result_dash > 0) {
                        $data_dash = $query_dash->fetch_assoc();
                    }

                    $query_dash->free_result(); // Liberar los resultados de la consulta
                    $conexion->next_result(); // Avanzar al siguiente conjunto de resultados si hubiera alguno
                } else {
                    echo "Error al ejecutar la consulta: " . $conexion->error;
                }
            }
            ?>
            <div class="info-cont">
                <p class="info-cont__title">Cableadores</p>
                <span class="info-cont__cont"><?php echo $data_dash['cableadores']; ?></span>
            </div>
            <div class="info-cont">
                <p class="info-cont__title">Fusionadores</p>
                <span class="info-cont__cont"><?php echo $data_dash['fusionadores']; ?></span>
            </div>
            <div class="info-cont">
                <p class="info-cont__title">Ordenes en tarea</p>
                <span class="info-cont__cont"><?php echo $data_dash['ordenes_en_tarea']; ?></span>
            </div>
            <div class="info-cont">
                <p class="info-cont__title">Ordenes finalizadas</p>
                <span class="info-cont__cont"><?php echo $data_dash['ordenes_finalizadas']; ?></span>
            </div>
        </section>

        <!--fin contenedores datos informativos-->
        <section class="container sectionTable pt-4 pb-4">
            <div class="container my-5">
                <h1 class="mb-4">Tabla de solicitudes</h1>
                <div class="col-md-12 text-center mt-5">
                    <form action="filtroFecha.php" method="post" accept-charset="utf-8">
                        <div class="row">
                            <div class="col">
                                <input type="date" name="fecha_ingreso" class="form-control mb-4" placeholder="Fecha de Inicio" required>
                            </div>
                            <div class="col">
                                <input type="date" name="fecha_Fin" class="form-control mb-4" placeholder="Fecha Final" required>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-dark mb-2" id="filtro">Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--Inicio tabla de solicitudes-->
            <div class="container">
                <div class="contform">
                    <form action="ver_orden.php" method="post" class="contform_form">
                        <input name="busqueda" type="text" class="contform_form--input" placeholder="Buscar orden..">
                        <button type="submit" class="contform_form--search"><i class="bi bi-search"></i></button>
                    </form>
                    <form action="ver_zonas.php" class="contform_form">
                        <input name="busqueda2" type="text" class="contform_form--input" placeholder="Buscar zona..">
                        <button type="submit" class="contform_form--search"><i class="bi bi-search"></i></button>
                    </form>
                </div>

                <div class="table-responsive mt-5">
                    <div class="col-md-4 mb-3 mt-3 d-flex justify-content-start">
                        <button type="button" class="btn btn-success w-50" onclick="exportTable()">
                            Exportar a Excel
                        </button>
                    </div>
                    <div class="col-md-12 text-center mt-5">
                        <span id="loaderFiltro"> </span>
                    </div>
                    <div class="resultadoFiltro">
                        <table class="table table-striped table-hover" id="tabla">
                            <thead>
                                <tr>
                                    <th>No. orden</th>
                                    <th>Cableador</th>
                                    <th>Fusionador</th>
                                    <th>Dirección</th>
                                    <th>Zona</th>
                                    <th>Descripción</th>
                                    <th>Hora de solicitud</th>
                                    <th>Tiempo traslado</th>
                                    <th>Tiempo de tarea</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //Se inicia el Paginador
                                $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros 
                                                                            FROM ordenes");

                                $result_register = mysqli_fetch_array($sql_register);
                                $total_registro = $result_register['total_registros'];
                                mysqli_free_result($sql_register);


                                /* Este código implementa la paginación para la lista de usuarios mostrada en la página.*/
                                $por_pagina = 5;

                                if (empty($_GET['pagina'])) {
                                    $pagina = 1;
                                } else {
                                    $pagina = $_GET['pagina'];
                                }

                                $desde = ($pagina - 1) * $por_pagina;
                                $total_paginas = ceil($total_registro / $por_pagina);

                                $query = "SELECT ord.N_orden, u1.nombre AS nombre_cableador, u2.nombre AS nombre_fusionador, ord.direccion, z.nombre_zona, ord.descripcion, ord.fecha_registro, tt.tiempo_tarea, trd.tiempo
                                            FROM ordenes ord
                                            INNER JOIN usuarios u1 ON u1.id_usuario = ord.id_usuario_cableador
                                            INNER JOIN usuarios u2 ON u2.id_usuario = ord.id_usuario_fusionador 
                                            INNER JOIN zonas z ON z.id_zona = ord.id_zona
                                            INNER JOIN tiempos_tarea tt ON tt.id_orden = ord.id_orden
                                            INNER JOIN tiempos_traslado trd ON trd.id_orden = ord.id_orden
                                            ORDER BY ord.N_orden ASC
                                        LIMIT $desde, $por_pagina";

                                $result = mysqli_query($conexion, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($data = mysqli_fetch_array($result)) {
                                ?>
                                        <tr>
                                            <td><?php echo $data['N_orden']; ?></td>
                                            <td><?php echo $data['nombre_cableador']; ?></td>
                                            <td><?php echo $data['nombre_fusionador']; ?></td>
                                            <td><?php echo $data['direccion']; ?></td>
                                            <td><?php echo $data['nombre_zona']; ?></td>
                                            <td><?php echo $data['descripcion']; ?></td>
                                            <td><?php echo $data['fecha_registro']; ?></td>
                                            <td><?php echo $data['tiempo_tarea']; ?></td>
                                            <td><?php echo $data['tiempo']; ?></td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <!--===============Páginador==============-->
            <div class="pagination-container">
                <ul class="pagination">
                    <li class="pagination-item <?php if ($pagina <= 1) {
                                                    echo 'disabled';
                                                } ?>">
                        <a href="<?php if ($pagina <= 1) {
                                        echo '#';
                                    } else {
                                        echo '?pagina=' . ($pagina - 1);
                                    } ?>">Anterior</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_paginas; $i++) { ?>
                        <li class="pagination-item <?php if ($pagina == $i) {
                                                        echo 'active';
                                                    } ?>">
                            <a href="<?php echo '?pagina=' . $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <li class="pagination-item <?php if ($pagina >= $total_paginas) {
                                                    echo 'disabled';
                                                } ?>">
                        <a href="<?php if ($pagina >= $total_paginas) {
                                        echo '#';
                                    } else {
                                        echo '?pagina=' . ($pagina + 1);
                                    } ?>">Siguiente</a>
                    </li>
                </ul>
            </div>
        </section>
        <!--fin tabla de solicitudes-->
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script src="../script/dashboard/exportarTabla.js"></script>
    <script src="../script/dashboard/validacionFormCambiarPass.js"></script>

</body>

</html>