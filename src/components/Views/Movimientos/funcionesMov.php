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

?>


