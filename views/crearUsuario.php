<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
session_start();

if (isset($_SESSION['rol']) && $_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
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
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Crear usuarios</title>
  <!-- Estilos CSS -->
  <link rel="stylesheet" href="../style/crear_usuario/usuario.css">
  <link rel="stylesheet" href="../style/crear_usuario/validarCampos.css">
  <link rel="stylesheet" href="../style/global.css">
  <!-- Estilos CSS -->
  <?php include "../views/styles.php" ?>

</head>

<body>
  <!--Inicio barra de gavegación-->
  <?php include "header.php"; ?>
  <!--Fin barra de gavegación-->

  <main>
    <section class="contenerdor">
      <div class="conInfouser">
        <h1 class="titulo_user">Registro de usuario</h1>
        <form action="../controller/crear_usuarioC.php" class="contenedor_usuario" method="post" id="formulario">

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
          <div class="contenerdor_usuario--datos">
            <label>
              <em>Nombre:</em>
              <input class="contenerdor_usuario--datos-input" type="text" placeholder="Ingrese nombre completo" name="name" id="name" required>
              <span></span>
            </label>
            <label>
              <em>Correo:</em>
              <input class="contenerdor_usuario--datos-input" type="email" placeholder="Ingrese correo del usuario" name="email" id="email" required>
              <span></span>
            </label>
            <label>
              <em>Teléfono:</em>
              <input class="contenerdor_usuario--datos-input" type="text" placeholder="Ingrese teléfono" name="tel" id="tel" required>
              <span></span>
            </label>

            <label>
              <em>Contraseña:</em>
              <input class="contenerdor_usuario--datos-input inputPassword" type="password" placeholder="Ingrese contraseña" name="clave" id="clave" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
              <span></span>
              <div id="message">
                <h3>La contraseña debe contener lo siguiente:</h3>
                <p id="letter" class="invalid">A <b>Minúsculas</b> Letra</p>
                <p id="capital" class="invalid">A <b>Mayúscula (Mayúscula)</b> Letra</p>
                <p id="number" class="invalid">A <b>Número</b></p>
                <p id="length" class="invalid">Mínimo <b>8 caracteres</b></p>
              </div>
            </label>
            <label>
              <em>Usuario:</em>
              <input class="contenerdor_usuario--datos-input" type="text" placeholder="Ingrese nombre del usuario" name="mane_user" id="mane_user" required>
              <span></span>
            </label>
          </div>
          <div class="contenerdor_usuario--opciones">
            <!--Selecionar zona-->
            <div class="contenerdor_usuario--opcionesZona">
              <?php
              $query_zona = mysqli_query($conexion, "SELECT * FROM zonas");
              $result_zona = mysqli_num_rows($query_zona);
              ?>
              <div class="opcionesZona">
                <label>
                  <em>Zona:</em>
                  <select name="zona" id="zona" class="opcionesZona-opciones">
                    <option value="">Selecicone la zona</option>
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
                  <span></span>
                </label>
              </div>
            </div>
            <!--Selecionar Rol-->
            <div class="contenerdor_usuario--opcionesRol">
              <?php
              $query_rol = mysqli_query($conexion, "SELECT * FROM roles");
              $result_rol = mysqli_num_rows($query_rol);
              mysqli_close($conexion);
              ?>
              <div class="opcionesRol">
                <label>
                  <em>Rol:</em>
                  <select name="rol" id="rol" class="opcionesRol-opciones" required>
                    <option value="">Seleccione el Rol</option>
                    <?php
                    if ($result_rol > 0) {
                      while ($rol = mysqli_fetch_array($query_rol)) {
                    ?>
                        <option value="<?php echo $rol['id_rol']; ?>"><?php echo $rol['nombre_rol']; ?></option>

                    <?php
                      }
                    }
                    ?>
                  </select>
                  <span></span>
                </label>
              </div>
            </div>
          </div>
          <button type="submit" class="contenedor_usuario--btn">Guardar</button>
        </form>
      </div>
    </section>
  </main>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script src="../script/../script/crear_usuario/validarCampos.js"></script>
  <script src="../script/../script/crear_usuario/validarClave.js"></script>

</body>

</html>