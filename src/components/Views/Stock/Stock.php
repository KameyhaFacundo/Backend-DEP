
<?php
      require_once '../../../../config.php';
      $ruta1 = BASE_URL.'styles';
      $ruta2= 'Stock';
      $rutaFooter="../../common/";
      require("../../common/header.php");
      require ("../../../Backend/obtenerStock.php");
      // require (BASE_URL.'Backend/excelStockInicial.php');
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

    <!-- <section clas="filter-container mb-3"> -->
      <!-- Formulario de búsqueda de artículo -->
      <?php require "busquedas.php"; ?>
 
        <section table-responsive>
          <table class=" table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <th class="p-2">Código</th>
                <th class="p-2">Artículo</th>
                <th class="p-2">Rubro</th>
                <th class="p-2">Entradas</th>
                <th class="p-2">Salidas</th>
                <th class="p-2">Existencias Disponibles</th>
              </tr>
            </thead>
            <tbody >
          <?php 
            if(!empty($_GET['busqueda'])) {
              $busqueda=trim($_GET['busqueda']);
              $articulos=filtrarPorArticulo($stock,$busqueda);
            }
            elseif (!empty($_GET['rubroFiltro'])) {
              $busqueda=$_GET['rubroFiltro'];
              $articulos= filtrarPorRubro($stock,$busqueda);
              $rubroFiltrado = $busqueda;
              echo $rubroFiltrado;
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

            $entradas=0;
            foreach ($articulos as $articulo)
            {
              $entradas=obtenerEntradas($articulo,$existencias);
              $salidas=obtenerSalidas($articulo,$existencias);
              
              echo'<tr>
              <td class="p-2">'.$articulo["IdConcepto"].'</td>
              <td class="p-2">'.$articulo["Articulo"].'</td>
              <td class="p-2">'.$articulo["Rubro"].'</td>
              <td class="p-2">'.$entradas.'</td> 
              <td class="p-2">'.$salidas.'</td> 
              <td class="p-2">'.obtenerDisponible($salidas,$entradas).'</td>
              </tr>';
            }                  
            ?>
            <!-- <td class="p-2">'.calcularDisponible($articulo,$movimientos,$existenciasTotales).'</td> -->
          </tbody>
        </table>
    </section>
           
    <!-- Paginado -->
    <?php if (is_array($articulos) && count($articulos) > 0): ?>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&rubroFiltrado=<?= urlencode($_GET['rubroFiltro'] ?? '') ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&rubroFiltro=<?= urlencode($_GET['rubroFiltro'] ?? '') ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&rubroFiltrado=<?= urlencode($_GET['rubroFiltro'] ?? '') ?>" aria-label="Next">
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
