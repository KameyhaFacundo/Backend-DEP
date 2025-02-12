
<?php
      //require_once '../../../../config.php';
      //$ruta1 = BASE_URL.'styles';
      $ruta2= 'Stock';
      // $rutaFooter= ;
      require("../../common/header.php");
      require (BASE_PATH."/src/Backend/obtenerStock.php");
      // require (BASE_URL.'Backend/excelStockInicial.php');
      require ("funcionesStock.php");
      require(MENU_URL);
      $usuarioPermitido = ($_SESSION['user']['rol'] == 'administrador' || $_SESSION['user']['rol'] == 'usuario');
      
?>
<main class='stock-container'>
  
  <!-- {/* Tabla de articulos */} -->
    <section class="stock-header">
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
      <section class="row" >
        <?php require "busquedas.php"; ?>
        <article class="col-sm-4 col-md-4 col-lg-4 mb-2 d-flex justify-content-end">
            <form method="POST" action="<?php echo BASE_URL?>Backend/exportarExcelStock.php">
              <button type="submit" class="btn btn-success">Descargar excel</button>
            </form>
        </article>
      </section>
 
        <section class="table-responsive">
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
            if(!empty($_GET['nombreFiltro'])) {
              $busqueda=trim($_GET['nombreFiltro']);
              $articulos=filtrarPorArticulo($stock,$busqueda);
              $articuloFiltrado = $busqueda;
            }
            elseif (!empty($_GET['rubroFiltro'])) {
              $busqueda=$_GET['rubroFiltro'];
              $articulos= filtrarPorRubro($stock,$busqueda);
              $rubroFiltrado = $busqueda;
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
          </tbody>
        </table>
    </section>
           
    <!-- Paginado -->
    <?php if (is_array($articulos) && count($articulos) > 0): ?>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center d-flex flex-wrap">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&rubroFiltrado=<?= urlencode($_GET['rubroFiltro'] ?? '') ?>&nombreFiltrado=<?= urlencode($_GET['nombreFiltro'] ?? '') ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php
      $visiblePages = 2; // Número de páginas a mostrar (sin contar la primera y la última)
      $halfVisible = floor($visiblePages / 2);

      // Mostrar la primera página
      ?>
      <li class="page-item <?= 1 == $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= 1 ?>&rubroFiltro=<?= urlencode($_GET['rubroFiltro'] ?? '') ?>&nombreFiltro=<?= urlencode($_GET['nombreFiltro'] ?? '') ?>">
          <?= 1 ?>
        </a>
      </li>
      <?php

      // Mostrar "..." si es necesario
      if ($total_pages > $visiblePages + 2 && $page > $halfVisible + 1) : ?>
        <li class="page-item disabled"> <span class="page-link">...</span></li>
      <?php endif;

      // Calcular el rango de páginas a mostrar
      $startPage = max(2, $page - $halfVisible);
      $endPage = min($total_pages - 1, $page + $halfVisible);

       if ($endPage - $startPage + 1 < $visiblePages) {
           if ($page <= $halfVisible + 1) {
               $endPage = min($total_pages - 1, $visiblePages + 1);
           } else {
               $startPage = max(2, $total_pages - $visiblePages -1);
           }
       }


      // Mostrar las páginas del rango
      for ($i = $startPage; $i <= $endPage; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>&rubroFiltro=<?= urlencode($_GET['rubroFiltro'] ?? '') ?>&nombreFiltro=<?= urlencode($_GET['nombreFiltro'] ?? '') ?>">
            <?= $i ?>
          </a>
        </li>
      <?php endfor; 

      // Mostrar "..." si es necesario
      if ($total_pages > $visiblePages + 2 && $page < $total_pages - $halfVisible - 1) : ?>
        <li class="page-item disabled"> <span class="page-link">...</span></li>
      <?php endif; 

      // Mostrar la última página
      ?>
      <li class="page-item <?= $total_pages == $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $total_pages ?>&rubroFiltro=<?= urlencode($_GET['rubroFiltro'] ?? '') ?>&nombreFiltro=<?= urlencode($_GET['nombreFiltro'] ?? '') ?>">
          <?= $total_pages ?>
        </a>
      </li>
            <?php if ($page < $total_pages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&rubroFiltrado=<?= urlencode($_GET['rubroFiltro'] ?? '') ?>&nombreFiltrado=<?= urlencode($_GET['nombreFiltro'] ?? '') ?>" aria-label="Next">
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

  include(FOOTER_URL);
?>
