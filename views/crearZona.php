<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
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

require '../conexion.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/iconos/logo.ico" />
    <title>Crear | Zona</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="../style/zona/crearZona.css">
    <link rel="stylesheet" href="../style/global.css">
    <?php include "../views/styles.php" ?>

</head>

<body>
    <!--Inicio barra de gavegación-->
    <?php include "header.php" ?>
    <!--Fin barra de gavegación-->
    <main>
        <h1>Formulario de Zonas</h1>
        <form action="../controller/crear_ZonaC.php" method="post">
            <label for="zona">Nombre de la zona:</label>
            <input type="text" id="zona" name="zona" required>
            <button type="submit">Crear</button>
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
        </form>
    </main>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>