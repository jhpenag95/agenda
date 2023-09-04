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

    <!-- Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Tabla bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bulma.min.css">
    <link href="https://cdn.datatables.net/v/bm/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/datatables.min.css" rel="stylesheet">

    <!-- Libreraias y estilos filtro fecha -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" class="css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css" class="css">


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
                                <strong>xito!</strong> <?php echo $_SESSION['success']; ?>
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
        <section class="sectionTable pt-4 pb-4">
            <!--Inicio tabla de solicitudes-->
            <div class="container">
                <div class="row">
                    <div class="col-md-12 mt5">
                        <h1 class="text-center">Tabla de solicitudes</h1>
                        <hr>
                    </div>
                </div>
                <table border="0" cellspacing="5" cellpadding="5">
                    <tbody>
                        <tr>
                            <td>Minimum date:</td>
                            <td><input type="text" id="min" name="min"></td>
                        </tr>
                        <tr>
                            <td>Maximum date:</td>
                            <td><input type="text" id="max" name="max"></td>
                        </tr>
                    </tbody>
                </table>

                <table id="example" class="table is-striped" style="width:100%">
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

                        $query = "SELECT ord.N_orden, u1.nombre AS nombre_cableador, u2.nombre AS nombre_fusionador, ord.direccion, z.nombre_zona, ord.descripcion, ord.fecha_registro, tt.tiempo_tarea, trd.tiempo
                                            FROM ordenes ord
                                            INNER JOIN usuarios u1 ON u1.id_usuario = ord.id_usuario_cableador
                                            INNER JOIN usuarios u2 ON u2.id_usuario = ord.id_usuario_fusionador 
                                            INNER JOIN zonas z ON z.id_zona = ord.id_zona
                                            INNER JOIN tiempos_tarea tt ON tt.id_orden = ord.id_orden
                                            INNER JOIN tiempos_traslado trd ON trd.id_orden = ord.id_orden
                                            WHERE ord.estado_orden = 3
                                            ORDER BY ord.N_orden";

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
                                    <td><?php echo $data['tiempo']; ?></td>
                                    <td><?php echo $data['tiempo_tarea']; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
        <!--fin tabla de solicitudes-->
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/v/bm/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/datatables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bulma.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script> -->



    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bulma.min.css">
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.js"></script>
    <!-- <script src="../script/dashboard/datatable.js"></script> -->


    <!-- ===============Font Awesome================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- libreraias para busqueda fecha -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>

    <!-- Datepicker -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                },

                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });

            let minDate, maxDate;

            // Custom filtering function which will search data in column four between two values
            DataTable.ext.search.push(function(settings, data, dataIndex) {
                let min = minDate.val();
                let max = maxDate.val();
                let date = new Date(data[7]);

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            });

            // Create date inputs
            minDate = new DateTime('#min', {
                format: 'YYYY MMMM Do'
            });
            maxDate = new DateTime('#max', {
                format: 'YYYY MMMM Do'
            });

            // Refilter the table
            document.querySelectorAll('#min, #max').forEach((el) => {
                el.addEventListener('change', () => table.draw());
            });
        });
    </script>

</body>

</html>