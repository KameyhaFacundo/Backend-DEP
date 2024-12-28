
<?php
      require_once '../../../../config.php';
      $ruta1 = BASE_URL.'styles';
      $ruta2= 'Stock';
      $rutaFooter="../../common/";
      require("../../common/header.php");
      require ("../../../Backend/obtenerStock.php");
      require ("funcionesStock.php");
      require(MENU_URL);
      $usuarioPermitido = ($_SESSION['user']['rol'] == 'administrador' || $_SESSION['user']['rol'] == 'usuario');

?>
<main class='productos-container'>
  
  <!-- {/* Tabla de productos */} -->
    <section class="productos-header">
      <h2>Stock</h2>
      
      <!-- Boton para activar el modal para agregar articulo -->
      <?php
      if ($usuarioPermitido) {
        echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
        Agregar Artículo
        </button>';
      }
      ?>
    </section>

    <section clas="filter-container mb-3">
      <!-- Formulario de búsqueda de artículo -->
      <section class="row">
          <article class="col-sm-4 col-md-4 col-lg-4 mb-2">

            <form id="filterArticuloForm" method="GET" action="">
              <section class="form-row">
                <section class="col-8" >
                  <input
                    type="text"
                    id="articulo"
                    name="busqueda"
                    class="form-control"
                    placeholder="Buscar artículo..."
                    autocomplete="off"
                  />
                  <section id="articulos-results" class="list-group"></section>
                </section>
                <section class="col-4 d-flex align-items-center">
                  <button type="submit" id="btn-filtrar" class="btn btn-sm btn-primary">Filtrar</button>
                </section>
              </section>
            </form>

          </article>

        </section>
        <section table-responsive>
          <table class=" table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <th class="p-3">Código</th>
                <th class="p-3">Artículo</th>
                <th class="p-3">Rubro</th>
                <th class="p-3">Existencias Totales</th>
                <th class="p-3">Existencias Disponibles</th>
              </tr>
            </thead>
            <tbody >
          <?php 
            if(!empty($_GET['busqueda'])) {
              $busqueda=trim($_GET['busqueda']);
              $articulos=filtrarPorArticulo($stock,$busqueda);
            }
            else{
              $articulos=$stock;
            } 

                  
            // -----------------Paginación-------------------
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            
            $items_per_page = 10;

            $pagination = getPaginatedStock($page, $items_per_page, $articulos);

            $articulos = $pagination['cant_articulos'];
            $total_pages = $pagination['total_pages'];
            $current_page = $pagination['current_page'];

            // -----------------FIN Paginación-------------------

            $existenciasTotales=0;
            foreach ($articulos as $articulo)
            {
              $existenciasTotales=obtenerExistencias($articulo,$existencias);
              echo'<tr>
              <td>'.$articulo["IdConcepto"].'</td>
              <td>'.$articulo["Articulo"].'</td>
              <td>'.$articulo["Rubro"].'</td>
              <td>'.$existenciasTotales.'</td> 
              <td>'.calcularDisponible($articulo,$movimientos,$existenciasTotales).'</td>
              </tr>';
            }                  
          ?>
          </tbody>
        </table>
    </section>
           
    <!-- Paginado -->
    <?php if (is_array($articulos) && count($articulos) > 0): ?>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&fechaMov=<?= urlencode($_GET['fechaMov'] ?? '') ?>&accion=<?= urlencode($_GET['accion'] ?? '') ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&fechaMov=<?= urlencode($_GET['fechaMov'] ?? '') ?>&accion=<?= urlencode($_GET['accion'] ?? '') ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&fechaMov=<?= urlencode($_GET['fechaMov'] ?? '') ?>&accion=<?= urlencode($_GET['accion'] ?? '') ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
<!-- Incluyo modulo para el modal para agregar un articulo nuevo -->
  <?php
  require "agregarArticulo.php";
  ?>
</main>



<?php

require_once  $rutaFooter."footer.php"
?>
