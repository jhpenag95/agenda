<!-- Estilos CSS --> <?php include "styles.php"; ?>
<link rel="stylesheet" href="../style/navegacion/nav.css"> <!-- Menú -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid"> <a class="navbar-brand" href="dashboard"> <img src="../assets/images/LogoAzulMetal 1.png" alt="" class="logo" width="200px" /> </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon" style="filter: invert(100%)"></span> </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="row w-100">
        <div class="col-lg-6">
          <ul class="navbar-nav">
            <?php
            if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
            ?>
              <li class="nav-item"> <a class="nav-link active" href="dashboard">Inicio</a> </li>
            <?php } ?>

            <?php
            if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
            ?>
              <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Usuario</a>
                <ul class="dropdown-menu">
                  <li> <a class="dropdown-item" href="crearUsuario">Crear usuarios</a> </li>
                  <li> <a class="dropdown-item" href="listadeUsuarios">Lista de usuarios</a> </li>
                </ul>
              </li>
            <?php } ?>

            <?php
            if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 3) {
            ?>
              <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Orden</a>
                <ul class="dropdown-menu">
                  <li> <a class="dropdown-item" href="crearOrden">Crear orden</a> </li>
                </ul>
              </li>
            <?php } ?>

            <?php
            if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
            ?>
              <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Zona</a>
                <ul class="dropdown-menu">
                  <li> <a class="dropdown-item" href="crearZona">Crear zonas</a> </li>
                  <li> <a class="dropdown-item" href="lista_zonas">Lista de zonas</a> </li>
                </ul>
              </li>
            <?php } ?>

            <?php
            if ($_SESSION['rol'] == 4) {
            ?>
              <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Ordenes Fusionador</a>
                <ul class="dropdown-menu">
                  <li> <a class="dropdown-item" href="agendaFusionador">Lista de ordenes asignadas</a> </li>
                </ul>
              </li>
            <?php } ?>

            <?php
            if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
            ?>
              <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Ordenes</a>
                <ul class="dropdown-menu">
                  <li> <a class="dropdown-item" href="ordenesActivas">Ordenes activas</a></li>
                  <li> <a class="dropdown-item" href="ordenesenProceso">Ordenes en proceso</a></li>
                </ul>
              </li>
            <?php } ?>
          </ul>
        </div>
        <div class="col-lg-6">
          <ul class="navbar-nav d-flex justify-content-end">
            <div class="cont-info">
              <li class="nav-item"> <span><?php echo $_SESSION['nombre']; ?></span> </li>
              <li class="nav-item"> <a class="nav-link" href="cerrar_sesion"><i class="bi bi-arrow-left-square"></i></a> </li>
            </div>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav> <!--Fin barra de gavegación-->