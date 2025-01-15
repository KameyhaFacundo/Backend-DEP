<?php
  function getMovimientos() {
    $url = 'http://localhost/Backend-DEP/src/Backend/obtenerMovimientos.php'; 
    $response = file_get_contents($url); 

    if ($response === false) {
        return []; 
    }

    $data = json_decode($response, true);

    return isset($data['movimientos']) ? $data['movimientos'] : [];
  }


  function getArticulos() {
    $url = 'http://localhost/Backend-DEP/src/Backend/Movimiento.php';

    $response = file_get_contents($url);

    if ($response === false) {
        return []; 
    }

    $data = json_decode($response, true);

    return isset($data['articulos']) ? $data['articulos'] : [];
  }


  function getCentros() {
    $url = 'http://localhost/Backend-DEP/src/Backend/Movimiento.php';

    $response = file_get_contents($url);

    if ($response === false) {
        return []; 
    }

    $data = json_decode($response, true);

    return isset($data['centros']) ? $data['centros'] : [];
  }


  function getAcciones() {
    $url = 'http://localhost/Backend-DEP/src/Backend/Movimiento.php';

    $response = file_get_contents($url);
    
    if ($response === false) {
        return []; 
    }

    $data = json_decode($response, true);
    return isset($data['acciones']) ? $data['acciones'] : [];
  }

  function filtrarPorFecha($fechaMov, $movimientos) {
      if (!$fechaMov) {
          return $movimientos;
      }

      return array_filter($movimientos, function($movimiento) use ($fechaMov) {
          return $movimiento['FechaMov'] === $fechaMov; 
      });
  }

  function filtrarPorAccion($accion, $movimientos) {
      if (!$accion) {
          return $movimientos;
      }

      return array_filter($movimientos, function($movimiento) use ($accion) {
          return $movimiento['Accion'] === $accion; 
      });
  }

  function filtrarPorArticulo($articulo, $movimientos) {
      if (!$articulo) {
          return $movimientos;
      }

      return array_filter($movimientos, function($movimiento) use ($articulo) {
          return $movimiento['Articulo'] === $articulo;
      });
  }

  function getPaginatedMovimientos($page, $items_per_page, $movimientos, $fechaMov = null, $accion = null, $articulo = null) {
    $movimientosFiltrados = $movimientos;
    
    if ($fechaMov) {
      $movimientosFiltrados = filtrarPorFecha($fechaMov, $movimientosFiltrados);
    }

    if ($accion) {
      $movimientosFiltrados = filtrarPorAccion($accion, $movimientosFiltrados);
    }

    if ($articulo) {
      $movimientosFiltrados = filtrarPorArticulo($articulo, $movimientosFiltrados);
    }

    $total_movements = count($movimientosFiltrados);
    $total_pages = ceil($total_movements / $items_per_page);
    $current_page = min($page, $total_pages);

    $offset = ($current_page - 1) * $items_per_page;
    $paginated_movimientos = array_slice($movimientosFiltrados, $offset, $items_per_page);

    return [
      'movimientos' => $paginated_movimientos,
      'total_pages' => $total_pages,
      'current_page' => $current_page
    ];
  }
?>

