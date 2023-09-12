<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
session_start();

if (isset($_SESSION['rol']) && $_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    header(("location: dashboard.php"));
}

if ($_SESSION['rol'] == 4) {
    header(("location: agendaFusionador.php"));
}


include '../conexion.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/iconos/logo.ico" />
    <title>Orden</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/Ordenes/crearOrdenes.css">


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
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->

    <main>
        <a href="#" class="newContrasena getUserData" data-bs-toggle="modal" data-bs-target="#exampleModal" data-rol="<?php echo $_SESSION['idUser']; ?>">
            <i class="bi bi-gear-fill"></i>
        </a>

        <section>
            <form class="formOrden" action="../controller/crear_OrdenC.php" method="post">
                <h1>Crear Orden</h1>
                <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['idUser']; ?>">
                <div class="form-cont">
                    <div class="form-cont__items">
                        <label for="orden">No. de Orden:</label>
                        <input type="text" id="orden" name="orden" placeholder="Ingrese el número de orden" required>
                    </div>
                    <div class="form-cont__items">
                        <label for="direccion">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Ingrese la dirección" required>
                    </div>
                </div>
                <div class="form-cont__items">
                    <label for="descrip">Descripción:</label>
                    <textarea id="descrip" name="descrip" placeholder="Ingrese la descripción" required></textarea>
                </div>
                <div class="contenedor-usuario form-cont__items">
                    <div class="contenedor-zona">
                        <label for="zona" class="label-zona">Zona:</label>
                        <div class="opciones-zona">
                            <?php
                            $query_zona = mysqli_query($conexion, "SELECT * FROM zonas WHERE estado = 1");
                            $result_zona = mysqli_num_rows($query_zona);
                            ?>
                            <select name="zona" id="zona" class="select-zona" required>
                                <option value="" disabled selected>Selecciona una zona</option>
                                <?php
                                if ($result_zona > 0) {
                                    while ($zona = mysqli_fetch_array($query_zona)) {
                                ?>
                                        <option value="<?php echo $zona['id_zona']; ?>"><?php echo $zona['nombre_zona']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button class="button" type="submit">Crear orden</button>
                </div>

                <!--============ Alertas Formulario creación============-->

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
            </form>
        </section>

        <!--Inicio tabla de solicitudes-->
        <section>
            <div class="container my-5 cont-table">

                <h1 class="mb-4">Listado de ordenes creadas</h1>


                <!-- =========== Alertas Ordenes  ===========-->

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

                <!-- =========== Tabla  ===========-->

                <table id="example" class="table is-striped" style="width:100%">
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

                        //consultar ordenes
                        $query = "SELECT ord.id_orden, ord.N_orden, ord.direccion, ord.descripcion, ord.id_usuario_cableador, ord.id_usuario_fusionador, ord.id_zona, ord.fecha_registro, ord.estado_orden, u_cableador.id_usuario, u_cableador.nombre AS nombre_cableador, u_fusionador.id_usuario, u_fusionador.nombre AS nombre_fusionador, z.id_zona, z.nombre_zona
                                        FROM ordenes ord
                                        LEFT JOIN usuarios u_cableador ON u_cableador.id_usuario = ord.id_usuario_cableador
                                        LEFT JOIN usuarios u_fusionador ON u_fusionador.id_usuario = ord.id_usuario_fusionador
                                        LEFT JOIN zonas z ON z.id_zona = ord.id_zona
                                        LEFT JOIN estado_tarea e ON e.id_estado_tarea = u_cableador.id_estado
                                        WHERE ord.estado_orden = 1 AND u_cableador.id_usuario = " . $_SESSION['idUser'] . "
                                        ORDER BY ord.id_orden ASC";

                        $result = mysqli_query($conexion, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_array($result)) { ?>

                                <tr>
                                    <td><?php echo $data['N_orden'] ?></td>
                                    <td><?php echo $data['nombre_cableador'] ?></td>
                                    <td><?php echo $data['nombre_zona'] ?></td>
                                    <td><?php echo $data['nombre_fusionador'] ?></td>
                                    <td><?php echo $data['direccion'] ?></td>
                                    <td><?php echo $data['fecha_registro'] ?></td>
                                    <td><a href="#" class="btn btn-danger" onclick="setOrdenID('<?php echo $data['id_orden']; ?>', '<?php echo $data['N_orden']; ?>')" id="eliminarOrdenesLink" data-bs-toggle="modal" data-bs-target="#eliminarOrdenModal"><i class="bi bi-trash-fill"></i></a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>

                </table>

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
                                <button type="button" class="btn btn-danger" onclick="eliminarOrden()">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- =============Modal configuración password======= -->
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
                                        <input type="password" class="form-control" name="password" id="password">
                                        <div class="invalid-feedback" id="passwordError"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="newPass" class="col-form-label">Nueva contraseña</label>
                                        <input type="password" class="form-control" name="newPass" id="newPass">
                                        <div class="invalid-feedback" id="newPassError"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirmPass" class="col-form-label">Confirmar contraseña</label>
                                        <input type="password" class="form-control" name="confirmPass" id="confirmPass">
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

            </div>
        </section>
        <!--fin tabla de solicitudes-->
    </main>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

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


    <!-- ==========my script====== -->
    <script src="../script/Orden/datatable.js"></script>
    <script src="../script/Orden/eliminarOrden.js"></script>

</body>

</html>