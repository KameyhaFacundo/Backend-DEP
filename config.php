<?php
define('BASE_URL', 'http://localhost/Backend-DEP/src/');
define('BASE_PATH', __DIR__);

// Enlaces relativos
define('MENU_URL', '../../common/Menu.php'); 
define('FOOTER_URL', BASE_PATH . '/src/components/common/footer.php');
define('FOOTER_CSS_URL', BASE_URL . 'components/common/footer.css');

// Variables de entorno para rutas
define('MOVIMIENTOS_URL', BASE_URL . 'components/Views/Movimientos/Movimiento.php');
define('CENTROS_URL', BASE_URL . 'components/Views/Centros/Centros.php');
define('STOCK_URL', BASE_URL . 'components/Views/Stock/Stock.php');
define('USUARIOS_URL', BASE_URL . 'components/Views/Usuarios/Usuarios.php');

// Función para cargar el archivo .env
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[$key] = trim($value);
        $_SERVER[$key] = trim($value);
    }
}

// Cargar variables de entorno
loadEnv(__DIR__ . '/.env');
?>