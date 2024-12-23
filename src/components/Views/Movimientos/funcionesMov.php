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


function filtrarPorFecha($fechaMov) {
    $movimientos = getMovimientos(); 

    if (!$fechaMov) {
        return $movimientos;
    }

    return array_filter($movimientos, function($movimiento) use ($fechaMov) {
        return $movimiento['FechaMov'] === $fechaMov; 
    });
}

function filtrarPorAccion($accion) {
    $movimientos = getMovimientos(); 

    if (!$accion) {
      echo json_encode($movimientos);
        return $movimientos;
    }

    $movimientosFiltrados = array_filter($movimientos, function($movimiento) use ($accion) {
        return $movimiento['Accion'] === $accion; 
    });

    return $movimientosFiltrados;
}

function filtrarPorArticulo($articulo) {
  $movimientos = getMovimientos();

  if(!$articulo){
    return $movimientos;
  }

  $movimientosFiltrados = array_filter($movimientos, function($movimiento) use ($articulo) {
    return $movimiento['Articulo'] === $articulo;
  });
  // echo json_encode($movimientosFiltrados);
  return $movimientosFiltrados;
}


function getPaginatedMovimientos($page, $items_per_page, $movimientos, $fechaMov = null, $accion = null, $articulo=null) {

  if ($fechaMov) {
    $movimientos = filtrarPorFecha($fechaMov);
  }

  if ($accion) {
    $movimientos = filtrarPorAccion($accion,$movimientos);
  }
    if ($articulo) {
    $movimientos = filtrarPorArticulo($articulo,$movimientos);
  }

  $total_movements = count($movimientos);
  $total_pages = ceil($total_movements / $items_per_page);
  $current_page = min($page, $total_pages);

  $offset = ($current_page - 1) * $items_per_page;
  $paginated_movimientos = array_slice($movimientos, $offset, $items_per_page);

  return [
    'movimientos' => $paginated_movimientos,
    'total_pages' => $total_pages,
    'current_page' => $current_page
    ];
}

?>


