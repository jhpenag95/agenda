<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="../style/recuperar_contraseña/recuperaVista2.css">
    <link rel="stylesheet" href="../style/global.css">

    <!-- Estilos CSS -->
    <?php include "../views/styles.php" ?>
</head>
<body>
    <main>
        <form method="post" action="recuperar_contrasena.php" class="form">
            <h2 class="form-title">Recuperar contraseña</h2>
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>
            <div class="form-group">
                <label for="new_password" class="form-label">Nueva contraseña:</label>
                <input type="password" name="new_password" id="new_password" class="form-input" required>
            </div>
            <div class="form-group">
                <label for="confirm-password" class="form-label">Confirmar nueva contraseña:</label>
                <input type="password" name="confirm-password" id="confirm-password" class="form-input" required>
            </div>
            <button type="submit" class="form-button">Recuperar contraseña</button>
            <a href="../index.php">Iniciar sesión</a>
            <?php
        if (isset($_GET['message'])) {
        ?>
            <!-- Alerta de recuperación de contraseña -->
            <?php
            switch ($_GET['message']) {
                case 'ok':
                    $alert_class = 'alert-success';
                    $message = 'Se se actualizo el correo de manera exitosa.!';
                    break;
                case 'error':
                    $alert_class = 'alert-danger';
                    $message = 'Las contraseñas no son iguales, por favor revise!.';
                    break;
                case 'invalidemail':
                    $alert_class = 'alert-warning';
                    $message = 'Todos los campos son obligatorios!..';
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

        </form>
        
       
    </main>
</body>
</html>
