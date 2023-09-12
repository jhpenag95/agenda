<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
session_start();
if (isset($_SESSION['rol']) && $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
    header(("location: agendaFusionador.php"));
}

require_once  '../conexion.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/iconos/logo.ico" />
    <title>Lista | usuarios</title>
    <!-- Estilos CSS -->
    <?php include "../views/styles.php"; ?>
    <link rel="stylesheet" href="../style/lista_usuarios/estados.css">
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
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->

    <main>
        <!--Inicio tabla de solicitudes-->
        <section class="container sectionTable pt-4 pb-4">
            <div class="container my-5">
                <h1 class="mb-4">Listado de usuarios</h1>
                <table id="example" class="table is-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Teléfono</th>
                            <th>Zona</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $query = "SELECT u.id_usuario, u.nombre, u.correo, u.telefono, u.nombre_usuario, u.estado, r.nombre_rol, z.nombre_zona, e.Nombre_estado FROM usuarios u
                                                    LEFT JOIN roles r ON r.id_rol  = u.id_rol
                                                    LEFT JOIN zonas z ON z.id_zona = u.id_zona
                                                    LEFT JOIN estado_tarea e ON e.id_estado_tarea = u.id_estado 
                                                    WHERE u.estado = 1 ORDER BY u.nombre ASC";

                        $result = mysqli_query($conexion, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_array($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $data['nombre']; ?></td>
                                    <td><?php echo $data['nombre_usuario']; ?></td>
                                    <td><?php echo $data['nombre_rol']; ?></td>
                                    <td><?php echo $data['telefono']; ?></td>
                                    <td><?php echo $data['nombre_zona']; ?></td>
                                    <td class="<?php echo $data['Nombre_estado'] == 'En tarea' ? 'en-tarea' : ($data['Nombre_estado'] == 'Disponible' ? 'disponible' : 'no-disponible'); ?>">
                                        <span class="estado <?php echo $data['Nombre_estado'] == 'En tarea' ? 'en-tarea' : ($data['Nombre_estado'] == 'Disponible' ? 'disponible' : 'no-disponible'); ?>"></span>
                                    </td>
                                    <td>
                                        <a href="editar_usuario?id=<?php echo base64_encode($data['id_usuario']); ?>" class="btn btn-success btn-editar"><i class="bi bi-pencil-square"></i></a>

                                        <?php
                                        if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) {
                                        ?>
                                            <a href="#" class="btn btn-danger" onclick="setUsuarioID('<?php echo base64_encode($data['id_usuario']); ?>', '<?php echo $data['nombre']; ?>')" id="eliminarUsuarioLink" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal"><i class="bi bi-trash-fill"></i></a>
                                        <?php
                                        }
                                        ?>

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
        <!--=====================fin tabla de solicitudes=====================-->

        <!--=====================Modal - Eliminar usuario=====================-->
        <div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarUsuarioModalLabel">Eliminar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                        <input type="hidden" id="idUsuario" />
                        <p>Nombre usuario: <span id="nombreUsuario"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="eliminarUsuario()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>


        <!--=============================== 
                Alertas
        =============================== -->

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
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

                    <?php if (isset($_SESSION['falta'])) : ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>¡Disculpa!</strong> <?php echo $_SESSION['falta']; ?>
                        </div>
                        <?php unset($_SESSION['falta']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

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



    <!-- ==============my script============= -->
    <script src="../script/listaDeUsuarios/listaDeUsuarios.js"></script>
    <script src="../script/eliminar_Usuario.js/eliminarUsuario.js"></script>
</body>

</html>