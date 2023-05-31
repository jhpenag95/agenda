<?php
$alert = ''; // define la variable $alert
session_start();

if (!empty($_SESSION['active'])) {
    header('location: views/dashboard.php'); // Redirige al dashboard si ya hay una sesión activa
} else {
    if (!empty($_POST)) { // Verifica si se recibieron datos del formulario
        // empty define si los campos están vacíos, si están vacíos, genera una alerta
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = 'Ingrese su usuario y su clave'; // Alerta de campos vacíos
        } else {
            require_once "conexion.php"; // Incluye el archivo de conexión a la base de datos

            $user = mysqli_real_escape_string($conexion, $_POST['usuario']); // Escapa y asigna el valor del campo usuario a la variable $user
            $pass = md5(mysqli_real_escape_string($conexion, $_POST['clave'])); // Escapa y asigna el valor del campo clave a la variable $pass, aplicando el hash MD5

            $query = mysqli_query($conexion, "SELECT u.id_usuario,u.nombre,u.correo,u.nombre_usuario,r.id_rol ,r.nombre_rol
                                                    FROM usuarios u 
                                                    INNER JOIN roles r
                                                    ON u.id_rol = r.id_rol
                                                    WHERE u.nombre_usuario = '$user'  AND u.clave = '$pass'"); // Realiza la consulta SQL para buscar al usuario en la base de datos
            mysqli_close($conexion); // Cierra la conexión a la base de datos

            $result = mysqli_num_rows($query); // Obtiene el número de filas resultantes de la consulta
            if ($result > 0) {
                $data = mysqli_fetch_array($query); // Obtiene los datos del usuario encontrado

                // Almacena los datos del usuario en variables de sesión
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $data['id_usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['email'] = $data['correo'];
                $_SESSION['user'] = $data['nombre_usuario'];
                $_SESSION['rol'] = $data['id_rol'];
                $_SESSION['rol_name'] = $data['nombre_rol'];

                header('location: views/dashboard.php'); // Redirige al dashboard si el inicio de sesión es exitoso
            } else {
                $alert = 'El usuario con clave son incorrectas'; // Alerta de usuario o clave incorrectos
                session_destroy(); // Destruye la sesión
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
                    <div class="alert alert-danger" role="alert">
                        <?php echo $alert; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Botón para enviar el formulario -->
            <button type="submit" class="submit-btn">Iniciar sesión</button>
        </form>
    </div>
</body>

</html>