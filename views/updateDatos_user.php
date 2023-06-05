<?php
session_start();
include '../conexion.php';


$infoUser = "SELECT u.id_usuario, u.nombre, u.nombre_usuario, u.telefono, u.id_rol, r.nombre_rol, u.id_zona, z.nombre_zona
                                        FROM usuarios u
                                        INNER JOIN roles r ON r.id_rol = u.id_rol
                                        INNER JOIN zonas z ON z.id_zona = u.id_zona
                                        WHERE u.id_usuario = ?";
$stmt = $conexion->prepare($infoUser); // Preparar la consulta SQL
$stmt->bind_param("i", $_SESSION['rol']); // Asociar el ID del usuario como parámetro a la consulta preparada
$stmt->execute(); // Ejecutar la consulta
$resultado = $stmt->get_result(); // Obtener el resultado de la consulta



?> 
 
 <!-- =================Modal actualizar datos usuario============== -->

 <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h2 class="modal-title" id="exampleModalLabel">Modificar contraseña</h2>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <div class="modal-body">
                 <?php

                    if ($resultado->num_rows > 0) {
                        $datos = $resultado->fetch_object();
                    ?>
                     <h4>Información personal</h4>
                     <input type="hidden" name="id" value="<? echo $resultado['id_usuario']; ?>">
                     <div>
                         <label class="w-100 mb-3">
                             <p class="fs-5 mb-0">Nombre:</p>
                             <span><?= $datos->nombre; ?></span>
                         </label>
                     </div>
                     <div>
                         <label class="w-100 mb-3">
                             <p class="fs-5 mb-0">Teléfono:</p>
                             <span><?= $datos->telefono; ?></span>
                         </label>
                     </div>
                     <div>
                         <label class="w-100 mb-3">
                             <p class="fs-5 mb-0">Usuario:</p>
                             <span><?= $datos->nombre_usuario; ?></span>
                         </label>
                     </div>
                     <div>
                         <label class="w-100 mb-3">
                             <p class="fs-5 mb-0">Rol:</p>
                             <span><?= $datos->nombre_rol; ?></span>
                         </label>
                     </div>
                 <?php } else {
                        echo "No se encontró información del usuario.";
                    }
                    $stmt->close(); // Cerrar la consulta preparada
                    ?>

                 <form action="#" method="post">
                     <div class="mb-3">
                         <label for="recipient-name" class="col-form-label">Contraseña actual:</label>
                         <input type="password" class="form-control" name="PassUser" id="recipient-name" placeholder="Contraseña actual" required>
                     </div>
                     <div class="mb-3">
                         <label for="recipient-name" class="col-form-label">Contraseña nueva:</label>
                         <input type="password" class="form-control" name="newPass" id="recipient-name" placeholder="Contraseña nueva" required>
                     </div>
                     <div class="mb-3">
                         <label for="recipient-name" class="col-form-label">Confirmar contraseña:</label>
                         <input type="password" class="form-control" name="PassConfirm" id="recipient-name" placeholder="Confirmar contraseña" required>
                     </div>

                     <div class="modal-footer">
                         <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                         <button type="button" class="btn btn-primary">Actualizar</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>