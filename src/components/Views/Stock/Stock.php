
<?php
      require_once '../../../../config.php';
      $ruta1 = BASE_URL.'styles';
      $ruta2= 'Stock';
      $rutaFooter="../../common/";
      require("../../common/header.php");
      require ("../../../Backend/obtenerStock.php");
      require ("funcionesStock.php");

      $Stock="#";
      require (MENU_URL);
?>
  <main class='mainSection'>
    
    <!-- {/* Tabla de productos */} -->
    <section class="productos-container">
      <section class="productos-header">
        <h2>Stock</h2>
        
        <!-- Boton para activar el modal para agregar articulo -->

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
    Agregar Artículo
    </button>
        <!-- Modal para agregar un articulo nuevo -->
        <?php

          require "agregarArticulo.php";

        ?>

    </section>

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
          foreach ($productos as $producto)
          {
            echo'<tr>
              <td>'.$producto["IdConcepto"].'</td>
              <td>'.$producto["Articulo"].'</td>
              <td>'.$producto["Rubro"].'</td>
              <td>'.$producto["ExistenciasTotales"].'</td>
              <td>'.calcularDisponible($producto,$movimientos).'</td>
            </tr>';
          }                  
          ?>
        </tbody>
      </table>
  </section>  
</main>



<?php

require_once  $rutaFooter."footer.php"
?>
