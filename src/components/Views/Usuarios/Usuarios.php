<?php
    require_once '../../../../config.php';
    $ruta1 = BASE_URL.'styles';
    $ruta2= 'Usuarios';
    $rutaFooter="../../common/";
    
    require("../../common/header.php");
    require ("../../../Backend/obtenerUsuarios.php");
    require ("funcionesUsuarios.php");
    require(MENU_URL);
    $usuarioPermitido = ($_SESSION['user']['rol'] == 'administrador' || $_SESSION['user']['rol'] == 'usuario');
    
    if (!$usuarioPermitido) {
        header('Location: ../Movimientos/Movimiento.php');
    }

    //Muestra de mensaje de error en caso que exista
    if(isset($_GET['error'])){
      echo '<div class="alert alert-danger" role="alert">'.htmlspecialchars($_GET['error']).'</div>';
    }
?>
<main class='usuarios-container'>
  
<!-- {/* Tabla de usuarios */} -->
  <section class="usuarios-header">
    <h2>Usuarios</h2>
    
    <!-- Boton para activar el modal para agregar articulo -->
    <?php
    if ($usuarioPermitido) {
      echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
      Agregar Usuario
      </button>';
    }
    ?>
  </section>

  <section clas="filter-container mb-3">
    <!-- Formulario de búsqueda de artículo -->
    <?php require 'busqueda.php'?>
    
    <!-- TABLA DE USUARIOS -->
      <section table-responsive>
        <table class=" table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th class="p-2">IdUsuario</th>
              <th class="p-2">Nombre</th>
              <th class="p-2">Rol</th>
              <th class="p-2">Modificar</th>
              <!-- <th class="p-3">Eliminar</th> -->
            </tr>
          </thead>
          <tbody >
        <?php 
          if(!empty($_GET['busqueda'])) {
            $busqueda=trim($_GET['busqueda']);
            $usuarios=filtrarPorUsuario($usuariosBD,$busqueda);
          }
          elseif (!empty($_GET['rolFiltro'])) {
            $busqueda=$_GET['rolFiltro'];
            $usuarios= filtrarPorRubro($usuariosBD,$busqueda);
            $rolFiltrado = $busqueda;
            // echo $rubroFiltrado;
          }
          else{
            $usuarios=$usuariosBD;
          } 

                
          // -----------------Paginación-------------------
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          
          $items_per_page = 10;

          $pagination = getPaginatedStock($page, $items_per_page, $usuarios);

          $usuarios = $pagination['cant_usuarios'];
          $total_pages = $pagination['total_pages'];
          $current_page = $pagination['current_page'];

          // -----------------FIN Paginación-------------------

          foreach ($usuarios as $usuario)
          {
            echo'<tr>
            <td class="py-2">'.$usuario["IdUsuario"].'</td>
            <td class="py-2">'.$usuario["Usuario"].'</td>
            <td class="py-2">'.$usuario["Rol"].'</td>
            <td class="py-2">
            <button 
                type="button" 
                class="btn btn-modificar"
                data-bs-toggle="modal" 
                data-bs-target="#modalModificar" 
                data-id="' . $usuario["IdUsuario"] . '" 
                data-usuario="' . $usuario["Usuario"] . '" 
                data-rol="' . $usuario["Rol"] . '
                data-password="' . $usuario["Password"] . '
              ">
                <i class="bi bi-pencil-square h-3"></i>
            </button>
            
            </tr>';
          }                  
        ?>
        </tbody>
      </table>
  </section>
         
  <!-- Paginado -->
  <?php if (is_array($usuarios) && count($usuarios) > 0): ?>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
          <?php if ($page > 1): ?>
              <li class="page-item">
                  <a class="page-link" href="?page=<?= $page - 1?>?>" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                  </a>
              </li>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                  <a class="page-link" href="?page=<?= $i?>?>">
                      <?= $i ?>
                  </a>
              </li>
          <?php endfor; ?>
          <?php if ($page < $total_pages): ?>
              <li class="page-item">
                  <a class="page-link" href="?page=<?= $page + 1 ?>?>" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
          <?php endif; ?>
      </ul>
    </nav>
  <?php endif; ?>


<!-- Incluyo modulo para el modal para agregar un articulo nuevo -->
 <?php
    require "agregarUsuario.php";
    require "modificarUsuario.php";
?> 
</main>

<!-- Script para llenar los campos del modal de modificar usuario: -->
  <script>
document.addEventListener("DOMContentLoaded", function () {
    const modalModificar = document.getElementById("modalModificar");

    modalModificar.addEventListener("show.bs.modal", function (event) {
        // Botón que activó el modal
        const button = event.relatedTarget;

        // Obtener datos del botón
        const idUsuario = button.getAttribute("data-id");
        const usuario = button.getAttribute("data-usuario");
        const rol = button.getAttribute("data-rol");

        // Asignar los datos a los campos del formulario
        modalModificar.querySelector("#idUsuario").value = idUsuario;
        modalModificar.querySelector("#usuario").value = usuario;
        modalModificar.querySelector("#rol").value = rol;
    });
});
</script>



<?php
        
require_once  $rutaFooter."footer.php"

?>
