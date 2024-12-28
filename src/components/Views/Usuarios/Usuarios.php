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
    <section class="row">
        <article class="col-sm-4 col-md-4 col-lg-4 mb-2">

          <form id="filterUsuarioForm" method="GET" action="">
            <section class="form-row">
              <section class="col-8" >
                <input
                  type="text"
                  id="buscar"
                  name="busqueda"
                  class="form-control"
                  placeholder="Buscar usuario..."
                  autocomplete="off"
                />
                <section id="usuarios-results" class="list-group"></section>
              </section>
              <section class="col-4 d-flex align-items-center">
                <button type="submit" id="btn-buscar" class="btn btn-sm btn-primary">Buscar</button>
              </section>
            </section>
          </form>

        </article>

      </section>
      <section table-responsive>
        <table class=" table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th class="p-3">IdUsuario</th>
              <th class="p-3">Nombre</th>
              <th class="p-3">Rol</th>
            </tr>
          </thead>
          <tbody >
        <?php 
          if(!empty($_GET['busqueda'])) {
            $busqueda=trim($_GET['busqueda']);
            $usuarios=filtrarPorUsuario($usuariosBD,$busqueda);
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
            <td>'.$usuario["IdUsuario"].'</td>
            <td>'.$usuario["Usuario"].'</td>
            <td>'.$usuario["Rol"].'</td>
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
?> 
</main>

<?php
        
require_once  $rutaFooter."footer.php"
?>
