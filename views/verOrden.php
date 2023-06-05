<?php
// Inicia o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión.
session_start();

if (isset($_SESSION['rol']) && $_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    header(("location: dashboard.php"));
}

if ($_SESSION['rol'] == 4) {
    header(("location: agendaFusionador.php"));
}

// Se incluye el archivo de conexión a la base de datos.
include '../conexion.php';

// Variable para almacenar el valor de búsqueda ingresado por el usuario.
$busqueda = '';

// Verifica si se ha enviado una solicitud de búsqueda vacía y redirige a la página de creación de ordenes.
if (isset($_REQUEST['busqueda']) && $_REQUEST['busqueda'] == '') {
    $_SESSION['noExist'] = "El campo están vacío";
    header("Location: crearOrden.php");
    exit();
} else {

    // Almacena el valor de búsqueda en mayusculas.
    $busqueda = strtoupper($_REQUEST['busqueda']);

    // Crea la cláusula WHERE para la consulta SQL.
    $where = "N_orden = '$busqueda'";

    // Almacena el valor de búsqueda en la variable de sesión 'buscar'.
    $buscar = "busqueda = $busqueda";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden</title>

    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>
    <link rel="stylesheet" href="../style/Ordenes/crearOrdenes.css">
    <link rel="stylesheet" href="../style/global.css">

</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->

    <main>
        <!--Inicio tabla de solicitudes-->
        <section>
            <div class="container my-5">
                <h1 class="mb-4">Listado de ordenes</h1>
                <form action="verOrden.php" class="contBuscar" method="post">
                    <input name="busqueda" id="busqueda" class="contBuscar-input" type="text" placeholder="No. Cotización" value="<?php echo $busqueda; ?>">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </form>
                <!-- Agrega un identificador al botón de "Ocultar" -->
                <a href="../views/crearOrden.php" type="button" class="btn btn-success mt-2">
                    <i class="bi bi-arrow-return-left"></i>
                    Volver
                </a>

                <div class="alertFormBuscar">
                    <?php if (isset($_SESSION['noExist'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> <?php echo $_SESSION['noExist']; ?>
                        </div>
                        <?php unset($_SESSION['noExist']); ?>
                    <?php endif; ?>
                </div>
                <!-- Alertas -->
                <div class="alertFormBuscar">
                    <?php if (isset($_SESSION['no'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> <?php echo $_SESSION['no']; ?>
                        </div>
                        <?php unset($_SESSION['no']); ?>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['noExist'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> <?php echo $_SESSION['noExist']; ?>
                        </div>
                        <?php unset($_SESSION['noExist']); ?>
                    <?php endif; ?>
                </div>

                <div class="alertFormBuscar">
                    <!-- Alertas -->
                    <?php if (isset($_SESSION['okOrden'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>¡Éxito!</strong> <?php echo $_SESSION['okOrden']; ?>
                        </div>
                        <?php unset($_SESSION['okOrden']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['notOrden'])) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Error!</strong> <?php echo $_SESSION['notOrden']; ?>
                        </div>
                        <?php unset($_SESSION['notOrden']); ?>
                    <?php endif; ?>
                    <?php
                    ?>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No. Orden</th>
                                <th>Cableador</th>
                                <th>Zona</th>
                                <th>Fusionador</th>
                                <th>Dirección zona</th>
                                <th>Fecha / Hora solicitud</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            //Se inicia el Paginador
                            $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM ordenes WHERE $where");
                            $result_register = mysqli_fetch_array($sql_register);
                            $total_registro = $result_register['total_registros'];

                            /* Este código implementa la paginación para la lista de usuarios mostrada en la página. */
                            $por_pagina = 5;

                            if (empty($_GET['pagina'])) {
                                $pagina = 1;
                            } else {
                                $pagina = $_GET['pagina'];
                            }

                            $desde = ($pagina - 1) * $por_pagina;
                            $total_paginas = ceil($total_registro / $por_pagina);

                            //consultar ordenes
                            $query = mysqli_query($conexion, "SELECT ord.id_orden, ord.N_orden, ord.direccion, ord.descripcion, ord.id_usuario_cableador, ord.id_usuario_fusionador, ord.id_zona, ord.fecha_registro, ord.estado_orden, u_cableador.id_usuario, u_cableador.nombre AS nombre_cableador, u_fusionador.id_usuario, u_fusionador.nombre AS nombre_fusionador, z.id_zona, z.nombre_zona
                                        FROM ordenes ord
                                        LEFT JOIN usuarios u_cableador ON u_cableador.id_usuario = ord.id_usuario_cableador
                                        LEFT JOIN usuarios u_fusionador ON u_fusionador.id_usuario = ord.id_usuario_fusionador
                                        LEFT JOIN zonas z ON z.id_zona = ord.id_zona
                                        LEFT JOIN estado_tarea e ON e.id_estado_tarea = u_cableador.id_estado
                                        WHERE $where AND ord.estado_orden = 1 AND u_cableador.id_usuario = " . $_SESSION['idUser'] . "
                                        ORDER BY ord.N_orden");


                            mysqli_close($conexion);

                            $result = mysqli_num_rows($query);

                            if ($result > 0) {
                                while ($data = mysqli_fetch_array($query)) { ?>

                                    <tr>
                                        <td><?php echo $data['N_orden'] ?></td>
                                        <td><?php echo $data['nombre_cableador'] ?></td>
                                        <td><?php echo $data['nombre_zona'] ?></td>
                                        <td><?php echo $data['nombre_fusionador'] ?></td>
                                        <td><?php echo $data['direccion'] ?></td>
                                        <td><?php echo $data['fecha_registro'] ?></td>
                                        <td>
                                            <a href="#" class="btn btn-danger" onclick="setUsuarioID('<?php echo $data['id_orden']; ?>', '<?php echo $data['N_orden']; ?>')" id="eliminarOrdenesLink" data-bs-toggle="modal" data-bs-target="#eliminarOrdenModal"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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


                <!--=====================Modal - Eliminar Orden=====================-->
                <div class="modal fade" id="eliminarOrdenModal" tabindex="-1" aria-labelledby="eliminarOrdenModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eliminarOrdenModalLabel">Eliminar Orden</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de que deseas eliminar la siguiente orden?</p>
                                <input type="hidden" id="idOrden" name="idOrden" />

                                <p>Número de Orden: <span id="nombreOrden"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" onclick="eliminarUsuario()">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--fin tabla de solicitudes-->
    </main>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="../script/Orden/eliminarOrden.js"></script>
</body>

</html>