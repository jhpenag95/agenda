<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurar | Contraseña</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="style/recuperar_contraseña/recuperarContrasena.css">
    <?php include "views/styles.php" ?>

</head>

<body>
    <main>
        <form method="post" action="views/recovery.php" class="form">
            <h2 class="form-title">Recuperar contraseña</h2>
            <div class="form-group">
                <label for="email" class="form-label">Ingresa tu dirección de correo electrónico:</label>
                <input type="email" name="email" id="email" class="form-input" required>
            </div>
            <button type="submit" class="form-button">Recuperar contraseña</button>
            <a href="index.php">Iniciar sesión</a>
        </form>

        <?php
        if (isset($_GET['message'])) {
        ?>
            <!-- Alerta de recuperación de contraseña -->
            <?php
            switch ($_GET['message']) {
                case 'ok':
                    $alert_class = 'alert-success';
                    $message = 'Se ha enviado correo, por favor revisa tu correo!';
                    break;
                case 'error':
                    $alert_class = 'alert-danger';
                    $message = 'Algo salió mal, por favor intenta de nuevo.';
                    break;
                case 'invalidemail':
                    $alert_class = 'alert-warning';
                    $message = 'El correo que ingresaste no existe!';
                    break;
                default:
                    $alert_class = '';
                    $message = '';
                    break;
            }
            ?>
            <?php if ($alert_class !== '') { ?>
                <div class="alert <?php echo $alert_class; ?>" role="alert">
                    <?php echo $message; ?>
                </div>
            <?php } ?>
        <?php
        }
        ?>


    </main>
</body>

</html>