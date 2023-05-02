<?php
//crea o reanuda una sesión existente, lo que permite al servidor almacenar información específica del usuario en la sesión
session_start();
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
  <?php include "../views/styles.php" ?>

</head>

<body>
  <!--Inicio barra de gavegación-->
  <?php include "header.php" ?>
  <!--Fin barra de gavegación-->

  <main>
    <section class="contenerdor">
      <h1>Registro de usuario</h1>
      <form class="contenedor_usuario" method="post">
        <div class="contenerdor_usuario--datos">
          <input class="contenerdor_usuario--datos-input" type="text" placeholder="Ingrese nombre completo">
          <input class="contenerdor_usuario--datos-input" type="number" placeholder="Ingrese teléfono">
        </div>
        <div class="contenerdor_usuario--opciones">

          <div class="contenerdor_usuario--opcionesRol">
            <label for="rol">Rol:</label>
            <div class="opcionesRol">
              <select name="" id="rol" class="opcionesRol-opciones">
                <option value="">Selecicone el Rol</option>
                <option value="">Administrador</option>
                <option value="">Despachador</option>
                <option value="">Cableador</option>
                <option value="">Fusionador</option>
              </select>
            </div>
          </div>
          <div class="contenerdor_usuario--opcionesZona">
            <label for="zona">Zona:</label>
            <div class="opcionesZona">
              <select name="" id="zona" class="opcionesZona-opciones">
                <option value="">Selecicone la zona</option>
                <option value="">Zona 1</option>
                <option value="">Zona 2</option>
                <option value="">Zona 3</option>
              </select>
            </div>
          </div>
        </div>
        <button type="submit" class="contenedor_usuario--btn">Guardar</button>
        </div>
    </section>


  </main>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>