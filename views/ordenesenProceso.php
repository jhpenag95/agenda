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
    <link rel="stylesheet" href="../style/global.css">

    <!-- Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Tabla bulma -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bulma.min.css">
    <link href="https://cdn.datatables.net/v/bm/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/datatables.min.css" rel="stylesheet">

    <!-- Libreraias y estilos filtro fecha -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" class="css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css" class="css">

    <!-- Responsive table-->
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- ===============Font Awesome================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php"; ?>
    <!--Fin barra de gavegación-->
    <main>
        <!--fin contenedores datos informativos-->
        <section class="container sectionTable pt-4 pb-4">
            <div class="container my-5">
                <h1 class="mb-4">Ordenes en proceso</h1>
            </div>
            <!--Inicio tabla de solicitudes-->
            <div class="container">
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
                            <th>Tiempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $query = "SELECT ord.id_orden, ord.N_orden, u1.nombre AS nombre_cableador, u2.nombre AS nombre_fusionador, ord.direccion, z.nombre_zona, ord.descripcion, ord.fecha_registro, ord.tiempo_transcurrido_proce
                                FROM ordenes ord
                                INNER JOIN usuarios u1 ON u1.id_usuario = ord.id_usuario_cableador
                                INNER JOIN usuarios u2 ON u2.id_usuario = ord.id_usuario_fusionador 
                                INNER JOIN zonas z ON z.id_zona = ord.id_zona
                                WHERE ord.estado_orden = 2
                                ORDER BY ord.N_orden ASC";

                        $result = mysqli_query($conexion, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_array($result)) {
                                // Obtén la hora de inicio de la orden desde la base de datos (como una cadena de tiempo)
                                $horaInicio = $data['tiempo_transcurrido_proce'];

                                // Calcular las horas, minutos y segundos transcurridos
                                $horaActual = date('H:i:s'); // Obtener la hora actual
                                $diferencia = strtotime($horaActual) - strtotime($horaInicio);

                                $horas = floor($diferencia / 3600);
                                $minutos = floor(($diferencia % 3600) / 60);
                                $segundos = $diferencia % 60;
                        ?>
                                <tr>
                                    <td><?php echo $data['N_orden']; ?></td>
                                    <td><?php echo $data['nombre_cableador']; ?></td>
                                    <td><?php echo $data['nombre_fusionador']; ?></td>
                                    <td><?php echo $data['direccion']; ?></td>
                                    <td><?php echo $data['nombre_zona']; ?></td>
                                    <td><?php echo $data['descripcion']; ?></td>
                                    <td><?php echo $data['fecha_registro']; ?></td>
                                    <td>
                                        <span class="cronometro" data-inicio="<?php echo $horaInicio; ?>"></span>
                                    </td>
                                </tr>
                        <?php
                            }
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- datatable bulma -->
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bulma.min.js"></script>

    <!-- libreraias para busqueda fecha -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>

    <!-- Responsive table-->
    <script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


    <!-- ==========my script=========== -->
    <script src="../script/ordenenProceso/datatable.js"></script>
    <script src="../script/ordenenProceso/reload.js"></script>
    <script src="../script/ordenenProceso/cronometro.js"></script>

</body>

</html>