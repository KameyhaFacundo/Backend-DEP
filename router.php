<?php
require_once 'config.php';

// Obtener la ruta solicitada
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$baseDir = 'http://localhost/Backend-DEP/'; // Ajusta esto según tu estructura
$request = str_replace($baseDir, '', $request);

// Mapa de rutas amigables a archivos reales
$routes = [
    'Stock' => 'components/Views/Stock/Stock.php',
    'Movimientos' => 'components/Views/Movimientos/Movimiento.php',
    'Centros' => 'components/Views/Centros/Centros.php',
    'Usuarios' => 'components/Views/Usuarios/Usuarios.php',
];

// Verificar si la ruta existe en el mapa
if (array_key_exists($request, $routes)) {
    require_once $routes[$request];
} else {
    // Página no encontrada
    http_response_code(404);
    echo "Página no encontrada.";
}



// // Base de las vistas
// $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $basePath = BASE_URL.'/components/Views/';
// $vista = isset($_GET['view']) ? $_GET['view'] : 'index';
// // $archivoVista = BASE_URL.'index.php';
// // Asignar archivo correspondiente
// switch ($vista) {
//     case 'movimientos':
//         $archivoVista = $basePath . 'Movimientos/Movimiento.php';
//         break;
//     case 'oficinas':
//         $archivoVista = $basePath . 'Centros/Centros.php';
//         break;
//     case 'stock':
//         $archivoVista = $basePath . 'Stock/Stock.php';
//         break;
//     case 'usuarios':
//         $archivoVista = $basePath . 'Usuarios/Usuarios.php';
//         break;

// }

// // Verificar existencia del archivo
// if (!file_exists($archivoVista)) {
//     http_response_code(404);
//     die('Página no encontrada.');
// }

// Incluir la vista correspondiente
// include $archivoVista;
?>
