
<?php
      $ruta1 = '../../../styles';
      $ruta2= 'Stock';
      require_once("../../common/header.php");
      require ("../../../Backend/obtenerStock.php");
      require ("funcionesStock.php");

?>
  <main class='mainSection'>
    
    <!-- {/* Tabla de productos */} -->
    <section class="productos-container">
      <section class="productos-header">
        <h2>Productos Registrados</h2>
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
          // ?>
        </tbody>
      </table>
  </section>  
</main>



<?php
echo '
</body>
</html>
'
          ?>
