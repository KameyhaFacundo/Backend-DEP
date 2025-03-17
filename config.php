<?php
    define('BASE_URL', 'http://localhost/depStock/src/');
    define('BASE_PATH', __DIR__);
    //Enlaces relativos
    define('MENU_URL', '../../common/Menu.php');//URL relativo para el menú desde vistas
    define('FOOTER_URL', BASE_PATH.'/src/components/common/footer.php');
    define('FOOTER_CSS_URL', BASE_URL.'components/common/footer.css');
    $rutaCSS = BASE_URL.'components/Views/'.$ruta2.'/'.$ruta2.'.css';
    define('MOVIMIENTOS_URL', BASE_URL . 'components/Views/Movimientos/Movimiento.php');
    define('OFICINAS_URL', BASE_URL . 'components/Views/Centros/Centros.php');
    define('STOCK_URL', BASE_URL . 'components/Views/Stock/Stock.php');
    define('USUARIOS_URL', BASE_URL . 'components/Views/Usuarios/Usuarios.php');
    define('RUTA_CSS', $rutaCSS);

    function loadEnv($path) {
        if (!file_exists($path)) {
            return;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($key, $value) = explode('=', $line, 2);
            putenv("$key=$value");
        }
    }
    
    // Cargar variables de entorno
    loadEnv(__DIR__ . '/.env');
?>