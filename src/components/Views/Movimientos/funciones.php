<?php
function getMovimientos() {
  $url = 'http://localhost/Backend-DEP/src/Backend/obtenerMovimientos.php'; // Asegúrate de que esta ruta sea correcta
  $response = file_get_contents($url); // Obtiene los datos del endpoint

  if ($response === false) {
      return []; // En caso de error, devuelve un array vacío
  }

  $data = json_decode($response, true); // Decodifica los datos JSON

  return isset($data['movimientos']) ? $data['movimientos'] : [];
}



function getArticulos() {
  $url = 'http://localhost/Backend-DEP/src/Backend/Movimiento.php'; // Asegúrate de que esta ruta sea correcta

  // Realiza la solicitud GET al endpoint
  $response = file_get_contents($url);

  // Verifica si hubo un error al obtener los datos
  if ($response === false) {
      return []; // Si hubo un error, devuelve un array vacío
  }

  // Decodifica la respuesta JSON
  $data = json_decode($response, true);

  // Devuelve los artículos si están disponibles, sino devuelve un array vacío
  return isset($data['articulos']) ? $data['articulos'] : [];
}

// Función para obtener los centros desde el archivo Movimiento.php
function getCentros() {
  $url = 'http://localhost/Backend-DEP/src/Backend/Movimiento.php'; // Asegúrate de que esta ruta sea correcta

  // Realiza la solicitud GET al endpoint
  $response = file_get_contents($url);

  // Verifica si hubo un error al obtener los datos
  if ($response === false) {
      return []; // Si hubo un error, devuelve un array vacío
  }

  // Decodifica la respuesta JSON
  $data = json_decode($response, true);

  // Devuelve los centros si están disponibles, sino devuelve un array vacío
  return isset($data['centros']) ? $data['centros'] : [];
}

// Función para obtener las acciones desde el archivo Movimiento.php
function getAcciones() {
  $url = 'http://localhost/Backend-DEP/src/Backend/Movimiento.php'; // Asegúrate de que esta ruta sea correcta

  // Realiza la solicitud GET al endpoint
  $response = file_get_contents($url);

  // Verifica si hubo un error al obtener los datos
  if ($response === false) {
      return []; // Si hubo un error, devuelve un array vacío
  }

  // Decodifica la respuesta JSON
  $data = json_decode($response, true);

  // Devuelve las acciones si están disponibles, sino devuelve un array vacío
  return isset($data['acciones']) ? $data['acciones'] : [];
}


?>
