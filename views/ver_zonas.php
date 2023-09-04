<?php
session_start();


if (isset($_SESSION['rol']) && $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
    header(("location: dashboard.php"));
}

if ($_SESSION['rol'] == 3) {
    header(("location: crearOrden.php"));
}

if ($_SESSION['rol'] == 4) {
    header(("location: agendaFusionador.php"));
}

include '../conexion.php';


// Variable para almacenar el valor de búsqueda ingresado por el usuario.
//busqueda2 orden
$busqueda2 = '';

// Verifica si se ha enviado una solicitud de búsqueda vacía y redirige a la página de creación de ordenes.
if (isset($_REQUEST['busqueda2']) && $_REQUEST['busqueda2'] == '') {
    $_SESSION['noExist'] = "El campo están vacío";
    header("Location: dashboard.php");
    exit();
} else {

    // Almacena el valor de búsqueda en mayusculas.
    $busqueda2 = $_REQUEST['busqueda2'];

    // Crea la cláusula WHERE para la consulta SQL.
    $where2 = "nombre_zona = '$busqueda2'";

    // Almacena el valor de búsqueda en la variable de sesión 'buscar'.
    $buscar2 = "busqueda2 = $busqueda2";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">



</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php"; ?>
    <!--Fin barra de gavegación-->
    <main>

        <section class="container sectionTable pt-4 pb-4">
            <div class="container my-5">
                <h1 class="mb-4">Tabla de solicitudes</h1>
            </div>
            <!--Inicio tabla de solicitudes-->
            <div class="container">
                <div class="contform">
                    <a href="dashboard.php" class="btn btn-success">¿Buscar por No. Orden?</a>
                </div>

                <div class="table-responsive mt-5">
                    <div class="resultadoFiltro">
                        <table id="example" class="table table-striped" style="width:100%">
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
                                $sql_register = mysqli_query($conexion, "SELECT COUNT(*) as total_registros FROM ordenes");
                                $result_register = mysqli_fetch_array($sql_register);
                                $total_registro = $result_register['total_registros'];

                                /* Este código implementa la paginación para la lista de usuarios mostrada en la página. */
                                $por_pagina = isset($_GET['por_pagina']) ? $_GET['por_pagina'] : 100;

                                if (empty($_GET['pagina'])) {
                                    $pagina = 1;
                                } else {
                                    $pagina = $_GET['pagina'];
                                }

                                $desde = ($pagina - 1) * $por_pagina;
                                $total_paginas = ceil($total_registro / $por_pagina);

                                // Valor por defecto si no se selecciona nada.

                                // Luego, en tu consulta SQL, usa $por_pagina para limitar el número de registros a mostrar.
                                $query = "SELECT ord.N_orden, u1.nombre AS nombre_cableador, u2.nombre AS nombre_fusionador, ord.direccion, z.nombre_zona, ord.descripcion, ord.fecha_registro, tt.tiempo_tarea, trd.tiempo
                                                FROM ordenes ord
                                                INNER JOIN usuarios u1 ON u1.id_usuario = ord.id_usuario_cableador
                                                INNER JOIN usuarios u2 ON u2.id_usuario = ord.id_usuario_fusionador 
                                                INNER JOIN zonas z ON z.id_zona = ord.id_zona
                                                INNER JOIN tiempos_tarea tt ON tt.id_orden = ord.id_orden
                                                INNER JOIN tiempos_traslado trd ON trd.id_orden = ord.id_orden
                                                WHERE $where2 AND ord.estado_orden
                                                GROUP BY ord.N_orden
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
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No se encontraron registros.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!--fin tabla de solicitudes-->
    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script src="../script/dashboard/exportarTabla.js"></script>
    <!-- <script src="../script/dashboard/filtrarFecha.js"></script> -->


    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-html5-2.4.2/datatables.min.js"></script>

    <!-- ===============Font Awesome================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        // Inicializa DataTable en tu tabla con el ID 'example'
        $(document).ready(function() {
            $('#example').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                },
                dom: "Blfrtip",
                buttons: [{
                    extend: 'excelHtml5',
                    text: "<i class='fa-regular fa-file-excel'></i>",
                    titleAttr: "Exportar Excel",
                    className: "btn btn-success"
                }],
            });
        });
    </script>

</body>

</html>