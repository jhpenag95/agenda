<?php
$alert = ''; // define la variable $alert
session_start();

if (!empty($_SESSION['active'])) {
    header('location: views/dashboard.php');
} else {
    if (!empty($_POST)) {
        // empty  define si los campos estan vacios si están vaciosn genera alerta
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = 'Ingrese su usuario y su clave';
        } else {
            require_once "conexion.php";

            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $pass = md5(mysqli_real_escape_string($conexion, $_POST['clave']));

            $query = mysqli_query($conexion, "SELECT u.id_usuario,u.nombre,u.correo,u.nombre_usuario,r.id_rol ,r.nombre_rol
                                                    FROM usuarios u 
                                                    INNER JOIN roles r
                                                    ON u.id_rol = r.id_rol
                                                    WHERE u.nombre_usuario = '$user'  AND u.clave = '$pass'");
            mysqli_close($conexion);

            $result = mysqli_num_rows($query);
            if ($result > 0) {
                $data = mysqli_fetch_array($query);


                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $data['id_usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['email'] = $data['correo'];
                $_SESSION['user'] = $data['nombre_usuario'];
                $_SESSION['rol'] = $data['id_rol'];
                $_SESSION['rol_name'] = $data['nombre_rol'];

                header('location: views/dashboard.php');
            } else {
                $alert = 'El usuario con clave son incorrectas';
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
    <title>login | Agenda</title>
    <link rel="stylesheet" href="style/login/login.css">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-header">
            <h2>Ingresar</h2>
            <p>Ingresa tus datos para acceder a la agenda</p>
        </div>
        <form action="" method="post">
            <div class="input-group">
                <label for="email"><i class="fas fa-envelope"></i></label>
                <input type="text" id="usuario" name="usuario" placeholder="usuario" required>
            </div>
            <div class="input-group">
                <label for="password"><i class="fas fa-lock"></i></label>
                <input type="password" id="clave" name="clave" placeholder="Contraseña" required>
            </div>
            <div class="forgot-password">
                <a href="restablecer.php">¿Olvidaste tu contraseña?</a>
            </div>


            <!-- muestra el mensaje de alerta, incluso si está vacío -->
            <div class="col-12">
                <?php if ($alert) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $alert; ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="submit-btn">Iniciar sesión</button>
        </form>
    </div>
</body>

</html>