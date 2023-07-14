<?php
$alert = '';
session_start();

if (!empty($_SESSION['active'])) {
    header('location: views/dashboard');
} else {
    if (!empty($_POST)) {
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = 'Ingrese su usuario y su clave';
        } else {
            require_once "conexion.php";

            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $pass = $_POST['clave'];

            $query = mysqli_query($conexion, "SELECT u.id_usuario,u.nombre,u.correo,u.nombre_usuario,u.clave,r.id_rol ,r.nombre_rol
                                                    FROM usuarios u 
                                                    INNER JOIN roles r
                                                    ON u.id_rol = r.id_rol
                                                    WHERE u.nombre_usuario = '$user'");
            //mysqli_close($conexion);

            $result = mysqli_num_rows($query);

            if ($result > 0) {
                $data = mysqli_fetch_array($query);
                $hashedPass = $data['clave'];


                if (password_verify($pass, $hashedPass)) {
                    $_SESSION['active'] = true;
                    $_SESSION['idUser'] = $data['id_usuario'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $_SESSION['email'] = $data['correo'];
                    $_SESSION['user'] = $data['nombre_usuario'];
                    $_SESSION['rol'] = $data['id_rol'];
                    $_SESSION['rol_name'] = $data['nombre_rol'];

                    header('location: views/dashboard');
                } else {
                    $alert = 'El usuario o la contraseña son incorrectos';
                    session_destroy();
                }
            } else {
                $alert = 'El usuario o la contraseña son incorrectos';
                session_destroy();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/iconos/logo.ico" />
    <title>login | Agenda</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="style/login/login.css">
    <link rel="stylesheet" href="style/global.css">

</head>

<body>
    <div class="login-wrapper">
        <div class="login-header">
            <h2>Ingresar</h2>
            <p>Ingresa tus datos para acceder a la agenda</p>
        </div>
        <!-- Formulario para el inicio de sesión -->
        <form action="" method="post">
            <!-- Input para el nombre de usuario -->
            <div class="input-group">
                <label for="email"><i class="fas fa-envelope"></i></label>
                <input type="text" id="usuario" name="usuario" placeholder="usuario" required>
            </div>
            <!-- Input para la contraseña -->
            <div class="input-group">
                <label for="password"><i class="fas fa-lock"></i></label>
                <input type="password" id="clave" name="clave" placeholder="Contraseña" required>
            </div>
            <!-- Enlace para restablecer la contraseña -->
            <div class="forgot-password">
                <a href="restablecer.php">¿Olvidaste tu contraseña?</a>
            </div>
            <!-- Muestra el mensaje de alerta si no se han llenado los campos -->
            <div class="col-12">
                <?php if ($alert) : ?>
                    <div id="alertMessage" class="alert alert-danger" role="alert">
                        <?php echo $alert; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Botón para enviar el formulario -->
            <button type="submit" class="submit-btn">Iniciar sesión</button>
        </form>
        <?php
        if (isset($_GET['message'])) {
            // Alerta de recuperación de contraseña
            switch ($_GET['message']) {
                case 'ok':
                    $alert_class = 'alert-success';
                    $message = 'Se se actualizó la contraseña de manera exitosa.';
                    break;
                case 'error':
                    $alert_class = 'alert-danger';
                    $message = 'Las contraseñas no son iguales, por favor revise.';
                    break;
                case 'invalidemail':
                    $alert_class = 'alert-warning';
                    $message = 'Todos los campos son obligatorios.';
                    break;
                default:
                    $alert_class = '';
                    $message = '';
                    break;
            }
            if ($alert_class !== '') {
        ?>
                <div id="message" class="alert <?php echo $alert_class; ?>" role="alert">
                    <?php echo $message; ?>
                </div>
        <?php
            }
        }
        ?>
    </div>

    <script src="script/login-alert/alertLogin.js"></script>
</body>

</html>