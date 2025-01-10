<?php
      require_once '../../../../config.php';
      //$ruta1 = BASE_URL.'styles';
      $ruta2= 'centros';
      //$rutaFooter="../../common/";
      require("../../common/header.php");
      require dirname(__DIR__, 2) . '/helpers/centros.php';
      require 'ItemCentro.php';
      require(MENU_URL);

      $centros = obtenerCentros();
      //var_dump($centros);
?>

<main class='mainSection'>
  
  <!-- {/* Tabla de centros */} -->
  <section class="centros-container">
    <section class="centros-header">
      <h2>Centro de Costos</h2>
    </section>
    
    <table class="table table-responsive table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th class="p-3">ID Centro</th>
          <th class="p-3">Nombre</th>
          <th class="p-3">Opciones</th>
        </tr>
      </thead>
      <tbody >
        <?php
          foreach ($centros as $centro) {
            echo ItemCertro($centro);
          }
        ?>
      </tbody>
    </table>
  </section>

</main>

<?php
  require_once  $rutaFooter."footer.php";
?>